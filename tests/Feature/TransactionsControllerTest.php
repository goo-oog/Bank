<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create(['user_id' => $user->id]);
        $response = $this->get(route('accounts.transactions.create', $account));
        $response->assertStatus(200);
        $response->assertViewIs('transaction-create');
    }

    public function testStore()
    {
        $this->followingRedirects();
        $user = User::factory()->create();
        $this->actingAs($user);
        $account = Account::factory()->create([
            'user_id' => $user->id,
            'currency' => 'EUR',
            'type' => 'investment'
        ]);
        // One existing transaction for positive balance
        Transaction::factory()->create([
            'account_id' => $account->id,
            'currency' => $account->currency,
            'amount' => 1000
        ]);
        // One existing transaction from selling stocks to trigger tax calculator
        Transaction::factory()->create([
            'account_id' => $account->id,
            'currency' => $account->currency,
            'amount' => 500,
            'type' => 'investment'
        ]);
        $recipientAccount = Account::factory()->create([
            'user_id' => $user->id,
            'currency' => 'USD'
        ]);
        $response = $this->post(route('accounts.transactions.store', $account), [
            'recipient_account' => $recipientAccount->number,
            'amount' => '13,87',
            'description' => 'Payment for BigMac'
        ]);
        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'partner_account' => $recipientAccount->number,
            'amount' => -1387,
            'currency' => 'EUR',
            'type' => 'money',
            'description' => 'To: ' . $recipientAccount->number . ', Payment for BigMac'
        ]);
        $response->assertStatus(200);
        $response->assertViewIs('account');
    }
}
