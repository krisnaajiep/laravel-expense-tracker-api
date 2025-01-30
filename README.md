# Laravel Expense Tracker API

> Expense Tracker RESTful API built with Laravel 11.

## Table of Contents

- [General Info](#general-information)
- [Technologies Used](#technologies-used)
- [Features](#features)
- [Setup](#setup)
- [Usage](#usage)
- [Authentication](#authentication)
- [HTTP Response Codes](#http-response-codes)
- [Project Status](#project-status)
- [Acknowledgements](#acknowledgements)

## General Information

Laravel Expense Tracker API is a simple RESTful API that allow users to create, read, update, and delete expenses. It supports categorization and filtering by amount, date, and creation time. The API uses [JWT](https://jwt.io/) for authentication powered by [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth). This project is designed to explore and practice working with the CRUD Operation, RESTful API, Data Modeling, and User Authentication in PHP.

## Technologies Used

- PHP - version 8.4.1
- MySQL - version 8.0.4
- [Laravel](https://www.laravel.com/) 11

## Features

- **User registration**: Register a new user using the `POST` method.
- **User login**: Authenticate the user using the `POST` method.
- **Create a new expense**: Create a new expense using the `POST` method.
- **Update an existing expense**: Update an existing expense using the `PUT` method.
- **Delete an existing expense**: Delete an existing expense using the `DELETE` method.
- **List all past expenses**: Get the list of to-do items with pagination using the `GET` method.
- **Filter past expenses**: Get the list of past expenses by category or by specific date range using the `start_date` and `end_date` query params.

## Setup

To run this CLI tool, you’ll need:

- **PHP**: Version 8.4 or newer
- **MySQL**: Version 8.0 or newer
- **Composer**: Version 2.7 or newer

How to install:

1. Clone the repository

   ```bash
   git clone https://github.com/krisnaajiep/laravel-expense-tracker-api.git
   ```

2. Change the current working directory

   ```bash
   cd laravel-expense-tracker-api
   ```

3. Install dependecies

   ```bash
   composer install
   ```

4. Configure `.env` file for configuration.

   ```bash
   cp .env.example .env
   ```

5. Generate application key

   ```bash
   php artisan key:generate
   ```
   
6. Generate JWT secret key

   ```bash
   php artisan jwt:secret
   ```

7. [Start MySQL server](https://phoenixnap.com/kb/start-mysql-server)
   
8. Run the database migration

   ```bash
   php artisan migrate
   ```

9. Run the local server

   ```bash
   php artisan serve
   ```

## Usage

Example API Endpoints:

1. **User Registration**

   - Method: `POST`
   - Endpoint: `/api/register`
   - Request Body:

     - `name` (string) - The name of the user.
     - `email` (string) - The email address of the user.
     - `password` (string) - The password of the user account.

   - Example Request:

     ```http
     POST /api/register
     {
       "name": "John Doe",
       "email": "john@doe.com",
       "password": "example_password",
     }
     ```

   - Response:

     - Status: `201 Created`
     - Content-Type: `application/json`

   - Example Response:

     ```json
     {
       "message": "User register successfully",
       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
       "token_type": "Bearer",
       "expires_in": 3600
     }
     ```

2. **User Login**

   - Method: `POST`
   - Endpoint: `/api/login`
   - Request Body:

     - `email` (string) - The email address of the user.
     - `password` (string) - The password of the user account.

   - Example Request:

     ```http
     POST /api/login
     {
       "email": "john@doe.com",
       "password": "example_password",
     }
     ```

   - Response:

     - Status: `200 OK`
     - Content-Type: `application/json`

   - Example Response:

     ```json
     {
       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
       "token_type": "Bearer",
       "expires_in": 3600
     }
     ```

4. **Create a new expense**

   - Method: `POST`
   - Endpoint: `/api/expenses`
   - Request Header:

     - `Authorization` (Bearer) - The access token.
       
   - Request Body:

     - `amount` (string) - The amount of the expense.
     - `category` (string) - The category of the expense.
     - `description` (string) - The description of the expense.
     - `date_time` (string) - The date of the expense

   - Example Request:

     ```http
     POST /api/expenses
     {
       "amount": 50,
       "category": "Groceries",
       "description": "Buy milk, eggs, and bread",
       "date_time": "2025-01-30"
     }
     ```

   - Response:

     - Status: `201 Created`
     - Content-Type: `application/json`

   - Example Response:

     ```json
     {
       "message": "Data stored successfully",
       "data": {
           "amount": 50,
           "category": "Groceries",
           "description": "Buy milk, eggs, and bread",
           "date_time": "2025-01-30",
           "user_id": 1,
           "updated_at": "2025-01-30T15:46:34.000000Z",
           "created_at": "2025-01-30T15:46:34.000000Z",
           "id": 2
       }
     }
     ```

5. **Update an existing expense**

   - Method: `PUT`
   - Endpoint: `api/expenses/{id}`
   - Request Header:

     - `Authorization` (Bearer) - The access token.
       
   - Request Body:

     - `amount` (string) - The amount of the expense.
     - `category` (string) - The category of the expense.
     - `description` (string) - The description of the expense.
     - `date_time` (string) - The date of the expense

   - Example Request:

     ```http
     POST /api/expenses/30
     {
       "amount": 10,
       "category": "Groceries",
       "description": "Buy milk, eggs, and bread, and cheese",
       "date_time": "2025-01-30"
     }
     ```

   - Response:

     - Status: `200 OK`
     - Content-Type: `application/json`

   - Example Response:

     ```json
     {
       "message": "Data updated successfully",
       "data": {
           "id": 2,
           "user_id": 1,
           "amount": "10.00",
           "category": "Groceries",
           "description": "Buy milk, eggs, and bread, and cheese",
           "date_time": "2025-01-30 00:00:00",
           "created_at": "2025-01-30T15:46:34.000000Z",
           "updated_at": "2025-01-30T15:48:57.000000Z"
       }
     }
     ```

6. **Delete an existing expense**

   - Method: `DELETE`
   - Endpoint: `/api/expenses/{id}`
   - Request Header:

     - `Authorization` (Bearer) - The access token.
       
   - Response:

     - Status: `204 No Content`
     - Content-Type: `text/xml`

7. **List and filter all past expenses**

   - Method: `GET`
   - Endpoint: `/api/expenses`
   - Request Header:
  
     - `Authorization` (Bearer) - The access token.

   - Response:

     - Status: `200 OK`
     - Content-Type: `application/json`

   - Example Response:

     ```json
     {
        "total_amount": "40.00",
        "expenses": {
            "current_page": 1,
            "data": [
                {
                    "id": 2,
                    "user_id": 1,
                    "amount": "10.00",
                    "category": "Groceries",
                    "description": "Buy milk, eggs, and bread",
                    "date_time": "2025-01-30 00:00:00",
                    "created_at": "2025-01-30T16:10:30.000000Z",
                    "updated_at": "2025-01-30T16:10:30.000000Z"
                },
                {
                    "id": 1,
                    "user_id": 1,
                    "amount": "30.00",
                    "category": "Bills",
                    "description": "Pay electricity and water bills",
                    "date_time": "2025-01-29 00:00:00",
                    "created_at": "2025-01-30T16:10:02.000000Z",
                    "updated_at": "2025-01-30T16:10:02.000000Z"
                }
            ],
            "first_page_url": "http://localhost:8000/api/expenses?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost:8000/api/expenses?page=1",
            "links": [
                {
                    "url": null,
                    "label": "&laquo; Previous",
                    "active": false
                },
                {
                    "url": "http://localhost:8000/api/expenses?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "Next &raquo;",
                    "active": false
                }
            ],
            "next_page_url": null,
            "path": "http://localhost:8000/api/expenses",
            "per_page": 10,
            "prev_page_url": null,
            "to": 2,
            "total": 2
        }
     }
     ```

     - Params:

       - `category` - Used for filtering expenses based on their category.
       - `start_date` - Used for filtering expenses based on start date (Options: `past_week`, `last_month`, `last_3_months`, custom date).
       - `end_date` - Used for filtering expenses based on end date (Options: custom date).


## Authentication

This API uses Bearer Token for authentication. You can generate an access token by registering a new user or login.

You must include an access token in each request to the API with the Authorization request header.

### Authentication error response

If an API key is missing, malformed, or invalid, you will receive an HTTP 401 Unauthorized response code.

## HTTP Response Codes

The following status codes are returned by the API depending on the success or failure of the request.

| Status Code               | Description                                                                                  |
| ------------------------- | -------------------------------------------------------------------------------------------- |
| 200 OK                    | The request was processed successfully.                                                      |
| 201 Created               | The new resource was created successfully.                                                   |
| 401 Unauthorized          | Authentication is required or the access token is invalid.                                   |
| 403 Forbidden             | Access to the requested resource is forbidden.                                               |
| 404 Not Found             | The requested resource was not found.                                                        |
| 422 Unprocessable Content | The server understands the request, but cannot process it due to a validation error          |
| 500 Internal Server Error | An unexpected server error occurred.                                                         |

## Project Status

Project is: _complete_.

## Acknowledgements

This project was inspired by [roadmap.sh](https://roadmap.sh/projects/expense-tracker-api).


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
