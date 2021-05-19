<div class="border-t border-gray-400 pb-3 hover:bg-yellow-50">
    <a href="/accounts/{{$account->id}}">
        <div class="flex p-2 space-x-4 xs:flex-wrap sm:flex-nowrap xs:justify-end sm:justify-between">
            <div class="xs:w-full sm:w-96">{{$account->name}}</div>
            <div>{{$account->number}}</div>
            <div class="flex ml-2">
                @if($account->type==='money')
                    <div>{{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}</div>
                @elseif($account->type==='investment')
                    <div>
                        {{sprintf('%0.2f %s',($account->transactions()->sum('amount')+$activeStocksValue->get($account))/100,$account->currency)}}
                    </div>
                @endif
                <div class="ml-2">{{$currencyProps->flag($account->currency)}}</div>
            </div>
        </div>
    </a>
</div>