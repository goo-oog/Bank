@foreach($stocks as $stock)
    <div class="border-t border-gray-400 pb-3
        @if($stock->is_active)
    @if($stockExchange->currentPrice($stock->symbol)>=$stock->buy_price) bg-green-50 @else bg-red-50 @endif
    @else bg-gray-100
    @endif
            ">
        <div class="flex xs:flex-wrap md:flex-nowrap xs:justify-end md:justify-between md:space-x-8 lg:space-x-24 sm:space-y-4 md:space-y-0 p-2">
            <div class="flex justify-between xs:w-full flex-wrap">
                <div class="flex flex-col mr-8">
                    <div class="flex items-start space-x-2">
                        <img src="{{$stockExchange->info($stock->symbol)->logo}}" class="h-8">
                        <div class="text-lg font-semibold">
                            {{$stock->symbol}}
                        </div>
                        <div class="sm:whitespace-nowrap w-full overflow-hidden">
                            {{ $stockExchange->info($stock->symbol)->name }}
                        </div>
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-44 sm:whitespace-nowrap">
                            {{$stock->created_at->format('d.m.Y H:i')}}
                        </div>
                        <div class="w-60">
                            {{sprintf('Bought: %0.2f @ %0.2f %s',$stock->amount,$stock->buy_price,$account->currency)}}
                        </div>
                    </div>
                </div>
                <div class="w-40 flex justify-between mr-8">
                    @if($stock->is_active)
                        <div>Current:</div>
                        <div>
                            {{sprintf('%0.2f',$stockExchange->currentPrice($stock->symbol))}} {{$account->currency}}
                        </div>
                    @else
                        <div>Sold:</div>
                        <div>
                            {{sprintf('%0.2f',$stock->sell_price)}} {{$account->currency}}
                        </div>
                    @endif
                </div>
                <div class="w-40 flex justify-between mr-8">
                    <div>{{ 'Value: ' }}</div>
                    @if($stock->is_active)
                        <div>
                            {{sprintf('%0.2f',($stockExchange->currentPrice($stock->symbol) * $stock->amount))}} {{$account->currency}}
                        </div>
                    @else
                        <div>
                            {{sprintf('%0.2f',($stock->sell_price * $stock->amount))}} {{$account->currency}}
                        </div>
                    @endif
                </div>
                <div class="flex whitespace-nowrap">
                    <div class="flex items-baseline">
                        @if($stock->is_active)
                            <div class="w-40 flex justify-between">
                                <div>Profit:</div>
                                <div class={{$stockExchange->currentPrice($stock->symbol)>=$stock->buy_price?'text-green-600':'text-red-600'}}>
                                    {{sprintf('%0.2f %s',($stockExchange->currentPrice($stock->symbol)-$stock->buy_price) * $stock->amount,$account->currency)}}
                                </div>
                            </div>
                            <div class="w-8 mx-2 text-xs {{$stockExchange->currentPrice($stock->symbol)>=$stock->buy_price?'text-green-600':'text-red-600'}}">
                                {{sprintf('%0.1f %%',(($stockExchange->currentPrice($stock->symbol) / $stock->buy_price-1)*100))}}
                            </div>
                        @else
                            <div class="w-40 flex justify-between">
                                <div>Profit:</div>
                                <div class={{$stock->sell_price>=$stock->buy_price?'text-green-600':'text-red-600'}}>
                                    {{sprintf('%0.2f %s',($stock->sell_price-$stock->buy_price)*$stock->amount,$account->currency)}}
                                </div>
                            </div>
                            <div class="w-8 mx-2 text-xs {{$stock->sell_price>=$stock->buy_price?'text-green-600':'text-red-600'}}">
                                {{sprintf('%0.1f %%',(($stock->sell_price/$stock->buy_price-1)*100))}}
                            </div>
                        @endif
                    </div>
                </div>
                <div>
                    @if($stock->is_active)
                        <form method="post" action="/accounts/{{$account->id}}/stocks/{{$stock->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="patch">
                            <input type="submit" value="Sell"
                                   class="w-16 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400"/>
                        </form>
                    @else
                        <form method="post" action="/accounts/{{$account->id}}/stocks/{{$stock->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <input type="submit" value="Delete"
                                   class="w-16 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400"/>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach