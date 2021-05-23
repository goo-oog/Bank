<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('accounts.create'));
        $response->assertStatus(200);
        $response->assertViewIs('account-create');
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('accounts.show', $account));
        $response->assertStatus(200);
        $response->assertViewIs('account');
    }

    public function testStore()
    {
        $this->followingRedirects();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('accounts.store'), [
            'user_id' => $user->id,
            'name' => 'Test account',
            'initial_balance' => '1234.56',
            'currency' => 'EUR',
            'type' => 'money'
        ]);
        $this->assertDatabaseHas('accounts', [
            'user_id' => $user->id,
            'name' => 'Test account',
            'currency' => 'EUR',
            'type' => 'money'
        ]);
        $this->assertDatabaseHas('transactions', [
            'amount' => 123456
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }
}
