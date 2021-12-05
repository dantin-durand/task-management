<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 💡 About

this project is a task management system developed in laravel. It features unit tests, API documentation and a token system with JWT.

## ✅ Usage tips

It is strongly advised to run the project with PHP7 (^7.3). The jwt-auth library does not seem to currently properly support PHP8.

## 📌 Start Tests

1. Firstly, make sure to create an `.env.testing` file with the identifiers of the test DB.
1. Migrate the tables to the test DB `php artisan --env=testing migrate`
1. And finally, run the tests with this command `php artisan test --env=testing`

## 📖 Documentation

API documentation link is [here](https://dantin.stoplight.io/docs/task-api/).

## ⚙️ Production

The link of the API production is [here](https://laravel-task-api.herokuapp.com/api).
