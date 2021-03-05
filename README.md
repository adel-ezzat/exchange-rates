##  USD Exchange Rates
for Retrieving current exchange rates (vs USD) .

## installation

 1. clone the repo 
`git clone https://github.com/adelezzatl/exchange-rates` .

 2. `cd projectname` .

 3. run `composer install` .

 4. configure appURl , database & APIKEY in `.env` file .

 5. configure memecache host & port in `config/cache` ,
  if you want laravel default `file cache driver`change
   `'default' => env('CACHE_DRIVER', 'file'),` .

 6. configure cron to get currencies exchange rates from API evey 24 hours and store them into database 
 `0 0 * * * cd /project-path] && php artisan rates:update >> /dev/null 2>&1`

 7. migrate database  `php artisan migrate`

 8. run `php artisan serve` to serve ,
or you can set your server index path to `public` folder to serve it without the need to run the command.

## requirements

 1. laravel 6 server requirements [here](https://laravel.com/docs/6.x#server-requirements) .
 2. memcahe or use  laravel default file cache driver.
 3. API key from [here](https://free.currencyconverterapi.com/) .

## Project Structure

 - `app/http/controllers/Rates.php` - rates controller.
 -  `app/Rate.php` - rates model.
 - `resources/views/welcome.php` - home view.
 - `routes/api.php` -  api routes.
 - `routes/web.php` -  web routes.
 - `app/Console/Commands/rateUpdate.php` - rates renew command.
 - `app/Http/Middleware/VerifyCsrfToken.php` - excluded route from CSRF verification.
 - `database/migrations/2021_03_04_115327_rates.php` - database migrations.
 - `config/cache` - cache driver config.
 - `.env` - global app configuration.

> by @adelezzatl
