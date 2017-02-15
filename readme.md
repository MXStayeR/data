## App Development Steps
1) Laravel Installation via Composer
composer global require "laravel/installer"
sudo ln -s $HOME/.composer/vendor/bin/laravel /usr/local/bin
laravel new <project_name>

OR

composer create-project laravel/laravel <project_name> 5.4.*

2) Create and configure Databases (MySQL + Redis)
3) Configurate: .env, config/app.php, config/database.php
4) Make Auth module:
php artisan make:auth   - Makes controllers and views for auth module
php artisan migrate     - Makes 1-st migration to create users, password_resets and migrations tables

5) composer require predis/predis - Include predis module to make models copies in Redis DB
6)   Installing an Twitter Bootstrap (only while development!!! all of packages will be installed from Git main Repo):
* composer require twbs/bootstrap - Include Bootstrap CSS/JS library
* add to composer.json at "post-update-cmd" next lines:
    "ln -sf vendor/twbs/bootstrap/dist/css/bootstrap.min.css public/css/",
    "ln -sf vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css public/css/",
    "ln -sf vendor/twbs/bootstrap/dist/js/bootstrap.min.js public/js/",
    "mkdir public/fonts",
    "cp -f vendor/twbs/bootstrap/dist/fonts/glyphicons-halflings-regular.woff2 public/fonts/",
    "cp -f vendor/twbs/bootstrap/dist/fonts/glyphicons-halflings-regular.woff public/fonts/",
    "cp -f vendor/twbs/bootstrap/dist/fonts/glyphicons-halflings-regular.ttf public/fonts/"
* composer update


## App Installation
1) Configure web-server
2) 

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>



## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
