<x-app-layout>
    <x-slot name="header">
        <div class="flex xs:space-x-8 sm:space-x-16 font-semibold text-xl leading-tight">
            <h2 class="text-gray-800">
                Make payment
            </h2>
            <h2 class="text-gray-800">
                <span class="text-base font-normal mr-2">from account:</span>
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
                    <x-jet-validation-errors class="mb-4" :errors="$errors"/>
                    <form method="post" action="/accounts/{{$account->id}}/transactions">
                        @csrf
                        <label for="recipient_account" class="mr-2">Recipient's account number:</label><br>
                        <input type="text" autocomplete="off" list="accounts" name="recipient_account"
                               value="{{ old('recipient_account') }}"
                               class="h-8 xs:w-full sm:w-96 border rounded border-gray-400 mb-8">
                        <datalist id="accounts">
                            @foreach($userAccounts as $userAccount)
                                <option value={{$userAccount->number}}>
                                    {{ucfirst($userAccount->type).' account: '.$userAccount->name.' '.$userAccount->number.' '.$userAccount->currency}}
                                </option>
                            @endforeach
                        </datalist>
                        <br>
                        <label for="amount" class="mr-2">Amount:</label><br>
                        <input type="text" id="amount" name="amount" value="{{ old('amount') }}"
                               class="h-8 xs:w-1/2 sm:w-48 border rounded border-gray-400 mb-8"
                               maxlength="12" pattern="[0-9]+([\.,][0-9]{1,2})?">
                        <span class="font-semibold text-xl"> {{$account->currency}}</span>
                        <br>
                        <label for="description" class="mr-2">Description:</label><br>
                        <input type="text" id="description" name="description" value="{{ old('description') }}"
                               class="h-8 xs:w-full sm:w-96 border rounded border-gray-400 mb-8">
                        <br>
                        <input type="submit" value="Pay"
                               class="w-48 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
