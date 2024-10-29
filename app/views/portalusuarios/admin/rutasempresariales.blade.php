<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Rutas Empresariales</title>
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
        <h3 class="h_titulo">VISUALIZACIÓN DE RUTAS EMPRESARIALES | {{$cliente}} </h3>     

    @if($permisos->barranquilla->serviciosbq->creacion==='on')
        <button style="margin-bottom: 7px" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
            SERVICIO<i class="fa fa-plus icon-btn"></i>
        </button>
        <a style="margin-bottom: 7px" class="btn btn-default btn-icon" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            RUTA<i class="fa fa-plus icon-btn"></i>
        </a>
         <a style="margin-bottom: 7px" class="btn btn-default btn-icon" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal22">
            RUTA QR<i class="fa fa-plus icon-btn"></i>
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
                <div class="hidden">
                  <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
                    <option value="0">PROVEEDORES</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                    @endforeach
                  </select>
                  <span style="cursor: pointer" class="input-group-addon proveedor_eventual"><i class="fa fa-car"></i></span>
                </div>
                <div class="hidden">
                    <select disabled id="conductor_search" style="width: 80px;" class="form-control input-font" name="conductores">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                        <option value="0">TODAS LAS SEDES</option>
                        @foreach($sub as $centro)
                            <option value="{{$centro->id}}">{{$centro->nombresubcentro}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden">
                    <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="hidden">
                    <select style="width: 107px;" name="ciudades" class="form-control input-font">
                        <option>CIUDADES</option>
                        @foreach($ciudades as $ciudad)
                            <option>{{$ciudad->ciudad}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="hidden">
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
              <th>Ciudad</th>
              <th>Fecha: Orden / Servicio</th>
              <th>Itinerario</th>
              <th>Desde</th>
              <th>Hasta</th>
              <th>Horario</th>              
          </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Codigo</th>
                <th>Solicitante / Fecha</th>
                <th>Ciudad</th>
                <th>Fecha: Orden / Servicio</th>
                <th>Itinerario</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Horario</th>                
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
                                        
                    <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@include('modales.rutas.nuevo_servicio_ruta')

@include('modales.rutas.editar_servicio')

@include('modales.rutas.nueva_ruta')

@include('modales.rutas.nueva_rutaqr')

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
          url: '{{url('transportesbaq').'/registraridweb'}}',
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
    	url: '{{url('transportesbaq/serviciosporaceptar')}}',
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
<script src="{{url('jquery/rutas_transporte_admin.js')}}"></script>

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