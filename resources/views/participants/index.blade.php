@extends('adminlte::page')

@section('title', 'Anggota Tim')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Anggota Tim {{$team['team_name']}}</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMemberModal">
        Tambah Anggota
        </button>
    </div>
    @include('component/validation')
@stop

@section('content')
    <table class="table table-striped table-responsive-sm">
        <thead>
            <tr>
                <th>No.</th>
                <th>NRP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Sebagai</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member['mahasiswa_nrp']}}</td>
                <td>{{ $member['mahasiswa_name'] }}</td>
                <td>{{ $member['user'][0]['email'] }}</td>
                @if($member['is_team_leader'] == 1)
                <td>Ketua</td>
                @else
                <td>Anggota</td>
                @endif
                <td>
                    <button 
                    data-userid="{{ $member['user'][0]['user_id'] }}" 
                    data-nrp="{{ $member['mahasiswa_nrp']}}" 
                    data-name="{{ $member['mahasiswa_name'] }}" 
                    data-email="{{ $member['user'][0]['email'] }}" type="button" class="btn btn-info" onclick="editUser(this)">Edit</button>
                </td>
                <td>
                    <form action="{{ route('participants.users.delete', $member['user'][0]['user_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Anda yakin ingin menghapus dari Tim?');" class="btn btn-danger">Delete</button>
                    </form>
                </td>
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
                    <form action="{{route('participants.users.store')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="userName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="mahasiswa_name" id="userName" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="userNrp">NRP</label>
                            <input type="text" class="form-control" name="nrp" id="userNrp">
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" name="email" id="userEmail">
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

    <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberLabel">Edit Data Anggota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('participants.users.store')}}" method="POST" id="editMemberForm">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="editUserName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="mahasiswa_name" id="editUserName">
                        </div>
                        <div class="form-group">
                            <label for="editUserNrp">NRP</label>
                            <input type="text" class="form-control" name="nrp" id="editUserNrp">
                        </div>
                        <div class="form-group">
                            <label for="editUserEmail">Email</label>
                            <input type="email" class="form-control" name="email" id="editUserEmail">
                        </div>
                        <div class="text-right mb-2">
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" >Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function editUser(element) {
            document.getElementById('editMemberForm').action = "{{route('participants.users.store')}}" + "/" + element.dataset.userid;
            document.getElementById('editUserNrp').value = element.dataset.nrp;
            document.getElementById('editUserName').value = element.dataset.name;
            document.getElementById('editUserEmail').value = element.dataset.email;
            $('#editMemberModal').modal('toggle')
        }
    </script>
@stop