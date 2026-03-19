from pathlib import Path


class Config:
    # Базовая директория
    BASE_DIR = Path(__file__).parent.parent
    
    # Директория для экспорта
    EXPORT_DIR = BASE_DIR / "exports"
    
    # Директория для сессий
    SESSIONS_DIR = BASE_DIR / "sessions"