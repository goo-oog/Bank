<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StocksControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $this->followingRedirects();
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'type' => 'investment'
        ]);
        // One existing transaction for positive balance
        Transaction::factory()->create([
            'account_id' => $account->id,
            'currency' => $account->currency,
            'amount' => 100000
        ]);
        $response = $this->post(route('accounts.stocks.store', $account), [
            'symbol' => 'AAPL',
            'amount' => 1.23
        ]);
        $this->assertDatabaseHas('stocks', [
            'account_id' => $account->id,
            'symbol' => 'AAPL',
            'amount' => 1.23
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('account');
    }

    public function testUpdate()
    {
        $this->followingRedirects();
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'type' => 'investment'
        ]);
        $stock = Stock::factory()->create(['account_id' => $account->id]);
        $response = $this->patch(route('accounts.stocks.update', [$account, $stock]));
        $this->assertDatabaseHas('stocks', [
            'account_id' => $account->id,
            'is_active' => false,
            'symbol' => $stock->symbol,
            'amount' => $stock->amount,
            'buy_price' => $stock->buy_price
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('account');
    }

    public function testDestroy()
    {
        $this->followingRedirects();
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'type' => 'investment'
        ]);
        $stock = Stock::factory()->create([
            'account_id' => $account->id,
            'is_active' => false
        ]);
        $response = $this->delete(route('accounts.stocks.destroy', [$account, $stock]));
        $this->assertDatabaseHas('stocks', ['deleted_at' => Carbon::now()->toDateTimeString()]);
        $response->assertStatus(200);
        $response->assertViewIs('account');
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('accounts.stocks.create', $account));
        $response->assertStatus(200);
        $response->assertViewIs('stock-buy');
    }
}
