<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Repositories\StockExchangeRepository;
use Illuminate\Support\Facades\Auth;

class StocksController extends Controller
{
    private StockExchangeRepository $stockExchange;

    public function __construct(StockExchangeRepository $stockExchange)
    {
        $this->stockExchange = $stockExchange;
    }

    public function search(string $symbol)
    {
        $check = $this->stockExchange->info($symbol);
        if (isset($check->name)) {
            return redirect()->back()->with(['symbol' => $symbol]);
        }
        session()->forget('symbol');
        return redirect()->back();
    }

    public function create(Account $account)
    {
        if ($account->user_id === User::find(Auth::id())->id) {
            return view('stock-buy', [
                'account' => $account,
                'stockExchange' => $this->stockExchange
            ]);
        }
        return redirect()->route('dashboard');
    }
}
