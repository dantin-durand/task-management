<h1 align="center">🗒 Task Management</h1>

<p align="center">
<a href="https://img.shields.io/github/repo-size/dantin-durand/task-management"><img src="https://img.shields.io/github/repo-size/dantin-durand/task-management" alt="repo size"></a>
<a href="https://img.shields.io/github/last-commit/dantin-durand/task-management"><img src="https://img.shields.io/github/last-commit/dantin-durand/task-management" alt="GitHub last commit"></a>
<a href="https://img.shields.io/badge/php-%5E7.3-blue"><img src="https://img.shields.io/badge/php-%5E7.3-blue" alt="PHP version"></a>
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
