@extends('adminlte::page')

@section('title', 'Profile Settings')

@section('content_header')
    <h1>Profile Settings</h1>
    @include('component/validation')
@stop

@section('content')
    <form action="{{ route('member.update.profile')}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nrp">NRP</label>
            <input type="text" class="form-control" id="nrp" value="{{ $user['user_name'] }}" disabled>
        </div>
        <div class="form-group">
            <label for="fullName">Nama Lengkap</label>
            <input type="text" class="form-control" name="mahasiswa_name" id="fullName" value="{{ $user['mahasiswa']['mahasiswa_name']}}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ $user['email'] }}">
        </div>
        <div class="form-group">
            <label for="teamName">Nama Tim</label>
            <input type="text" class="form-control" name="team_name" id="teamName" value="{{ $user['team']['team_name'] }}">
        </div>
        <div class="form-group">
            <label for="competitionCategory">Kategori Kompetisi</label>
            <select id="competitionCategory" class="custom-select" disabled>
                <option> {{ $category }}</option>
            </select>
        </div>
        
        <div class="text-right mb-2">
            <br>
            <button type="button" class="btn btn-warning" onclick="return location.reload()">Cancel</button>
            <button class="btn btn-primary" type="submit" >Ubah</button>

        </div>
    </form>
@stop
