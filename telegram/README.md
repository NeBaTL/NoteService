\# Модуль импорта из Telegram



Этот модуль позволяет подключаться к Telegram API и импортировать сообщения для последующего использования в сервисе заметок.



\## 📋 Требования



\- Python 3.8 или выше

\- pip (менеджер пакетов Python)

\- Аккаунт в Telegram

\- API ключи от Telegram (получить на https://my.telegram.org)



\## 🚀 Установка и настройка



\### 1. Установка зависимостей



```bash

\# Перейти в папку модуля

cd telegram



\# Установить необходимые пакеты

pip install -r requirements.txt



Получение API ключей Telegram

Перейдите на https://my.telegram.org



Войдите под своим аккаунтом Telegram



Перейдите в раздел "API Development Tools"



Создайте новое приложение (если нет)



Скопируйте api\_id и api\_hash



В файл .evn вставьте



после всего выполните тестовый скрипт python scripts/test\_connection.py

