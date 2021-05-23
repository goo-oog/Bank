<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowDashboard()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }
}
