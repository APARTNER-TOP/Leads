<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queues List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (count($jobs) == NULL)
                            <p>{{ __('No queues found') }}</p>
                        @else

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('ID') }}</th>
                                <th scope="col">{{ __('Lead') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Available at') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr>
                                        <th scope="row">{{ $job->id }}</th>
                                        <td>{{ $job->data['lead_type'] }}</td>
                                        <td>{{ $job->data['first_name'] }} {{ $job->data['last_name'] }}</td>
                                        <td>{{ $job->data['email'] }}</td>
                                        <!-- <td>{ explode('|', $job->queue)[0] }</td> -->
                                        <td>
                                            {{ date('Y-m-d H:i', $job->available_at) }}
                                        </td>
                                        <td>
                                            <!-- <a href="{{ route('queues.show', $job->id) }}" class="btn btn-success ml-2 mr-2">{{ __('View') }}</a> -->

                                            <a href="{{ route('queues.edit', $job->id) }}" class="btn btn-warning ml-2 mr-2">{{ __('Edit') }}</a>

                                            <!-- <form action="{{ route('queues.destroy', $job->id) }}" method="POST" class="btn btn-danger">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form> -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $jobs->links() }}

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
