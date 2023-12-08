@extends('adminlte::page')

@section('title', 'pacientes')

@section('content_header')
    <h1 style="font-weight: bold; text-align:center">Trabajos</h1>
@stop

@section('content')
    <div id="app">
       {{--  <paciente-component></paciente-component> --}}
       <trabajos-component :user="{{Auth::user() != null ? Auth::user(): json_encode($user = array())}}"></trabajos-component>
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