<?php

namespace Modules\Tenant\Orchid\Screens;

use Modules\Tenant\Entities\Tenant;
use Modules\Tenant\Orchid\Layouts\TenantListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TenantListScreen extends Screen
{
    public function query(): array
    {
        return [
            'tenants' => Tenant::paginate()
        ];
    }

    public function name(): ?string
    {
        return __('Tenants');
    }

    public function description(): ?string
    {
        return __('All tenants');
    }

    public function commandBar(): array
    {
        return [
            Link::make(__('Create new'))
                ->icon('pencil')
                ->route('platform.tenant.edit')
        ];
    }

    public function layout(): array
    {
        return [
            TenantListLayout::class
        ];
    }
}
