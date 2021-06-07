@extends('adminlte::auth.login')

@section('auth_header', 'Masukkan Username/NRP dan Password')

@section('auth_body')
    @include('component/validation')
    <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}

        {{-- Username field --}}
        <div class="input-group mb-3">
            <input type="text" name="user_name" class="form-control {{ $errors->has('user_name') ? 'is-invalid' : '' }}"
                   value="{{ old('user_name') }}" placeholder="Username/NRP" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-id-card {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('user_name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('user_name') }}</strong>
                </div>
            @endif
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">{{ 'Ingat saya'}}</label>
                </div>
            </div>
            <div class="col-5">
                <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ 'Masuk' }}
                </button>
            </div>
        </div>

    </form>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if(config('password_reset_url'))
        <p class="my-0">
            <a href="{{ route('password.request') }}">
                {{ 'Lupa password?' }}
            </a>
        </p>
    @endif

    {{-- Register link --}}
    @if(route('register'))
        <p class="my-0">
            <a href="{{ route('register') }}">
                {{ 'Daftar baru' }}
            </a>
        </p>
    @endif
@stop
