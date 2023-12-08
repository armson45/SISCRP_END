@extends('adminlte::page')

@section('title', 'Especialidades')

@section('content_header')
    <h1 style="font-weight: bold; text-align:center">Especialidades</h1>
@stop

@section('content')
    <div id="app">
       {{--  <paciente-component></paciente-component> --}}
       <espec-component></espec-component>
    </div>
@stop

@section('css')
   {{--  <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @vite('resources/css/app.css')
@stop

@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    @vite('resources/js/app.js')
@stop