import os
from pathlib import Path
from dotenv import load_dotenv

# Базовая директория проекта
BASE_DIR = Path(__file__).resolve().parent.parent

# Загружаем .env файл
load_dotenv(BASE_DIR / '.env')

class Config:
    # Telegram API credentials (получить на https://my.telegram.org)
    API_ID = int(os.getenv('TELEGRAM_API_ID', 0))
    API_HASH = os.getenv('TELEGRAM_API_HASH', '')
    PHONE = os.getenv('TELEGRAM_PHONE', '')
    
    # Пути для сессий и логов
    SESSION_DIR = BASE_DIR / 'sessions'
    LOG_DIR = BASE_DIR / 'logs'
    
    @classmethod
    def check(cls):
        """Проверка конфигурации"""
        if not cls.API_ID or not cls.API_HASH:
            print("❌ Ошибка: Не указаны TELEGRAM_API_ID или TELEGRAM_API_HASH")
            print("📝 Создайте файл .env в папке telegram/ и добавьте:")
            print("TELEGRAM_API_ID=ваш_id")
            print("TELEGRAM_API_HASH=ваш_hash")
            print("TELEGRAM_PHONE=+79001234567")
            return False
        return True
    
    @classmethod
    def create_dirs(cls):
        """Создание необходимых папок"""
        cls.SESSION_DIR.mkdir(exist_ok=True)
        cls.LOG_DIR.mkdir(exist_ok=True)

# Создаём папки при импорте
Config.create_dirs()