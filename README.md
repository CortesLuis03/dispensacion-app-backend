## About Project

This Backend project allows you to store, consult and delete records of the bills module of a dispensation app.

## Requirements

 - php 8+
 - composer
 - mysql

If you want, install xampp control center to manage apache, php and mysql services

## Installation

1. Run ```composer install``` to install dependencies.

2. Copy the ```.env.example``` file and create a new file called ```.env```.

3. In the ```.env``` file, change the name of the database, user, password and port.

4. Run the ```php artisan migrate``` command to create the tables and database required by the application.

5. Run the ```php artisan serve``` command to start the laravel test server.