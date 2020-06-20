@extends('adminlte::page')

@section('title', 'Create Pages')

@section('content_header')
    <h1>Create Pages</h1>
    @include('component/validation')
@stop

@section('content')
    <form action="{{route('pages.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="pageTitle">Judul</label>
            <input type="text" class="form-control" name="page_title" id="pageTitle">
        </div>
        <div>
            <label for="pageContent">Konten</label>
            <textarea name="page_content" class="form-control" id="pageContent" rows="10">
                Tulis isi halaman disini ...
            </textarea>
        </div>
        <div class="text-right mb-2">
            <br>
            <button class="btn btn-primary" type="submit" >Publish</button>
        </div>
    </form>
@stop

@section('css')
@stop

@section('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#pageContent',
            height : 480,
            plugins : 'advlist link image lists',
            automatic_uploads: true,
            images_upload_url: '{{ route('pages.image') }}',
            images_upload_credentials: true,
            image_class_list: [
                {title: 'Responsive Image', value: 'img-fluid'},
            ],
            relative_urls : false,
            convert_urls : false
        });
    </script>
@stop
