<?php

namespace Modules\Tenant\Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Support\Testing\ScreenTesting;

class TenantScreenTest extends TestCase
{
    use RefreshDatabase, ScreenTesting;

    public function testShouldShowScreen()
    {
        $screen = $this->screen('platform.tenant.list')
            ->actingAs(User::find(1));

        $screen->display()
            ->assertSee('Tenants');
    }
}
