<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Stock;
use App\Models\Transaction;
use App\Repositories\StockExchangeRepository;
use App\Services\ConversionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StocksController extends Controller
{
    private StockExchangeRepository $stockExchange;
    private ConversionService $conversion;

    public function __construct(StockExchangeRepository $stockExchange, ConversionService $conversionService)
    {
        $this->stockExchange = $stockExchange;
        $this->conversion = $conversionService;
    }

    /**
     * Search for stocks
     */
    public function search(string $symbol)
    {
        $checkIfSymbolExists = $this->stockExchange->info($symbol);
        if (isset($checkIfSymbolExists->name)) {
            return redirect()->back()->with(['symbol' => $symbol]);
        }
        return redirect()->back();
    }

    /**
     * Show 'stocks search' form
     */
    public function create(Account $account)
    {
        if (old('symbol')) {
            session(['symbol' => old('symbol')]);
        }
        if ($account->user_id === Auth::user()->id) {
            return view('stock-buy', [
                'account' => $account,
                'stockExchange' => $this->stockExchange
            ]);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Buy stocks
     */
    public function store(Account $account, Request $request)
    {
        if ($account->user_id === Auth::user()->id) {
            $balance = $account->transactions()->sum('amount');
            $price = $this->stockExchange->currentPrice($request->input('symbol'));
            $toPay = round($price * (float)$request->input('amount') * 100);
            $request->validate([
                'amount' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'lte:' . (round($balance / $price * 10000) / 100000)
                ],
            ]);
            Stock::create([
                'account_id' => $account->id,
                'symbol' => $request->input('symbol'),
                'amount' => (float)$request->input('amount'),
                'buy_price' => $price
            ]);
            if ($account->currency !== 'USD') {
                $toPay = $this->conversion->do('USD', $account->currency, (int)$toPay);
            }
            Transaction::create([
                'account_id' => $account->id,
                'partner_account' => $account->number,
                'description' => 'Bought ' . $request->input('amount') . ' '
                    . $request->input('symbol') . ' for $' . $price . ' each',
                'amount' => -$toPay,
                'currency' => $account->currency,
                'type' => 'investment'
            ]);
        }
        session()->forget('symbol');
        return redirect()->route('accounts.show', ['account' => $account->id]);
    }

    /**
     * Sell stocks
     */
    public function update(Account $account, Stock $stock)
    {
        if ($account->user_id === Auth::user()->id) {
            $price = $this->stockExchange->currentPrice($stock->symbol);
            $toReceive = (int)round($price * $stock->amount * 100);
            $stock->update([
                'is_active' => false,
                'sell_price' => $price
            ]);
            if ($account->currency !== 'USD') {
                $toReceive = $this->conversion->do('USD', $account->currency, $toReceive);
            }
            Transaction::create([
                'account_id' => $account->id,
                'partner_account' => $account->number,
                'description' => 'Sold ' . $stock->amount . ' ' . $stock->symbol
                    . ' for ' . $price . ' ' . $account->currency . ' each',
                'amount' => $toReceive,
                'currency' => $account->currency,
                'type' => 'investment'
            ]);
        }
        return redirect()->route('accounts.show', ['account' => $account->id]);
    }

    /**
     * Delete sold stocks
     */
    public function destroy(Account $account, Stock $stock)
    {
        if ($account->user_id === Auth::user()->id) {
            $stock->delete();
        }
        return redirect()->route('accounts.show', ['account' => $account->id]);
    }
}
