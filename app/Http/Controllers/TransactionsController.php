<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\SendSecurityCodeJob;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ConversionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionsController extends Controller
{
    private ConversionService $conversion;

    public function __construct(ConversionService $conversionService)
    {
        $this->conversion = $conversionService;
    }

    /**
     * Show 'make payment' form
     */
    public function create(Account $account)
    {
        $user = User::find(Auth::id());
        if ($account->user_id === $user->id) {
            return view('transaction-create', [
                'account' => $account,
                'userAccounts' => $user->accounts()->get()->except($account->id)
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function askCode(Account $account, Request $request)
    {
        $user = User::find(Auth::id());
        $request->merge(['amount' => str_replace(',', '.', $request->input('amount'))]);
        $request->validate([
            'recipient_account' => [
                'required',
            ],
            'amount' => [
                'required',
                'numeric',
                'between:0,' . $account->transactions()->sum('amount') / 100
            ],
            'description' => ['required', 'max:64']
        ]);
        // Restrict transactions from an investment account only to money account owned by the same user
        if ($account->type === 'investment') {
            $request->validate([
                'recipient_account' => [
                    Rule::in($user->accounts()->pluck('number')->toArray())
                ]
            ]);
        }
        $request->session()->flash('input', $request->input());
        // Generate security code and send it as email
        session(['code' => (string)rand(10000, 99999)]);
        $this->dispatch(new SendSecurityCodeJob($user, session('code')));
        return view('ask-verification-code', [
            'account' => $account,
        ]);
    }

    /**
     * Make payment
     */
    public function store(Account $account, Request $request)
    {
        session(['message' => 'Check your email again and enter the new code here:']);
        $request->validate([
            'code' => [
                'required',
                Rule::in(session('code'))
            ]
        ]);
        $user = User::find(Auth::id());
        if ($account->user_id === $user->id && session('code') === $request->input('code')) {
            $amount = session('input')['amount'] * 100;
            $moneyTransactionsBalance = $account->transactions()->where('type', 'money')->sum('amount');
            // Calculate 20% tax if withdrawal exceeds the sum of deposits
            if ($account->type === 'investment' && $moneyTransactionsBalance - $amount < 0) {
                if ($moneyTransactionsBalance < 0) {
                    $tax = (int)round($amount * 0.2);
                } else {
                    $tax = (int)round(($amount - $moneyTransactionsBalance) * 0.2);
                }
            }
            // Outgoing transaction
            Transaction::create([
                'account_id' => $account->id,
                'partner_account' => session('input')['recipient_account'],
                'description' => 'To: ' . session('input')['recipient_account'] . ', ' . session('input')['description'],
                'amount' => -$amount,
                'currency' => $account->currency
            ]);
            $recipientAccount = Account::where('number', session('input')['recipient_account'])->first();
            if ($recipientAccount) {
                // Apply currency conversion if currencies do not match
                if ($recipientAccount->currency !== $account->currency) {
                    $amount = $this->conversion->do($account->currency, $recipientAccount->currency, $amount);
                    if (isset($tax)) {
                        $tax = $this->conversion->do($account->currency, $recipientAccount->currency, $tax);
                    }
                }
                // Incoming transaction if account is opened in this bank
                Transaction::create([
                    'account_id' => $recipientAccount->id,
                    'partner_account' => $account->number,
                    'description' => 'From: ' . $account->user->name . ', ' . $recipientAccount->number . ', ' . session('input')['description'],
                    'amount' => $amount,
                    'currency' => $recipientAccount->currency
                ]);
                // Applying tax if calculated
                if (isset($tax)) {
                    Transaction::create([
                        'account_id' => $recipientAccount->id,
                        'partner_account' => 'Treasury',
                        'description' => sprintf('Capital gains tax: %0.2f %s', $tax / 100, $recipientAccount->currency),
                        'amount' => -$tax,
                        'currency' => $recipientAccount->currency,
                        'type' => 'tax'
                    ]);
                }
            }
        }
        session()->forget(['message', 'code', 'input']);
        return redirect()->route('accounts.show', ['account' => $account->id]);
    }
}
