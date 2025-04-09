# PHP Coding Challenge — Laravel + Doctrine

This Laravel project imports Australian customers from the [Random User API](https://randomuser.me/) and stores them using **Doctrine ORM**. It exposes a RESTful API for fetching customer data and includes a reusable service layer.

> Repository: [https://github.com/kikz4life/php-coding-challenge](https://github.com/kikz4life/php-coding-challenge)

---

## 📦 Tech Stack

- Laravel 10.x
- Doctrine ORM (via `laravel-doctrine/orm`)
- PHP 8.1+
- MySQL / PostgreSQL / SQLite
- RESTful API
- Artisan Console Commands
- Service Providers & Custom Services

---

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/kikz4life/php-coding-challenge.git
cd php-coding-challenge

# Install dependencies
composer install

# Copy and configure environment
cp .env.example .env

# Generate Laravel app key
php artisan key:generate
```

## 🛠 Create the Database Schema

```bash
# Doctrine does not use Laravel's migration system.
# To create the schema:
php artisan doctrine:schema:create

# To update the schema later:
php artisan doctrine:schema:update --force
```

## 🚀 Import Customers
```bash
# Run this command to import 100 Australian customers:
php artisan customers:import
```

## 📡 API Endpoints

- GET	/api/customers	Returns a list of all customers
- GET	/api/customers/{id}	Returns detailed info of a customer

## 🧪 Run Tests
```bash
php artisan test
```
