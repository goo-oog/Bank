<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:justify-start sm:flex-nowrap sm:space-x-16 xs:space-y-4 sm:space-y-0 items-end font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                {{ __('Dashboard') }}
            </h2>
            <form method="get" action="/accounts/create">
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
                            @include('components.accounts-list')
                        @endif
                    @endforeach
                    @if ($isInvestmentAccountCreated)
                        <h2 class="text-gray-800 font-semibold text-xl pb-3">Investments Account</h2>
                        @foreach($accounts as $account)
                            @if ($account->type==='investment')
                                @include('components.accounts-list')
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
