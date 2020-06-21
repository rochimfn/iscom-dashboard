@if ($errors->any())
    <div class="alert alert-danger mt-1">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-succes mt-1">
        <ul>
            @foreach ( session('success') as $success)
                <li>{{ $success }}</li>
            @endforeach
        </ul>
    </div>
@endif
