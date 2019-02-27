# ShiftManager

Web application to manage shifts and tasks.

Built with PHP and Laravel.

## Requirements

- PHP 7
- [Laravel](https://laravel.com/) 5.6
- [Node.js](https://nodejs.org/en/) and [npm](https://www.npmjs.com/)
- [Webpack](https://webpack.js.org/) with [Laravel Mix](https://laravel.com/docs/5.6/mix)

## Installation

Clone Project

```sh
git clone https://github.com/taiyeoguns/shiftmgr-laravel.git shiftmgr-laravel
```

Install Composer dependencies

```sh
cd shiftmgr-laravel
composer install
```

Install and run tasks for Frontend dependencies

```sh
npm install && npm run dev
```

Maintain database details in `.env` file

```sh
cp .env.example .env
```

Migrate database tables

```sh
php artisan migrate
```

Generate app key and start server

```sh
php artisan key:generate && php artisan serve
```

Launch browser

Navigate to `http://localhost:8000`

## Tests

In command prompt, run:

```sh
vendor\bin\phpunit --testdox
```
