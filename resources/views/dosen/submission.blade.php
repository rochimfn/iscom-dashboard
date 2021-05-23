@extends('adminlte::page')

@section('title', 'Submisi KTI')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Submisi</h1>
    <a href="{{ route('dosen.download.submission') }}" class="btn btn-primary">
        Unduh Semua
    </a>
</div>
@include('component/validation')
@stop

@section('content')

<div class="accordion">
    @foreach($submitted as $item)
    <div class="card">
        <div class="card-header" id="heading{{ $item['competition_category_id']}}">
            <div class="mb-0 d-flex justify-content-between">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $item['competition_category_id']}}">
                    {{ $item['competition_category_name'] .' '. '(' . count($item['submitted']) . ')'}}
                </button>
                <a href="{{ route('dosen.download.submission') . '/'. $item['competition_category_abbreviation'] }}" class="btn btn-info">Unduh</a>
            </div>

        </div>


        <div id="collapse{{ $item['competition_category_id']}}" class="collapse">
            <div class="card-body">
                @if( count($item['submitted']) < 1) <p><strong>Belum ada submisi</strong></p>
                    @endif
                    @foreach($item['submitted'] as $submission)
                    <a href="{{env('APP_URL') . $submission['submitted_file'] }}" target="_blank">
                        <p>{{ $submission['submitted_title'] }}</p>
                    </a>
                    <hr>
                    @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop