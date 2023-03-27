<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lead sources') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('lead_source.create') }}" class="btn btn-success">{{ __('Create lead source') }}</a>
                    <br>
                    <br>

                    <ul>
                        @foreach($lead_sources as $lead)
                            <li class="mt-2 d-flex">
                                <div class="col-md-3 col-sm-6 col-auto overflow-hidden">
                                    {{ $lead->name }}
                                    <br>
                                    <p class="text-success">{{ $lead->email }}</p>
                                </div>

                                <div class="col-auto">
                                    <a href="{{ route('lead_source.edit', $lead->id) }}" class="btn btn-warning ml-2 mr-2">{{ __('Edit') }}</a>

                                    <form method="POST" class="btn btn-danger" action="{{ route('lead_source_delete', $lead->id) }}">
                                        @csrf
                                        <button type="submit">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
