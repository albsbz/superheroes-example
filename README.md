# Superhero App

Example CRUD app for dealing with superheroes (Laravel+VueJS+Vuetify)

## Installation

Rename .env.example to .env and set database credentials

```bash
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Run api server

```bash
php artisan serve
```

Run migrations

```bash
php artisan migrate
```

Seed database with example data, if need

```bash
php artisan db:seed
```

## Testing

To run tests in .env change DB_CONNECTION

```bash
DB_CONNECTION=testing
```

Run tests

```bash
php artisan test
```

## Assumptions

Photo assignment avaliable only between seeded photos (no upload).

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
