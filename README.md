# GoodFood 2.0 - Retaurants Api

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=goodfood-cesi_api-restaurants&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=goodfood-cesi_api-restaurants)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=goodfood-cesi_api-restaurants&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=goodfood-cesi_api-restaurants)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=goodfood-cesi_api-restaurants&metric=bugs)](https://sonarcloud.io/summary/new_code?id=goodfood-cesi_api-restaurants)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=goodfood-cesi_api-restaurants&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=goodfood-cesi_api-restaurants)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=goodfood-cesi_api-restaurants&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=goodfood-cesi_api-restaurants)

API to manage restaurants, menus and products.

## Technologies
![PHP](https://img.shields.io/badge/-PHP-05122A?style=flat&logo=php&logoColor=777BB4)
![JWT](https://img.shields.io/badge/JWT-05122A?style=flat&logo=JSON%20web%20tokens)
![MySQL](https://img.shields.io/badge/-MySQL-05122A?style=flat&logo=mysql&logoColor=4479A1)
![Docker](https://img.shields.io/badge/docker-05122A.svg?style=flat&logo=docker&logoColor=white)
![Lumen](https://img.shields.io/badge/-Lumen-05122A?style=flat&logo=lumen&logoColor=FF2D20)

## Requierements:
MySQL Database

## Installation
Install dependencies:
```
composer install
```
Copy and complete .env file from .env.example:
```
cp .env .env.example
```

Generate JWT secret key:
```
php artisan jwt:secret
```
Copy and complete .env :
```
JWT_SECRET=<generated_key>
```
Run project:
```
php -S 0.0.0.0:8000 -t public
```

## Tests
Run tests:
```
./vendor/bin/phpunit
```
