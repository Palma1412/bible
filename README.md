## 🚀Запуск проекта
### Клонировать репозиторий
- git clone [repo-url]
- cd test

### Настроить окружение
- cp .env.example .env
- php artisan key:generate

### Настроить БД (данные ниже)
- php artisan migrate

### Получить данные с WB API
- php artisan wb:fetch --days=30

### Запустить сервер
- php artisan serve

## 🗃️Production БД развернута на Railway
- DB_CONNECTION=mysql
- DB_HOST=caboose.proxy.rlwy.net:57871
- DB_PORT=3306
- DB_DATABASE=railway
- DB_USERNAME=root
- DB_PASSWORD=yjKnHZhRetNcSNABheYlmEjGdEUPrCAZ

## Таблицы в БД
- sales - данные о продажах
- orders - данные о заказах
- stocks - данные о складах
- incomes - данные о доходах

## ⚙️Команды Artisan
- Получить данные с WB API за последние 7 дней - php artisan wb:fetch 
- Создать тестовые данные - php artisan wb:seed-test-data
- Очистить все данные - php artisan wb:clear

## 🔌Примеры API запросов
- sales = http://localhost:8000/api/sales?dateFrom=2025-11-20&dateTo=2025-11-21&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie
- orders = http://127.0.0.1:8000/api/orders?dateFrom=2023-11-01&dateTo=2025-11-21 &key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie
- stocks = http://127.0.0.1:8000/api/stocks?dateFrom=2022-11-01&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie
- incomes = http://127.0.0.1:8000/api/incomes?dateFrom=2023-11-01&dateTo=2025-11-21 &key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie
