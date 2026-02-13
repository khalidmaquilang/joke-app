# Specification
- Laravel 12
- PHP 8.4
- NPM 24

# Suggestion
- Install laravel herd (https://herd.laravel.com)

# Installation on local
- clone repository
- copy `.env.example` to `.env`
- run `composer i`
- run `php artisan key:generate`
- edit database connection inside `.env` 
- run `npm i`
- run `npm run build`
- run `php artisan migrate`
- run `php artisan serve` (only if you are not using herd)

# API Access
- After logging in
- Create your token at the Token Menu
- Use the token as a Bearer Token

``
GET /api/v1/jokes
``