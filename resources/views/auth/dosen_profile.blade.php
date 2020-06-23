@extends('adminlte::page')

@section('title', 'Profile Settings')

@section('content_header')
    <h1>Profile Settings</h1>
    @include('component/validation')
@stop

@section('content')
    <form action="{{ route('dosen.update.profile')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" value="{{ $user['user_name'] }}" disabled>
        </div>
        <div class="form-group">
            <label for="fullName">Nama Lengkap</label>
            <input type="text" class="form-control" name="dosen_name" id="fullName" value="{{ $user['dosen']['dosen_name']}}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ $user['email'] }}">
        </div>
        
        <div class="text-right mb-2">
            <br>
            <button type="button" class="btn btn-warning" onclick="return location.reload()">Cancel</button>
            <button class="btn btn-primary" type="submit" >Ubah</button>

        </div>
    </form>
@stop
