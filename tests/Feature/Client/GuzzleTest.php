<?php

declare(strict_types=1);

use GuzzleHttp\Client;

test('default', function () {
    setContext();

    $client = app(Client::class);

    $headers = $client->getConfig('headers');

    expect($headers)
        ->not->toBeEmpty()
        ->toMatchSnapshot();
});
