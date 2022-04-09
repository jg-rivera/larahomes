<?php

namespace Modules\Tenant\Orchid\Screens;

use Illuminate\Http\Request;
use Modules\Tenant\Entities\Tenant;
use Modules\Tenant\Orchid\Layouts\TenantEditLayout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class TenantEditScreen extends Screen
{
    public Tenant $tenant;

    public function query(Tenant $tenant): array
    {
        return [
            'tenant' => $tenant
        ];
    }

    private function exists(): bool
    {
        return $this->tenant->exists;
    }

    public function name(): ?string
    {
        return $this->exists() ? __('Edit tenant') : __('Creating a new tenant');
    }

    public function description(): ?string
    {
        return $this->exists() ? __('Edit tenant') : __('Creating a new tenant');
    }

    public function layout(): array
    {
        return [
            TenantEditLayout::class
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make(__('Create tenant'))
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists()),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists()),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists()),
        ];
    }

    public function createOrUpdate(Tenant $tenant, Request $request)
    {
        $tenant->fill($request->get('tenant'))->save();

        Alert::info(__('You have successfully created a tenant.'));

        return redirect()->route('platform.tenant.list');
    }

    public function remove(Tenant $tenant)
    {
        $tenant->delete();

        Alert::info(__('You have successfully deleted the tenant.'));

        return redirect()->route('platform.tenant.list');
    }
}
