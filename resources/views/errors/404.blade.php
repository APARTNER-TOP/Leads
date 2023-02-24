<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="alert alert-danger text-center">
            <h2 class="display-3">{{ $exception->getStatusCode() }}</h2>
            <p class="display-5">{{ __('Oops! Something is wrong') }}.</p>

            <a href="/" class="btn btn-info">{{ __('Back Home') }}</a>
        </div>

    </x-auth-card>
</x-guest-layout>
