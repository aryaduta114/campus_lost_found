<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Kami telah mengirimkan kode OTP ke alamat email Anda.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <!-- OTP -->
        <div>
            <x-input-label for="otp" :value="__('Kode OTP')" />

            <x-text-input
                id="otp"
                class="block mt-1 w-full"
                type="text"
                name="otp"
                inputmode="numeric"
                maxlength="6"
                autocomplete="one-time-code"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verifikasi') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('otp.resend') }}" class="mt-4">
        @csrf

        <button
            type="submit"
            class="underline text-sm text-gray-600 hover:text-gray-900"
        >
            {{ __('Kirim Ulang OTP') }}
        </button>
    </form>
</x-guest-layout>