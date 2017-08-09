
# listeo-dev

💁 *Zemke/starter-laravel-angular has been upgraded to AngularJS 1.5.8.*

💁 *Zemke/starter-laravel-angular has been upgraded to Laravel 5.3. You can pull the changes and run* `rm composer.lock && composer install --prefer-dist --no-scripts` *to merge the upgrade.*

# Laravel and AngularJS Starter Application

This is a repo for a starter application for a Single Page Application featuring the modern Laravel PHP framework and Google’s acclaimed front-end framework AngularJS. Just download and install and you have a good foundation for building any application.

## Features!

- Single Page Application
  - HTML5 mode URLs
  - Optimized Laravel and AngularJS routes
    - You kind of don’t need to care about routes, they work automatically as you add new views. Still allows for flexibility if you plan any special routes.
- Authentication!
  - Flexible, extensible, clean
  - Token-based ([tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth))
  - Persistent local storage
  - Versioning of CSS and JS files (cache busting)
  - CSS and JS files will be included automatically
  - Comes with Bootstrap and AngularJS configured to work together at their best
  
## Installation
```
git clone https://github.com/sarancruzer/listeo-dev.git
```
```
composer install 
```
```

### Database setup

Edit `.env.example` according to your environment and save as `.env`.
An application key can be generates with the command `php artisan key:generate`.

Run these commands to create the tables within the database you have already created.

```
php artisan migrate:install
```
```
php artisan migrate:refresh
```

If you get an error like a `PDOException` try editing your `.env` file and change `DB_HOST=localhost` to `DB_HOST=127.0.0.1`. If that doesn’t work, file an issue on GitHub, I will be glad to help.
Source: http://stackoverflow.com/a/20733001

## Run

To provide the JS and CSS files and to keep track of changes to these files:
```

To start the PHP built-in server:
```
php artisan serve 
```

Now you can browse the site  [http://localhost:8000](http://localhost:8000). 🙌

## Requirements

- PHP >= 5.6
- Composer
- NPM
- MySQL 


#### .env

Set up your `.env` file like described in “Database setup” above.

