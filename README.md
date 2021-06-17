###### Technology Stack
----
- PHP 7.2.x or higher
- Laravel 6
- MySQL 5.7
- Apache 2.4
- VueJS 2.6
- Vuex 3.1
- Vue Router 3.1
- Bootstrap 4.3

##### Installation
----

###### If you're cloning the project using git
`composer install`<br>
`npm install`

Check if your root directory have .env file, if not copy content from .env.example to .env and run,<br>
`php artisan key:generate`


###### If you've downloaded the zip or followed above commands start here:<br>
To migrate tables,<br>
`php artisan migrate`

I've already wrote factories if you want to mock fake data, you can use the same for testing
