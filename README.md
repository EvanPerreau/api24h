# P24H API

API backend for the P24H personal finance management application.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP 8.4+** with required extensions:
  - PDO
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
- **Composer 2.x**
- **Node.js 21+** and npm

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/EvanPerreau/P24H-API.git
cd P24H-API
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and modify it according to your local setup:

```bash
cp .env.example .env
```

Edit the `.env` file to configure your database connection:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=p24h
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Run database migrations

```bash
php artisan migrate
```

## Running the Application

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

### Frontend Assets

Compile frontend assets with Vite:

```bash
npm run dev
```

### All-in-one Development Environment

Laravel provides a convenient way to run all services at once:

```bash
composer dev
```

This will start:
- Laravel server
- Queue worker
- Log watcher
- Vite development server

## API Documentation

The API is documented using Swagger/OpenAPI. To view the documentation:

1. Generate the Swagger documentation:

```bash
php artisan l5-swagger:generate
```

2. Visit `http://localhost:8000/api/documentation` in your browser.

## Testing

Run the test suite with:

```bash
php artisan test
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.
