<div class="border-t border-gray-400 pb-3">
    <div class="flex xs:flex-wrap md:flex-nowrap xs:justify-end md:justify-between md:space-x-8 lg:space-x-24 sm:space-y-4 md:space-y-0 p-2">
        <div class="flex justify-between xs:w-full space-x-8">
            <div class="w-44 sm:whitespace-nowrap">{{$transaction->created_at->format('d.m.Y H:i')}}</div>
            <div class="w-full">{{$transaction->description}}</div>
            <div class="w-32 text-right whitespace-nowrap">{{sprintf('%0.2f %s',$transaction->amount/100,$account->currency)}}</div>
        </div>
        {{--        <div class="flex space-x-4 items-end">--}}

        {{--        </div>--}}
    </div>
</div>