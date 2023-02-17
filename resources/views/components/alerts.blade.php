@if ($errors->any())
    <div class="errors alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="errors alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="errors alert alert-success">
        {{ session('success') }}
    </div>
@endif
