# 🪢 Laravel Request Tracker

<picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://banners.beyondco.de/Laravel%20Request%20Tracker.png?pattern=topography&style=style_2&fontSize=100px&md=1&showWatermark=1&theme=dark&packageManager=composer+require&packageName=dragon-code%2Flaravel-request-tracker&description=Laravel+adapter+for+dragon-code%2Frequest-tracker+to+trace+inter-service+request+chains&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg">
    <img src="https://banners.beyondco.de/Laravel%20Request%20Tracker.png?pattern=topography&style=style_2&fontSize=100px&md=1&showWatermark=1&theme=light&packageManager=composer+require&packageName=dragon-code%2Flaravel-request-tracker&description=Laravel+adapter+for+dragon-code%2Frequest-tracker+to+trace+inter-service+request+chains&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg" alt="Laravel Request Tracker">
</picture>

[![Stable Version][badge_stable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

Laravel adapter for dragon-code/request-tracker to trace inter-service request chains.

## Installation

You can install the **Laravel Request Tracker** package via [Composer](https://getcomposer.org):

```Bash
composer require dragon-code/laravel-request-tracker
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="tracker"
```

## Basic Usage

That's all 🙂

Middleware is automatically registered in the application kernel and Http Client.

## How It Works

When the application is initialized, a unique UUIDv7 is generated and written to the Laravel context information.

Laravel automatically adds this information when writing logs.

Default context information:

```php
[
    'tracker' => [
        'traceId' => '019d6cc2-7456-7a78-bdbf-62569a688c78',
    ],
]
```

In addition, when incoming HTTP requests to the application, the middleware automatically retrieves the tracker headers
and adds them to the [context](https://laravel.com/docs/context) information if they are present in the request,
otherwise new ones are generated.

In this case, the `traceId` value is replaced with the new value, and the existing value is transferred to
`parentTraceId`.

For outgoing requests, middleware is automatically registered for the Http facade, which adds tracker headers to
outgoing requests.

## License

This package is licensed under the [MIT License](LICENSE).


[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/laravel-request-tracker.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/laravel-request-tracker.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/laravel-request-tracker?label=packagist&style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/laravel-request-tracker
