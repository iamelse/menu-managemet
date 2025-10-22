# 🍱 Menu Tree API - Laravel 12

A simple **Menu Tree Management API** built using **Laravel 12**, implementing:
- Repository & Service Pattern
- CRUD for hierarchical menus
- Request validation
- JSON Resource formatting
- SQLite database

## 🧠 Overview
Manages nested menus (tree structure).

## ⚙️ Tech Stack
Laravel 12, PHP 8.3+, SQLite

## 🚀 Installation
```bash
composer install
cp .env.example .env
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

## 🔗 API Endpoints
| Method | Endpoint | Description |
|---------|-----------|-------------|
| GET | /api/menus | Get all menus (tree) |
| POST | /api/menus | Create new menu |
| PUT | /api/menus/{id} | Update menu |
| DELETE | /api/menus/{id} | Delete menu |