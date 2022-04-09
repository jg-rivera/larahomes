<?php

namespace Modules\Tenant\Orchid\Layouts;

use Modules\Tenant\Entities\Tenant;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class TenantListLayout extends Table
{
    public $target = 'tenants';

    public function columns(): array
    {
        return [
            TD::make('first_name', __('First Name'))
                ->render(function (Tenant $tenant) {
                    return Link::make($tenant->first_name)
                        ->route('platform.tenant.edit', $tenant);
                }),

            TD::make('middle_name', __('Middle Name'))
                ->render(function (Tenant $tenant) {
                    return Link::make($tenant->middle_name)
                        ->route('platform.tenant.edit', $tenant);
                }),

            TD::make('last_name', __('Last Name'))
                ->render(function (Tenant $tenant) {
                    return Link::make($tenant->last_name)
                        ->route('platform.tenant.edit', $tenant);
                }),

            TD::make('created_at', __('Created at'))
                ->render(function (Tenant $tenant) {
                    return Link::make($tenant->created_at->format('M d, Y H:i A'));
                }),
            TD::make('updated_at', __('Updated at'))
                ->render(function (Tenant $tenant) {
                    return Link::make($tenant->updated_at->format('M d, Y H:i A'));
                }),
        ];
    }
}
