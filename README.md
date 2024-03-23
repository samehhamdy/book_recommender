Laravel App For Book Recommender

## Installation
1- Clone the repository
```bash
2- Run the following commands
```bash
1- cp .env.example .env
2- composer install
3- php artisan key:generate
4- create db and update .env file
5- php artisan migrate --seed
6- php artisan serve
```
this is for normal installation, if you want to use docker, you can use the following commands
```bash
1- cp .env.example .env
2- sail up -d
3- sail artisan key:generate
4- create db and update .env file
5- sail artisan migrate --seed
```

## Api Documentation

go to your browser and type the following url (change local domain to yours)

```bash
http://recommender.test/docs
```

## Testing

```bash
php artisan test
```


