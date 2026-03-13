#!/usr/bin/env python
"""
Тестовый скрипт для проверки подключения к Telegram
"""

import asyncio
import sys
from pathlib import Path

# Добавляем путь к src
sys.path.append(str(Path(__file__).parent.parent))

from src.client import TelegramClientWrapper
from src.config import Config

async def test_connection():
    """Тест подключения к Telegram"""
    print("=" * 50)
    print("🔍 ТЕСТ ПОДКЛЮЧЕНИЯ К TELEGRAM")
    print("=" * 50)
    
    # Проверяем конфигурацию
    if not Config.check():
        return
    
    # Создаём клиента
    client = TelegramClientWrapper('test_session')
    
    try:
        # Подключаемся
        success = await client.connect()
        
        if success:
            # Получаем информацию о себе
            me = await client.get_me()
            print("\n📊 Информация об аккаунте:")
            print(f"   Имя: {me.first_name}")
            print(f"   Username: @{me.username}")
            print(f"   ID: {me.id}")
            print(f"   Телефон: {me.phone}")
            
            # Получаем последние диалоги
            print("\n📱 Последние диалоги:")
            dialogs = await client.get_dialogs(5)
            for i, dialog in enumerate(dialogs, 1):
                print(f"   {i}. {dialog['name']} ({dialog['type']}) - {dialog['unread']} непрочитанных")
            
            print("\n✅ Тест подключения пройден успешно!")
            
    except Exception as e:
        print(f"\n❌ Ошибка: {e}")
    
    finally:
        # Отключаемся
        await client.disconnect()
    
    print("=" * 50)

if __name__ == "__main__":
    asyncio.run(test_connection())