@extends('adminlte::page')

@section('title', 'Anggota Kelompok')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Anggota Kelompok</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal">
        Tambah Anggota
        </button>
    </div>
    @include('component/validation')
@stop

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Sebagai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teams['mahasiswa'] as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member['mahasiswa_nrp']}}</td>
                <td>{{ $member['mahasiswa_name'] }}</td>
                @if($member['is_team_leader'] == 1)
                <td>Ketua</td>
                @else
                <td>Anggota</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addMemberLabel">Tambah Anggota</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="{{route('users.store')}}" method="POST">
        @csrf
            <div class="form-group">
                <label for="pageTitle">Nama Lengkap</label>
                <input type="text" class="form-control" name="mahasiswa_name" id="pageTitle">
            </div>
            <div class="form-group">
                <label for="pageTitle">NRP</label>
                <input type="text" class="form-control" name="user_name" id="pageTitle">
            </div>
            <div class="form-group">
                <label for="pageTitle">Email</label>
                <input type="text" class="form-control" name="user_email" id="pageTitle">
            </div>
            <div class="text-right mb-2">
                <br>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit" >Tambah Anggota</button>
            </div>
        </form>
        </div>
        </div>
    </div>
    </div>
@stop
