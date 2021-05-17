<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:justify-start sm:flex-nowrap sm:space-x-16 xs:space-y-4 sm:space-y-0 items-end font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                <span class="text-base font-normal mr-2">Account:</span>
                {{$account->name}}
            </h2>
            <p>
                <span class="text-base font-normal mr-2 whitespace-nowrap">Balance:</span>
                {{sprintf('%0.2f %s',($account->transactions()->sum('amount'))/100,$account->currency)}}
            </p>
            @if($account->type==='money')
                <form method="get" action="/accounts/{{$account->id}}/transactions/create">
                    @csrf
                    <input type="submit" value="Make payment"
                           class="bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
                </form>
            @elseif($account->type==='investment')
                <form method="get" action="/accounts/{{$account->id}}/stocks/create">
                    @csrf
                    <input type="submit" value="Buy stock"
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
                        @if($account->type==='money')
                            <div class="flex justify-between font-semibold text-xl pb-3">
                                <h2 class="text-gray-800">Transactions</h2>
                                <h2 class="text-green-500 whitespace-nowrap">
                                    {{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}
                                </h2>
                            </div>
                            @include('components.transactions-list')
                        @elseif($account->type==='investment')
                            <div class="flex justify-between font-semibold text-xl pb-3">
                                <h2 class="text-gray-800">Investments</h2>
                                <h2 class="text-green-500 whitespace-nowrap">
                                    {{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}
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
