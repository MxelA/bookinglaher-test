[//]: # (<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>)

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requirements

- PHP 8.2
- [Composer](https://getcomposer.org/download)
- [Git](https://git-scm.com/downloads)
- [Cocker](https://www.docker.com/products/docker-desktop/)


# BookingLayer Test App
The task of the test is to correctly calculate room occupancy rates. Occupancy rates represent
the number of occupied versus vacant rooms. We need occupancy rates for a single day vs
multiple room ids and for a single month vs multiple room ids (so queries are not always against
all rooms).

## Setup notes

- Clone master branch to your local environment
- Copy .env.example to .env
- Run: composer install
- Run: vendor/bin/sail up -d

- Run: vendor/bin/sail php artisan migrate
- Run: vendor/bin/sail php artisan db:seed

## Setup/Run App Tests

- Create `testing` database
- Run: vendor/bin/sail php artisan test
