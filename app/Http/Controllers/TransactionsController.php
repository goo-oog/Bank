<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ConversionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    private ConversionService $conversion;

    public function __construct(ConversionService $conversionService)
    {
        $this->conversion = $conversionService;
    }

    public function create(Account $account)
    {
        if ($account->user_id === User::find(Auth::id())->id) {
            return view('transaction-create', [
                'account' => $account,
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function store(Account $account, Request $request): RedirectResponse
    {
        if ($account->user_id === User::find(Auth::id())->id) {
            $request->merge(['amount' => str_replace(',', '.', $request->input('amount'))]);
            $request->validate([
                'recipient_account' => ['required'],
                'amount' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'lte:' . $account->transactions()->sum('amount') / 100
                ],
                'description' => ['required', 'max:64']
            ]);
            /** @noinspection UnnecessaryCastingInspection */
            $amount = (int)($request->input('amount') * 100);
            Transaction::create([
                'account_id' => $account->id,
                'partner_account' => $request->input('recipient_account'),
                'description' => $request->input('description'),
                'amount' => -$amount,
                'currency' => $account->currency
            ]);
            $recipientAccount = Account::where('number', $request->input('recipient_account'))->first();
            if ($recipientAccount) {
                if ($recipientAccount->currency !== $account->currency) {
                    $amount = $this->conversion->do($account->currency, $recipientAccount->currency, $amount);
                }
                Transaction::create([
                    'account_id' => $recipientAccount->id,
                    'partner_account' => $account->number,
                    'description' => $request->input('description'),
                    'amount' => $amount,
                    'currency' => $recipientAccount->currency
                ]);
            }
        }
        return redirect()->route('accounts.show', ['account' => $account->id]);
    }
}
