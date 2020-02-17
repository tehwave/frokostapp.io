# frokostapp.iop

Post to Slack which users should be responsible for lunch.

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Demo

https://frokostapp.io

## Requirements

The application has been developed and tested to work with the following minimum requirements:

- PHP 7.4
- MySQL 5.7
- Laravel 6

## Installation

Install the packages.

```bash
composer install
```

### Build

Install the dependencies.

```
npm install
```

Process and build assets.

```
npm run prod
```

Develop in a local environment.

```
npm run watch
```

### Deployment

Deploy Script for Laravel Forge.

    cd /home/forge/frokostapp.io

    php artisan down

    git pull origin master

    composer install --no-interaction --prefer-dist --optimize-autoloader

    npm ci

    npm run production

    php artisan migrate --force

    php artisan cache:clear
    php artisan view:clear

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    php artisan queue:restart

    echo "" | sudo -S service php7.2-fpm reload

    php artisan up

Replace ```php7.2-fpm``` with the version of PHP installed on the server.

### Environment

```.env.example``` represents the environment variables for production.

Sensitive values has been redacted. They must be replaced with their correct values.

## About

The website is developed using Laravel PHP framework, Composer PHP dependency manager, JQuery JavaScript library, Bootstrap front-end component library and SASS CSS extension language.

For more information on how I developed the website, please visit [my blog](https://peterchrjoergensen.dk/blog/).

If you would like to contribute by filing an issue or sending a pull request, please feel free to do so.

I would be happy to answer any questions, that you might have regarding the website, via Twitter [@tehwave](https://twitter.com/tehwave).

## Security

For any security related issues, send a mail to [peterchrjoergensen+frokostapp@gmail.com](mailto:peterchrjoergensen+frokostapp@gmail.com) instead of using the issue tracker.

## Credit

- [Peter Christian Jørgensen](https://github.com/tehwave)
- [All Contributors](../../contributors)

## License

[MIT License](LICENSE)