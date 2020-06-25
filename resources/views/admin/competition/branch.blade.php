@extends('adminlte::page')

@section('title', 'Competition Branch')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Competition Branch</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBranchModal" disabled="">
        Add Branch
        </button>
        
    </div>
    @include('component/validation')
@stop

@section('content')
<p class="text-danger"><strong><em>*Dikunci oleh DBAdmin</em></strong></p>
    <table class="table table-striped table-responsive-sm">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Akronim</th>
                <th>Jumlah Tim</th>
                <th>KTI</th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($branch as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['competition_category_name'] }}</td>
                <td>{{ $item['competition_category_abbreviation'] }}</td>
                <td>{{ $item['competition_category_team_limit'] }}</td>

                @if( $item['is_kti'] == 1)
                <td>Iya</td>
                @else
                <td>Tidak</td>
                @endif
                <td>
                    <button 
                    data-id="{{ $item['competition_category_id'] }}" 
                    data-name="{{ $item['competition_category_name'] }}" 
                    data-abbr="{{ $item['competition_category_abbreviation'] }}" 
                    data-limit="{{ $item['competition_category_team_limit'] }}"
                    data-kti="{{ $item['is_kti'] }}"

                    type="button" class="btn btn-info" onclick="editBranch(this)" disabled>Edit</button>
                </td>
                <td>
                    <form action="{{ route('admin.competition.destroy.branch', $item['competition_category_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Anda yakin ingin menghapus?');" class="btn btn-danger" disabled>Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBranchLabel">Tambah Cabang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.competition.store.branch')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="name">Nama Cabang</label>
                            <input type="text" class="form-control" name="competition_category_name" id="name" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="abbr">Akronim</label>
                            <input type="text" class="form-control" name="competition_category_abbreviation" id="abbr">
                        </div>
                        <div class="form-group">
                            <label for="teamLimit">Jumlah Tim</label>
                            <input type="email" class="form-control" name="competition_category_team_limit" id="teamLimit">
                        </div>
                        <div class="form-check">
							  <input class="form-check-input" type="checkbox" name="is_kti" value="1" id="isKti">
							  <label class="form-check-label" for="isKti">
							   <strong> KTI </strong>
							  </label>
						</div>
                        <div class="text-right mb-2">
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" >Tambah Cabang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchLabel">Edit Cabang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.competition.store.branch')}}" method="POST" id="editBranchForm">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="editName">Nama Cabang</label>
                            <input type="text" class="form-control" name="competition_category_name" id="editName" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="editAbbr">Akronim</label>
                            <input type="text" class="form-control" name="competition_category_abbreviation" id="editAbbr">
                        </div>
                        <div class="form-group">
                            <label for="editTeamLimit">Jumlah Tim</label>
                            <input type="email" class="form-control" name="competition_category_team_limit" id="editTeamLimit">
                        </div>
                        <div class="form-check">
							  <input class="form-check-input" type="checkbox" name="is_kti" value="1" id="editIsKti">
							  <label class="form-check-label" for="editIsKti">
							    KTI
							  </label>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function editBranch(element) {
            document.getElementById('editBranchForm').action = "{{route('admin.competition.store.branch')}}" + "/" + element.dataset.id;
            document.getElementById('editName').value = element.dataset.name;
            document.getElementById('editAbbr').value = element.dataset.abbr;
            document.getElementById('editTeamLimit').value = element.dataset.limit;
            if(element.dataset.kti == 1) {
            	document.getElementById('editIsKti').checked = true;
            } else {
            	document.getElementById('editIsKti').checked = false;
            }
            $('#editBranchModal').modal('toggle')
        }
    </script>
@stop