# BlackCart API.

## Requirements
1. PHP >= 8.1
2. MySQL 8
3. SQLite and `php-sqlite3` extension (for tests)
4. Composer

## Installation
1. Clone this repository.
2. Copy `.env.example` file to `.env`
3. Configure the database.
4. Run `composer install`
5. Run `php artisan key:generate`
6. Run `php artisan migrate --seed`
7. Run `php artisan serve` to serve the application in your local environment.

## Running Tests
Simply run ` php artisan test --testsuite=Feature`

## Notes
1. I kept `platform` and `driver` Store parameters separate to keep the possibility to integrate separate platforms
with same driver. (e.g. you may need to integrate 2 different Shopify platforms).
2. I did not use WooCommerce PHP Library because it does not support mocking.
3. I added currency code and weight units of WooCommerce in configuration for quicker task completion, but we can get 
it from the Settings API.
4. I ignored pagination for quicker task completion, but for the real platform, it's mandatory.
5. I sent a Postman collection, but I suggest using OpenAPI (Swagger) or Scribe for API Documentations.
6. Mocked responses are implemented only in tests. All postman requests will fail because configurations are invalid.
If you want to enable mocking for API calls (I added it only for testing purposes), uncomment the line 24 in the 
AppServiceProvider.
7. I kept exchange rates of currencies in configuration file. For the real platform, rates needs to be periodically
updated.
8. I filtered product color and size attributes by names but IMO better to keep attribute ids for each platform.
9. Each variation may have its own weight and price, so I added these parameters inside variations.
10. BTW, I did not connect to real Shopify or WooCommerce APIs, all responses were mocked, but if you provide me API keys
I can test it and fix errors (if any).
