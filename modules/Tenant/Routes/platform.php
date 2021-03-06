<?php

use Modules\Tenant\Orchid\Screens\TenantEditScreen;
use Modules\Tenant\Orchid\Screens\TenantListScreen;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

Route::screen('tenant', TenantListScreen::class)
    ->name('platform.tenant.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('All Tenants'), route('platform.tenant.list'));
    });

Route::screen('tenant/{tenant?}', TenantEditScreen::class)
    ->name('platform.tenant.edit')
    ->breadcrumbs(function (Trail $trail, $tenant) {
        return $trail
            ->parent('platform.tenant.list')
            ->push(__('Edit Tenant'), route('platform.tenant.edit', $tenant));
    });
