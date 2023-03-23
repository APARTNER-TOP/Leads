<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <ul>
                        <li>ID: {{ $job->id }}</li>
                        <li>Available at: {{ date('Y-m-d H:i', $job->available_at) }}</li>

                        @foreach($job->data as $key => $value)
                            <li>{{ $key }}: {{ $value }}</li>
                        @endforeach
                    </ul>

                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-info mt-3">{{ __("Go Back") }}</a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
