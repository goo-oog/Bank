<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:justify-start sm:flex-nowrap sm:space-x-12 xs:space-y-4 sm:space-y-0 items-end font-semibold text-xl leading-tight">
            <div class="text-gray-800">
                <span class="text-base font-normal mr-2">Account:</span>
                <span class="whitespace-nowrap">{{$account->name}}</span>
            </div>
            <div class="text-gray-800">
                <span class="text-base font-normal mr-2">Number:</span>
                <span class="whitespace-nowrap">{{$account->number}}</span>
            </div>
            <div>
                <span class="text-base font-normal mr-2 whitespace-nowrap">Balance:</span>
                <span class="whitespace-nowrap">
                    @if($account->type==='money')
                        {{sprintf('%0.2f %s', $balance, $account->currency)}}
                    @else
                        {{sprintf('%0.2f %s', $balance+$activeStocksValue, $account->currency)}}
                    @endif
                </span>
            </div>
            <form method="get" action="/accounts/{{$account->id}}/transactions/create">
                @csrf
                <input type="submit" value="Make payment"
                       class="bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
            </form>
            @if($account->type==='investment')
                <form method="get" action="/accounts/{{$account->id}}/stocks/create">
                    @csrf
                    <input type="submit" value="Buy stocks"
                           class="bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="space-y-12 p-6 bg-white border-b border-gray-200">
                    <div>
                        <div class="flex justify-between font-semibold text-xl pb-3">
                            <h2 class="text-gray-800">Transactions</h2>
                            <h2 class="whitespace-nowrap">
                                {{sprintf('%0.2f %s', $balance, $account->currency)}}
                            </h2>
                        </div>
                        @include('components.transactions-list')
                        @if($account->type==='investment')
                            <div class="flex justify-between font-semibold text-xl mt-16 pb-3">
                                <h2 class="text-gray-800">Investments</h2>
                                <h2 class="whitespace-nowrap">
                                    {{sprintf('%0.2f %s', $activeStocksValue, $account->currency)}}
                                </h2>
                            </div>
                            @include('components.stocks-list')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
