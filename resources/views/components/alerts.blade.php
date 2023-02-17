@if ($errors->any())
    <div class="errors alert alert-danger"
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    >
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="errors alert alert-danger"
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 10000)"
    >
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="errors alert alert-success"
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 2000)">
        {{ session('success') }}
    </div>
@endif


