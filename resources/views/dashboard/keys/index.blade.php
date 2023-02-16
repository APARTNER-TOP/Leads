<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keys') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('key.create') }}" class="btn btn-success">{{ _('Create key') }}</a>
                    <br>
                    <br>

                    <ul>
                        @foreach($keys as $key)
                            <li class="mt-2 d-flex">
                                {{ $key->key }}
                                <a href="{{ route('key.edit', $key->id) }}" class="btn btn-info ml-2 mr-2">{{ _('Edit') }}</a>

                                <form method="POST" action="{{ route('key.delete', $key->id) }}">
                                    @csrf
                                    <button type="submit1" class="btn btn-danger">
                                        {{ _('Delete') }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
