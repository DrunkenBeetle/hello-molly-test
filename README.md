# Unsplash demo

Demo for using Unsplash API to search and serve images using laravel/react

## Running it

- Install using composer (`composer install`)
- Build the frontend react app using: `npm run build`
- Run laravel app using `php artisan serve`
- Open [http://localhost:8000](http://localhost:8000) and search for images

Unsplash data is stored/cached in a sqlite database. Cache is considered stale if the saved search term is older than one day. If you want to reset the cache then you can just destroy the db using `php artisan migrate:refresh`