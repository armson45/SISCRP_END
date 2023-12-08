@extends('adminlte::page')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Crear Doctor') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('doctores.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="nombre">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text" class="form-control" name="nombre"
                                    value="{{ old('nombre') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="numeroTel">{{ __('Número de Teléfono') }}</label>
                                <input id="numeroTel" type="text" class="form-control" name="numeroTel"
                                    value="{{ old('numeroTel') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="fechaRegistro">{{ __('Fecha de Registro') }}</label>
                                <input id="fechaRegistro" type="date" class="form-control" name="fechaRegistro"
                                    value="{{ old('fechaRegistro') }}" required>
                            </div>

                           



                            <div class="form-group">

                                <input id="user_id" type="hidden" name="user_id" value="1">
                            </div>


                            <div class="form-group">
                                <label for="especialidad_id" class="form-label">Especialidad</label>
                                <select class="form-select" id="especialidad_id" name="especialidad_id">
                                    @foreach ($especialidades as $especialidad)
                                        <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
