@extends('adminlte::page')

@section('title', 'All Pages')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>All Pages</h1><a href="{{ route('pages.create') }}" class="btn btn-primary">New Page</a>
    </div>
    @include('component/validation')
@stop

@section('content')
<table id="pagesTable" class="table table-striped table-responsive-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Judul</th>
            <th>Tanggal Publish</th>
            <th>Terakhir Update</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pages as $page)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $page['page_title']}}</td>
            <td>{{ date("j F Y", strtotime($page['created_at'])) }}</td>
            <td>{{ date("j F Y", strtotime($page['updated_at'])) }}</td>
            <td><a href="{{ route('pages.edit', $page['slug']) }}" class="btn btn-primary">Edit</a></td>
            <td>
                <form action="{{ route('pages.destroy', $page['page_id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Anda yakin ingin menghapus halaman?');" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('js')
    <script>
        $(document).ready( function () {
            $('#pagesTable').DataTable();
        } );
    </script>
@stop

@section('plugins.Datatables', true)

