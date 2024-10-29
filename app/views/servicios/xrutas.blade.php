<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Rutas</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>
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
    <h3 class="h_titulo">PROGRAMACION DE RUTAS</h3>

    @if($permisos->transportes->servicios->creacion==='on')
        <!--<button style="margin-bottom: 7px" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
            SERVICIO<i class="fa fa-plus icon-btn"></i>
        </button>-->
        <a style="margin-bottom: 7px" class="btn btn-default btn-icon" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            RUTA<i class="fa fa-plus icon-btn"></i>
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
                            <option value="{{$usuario->id}}">{{$usuario->first_name.' '.$usuario->last_name}}</option>
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
                    <td><a title="{{$servicio->nombre_ruta}}" href>{{$servicio->codigo_ruta}}</a></td>
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
                              echo '<a title="BArrios" data-id="'.$servicio->id.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

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
								echo '<br><a class="bolder recibir_pago" data-idpag="'.$servicio->id.'" style="cursor: pointer;">PAGO DIRECTO </a>';
							}else{
									echo '<br><small class="bolder">PAGO DIRECTO</small>';
								}
                          }
						  elseif(intval($servicio->pago_directo)===2){
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
                      ?>
                    </td>
                    <td class="opciones text-center">


                        <?php

                            $rutaMapa = intval($servicio->estado_servicio_app);
                            $valorCalificacion = 0;
                            $letraCalificacion = '';
                            $clasemodificacion = '';

                            if($permisos->transportes->encuesta->ver==='on'):
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
                    @if($permisos->transportes->reconfirmacion->ver==='on')
                        <a style="margin-bottom:5px" class="@if($servicio->cancelado===1)disabled @endif btn btn-default" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}">

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
                        <a style="color: white !important" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}" class="hora_reconfirmacion hidden"></a>
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
                                        <div class="input-group">
                                            <select data-option="1" type="text" class="form-control input-font" id="proveedor">
                                                <option value="0">PROVEEDORES</option>
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
                    <a id="guardar" class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
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

