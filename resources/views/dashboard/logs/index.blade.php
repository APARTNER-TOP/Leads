<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($logs) > 0)
                    <ul>
                        @foreach($logs as $log)
                            <li class="mt-2 d-flex">
                                <div class="col-md-3 col-sm-6 col-auto overflow-hidden">
                                    ID: {{ $log->id }}
                                    <br>
                                    {{ $log->key }}
                                </div>

                                <div class="col-auto">
                                    <a href="{{ route('log.show', $log->id) }}" class="btn btn-warning ml-2 mr-2">{{ _('Show') }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                        <p>{{ __('Logs is empty.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
