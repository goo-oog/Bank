<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = User::find(Auth::id());
        return view('dashboard', [
            'accounts' => $user->accounts()->get(),
            'isInvestmentAccountCreated' => $user->accounts()->where('type', 'investment')->exists()
        ]);
    }
}
