<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AccountsController extends Controller
{
    public function showCreateForm(): View
    {
        $user = User::find(Auth::id());
        return view('account-create', [
            'isInvestmentAccountCreated' => $user->accounts()->where('type', 'investment')->exists()
        ]);
    }

    public function create(Request $request)
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
        return redirect('/dashboard');
    }

    public function show(Request $request)
    {
//        $user=User::find(Auth::id());
//        $account=$user->accounts()->with('transactions')->find($request->route('id'));
//        return Inertia::render('Account', [
//            'account' => $account
//        ]);
        $user = User::find(Auth::id());
        $account = $user->accounts()->with('transactions')->find($request->route('id'));
        return view('account', [
            'account' => $account,
            'transactions' => $account->transactions()->orderByDesc('created_at')->get(),
//            'sumIncoming' => $account->transactions()->where('amount', '>', 0)->sum('amount'),
//            'sumOutgoing' => $account->transactions()->where('amount', '<', 0)->sum('amount')
        ]);
    }
//    public function payment(Request $request)
//    {
//        $account=Account::find($request->input('id'));
//        if(User::find(Auth::id())->accounts->contains($account)){
//            $request->validate([
//                'amount' => ['required', 'numeric', 'gt:1']
//            ]);
//            $transaction=new Transaction([
//                'account_id'=>$account->id,
//                'partner_account'=>$request->input('partner_account'),
//                'description'=>$request->input('description'),
//                'amount'=>(int)$request->input('amount'),
//                'currency'=>$account->currency
//            ]);
//            $transaction->save();
//
//            return $transaction;
//        }
////        $user=User::find(Auth::id());
////        /** @var Account $account */
////        $account=$user->accounts()->find($request->input('id'));
////        return $account;
//        return Redirect::route('users.show', $transaction);
//    }
}
