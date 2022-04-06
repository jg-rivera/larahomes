<?php

declare(strict_types=1);

use Modules\Tenant\Orchid\Screens\Examples\ExampleScreen;
use Tabuna\Breadcrumbs\Trail;

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });
