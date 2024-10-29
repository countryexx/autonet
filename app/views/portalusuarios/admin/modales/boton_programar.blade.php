
  @if ($servicio->estad_programado==null)
    <button type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio" class="btn btn-default programar_servicio"
            data-id-servicio="{{$servicio->id}}">
      PROGRAMAR
    </button>
  @endif
