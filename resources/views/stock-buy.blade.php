<x-app-layout>
    <x-slot name="header">
        <div class="flex xs:space-x-8 sm:space-x-16 font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                Buy stocks
            </h2>
            <h2 class="text-gray-800">
                <span class="text-base font-normal mr-2">Account:</span>
                {{$account->name}}
            </h2>
            <p>
                <span class="text-base font-normal mr-2 whitespace-nowrap">Balance:</span>
                {{sprintf('%0.2f %s',$account->transactions()->sum('amount')/100,$account->currency)}}
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-8 sm:text-xl xs:text-lg">
                        <form method="get" id="search-form" action="{{'/stocks/'.session('symbol').'/search'}}"
                              class="inline-flex flex-nowrap justify-center items-center">
                            <label for="search" class="whitespace-nowrap">Search for stock:</label>
                            <input type="search" id="search" maxlength="5" name="symbol" required
                                   value="{{session('symbol')??old('symbol')}}"
                                   class="h-8 w-20 border rounded border-gray-400 ml-2 text-center"
                                   oninput="this.value = this.value.toUpperCase();
                                        document.getElementById('search-form').action='/stocks/'+this.value+'/search'">
                            <input type="submit" value="Search"
                                   class="w-20 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400 ml-2">
                        </form>
                        @if(session('symbol'))
                            <div class="flex flex-nowrap items-center space-x-2">
                                <img src="{{ $stockExchange->info(session('symbol'))->logo }}" class="h-8">
                                <div class="font-bold">{{ session('symbol') }}</div>
                                <div class="text-gray-400 whitespace-nowrap overflow-hidden">{{ $stockExchange->info(session('symbol'))->name }}</div>
                                <div class="font-bold whitespace-nowrap">{{ sprintf('$ %0.2f',$stockExchange->currentPrice(session('symbol'))) }}</div>
                            </div>
                            <form method="post" action="/accounts/{{$account->id}}/stocks"
                                  class="inline-flex flex-nowrap text-xs items-end">
                                @csrf
                                <input type="hidden" name="symbol" value="{{ session('symbol') }}">
                                <div>
                                    <label for="buy">Count</label><br>
                                    <input type="text" id="buy" maxlength="8"
                                           class="h-8 w-28 border rounded border-gray-400" name="amount"
                                           pattern="^[0-9]+[\.]?[0-9]*$"
                                           oninput="document.getElementById('buy-m').value='$'+Math.round(this.value*{{ $stockExchange->currentPrice(session('symbol')) }}*100)/100;
                                                   document.getElementById('buy-button').disabled=
                                                   document.getElementById('buy-m').value.substr(1)<=0 ||
                                                   document.getElementById('buy-m').value.substr(1)>{{($account->transactions()->sum('amount'))/100}}">
                                </div>
                                <div class="ml-2">
                                    <label for="buy-m">Money</label><br>
                                    <input type="text" id="buy-m" maxlength="8"
                                           class="h-8 w-28 border rounded border-gray-400"
                                           pattern="^[\$]?[0-9]+[\.]?[0-9]*$"
                                           oninput="this.value=this.value[0]==='$'?this.value:'$'+this.value;
                                                   document.getElementById('buy').value=Math.round(this.value.substr(1)*1000000/{{ $stockExchange->currentPrice(session('symbol')) }})/1000000">
                                </div>
                                <input type="submit" id="buy-button"
                                       class="w-16 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400 ml-2"
                                       value="Buy">
                            </form>
                        @endif
                    </div>
                    <x-jet-validation-errors class="mb-4" :errors="$errors"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
