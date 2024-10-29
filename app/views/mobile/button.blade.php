
@if ($servicio->empresarial==1)
    <br>
    @if ($servicio->programado==null and $servicio->cancelado!=1)
      <button type="button" name="button" class="btn btn-danger cancelar_servicio"
              data-id-servicio="{{$servicio->id}}">
        CANCELAR
      </button>
      <button  type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio" class="btn btn-default programar_servicio"
              data-id-servicio="{{$servicio->id}}">
        PROGRAMAR
      </button>
    @endif
@else
  @if ($servicio->empresarial!=1)
    <br>
    <button type="button" name="button" class="btn btn-danger cancelar_servicio"
            data-id-servicio="{{$servicio->id}}" @if($servicio->estado=='APPROVED'){{'disabled'}}@endif>
      CANCELAR
    </button>
    <button type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio" class="btn btn-default programar_servicio" data-id-servicio="{{$servicio->id}}" @if($servicio->estado=='DECLINED'){{'disabled'}}@endif">
      PROGRAMAR
    </button>
  @endif

  @if ($servicio->esperando_tarifa==1 and $servicio->tarifado==1 and $servicio->pago_servicio_id!=null and $servicio->programado==null)
    <button type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio" class="btn btn-default programar_servicio"
            data-id-servicio="{{$servicio->id}}" >
      PROGRAMAR
    </button>
  @endif
@endif


@if ($servicio->esperando_tarifa==1 and $servicio->tarifado==null)
  
@elseif($servicio->esperando_tarifa==1 and $servicio->tarifado==1 and $servicio->empresarial==null)
  <div>
    <small style="color: #F47321"><strong>TARIFA APLICADA:</strong></small> <span style="color: #1ba9ff">{{$servicio->tarifastraslados->tarifa_nombre}}</span><br>
    <small style="color: #F47321"><strong>CIUDAD:</strong></small> <span style="color: #1ba9ff">{{$servicio->tarifastraslados->tarifa_ciudad}}</span><br>
    <small style="color: #F47321">
      <strong>VALOR + COMISION:</strong>
    </small>
    <?php
      $valor_tarifa = $servicio->valor;
      $comision = $valor_tarifa*0.0349+900;
      $comision_iva = $comision*0.19;
      $total_tarifa = $valor_tarifa+$comision+$comision_iva;
    ?>
    <span style=" color: #1ba9ff">$ {{number_format($total_tarifa)}}</span><br>
    <small style="color: #F47321"><strong>VEHICULO:</strong></small> <span style=" color: #1ba9ff">{{strtoupper($servicio->vehiculo_tarifado)}}</span><br>
    <small style="color: #F47321"><strong>USUARIO:</strong></small> <span style=" color: #1ba9ff">@if(isset($servicio->tarifador_user_id)) {{$servicio->tarifado_por()}} @else {{'AUTOMATICO'}} @endif</span>
  </div>
@endif

@if ($servicio->empresarial==1)
  <center>
    <br>
    <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 11px; padding: 3px 5px; width: 145px; border-radius: 2px;">CONVENIO CORPORATIVO<br>{{$servicio->empresa}}
    </div>
  </center>
@else
  <center>
    <br>

    @if($servicio->estado=='APPROVED')
      <div class="estado_servicio_app" style="background: #35BEDD; color: white; margin: 2px 0px; font-size: 11px; padding: 3px 5px; width: 145px; border-radius: 2px;"> PAGO REALIZADO <i class="fa fa-usd" aria-hidden="true"></i>
      </div>
      <span style="font-size: 15px;">¡Este servicio se debe programar lo más pronto!</span>
    @else
      <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 11px; padding: 3px 5px; width: 145px; border-radius: 2px;"> PAGO DECLINADO <i class="fa fa-usd" aria-hidden="true"></i>
      </div>
      <span style="font-size: 12px;">¡El usuario fue notificado para reintentar el pago!</span>
    @endif

    <br>
  </center>
@endif

@if ($servicio->pago_facturacion==1)
  <div>
      <br>
      <small class="text-info" style="font-weight: bold; font-size: 13px">COBRO POR FACTURACION</small>
  </div>
@elseif ($servicio->liquidacion_pendiente==1)
  @if ($servicio->programado==1)
    @if ($servicio->liquidacion_para_pago==1)
      <small style="color: #F47321">
        <strong>VALOR TOTAL:</strong>
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
      <button data-servicio-id="{{$servicio->id}}" style="margin-left: 3px" class="btn btn-default servicio_liquidado">LIQUIDADO</button>
    @else
      <!--<div>
          <small class="text-danger">SERVICIO PENDIENTE POR LIQUIDAR</small>
          <div>
            <button style="margin-left: 3px" class="btn btn-default revisar_servicio" data-servicio-id="{{$servicio->id}}">
              REVISAR
            </button>
          </div>
      </div>-->
    @endif

  @elseif($servicio->programado==null)
    <!--<div>
        <small class="text-danger">SERVICIO PENDIENTE POR LIQUIDAR</small>
    </div>-->
  @endif
@endif

@if ($servicio->correo_confirmacion!=null)
  <div class="">
    <p style="text-align: center;">
      <small class="text-success">
        REQUIERE CONFIRMACION VIAL MAIL,
        <strong>REVISAR CORREO CORPORATIVO CON EL APROBADO</strong>
      </small>
    </p>
  </div>
@endif
