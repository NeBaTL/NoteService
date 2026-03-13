import asyncio
from telethon import TelegramClient
from telethon.errors import SessionPasswordNeededError
from pathlib import Path
from .config import Config

class TelegramClientWrapper:
    """Простой клиент для работы с Telegram"""
    
    def __init__(self, session_name='telegram_session'):
        self.session_name = session_name
        self.session_path = Config.SESSION_DIR / session_name
        self.client = None
        self.is_connected = False
        
    async def connect(self):
        """Подключение к Telegram"""
        if not Config.check():
            return False
        
        print("🔄 Подключение к Telegram...")
        
        # Создаём клиента
        self.client = TelegramClient(
            str(self.session_path),
            Config.API_ID,
            Config.API_HASH
        )
        
        await self.client.connect()
        
        # Проверка авторизации
        if not await self.client.is_user_authorized():
            await self._authorize()
        
        self.is_connected = True
        me = await self.client.get_me()
        print(f"✅ Подключено! Аккаунт: {me.first_name} (@{me.username})")
        return True
    
    async def _authorize(self):
        """Авторизация (при первом запуске)"""
        phone = Config.PHONE
        
        if not phone:
            phone = input("📱 Введите номер телефона (+79001234567): ")
        
        # Отправляем код
        await self.client.send_code_request(phone)
        code = input("🔢 Введите код из Telegram: ")
        
        try:
            await self.client.sign_in(phone, code)
        except SessionPasswordNeededError:
            # Если включена двухфакторка
            password = input("🔐 Введите пароль двухфакторной аутентификации: ")
            await self.client.sign_in(password=password)
    
    async def disconnect(self):
        """Отключение"""
        if self.client and self.is_connected:
            await self.client.disconnect()
            self.is_connected = False
            print("🔌 Отключено от Telegram")
    
    async def get_me(self):
        """Получить информацию о себе"""
        if not self.is_connected:
            await self.connect()
        return await self.client.get_me()
    
    async def get_dialogs(self, limit=10):
        """Получить список последних диалогов"""
        if not self.is_connected:
            await self.connect()
        
        dialogs = []
        async for dialog in self.client.iter_dialogs(limit=limit):
            dialogs.append({
                'id': dialog.id,
                'name': dialog.name,
                'unread': dialog.unread_count,
                'type': 'чат' if dialog.is_group else 'канал' if dialog.is_channel else 'личный'
            })
        return dialogs