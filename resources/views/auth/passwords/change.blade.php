@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Change Password</h1>
    @include('component/validation')
@stop

@section('content')
    <form action="{{ route('update.password')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="oldPassword">Password lama</label>
            <input type="password" class="form-control" name="old_password" id="oldPassword">
        </div>
        <div class="form-group">
            <label for="newPassword">Password baru</label>
            <input type="password" class="form-control" name="new_password" id="newPassword">
        </div>
        <div class="form-group">
            <label for="newPasswordConfirmation">Konfirmasi password baru</label>
            <input type="password" class="form-control" name="confirmation_new_password" id="newPasswordConfirmation">
        </div>
        <div class="text-right mb-2">
            <br>
            <button class="btn btn-primary" type="submit" >Ubah</button>
        </div>
    </form>
@stop
