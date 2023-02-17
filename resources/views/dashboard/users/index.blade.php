<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('users.create') }}" class="btn btn-success">{{ _('Create user') }}</a>
                    <br>
                    <br>

                    <ul>
                        @foreach($items as $item)
                        <li class="mt-2 d-flex">
                            <!-- {{ $item->name }} -->
                            {{ $item->email }}

                            @if($item->admin)
                            <p class="text-danger ml-2">admin</p>
                            @else
                            <p class="text-success ml-2">user</p>
                            @endif

                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-info ml-2 mr-2">{{ _('Edit') }}</a>

                            @if($item->id > 1)
                            <form method="POST" action="{{ route('users.delete', $item->id) }}">
                                @csrf
                                <button class="btn btn-danger">
                                    {{ _('Delete') }}
                                </button>
                            </form>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
