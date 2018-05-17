# API Rest Tasks todo

This API was created in order to further study the API concept with TOKEN access using the [Laravel] framework (https://laravel.com/). In this API we discarded the use of views, since the intention was only to do CRUD without an interface, but through POSTMAN or SWAGGER.

# What is necessary ?
- PHP> = 7.1
- MySQL
- Composer

# Observations for project operation
> 1 - Make the clone for your computer.

> 2 - Create a local database with any name. I suggest putting `laravel-todo`

> 3 - Change .env.example to .env and change the database settings. Ex: 
 - DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel-todo
   DB_USERNAME=root
   DB_PASSWORD=root

> 4 - You may have to generate the app key with `php artisan key:generate`

> 5 - Enjoy and acquire the dependencies of the project with `composer update`

> 6 - Changed .env open terminal in project folder and run migrations with `php artisan migrate`

> 7 - You may have to generate the clients for JWT authentication with `php artisan passport:install`

> 7 - To run the project just run `php artisan serve` that by default to access the application just access localhost:8000
 - To access the SWAGGER documentation, just use `localhost:8000/api/documentation`
 
 - Some routes are configured to be accessed only if logged in ... Consider this as a bonus. To login first log in or log in and use swagger's token login ... If you are using postman, just go through the request header with the following:
   Authorization: Bearer token
   
# Why I use Laravel ?

> 1 - Easy to get started
 - Okay!! Read the title again, First reason why people starts with laravel is, It’s easy to get started. Even if you’re aware of just basics of PHP, You can easily develop 5 page site in just few hours. Still it’s not the only reason why you should choose laravel. There’s much more.
 
> 2 - Follows MVC
 - In development, Transparency between business logic & presentation is important. Laravel is based on MVC Architecture. It has plenty of built-in-functions, MVC increases performance & provides better documentation.
 
> 3 - Secure
 - Laravel provides you some of the essential things which makes your application secure. Laravel’s ORM uses PDO, which prevents SQL injections. Laravel’s csrf protection prevents cross site request forgery. It’s syntax automatically escapes any html entities being passed via view parameters, which prevents cross site scripting. All you have to do is, using the proper components of the framework.
 
> 4 - Migrations database
 - Migration is one of the key features provided by laravel. Migration allows you to maintain database structure of application without re-creating it. Instead of using SQL, migration allows you to write php code to control Database. Migrations allows you to rollback most recent changes you made to Database.
 
> 5 - Unit tests
 - Testing is important thing for any application before it’s available for end users. Laravel provides facility for Unit Testing. Sometimes new changes can break systems unexpectedly. Laravel runs many tests to ensure stability of application.
 
 # Print of routes in SWAGGER
  - Remember that you don't need to use postman to test the routes, just use the SWAGGER.
  ![image](https://user-images.githubusercontent.com/14933271/40180439-35dbb614-59bd-11e8-8fc7-d120e05ad67f.png)