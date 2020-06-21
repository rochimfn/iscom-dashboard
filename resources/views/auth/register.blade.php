@extends('adminlte::auth.register')

@section('auth_header','Daftar sebagi perserta ISCOM')

@section('auth_body')
    @include('component/validation')
    <form action="{{ route('register') }}" method="post" autocomplete="off">
        {{ csrf_field() }}

        {{-- Mahasiswa Name field --}}
        <div class="input-group mb-3">
            <input type="text" name="mahasiswa_name" class="form-control {{ $errors->has('mahasiswa_name') ? 'is-invalid' : '' }}"
                   value="{{ old('mahasiswa_name') }}" placeholder="Nama Lengkap" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('mahasiswa_name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('mahasiswa_name') }}</strong>
                </div>
            @endif
        </div>

        {{-- User Name / NRPfield --}}
        <div class="input-group mb-3">
            <input type="text" name="user_name" class="form-control {{ $errors->has('user_name') ? 'is-invalid' : '' }}"
                   value="{{ old('user_name') }}" placeholder="NRP" autofocus>
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

        {{-- Team Name --}}
        <div class="input-group mb-3">
            <input type="text" name="team_name" class="form-control {{ $errors->has('team_name') ? 'is-invalid' : '' }}"
                   value="{{ old('team_name') }}" placeholder="Nama Tim" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-users {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('team_name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('team_name') }}</strong>
                </div>
            @endif
        </div>

        {{-- Competition Categories --}}
        <div class="input-group mb-3">
            <select name="competition_category" class="custom-select" required>
                <option value="" disabled selected>Pilih kategori kompetisi</option>
                @foreach($competitionCategories as $category)
                <option value="{{ $category['competition_category_abbreviation'] }}"> {{ $category['competition_category_name'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   value="{{ old('email') }}" placeholder="Email">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password"
                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
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

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                   placeholder="Konfirmasi Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
            @endif
        </div>

        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ 'Daftar' }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            {{ 'Sudah punya akun? Masuk' }}
        </a>
    </p>
@stop

