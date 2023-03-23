<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queues') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- <a href="{{ route('users.create') }}" class="btn btn-success">{{ __('Create user') }}</a> -->
                    <!-- <br>
                    <br> -->

                    @if (empty($jobs))
                            <p>{{ __('No queues found') }}</p>
                        @else

                        <ul>
                            @foreach($jobs as $item)
                            <li class="mt-2">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">
                                        <!-- {{ $item->queue }} -->
                                        {{ explode('|', $item->queue)[0] }}

                                        <?php var_dump(json_decode($item->payload)) ?>
                                    </div>

                                    <div class="d-fle col-4">
                                        <a href="{{ route('queues.edit', $item->id) }}" class="btn btn-warning ml-2 mr-2">{{ __('Edit') }}</a>

                                        <form action="{{ route('queues.destroy', $item->id) }}" method="POST" class="btn btn-danger">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        {{ $jobs->links() }}

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
