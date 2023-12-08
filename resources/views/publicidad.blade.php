@extends('layouts.index')

@section('content')
<h3 class="text-center">Publicaciones</h3>
<div>
    @foreach ($publicidades as $publicidad)
    <p class="h4">Ofertas</p>
    <div class="row">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $publicidad->nombreTrabajo }}</h5>
                <p class="card-text">{{ $publicidad->descripcion }}</p>
                <p class="card-text">Precio: {{ $publicidad->precio }}</p>
                <p class="card-text">Desde: {{ $publicidad->fechaInicio }}</p>
                <p class="card-text">Hasta: {{ $publicidad->fechaFinal }}</p>
                <a href="#" class="btn btn-primary">Agendar Cita</a>
            </div>
        </div>
    </div>
@endforeach
</div>
    
@endsection
