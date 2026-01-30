# Laravel + React Blog Application

Современное веб-приложение блога с использованием Laravel (backend API) и React (frontend).

## 🚀 Быстрый старт

### Предварительные требования
- PHP 8.1+
- Composer
- Node.js 16+
- MySQL 8.0+ или SQLite
- Git

## 📁 Структура проекта
project/
├── src/ # Laravel backend
│ ├── app/
│ ├── bootstrap/
│ ├── config/
│ ├── database/
│ │ ├── migrations/
│ │ ├── seeders/
│ │ └── factories/
│ ├── public/
│ ├── resources/
│ ├── routes/
│ └── .env.example
│
└── blog-frontend/ # React frontend
├── src/
│ ├── components/
│ ├── services/
│ └── styles/
├── public/
└── package.json


# Выполнить все миграции в папке src
php artisan migrate

# Запустить все сидеры
php artisan db:seed


# Вернуться в корень проекта
cd ..

# Перейти в папку React
cd blog-frontend

# Установить зависимости Node.js
npm install

# Или если используете yarn
yarn install

# В терминале 1: Запуск Laravel сервера
cd src
php artisan serve
# Сервер доступен по: http://localhost:8000

# В терминале 2: Запуск React сервера
cd blog-frontend
npm start
# Или: yarn start
# Приложение доступно по: http://localhost:3000


Основные эндпоинты:
Статьи:
GET /api/articles - список всех статей

GET /api/articles/{id} - получить статью с комментариями

POST /api/articles - создать новую статью

Комментарии:
GET /api/articles/{id}/comments - комментарии статьи

POST /api/articles/{id}/comments - добавить комментарий
