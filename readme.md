## Requirements
- Git
- PHP >= 5.6
- PHP extensions: php-xml, php-mbstring, php-mysql 
- Composer
- Redis
- MySQL DB

## App Installation
1) Be sure, that you have installed composer

2) Create App's directory:
- `mkdir /path/to/project`
- `cd /path/to/project`
- `git init`
- `git remote add {remote_repository_name} {remote_repository_link}`
- `git pull origin master`
     
3) Execute `composer update` and resolve conflicts, if they are taking place

4) Create MySQL DB with user for App, or use existing

5) Choose Redis DB to your App

6) Using .env.example file make your own .env file with actual settings

7) Execute `/path/to/php artisan migrate` command to create all required SQL-tables in Database

8) Use path `/register` at your browser to create a new user in your App

9) Add `* * * * * /path/to/php /path/to/project/artisan schedule:run >> /dev/null 2>&1` to your crontab using `crontab -e` to activate App's Scheduler

10) Login into App's interface and HANG OOOOOOOOOOONNNNN.....

P.S.: Take care about RWX problems ;-)


##ER-scheme
<p align="center">
  <img src="https://dmp2.c8.net.ua:85/img/DMPSeller.png">  
</p>





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
