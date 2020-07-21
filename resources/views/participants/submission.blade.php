@extends('adminlte::page')

@section('title', 'Submission')

@section('content_header')
        <h1>Submission</h1>
    @include('component/validation')
@stop

@section('content')

    @if( count($questions) < 1)
        <p><strong>Nope!!</strong></p>
    @endif

@foreach($questions as $question)
	<div class="accordion" >
        <div class="card">
            <div class="card-header" id="heading{{ $question['question_id']}}">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $question['question_id']}}">
                      {{ $question['question_title']}}
                    </button>
                </h2>
            </div>
	        <div id="collapse{{ $question['question_id']}}" class="collapse">
	            <div class="card-body">
	                <p><strong>{{ $question['question_title'] }}</strong></p>
	                <p>{!! $question['question_description'] !!}</p>
	                <div class="d-flex justify-content-center">

	                	@if(count($submissions) > 0 && $submissions[ $question['question_id'] ])
                        <a href="{{ $submissions[$question['question_id']] ['submitted_file'] }}" class="btn btn-success mr-1" target="_blank">Unduh Submisi</a>
                        <form action="{{ route('participants.submission.delete', $question['question_id'] ) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Anda yakin ingin menghapus submisi?');" class="btn btn-danger">Hapus Submisi</button>
                        </form>
	                	@else
	                		  <button type="button" class="btn btn-primary" onclick="submitFileModal({{ $question['question_id']}})">Submit</button>
	                	@endif
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
@endforeach

<div class="modal fade" id="submitModal" role="dialog" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submitModalLabel">Submit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="" action="{{ route('participants.submission.store')}}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="submitted_question_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                      <label for="submittedTitle">Judul</label>
                      <input type="text" class="form-control" name="submitted_title" id="submittedTitle" placeholder="Masukkan judul di sini" required>
                    </div>
                    <div class="custom-file">
                        <input name="submission_file" type="file" class="custom-file-input" id="submitFile" required>
                        <label class="custom-file-label" for="customFile">Pilih file*</label>
                        <small class="form-text form-muted text-danger">*Pastikan file yang anda submit sesuai dengan petunjuk</small>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
          </div>
    </div>
</div>

@stop

@section('js')
    <script>
        const submitFile = document.getElementById('submitFile')
        submitFile.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                document.querySelector('label[for="customFile"]').textContent = this.files[0].name
            } else {
                document.querySelector('label[for="customFile"]').textContent = "Pilih File"
            }
        })

        function submitFileModal(questionId) {
            document.querySelector('input[name="submitted_question_id"]').value = questionId
            $('#submitModal').modal()
        }
    </script>
@stop
