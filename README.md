# ![Dampetra API](https://laravel.com/img/logomark.min.svg) Dampetra API

> ### Dampetra is a robust backend solution designed for couple tracking applications. This API facilitates real-time data synchronization, secure activity logging, and seamless interaction management to help partners stay connected and maintain transparency in their digital relationship.

This repo is under development!

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/13.x/installation)

Clone the repository

    git clone git@github.com:luqmanulhakiem/dampetra-api-laravel.git

Switch to the repo folder

    cd dampetra-api-laravel

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate:fresh --seed

Generate a new jwt key

    php artisan jwt:secret

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## API Specification

This application adheres to the api specifications set by the [Luqmanul Hakiem](https://github.com/luqmanulhakiem). This helps mix and match any backend with any other frontend without conflicts.

> [Full API Spec](https://github.com/#) -- Under Develop

More information regarding the project can be found here https://github.com/luqmanulhakiem/dampetra-api-laravel

----------

# Code overview

## Dependencies

- [Haruncpi/Laravel-id-Generator](https://github.com/haruncpi/laravel-id-generator) - For Generate Unix Id on Users
- [Swagger](https://github.com/darkaonline/l5-swagger) - For API Test & Documentation
- [JWT - JSON Web Token](https://github.com/tymondesigns/jwt-auth?tab=readme-ov-file) - For Authentication Token

## Folders

- `app/Models` - Contains all the Models
- `app/Http/Controllers/API` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/API` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeders` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------