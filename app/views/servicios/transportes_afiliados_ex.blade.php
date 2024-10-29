<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Servicios</title>
    <link href="{{asset('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{asset('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('animate.css')}}">
    <link rel="manifest" href="{{asset('manifest.json')}}">
    <style>
      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }
    </style>
</head>
<body onload="nobackbutton();">
@include('admin.menu')

<div class="col-lg-12">
    <h3 class="h_titulo">PROGRAMACION DE SERVICIOS</h3>

    @if($permisos->transportes->servicios->creacion==='on')
        <button style="margin-bottom: 7px" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
            SERVICIO<i class="fa fa-plus icon-btn"></i>
        </button>
    @endif

    <form class="form-inline" id="form_buscar">
        <div class="col-lg-12" style="margin-bottom: 5px">
            <div class="row">
                <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select style="width: 109px;" class="form-control input-font" name="servicios">
                        <option value="0">SERVICIOS</option>
                        <option value="2">NO REVISADOS</option>
                        <option value="3">NO LIQUIDADOS</option>
                        <option value="4">NO FACTURADOS</option>
                        <option value="5">PAGO DIRECTO</option>
                        <option value="6">ENCUESTADO</option>
                        <option value="7">SERVICIOS NO AUTORIZADOS</option>
                        <option value="8">NO FINALIZADOS</option>
						            <option value="9">NO SHOW</option>
                    </select>
                </div>
                <div class="form-group">
                  <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
                    <option value="0">PROVEEDORES</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <select disabled id="conductor_search" style="width: 80px;" class="form-control input-font" name="conductores">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                        <option value="0">CENTROS DE COSTO</option>
                        @foreach($centrosdecosto as $centro)
                            <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select style="width: 107px;" name="ciudades" class="form-control input-font">
                        <option>CIUDADES</option>
                        @foreach($ciudades as $ciudad)
                            <option>{{$ciudad->ciudad}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select style="width: 107px;" class="form-control input-font" name="usuario">
                        <option value="0">USUARIOS</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->first_name.' '.$usuario->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                </div>
                <button data-option="2" id="buscar" class="btn btn-default btn-icon">
                    Buscar<i class="fa fa-search icon-btn"></i>
                </button>
            </div>
        </div>
    </form>

    @if(isset($servicios))
    <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
              <th></th>
              <th>Codigo</th>
              <th>Solicitante/Fecha</th>
              <th>Ruta</th>
              <th>Ciudad</th>
              <th>Fecha: Orden / Servicio</th>
              <th>Itinerario</th>
              <th>Recoger en</th>
              <th>Dejar en</th>
              <th>Detalle</th>
              <th>Pax</th>
              <th>Proveedor / Conductor</th>
              <th>Horario</th>
              <th>Cliente</th>
              <th>Usuario</th>
              <th>Estado</th>
              <th></th>
              <th>Historial</th>
          </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Codigo</th>
                <th>Solicitante/Fecha</th>
                <th>Ruta</th>
                <th>Ciudad</th>
                <th>Fecha: Orden / Servicio</th>
                <th>Itinerario</th>
                <th>Recoger en</th>
                <th>Dejar en</th>
                <th>Detalle</th>
                <th>Pax</th>
                <th>Proveedor / Conductor</th>
                <th>Horario</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th></th>
                <th>Historial</th>
            </tr>
        </tfoot>
        <tbody>

            @foreach($servicios as $servicio)

                <?php
                    $btnEditaractivado = null;
                    $btnEditardesactivado = null;
                    $btnProgactivado = null;
                    $btnProgdesactivado = null;
                ?>

                <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@endif">
                    <td>{{$o++}}</td>
                    <td>{{$servicio->id}}</td>
                    <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>
                    <td>
                      <a href title="{{$servicio->tarifatraslados->tarifa_nombre}}">RT</a>
                    </td>
                    <td>{{$servicio->ciudad}}</td>
                    <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
                    <td>
                        @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                        @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                        @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                        @if($servicio->vuelo==='')@else Vuelo:<br>{{$servicio->vuelo}}@endif<br>
                        @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                        @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                    </td>
                    <td>{{$servicio->recoger_en}}</td>
                    <td>{{$servicio->dejar_en}}</td>
                    <td>{{$servicio->detalle_recorrido}}</td>
                    <td>
                      {{$servicio->pasajeros()}}
                    </td>
                    <td>
                        <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->proveedor->razonsocial}}</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                        <a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->conductor->nombre_completo}}</a>
                    </td>
                    <td>
                      Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br>
                      Hora real:<br> {{$servicio->hora_servicio}}
                    </td>
                    <td>
                      <span class="bolder">
                        @if(($servicio->centrodecosto->razonsocial===$servicio->subcentrodecosto->nombresubcentro))
                          {{$servicio->centrodecosto->razonsocial}}
                        @else
                          {{$servicio->centrodecosto->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->subcentrodecosto->nombresubcentro}}
                        @endif
                      </span>
                    </td>
                    <td>{{$servicio->user->first_name.' '.$servicio->user->last_name}}</td>
                    <td>

                      @if($servicio->facturacion!=null)

                        @if($servicio->facturacion->facturado==1)

                          <small style="display: block" class="text-info">FACTURADO</small>
                          <small style="display: block" class="text-info bolder">
                            ORDEN: {{$servicio->facturacion->ordenfactura->numero_factura}}
                          </small>

                        @else

                          @if($servicio->reconfirmacion!=null)

                            @if($servicio->reconfirmacion->ejecutado==1)
                              <small style="display: block" class="text-info">EJECUTADO</small>
                            @else
                              <smal style="display: block" class="text-success">PROGRAMADO</small>
                            @endif

                          @else
                            <small style="display: block" class="text-success">PROGRAMADO</small>
                          @endif

                          @if (intval($servicio->facturacion->revisado)===1)
                            <small style="display: block" class="text-warning">REVISADO</small>
                          @endif

                          @if(intval($servicio->facturacion->liquidado)===1)
                            <small style="display: block" class="text-danger">LIQUIDADO</small>
                          @endif

                          @if(intval($servicio->facturacion->facturado)!=1)
                            <small style="color: #EC0000; display: block">SIN FACTURAR</small>
                          @endif

                        @endif

                      @else

                        @if($servicio->reconfirmacion!=null)

                          @if($servicio->reconfirmacion->ejecutado==1)
                            <small style="display: block" class="text-info">EJECUTADO</small>
                          @else
                            <small style="display: block" class="text-success">PROGRAMADO</small>
                          @endif

                        @else
                          <small style="display: block" class="text-success">PROGRAMADO</small>
                        @endif

                        <small style="color: #EC0000; display: block">SIN FACTURAR</small>

                      @endif

                      <?php

                          if (intval($servicio->estado_servicio_app)===1) {
                              echo '<div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">EN SERVICIO</div>';
                          }else if(intval($servicio->estado_servicio_app)===2){
                              echo '<div class="estado_servicio_app" style="background: #eaeaea; color: #313131; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">FINALIZADO</div>';
                          }else{
                              echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">NO INICIADO</div>';
                              if (intval($servicio->aceptado_app)===0) {
                                  echo '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">NO ACEPTADO</div>';
                              }else if(intval($servicio->aceptado_app)===3){
                                  echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">RECHAZADO</div>';
                              }else if(intval($servicio->aceptado_app)===1){
                                  echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">ACEPTADO</div>';
                              }
                          }

                          /*if ($servicio->serviciopivote!=null) {
                            echo '<small class="text-primary">EDITADO</small>';
                          }*/

                          /*if ($servicio->novedad!=null) {
                            echo '<small class="text-danger">NOVEDAD</small>';
                          }*/

                          /*if ($servicio->reportepivote!=null) {
                            echo '<br><small class="text-warning">REPORTE</small>';
                          }*/

                          if (intval($servicio->pago_directo)===1) {
              							if(Sentry::getUser()->id_rol === 5 || Sentry::getUser()->id_rol === 6 || Sentry::getUser()->id_rol === 1){
              								echo '<a class="bolder recibir_pago" data-idpag="'.$servicio->id.'" style="cursor: pointer; display: inline-block">PAGO DIRECTO </a>';
              							}else{
              								echo '<small class="bolder">PAGO DIRECTO</small>';
            								}
                          }elseif(intval($servicio->pago_directo)===2){
            									echo '<small class="bolder" style="display: inline-block" title="RECIBIDO: {{$servicio->fecha_pago_directo}}">PAGO DIREC.<i class="glyphicon glyphicon-ok text-success"></i></small>';
            						  }

                          if (intval($servicio->finalizado)===1) {
                              echo '<small style="display: inline-block" class="text-success bolder">FINALIZADO</small>';
                          }

                          if(intval($servicio->pendiente_autori_eliminacion)===1){
                            echo '<small class="bolder" style="color: #f0ad4e; display: inline-block">PROGRAMADO PARA ELIMINAR</small>';
                          }

                          if(intval($servicio->rechazar_eliminacion)===1){
                              echo '<div data-id="'.$servicio->id.'" style="background: #32898e; color: #ffffff; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;" class="btn-rechazado">RECHAZADO ELIMINACION</div>';
                          }

                      ?>
                    </td>
                    <td class="opciones text-center">

                        <?php

                            $rutaMapa = intval($servicio->estado_servicio_app);
                            $recorrido_gps = $servicio->recorrido_gps;
                            $valorCalificacion = 0;
                            $letraCalificacion = '';
                            $clasemodificacion = '';

                            if($permisos->transportes->servicios->edicion==='on'){
                                $btnEditaractivado = '<a id="'.$servicio->id.'" data-toggle="modal" data-target=".mymodal1"'.
                                        'style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio">'.
                                        '<i class="fa fa-pencil"></i></a>';
                            }else{
                                $btnEditaractivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio disabled">'.
                                        '<i class="fa fa-pencil"></i></a>';
                            }

                            $btnEditardesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary disabled">'.
                                    '<i class="fa fa-pencil"></i></a>';

                            /**
                             * PERMISOS PARA ELIMINAR SERVICIOS
                             */
                            if($permisos->transportes->servicios->eliminacion==='on'){

                                $btnProgactivado = '<a id="'.$servicio->id.'" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion">'.
                                        '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                            }else{
                                $btnProgactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion disabled">'.
                                        '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                            }

                            $btnProgdesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning disabled">'.
                                    '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                        ?>

                        <!-- SI EL SERVICIO ESTA PENDIENTE POR ELIMINAR ENTONCES $btnEditardesactivado.$btnProgdesactivado-->
                        @if($servicio->rechazar_eliminacion==1)
                            {{$btnEditaractivado.$btnProgdesactivado}}
                        @elseif($servicio->pendiente_autori_eliminacion==1)
                            {{$btnEditardesactivado.$btnProgdesactivado}}
                        <!-- SI EST FACTURADO ENTONCES -->
                        @elseif($servicio->facturacion!=null)

                            @if($servicio->facturacion->facturado==1)

                              @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12)
                                  {{$btnEditaractivado.$btnProgdesactivado}}
                              @else
                                  {{$btnEditardesactivado.$btnProgdesactivado}}
                              @endif

                            @elseif($servicio->facturacion->liquidado==1)

                              @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
                                  {{$btnEditaractivado.$btnProgactivado}}
                              @else
                                  {{$btnEditardesactivado.$btnProgdesactivado}}
                              @endif

                            @elseif($servicio->facturacion->revisado==1)

                              @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
                                  {{$btnEditaractivado.$btnProgactivado}}
                              @else
                                  {{$btnEditardesactivado.$btnProgdesactivado}}
                              @endif

                            @endif

                        @else

                          {{$btnEditaractivado.$btnProgactivado}}

                        @endif

                        @if($rutaMapa!=null and $recorrido_gps!=null)
                          <a data-toggle="modal" data-target=".mymodal4" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px;" class="btn btn-success ruta_mapa" title="Mapa GPS">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                          </a>
                        @endif
                        @if($servicio->estado_servicio_app===null and $servicio->usuario_id !=null and $servicio->ejecutado!=1)
                        <a style="padding: 6px 6px;" class="btn btn-info enviar_notification" data-id="{{$servicio->id}}" title="Enviar Notificacion APP"><i class="fa fa-info-circle"></i></a>
                        @endif
                    </td>
                    <td>
                    {{-- PERMISO PARA VER RECONFIRMACION --}}
                    @if($permisos->transportes->reconfirmacion->ver==='on')
                      <a style="margin-bottom:5px; display: block;" class="@if($servicio->cancelado===1)disabled @endif btn btn-default" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}">

                        <?php

                          $i=0;

                          if($servicio->reconfirmacion!=null){

                              if ($servicio->reconfirmacion->numero_reconfirmaciones<=2) {
                                  echo '<span class="text-danger">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }else if($servicio->reconfirmacion->numero_reconfirmaciones>=3 and $servicio->reconfirmacion->numero_reconfirmaciones<=4){
                                  echo '<span class="text-info">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===5) {
                                  echo '<span class="text-success">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===6){
                                  echo '<span class="text-success">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===7){
                                  echo '<span class="text-success">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }

                          }else{
                              echo 'VER';
                          }

                        ?>
                      </a>
                        <a style="color: white !important" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}" class="hora_reconfirmacion hidden"></a>
                    @else
                        <a style="margin-bottom:5px" class="disabled btn btn-default">

                          <?php

                            $i=0;

                            if($servicio->reconfirmacion!=null){

                                if ($servicio->reconfirmacion->numero_reconfirmaciones<=2) {
                                    echo '<span class="text-danger">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }else if($servicio->reconfirmacion->numero_reconfirmaciones>=3 and $reconfirmacion->numero_reconfirmaciones<=4){
                                    echo '<span class="text-info">'.$servicio->reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===5) {
                                    echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===6){
                                    echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($servicio->reconfirmacion->numero_reconfirmaciones===7){
                                    echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }

                            }else{
                                echo 'VER';
                            }

                          ?>

                        </a><BR>
                        <a style="color: white !important" class="hora_reconfirmacion hidden"></a>
                    @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<!---MODAL PARA NUEVO SERVICIO-->
<div class="modal fade mymodal" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-servicios">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>NUEVO SERVICIO</strong>
                </div>
                <div class="modal-body tabbable">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#programacion_tab" aria-controls="programacion" id="programacion" role="tab" data-toggle="tab">Programacion de Servicio</a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#ruta_tab" aria-controls="rutas" id="rutas" role="tab">Ruta</a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#ordenes_tab" aria-controls="ordenes" role="tab" id="ordenes">Ordenes de servicio</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="edicion tab-pane fade in active" id="programacion_tab">
                            <div class="row" style="margin-top: 15px">
                                <div class="col-xs-12">
                                    <div class="col-xs-2">
                                        <label>Fecha de orden</label>
                                        <div class="input-group">
                                            <div class="input-group date" id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="fecha_orden" value="{{date('Y-m-d')}}" disabled>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" id="centro_alerta">
                                        <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                        <select class="form-control input-font" id="centro_de_costo">
                                            <option>-</option>
                                            @foreach($centrosdecosto as $centrodecosto)
                                                @if($centrodecosto->inactivo==1)
                                                    <option disabled value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                                @else
                                                    <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
                                    </div>
                                    <div class="subcentros hidden">
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                            <select class="form-control input-font" id="subcentros">
                                                <option>-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="numero_pax">
                                        <div class="col-xs-1">
                                            <label class="obligatorio" for="numero_pax"># pax</label>
                                            <select class="form-control input-font" id="numero_pax">
                                                <option selected>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>GRUPO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-1 grupo_numero hidden">
                                            <label for="grupo_numero">Cantidad</label>
                                            <select class="form-control input-font" id="grupo_numero">
                                                @for ($i = 1; $i < 201; $i++)
                                                    <option>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" style="min-height: 67px;">
                                        <label class="obligatorio" for="departamento">Departamento</label>
                                        <select class="form-control input-font" id="departamento">
                                            <option>-</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                        <select disabled class="form-control input-font" id="ciudad">
                                            <option>-</option>
                                        </select>
                                    </div>
									<!-- DIV PDF -->
      									<div class="col-xs-12 hidden" id="pdfs">
      										<form style="display: inline" id="ingreso_pdfs" enctype="multipart/form-data" method="post">
      											<div class="col-xs-2">
      											</div>
      											<div class="col-xs-2">
      												<label for="formato_serv">Formato Solicitud:</label>
      												<label style="height: width:80px;"><input type="file" class="form-control" name="solicitud_pdf" id="solicitud_pdf" accept="application/pdf" data-filename-placement="inside"></label>
      											</div>
      											<div class="col-xs-2">
      											<label for="correo_serv">Correo Autorizado:</label>
      												<label >
      													<input type="file" class="form-control" name="correo_pdf" id="correo_pdf" accept="application/pdf" data-filename-placement="inside">
      												</label>
      											</div>
      										</form>
      									</div>
      									<!-- DIV PDF -->

                                    <div class="col-xs-12">
                                        <div class="row pasajeros">
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="pax">Pax</label>
                                                <input type="text" class="form-control input-font nombres_pax">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="celular">Celular</label>
                                                <input type="text" class="form-control input-font celular_pax">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="nivel">Nivel</label>
                                                <input type="text" class="form-control input-font nivel_pax">
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="email">Email</label>
                                                <input type="text" class="form-control input-font email_pax" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                        <input id="solicitado_por" type="text" class="form-control input-font">
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group">
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="fecha_solicitud" value="">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="email_solicitante">Email de quien lo solicita</label>
                                        <input id="email_solicitante" type="text" class="form-control input-font">
                                    </div>
                                    <div class="col-xs-1">
                                        <label for="estado_email">Mail</label>
                                        <select class="form-control input-font" id="estado_email">
                                            <option>-</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="ruta_tab">
                            <div class="row" style="margin-top: 15px">
                                <div class="col-xs-12">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="ruta">Ruta</label>
                                                <select class="form-control input-font" id="ruta">
                                                    <option>-</option>
                                                </select>
                                                <!--<small id="agregar_ruta" class="help-block hidden"><a data-toggle="modal" class="shmodal_agregar" href="#shortModal" href="">Agregar ruta!</a></small>-->
                                                <small id="ruta_alerta" class="help-block hidden"><a class="shmodal_noruta" style="color: #a94442">Centro de costo sin rutas solicite una!</a></small>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="recoger_en">Recoger en</label>
                                                <input type="text" class="form-control input-font" id="recoger_en">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="dejar_en">Dejar en</label>
                                                <input type="text" class="form-control input-font" id="dejar_en">
                                            </div>
                                            <div class="col-xs-5">
                                                <label class="obligatorio" for="detalle_recorrido">Detalle del recorrido</label>
                                                <textarea class="form-control input-font" id="detalle_recorrido"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 proveedor_content">
                                        <label class="obligatorio">Proveedor</label>
                                        <select data-option="1" type="text" class="form-control input-font" id="proveedor">
                                            <option value="0">PROVEEDORES</option>
                                            @foreach($proveedores as $proveedor)
                                                @if($proveedor->inactivo!=1)
                                                    <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="conductor">Conductor</label>
										<small role="alert" class="text-danger conductor_alert hidden"></small>
                                        <select disabled class="form-control input-font" id="conductor" estado="false">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="vehiculo">Vehiculo</label>
										<small role="alert" class="text-danger vehiculo_alert hidden"></small>
                                        <select disabled class="form-control input-font" id="vehiculo" estado="false">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio">Tipo de servicio</label>
                                        <div class="form-group">
                                            <label id="id_unico" class="radio-inline">
                                                <input checked type="radio" name="radio_tipo" id="inlineRadio1" value="1"> Unico
                                            </label>
                                            <label id="id_multiple" class="radio-inline">
                                                <input type="radio" name="radio_tipo" id="inlineRadio2" value="2"> Multiple
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 unico">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label for="fecha_servicio">Fecha de servicio</label>
                                                <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker2">
                                                        <input type="text" class="form-control input-font" id="fecha_servicio" value="{{date('Y-m-d')}}">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="hora_servicio">Hora de servicio</label>
                                                <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker3">
                                                        <input type="text" class="form-control input-font" id="hora_servicio">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                <label class="obligatorio" for="resaltar">Resaltar</label>
                                                <select class="form-control input-font" id="resaltar">
                                                    <option>-</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="pago_directo">Pago Directo</label>
                                                <select class="form-control input-font" id="pago_directo">
                                                    <option>-</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="notificacion">Notificacion</label>
                                                <select class="form-control input-font" id="notificacion">
                                                    <option>-</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-12">
                                                <h5 style="border-bottom: 1px dashed #CCCCCC;;">ITINERARIO</h5>
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label for="origen">Origen</label>
                                                        <input type="text" class="form-control input-font" id="origen">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="origen">Destino</label>
                                                        <input type="text" class="form-control input-font" id="destino">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="origen">Aerolinea</label>
                                                        <input type="text" class="form-control input-font" id="aerolinea">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="origen">Vuelo</label>
                                                        <input type="text" class="form-control input-font" id="vuelo">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="hora_servicio">Hora de salida</label>
                                                        <div class="input-group">
                                                            <div class="input-group date" id="datetimepicker7">
                                                                <input type="text" class="form-control input-font" id="hora_salida">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label for="hora_servicio">Hora de llegada</label>
                                                        <div class="input-group">
                                                            <div class="input-group date" id="datetimepicker8">
                                                                <input type="text" class="form-control input-font" id="hora_llegada">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 multiple hidden">
                                        <div class="row">
                                            <div class="col-xs-12">
                                            </div>
                                            <div class="rangos">
                                                <div class="col-xs-2">
                                                    <label>Hora de los servicios</label>
                                                    <div class="input-group">
                                                        <div class="input-group date" id="datetimepicker3">
                                                            <input type="text" class="form-control input-font" id="hora_servicios">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label>Fecha inicial</label>
                                                    <div class="input-group">
                                                        <div class="input-group date" id="datetimepicker5">
                                                            <input name="rangos_a" type="text" class="form-control input-font" id="rango_a" value="{{date('Y-m-d')}}">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-calendar">
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label>Fecha final</label>
                                                    <div class="input-group">
                                                        <div class="input-group date" id="datetimepicker6">
                                                            <input name="rangos_b" type="text" class="form-control input-font" id="rango_b">
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-calendar">
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label class="obligatorio" for="notificacion">Notificacion</label>
                                                    <select class="form-control input-font" id="notificacion_multiple">
                                                        <option>-</option>
                                                        <option value="1">SI</option>
                                                        <option value="0">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-1">
                                                <button id="agregar_fecha" style="margin-top: 31px" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                                <button style="margin-top: 31px" class="btn btn-danger hidden"><i class="fa fa-close"></i></button>
                                            </div>
                                            <div class="hora_servicio" id="servicios_horas">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="edicion tab-pane fade" id="ordenes_tab">
                            <div class="row" style="margin-top: 15px">
                                <div class="col-xs-12">
                                    <table style="margin-bottom: 15px;" class="table table-bordered" id="servicios">
                                        <thead>
                                        <tr>
                                            <th>Ruta</th>
                                            <th>Detalle</th>
                                            <th>Recoger en</th>
                                            <th>Dejar en</th>
                                            <th>Fecha de inicio</th>
                                            <th>Hora de inicio</th>
                                            <th>Conductor</th>
                                            <th>Vehiculo</th>
                                            <th>Informacion</th>
                                        </tr>
                                        </thead>

                                        <tfoot>
                                        <tr>
                                            <th>Ruta</th>
                                            <th>Detalle</th>
                                            <th>Recoger en</th>
                                            <th>Dejar en</th>
                                            <th>Fecha de inicio</th>
                                            <th>Hora de inicio</th>
                                            <th>Conductor</th>
                                            <th>Vehiculo</th>
                                            <th>Informacion</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <button id="agregar_mas" class="btn btn-info btn-icon">Agregar mas<i class="fa fa-plus icon-btn"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success btn-icon" id="continuar">Continuar<i class="fa fa-arrow-right icon-btn"></i></a>
                    <a id="programar" class="btn btn-redu btn-icon disabled">Programar<i class="fa fa-play icon-btn"></i></a>
                    <a data-option="2" id="guardar" class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
                    <a data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div>
    </div><!-- /.modal-content -->
</div>

<!---MODAL PARA EDITAR SERVICIOS-->
<div class="modal fade mymodal1" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">EDITAR SERVICIO</h4>
            </div>
            <div class="modal-body tabbable">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#programacion_tab_editar" aria-controls="programacion_editar" id="programacion_editar" role="tab" data-toggle="tab">Programacion de Servicio</a>
                    </li>
                    <li role="presentation">
                        <a href="#ruta_tab_editar" aria-controls="rutas_editar" id="rutas_editar" role="tab" data-toggle="tab">Ruta</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="programacion_tab_editar">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-xs-2">
                                    <label>Fecha de orden</label>
                                    <div class="input-group">
                                        <div class="input-group date" id='datetimepicker1'>
                                            <input type='text' class="form-control input-font fecha_orden" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                    <select class="form-control input-font centro_de_costo">
                                        <option>-</option>
                                        @foreach($centrosdecosto as $centrodecosto)
                                            @if($centrodecosto->inactivo==1)
                                                <option disabled value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                            @else
                                                <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="subcentro">Subcentro de costo</label>
                                    <select class="form-control input-font subcentro">
                                        <option>-</option>
                                    </select>
                                </div>

                                <div class="col-xs-1">
                                    <label class="obligatorio" for="numero_pax"># pax</label>
                                    <select class="form-control input-font" id="numero_pax_editar">
                                        <option selected>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>GRUPO</option>
                                    </select>
                                </div>
                                <div class="col-xs-1 grupo_numero_editar hidden">
                                    <label for="grupo_numero">Cantidad</label>
                                    <select class="form-control input-font" id="grupo_numero_editar">
                                        @for ($i = 1; $i < 201; $i++)
                                            <option>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-xs-2">
                                    <label class="obligatorio" for="departamento">Departamento</label>
                                    <select class="form-control input-font departamento">
                                        <option>-</option>
                                        @foreach($departamentos as $departamento)
                                            <option>{{$departamento->departamento}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                    <select disabled class="form-control input-font ciudad">
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row grupo_de_pasajeros">
                                        <div class="col-xs-3">
                                            <label class="obligatorio" for="pax">Pax</label>
                                            <input type="text" class="form-control input-font nombres">
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="celular">Celular</label>
                                            <input type="text" class="form-control input-font celular">
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="nivel">Nivel</label>
                                            <input type="text" class="form-control input-font nivel">
                                        </div>
                                        <div class="col-xs-3">
                                            <label class="obligatorio" for="email">Email</label>
                                            <input type="text" class="form-control input-font email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                    <input id="solicitado_por" type="text" class="form-control input-font solicitado_por">
                                </div>
                                <div class="col-xs-2">
                                    <label>Fecha de Solicitud</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control input-font fecha_solicitud" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label for="email_solicitante">Email de quien lo solicita</label>
                                    <input type="text" class="form-control input-font email_solicitante">
                                </div>
                                <!--<div class="col-xs-1">
                                    <label for="estado_email">Mail</label>
                                    <select class="form-control input-font estado_email">
                                        <option>-</option>
                                        <option value="1">SI</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="ruta_tab_editar">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <label class="obligatorio" for="ruta">Ruta</label>
                                            <select class="form-control input-font ruta">
                                                <option>-</option>
                                            </select>
                                            <!--<small id="agregar_ruta" class="help-block hidden"><a data-toggle="modal" class="shmodal_agregar" href="#shortModal" href="">Agregar ruta!</a></small>-->
                                            <small id="ruta_alerta" class="help-block hidden"><a class="shmodal_noruta" style="color: #a94442">Centro de costo sin rutas solicite una!</a></small>
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="recoger_en">Recoger en</label>
                                            <input type="text" class="form-control input-font recoger_en">
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="dejar_en">Dejar en</label>
                                            <input type="text" class="form-control input-font dejar_en">
                                        </div>
                                        <div class="col-xs-5">
                                            <label class="obligatorio" for="detalle_recorrido">Detalle del recorrido</label>
                                            <textarea class="form-control input-font detalle_recorrido"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3 proveedor_content">
                                    <label class="obligatorio">Proveedor</label>
                                    <div class="input-group">
                                        <select data-option="1" type="text" class="form-control input-font proveedor">
                                            <option>PROVEEDORES</option>
                                            @foreach($proveedores as $proveedor)
                                                @if($proveedor->inactivo!=1)
                                                    <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="input-group-addon proveedor_eventual" style="cursor: pointer"><i class="fa fa-car"></i></div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="conductor">Conductor</label>
                                    <select class="form-control conductor input-font">
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio" for="vehiculo">Vehiculo</label>
                                    <select class="form-control input-font vehiculo">
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 unico">

                                    <div class="row">
                                        <div class="col-xs-2">
                                            <label for="fecha_servicio">Fecha de servicio</label>
                                            <div class="input-group">
                                                <div class="input-group date" id="datetimepicker2">
                                                    <input type="text" class="form-control input-font fecha_servicio" value="{{date('Y-m-d')}}">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="hora_servicio">Hora de servicio</label>
                                            <div class="input-group">
                                                <div class="input-group date" id="datetimepicker3">
                                                    <input type="text" class="form-control input-font hora_servicio_editar">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-1">
                                            <label class="obligatorio" for="resaltar">Resaltar</label>
                                            <select class="form-control input-font resaltarr">
                                                <option>-</option>
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="resaltar">Pago Directo</label>
                                            <select class="form-control input-font pago_directo_editar">
                                                <option>-</option>
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
	                                          <label class="obligatorio" for="resaltar">Notificacion</label>
	                                          <select class="form-control input-font notificacion_editar">
                                              <option>-</option>
                                              <option value="1">SI</option>
                                              <option value="0">NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-12">
                                            <h5 style="border-bottom: 1px dashed #CCCCCC;">ITINERARIO</h5>
                                            <div class="row">
                                                <div class="col-xs-2">
                                                    <label for="origen">Origen</label>
                                                    <input type="text" class="form-control input-font origen">
                                                </div>
                                                <div class="col-xs-2">
                                                    <label for="origen">Destino</label>
                                                    <input type="text" class="form-control input-font destino">
                                                </div>
                                                <div class="col-xs-2">
                                                    <label for="origen">Aerolinea</label>
                                                    <input type="text" class="form-control input-font aerolinea">
                                                </div>
                                                <div class="col-xs-2">
                                                    <label for="origen">Vuelo</label>
                                                    <input type="text" class="form-control input-font vuelo">
                                                </div>
                                                <div class="col-xs-2">
                                                    <label for="hora_servicio">Hora de salida</label>
                                                    <div class="input-group">
                                                        <div class="input-group date" id="datetimepicker7">
                                                            <input type="text" class="form-control input-font hora_salida">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label for="hora_servicio">Hora de llegada</label>
                                                    <div class="input-group">
                                                        <div class="input-group date" id="datetimepicker8">
                                                            <input type="text" class="form-control input-font hora_llegada">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
			@if(Sentry::getUser()->id_rol==3 or Sentry::getUser()->id_rol==4 or Sentry::getUser()->id_rol==16)
				<!-- Validar si es el lider de Transporte "Juan Pimienta"-->
				@if(Sentry::getUser()->id==3)
					<a id="actualizar_servicio" class="btn btn-info btn-icon">Actualizar<i class="fa fa-refresh icon-btn"></i></a>
				@else
					<a id="autorizar_editar_servicio" class="btn btn-info btn-icon">Actualizar<i class="fa fa-refresh icon-btn"></i></a>
				@endif
			@else
            <a id="actualizar_servicio" class="btn btn-info btn-icon">Actualizar<i class="fa fa-refresh icon-btn"></i></a>
			@endif
            <a data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
        </div>
        </div>
    </div>
</div>

<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

<div id="alert_eliminar" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar <i id="cerrar_alerta_sino" style="float: right; cursor: pointer" class="fa fa-close"></i></div>
            <div class="panel-body">
                <label></label><br>
                <a id="respuesta_si" class="btn-default btn">Si</a>
                <a id="respuesta_no" class="btn-default btn">No</a>
            </div>
        </div>
    </div>
</div>

<div id="motivo_eliminacion" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Escriba las razones por las cuales se va a eliminar este servicio.</label>
                    <textarea id="descripcion_eliminacion" cols="30" rows="10" class="form-control input-font"></textarea>
                </div>
                <a id="realizar" class="btn btn-primary btn-icon">Realizar<i class="fa fa-trash icon-btn"></i></a>
                <a id="cancelar" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
            </div>
        </div>

    </div>
</div>

<div id="motivo_rechazo" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Motivo de Rechazo<i id="cerrar_alerta_sino" style="float: right; cursor: pointer" class="fa fa-close"></i></div>
            <div class="panel-body">
                <div class="form-group">
                    <textarea disabled id="input_motivo_rechazo" cols="30" rows="10" class="form-control input-font"></textarea>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 style="display: inline-block" class="modal-title" id="myModalLabel">TRACKING GPS</h4>
                <div class="hidden" id="estado_servicio_modal"></div>
            </div>
            <div class="modal-body tabbable">
              <div id="map" style="overflow-y: auto; height: 500px;"></div>

            </div>
            <div class="modal-footer">
                <label id="label_hora_inicio" class="hidden" style="float: left; margin-top: 5px; font-size: 12px; margin-right: 20px;">HORA INICIAL<div class="label_timestamp" id="hora_estado_inicio"></div></label>
                <label id="label_hora_final" class="hidden" style="float: left; margin-top: 5px; font-size: 12px;">HORA FINAL<div class="label_timestamp" id="hora_estado_final"></div></label>
                <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
            </div>
        </div>
    </div>
</div>

@if(Sentry::getUser()->coordinador===1)
    <div id="modal-activar-reconfirmacion">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Reconfirmacion
                    <i id="cerrar_alerta_sino" style="cursor: pointer; float: right; font-weight:100" class="fa fa-close"></i>
                </div>
                <div class="panel-body">
                    <label>Desea activar la reconfirmacion?</label><br>
                    <a id="activar_reconfirmacion" data-option="4" class="btn-success btn"><div style="vertical-align: super;display: inline-block;">Si</div> <i class="fa fa-2x fa-smile-o"></i></a>
                    <a id="cerrar_ventana_reconfirmacion" class="btn-danger btn"><div style="vertical-align: super;display: inline-block;">No</div> <i class="fa fa-2x fa-frown-o"></i></a>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="documentacion_conductor hidden">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>DOCUMENTACION DEL CONDUCTOR</strong>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fvencimiento" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
            </li>
          </ul>
          <button type="button" class="btn btn-primary btn-block ok">
            OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
</div>

<div class="documentacion_vehiculo hidden">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>DOCUMENTACION DEL VEHICULO</strong>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item">
            <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
          </li>
          <li class="list-group-item">
            <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
          </li>
          <li class="list-group-item">
            <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
          </li>
          <li class="list-group-item">
            <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
          </li>
          <li class="list-group-item">
            <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
          </li>
          <li class="list-group-item">
            <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
          </li>
          <li class="list-group-item">
            <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
            <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
          </li>
        </ul>
        <button type="button" class="btn btn-primary btn-block ok">
          OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade mdl_alertas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-medium">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>LISTADO DE COTIZACIONES</strong>
            </div>
            <div class="modal-body">
                <div id="alertas_vigencia" style="overflow-y: auto; height: 400px;">

					<table id="tabla_cotizaciones" class="table table-bordered hover tabla">
						<thead>
						  <tr>

							<th>Fecha</th>
							<th>Nombre completo</th>
							<th>Tipo</th>
							<th>Estado</th>
							<th></th>
						  </tr>
						</thead>
						<tbody>
						  @if(isset($cotizaciones))
							@foreach($cotizaciones as $cotizacion)
							  <tr>
								<td><label title="Vence: {{$cotizacion->fecha_vencimiento}}">{{$cotizacion->fecha}}</label></td>
								<td><label title="Vendedor: {{$cotizacion->vendedor}} Contacto: {{$cotizacion->contacto}}">{{$cotizacion->nombre_completo}}</label></td>

								<?php
								  $tipo = '';
								  if(intval($cotizacion->tipo)===1){
									$tipo = 'TRANSPORTE';
								  }elseif(intval($cotizacion->tipo)===2){
									$tipo = 'TURISMO';
								  }elseif(intval($cotizacion->tipo)===3){
									$tipo = 'AMBAS';
								  }
								?>
								<td>{{$tipo}}</td>
								<td>
									@if(intval($cotizacion->estado)===1)
									APROBADO
										@if($cotizacion->contenido_html === null || $cotizacion->contenido_html==='')
										<a class="btn btn-list-table btn-default prog_serv" style="float: right;" title="Programar Servicio" data-toggle="modal" data-target=".mymodal"><i class="fa fa-car" aria-hidden="true"></i></a>
										@endif
									@endif

									@if(intval($cotizacion->estado)===2)
									EN NEGOCIACION
									@endif

									@if(intval($cotizacion->estado)===3)
									RECHAZADO
									@endif

									@if(intval($cotizacion->estado)===4)
									VENCIDO
									@endif

									@if(intval($cotizacion->estado)===5)
									SIN GESTION
									@endif
								</td>
								<td>
								@if($cotizacion->contenido_html != null || $cotizacion->contenido_html !='')
								  <a href="{{url('cotizaciones/exportarcotizacion/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger" title="Exportar">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
								@else
									<a href="{{url('cotizaciones/exportarcot/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger" title="Exportar">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
								@endif

								</td>
							  </tr>
							@endforeach
						  @endif
						</tbody>
					</table>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a> -->
            </div>
        </div>
    </div>
</div>

@include('scripts.scripts')

<!--solo para area de transportes se coloca la notificacion -->
@if(Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 4 || Sentry::getUser()->id_rol === 10 || Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 11 || Sentry::getUser()->id_rol === 16)
  <script src="{{url('boostrap_notify/bootstrap-notify.min.js')}}"></script>
  <script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-messaging.js"></script>
  <script src="{{asset('firebase_init.js')}}"></script>
  <script>

	  // Retrieve Firebase Messaging object.
	  const messaging = firebase.messaging();

	  navigator.serviceWorker.register('firebase-messaging-sw.js')
    .then((registration) => {
	    messaging.useServiceWorker(registration);

	    messaging.requestPermission()
	    .then(function() {
	      console.log('Notification permission granted.');

	      messaging.getToken()
	      .then(function(token) {

	        $.ajax({
	          url: '{{url('transportes').'/registraridweb'}}',
	          method: 'post',
	          data: {
	              token: token
	          },
	          type: 'json'
	        }).done(function(data){
	          console.log(data.respuesta);
	        });

	      }).catch(function(err) {
	        console.log('Unable to retrieve token ', err);
	        showToken('Unable to retrieve token ', err);
	      });


	    })
	    .catch(function(err) {
	      console.log('Unable to get permission to notify.', err);
	    });
	  });

	  messaging.onTokenRefresh(function() {
	    messaging.getToken()
	    .then(function(refreshedToken) {
	      console.log('Token refreshed.');
	    })
	    .catch(function(err) {
	      console.log('Unable to retrieve refreshed token ', err);
	      showToken('Unable to retrieve refreshed token ', err);
	    });
	  });

	  messaging.onMessage(function(payload) {
	    console.log(payload);
	    $.notify({
	    	message: payload.notification.body,
	    	url: '{{url('transportes/serviciosporaceptar')}}',
	    	target: '_blank'
	    },{
	      type: payload.data.tipo_notificacion,
	      animate: {
	    		enter: 'animated bounceInRight',
	    		exit: 'animated bounceOutRight'
	  	  },
	      newest_on_top: true,
	      mouse_over: 'pause',
	      delay: 1000,
	  	  timer: 180000,
	    });
	  });

	</script>
@endif

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/servicios.js')}}"></script>

@if(Sentry::getUser()->coordinador===1)
<script>
    $('#modal-activar-reconfirmacion')
        .animate({
          opacity: 1,
    },2000);
</script>
@endif

<script>
  //inicializar variables
  var $trackingGps = null;
  var map = null;
  var markers = [];
  var trazadoRuta = null;
  var markerFinal = null;

  $('input[type=file]').bootstrapFileInput();
  $('.file-inputs').bootstrapFileInput();

  function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }

  function clearMarkers() {
    setMapOnAll(null);
  }

  function deleteMarkers() {
    clearMarkers();
    markers = [];
  }

  function iniciarMapa(id){

    if (!$('#label_hora_inicio').hasClass('hidden')) {
      $('#label_hora_inicio').addClass('hidden');
    }

    if (!$('#label_hora_final').hasClass('hidden')) {
      $('#label_hora_final').addClass('hidden');
    }

    $.ajax({
        url: 'transportes/servicioruta',
        data: {
          id: id
        },
        method: 'post',
        dataType: 'json',
        success: function(data){

            if (data.respuesta===true) {

              var contadorPosicion = 0;

              //array para polilineas
              var polyLinesRuta = [];

              //objecto para guardar las coordenadas y timestamps
              var posiciones = JSON.parse(data.servicio.recorrido_gps);

              //estado del servicio 1 iniciado, 2 finalizado
              var estado_servicio_app = data.servicio.estado_servicio_app;

              //hora inicial
              var timestamp_inicial = posiciones[0].timestamp;

              //cantidad de posiciones (marcadores)
              var cantidad = posiciones.length;

              //hora final
              var timestamp_final = posiciones[cantidad-1].timestamp;

              //div de los estados, en servicio o finalizado
              var $divEstado = $('#estado_servicio_modal');

              var bounds = new google.maps.LatLngBounds();

              //si el servicio esta en proceso (iniciado)
              if (parseInt(estado_servicio_app)===1) {

                  //coloca hora inicial
                  $('#hora_estado_inicio').text(timestamp_inicial);

                  $('#label_hora_inicio').removeClass('hidden');

                  $divEstado.text('EN SERVICIO').addClass('estado_en_servicio').removeClass('estado_en_finalizado');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }

              //si el servicio esta finalizado
              }else if(parseInt(estado_servicio_app)===2){

                  //colocar hora inicial y hora final
                  $('#hora_estado_inicio').text(timestamp_inicial);
                  $('#hora_estado_final').text(timestamp_final);

                  $('#label_hora_inicio').removeClass('hidden');
                  $('#label_hora_final').removeClass('hidden');

                  $divEstado.text('FINALIZADO').addClass('estado_en_finalizado').removeClass('estado_en_servicio');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }
              }

              setTimeout(function(){

                //eliminar marcadores
                deleteMarkers();

                var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                //insertar primera polilinea
                var primeraPolyline = {
                  lat: parseFloat(posiciones[0].latitude),
                  lng: parseFloat(posiciones[0].longitude)
                };

                polyLinesRuta.push(primeraPolyline);

                //opciones para inicio de google maps
                var mapOptions = {
                    center: latLong,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true
                };

                //icon aotour google maps
                var icon = {
                    url: 'img/marker3.png', // url
                    scaledSize: new google.maps.Size(50, 50), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                }

                //si la variable mapa esta vacia, iniciarla
                if (map===null) {
                  map = new google.maps.Map(document.getElementById("map"), mapOptions);
                }

                //si se han iniciado las polilineas limpiarlas
                if (trazadoRuta!=null) {
                  trazadoRuta.setMap(null);
                }

                //marcador inicial
                var marker = new google.maps.Marker({
                  position: latLong,
                  map: map,
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: 'img/marker3.png',
                    scaledSize: new google.maps.Size(40, 40)
                  },
                  zIndex: 5000
                });

                //contar primer punto
                contadorPosicion++;

                bounds.extend(marker.position);

                markers.push(marker);

                //colocar polilineas
                for (var i in posiciones) {

                    if (i>0 && i<cantidad) {

                      position = {
                        lat: parseFloat(posiciones[i].latitude),
                        lng: parseFloat(posiciones[i].longitude)
                      }

                      polyLinesRuta.push(position);

                      var latLong = new google.maps.LatLng(posiciones[i].latitude, posiciones[i].longitude);

                      bounds.extend(position);

                      //contar puntos
                      contadorPosicion++;

                    }

                }

                if (cantidad>=2) {

                  //polilinea final
                  var finalPolyline = {
                    lat: parseFloat(posiciones[cantidad-1].latitude),
                    lng: parseFloat(posiciones[cantidad-1].longitude)
                  };

                  polyLinesRuta.push(finalPolyline);

                  var latLong = new google.maps.LatLng(posiciones[cantidad-1].latitude, posiciones[cantidad-1].longitude);

                  //marcador final
                  markerFinal = new google.maps.Marker({
                    position: latLong,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: 'img/marker3-final.png',
                      scaledSize: new google.maps.Size(40, 40)
                    },
                    zIndex: 5000
                  });

                  bounds.extend(markerFinal.position);

                  markers.push(markerFinal);

                }else{

                  var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                  markerFinal = new google.maps.Marker({
                    position: latLong,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: 'img/marker3-final.png',
                      scaledSize: new google.maps.Size(40, 40)
                    },
                    zIndex: 4000
                  });

                  markers.push(markerFinal);
                }

                //trazar ruta con las polylineas
                trazadoRuta = new google.maps.Polyline({
                  path: polyLinesRuta,
                  geodesic: true,
                  strokeColor: '#eb7901',
                  strokeOpacity: 1.0,
                  strokeWeight: 4,
                  editable: false
                });

                //agregar al mapa
                trazadoRuta.setMap(map);

                map.fitBounds(bounds);

              }, 1500);

              if (estado_servicio_app!=2) {

                $trackingGps = setInterval(function(){

                    $.ajax({
                      url: 'transportes/actualizarmapa',
                      method: 'post',
                      data: {
                        id: id
                      }
                    }).done(function(data){

                      var nuevas_posiciones = JSON.parse(data.servicio);

                      for (var i in nuevas_posiciones) {

                        if (i>(contadorPosicion-1)) {

                          position = {
                            lat: parseFloat(nuevas_posiciones[i].latitude),
                            lng: parseFloat(nuevas_posiciones[i].longitude)
                          }

                          polyLinesRuta.push(position);

                          trazadoRuta.setPath(polyLinesRuta);

                          bounds.extend(position);

                          map.fitBounds(bounds);

                          contadorPosicion++;

                        }

                      }

                      if (contadorPosicion>1) {
                          markerFinal.setPosition(new google.maps.LatLng(nuevas_posiciones[contadorPosicion-1].latitude, nuevas_posiciones[contadorPosicion-1].longitude));
                      }

                    }).fail(function(data){
                        alert('Hubo un error en la conexion');
                    });



                }, 3000);

              }

            }else if (data.respuesta==='relogin') {
                location.reload();
            }
        }
    });

  }

  $('#example').on('click', '.ruta_mapa', function(){

    var id = $(this).attr('data-id');
    iniciarMapa(id);

  });

  //detener el trackingGps cuando cierran la ventana modal
  $('.mymodal4').on('hidden.bs.modal', function (e) {
      clearInterval($trackingGps);
  });

</script>

<script type="text/javascript">

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);

    }
    window.onunload=function(){
    window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

    function nobackbutton(){

       window.location.hash="no-back-button";

       window.location.hash="Again-No-back-button" //chrome

       window.onhashchange=function(){
         window.location.hash="no-back-button";
       }
    }

</script>
</body>
</html>
