<div class="border-t border-gray-400 pb-3 hover:bg-yellow-50">
    <a href="/account/{{$account->id}}">
        <div class="flex p-2 space-x-4 xs:flex-wrap sm:flex-nowrap xs:justify-end sm:justify-between">
            <div class="xs:w-full sm:w-96">{{$account->name}}</div>
            <div class="flex ml-2">
                <div>{{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}</div>
                <div class="ml-2">{{$currencyProps->flag($account->currency)}}</div>
            </div>
        </div>
    </a>
</div>