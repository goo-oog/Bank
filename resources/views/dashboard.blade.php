<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:justify-start sm:flex-nowrap sm:space-x-16 xs:space-y-4 sm:space-y-0 items-end font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                {{ __('Dashboard') }}
            </h2>
            <form method="get" action="/account/show-form/create">
                @csrf
                <input type="submit" value="Create new account"
                       class="bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-gray-800 font-semibold text-xl pb-3">Accounts</h2>
                    @foreach($accounts as $account)
                        @if ($account->type==='money')
                            <div class="border-t border-gray-400 pb-3 hover:bg-yellow-50">
                                <a href="/account/{{$account->id}}">
                                    <div class="flex p-2 space-x-4 xs:flex-wrap sm:flex-nowrap xs:justify-end sm:justify-between">
                                        <div class="xs:w-full sm:w-96">{{$account->name}}</div>
                                        <div>{{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                    @if ($isInvestmentAccountCreated)
                        <h2 class="text-gray-800 font-semibold text-xl pb-3">Investment Account</h2>
                        @foreach($accounts as $account)
                            @if ($account->type==='investment')
                                <div class="border-t border-gray-400 pb-3 hover:bg-yellow-50">
                                    <a href="/account/{{$account->id}}">
                                        <div class="flex p-2 space-x-4 xs:flex-wrap sm:flex-nowrap xs:justify-end sm:justify-between">
                                            <div class="xs:w-full sm:w-96">{{$account->name}}</div>
                                            <div>{{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}</div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
