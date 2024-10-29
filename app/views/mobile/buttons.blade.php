<!-- Sin tarifar -->
@if ($servicio->esperando_tarifa==1 and $servicio->tarifado===null and $servicio->programado!=1)
  <a data-servicio-id="{{$servicio->id}}" data-user-id="{{$servicio->user->id}}" href="#"
     class="btn btn-default tarifar" data-toggle="modal" data-target="#tarifa_modal">
    TARIFAR
  </a>
@endif
<!-- -->

<!-- Tarifados -->
@if($servicio->tarifado==1 and $servicio->programado!=1 and $servicio->pago_facturacion!=1 or $servicio->pago_pendiente)
  <small style="color: #F47321"><strong>TARIFA APLICADA:</strong></small> <span style="color: #1ba9ff">{{$servicio->tarifastraslados->tarifa_nombre}}</span><br>
  <small style="color: #F47321"><strong>CIUDAD:</strong></small> <span style="color: #1ba9ff">{{$servicio->tarifastraslados->tarifa_ciudad}}</span><br>
  <small style="color: #F47321">
    <strong>VALOR + COMISION:</strong>
  </small>
  <?php

    $total_novedades = 0;

    if ($servicio->novedades!=null) {
      $novedades = json_decode($servicio->novedades);

      foreach ($novedades as $novedad) {
        $total_novedades = $total_novedades+$novedad->valor;
      }
    }

    $valor_tarifa = $servicio->valor+$total_novedades;
    $comision = $valor_tarifa*0.0349+900;
    $comision_iva = $comision*0.19;
    $total_tarifa = $valor_tarifa+$comision+$comision_iva;

  ?>
  <span style=" color: #1ba9ff">$ {{number_format($total_tarifa)}}</span><br>
  <small style="color: #F47321"><strong>VEHICULO:</strong></small> <span style=" color: #1ba9ff">{{strtoupper($servicio->vehiculo_tarifado)}}</span><br>
  <small style="color: #F47321"><strong>USUARIO:</strong></small> <span style=" color: #1ba9ff">@if(isset($servicio->tarifador_user_id)) {{$servicio->tarifado_por()}} @else {{'AUTOMATICO'}} @endif</span>
@endif
<!-- -->

<!-- Pagados -->
@if ($servicio->pago_servicio_id!=null and $servicio->programado!=1)
  <small style="color: #F47321"><strong>PAGADO:</strong></small>
  <span style="color: #1ba9ff">$@if(isset($servicio->pagoservicio()->valor)) {{number_format($servicio->pagoservicio()->valor)}} @endif</span><br>
  <small style="color: #F47321"><strong>FECHA DE PAGO:</strong></small>
  <span style="color: #1ba9ff">{{$servicio->fecha_pago}}</span><br>
@endif

@if ($servicio->pago_facturacion==1 and $servicio->programado==null or $servicio->pago_pendiente==1)
  @if ($servicio->correo_confirmacion!=null)
    <br>
    <p style="text-align: center;">
      <small class="text-success">
        REQUIERE CONFIRMACION VIAL MAIL,
        <strong>REVISAR CORREO CORPORATIVO CON EL APROBADO</strong>
      </small>
    </p>
  @endif
@endif
<!-- -->

@if ($servicio->cancelado!=1 and $servicio->programado!=1 and $servicio->tarifado==1 and ($servicio->tarifa_aceptada==1 or $servicio->pago_facturacion==1))
  <button type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio"
    class="btn btn-default programar_servicio" data-id-servicio="{{$servicio->id}}">
    PROGRAMAR
  </button>
@endif

@if ($servicio->cancelado==1)
  <a class="disabled btn btn-danger">CANCELADO</a>
@endif

<!-- Programados -->
@if ($servicio->programado==1)
  <a class="disabled btn btn-default" disabled>PROGRAMADO</a>
@endif
<!-- -->

@if ($servicio->liquidacion_para_pago!=1 and $servicio->empresarial==1 and $servicio->pago_facturacion!=1 and $servicio->programado==1)
  <button style="margin-left: 3px" class="btn btn-default revisar_servicio" data-servicio-id="{{$servicio->id}}">
    REVISAR
  </button>
@elseif ($servicio->liquidacion_para_pago==1)
  <button data-servicio-id="{{$servicio->id}}" style="margin-left: 3px" class="btn btn-default servicio_liquidado">LIQUIDADO</button>
  @if ($servicio->pago_servicio_id==null)
    <div class="">
        <small class="text-danger">ESPERANDO QUE EL CLIENTE REALIZE EL PAGO</small>
    </div>
  @elseif($servicio->pago_servicio_id!=null)
    <div class="">
        <small class="text-success">PAGO REALIZADO POR PARTE DEL CLIENTE</small>
    </div>
  @endif
@endif

@if ($servicio->tarifado==1 and $servicio->tarifa_aceptada==null and $servicio->pago_facturacion!=1)
  <div class="">
      <small class="text-danger">TARIFA SIN ACEPTAR, ESPERANDO QUE EL CLIENTE ACEPTE LA TARIFA</small>
  </div>
@endif
