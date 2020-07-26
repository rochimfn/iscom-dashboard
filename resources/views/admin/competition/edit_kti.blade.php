@extends('adminlte::page')

@section('title', 'Edit Instruksi')

@section('content_header')
    <h1>Edit Instruksi</h1>
    @include('component/validation')
@stop

@section('content')
    <form action="{{route('admin.competition.update.question.kti', $question['question_id'])}}" method="POST">
    @csrf
    @method('PUT')
        <div class="form-group">
            <label for="editTitle">Judul Instruksi</label>
            <input type="text" class="form-control" name="title" id="editTitle" value="{{ $question['question_title']}}">
        </div>
        <div class="form-group">
            <p class="text-danger"><strong><em>*Submisi hanya menerima file dengan extensi: zip,jar,txt,jpeg,jpg,jpe,pdf,docx,doc,dot,ppt,pps,pot dan pptx</em></strong></p>
            <label for="editDescription">Description</label>
            <textarea id="editDescription" class="form-control" name="description">{!!$question['question_description']!!}"
            </textarea>
        </div>
        <div class="text-right mb-2">
            <br>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" >Update Instruksi</button>
        </div>
    </form>
@stop
@section('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editDescription',
            height : 200,
            plugins : 'advlist link lists',
            images_upload_credentials: true,
            images_upload_url: '{{ route("admin.pages.image") }}',
            automatic_uploads: true,
            image_class_list: [
                {title: 'Responsive Image', value: 'img-fluid'},
            ],
            relative_urls : false,
            convert_urls : false
        });
    </script>
@stop