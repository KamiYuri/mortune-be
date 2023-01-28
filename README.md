# Back-end

This template should help get you started developing with Laravel 9.

## Project Setup - run after cloning this project

### Run
```shell
composer install
```

### Local configuration
1. Add entry to _**hosts**_ file
    ```text
    127.0.0.1	http://api.mortune.test
    ```
2. Copy file [.env.example](./.env.example) to .env
3. Config database credentials in file [.env](./.env)
4. Generate app key
```shell
php artisan key:generate
```

### Migration
1. Create database
2. Config database in file [.env](./.env)
3. Run migrate
```shell
php artisan migrate
```
- _**Refresh database**_
```shell
php artisan migrate:refresh
```
- _**Migrate database with seeding**_
```shell
php artisan migrate:refresh --seed
```
### Serve app for Development

```sh
php artisan serve
```
Now server running on [http://api.mortune.test:8000](http://api.mortune.test:8000)

### Realtime Broadcast
```sh
php artisan serve
php artisan queue:work
laravel-echo-server start
yarn dev

Class Event implements ShouldBroadcast
<script src="http://localhost:6001/socket.io/socket.io.js"></script>
```
