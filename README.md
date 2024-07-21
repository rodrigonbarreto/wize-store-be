# Project Overview

This project is divided into Backend (BE) developed with Laravel and Frontend (FE) developed with React.

## Configuration

### Requirements

- PHP: 8.2
- MySQL: 8.0

### Setup

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



## Supplier
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
    * The cart could be managed in the Backend using a HasOne relationship with the User, providing better control over product stock and validations.
    * In the SupplierOrderController, there could be a more elegant solution, such as using a Repository pattern.
    * The phpunit.xml configuration could include a separate database for testing to avoid affecting the local database.(Due to the time constraints, I didn't do this configuration)
    * GitHub Actions could be set up to run Pint, PHPStan and Tests automatically.

# FE Project

- [FE Project](https://github.com/rodrigonbarreto/wize-store-fe)
