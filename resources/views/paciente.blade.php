@extends('layouts.index')


@section('content')

    <head>
        <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
    </head>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Nuevo Paciente</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('guardar-paciente') }}">
                            @csrf



                            <div class="form-group">
                                <label for="nombreCom">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombreCom" name="nombreCom" required>
                            </div>

                            <div class="form-group">
                                <label for="fechaNacimiento">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="numTel">Número de Teléfono</label>
                                <input type="tel" class="form-control" id="numTel" name="numTel" required>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button type="submit" class="btn btn-primary">Crear Paciente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Verificar si la página ha sido recargada
        if (!sessionStorage.getItem('pageReloaded')) {
            // Establecer la marca de página recargada en sessionStorage
            sessionStorage.setItem('pageReloaded', 'true');

            // Recargar la página después de un breve retraso (por ejemplo, 500 ms o 0.5 segundos)
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    </script>
@endsection
