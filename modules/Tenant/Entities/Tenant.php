<?php

namespace Modules\Tenant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;

class Tenant extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name'
    ];

    protected static function newFactory()
    {
        return \Modules\Tenant\Database\Factories\TenantFactory::new();
    }
}
