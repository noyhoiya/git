<?php

use Laravel\Telescope\Http\Middleware\Authorize;
use Laravel\Telescope\Watchers;

return [

    'driver' => env('TELESCOPE_DRIVER', 'database'),

    'cache_store' => env('TELESCOPE_CACHE_STORE', 'database'),

    'enabled' => env('TELESCOPE_ENABLED', true),

    'path' => env('TELESCOPE_PATH', 'telescope'),

    'middleware' => [
        'web',
        \Laravel\Telescope\Http\Middleware\Authorize::class,
    ],
'watchers' => [
    \Laravel\Telescope\Watchers\CacheWatcher::class => [
        'enabled' => true,   // force enable
        'hidden' => [],
        'ignore' => [],
    ],

    \Laravel\Telescope\Watchers\QueryWatcher::class => [
        'enabled' => true,   // force enable
        'ignore_packages' => true,
        'ignore_paths' => [],
        'slow' => 100,
    ],

    \Laravel\Telescope\Watchers\RequestWatcher::class => [
        'enabled' => true,
        'size_limit' => 64,
        'ignore_http_methods' => [],
        'ignore_status_codes' => [],
    ],

    \Laravel\Telescope\Watchers\JobWatcher::class => [
        'enabled' => true,
    ],

    \Laravel\Telescope\Watchers\LogWatcher::class => [
        'enabled' => true,
        'level' => 'error',
    ],

    \Laravel\Telescope\Watchers\ExceptionWatcher::class => [
        'enabled' => true,
    ],

    \Laravel\Telescope\Watchers\EventWatcher::class => [
        'enabled' => true,
        'ignore' => [],
    ],

    \Laravel\Telescope\Watchers\MailWatcher::class => [
        'enabled' => true,
    ],

    \Laravel\Telescope\Watchers\ModelWatcher::class => [
        'enabled' => true,
        'events' => ['eloquent.*'],
        'hydrations' => true,
    ],

    \Laravel\Telescope\Watchers\NotificationWatcher::class => [
        'enabled' => true,
    ],

    \Laravel\Telescope\Watchers\ViewWatcher::class => [
        'enabled' => true,
    ],

    \Laravel\Telescope\Watchers\ScheduleWatcher::class => [
        'enabled' => true,
    ],
],


];
