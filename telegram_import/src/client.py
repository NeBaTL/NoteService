from telethon import TelegramClient
import os
from pathlib import Path
from dotenv import load_dotenv

env_path = Path(__file__).parent.parent / '.env'
load_dotenv(dotenv_path=env_path)

class TelegramClientWrapper:
    def __init__(self, session_name):
        self.session_name = session_name
        self.api_id = int(os.getenv('API_ID', 0))
        self.api_hash = os.getenv('API_HASH', '')
        self.phone = os.getenv('PHONE', '')
        self.client = None

    async def start(self):
        session_path = Path(__file__).parent.parent / 'sessions' / self.session_name
        self.client = TelegramClient(str(session_path), self.api_id, self.api_hash)
        await self.client.start(phone=self.phone)
        print("✓ Telegram client started")
        return self.client

    async def stop(self):
        if self.client:
            await self.client.disconnect()

    async def get_saved_messages(self, limit=None):
        if not self.client:
            await self.start()
        messages = []
        async for msg in self.client.iter_messages('me', limit=limit):
            messages.append(msg)
        return messages