<!---MODAL PARA NUEVA RUTA-->
<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">AGREGAR RUTA</h4>
          </div>
            <div class="modal-body tabbable" >
                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                    <li role="presentation" class="active">
                        <a href="#prog_ex" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab">Programacion de Ruta</a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#ex_ruta" aria-controls="exx_ruta" id="exx_ruta" role="tab">Importar Listado</a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#ex_programar" aria-controls="e" id="exx_programar" role="tab">Ruta</a>
                    </li>
                    <li role="presentation">
                        <a href="#export_exce_ruta" aria-controls="e" id="export_ruta" role="tab" data-toggle="tab">Exportar</a>
                    </li>
                    <li role="presentation">
                        <a href="#export_exce_ruta2" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab">Exportar Dia</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="prog_ex">
                        <div class="row" style="margin-top: 15px">
                                <div class="col-xs-12">
                                    <div class="col-xs-2">
                                        <label>Fecha de servicio</label>
                                        <div class="input-group">
                                            <div class="input-group date" id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="ruta_fecha_servicio" value="{{date('Y-m-d')}}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-4" id="centro_alerta">
                                        <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                        <select class="form-control input-font" id="ruta_centro_de_costo">
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
                                    <div class="ruta_subcentros hidden">
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                            <select class="form-control input-font" id="ruta_subcentros">
                                                <option>-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" style="min-height: 67px;">
                                        <label class="obligatorio" for="departamento">Departamento</label>
                                        <select class="form-control input-font" id="ruta_departamento">
                                            <option>-</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                        <select disabled class="form-control input-font" id="ruta_ciudad">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="row">

                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                                <input id="ruta_solicitado_por" type="text" class="form-control input-font">
                                            </div>
                                            <div class="col-xs-2">
                                                <label>Fecha de Solicitud</label>
                                                <div class="input-group">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <input type='text' class="form-control input-font" id="ruta_fecha_solicitud" value="">
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
                    <div role="tabpanel" class="tab-pane fade" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 500px;">
                        <form style="display: inline" id="form_ruta">
                            <div style="display: inline-block; margin-bottom: 15px;">
                                <input id="excel_ruta" type="file" value="Subir" name="excel">
                            </div>
                        </form>
                        <table name="mytable" id="ruta_import" class="table table-hover table-bordered tablesorter">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>NOMBRES</td>
                                    <td>APELLIDOS</td>
                                    <td>CEDULA</td>
                                    <td>DIRECCION</td>
                                    <td>BARRIO</td>
                                    <td>CARGO</td>
                                    <td>AREA</td>
                                    <td>SUB AREA</td>
                                    <td>HORARIO</td>
                                    <td>RUTA</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="ex_programar" style="padding-top: 0; overflow-y: auto; height: 500px;">
                        <table id="ruta_a_programar" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>RUTA</td>
                                    <td>PROVEEDOR</td>
                                    <td>CONDUCTOR</td>
                                    <td>VEHICULO</td>
                                    <td>RECOGER EN</td>
                                    <td>DEJAR EN</td>
                                    <td>HORA</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarrutasfechas')}}" method="post">
                                          <div class="col-xs-12">
                                              <h6>EXPORTAR RELACION DE LISTADO ENTRE FECHAS</h6>
                                          </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                              <label class="obligatorio" for="rt_fecha_final">Fecha Final</label>
                                              <div class="input-group">
                                                <div class="input-group date" id="datetimepicker1">
                                                    <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarlistadodia')}}" method="post">
                                            <div class="col-xs-12">
                                                <h6>EXPORTAR LISTADO DEL DIA</h6>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta2">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarrutasdia')}}" method="post">
                                            <div class="col-xs-12">
                                                <h6>Exportar Rutas Del Dia</h6>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                            <div class="col-xs-12">
                                              <div class="row">
                                                <div class="col-xs-12">
                                                    <h6>Campos a Exportar</h6>
                                                    <ul class="list-group">
                                                      <div class="row">
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Nombres
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_nombre" name="ch_nombre" type="checkbox" checked="true">
                                                                  <label for="ch_nombre" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Apellidos
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_apellido" name="ch_apellido" type="checkbox" checked="true">
                                                                  <label for="ch_apellido" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Cedula
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_cedula" name="ch_cedula" type="checkbox"/>
                                                                  <label for="ch_cedula" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Direccion
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_direccion" name="ch_direccion" type="checkbox"/>
                                                                  <label for="ch_direccion" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Barrio
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_barrio" name="ch_barrio" type="checkbox"/>
                                                                  <label for="ch_barrio" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Cargo
                                                              <div class="material-switch pull-right">
                                                                    <input id="ch_cargo" name="ch_cargo" type="checkbox"/>
                                                                  <label for="ch_cargo" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Area
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_area" name="ch_area" type="checkbox" checked="true">
                                                                  <label for="ch_area" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Sub area
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_subarea" name="ch_subarea" type="checkbox" checked="true">
                                                                  <label for="ch_subarea" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Horario
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_horario" name="ch_horario" type="checkbox"/>
                                                                  <label for="ch_horario" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Embarcado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_embarcado" name="ch_embarcado" type="checkbox" checked="true">
                                                                  <label for="ch_embarcado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              No Embarcado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_no_embarcado" name="ch_no_embarcado" type="checkbox" checked="true">
                                                                  <label for="ch_no_embarcado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Autorizado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_autorizado" name="ch_autorizado" type="checkbox" checked="true">
                                                                  <label for="ch_autorizado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Firma
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_firma" name="ch_firma" type="checkbox" checked="true">
                                                                    <label for="ch_firma" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                        </div>
                                                      </div>
                                                    </ul>
                                                </div>
                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="continuar_ruta" class="btn btn-success btn-icon">CONTINUAR <i class="fa fa-arrow-right icon-btn"></i></a>
                <a id="ordenar_rutas" class="btn btn-info btn-icon disabled">ORDENAR<i class="fa fa-bars icon-btn" aria-hidden="true"></i></a>
                <a id="siguiente" class="btn btn-redu btn-icon disabled">PROGRAMAR<i class="fa fa-play icon-btn" aria-hidden="true"></i></a>
                <a id="guardar_rutas" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>

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
                            <td>APELLIDO</td>
                            <td>CEDULA</td>
                            <td>DIRECCION</td>
                            <td>BARRIO</td>
                            <td>CARGO</td>
                            <td>AREA</td>
                            <td>SUB AREA</td>
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
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/rutas_transporte.js')}}"></script>

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
    var map;

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

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

                //objecto para guardar las coordenadas
                var object = JSON.parse(data.servicio.recorrido_gps);
                var estado_servicio_app = data.servicio.estado_servicio_app;
                var contadorPosicion = 0;
                var cantidad = parseInt(object.length);
                var timestamp_inicial = object[0].timestamp;
                var timestamp_final = object[cantidad-1].timestamp;
                var mitad_mapa = Math.round(cantidad/2);
                var centLatitude = object[mitad_mapa].latitude;
                var centLongitude = object[mitad_mapa].longitude;
                var $divEstado = $('#estado_servicio_modal');

                if (parseInt(estado_servicio_app)===1) {

                    $('#hora_estado_inicio').text(timestamp_inicial);
                    $('#label_hora_inicio').removeClass('hidden');
                    $divEstado.text('EN SERVICIO').addClass('estado_en_servicio').removeClass('estado_en_finalizado');
                    if ($divEstado.hasClass('hidden')) {
                      $divEstado.removeClass('hidden')
                    }

                }else if(parseInt(estado_servicio_app)===2){

                    $('#hora_estado_inicio').text(timestamp_inicial);
                    $('#hora_estado_final').text(timestamp_final);
                    $('#label_hora_inicio').removeClass('hidden');
                    $('#label_hora_final').removeClass('hidden');
                    $divEstado.text('FINALIZADO').addClass('estado_en_finalizado').removeClass('estado_en_servicio');
                    if ($divEstado.hasClass('hidden')) {
                      $divEstado.removeClass('hidden')
                    }
                }

                //opciones google maps
                var mapOptions = {
                    center: new google.maps.LatLng(centLatitude, centLongitude),
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true
                };

                //iniciar mapa
                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                //icon
                var icon = {
                    url: 'img/marker3.png', // url
                    scaledSize: new google.maps.Size(50, 50), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };

                for (var i in object) {

                  if (i==0) {

                    var latLong = new google.maps.LatLng(object[i].latitude, object[i].longitude);

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

                  }else if(i==cantidad-1){

                    var latLong = new google.maps.LatLng(object[i].latitude, object[i].longitude);

                    var marker = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: 'img/marker3-final.png',
                        scaledSize: new google.maps.Size(40, 40)
                      },
                      zIndex: 5000
                    });

                  }else{

                    var latLong = new google.maps.LatLng(object[i].latitude, object[i].longitude);

                    var marker = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: 'img/punto.png',
                        scaledSize: new google.maps.Size(20, 20)
                      },
                      zIndex: parseInt(i)
                    });

                  }

                  contadorPosicion++;

                }

                if (estado_servicio_app!=2) {

                  $trackingGps = setInterval(function(){

                      $.ajax({
                        url: 'transportes/actualizarmapa',
                        method: 'post',
                        data: {
                          id: id
                        }
                      }).done(function(data){

                        var object = JSON.parse(data.servicio);

                        for (var i in object) {

                          if (i>(contadorPosicion-1)) {

                            latLong = new google.maps.LatLng(object[i].latitude, object[i].longitude);

                            marker = new google.maps.Marker({
                              position: latLong,
                              map: map,
                              animation: google.maps.Animation.DROP,
                              icon: {
                                url: 'img/marker3.png',
                                scaledSize: new google.maps.Size(30, 30)
                              }
                            });

                            contadorPosicion++;

                          }

                        }

                      }).fail(function(data){
                          alert('Hubo un error en la conexion');
                      });

                  }, 10000);

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
