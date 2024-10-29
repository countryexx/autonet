<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>
      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      .pac-container {
        z-index: 100000;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .bootstrap-select>.dropdown-toggle{
        padding: 8px;
      }

      .proveedor, [data-id="proveedor"]{
        z-index: 10 !important;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

      .parpadea {

        animation-name: parpadeo;
        animation-duration: 6s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
      }

      @-moz-keyframes parpadeo{
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      @-webkit-keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
         100% { opacity: 1.0; }
      }

      @keyframes parpadeo {
        0% { opacity: 1.0; }
         50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">PROGRAMACION DE SERVICIOS</h3>

        @if($permisos->barranquilla->serviciosbq->creacion==='on')
          <button style="margin-bottom: 7px" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
            SERVICIO
            <i class="fa fa-plus icon-btn"></i>
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
    						            <option value="10">APP MOVIL</option>
                            <option value="11">CALIFICADOS</option>
                            <option value="12">NO CALIFICADOS</option>
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
                            @foreach($usuarios as $user)
                                <option>{{trim($user->first_name).' '.trim($user->last_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                    </div>
                    <button data-option="1" id="buscar" class="btn btn-default btn-icon">
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

                        $novedadap = DB::table('novedades_app')
                        ->where('servicio_id', $servicio->id)
                        ->whereNull('estado')
                        ->get();
                    ?>
                    <tr id="{{$servicio->id}}" class="@if($novedadap!=null){{'danger'}}@elseif(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'resaltar'}} @endif">
                        <td>{{$o++}}</td>
                        <td>{{$servicio->id}}</td>
                        <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>
                        <td>
                          <a title="{{$servicio->nombre_ruta}}" href>
                            {{$servicio->codigo_ruta}}
                          </a>
                        </td>
                        <td>{{$servicio->ciudad}}</td>
                        <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
                        <td>
                            @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                            @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                            @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                            @if($servicio->vuelo==='')@else Vuelo:<br><a target="_blank" href="https://www.flightradar24.com/data/flights/{{trim(strtolower($servicio->vuelo))}}">{{$servicio->vuelo}}</a>@endif<br>
                            @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                            @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                        </td>
                        <td>{{$servicio->recoger_en}}</td>
                        <td>{{$servicio->dejar_en}}</td>
                        <td>{{$servicio->detalle_recorrido}} / <b>EXP:</b> {{$servicio->expediente}} <hr style="border: 1px solid;"><b>{{$servicio->email_solicitante}}</b></td>
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
                                  echo '<a data-id="'.$servicio->id.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

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
                                          echo '<a>'.$celular.'</a><br>';
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
                              $novedadapp = DB::table('novedades_app')->where('servicio_id', $servicio->id)->get();

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
                                      echo '<div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">EN SERVICIO</div>';
                                  }else if(intval($servicio->estado_servicio_app)===2){
                                      echo '<div class="estado_servicio_app" style="background: #eaeaea; color: #313131; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">FINALIZADO</div>';
                                  }else{
                                      echo '<div class="estado_servicio_app" id="'.$servicio->id.$servicio->id.'" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">NO INICIADO</div>';
                                      if (intval($servicio->aceptado_app)===0) {
                                          echo '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">NO ACEPTADO</div>';
                                      }else if(intval($servicio->aceptado_app)===3){
                                          echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">RECHAZADO</div>';
                                      }else if(intval($servicio->aceptado_app)===1){
                                          echo '<div class="estado_servicio_app acepted'.$servicio->id.'" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">ACEPTADO</div>';
                                      }
                                  }

                              }

                              if ($servicio->id_pivote!=null) {
                                  echo '<div><small class="text-primary">EDITADO</small></div>';
                              }

                              if ($novedades!=null) {
                                  echo '<small class="text-danger">NOVEDAD</small>';
                              }

                              if ($novedadapp!=null) {
                                  echo '<div><small class="text-danger" style="color: #8a069a;">NOVEDAD APP</small></div>';
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
                									echo '<br><small class="bolder" title="RECIBIDO: {{$servicio->fecha_pago_directo}}">PAGO DIREC.<i class="glyphicon glyphicon-ok text-success"></i></small>';
                						  }

                              if (intval($servicio->finalizado)===1) {
                                  echo '<div><small class="text-success bolder">FINALIZADO</small></div>';
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
                          @include('otros.servicios.botones_listado_servicio')
                        </td>
                        <td>
                          {{-- PERMISO PARA VER RECONFIRMACION --}}
                          @if($permisos->barranquilla->reconfirmacionbq->ver==='on')
                              <a style="margin-bottom:5px" class="@if($servicio->cancelado===1)disabled @endif btn btn-default" href="{{url('transportesbaq/reconfirmacion/'.$servicio->id)}}">

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
                              <a style="color: white !important" href="{{url('transportesbaq/reconfirmacion/'.$servicio->id)}}" class="hora_reconfirmacion hidden"></a>
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
                          @if($servicio->calificacion_app_conductor_calidad!=null)
                            <div title="Calificacion desde aplicacion de conductores" class="calificacion_listado_servicios_conductor">
                              <span>{{$servicio->calificacion_app_conductor_calidad}}</span>
                              <i class="fa fa-star"></i>
                            </div>
                          @endif
                          @if($servicio->calificacion_app_cliente_calidad!=null)
                            <div title="Calificacion desde aplicacion de clientes" class="calificacion_listado_servicios_cliente">
                              <span>{{$servicio->calificacion_app_cliente_calidad}}</span>
                              <i class="fa fa-star"></i>
                            </div>
                          @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('modales.nuevo_servicio')

    @include('modales.editar_servicio')

    <!---MODAL PARA NUEVA RUTA-->
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-servicios" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">AGREGAR RUTA</h4>
              </div>
                <div class="modal-body tabbable">
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
                                            <form id="form" action="{{url('transportesbaq/exportarrutasfechas')}}" method="post">
                                              <div class="col-xs-12">
                                                  <h6>EXPORTAR RELACION DE LISTADO ENTRE FECHAS</h6>
                                              </div>
                                                <div class="col-xs-2">
                                                    <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                    <div class="input-group">
                                                      <div class="input-group date" id="datetimepicker1">
                                                          <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
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
                                                        <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115px;" type="text" class="form-control input-font">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-xs-3">
                                                    <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                    <select name="md_centrodecosto" id="centrodecosto_ex_excel" class="form-control input-font centrodecosto_ex_excel">
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
                                            <form id="form" action="{{url('transportesbaq/exportarlistadodia')}}" method="post">
                                                <div class="col-xs-12">
                                                    <h6>EXPORTAR LISTADO DEL DIA</h6>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                    <div class="input-group">
                                                      <div class="input-group date" id="datetimepicker1">
                                                          <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
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
                                            <form id="form" action="{{url('transportesbaq/exportarrutasdia')}}" method="post">
                                                <div class="col-xs-12">
                                                    <h6>Exportar Rutas Del Dia</h6>
                                                </div>
                                                <div class="col-xs-2">
                                                    <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                    <div class="input-group">
                                                      <div class="input-group date" id="datetimepicker1">
                                                          <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
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

    @include('modales.eliminar_servicio')

    @include('modales.motivo_eliminacion')

    @include('modales.transportes.envio_mails_servicios')

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
      <div class="modal-dialog modal-lg" role="document" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header" style="background-color: white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <!--<center><h4 style="display: inline-block" class="modal-title" id="myModalLabel">TRACKING GPS</h4></center>-->
                    <center><div class="hidden" id="estado_servicio_modal" style="background: #4CAF50; color: white; margin: 2px 0px; font-size: 20px; padding: 3px 5px; width: 140px; border-radius: 2px"></div>
                        <br>
                        <div class="estado_servicio_app codes hidden" style="background: #f47321; color: white; margin: 2px 0px; font-size: 25px; padding: 3px 5px; width: 15%; border-radius: 6px;"><b class="codigos"></b></div>

                    </center>
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

    <!-- Opcion de reconfirmacion, variable obligatoria -->
    <?php $option_reconfirmacion = 1; ?>
    @include('modales.activacion_reconfirmacion')

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
                <span>RESTRICCIONES<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vrestriccion" style="font-size: 10px" class="text-warning bolder">
                  <ul style="padding-left: 15px; padding-top: 6px;">
                  </ul>
                </small>
              </li>
              <li class="list-group-item">
                <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vadministracion" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vsoat" style="font-size: 10px" class="text-success bolder"></small>
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

    <audio id="audio">
        <source id="avisos" src="{{url('notify_start.mp3')}}" type="audio/mpeg">
    </audio>

    <audio id="audio2">
        <source id="avisos" src="{{url('notify_end.mp3')}}" type="audio/mpeg">
    </audio>

    @include('scripts.scripts')

    @include('otros.firebase_cloud_messaging')

    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/serviciosbaq.js')}}"></script>

    @include('otros.pusher.servicios_cancelados')
    @include('otros.pusher.notify_baq')

    <script type="text/javascript" src="{{asset('typeahead.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <script type="text/javascript">

      var substringMatcher = function(strs) {
        return function findMatches(q, cb) {

          var matches, substringRegex;
          matches = [];

          substrRegex = new RegExp(q, 'i');

          $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
              matches.push(str);
            }
          });

          cb(matches);

        };
      };

      var correos = [
        "dcoba@aotour.com.co", "transportes1@aotour.com.co", "lalonso@aotour.com.co", "luis.farfan@effem.com", "chaily.navarro@effem.com",
        "ismael.simancas@effem.com", "nicolas.umbarila@effem.com", "nathalia.reyes@effem.com", "yheis.mendoza@hotelesestelar.com",
        "cristiand.zabaleta@hotelesestelar.com", "carlosr.villatoro@hotelesestelar.com", "ariana.onate@hotelesestelar.com",
        "gracielae.herrera@hotelesestelar.com", "algarin.laura@knauf.com.co", "eddy.rojano@pmi.com", "leidyalejandra.urquijo@pmi.com",
        "patricia.calle@averydennison.com", "cindy.rojano@corteva.com", "vvizcainovalle@dow.com", "fbqsegu@dow.com", "luis.torres@sutherlandglobal.com",
        "anamelissa.montenegro@sutherlandGlobal.com", "odalis.orozcoalvarez@sutherlandglobal.com", "carolina.orrego@averydennison.com", "sistemas@aotour.com.co"
      ];

      /*$('input[name="envio_mail_correo_electronico"], input[name="envio_mail_cc_correo_electronico"]').tagsinput({
        typeaheadjs: {
          hint: true,
          highlight: true,
          minLength: 1,
          name: 'states',
          source: substringMatcher(correos)
        },
        trimValue: true
      });*/

      @if(Sentry::getUser()->coordinador===1)
        $('#modal-activar-reconfirmacion').animate({
          opacity: 1
        }, 2000);
      @endif

      function clearMarkers() {
        setMapOnAll(null);
      }

      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      function initMap() {

        var polylineOptionsActual = new google.maps.Polyline({
          strokeColor: 'gray',
          strokeOpacity: 111.0,
          strokeWeight: 4
        });

        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true, polylineOptions: polylineOptionsActual});  //suppressMarkers: true,

        const map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: -33.8688, lng: 151.2195 },
          zoom: 13,
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
        });

        const mapa = new google.maps.Map(document.getElementById("mapa"), {
          center: { lat: 10.996992, lng: -74.800389 },
          zoom: 16,
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
        });

        const mapas = new google.maps.Map(document.getElementById("mapas"), {
          center: { lat: 10.996992, lng: -74.800389 },
          zoom: 16,
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
        });

        const mapp = new google.maps.Map(document.getElementById("mapp"), {
          center: { lat: 10.996992, lng: -74.800389 },
          zoom: 16,
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
        });

        directionsRenderer.setMap(mapp);

        const markerss = new google.maps.Marker({
          map: mapa,
          icon: {
            url: "{{url('img/marker_pasajero_recogido.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          draggable: true,
          animation: google.maps.Animation.DROP,
          position: new google.maps.LatLng(10.996992,-74.800389),

        });

        const markersss = new google.maps.Marker({
          map: mapas,
          icon: {
            url: "{{url('img/marker_bandera.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          draggable: true,
          animation: google.maps.Animation.DROP,
          position: new google.maps.LatLng(10.996992,-74.800389),

        });

        //dirs
        const markerInicio = new google.maps.Marker({
          map: mapp,
          icon: {
            url: "{{url('img/marker_pasajero_recogido.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          draggable: true,
          animation: google.maps.Animation.DROP,
          position: new google.maps.LatLng(10.996992,-74.800389),

        });

        const markerFin = new google.maps.Marker({
          map: mapp,
          icon: {
            url: "{{url('img/marker_bandera.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          draggable: true,
          animation: google.maps.Animation.DROP,
          position: new google.maps.LatLng(10.996992,-74.800389),

        });

        /*Nuevo servicio*/
        var inputRecoger = (document.getElementById('recoger_en'));
        var inputDestino = (document.getElementById('dejar_en'));
        var options = {
          //componentRestrictions: {
            //country: 'CO'
            types: ['(cities)'],
            componentRestrictions: {country: 'CO'}
          //}
        };
        var autocompleteRecoger = new google.maps.places.SearchBox(inputRecoger, options);
        var autocompleteDejar = new google.maps.places.SearchBox(inputDestino, options);

        autocompleteRecoger.addListener("places_changed", () => {
          const places = autocompleteRecoger.getPlaces();
          if (places.length == 0) {
            return;
          }
          places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
              console.log("Returned place contains no geometry");
              return;
            }

            const icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
              new google.maps.Marker({
                mapa,
                icon,
                title: place.name,
                position: place.geometry.location,
              })
            );

            if (place.geometry.viewport) {
              mapa.fitBounds(place.geometry.viewport);
            } else {
              mapa.setCenter(place.geometry.location);
              mapa.setZoom(17); // Why 17? Because it looks good.
            }

            markerss.setPosition(place.geometry.location);
            markerss.setVisible(true);



            $('#recoger_en, .recoger_en').attr('data-latitude',place.geometry.location.lat());
            $('#recoger_en, .recoger_en').attr('data-longitude',place.geometry.location.lng());

            $('#recoger_en').attr('data-sw',1);
            if($('#dejar_en').attr('data-sw')!=0){
              $('#programar').removeClass('disabled');

              $('.viaje').removeClass('hidden');
              var inicio = {
                lat: parseFloat($('#recoger_en').attr('data-latitude')),
                lng: parseFloat($('#recoger_en').attr('data-longitude'))
              }

              var fin = {
                lat: parseFloat($('#dejar_en').attr('data-latitude')),
                lng: parseFloat($('#dejar_en').attr('data-longitude'))
              }

              directionsService.route({
                origin: inicio,
                destination: fin,
                travelMode: 'DRIVING'
              }, function(response, status) {
                if (status === 'OK') {
                  directionsRenderer.setDirections(response);
                  var route = response.routes[0];
                  var summaryPanel = document.getElementById('directions-panel');
                  summaryPanel.innerHTML = '';

                  var time = response.routes[0].legs[0].duration.text;
                  var distance = response.routes[0].legs[0].distance.text;

                  document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';

                  document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                  for (var i = 0; i < route.legs.length; i++) {
                    var routeSegment = i + 1;
                    summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                        '</b><br>';
                    summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                    summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                    summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                  }
                }
              });

              markerInicio.setPosition(inicio)
              markerFin.setPosition(fin)

            }else{
                $('.viaje').addClass('hidden');
                $('#programar').addClass('disabled');
            }

          });
        });

        //move
        markerss.addListener( 'dragend', function (event)
          {
            $('#recoger_en, .recoger_en').attr('data-latitude',this.getPosition().lat());
            $('#recoger_en, .recoger_en').attr('data-longitude',this.getPosition().lng());
          });

          var geocoder = new google.maps.Geocoder();

          //le asignamos una funcion al eventos dragend del marcado
          google.maps.event.addListener(markerss, 'dragend', function() {

            geocoder.geocode({'latLng': markerss.getPosition()}, function(results, status) {

              if (status == google.maps.GeocoderStatus.OK) {

                var address=results[0]['formatted_address'];
                document.getElementById("recoger_en").value = address;

                var inicio = {
                  lat: parseFloat($('#recoger_en').attr('data-latitude')),
                  lng: parseFloat($('#recoger_en').attr('data-longitude'))
                }

                var fin = {
                  lat: parseFloat($('#dejar_en').attr('data-latitude')),
                  lng: parseFloat($('#dejar_en').attr('data-longitude'))
                }

                //Habilitar las opciones
                $('#recoger_en').attr('data-sw',1);

                if($('#dejar_en').attr('data-sw')!=0){
                  $('#programar').removeClass('disabled');
                  $('.viaje').removeClass('hidden');
                }else{
                  $('#programar').addClass('disabled');
                  $('.viaje').addClass('hidden');
                }

                directionsService.route({
                  origin: inicio,
                  destination: fin,
                  travelMode: 'DRIVING'
                }, function(response, status) {
                  if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                    var route = response.routes[0];
                    var summaryPanel = document.getElementById('directions-panel');
                    summaryPanel.innerHTML = '';

                    var time = response.routes[0].legs[0].duration.text;
                    var distance = response.routes[0].legs[0].distance.text;

                    document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';

                    document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                    for (var i = 0; i < route.legs.length; i++) {
                      var routeSegment = i + 1;
                      summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                          '</b><br>';
                      summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                      summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                      summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                    }
                  }
                });

                markerInicio.setPosition(inicio)
                markerFin.setPosition(fin)

              }

            });

          });

        autocompleteDejar.addListener("places_changed", () => {
          const placess = autocompleteDejar.getPlaces();

          if (placess.length == 0) {
            return;
          }

          placess.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
              console.log("Returned place contains no geometry");
              return;
            }

            if (place.geometry.viewport) {
              mapas.fitBounds(place.geometry.viewport);
            } else {
              mapas.setCenter(place.geometry.location);
              mapas.setZoom(17); // Why 17? Because it looks good.
            }

            markersss.setPosition(place.geometry.location);
            markersss.setVisible(true);

            $('#dejar_en, .dejar_en').attr('data-latitude',place.geometry.location.lat());
            $('#dejar_en, .dejar_en').attr('data-longitude',place.geometry.location.lng());

            $('#dejar_en').attr('data-sw',1);

            if($('#recoger_en').attr('data-sw')!=0){
              $('#programar').removeClass('disabled');

              $('.viaje').removeClass('hidden');

              var inicio = {
                lat: parseFloat($('#recoger_en').attr('data-latitude')),
                lng: parseFloat($('#recoger_en').attr('data-longitude'))
              }

              var fin = {
                lat: parseFloat($('#dejar_en').attr('data-latitude')),
                lng: parseFloat($('#dejar_en').attr('data-longitude'))
              }

              directionsService.route({
                origin: inicio,
                destination: fin,
                travelMode: 'DRIVING'
              }, function(response, status) {
                if (status === 'OK') {
                  directionsRenderer.setDirections(response);
                  var route = response.routes[0];
                  var summaryPanel = document.getElementById('directions-panel');
                  summaryPanel.innerHTML = '';

                  var time = response.routes[0].legs[0].duration.text;
                  var distance = response.routes[0].legs[0].distance.text;

                  document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';

                  document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                  for (var i = 0; i < route.legs.length; i++) {
                    var routeSegment = i + 1;
                    summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                        '</b><br>';
                    summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                    summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                    summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                  }
                }
              });

              markerInicio.setPosition(inicio)
              markerFin.setPosition(fin)

            }else{
                $('#programar').addClass('disabled');
                $('.viaje').addClass('hidden');
            }

            console.log($('#dejar_en').attr('data-latitude'))
            console.log($('#dejar_en').attr('data-longitude'))

          });

        });

        markersss.addListener( 'dragend', function (event)
          {
            $('#dejar_en, .recoger_en').attr('data-latitude',this.getPosition().lat());
            $('#dejar_en, .recoger_en').attr('data-longitude',this.getPosition().lng());
          });

          var geocoder = new google.maps.Geocoder();

          //le asignamos una funcion al eventos dragend del marcado
          google.maps.event.addListener(markersss, 'dragend', function() {

            geocoder.geocode({'latLng': markersss.getPosition()}, function(results, status) {

              if (status == google.maps.GeocoderStatus.OK) {

                var address=results[0]['formatted_address'];
                document.getElementById("dejar_en").value = address;

                var inicio = {
                  lat: parseFloat($('#recoger_en').attr('data-latitude')),
                  lng: parseFloat($('#recoger_en').attr('data-longitude'))
                }

                var fin = {
                  lat: parseFloat($('#dejar_en').attr('data-latitude')),
                  lng: parseFloat($('#dejar_en').attr('data-longitude'))
                }

                //Habilitar las opciones
                $('#dejar_en').attr('data-sw',1);

                if($('#recoger_en').attr('data-sw')!=0){
                  $('#programar').removeClass('disabled');
                  $('.viaje').removeClass('hidden');
                }else{
                  $('#programar').addClass('disabled');
                  $('.viaje').addClass('hidden');
                }

                directionsService.route({
                  origin: inicio,
                  destination: fin,
                  travelMode: 'DRIVING'
                }, function(response, status) {
                  if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                    var route = response.routes[0];
                    var summaryPanel = document.getElementById('directions-panel');
                    summaryPanel.innerHTML = '';

                    var time = response.routes[0].legs[0].duration.text;
                    var distance = response.routes[0].legs[0].distance.text;

                    document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';

                    document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 24px; padding: 6px 5px; width: 105px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                    for (var i = 0; i < route.legs.length; i++) {
                      var routeSegment = i + 1;
                      summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                          '</b><br>';
                      summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                      summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                      summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                    }
                  }
                });

                markerInicio.setPosition(inicio)
                markerFin.setPosition(fin)

              }

            });

          });
        /*Nuevo servicio*/

        /*Editar servicio*/
        var inputRecogere = (document.getElementById('recoger_en_editar'));
        var inputDestinoe = (document.getElementById('dejar_en_editar'));
        var optionse = {
          componentRestrictions: {
            country: 'co'
          }
        };
        var autocompleteRecogere = new google.maps.places.SearchBox(inputRecogere, optionse);
        var autocompleteDejare = new google.maps.places.SearchBox(inputDestinoe, optionse);

        autocompleteRecogere.addListener("places_changed", () => {
          const placesse = autocompleteRecogere.getPlaces();
          if (placesse.length == 0) {
            return;
          }
          placesse.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
              console.log("Returned place contains no geometry");
              return;
            }
            $('#recoger_en_editar').attr('data-latitude',place.geometry.location.lat());
            $('#recoger_en_editar').attr('data-longitude',place.geometry.location.lng());

            //console.log($('#recoger_en_editar').attr('data-latitude'))
            //console.log($('#recoger_en_editar').attr('data-longitude'))
          });
        });

        autocompleteDejare.addListener("places_changed", () => {
          const placesse = autocompleteDejare.getPlaces();

          if (placesse.length == 0) {
            return;
          }

          placesse.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
              console.log("Returned place contains no geometry");
              return;
            }

            $('#dejar_en_editar').attr('data-latitude',place.geometry.location.lat());
            $('#dejar_en_editar').attr('data-longitude',place.geometry.location.lng());

            //console.log($('#dejar_en_editar').attr('data-latitude'))
            //console.log($('#dejar_en_editar').attr('data-longitude'))

          });
        });
        /*Editar servicio*/

        var latitudeRecoger = null;
        var longitudeRecoger = null;

        map.addListener('bounds_changed', function() {
          autocompleteRecoger.setBounds(map.getBounds());
        });

        map.addListener('bounds_changed', function() {
          autocompleteDejar.setBounds(map.getBounds());
        });
      }

      $('#recoger_en').keyup(function() {
        if( $('#flexCheckDefault').attr('data-sw')==0 ) {
            $('#programar').addClass('disabled');
            $(this).attr('data-sw',0);
            $('.viaje').addClass('hidden');
        }else{
            $('#programar').removeClass('disabled');
        }
      });

      $('#dejar_en').keyup(function() {
        if( $('#flexCheckDefault').attr('data-sw')==0 ) {
            $('#programar').addClass('disabled');
            $(this).attr('data-sw',0);
            $('.viaje').addClass('hidden');
        }else{
            $('#programar').removeClass('disabled');
        }
      });

      $('#flexCheckDefault').click(function() {
        if($(this).is(':checked')){
            $(this).attr('data-sw',1);
            $('#programar').removeClass('disabled');
            $('#dejar_en').val('A DISPOSICIÓN')
            $('.viaje').addClass('hidden');
        }else{
            $('#programar').addClass('disabled');
            $(this).attr('data-sw',0);
            $('#dejar_en').val('')
        }
      });

      function iniciarMapa(id){

        if (!$('#label_hora_inicio').hasClass('hidden')) {
          $('#label_hora_inicio').addClass('hidden');
        }

        if (!$('#label_hora_final').hasClass('hidden')) {
          $('#label_hora_final').addClass('hidden');
        }

        $.ajax({
            url: 'transportesbaq/servicioruta',
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

                      //alert(parseFloat(posisionesss[0].lat))
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

                      $('.letrero').addClass('hidden');
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

                    //INFO WINDOW
                    var contenidoss = '<div id="content">'+
                    '<h4>Aquí inició UP DRIVER</h4>'
                    '</div>';

                    var infowindowss = new google.maps.InfoWindow({
                      content: contenidoss
                    });

                    marker.addListener('click', function() {
                      infowindowss.open(map, marker);
                    });

                    if(data.servicio.hasta!=null){

                        var posisionesss =  JSON.parse(data.servicio.hasta);

                        var hasta = {
                          lat: parseFloat(posisionesss[0].lat),
                          lng: parseFloat(posisionesss[0].lng)
                        }

                    }else{

                        var hasta = {
                            lat: 10.997073,
                            lng: -74.80063
                        }

                    }

                    var marcador = new google.maps.Marker({
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
                      var contenidos = '<div id="content">'+
                      '<h4>Lugar de Destino</h4>'
                      '</div>';

                      var infowindows = new google.maps.InfoWindow({
                        content: contenidos
                      });

                      marcador.addListener('click', function() {
                        infowindows.open(map, marcador);
                      });

                      //MARCADOR DONDE EL SE LLEVARÁ AL PASAJERO

                      if(data.servicio.desde!=null){

                        var posisionees =  JSON.parse(data.servicio.desde);

                        var desde = {
                            lat: parseFloat(posisionees[0].lat),
                            lng: parseFloat(posisionees[0].lng)
                        }

                      }else{

                        var desde = {
                            lat: 10.997073,
                            lng: -74.80063
                        }

                      }

                      

                      var marcadors = new google.maps.Marker({
                          position: desde,
                          map: map,
                          title: 'Lugar de Recogida',
                          animation: google.maps.Animation.BOUNCE,
                          icon: {
                            url: "{{url('img/marker_pasajero_recogido.png')}}",
                            scaledSize: new google.maps.Size(40, 40)
                          },
                          //zIndex: 5000
                        });

                        //INFO WINDOW
                        var contenido = '<div id="content">'+
                        '<h4>Lugar de Recogida</h4>'
                        '</div>';

                        var infowindow = new google.maps.InfoWindow({
                          content: contenido
                        });

                        marcadors.addListener('click', function() {
                          infowindow.open(map, marcadors);
                        });
                      //MARCADOR DONDE SE LLEVARÁ AL PASAJERO
                      //marcador.setPosition(hasta);
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
                      strokeColor: 'gray',
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
                          url: 'transportesbaq/actualizarmapa',
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
                              $('.estado_mensaje').html('El conductor se dirige a buscar al pasajero');
                              $('.codes').removeClass('hidden');
                              $('.codigos').html('Código de viaje: '+data.codigo);
                            }else if(data.recoger==0){
                              $('.estado_mensaje').html('El conductor está esperando al pasajero');
                              $('.codes').removeClass('hidden');
                              $('.codigos').html('Código de viaje: '+data.codigo);
                            }else{
                              $('.estado_mensaje').html('El conductor recogió al pasajero y se dirige al punto de destino');
                            }

                          }else if(data.estado==2){

                            $('.codes').addClass('hidden');

                            $('#hora_estado_final').text(data.finalizado);

                            $('#label_hora_final').removeClass('hidden');

                            $divEstado.text('FINALIZADO').removeClass('parpadea').removeClass('estado_en_finalizado');

                            $('.estado_mensaje').html('El servicio fue finalizado por el conductor').removeClass('parpadea');

                            //if ($divEstado.hasClass('hidden')) {
                              //$divEstado.removeClass('hidden')
                            //}

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

      $('#example').on('click', '.ruta_mapa', function(){

        var servicio_id = $(this).attr('data-id');
        iniciarMapa(servicio_id);

      });

      //detener el trackingGps cuando cierran la ventana modal
      $('.mymodal4').on('hidden.bs.modal', function (e) {
          clearInterval($trackingGps);
      });

      /*$('#recoger_en').keyup(function(){
        $('#programar').addClass('disabled');
        $('#recoger_en').attr('data-sw',0);
      });

      $('#dejar_en').keyup(function(){
        $('#programar').addClass('disabled');
        $('#dejar_en').attr('data-sw',0);
      });*/

      window.onload = function(){

        var pos=window.name || 0;

        window.scrollTo(0,pos);

        window.location.hash="no-back-button";

        window.location.hash="Again-No-back-button" //chrome

        window.onhashchange=function(){
          window.location.hash="no-back-button";
        }

      }

      window.onunload=function(){
        window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
      }

    </script>
  </body>
</html>
