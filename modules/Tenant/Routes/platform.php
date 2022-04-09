<?php

use Modules\Tenant\Orchid\Screens\TenantEditScreen;
use Modules\Tenant\Orchid\Screens\TenantListScreen;
use Tabuna\Breadcrumbs\Trail;

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
            ->push('Edit Tenant', route('platform.tenant.edit', $tenant));
    });
