@extends('adminlte::page')

@section('title', 'Users Evaluator Page')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Users Evaluator Page</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addEvaluatorModal">
        Tambah Evaluator
        </button>
    </div>
    @include('component/validation')
@stop

@section('content')
    <table class="table table-striped table-responsive-sm" id="usersTable">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Aksi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user['dosen_name'] }}</td>
                <td>{{ $user['user']['user_name'] }}</td>
                <td>{{ $user['user']['email'] }}</td>
                <td>
                    <button 
                    data-userid="{{ $user['user']['user_id'] }}" 
                    data-username="{{ $user['user']['user_name'] }}" 
                    data-fullname="{{ $user['dosen_name'] }}" 
                    data-email="{{ $user['user']['email'] }}" type="button" class="btn btn-info" onclick="editUser(this)">Edit</button>
                </td>
                <td>
                    <form action="{{ route('users.dosen.destroy', $user['user']['user_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Anda yakin ingin menghapus evaluator?');" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="addEvaluatorModal" tabindex="-1" role="dialog" aria-labelledby="addEvaluatorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEvaluatorLabel">Add Evaluator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('users.dosen.store')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="userFullName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="dosen_name" id="userFullName" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="userName">Nama Pengguna</label>
                            <input type="text" class="form-control" name="user_name" id="userName" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="userEmail">Email</label>
                            <input type="email" class="form-control" name="email" id="userEmail">
                        </div>
                        <div class="text-right mb-2">
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" >Tambah Evaluator</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editEvaluatorModal" tabindex="-1" role="dialog" aria-labelledby="editEvaluatorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEvaluatorLabel">Edit Evaluator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('users.dosen.store')}}" method="POST" id="editEvaluatorForm">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="editUserFullName">Nama Lengkap</label>
                            <input type="text" class="form-control" name="dosen_name" id="editUserFullName">
                        </div>
                        <div class="form-group">
                            <label for="editUserNrp">Nama Pengguna</label>
                            <input type="text" class="form-control" name="user_name" id="editUserName">
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
            document.getElementById('editEvaluatorForm').action = "{{route('users.dosen.store')}}" + "/" + element.dataset.userid;
            document.getElementById('editUserFullName').value = element.dataset.fullname;
            document.getElementById('editUserName').value = element.dataset.username;
            document.getElementById('editUserEmail').value = element.dataset.email;
            $('#editEvaluatorModal').modal('toggle')
        }
    </script>
    <script>
        $(document).ready( function () {
            $('#usersTable').DataTable();
        } );
    </script>
@stop

@section('plugins.Datatables', true)