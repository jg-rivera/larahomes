<?php

use Orchid\Screen\Actions\Menu;

return [
    'name' => 'Tenant',
    'platform' =>  [
        'mainMenu' => [
            [
                'menu' => Menu::make('Example screen')
                    ->icon('monitor')
                    ->title('Navigation')
                    ->badge(function () {
                        return 6;
                    }),
                'route' => 'platform.example'
            ]
        ]
    ]
];
