@extends('adminlte::page')

@section('title', 'Competition Session')

@section('content_header')
    <h1>Competition Session</h1>
    @include('component/validation')
@stop

@php
    function parseDate($dateTime)
    {
        $value = strtotime($dateTime);
        return date('Y-m-d\TH:i', $value);
    }
@endphp

@section('content')
    <form action="{{ route('admin.update.session')}}" method="POST">
        @csrf
        @method('PUT')
        <label for="registration">Registrasi :</label>
        <div class="row">
            <div class="col">
                <input type="datetime-local" class="form-control" name="registration_start" id="registration" value="{{ parseDate($sessions['registration']['session_start']) }}">
            </div>
            <div class="col">
                <input type="datetime-local" class="form-control" name="registration_end"
                 value="{{ parseDate($sessions['registration']['session_end']) }}">
                
            </div>
        </div>
        <br>
        <label for="ktiSubmit">Pengumpulan KTI :</label>
        <div class="row">
            <div class="col">
                <input type="datetime-local" class="form-control" name="kti_submit_start" id="ktiSubmit" value="{{ parseDate($sessions['kti_submit']['session_start']) }}">
            </div>
            <div class="col">
                <input type="datetime-local" class="form-control" name="kti_submit_end" value="{{ parseDate($sessions['kti_submit']['session_end'])}}">    
            </div>
        </div>
        <br>
        <label for="nonKtiSubmit">Pengumpulan non KTI :</label>
        <div class="row">
            <div class="col">
                <input type="datetime-local" class="form-control" name="non_kti_submit_start" id="nonKtiSubmit" value="{{ parseDate($sessions['non_kti_submit']['session_start']) }}">    
            </div>
            <div class="col">
                <input type="datetime-local" class="form-control" name="non_kti_submit_end" value="{{ parseDate($sessions['non_kti_submit']['session_end']) }}">
            </div>
        </div>
        <div class="text-right mb-2">
            <br>
            <button class="btn btn-primary" type="submit" >Atur</button>
        </div>
    </form>
@stop
