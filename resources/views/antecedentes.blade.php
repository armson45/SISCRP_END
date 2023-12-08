@extends('layouts.index')

@section('content')
<div class="container">
    <h3>Antecedentes médicos</h3>
    <form role="form" action="{{ route('antecedentes.store') }}" method="post">
        @csrf
      <div class="mb-3">
        <label for="hipertencionArterial">Hipertensión Arterial</label>
        <select class="form-control" id="hipertencionArterial" name="hipertencionArterial">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="cardiopatia">Cardiopatía</label>
        <select class="form-control" id="cardiopatia" name="cardiopatia">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="diabetesMellitu">Diabetes Mellitus</label>
        <select class="form-control" id="diabetesMellitu" name="diabetesMellitu">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="problemaRenal">Problema Renal</label>
        <select class="form-control" id="problemaRenal" name="problemaRenal">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="problemaRespiratorio">Problema Respiratorio</label>
        <select class="form-control" id="problemaRespiratorio" name="problemaRespiratorio">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="problemaHepatico">Problema Hepático</label>
        <select class="form-control" id="problemaHepatico" name="problemaHepatico">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="problemaEndocronico">Problema Endocrínico</label>
        <select class="form-control" id="problemaEndocronico" name="problemaEndocronico">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="problemaHemorragico">Problema Hemorrágico</label>
        <select class="form-control" id="problemaHemorragico" name="problemaHemorragico">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="alergiaMedicamentos">Alergia a Medicamentos</label>
        <input type="text" class="form-control" id="alergiaMedicamentos" name="alergiaMedicamentos" placeholder="Alergia a Medicamentos">
      </div>
      
      <div class="mb-3">
        <label for="embarazo">Embarazo</label>
        <select class="form-control" id="embarazo" name="embarazo">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3">
        <label for="otrosMedicamentosQueToma">Otros Medicamentos que Toma</label>
        <select class="form-control" id="otrosMedicamentosQueToma" name="otrosMedicamentosQueToma">
          <option value="">Seleccione una opción</option>
          <option value="SI">Sí</option>
          <option value="NO">No</option>
        </select>
      </div>
      
      <div class="mb-3" id="otrosMedicamentosInfo" style="display: none;">
        <label for="otrosMedicamentosInfo">Información adicional sobre los medicamentos</label>
        <textarea class="form-control" id="otrosMedicamentosInfo" name="otrosMedicamentosInfo" rows="3"></textarea>
      </div>
      
      <div class="mb-3">
        <label for="otrosDatos">Otros Datos</label>
        <textarea class="form-control" id="otrosDatos" name="otrosDatos" rows="3"></textarea>
      </div>
      
      <div class="mb-3">
        <label for="paciente_id">ID del Paciente</label>
        <input type="number" class="form-control" id="paciente_id" name="paciente_id" placeholder="ID del Paciente">
      </div>
      
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>

  <script>
    $(document).ready(function() {
      $('#otrosMedicamentosQueToma').change(function() {
        if ($(this).val() === 'SI') {
          $('#otrosMedicamentosInfo').show();
        } else {
          $('#otrosMedicamentosInfo').hide();
        }
      });
    });
  </script>
@endsection