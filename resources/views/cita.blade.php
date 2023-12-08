@extends('layouts.index')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-3">¡Agendar cita!</h2>
                        <form method="post" action="{{ route('mostrar-citas') }}">
                            @csrf
                            <div class="form-group">
                                <label for="especialidad_id">Selecciona una especialidad:</label>
                                <select class="form-control" name="especialidad_id" id="especialidad_id">
                                    @foreach ($especialidades as $especialidad)
                                        <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Buscar Citas</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12 mt-3">
                @isset($pacientes)
                    @if ($pacientes)
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="paciente_id" value="{{ $pacientes->id }}">
                                <div class="form-control" style="cursor: default;">{{ $pacientes->nombreCom }}</div>
                            </div>
                        </div>
                    @endif
                @endisset
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-3">Calendario</h3>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12 mt-3">
                <div class="card" id="horasDisponiblesCard" style="display: none;">
                    <div class="card-body">
                        <h3 class="text-center mb-3">Horas Disponibles</h3>
                        <!-- Aquí se mostrarán las horas disponibles -->
                        <form method="post" action="{{ route('citasCliente.store') }}">
                            @csrf
                            <input type="hidden" name="dia" id="dia">
                            <input type="hidden" name="especialidad_id" id="especialidad_id_hidden">
                            <input type="hidden" name="paciente_id" id="paciente_id_hidden">

                        
                                
                        

                            <div id="horasDisponiblesContent"></div>

                            <button type="submit" class="btn btn-primary btn-block mt-3">Confirmar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            @if (isset($eventos))
                console.log('Eventos disponibles:', @json($eventos));

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    select: function(info) {
                        obtenerHorasDisponibles(info.startStr);
                    },
                    locale: 'es',
                    events: @json($eventos)
                });
                calendar.render();
            @else
                console.log('No hay eventos disponibles.');
            @endif

            function obtenerHorasDisponibles(fechaSeleccionada) {
                $.ajax({
                    url: '{{ route('obtener-horas-disponibles') }}',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        fechaSeleccionada: fechaSeleccionada
                    },
                    success: function(response) {
                        mostrarHorasDisponibles(response.horasDisponibles, fechaSeleccionada);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error('Error al obtener las horas disponibles:', textStatus,
                            errorThrown);
                    }
                });
            }

            function mostrarHorasDisponibles(horasDisponibles, fechaSeleccionada) {
                // Rellenar los campos ocultos con la información necesaria
                $('#dia').val(fechaSeleccionada);
                $('#especialidad_id_hidden').val($('#especialidad_id').val());
                $('#paciente_id_hidden').val('1');

                // Limpiar y mostrar las horas disponibles
                $('#horasDisponiblesContent').empty();

                horasDisponibles.forEach(function(hora) {
                    var checkbox = $(
                        '<div class="form-check"><input class="form-check-input" type="radio" name="hora" value="' +
                        hora + '" id="hora' + hora + '"><label class="form-check-label" for="hora' +
                        hora + '">' + hora + '</label></div>');
                    $('#horasDisponiblesContent').append(checkbox);
                });

                // Muestra el card
                $('#horasDisponiblesCard').show();
            }
        });
        
    </script>
@endsection
