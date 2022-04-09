<?php

namespace Modules\Tenant\Orchid\Layouts;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TenantEditLayout extends Rows
{
    protected function fields(): array
    {
        return [
            Input::make('tenant.first_name')
                ->title(__('First Name'))
                ->required(),
            Input::make('tenant.middle_name')
                ->title(__('Middle Name')),
            Input::make('tenant.last_name')
                ->title(__('Last Name'))
                ->required()
        ];
    }
}
