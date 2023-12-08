<!-- create_paciente.blade.php -->

@extends('layouts.index')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-end mb-3">
            <a href="{{ route('crear-paciente') }}" class="btn btn-primary">Crear Paciente</a>
        </div>
        @isset($pacientes)
            @if (count($pacientes) > 0)
                <ul class="list-group">
                    @foreach ($pacientes as $paciente)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $paciente->nombreCom }}
                            <div class="btn-group" role="group">
                                <a href="{{ route('agendar-cita', ['paciente_id' => $paciente->id]) }}"
                                    class="btn btn-success">Agendar Cita</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No tienes pacientes registrados.</p>
            @endif
        </div>
    @endisset
@endsection
