@if ($errors->any())
<div class="alert bg-danger mt-1">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('success'))
<div class="alert bg-lime mt-1">
    @if(is_array(session('success')))
    <ul>
        @foreach (session('success') as $msg)
        <li>{{ $msg }}</li>
        @endforeach
    </ul>
    @elseif (is_string(session('success')))
    <p>{{ session('success') }}</p>
    @endif
</div>
@endif