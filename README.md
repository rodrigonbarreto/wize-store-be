# Project Overview

This project is divided into Backend (BE) developed with Laravel and Frontend (FE) developed with React.

## Configuration

### Requirements

- PHP: 8.1 or higher
- MySQL: 8.0

### Handle .env
copy the .env.example file to .env and set configuration.

### Setup without Docker

```shell
composer install
php artisan migrate
php artisan db:seed
```
Run the server:
```shell
php artisan serve
```

Run the tests:
```shell
./vendor/bin/pest
```

Run code standards:
```shell
./vendor/bin/pint

./vendor/bin/phpstan analyse --memory-limit=4G
```

### Setup with Docker

note: Tests need to be setuped on Docker check on (Improvements)

If you have Docker installed, you can run the following commands:

```shell
docker-compose build
docker-compose up -d
```

Then, run the migration:

```shell
docker-compose exec app php artisan migrate
```

To populate the database, run:

```shell
docker-compose exec app php artisan db:seed
```

If you want to manually create a database or run any other command, use:

```shell
docker-compose exec db mysql -u root
```

# Test user supplier:
    * email: supplier@example.com
    * password: 123123

# Project Overview

The main domains are separated into User and Supplier. Both are part of the User table and are distinguished by the ORM and the type in the database.

# Researches:
- [Serializer](https://laravel.com/docs/10.x/eloquent-resources)
- [Policy](https://laravel.com/docs/10.x/authorization)
- [Resource](https://laravel.com/docs/10.x/eloquent-resources)
- [Auth](https://laravel.com/docs/10.x/sanctum)
- [ORM](https://laravel.com/docs/10.x/eloquent)
- [Tests](https://pestphp.com/docs/installation)
- Code Standards:
    - [Larastan](https://github.com/larastan/larastan)
    - [Laravel Pint](https://laravel.com/docs/10.x/pint)



## Supplier (api only)
Suppliers in the API can:
- Perform CRUD operations on Products
- List buyers
- Register and log in

## Users 
Users can:
- List and view product details
- Checkout (create an order)
- List their own orders

# Additional Information
    * Policies: Used for permissions
    * Resources: Used for data serialization
    * Services: Used for more complex actions
    * Dependency Injection: Used in controllers
    * Code Standards: Implemented with PHP CS Fixer(Pint) and PHPStan
    * Tests: Done with PHPUnit and Pest



# Improvements
    * We need to develop a front-end for the Supplier since it's currently only operational through the API.

    * The cart could be managed in the Backend using a HasOne relationship with the User, providing better control over product stock and validations.

    * In the SupplierOrderController, there could be a more elegant solution, such as using a Repository pattern.
    
    * Setup test ENV on Docker, The phpunit.xml configuration could include a separate database for testing to avoid affecting the local database.(Due to the time constraints, I didn't do this configuration)
    
    * Api Documentation using swagger(Open API ) or  Postman Documentation.
    
# FE Project

- [FE Project](https://github.com/rodrigonbarreto/wize-store-fe)
