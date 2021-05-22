<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\CurrencyRatesRepository;
use App\Repositories\StockExchangeRepository;
use App\Services\ActiveStocksValueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    private StockExchangeRepository $stockExchange;
    private ActiveStocksValueService $activeStocksValue;
    private CurrencyRatesRepository $currencyRates;

    public function __construct(
        StockExchangeRepository $stockExchange,
        ActiveStocksValueService $activeStocksValue,
        CurrencyRatesRepository $currencyRates
    )
    {
        $this->stockExchange = $stockExchange;
        $this->activeStocksValue = $activeStocksValue;
        $this->currencyRates = $currencyRates;
    }

    public function create()
    {
        $user = User::find(Auth::id());
        return view('account-create', [
            'isInvestmentAccountCreated' => $user->accounts()->where('type', 'investment')->exists(),
            'symbols' => $this->currencyRates->getAllSymbols()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:32'],
            'currency' => ['required'],
            'type' => ['required'],
            'initial_balance' => ['required', 'numeric', 'gte:0']
        ]);
        $account = new Account([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'number' => strtoupper(hash('crc32', microtime())),
            'currency' => $request->input('currency'),
            'type' => $request->input('type')
        ]);
        $account->save();
        if ($request->input('initial_balance')) {
            Transaction::create([
                'account_id' => $account->id,
                'partner_account' => 'Self',
                'description' => 'Initial balance',
                'amount' => $request->input('initial_balance') * 100,
                'currency' => $account->currency
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function show(Account $account)
    {
        if ($account->user_id === Auth::user()->id) {
            return view('account', [
                'account' => $account,
                'transactions' => $account->transactions()->orderByDesc('created_at')->paginate(5),
                'stocks' => $account->stocks()->orderByDesc('is_active')->orderByDesc('created_at')->get(),
                'stockExchange' => $this->stockExchange,
                'activeStocksValue' => $this->activeStocksValue->get($account) / 100,
                'balance' => $account->transactions()->sum('amount') / 100
            ]);
        }
        return redirect()->route('dashboard');
    }
}
