<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>
</p>

## Installment
1. Install php with version later than 7.4.0 (https://www.php.net/downloads) and [composer](https://getcomposer.org/)

2. Install and enable following plugin in **php**
    * mysql
    * xml
    * mbstring
    * curl
3. Upgrades your dependencies
    * `composer update`
4. Generate **app key** and **jwt key**
    * `php artisan key:gen`
    * `php artisan jwt:secret`
5. Set up database connection in **.env** file
6. Create migrate table and run migration with generated data
    * `php artisan migrate:install`
    * `php artisan migrate:fresh --seed`
7. Run
    * `php artisan serve`

## About project

This is part of my collage project to build ecommerce website, this project has 2
parts: [Front-end](https://gitlab.com/nconghau/e-tech) and Back-end (this repo)
You can use [this](https://www.getpostman.com/collections/5d7de1e9a0583c877605) postman collection to get data
