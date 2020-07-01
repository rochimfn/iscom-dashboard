@extends('adminlte::page')

@section('title', 'Persoalan Non KTI')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Persoalan Non KTI</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPersoalanModal">
        Tambah Persoalan
        </button>
    </div>
    @include('component/validation')
@stop

@section('content')

<div class="accordion" >
@foreach($category as $item)
        <div class="card">
            <div class="card-header" id="heading{{ $item['competition_category_id']}}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $item['competition_category_id']}}">
                      {{ $item['competition_category_name']}}
                    </button>
                </h2>
            </div>
        

        <div id="collapse{{ $item['competition_category_id']}}" class="collapse">
            <div class="card-body">
    @if( count($item['question']) < 1)
        <p><strong>Buat Instruksi untuk peserta!</strong></p>
    @endif
    @foreach($item['question'] as $question)
                <p><strong>Instruksi :</strong></p>
                <p>{{ $question['question_title'] }}</p>
                <p><strong>Deskripsi :</strong></p>
                <p>{!! $question['question_description'] !!}</p>
                <div class="d-flex justify-content-end">
                    <a class="btn btn-primary mr-1" href="{{route('admin.competition.edit.question.non-kti', $question['question_id'] )}}" >Edit</a>
                    <form action="{{ route('admin.competition.destroy.question.non-kti', $question['question_id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Anda yakin ingin menghapus instruksi? Pastikan terdapat satu instruksi untuk peserta');" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                
                <hr>
    @endforeach
            </div>
        </div>
    </div>
@endforeach
</div>
    <div class="modal fade" id="addPersoalanModal" tabindex="-1" role="dialog" aria-labelledby="addInstructionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstructionLabel">Tambah Persoalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.competition.store.question.kti')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="branch">Pilih Cabang</label>
                            <select class="custom-select" name="branch">
                                    <option selected disabled>Pilih cabang</option>
                                @foreach($category as $item)
                                    <option value="{{$item['competition_category_id']}}">{{$item['competition_category_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="instructionTitle">Judul Soal</label>
                            <input type="text" class="form-control" name="title" id="instructionTitle" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="instructionDescription">Deskripsi</label>
                            <textarea class="form-control" name="description" id="instructionDescription">
                                Tulis deskripsi disini
                            </textarea>
                        </div>
                        <div class="text-right mb-2">
                            <br>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" >Tambah Instruksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#instructionDescription',
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