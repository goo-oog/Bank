<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
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
        if ($account->user_id === User::find(Auth::id())->id) {
            return view('account', [
                'account' => $account,
                'transactions' => $account->transactions()->orderByDesc('created_at')->get(),
            ]);
        }
        return redirect()->route('dashboard');
    }
}
