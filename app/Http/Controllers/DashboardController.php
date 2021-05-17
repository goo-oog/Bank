<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CurrencyPropertiesService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private CurrencyPropertiesService $currencyProps;

    public function __construct(CurrencyPropertiesService $currencyProps)
    {
        $this->currencyProps = $currencyProps;
    }

    public function __invoke()
    {
        $user = User::find(Auth::id());
        return view('dashboard', [
            'accounts' => $user->accounts()->get(),
            'isInvestmentAccountCreated' => $user->accounts()->where('type', 'investment')->exists(),
            'currencyProps' => $this->currencyProps
        ]);
    }
}
