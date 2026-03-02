<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Сервис заметок (Notes Service)

Командный проект по разработке веб-приложения для создания и управления заметками.

## Описание проекта

**Сервис заметок** — это веб-приложение, разрабатываемое в рамках учебного курса. Цель проекта — создание полнофункционального приложения с использованием современного стека технологий и практик командной разработки, таких как Git Flow и код-ревью.

Приложение позволит пользователям:
*   Регистрироваться и авторизовываться.
*   Создавать, редактировать и удалять заметки.
*   Организовывать заметки по категориям или тегам.

## Участники команды

*   **Разработчик:** [Лозовой Николай](https://github.com/NeBaTL)
*   **Разработчик:** [Кузнецов Семён](https://github.com/Simens-code)
*   **Заказчик/Тимлид:** [Сальков Михаил](https://github.com/Laggon)

## Стек технологий

*   **Бэкенд:** PHP 8.3+, Laravel 12
*   **База данных:** MySQL
*   **Фронтенд:** Blade-шаблоны Laravel, Node.js, Vite
*   **Админ-панель:** Orchid Platform
*   **Тестирование:** PHPUnit / Laravel Dusk
*   **Система контроля версий:** Git, GitHub

## Правила работы с репозиторием

1.  **Ветки:** Запрещена прямая загрузка кода в ветку `main`. Все изменения должны разрабатываться в отдельных тематических ветках.
2.  **Pull Requests (PR):** Каждое изменение вносится через Pull Request с обязательным ревью от тимлида.

## Установка и запуск проекта

### Требования
- PHP >= 8.3
- Composer
- MySQL
- Node.js (v18+) и NPM

### Пошаговая установка

1. **Клонируйте репозиторий**
    ```bash
    git clone https://github.com/NeBaTL/NoteService.git
    cd NoteService
2. **Установите зависимости PHP**
    ```bash
    composer install
3. **Установите зависимости Node.js**
    ```bash
    npm install
4. **Настройте окружение**
    ```bash
    cp .env.example .env
    php artisan key:generate
    Настройте подключение к MySQL

5. **Откройте файл .env и укажите параметры вашей базы данных:**
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=notes_db
    DB_USERNAME=root
    DB_PASSWORD=
6. **Выполните миграции**
    ```bash
    php artisan migrate
7. **Установите Orchid (админ-панель)**
    ```bash
    php artisan orchid:install
    php artisan orchid:admin
8. **Соберите фронтенд**
    ```bash
    npm run build
9. **Запустите сервер**
    ```bash
    php artisan serve
10. **Откройте в браузере**

    Основной сайт: http://127.0.0.1:8000

    Админ-панель Orchid: http://127.0.0.1:8000/admin