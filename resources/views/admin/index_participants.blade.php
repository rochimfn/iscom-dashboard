@extends('adminlte::page')

@section('title', 'Participat List Page')

@section('content_header')
<h1>Participat List Page </h1>
<div class="d-flex justify-content-between mt-2">
    <a href="{{route('admin.users.participants.download')}}" class="btn btn-success my-auto mr-4"> Unduh .xlsx</a>
    <div>
        @foreach($participants as $participant)
        <button type="button" class="btn btn-info mt-1">
            {{ strtoupper( $participant['competition_category_abbreviation']) }}
            <span class="badge badge-light"> {{ count($participant['team'])}}</span>
        </button>
        @endforeach
    </div>
</div>
@include('component/validation')
@stop

@section('content')

<table class="table table-striped table-responsive-sm" id="participatsTable">
    <thead>
        <tr>
            <th>No.</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Sebagai</th>
            <th>Nama Tim</th>
            <th>Kategori Lomba</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user['mahasiswa_nrp']}}</td>
            <td>{{ $user['mahasiswa_name'] }}</td>
            @if($user['is_team_leader'] == 1)
            <td>Ketua</td>
            @else
            <td>Anggota</td>
            @endif
            <td>{{ $user['team']['team_name'] }}</td>
            <td>{{ $user['category']['competition_category_name'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#participatsTable').DataTable();
    });
</script>
@stop

@section('plugins.Datatables', true)