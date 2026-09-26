<?php

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Http\Controllers\AssetController;
use Shamrozghouri\LaravelUiAiKit\Http\Controllers\ChatController;
use Shamrozghouri\LaravelUiAiKit\Http\Controllers\ConsoleController;
use Shamrozghouri\LaravelUiAiKit\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| AI UI Routes
|--------------------------------------------------------------------------
|
| Loaded by LaravelUiAiKitServiceProvider via loadRoutesFrom(). Every route is
| optional and config-driven, so a consuming app can disable or relocate
| any of them without touching this file.
*/

if (config('ui-ai-kit.landing.enabled', true)) {
    Route::middleware(config('ui-ai-kit.landing.middleware', ['web']))
        ->group(function () {
            Route::get(
                config('ui-ai-kit.landing.route', 'ui-ai-kit'),
                [LandingController::class, '__invoke']
            )->name('ui-ai-kit.landing');
        });
}

if (config('ui-ai-kit.console.enabled', true)) {
    Route::middleware(config('ui-ai-kit.console.middleware', ['web']))
        ->group(function () {
            Route::get(
                config('ui-ai-kit.console.route', 'ui-ai-kit/console'),
                [ConsoleController::class, '__invoke']
            )->name('ui-ai-kit.console');
        });
}

// Always available so the UI styles itself before assets are published.
Route::get('ui-ai-kit/assets/{file}', [AssetController::class, '__invoke'])
    ->where('file', '[A-Za-z0-9._-]+')
    ->name('ui-ai-kit.asset');

if (config('ui-ai-kit.api.enabled', true)) {
    $middleware = config('ui-ai-kit.api.middleware', ['web']);

    if ($throttle = config('ui-ai-kit.api.throttle')) {
        $middleware[] = 'throttle:'.$throttle;
    }

    Route::middleware($middleware)->group(function () {
        Route::post(
            config('ui-ai-kit.api.route', 'ui-ai-kit/chat'),
            [ChatController::class, '__invoke']
        )->name('ui-ai-kit.chat');
    });
}
