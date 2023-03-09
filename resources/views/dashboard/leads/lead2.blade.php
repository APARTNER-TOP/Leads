<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leads') }} 2
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-xl">

                        @if (count($lead_sources) === 0)
                            @if(Auth::user()->admin === 1)
                                <a href="{{ route('lead_source.create') }}" class="btn btn-info">Please create lead source</a>
                            @endif
                        @else
                        @include('components.form2')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
