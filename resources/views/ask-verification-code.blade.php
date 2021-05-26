<x-app-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <div class="xs:hidden sm:block">
                <x-jet-authentication-card-logo/>
            </div>
        </x-slot>
        <div class="text-gray-800 font-semibold text-xl pb-3">
            Security code
        </div>
        <x-jet-validation-errors class="mb-4"/>
        <form method="post" action="/accounts/{{$account->id}}/transactions">
            @csrf
            <label for="code" class="text-sm">
                {{session('message')??'Check your mail for a code and enter it here:'}}
            </label>
            <div class="flex items-end justify-between mt-3">
                <input id="code" type="text" maxlength="5" inputmode="numeric" name="code"
                       pattern="[0-9]{5}" autocomplete="one-time-code"
                       class="h-8 w-20 border rounded border-gray-400 text-center"/>
                <input type="submit" value="Verify"
                       class="w-20 h-8 bg-white text-base hover:border-blue-500 hover:text-blue-500 px-2 border rounded border-gray-400 ml-2"/>
            </div>
        </form>
    </x-jet-authentication-card>
</x-app-layout>
