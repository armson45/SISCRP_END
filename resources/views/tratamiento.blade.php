@extends('layouts.index')

@section('content')
<h3 class="text-center">Tratamientos</h3>
<div>
    @isset($tratamientos)
    @foreach ($tratamientos as $tratamiento)
    <div class="row">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $tratamiento->nombreTrabajo }}</h5>
                <p class="card-text">{{ $tratamiento->descripcion }}</p>
                <a href="#" class="btn btn-primary">Agendar Cita</a>
            </div>
        </div>
    </div>
@endforeach
    @endisset
 
</div>
@endsection