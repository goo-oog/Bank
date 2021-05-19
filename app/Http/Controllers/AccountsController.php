<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Repositories\StockExchangeRepository;
use App\Services\ActiveStocksValueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    private StockExchangeRepository $stockExchange;
    private ActiveStocksValueService $activeStocksValue;

    public function __construct(StockExchangeRepository $stockExchange, ActiveStocksValueService $activeStocksValue)
    {
        $this->stockExchange = $stockExchange;
        $this->activeStocksValue = $activeStocksValue;
    }

    public function create()
    {
        $user = User::find(Auth::id());
        return view('account-create', [
            'isInvestmentAccountCreated' => $user->accounts()->where('type', 'investment')->exists()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:32'],
            'currency' => ['required'],
            'type' => ['required']
        ]);
        Account::create([
            'user_id' => Auth::id(),
            'name' => $request->input('name'),
            'number' => hash('crc32', microtime()),
            'currency' => $request->input('currency'),
            'type' => $request->input('type')
        ]);
        return redirect()->route('dashboard');
    }

    public function show(Account $account)
    {
        if ($account->user_id === Auth::user()->id) {
            return view('account', [
                'account' => $account,
                'transactions' => $account->transactions()->orderByDesc('created_at')->get(),
                'stocks' => $account->stocks()->orderByDesc('is_active')->orderByDesc('created_at')->get(),
                'stockExchange' => $this->stockExchange,
                'activeStocksValue' => $this->activeStocksValue->get($account) / 100,
                'balance' => $account->transactions()->sum('amount') / 100
            ]);
        }
        return redirect()->route('dashboard');
    }
}
