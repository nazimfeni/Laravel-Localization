## Setup Laravel

```
composer create-project laravel/laravel laravel-Localization
cd laravel-Localization
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
php artisan serve
php artisan lang:publish
```

ref: https://www.youtube.com/watch?v=vpmVE1hOBow&t=26s
