<x-app-layout>
    <x-slot name="header">
        <div class="flex xs:space-x-8 sm:space-x-16 font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                Buy stock
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
                    <div class="flex flex-wrap justify-center space-x-2 items-end m-4 sm:text-xl xs:text-lg">
                        <form method="get" id="search-form" action="{{'/stocks/'.session('symbol').'/search'}}"
                              class="inline-flex flex-nowrap justify-center items-center">
                            <label for="search" class="whitespace-nowrap">Search for stock:</label>
                            <input type="search" id="search" maxlength="5" name="symbol" required
                                   value="{{session('symbol')??''}}"
                                   class="h-8 w-20 border rounded border-gray-400 ml-2 text-center"
                                   oninput="this.value = this.value.toUpperCase();
                                        document.getElementById('search-form').action='/stocks/'+this.value+'/search'">
                            <input type="submit" value="Search"
                                   class="w-20 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400 ml-2">
                        </form>
                        @if(session('symbol'))
                            <div class="inline-flex flex-nowrap justify-center items-center space-x-2">
                                <img src="{{ $stockExchange->info(session('symbol'))->logo }}" class="h-8">
                                <span class="font-bold">{{ session('symbol') }}</span>
                                <span class="max-w-7xl text-gray-400 whitespace-nowrap overflow-hidden">{{ $stockExchange->info(session('symbol'))->name }}</span>
                                <span class="text-base">{{ '$' }}</span>
                                <span class="font-bold">{{ sprintf('%0.2f',$stockExchange->currentPrice(session('symbol'))) }}</span>
                            </div>
                        @endif
                    </div>
                    <x-jet-validation-errors class="mb-4" :errors="$errors"/>
                    {{--                    <form method="post" action="/accounts/{{$account->id}}/stocks">--}}
                    {{--                        @csrf--}}
                    {{--                        <label for="recipient_account" class="mr-2">Recipient's account number:</label><br>--}}
                    {{--                        <input type="text" id="recipient_account" name="recipient_account"--}}
                    {{--                               class="h-8 xs:w-full sm:w-96 border rounded border-gray-400 mb-8">--}}
                    {{--                        <br>--}}
                    {{--                        <label for="amount" class="mr-2">Amount:</label><br>--}}
                    {{--                        <input type="text" id="amount" name="amount"--}}
                    {{--                               class="h-8 xs:w-1/2 sm:w-48 border rounded border-gray-400 mb-8"--}}
                    {{--                               maxlength="12" pattern="[0-9]+([\.,][0-9]{1,2})?">--}}
                    {{--                        <span class="font-semibold text-xl"> {{$account->currency}}</span>--}}
                    {{--                        <br>--}}
                    {{--                        <label for="description" class="mr-2">Description:</label><br>--}}
                    {{--                        <input type="text" id="description" name="description"--}}
                    {{--                               class="h-8 xs:w-full sm:w-96 border rounded border-gray-400 mb-8">--}}
                    {{--                        <br>--}}
                    {{--                        <input type="submit" value="Pay"--}}
                    {{--                               class="w-48 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">--}}
                    {{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
