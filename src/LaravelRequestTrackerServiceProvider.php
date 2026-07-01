<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;
use DragonCode\LaravelRequestTracker\Http\Middleware\TrackerMiddleware;
use DragonCode\LaravelRequestTracker\Listeners\LoggedListener;
use DragonCode\LaravelRequestTracker\Listeners\LogoutListener;
use DragonCode\RequestTracker\TrackerUuid;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\RequestInterface;

class LaravelRequestTrackerServiceProvider extends ServiceProvider
{
    public function boot(Kernel $http): void
    {
        $this->bootConfig();
        $this->bootEvents();
        $this->bootMiddleware($http);
    }

    public function register(): void
    {
        $this->registerConfig();
        $this->registerTrackingData();
        $this->registerHttpClient();
        $this->registerGuzzle();
    }

    protected function bootConfig(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/request-tracker.php' => $this->app->configPath('request-tracker.php'),
        ], ['config', 'tracker']);
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/request-tracker.php',
            'request-tracker'
        );
    }

    protected function registerTrackingData(): void
    {
        $this->app->singleton(TrackerUuid::class);

        $data = new ContextData(
            traceId: $this->app->make(TrackerUuid::class)->generate(),
        );

        $this->app->make(ContextHelper::class)->store($data);
    }

    protected function bootEvents(): void
    {
        Event::listen(Authenticated::class, LoggedListener::class);
        Event::listen(Logout::class, LogoutListener::class);
    }

    protected function bootMiddleware(Kernel $http): void
    {
        $http->prependMiddleware(TrackerMiddleware::class);
    }

    protected function registerHttpClient(): void
    {
        Http::globalRequestMiddleware(function (RequestInterface $request) {
            $context = $this->app->make(ContextHelper::class);

            foreach ($context->getHeaders() as $name => $value) {
                $request = $request->withHeader($name, $value);
            }

            return $request;
        });
    }

    protected function registerGuzzle(): void
    {
        $this->app->scoped(Client::class, function () {
            $context = $this->app->make(ContextHelper::class);

            return new Client(['headers' => $context->getHeaders()]);
        });
    }
}
