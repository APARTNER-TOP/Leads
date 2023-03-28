<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leads') }} {{ $lead_type }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="max-w-xl">

                        @if($lead_type == 1)

                            @if (count($keys) === 0)
                                @if(Auth::user()->admin === 1)
                                    <a href="{{ route('key.create') }}" class="btn btn-info">Please create key</a>
                                @endif
                            @else
                                @include('components.form')
                            @endif

                        @elseif($lead_type == 2)

                            @if (count($lead_sources) === 0)
                                @if(Auth::user()->admin === 1)
                                    <a href="{{ route('lead_source.create') }}" class="btn btn-info">Please create lead source</a>
                                @endif
                            @else
                                @include('components.form')
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
