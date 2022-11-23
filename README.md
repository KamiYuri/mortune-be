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

### Serve app for Development

```sh
php artisan serve
```
Now server running on [http://api.mortune.test:8000](http://api.mortune.test:8000)
