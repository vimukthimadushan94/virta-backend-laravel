<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Overview

This repository contains a Laravel application configured to run with Docker using Laravel Sail.

## Prerequisites
Before you begin, ensure you have the following installed on your local machine:
  - Docker Desktop: Install Docker Desktop
  - Composer: Install Composer

## Getting Started
Clone this repository to your local machine:
```
git clone <repository_url>
```
Navigate into the project directory:
```
cd <project_directory>
```
Install dependencies:
```angular2html
composer install
```

Copy the .env.example file to .env:
```angular2html
cp .env.example .env
```

Generate an application key:
```angular2html
php artisan key:generate
```

### Running the Application
To start the application, you can use Laravel Sail, which orchestrates the Docker containers for you.

- Start the Docker containers:
```angular2html
sail up -d
```
- Access the application in your browser at http://localhost.

### Additional Commands
Here are some additional commands you have to execute to run application with data (with locations in Finland):
- Run database migrations:
```angular2html
sail artisan migrate
```

- Run database seeders.(Seeds Companies and Stations within the Finland region):
```angular2html
sail artisan db:seed
```

- Access the MySQL database:
```angular2html
sail mysql
```
