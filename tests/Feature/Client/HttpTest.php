<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

test('default', function () {
    setContext();

    Http::fake();

    Http::get('some');

    Http::assertSent(function (Request $request) {
        expect($request->headers())->toMatchSnapshot();

        return true;
    });
});
