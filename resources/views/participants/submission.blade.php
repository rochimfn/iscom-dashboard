@extends('adminlte::page')

@section('title', 'Submisi')

@section('content_header')
        <h1>Submisi</h1>
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

	                	@if(count($submissions) > 0 &&  $submissions[0])
	                		<button class="btn btn-primary">Edit Submisi</button>
	                	@else
	                		<button class="btn btn-primary">Submit</button>
	                	@endif
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
@endforeach

@stop
