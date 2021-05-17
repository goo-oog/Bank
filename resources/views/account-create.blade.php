<x-app-layout>
    <x-slot name="header">
        <h2 class="text-gray-800">
            Create new account
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-jet-validation-errors class="mb-4" :errors="$errors"/>
                    <form method="post" action="/accounts">
                        @csrf
                        <label for="name" class="mr-2">Name your account:</label><br>
                        <input type="text" id="name" name="name" class="h-8 w-48 border rounded border-gray-400 mb-4">
                        <br>
                        <label for="currency" class="mr-2">Choose currency:</label><br>
                        <select id="currency" name="currency" class="h-8 w-48 border rounded border-gray-400 mb-4">
                            <option value="EUR" selected>EUR</option>
                            <option value="USD">USD</option>
                            <option value="CAD">CAD</option>
                        </select>
                        <br>
                        @if ($isInvestmentAccountCreated)
                            <input type="hidden" name="type" value="money">
                        @else
                            <label for="type" class="mr-2">Select account type:</label><br>
                            <select id="type" name="type" class="h-8 w-48 border rounded border-gray-400 mb-4">
                                <option value="money" selected>Money</option>
                                <option value="investment">Investment</option>
                            </select>
                        @endif
                        <br><br>
                        <input type="submit" value="Create new account"
                               class="w-48 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
