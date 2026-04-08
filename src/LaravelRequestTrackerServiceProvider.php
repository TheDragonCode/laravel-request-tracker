<?php

declare(strict_types=1);

namespace DragonCode\LaravelRequestTracker;

use DragonCode\LaravelRequestTracker\Data\ContextData;
use DragonCode\LaravelRequestTracker\Helpers\ContextHelper;
use DragonCode\LaravelRequestTracker\Helpers\TrackerConfig;
use DragonCode\LaravelRequestTracker\Http\Middleware\RequestTrackerMiddleware;
use DragonCode\RequestTracker\TrackerUuid;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\RequestInterface;

class LaravelRequestTrackerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/request-tracker.php' => $this->app->configPath('request-tracker.php'),
        ], ['config', 'tracker']);
    }

    public function register(): void
    {
        $this->registerConfig();
        $this->registerTrackingData();
        $this->registerMiddleware();
        $this->registerHttpMiddleware();
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
        $data = new ContextData(
            traceId: TrackerUuid::get(),
        );

        $this->app->make(ContextHelper::class)->store($data);
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app['router'];

        foreach ($router->getMiddlewareGroups() as $name) {
            $router->prependMiddlewareToGroup($name, RequestTrackerMiddleware::class);
        }
    }

    protected function registerHttpMiddleware(): void
    {
        Http::globalRequestMiddleware(function (RequestInterface $request) {
            $context = $this->app->make(ContextHelper::class);

            return $request
                ->withHeader(TrackerConfig::headerUserId(), $context->getUserId())
                ->withHeader(TrackerConfig::headerIp(), $context->getIp())
                ->withHeader(TrackerConfig::headerTraceId(), $context->getTraceId());
        });
    }
}
