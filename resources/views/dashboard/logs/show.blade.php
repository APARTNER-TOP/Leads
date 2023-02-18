<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show log') }} ID: {{ $log->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>Created at: {{ $log->created_at }}</p>
                    <p class="@if($log->status == 'error') text-danger @else text-success @endif">Status: {{ $log->status }}</p>
                    <p>Code: {{ $log->code }}</p>
                    <p>User ID: {{ $log->user->id }}</p>
                    <p>User Email: {{ $log->user->email }}</p>
                    <p>User Name: {{ $log->user->name }}</p>

                    <h2 class="mt-3 text-success">Data send</h2>
                    @foreach($log->data as $key => $data)
                    <p>{{ $key }}: {{ $data }}</p>
                    @endforeach

                    <h2 class="mt-3 text-success">Result</h2>
                    @foreach($log->result as $key => $data)
                    <p>{{ $data }}</p>
                    @endforeach

                    <a href="{{ url()->previous() }}" class="btn btn-success mt-3">{{ _('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
