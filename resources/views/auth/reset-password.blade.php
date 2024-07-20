<x-layout-minimal>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-inputs.label for="email" :value="__('Email')" />
            <x-inputs.text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required
                autofocus autocomplete="username" />
            <x-inputs.errorbox :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-inputs.label for="password" :value="__('Password')" />
            <x-inputs.text id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-inputs.errorbox :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-inputs.label for="password_confirmation" :value="__('Confirm Password')" />

            <x-inputs.text id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-inputs.errorbox :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-buttons.primary>
                {{ __('Reset Password') }}
            </x-buttons.primary>
        </div>
    </form>
</x-layout-minimal>
