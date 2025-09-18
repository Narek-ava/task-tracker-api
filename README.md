# 📌 Task Tracker API

API для управления задачами команды разработчиков.  
Проект построен на **Laravel 12 + PHP 8.2 + MySQL**, с поддержкой **Swagger** для удобного просмотра и тестирования API.

---

## 🚀 Технологии

- **PHP**: 8.2.28
- **Laravel**: 12
- **MySQL**: 8.x
- **Node.js**: v20.12.2
- **NPM**: 10.x
- **Composer**: 2.x

---

[Открыть API-документацию](http://5.129.193.253:8000/api/documentation)

[![Swagger](https://img.shields.io/badge/docs-swagger-blue)](http://5.129.193.253:8000/api/documentation)


## ⚙️ Установка и запуск

   ```bash
   git clone https://github.com/your-repo/task-tracker-api.git
   
   cd task-tracker-api
   
   composer install
   
   npm install
   
   cp .env.example .env
   
   php artisan key:generate

   php artisan migrate --seed

   php artisan serve
