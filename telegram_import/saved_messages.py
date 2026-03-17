#!/usr/bin/env python
import asyncio
import json
import sys
import os
import requests
from pathlib import Path
from datetime import datetime
import argparse

sys.path.append(str(Path(__file__).parent))

from src.client import TelegramClientWrapper

class SavedMessagesToLaravel:
    def __init__(self, output_dir=None, laravel_url=None):
        self.client = TelegramClientWrapper("saved_messages_session")
        self.output_dir = Path(output_dir) if output_dir else Path("exports")
        self.output_dir.mkdir(exist_ok=True)
        self.laravel_url = laravel_url or os.getenv('LARAVEL_URL', 'http://localhost:8000')
        self.stats = {'total': 0, 'sent': 0, 'failed': 0}

    async def fetch_and_send(self, limit=None):
        try:
            await self.client.start()
            print(f"✅ Подключено к Telegram")
            print(f"📤 URL Laravel: {self.laravel_url}")
            
            # Проверка Laravel API
            try:
                test_url = f"{self.laravel_url}/api/test"
                print(f"🔍 Проверка API: {test_url}")
                test_response = requests.get(test_url, timeout=5)
                print(f"✅ API доступен: {test_response.status_code}")
                print(f"📥 Ответ: {test_response.text}")
            except Exception as e:
                print(f"❌ API недоступен: {e}")
                return self.stats
            
            messages = await self.client.get_saved_messages(limit=limit)
            print(f"📨 Получено {len(messages)} сообщений")
            
            for i, msg in enumerate(messages, 1):
                try:
                    print(f"\n📝 [{i}] Сообщение ID: {msg.id}")
                    print(f"   Дата: {msg.date}")
                    print(f"   Текст: {msg.text[:50] if msg.text else 'Нет текста'}...")
                    
                    # Отправка в Laravel
                    success = await self._send_to_laravel(msg)
                    
                    if success:
                        self.stats['sent'] += 1
                        print(f"  ✅ Успешно отправлено")
                    else:
                        self.stats['failed'] += 1
                        print(f"  ❌ Ошибка отправки")
                        
                except Exception as e:
                    print(f"  ❌ Ошибка: {e}")
                    self.stats['failed'] += 1
                    
                self.stats['total'] += 1
                
        except Exception as e:
            print(f"❌ Общая ошибка: {e}")
        finally:
            await self.client.stop()
        
        return self.stats

    async def _send_to_laravel(self, message):
        """Отправка одного сообщения в Laravel"""
        url = f"{self.laravel_url}/api/telegram/messages"
        
        data = {
            'telegram_message_id': message.id,
            'date': int(message.date.timestamp()),
            'text': message.text or '',
            'media': bool(message.media),
            'out': bool(message.out),
            'mentioned': bool(message.mentioned),
        }
        
        # Добавляем дополнительные поля, если есть
        if hasattr(message, 'views') and message.views:
            data['views'] = message.views
        if hasattr(message, 'forwards') and message.forwards:
            data['forwards'] = message.forwards
            
        print(f"  📤 URL: {url}")
        print(f"  📤 Данные: {json.dumps(data, ensure_ascii=False, indent=2)}")
        
        try:
            response = requests.post(
                url,
                json=data,
                timeout=10,
                headers={
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'User-Agent': 'Telegram-Import/1.0'
                }
            )
            
            print(f"  📥 Статус: {response.status_code}")
            print(f"  📥 Ответ: {response.text[:200]}")
            
            return response.status_code in [200, 201]
            
        except requests.exceptions.ConnectionError:
            print(f"  ❌ Ошибка подключения к {url}")
            return False
        except Exception as e:
            print(f"  ❌ Ошибка: {e}")
            return False

async def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("--limit", type=int, default=5, help="Количество сообщений")
    parser.add_argument("--laravel-url", default="http://127.0.0.1:8000", help="URL Laravel")
    args = parser.parse_args()
    
    print("🚀 Запуск импорта из Telegram в Laravel")
    print(f"📊 Лимит: {args.limit}")
    print(f"🌐 Laravel: {args.laravel_url}")
    
    importer = SavedMessagesToLaravel(laravel_url=args.laravel_url)
    stats = await importer.fetch_and_send(limit=args.limit)
    
    print("\n" + "="*50)
    print("📊 ИТОГОВАЯ СТАТИСТИКА")
    print("="*50)
    print(f"📨 Всего обработано: {stats['total']}")
    print(f"✅ Отправлено в Laravel: {stats['sent']}")
    print(f"❌ Ошибок: {stats['failed']}")
    print("="*50)

if __name__ == "__main__":
    asyncio.run(main())
