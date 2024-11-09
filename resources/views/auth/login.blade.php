<x-dashboard>
    <h1>login</h1>
    <form method="POST" action="/login">
        @csrf

        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12 ">
                <x-form-field>
                    <div class="sm:col-span-4">
                        <x-form-label for="email"> Email </x-form-label>
                        <x-form-input type="email" name="email" id="email" :value="old('email')"
                            placeholder="email@example.com" />
                        <x-form-error name="email" />
                    </div>
                </x-form-field>
                <x-form-field>
                    <div class="sm:col-span-4">
                        <x-form-label for="password"> Password </x-form-label>
                        <x-form-input type="password" name="password" id="password" />
                        <x-form-error name="password" />
                    </div>
                </x-form-field>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900">Cancel</button>
            <x-form-button>Log In</x-form-button>
        </div>
    </form>
</x-dashboard>
