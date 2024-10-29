<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Rutas BOG</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      [data-notify="progressbar"] {
	      	margin-bottom: 0px;
	      	position: absolute;
	      	bottom: 0px;
	      	left: 0px;
	      	width: 100%;
	      	height: 5px;
      }

    </style>
</head>

<body onload="nobackbutton();">
@include('admin.menu')

<div class="col-lg-12">
    <h3 class="h_titulo">PROGRAMACION DE RUTAS</h3>

    @if($permisos->bogota->servicios->creacion==='on')
        <button style="margin-bottom: 7px" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
            SERVICIO<i class="fa fa-plus icon-btn"></i>
        </button>
        <a style="margin-bottom: 7px" class="btn btn-default btn-icon" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            RUTA<i class="fa fa-plus icon-btn"></i>
        </a>

         <a style="margin-bottom: 7px; background-color: #FF8000; color: white" class="btn btn-default btn-icon" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal22">
            RUTA QR <i class="fa fa-qrcode" style="font-size:15";></i><i class="fa fa-plus icon-btn"></i>
        </a>
    @endif
	<!-- <a class="btn btn-warning btn-list-table listado_cotizaciones" style="padding: 6px 6px; float: right; margin-right: 50px;" data-toggle="modal" data-target=".mdl_alertas">COTIZACIONES
		<i class="fa fa-envelope-o"><span style="padding: 0 4px;" class="badge"><?php echo count($cotizaciones); ?></span></i>
	</a> -->
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
                        <option value="0">RUTAS</option>
                        <option value="3">NO LIQUIDADOS</option>
                        <option value="4">NO FACTURADOS</option>
                        <option value="5">PAGO DIRECTO</option>
                        <option value="6">ENCUESTADO</option>
                        <option value="7">SERVICIOS NO AUTORIZADOS</option>
                        <option value="8">NO FINALIZADOS</option>
						            <option value="9">NO SHOW</option>
                        <option value="10">HABILITADOS POR FACTURACION</option>
                        <option value="11">NO ACEPTADOS EN LA APP</option>
                    </select>
                </div>
                <div class="input-group proveedor_content">
                  <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
                    <option value="0">PROVEEDORES</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                    @endforeach
                  </select>
                  <span style="cursor: pointer" class="input-group-addon proveedor_eventual"><i class="fa fa-car"></i></span>
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
                            <option value="{{$usuario->id}}">{{trim($usuario->first_name).' '.trim($usuario->last_name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                </div>
                <button id="buscar" class="btn btn-default btn-icon">
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
              <th>Solicitante / Fecha</th>
              <th>Traslado / Nombre ruta</th>
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
                <th>Solicitante / Fecha</th>
                <th>Traslado / Nombre ruta</th>
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
                      <a title="{{$servicio->nombre_ruta}}" href>{{$servicio->codigo_ruta}}</a>
                      @if ($servicio->nombre)
                        <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                        <a title="{{$servicio->nombre}}" href>{{$servicio->nombre}}</a>
                      @endif
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
                    <td><small title="barrios">{{$servicio->detalle_recorrido}}</small></td>
                    <td>
                      <?php

                        if ($servicio->ruta!=null) {
								                  //si es RUTA
                              $pax = explode('/',$servicio->pasajeros);

                              for ($i=0; $i < count($pax); $i++) {
                                  $pasajeros[$i] = explode(',', $pax[$i]);
                              }

                              for ($i=0; $i < count($pax)-1; $i++) {

                                  for ($j=0; $j < count($pasajeros[$i]); $j++) {

                  								if ($j===0) {
                  									$nombre = $pasajeros[$i][$j];
                  								}

                  								if ($j===1) {
                  									$celular = $pasajeros[$i][$j];
                  								}

                  								if ($j===2) {
                  									$email = $pasajeros[$i][$j];
                  								}

                  								if ($j===3) {
                  									$nivel = $pasajeros[$i][$j];
                  								}

                  							}

                  							if (!isset($celular)){
                  								$celular = "";
                  							}

                  							if (!isset($nombre)){
                  								$nombre = "";
                  							}

                                    echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';


                              }
                              echo '<a title="Ver Listado" data-id="'.$servicio->id.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

                        }else{

                              $pax = explode('/',$servicio->pasajeros);

                              for ($i=0; $i < count($pax); $i++) {
                                  $pasajeros[$i] = explode(',', $pax[$i]);
                              }

                              for ($i=0; $i < count($pax)-1; $i++) {

                                  for ($j=0; $j < count($pasajeros[$i]); $j++) {

                										if ($j===0) {
                											$nombre = $pasajeros[$i][$j];
                										}

                										if ($j===1) {
                											$celular = $pasajeros[$i][$j];
                										}

                										if ($j===2) {
                											$email = $pasajeros[$i][$j];
                										}

                										if ($j===3) {
                											$nivel = $pasajeros[$i][$j];
                										}

                                  }
                                  if (isset($celular)){
                                      echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';
                                  }else{
                                      echo '<a>'.$nombre.'</a><br>';
                                  }

                              }

                        }

                        ?>
                    </td>
                    <td>
                        <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonproveedor}}</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                        <a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
                    </td>
                    <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                    <td><span class="bolder">@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}} @else {{$servicio->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}@endif</span></td>
                    <td>{{$servicio->first_name.' '.$servicio->last_name}}</td>
                    <td>
                      <?php

                          $novedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion',$servicio->id)->get();

                          if (intval($servicio->facturado)===1) {

                              echo '<small class="text-info">FACTURADO</small><br>';
                              $numero_factura = DB::table('ordenes_facturacion')->where('id',$servicio->factura_id)->first();
                              echo '<small class="text-info bolder">ORDEN:'.$numero_factura->numero_factura.'</small><br>';

                          }else{

                              $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

                              if ($servicio->id_reconfirmacion!=null) {

                                  if ($servicio->ejecutado===1) {
                                      echo '<small class="text-info">EJECUTADO</small><br>';
                                  }else{
                                      echo '<small class="text-success">PROGRAMADO</small><br>';
                                  }
                              }else{
                                  echo '<small class="text-success">PROGRAMADO</small><br>';
                              }

                              if (intval($servicio->revisado)===1) {
                              echo '<small class="text-warning">REVISADO</small><br>';
                              }
                              if (intval($servicio->liquidado)===1) {
                                  echo '<small class="text-danger">LIQUIDADO</small><br>';
                              }
                              if (intval($servicio->facturado)!=1) {
                                  echo '<small style="color: #EC0000">SIN FACTURAR</small>';
                              }

                              if (intval($servicio->estado_servicio_app)===1) {
                                  echo '<div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 69px; border-radius: 2px;">EN SERVICIO</div>';
                              }else if(intval($servicio->estado_servicio_app)===2){
                                  echo '<div class="estado_servicio_app" style="background: #eaeaea; color: #313131; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 69px; border-radius: 2px;">FINALIZADO</div>';
                              }else{
                                  echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 69px; border-radius: 2px;">NO INICIADO</div>';
                                  if (intval($servicio->aceptado_app)===0) {
                                      echo '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 70px; border-radius: 2px;">NO ACEPTADO</div>';
                                  }else if(intval($servicio->aceptado_app)===3){
                                    if(intval($servicio->estado_rechazo)===1){
                                      $rec = '<b>SD</b>';
                                    }else if(intval($servicio->estado_rechazo)===2){
                                      $rec = '<b>TI</b>';
                                    }else if(intval($servicio->estado_rechazo)===3){
                                      $rec = '<b>NP</b>';
                                    }else{
                                      $rec = '';
                                    }

                                      echo '<div class="estado_servicio_app" style="background: #5B5B5B; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 70px; border-radius: 2px;">RECHAZADO<br>'.$rec.'</div>';

                                  }else if(intval($servicio->aceptado_app)===1){
                                      echo '<div class="estado_servicio_app" style="background: #0ACEFE; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 70px; border-radius: 2px;">ACEPTADO</div>';
                                  }
                              }
                          }

                          if ($servicio->id_pivote!=null) {
                              echo '<br><small class="text-primary">EDITADO</small>';
                          }

                          if ($novedades!=null) {
                              echo '<br><small class="text-danger">NOVEDAD</small>';
                          }

                          if ($servicio->id_reporte!=null) {
                              echo '<br><small class="text-warning">REPORTE</small>';
                          }

                          if (intval($servicio->pago_directo)===1) {

              							if(Sentry::getUser()->id_rol === 5 || Sentry::getUser()->id_rol === 6 || Sentry::getUser()->id_rol === 1){
              								echo '<br><a class="bolder recibir_pago" data-idpag="'.$servicio->id.
                              '" style="cursor: pointer;">PAGO DIRECTO </a>';
              							}else{
              									echo '<br><small class="bolder">PAGO DIRECTO</small>';
            								}

                          }elseif(intval($servicio->pago_directo)===2){
                    				echo '<br><small class="bolder" title="RECIBIDO">PAGO DIREC.<i class="glyphicon glyphicon-ok text-success"></i></small>';
                    			}

                          if (intval($servicio->finalizado)===1) {
                              echo '<br><small class="text-success bolder">FINALIZADO</small>';
                          }

                          if(intval($servicio->pendiente_autori_eliminacion)===1){
                            echo '<br><small class="bolder" style="color: #f0ad4e;">PROGRAMADO PARA ELIMINAR</small>';
                          }

                          if(intval($servicio->rechazar_eliminacion)===1){
                              echo '<br><div data-id="'.$servicio->id.'" class="bolder btn-rechazado">RECHAZADO</div>';
                          }

                          if($servicio->documento_pdf1 != null){

              							echo'<br><br><a href="biblioteca_imagenes/servicios_autorizados/'.$servicio->documento_pdf1.'" target="_blank">Solicitud_PDF</a><br>';
              						}
              						if($servicio->documento_pdf2 != null){
              							echo'<a href="biblioteca_imagenes/servicios_autorizados/'.$servicio->documento_pdf2.'" target="_blank">Correo_PDF</a><br>';

              						}

                        if(intval($servicio->ruta_qr)===1){
                              echo '<i class="fa fa-qrcode" style="font-size:35; margin: 2px 0 0 20px"></i><br>';
                          }                ?>
                    </td>
                    <td class="opciones text-center">

                        <?php

                            $rutaMapa = intval($servicio->estado_servicio_app);
                            $valorCalificacion = 0;
                            $letraCalificacion = '';
                            $clasemodificacion = '';

                            if($permisos->bogota->encuesta->ver==='on'):
                                if ($servicio->pregunta_1!=null):

                                if ($servicio->pregunta_1==1):
                                    $valorCalificacion = $valorCalificacion + 4.5;
                                elseif ($servicio->pregunta_1==2):
                                    $valorCalificacion = $valorCalificacion + 1.5;
                                endif;

                                if ($servicio->pregunta_2==1):
                                    $valorCalificacion = $valorCalificacion + 4.5;
                                elseif ($servicio->pregunta_2===2):
                                    $valorCalificacion = $valorCalificacion + 1.5;
                                endif;

                                if ($servicio->pregunta_3===1):
                                    $valorCalificacion = $valorCalificacion + 4.5;
                                elseif ($servicio->pregunta_3==2):
                                    $valorCalificacion = $valorCalificacion + 1.5;
                                endif;

                                if ($servicio->pregunta_4==1):
                                    $valorCalificacion = $valorCalificacion + 4.5;
                                elseif ($servicio->pregunta_4==2):
                                    $valorCalificacion = $valorCalificacion + 1.5;
                                endif;

                                $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_8);
                                $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_9);
                                $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_10);

                                if ($valorCalificacion>0 && $valorCalificacion<=10):
                                    $clasemodificacion = 'danger';
                                    $letraCalificacion = 'M';
                                elseif ($valorCalificacion>=11 && $valorCalificacion<=20):
                                    $clasemodificacion = 'warning';
                                    $letraCalificacion = 'R';
                                elseif ($valorCalificacion>=21 && $valorCalificacion<=27):
                                    $clasemodificacion = 'yellow';
                                    $letraCalificacion = 'A';
                                elseif ($valorCalificacion>=28 && $valorCalificacion<=32):
                                    $clasemodificacion = 'success';
                                    $letraCalificacion = 'B';
                                elseif ($valorCalificacion>=32 && $valorCalificacion<=35):
                                    $clasemodificacion = 'info';
                                    $letraCalificacion = 'E';
                                endif;

                                echo '<a data-toggle="modal" style="margin-top: 5px; margin-bottom: 5px; padding: 5px 6px;" class="btn btn-'.$clasemodificacion.
                                     '"><i class="fa fa-file-text"></i><br>'.$letraCalificacion.'</a>';
                            endif;
                            endif;
                            /**
                             * PERMISOS PARA EDITAR SERVICIOS
                             */
                            if($permisos->bogota->servicios->edicion==='on'){
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
                            if($permisos->bogota->servicios->eliminacion==='on'){

                                $btnProgactivado = '<a id="'.$servicio->id.'" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion">'.
                                        '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                            }else{
                                $btnProgactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion disabled">'.
                                        '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                            }

                            $btnProgdesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning disabled">'.
                                    '<i class="fa fa-ban" aria-hidden="true"></i></a>';
                        ?>
                        <!-- SI EL SERVICIO ESTA PENDIENTE POR ELIMINAR ENTONCES -->
                        @if($servicio->rechazar_eliminacion==1)
                            {{$btnEditardesactivado.$btnProgdesactivado}}
                        @elseif($servicio->pendiente_autori_eliminacion==1)
                            {{$btnEditardesactivado.$btnProgdesactivado}}
                        <!-- SI EST FACTURADO ENTONCES -->
                        @elseif($servicio->facturado==1)
                        {{-- SI EL USUARIO ES ADMINISTRADOR O GERENTE --}}
                            @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12)
                                {{$btnEditaractivado.$btnProgdesactivado}}
                            @else
                                {{$btnEditardesactivado.$btnProgdesactivado}}
                            @endif
                        <!-- SI ESTA REVISADO Y ESTA EN FACTURACION PUEDE SER EDITADO Y ELIMINADO POR FACTURACION -->
                        @elseif($servicio->liquidado==1)
                        <!-- SI EL USUARIO ES ADMINISTRADOR O GERENTE O FACTURACION -->
                            @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
                                {{$btnEditaractivado.$btnProgactivado}}
                            @else
                                {{$btnEditardesactivado.$btnProgdesactivado}}
                            @endif
                        <!-- SI ESTA REVISADO Y ESTA EN FACTURACION PUEDE SER EDITADO Y ELIMINADO POR FACTURACION -->
                        @elseif($servicio->revisado==1)
                            @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
                                {{$btnEditaractivado.$btnProgactivado}}
                            @else
                                {{$btnEditardesactivado.$btnProgdesactivado}}
                            @endif
                        <!-- SI ESTA REVISADO Y ESTA ES COORDINADOR PUEDE SER EDITADO PERO NO PUEDE SER ELIMINADO POR COORDINADORES -->
                        @else
                            {{$btnEditaractivado.$btnProgactivado}}
                        @endif
                        @if($rutaMapa!=null)
                          <a data-toggle="modal" data-target=".mymodal4" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px;" class="btn btn-success ruta_mapa">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                          </a>
                        @endif
                        <a style="padding: 6px 6px;" class="btn btn-info enviar_notification" data-id="{{$servicio->id}}" title="Enviar Notificacion APP"><i class="fa fa-info-circle"></i></a>
                    </td>
                    <td>
                    {{-- PERMISO PARA VER RECONFIRMACION --}}
                    @if($permisos->bogota->reconfirmacion->ver==='on')
                        <a style="margin-bottom:5px" class="@if($servicio->cancelado===1)disabled @endif btn btn-default" href="{{url('transportesbog/reconfirmacion/'.$servicio->id)}}">

                          <?php

                          //ESTE CODIGO SE PUEDE OPTIMIZAR HACIENDO LA BUSQUEDA POR LEFT JOIN EN LA CONSULTA ORIGINAL
                          $i=0;

                          $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

                          if(isset($reconfirmacion)){

                              if ($reconfirmacion->numero_reconfirmaciones<=2) {
                                  echo '<span class="text-danger">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }else if($reconfirmacion->numero_reconfirmaciones>=3 and $reconfirmacion->numero_reconfirmaciones<=4){
                                  echo '<span class="text-info">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===5) {
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===6){
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===7){
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }

                          }else{
                              echo 'VER';
                          }

                          ?>
                        </a><BR>
                        <a style="color: white !important" href="{{url('transportesbog/reconfirmacion/'.$servicio->id)}}" class="hora_reconfirmacion hidden"></a>
                    @else
                        <a style="margin-bottom:5px" class="disabled btn btn-default">

                            <?php

                            //ESTE CODIGO SE PUEDE OPTIMIZAR HACIENDO LA BUSQUEDA POR LEFT JOIN EN LA CONSULTA ORIGINAL
                            $i=0;

                            $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

                            if(isset($reconfirmacion)){

                                if ($reconfirmacion->numero_reconfirmaciones<=2) {
                                    echo '<span class="text-danger">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }else if($reconfirmacion->numero_reconfirmaciones>=3 and $reconfirmacion->numero_reconfirmaciones<=4){
                                    echo '<span class="text-info">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($reconfirmacion->numero_reconfirmaciones===5) {
                                    echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($reconfirmacion->numero_reconfirmaciones===6){
                                    echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                                }elseif ($reconfirmacion->numero_reconfirmaciones===7){
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

    <!-- NEW -->
</div>

@include('modales.rutas.nuevo_servicio_rutabog')

@include('modales.rutas.editar_serviciobog')

@include('modales.rutas.nueva_rutabog')

@include('modales.rutas.nueva_rutaqrbog')

<!---MODAL PARA EDITAR PASAJEROS DE RUTAS-->
<div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-rutas" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">DATOS DE PASAJEROS</h4>
            </div>
            <div class="modal-body tabbable">
                <table style="margin-bottom: 15px;" id="pax_info" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>NOMBRES</td>
                            <td>EMPLOY ID</td>
                            <td>TELÉFONO</td>
                            <td>DIRECCION</td>
                            <td>BARRIO</td>
                            <td>LOCALIDAD</td>
                            <td>CIUDAD</td>
                            <td>CAMPAÑA</td>
                            <td>HORARIO</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <a class="btn btn-info btn-icon" id="agregar_pax_ruta">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
            </div>
            <div class="modal-footer">
                <a class="btn btn-success btn-icon boton_excel_exportar">EXPORTAR<i class="fa fa-file-excel-o icon-btn"></i></a>
                <a class="btn btn-primary btn-icon boton_pax_guardar">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
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

<!--<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
</div>-->

<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 100%">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!--<center><h4 style="display: inline-block" class="modal-title" id="myModalLabel">TRACKING GPS</h4></center>-->
                <center><div class="hidden" id="estado_servicio_modal" style="background: #4CAF50; color: white; margin: 2px 0px; font-size: 20px; padding: 3px 5px; width: 140px; border-radius: 2px"></div></center>
                <label id="label_hora_inicio" class="hidden" style="color: black; float: left; margin-top: 5px; font-size: 12px; margin-right: 20px;">HORA INICIAL<div class="label_timestamp" id="hora_estado_inicio"></div></label>
                <label id="label_hora_final" class="hidden" style="color: black; float: right; margin-top: 5px; font-size: 12px;">HORA FINAL<div class="label_timestamp" id="hora_estado_final"></div></label>
            </div>
            <div class="modal-body tabbable">
              <div id="map" style="overflow-y: auto; height: 650px;"></div>

            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-lg-3">


                </div>
                <div class="col-lg-6">
                  <center><div class="hidden" id="estado_servicio_modal" style="background: gray; color: white; margin: 2px 0px; font-size: 20px; padding: 3px 5px; width: 140px; border-radius: 2px"></div></center>
                  <center><div class="estado_servicio_app letrero" style="background: #f47321; color: white; margin: 2px 0px; font-size: 25px; padding: 3px 5px; width: 95%; border-radius: 6px;"><b class="estado_mensaje parpadea">...</b></div></center>
                </div>
                <div class="col-lg-3">
                  <!--<a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>-->
                </div>
              </div>
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
                    <a id="activar_reconfirmacion" class="btn-success btn"><div style="vertical-align: super;display: inline-block;">Si</div> <i class="fa fa-2x fa-smile-o"></i></a>
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
@if(Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 4 || Sentry::getUser()->id_rol === 10 || Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 11 || Sentry::getUser()->id_rol === 16){
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
          url: '{{url('transportesbog').'/registraridweb'}}',
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
    	url: '{{url('transportesbog/serviciosporaceptar')}}',
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
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/rutas_transportebog.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=marker&v=beta" defer ></script>

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
        url: 'transportesbog/servicioruta',
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
                    disableDefaultUI: true,
                    styles: [
                        {
                            "featureType": "water",
                            "stylers": [
                                {
                                    "saturation": 43
                                },
                                {
                                    "lightness": -11
                                },
                                {
                                    "hue": "#0088ff"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "hue": "#ff0000"
                                },
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 99
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.stroke",
                            "stylers": [
                                {
                                    "color": "#808080"
                                },
                                {
                                    "lightness": 54
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ece2d9"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ccdca1"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#767676"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.stroke",
                            "stylers": [
                                {
                                    "color": "#ffffff"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.natural",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "color": "#EBE5E0"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.sports_complex",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ]
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

                for(var o in data.usuarios) {

                  var posisionesss =  JSON.parse(data.usuarios[o].coords);
                  var name = data.usuarios[o].fullname+' - '+data.usuarios[o].address;
                  var hasta = {
                    lat: parseFloat(posisionesss[0].lat),
                    lng: parseFloat(posisionesss[0].lng)
                  }

                  var ids = data.usuarios[o].id;

                  ids = new google.maps.Marker({
                    position: hasta,
                    map: map,
                    title: name,
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                      url: "{{url('img/marker_pasajero_recogido.png')}}",
                      scaledSize: new google.maps.Size(40, 40)
                    },
                    //zIndex: 5000
                  });
                }

                if(data.servicio.tipo_ruta==1){ //RUTA DE INGRESO

                  var positions =  JSON.parse(data.servicio.hasta);

                  var hasta = {
                    lat: parseFloat(positions[0].lat),
                    lng: parseFloat(positions[0].lng)
                  }

                  var marcadorss = new google.maps.Marker({
                      position: hasta,
                      map: map,
                      title: 'Lugar de Destino',
                      animation: google.maps.Animation.BOUNCE,
                      icon: {
                        url: "{{url('img/marker_bandera.png')}}",
                        scaledSize: new google.maps.Size(40, 40)
                      },
                      //zIndex: 5000
                    });

                    //INFO WINDOW
                    var contenidoss = '<div id="content">'+
                    '<h4>Lugar de Destino</h4>'
                    '</div>';

                    var infowindowss = new google.maps.InfoWindow({
                      content: contenidoss
                    });

                    marcadorss.addListener('click', function() {
                      infowindowss.open(map, marcadorss);
                    });

                }else{ //RUTA DE SALIDA

                }

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
                      url: 'img/car.png',
                      scaledSize: new google.maps.Size(70, 60)
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
                      url: 'img/car.png',
                      scaledSize: new google.maps.Size(70, 60)
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

                          //bounds.extend(position);

                          //map.fitBounds(bounds);

                          contadorPosicion++;

                        }

                      }

                      if (contadorPosicion>1) {
                          markerFinal.setPosition(new google.maps.LatLng(nuevas_posiciones[contadorPosicion-1].latitude, nuevas_posiciones[contadorPosicion-1].longitude));
                      }

                      if(data.estado==1) {
                        //alert('estado activo')
                        $('#hora_estado_inicio').text(timestamp_inicial);

                        $('#label_hora_inicio').removeClass('hidden');

                        $divEstado.text('EN SERVICIO').addClass('parpadea').removeClass('estado_en_finalizado');

                        if ($divEstado.hasClass('hidden')) {
                          $divEstado.removeClass('hidden')
                        }

                        if( $('.letrero').hasClass('hidden')){
                          $('.letrero').removeClass('hidden');
                        }

                        if(data.recoger==null){
                          $('.estado_mensaje').html('El conductor está recogiendo a sus pasajeros');
                        }else if(data.recoger==0){
                          $('.estado_mensaje').html('El conductor está esperando al pasajero');
                        }else{
                          $('.estado_mensaje').html('El conductor terminó de recoger a sus pasajeros y se dirige al punto de destino');
                        }

                      }else if(data.estado==2){

                        $('#hora_estado_final').text(data.finalizado);

                        $('#label_hora_final').removeClass('hidden');

                        $divEstado.text('FINALIZADO').removeClass('parpadea').removeClass('estado_en_finalizado');

                        $('.estado_mensaje').html('El servicio fue finalizado por el conductor').removeClass('parpadea');

                        clearInterval($trackingGps);

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



  function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 4.653773, lng: -74.097507 },
        zoom: 11,
        mapId: "4504f8b37365c3d0",
      });
      const priceTag = document.createElement("div");

      priceTag.className = "price-tag";
      priceTag.textContent = "$2.5M";

      const markerView = new google.maps.marker.AdvancedMarkerView({
        map,
        position: { lat: 37.42, lng: -122.1 },
        content: priceTag,
      });
    }

    window.initMap = initMap;

    function codeAddress(geocoder, map, address, id, code, addre, cel) {
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            var is = id;
            map.setCenter(results[0].geometry.location);
            id = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });

            //INFO WINDOW
            var contentString = '<div>'+
            '<h4>'+is+'<br>'+addre+'</h4>'+'<center><button class="info-button" data-id="'+code+'" data-direccion="'+addre+'" data-celular="'+cel+'" data-name="'+is+'">Asignar Ruta</button></center>'
            '</div>';

            var infowindow = new google.maps.InfoWindow({
              content: contentString
            });
            //console.log(infowindow);

            id.addListener('click', function() {
              infowindow.open(map, id);
            });

          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

    $('.testt').click(function() {
    //alert('testt')

    for (var i = 1; i <= 5; i++) {
        console.log('test')
        marker = new google.maps.Marker({
        map: map,
//        icon: image,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(4.1143,-74.1133),

      });

    }
  })

    var rt_fecha_servicio = '';
    var rt_centrodecosto = '';
    var rt_subcentrodecosto ='';
    var rt_departamento = '';
    var rt_ciudad = '';
    var rt_solicitado_por = '';


    var rt_nombre_ruta = '';
    var rt_fecha_solicitud = '';
    var rt_tipo_traslado = '';
    var rt_firma = [];
    var rtArrayPax = [];

    $('.asignar').click(function() {
        console.log($(this).attr('data-id'))
        alert('test')
    })

    var htmlPaxqr = '';

    var $tabless = $('#exampless').DataTable({
        paging: false,
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            },
            responsive: true
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' }, //count
            { 'sWidth': '2%' }, //cliente
            { 'sWidth': '2%' }, //tipo de ruta
            { 'sWidth': '1%' }, //hora
            { 'sWidth': '2%' }, //fecha
        ],
        processing: true,
        "bProcessing": true
    });

    $('.programarruta').click(function() {

        //0 , RUTA , DESDE , HASTA

        var conductor = $('#conductors option:selected').val();
        var ruta = $('#rutass option:selected').html().trim().toUpperCase();
        var recoger = $('#recoger option:selected').html().trim().toUpperCase();
        var dejar = $('#dejar option:selected').html().trim().toUpperCase();


        var employArray = [];
        var nameArray = [];
        var celArray = [];
        var direccionArray = [];

        var rt_vehiculoArray = [];
        var rt_recogerenArray = [];
        var rt_dejarenArray = [];
        var rt_horaArray = [];


        $('#exampless tbody tr').each(function(index){

            $(this).children("td").each(function (index2){

                switch (index2){
                    case 0:
                        //rt_detalleArray.push($(this).html());
                        //rt_rutaIdArray.push($(this).attr('data-nombre-ruta-id'));
                        break;
                    case 1:
                        employArray.push($(this).html());
                        break;
                    case 2:
                        nameArray.push($(this).html());
                        break;
                    case 3:
                        celArray.push($(this).html());
                        break;
                    case 4:
                          direccionArray.push($(this).html());
                        break;
                }
            });
        });

        var rt_fecha_servicio = $('#ruta_fecha_servicio').val();
        var rt_hora_servicio = $('#hora_servicioss').val();
        var rt_fecha_solicitud = $('#ruta_fecha_solicitud').val();
        var ruta_email_solicitante = $('#ruta_email_solicitante').val();
        var ruta_solicitado_por = $('#ruta_solicitado_por').val();

        var rt_centrodecosto = $('#ruta_centro_de_costo').val();
        var rt_subcentrodecosto = $('#ruta_subcentros').val();
        var rt_departamento = $('#ruta_departamento option:selected').html();
        var rt_ciudad = $('#ruta_ciudad option:selected').html();

        var rt_tipo_traslado = $('#tipo_traslado').val();
        var rt_firma = $('#firma_calificacion').val();

        console.log(conductor+ ' , '+ruta+' , '+recoger+ ' , '+dejar+ ' , '+employArray+' , '+celArray+' , '+rt_fecha_servicio+ ' ,'+rt_hora_servicio)

        var formData = new FormData();
        formData.append('fecha_servicio', rt_fecha_servicio);
        formData.append('centrodecosto', rt_centrodecosto);
        formData.append('subcentrodecosto', rt_subcentrodecosto);
        formData.append('departamento', rt_departamento);
        formData.append('ciudad', rt_ciudad);
        formData.append('firma', rt_firma);
        formData.append('pasajeros', JSON.stringify(rtArrayPax));
        formData.append('fecha_servicio', rt_fecha_servicio);
        formData.append('departamento', rt_departamento);
        formData.append('ciudad', rt_ciudad);

        formData.append('solicitado_por', ruta_solicitado_por);
        formData.append('email_solicitante', ruta_email_solicitante);

        formData.append('fecha_solicitud', rt_fecha_solicitud);
        formData.append('tipo_traslado', rt_tipo_traslado);
        formData.append('detalleArray',ruta);
        formData.append('rutaIdArray',ruta); //ok
       // formData.append('proveedorArray', rt_proveedorArray);
        //formData.append('conductorArray', rt_conductorArray);
        //formData.append('vehiculoArray', rt_vehiculoArray);
        //formData.append('vehiculoplacaArray',);
        formData.append('conductorIdArray', conductor); //test
        formData.append('recoger_enArray', recoger);
        formData.append('dejar_enArray', dejar);
        formData.append('horaArray', rt_hora_servicio);

        $.ajax({
            url: 'transportesrutasbog/nuevaruta',
            data: formData,
            method: 'post',
            contentType: false,
            processData: false,
            success: function(data){

              if (data.respuesta===true) {
                  if(data.contador!=0){

                    $('#guardando').addClass('hidden');
                    $('#guardar_rutasqr').removeClass('hidden');

                    $.confirm({
                        title: 'Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                        content: 'No se pudieron crear ' + data.contador + ' rutas ya que el corte para este centro de costo ha sido cerrado!',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                          tryAgain: {
                            text: 'Cerrar',
                            btnClass: 'btn-danger',
                            action: function(){
                              location.reload();
                            }
                          }
                        }
                    });

                  }else{

                    var rutas = data.contadora;
                    var cliente = data.cliente;

                    $('#guardando').addClass('hidden');
                    $('#guardado').removeClass('hidden');

                    $('table#exampless tbody').html('');
                    htmlPaxqr = '';

                    $.confirm({
                        title: 'REALIZADO! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                        content: 'Se han programado '+rutas+' rutas para el cliente '+cliente,
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                          tryAgain: {
                            text: 'Cerrar',
                            btnClass: 'btn-success',
                            action: function(){
                              location.reload();
                            }
                          }
                        }
                    });

                  }
              }else if(data.respuesta==='documentacion'){




              }else if (data.respuesta==='relogin') {
                  location.reload();
              }

            }
        });
    })

    $(document).on('click', '.info-button', function(){

        /*$tabless.clear().draw();*/

      var id = $(this).attr('data-id');
      console.log(id)
      var name = $(this).attr('data-name');
      var addres = $(this).attr('data-direccion');
      var cel = $(this).attr('data-celular');

      /*$tabless.row.add([
            1,
            id,
            name,
            cel,
            addres,
        ]).draw().nodes().to$().attr('id', id);*/

      $('table#exampless tbody').html('');

      $(this).attr('disabled', 'disabled');

      htmlPaxqr += '<tr>'+
                    '<td>'+1+'</td>'+
                    '<td>'+id+'</td>'+
                    '<td>'+name+'</td>'+
                    '<td>'+cel+'</td>'+
                    '<td>'+addres+'</td>'+
              '</tr>';

              //y++;

          $('table#exampless tbody').append(htmlPaxqr);
    });

    $('#siguiente').click(function(e){

        //Array de texto de rutas
        var rt_rutaArray = [];
        //Array de nombres de rutas
        var rt_rutaNombreId = [];
        var rt_conductorId = [];
        var rt_vehiculoId = [];
        var rt_hora = [];
        var rt_recoger = [];
        var rt_dejar = [];
        var rt_conductorNombres = [];

        //Declaracion de json vacio
        var stringJson = '';

        //Limpiar tabla de listado de conductores a asignar a la ruta
        $('#ruta_a_programar tbody').html('');

        //Recorrer la tabla de listado de pasajeros
        $('#ruta_import tbody tr').each(function(index){
            //Asignar valor del nombre texto de la ruta
            rt_rutaArray.push($(this).find('td').eq(10).html().trim());
            //Asignar valor del id del nombre de la ruta
            rt_rutaNombreId.push($(this).find('td').eq(10).html().trim());

        });

        //Limpiar ambos arrays y dejar los valores que no se repiten
        var rutas = $.unique(rt_rutaArray);
        var nombreRutaId = $.unique(rt_rutaNombreId);

        var proveedores = '';

        //Ordenar ambos arrays
        rutas = rutas.sort();
        nombreRutaId = nombreRutaId.sort();
        rutas2 = $.unique(rutas);

        const listaNumerosv = rt_vehiculoId;

        // Eliminamos los valores repetidos del array
      /*  let valoresUnico=listaNumeros.filter (
            (value,pos,self) => {
                return pos === self.indexOf(value);
            }
        );
        condu = valoresUnico;*/

        var rt_pasajeros = [];

        //Recorrer las rutas para asignar los pasajeros
        for (var i = 0; i < rutas2.length; i++) {

            rt_pasajeros = [];
            var $objeto2 = '';
            var $objeto3 = '';
            var $objeto4 = '';
            var $objeto5 = '';
            var $objeto6 = '';
            var $recogeren = '';
            var $dejaren = '';


            //Recorrer cada tr de la tabla para de acuerdo a esto guardar los pasajeros
            $('#ruta_import tbody tr').each(function(index){

                //Tomar la columna 10 de la fila que contiene el nombre de la ruta
                var $objeto = $(this).find('td').eq(10);

                var $td = $(this).find('td');

                if ($objeto.html()==rutas[i]) {

                    if(($('#add_pax_ruta').hasClass('hidden'))){

                        console.log($td.eq(4).html().trim());

                        geocoder = new google.maps.Geocoder();
                        codeAddress(geocoder, map, $td.eq(4).html().trim(), $td.eq(2).html().trim(), $td.eq(1).html().trim(), $td.eq(4).html().trim(), $td.eq(3).html().trim());

                      rt_pasajeros.push({
                        "nombres": $td.eq(2).html().trim(),
                        "apellidos": $td.eq(1).html().trim(),
                        "cedula": $td.eq(3).html().trim(),
                        "direccion": $td.eq(4).html().trim(),
                        "barrio": $td.eq(5).html().trim(),
                        "cargo": $td.eq(6).html().trim(),
                        "area": $td.eq(7).html().trim(),
                        "sub_area": $td.eq(8).html().trim(),
                        "hora": $td.eq(9).html()
                      });
                      $objeto2 = $(this).find('td').eq(11).html();
                      $objeto4 = $(this).find('td').eq(13).html();
                      $objeto3 = $(this).find('td').eq(9).html();
                      $objeto5 = $(this).find('td').eq(14).html();
                      $objeto6 = $(this).find('td').eq(15).html();

                    }else{

                      rt_pasajeros.push({
                        "nombres": $td.eq(1).find('input').val().trim(),
                        "apellidos": $td.eq(2).find('input').val().trim(),
                        "cedula": $td.eq(3).find('input').val().trim(),
                        "direccion": $td.eq(4).find('input').val().trim(),
                        "barrio": $td.eq(5).find('input').val().trim(),
                        "cargo": $td.eq(6).find('input').val().trim(),
                        "area": $td.eq(7).find('input').val().trim(),
                        "sub_area": $td.eq(8).find('input').val().trim(),
                        "hora": $td.eq(9).find('input').val().trim()
                      });

                    }

                }


            });
            var lu = $objeto5;
            var lu2 = $objeto6;
            if($objeto5==1){
               $objeto5 = "AUTO CERRADO";
            }else if($objeto5==2){
               $objeto5 = "AUTO ABIERTO";
            }else if($objeto5==3){
               $objeto5 = "CERRADA";
            }else if($objeto5==4){
               $objeto5 = "ABIERTO";
            }else if($objeto5==5){
               $objeto5 = "SUTHERLAND";
            }else if($objeto5==7){
              $objeto5 = "SOACHA"
            }else if($objeto5==6){
              $objeto5 = "AUTO SOACHA"
            }else if($objeto5==8){
              $objeto5 = "RESIDENCIA"
            }else if($objeto5==9){
              $objeto5 = "COLEGIO"
            }

            //DEJAR
            if(lu2==1){
               $objeto6 = "AUTO CERRADO";
            }else if(lu2==2){
               $objeto6 = "AUTO ABIERTO";
            }else if(lu2==3){
               $objeto6 = "CERRADA";
            }else if(lu2==4){
               $objeto6 = "ABIERTO";
            }else if(lu2==5){
               $objeto6 = "SUTHERLAND";
            }else if(lu2==7){
              $objeto6 = "SOACHA";
            }else if(lu2==6){
              $objeto6 = "AUTO SOACHA";
            }else if(lu2==8){
              $objeto6 = "RESIDENCIA";
            }else if(lu2==9){
              $objeto6 = "COLEGIO";
            }
            rtArrayPax.push(rt_pasajeros);
            rt_conductorId.push($objeto2);
            rt_hora.push($objeto3);
            rt_vehiculoId.push($objeto4);
            rt_recoger.push($objeto5);
            rt_dejar.push($objeto6);


        }
        hora = rt_hora;
        condu = rt_conductorId;
        placa = rt_vehiculoId;
        recoger = rt_recoger;
        dejar = rt_dejar;

        var formData = new FormData();
        formData.append('conductoresid',rt_conductorId);
        //formData.append('centrodecosto',rt_centrodecosto);
        //formData.append('subcentrodecosto',rt_subcentrodecosto);

        $.ajax({
            url: 'transportesrutasbog/mostrarproveedores',
            data: formData,
            method: 'post',
            contentType: false,
            processData: false,
            success: function(data){
              if (data.respuesta===true) {

                 /*   for(i in data.conductores){
                      rt_conductorNombres.push(data.conductores[i]);
                      //  conductores += '<option value="'+data.proveedores[i].id+'">'+data.proveedores[i].razonsocial+'</option>';
                    }
*/
                }
            },

        });
        condunombres = rt_conductorNombres;
        var rowsRutas = '';

        for (var i = 0; i < rutas2.length; i++) {

          var horaTxt = '<div class="input-group">'+
                      '<div class="input-group date datetimepickerall">'+
                        '<input type="text" class="form-control input-font" id="hora_servicio" autocomplete="off">'+
                        '<span class="input-group-addon">'+
                          '<span class="fa fa-calendar">'+
                          '</span>'+
                          '</span>'+
                      '</div>'+
                    '</div>';

          $('#ruta_a_programar tbody').append(
            '<tr>'+
              '<td data-nombre-ruta-id="'+nombreRutaId[i]+'">'+rutas[i]+'</td>'+

              '<td data-conductor-ruta-id="'+condu[i]+'">'+condu[i]+'</td>'+
              '<td data-conductor-placa-id="'+placa[i]+'">'+placa[i]+'</td>'+
              '<td data-conductor-recoger-id="'+recoger[i]+'">'+recoger[i]+'</td>'+
              '<td data-conductor-dejar-id="'+dejar[i]+'">'+dejar[i]+'</td>'+

              '<td data-conductor-hora-id="'+hora[i]+'">'+hora[i]+'</td>'+//'<td>'+horaTxt+'</td>'+
          '<tr>');

        }

        $('#ordenar_rutas').addClass('disabled');
        $('#exx_programar').closest('li').removeClass('disabled').addClass('active');
        $('#exx_ruta').closest('li').removeClass('active').addClass('disabled');
        $('#ex_ruta').removeAttr('data-toggle');
        $('#ex_ruta').removeClass('in active');
        $('#ex_programar').addClass('active in');
        $('#siguiente').addClass('disabled');
        $('#guardar_rutas').removeClass('disabled');

        console.log(rtArrayPax);

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
