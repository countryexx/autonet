<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Revision</title>
	  @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
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

  </style>
</head>
<body>

@include('admin.menu')

<div class="col-lg-12">
  <div class="col-lg-12">
    <div class="row">
        @include('facturacion.menu_facturacion')
    </div>
  </div>

  <div class="col-lg-12">
    <div class="row">
      <h3 class="h_titulo">LISTADO DE ORDENES DE SERVICIOS PROGRAMADAS</h3>
    </div>
  </div>
	<form class="form-inline" id="form_buscar">
      <div class="col-lg-12" style="margin-bottom: 5px">
            <div class="row">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group date datetime_fecha">
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
                        <div class="input-group date datetime_fecha">
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
                        <option value="3">NO REVISADOS</option>
                        <option value="4">NO FACTURADOS</option>
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
                    <select id="conductor_search" style="width: 80px;" class="form-control input-font" name="conductores">
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
                <button id="buscar" class="btn btn-default btn-icon">
                    Buscar<i class="fa fa-search icon-btn"></i>
                </button>
            </div>
        </div>
  </form>

  @if(isset($servicios))
  	<div class="tabla">

      <a title="Ir a Revisar los Servicios Seleccionados" id="" style="padding: 8px 8px; float: right; margin-bottom: 10px" class="btn btn-info revisar_seleccion">Revisar Selección <i class="fa fa-pencil-square-o"></i></a>

  		<table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
  			<thead>
  			<tr>
  				<th></th>
  				<th>Fecha servicio</th>
  				<th>Ciudad</th>
  				<th>Detalle</th>
  				<th>Recoger en</th>
  				<th>Dejar en</th>
  				<th>Cod centro costo</th>
  				<th>Pax</th>
  				<th>Proveedor / Conductor</th>
  				<th>Horario</th>
  				<th>Cliente</th>
  				<th>
            Select
            <center><input style="font-size: 40px" type="checkbox" id="cbox1" class="select_all" value="second_checkbox">
            </center>
          </th>
  				<th>Usuario</th>
  				<th>Estado</th>
  				<th></th>
  			</tr>
  			</thead>
  			<tfoot>
  			<tr>
  				<th></th>
  				<th>Fecha servicio</th>
  				<th>Ciudad</th>
  				<th>Detalle</th>
  				<th>Recoger en</th>
  				<th>Dejar en</th>
  				<th>Cod centro costo</th>
  				<th>Pax</th>
  				<th>Proveedor / Conductor</th>
  				<th>Horario</th>
  				<th>Cliente</th>
  				<th>Select</th>
  				<th>Usuario</th>
  				<th>Estado</th>
  				<th></th>
  			</tr>
  			</tfoot>
  			<tbody>

  			@foreach($servicios as $servicio)
  				<tr id="{{$servicio->id}}">
  					<td>
              {{$o++}}
              <div class="badge_revision">
                {{$servicio->id}}
              </div>
            </td>
  					<td>{{$servicio->fecha_servicio}}</td>
  					<td>{{$servicio->ciudad}}</td>
  					<td>{{$servicio->detalle_recorrido}}</td>
  					<td>
              @if($servicio->ruta==1 and $servicio->desde!=null)
  							{{$servicio->desde}}

  						@else
  							{{$servicio->recoger_en}}
  						@endif
            </td>
  					<td>
              @if($servicio->ruta==1 and $servicio->hasta!=null)
  							{{$servicio->hasta}}
  						@else
  							{{$servicio->dejar_en}}
  						@endif
            </td>
  					<td>{{$servicio->cod_centro_costo}}</td>
  					<td>
  						<?php

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

  							if (!isset($email)){
  								$email = "";
  							}

  							if (!isset($nivel)){
  								$nivel = "";
  							}

  							echo '<a href title="'.$celular.'">'.$nombre.'</a><br><a href title="'.$email.'">'.$nivel.'</a><br>';

  						}

  						?>
  					</td>
  					<td>
  						<a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonproveedor}}</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
  						<a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
  					</td>
  					<td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
  					<td>@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}} @else {{$servicio->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}@endif</td>
  					<td>
              @if( isset($servicio->numero_planilla) )
                <center><small class="text-danger"><i style="color: green; font-size: 13px" class="fa fa-check" aria-hidden="true"></i></small></center><br>
              @else
                <center><input data-id="{{$servicio->id}}" type="checkbox" id="cbox1" class="services" value="first_checkbox"></center>
              @endif
            </td>
  					<td>{{$servicio->first_name.' '.$servicio->last_name}}</td>
  					<td>
  						<?php

  						$reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();
  						$novedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion',$servicio->id)->get();
  						$novedades_app = DB::table('novedades_app')->where('servicio_id', $servicio->id)->where('estado',1)->first();
  						$facturacion = DB::table('facturacion')->where('servicio_id',$servicio->id)->first();

  						if ($reconfirmacion!=null) {

  							if($reconfirmacion->ejecutado===1){
  								echo '<small class="text-info">EJECUTADO</small><br>';
  							}else{
  								echo '<small class="text-success">PROGRAMADO</small><br>';
  							}

  						}else{
  							echo '<small class="text-success">PROGRAMADO</small><br>';
  						}

  						if ($facturacion!=null) {

                if($facturacion->revisado===1){
                    echo '<small class="text-danger">REVISADO</small><br>';
                }
                if ($facturacion->liquidado===1) {
                	 echo '<small class="text-danger">LIQUIDADO</small><br>';
                }

                if ($facturacion->revisado===1 and $facturacion->liquidado===1 and ($facturacion->facturado===0 or $facturacion===null)) {
                	echo '<small style="color: #EC0000">SIN FACTURAR</small>';
                }

                if ($facturacion->facturado===1) {
                    echo '<small class="text-info">FACTURADO</small>';
                }

              }else{
                  if($servicio->rechazar_eliminacion===1){
                      echo '<div data-id="'.$servicio->id.'" class="bolder btn-rechazado">RECHAZADO</div>';
                  }
              }

              if($permisos->barranquilla->novedadbq->ver==='on'):
                  if ($novedades!=null):
                      echo '<a data-id="'.$servicio->id.'" href="#" style="margin-bottom: 2px;" class="ver_novedad btn"><small>NOVEDAD</small></a>';
                  endif;
              else:
                  if ($novedades!=null):
                      echo '<a class="ver_novedad btn disabled" style="margin-bottom: 2px;"><small>NOVEDAD</small></a>';
                  endif;
              endif;

              if ($novedades_app!=null) {
                echo '<a class="btn boton-novedad-app ver_novedad_app" data-servicio-id="'.$servicio->id.'"><small>NOVEDAD APP</small></a>';
              }


              if($servicio->pago_directo===1){
                  echo '<br><small class="bolder">PAGO DIRECTO</small>';
              }
  						if($servicio->documento_pdf1 != null){

  							echo'<br><a href="../biblioteca_imagenes/servicios_autorizados/'.$servicio->documento_pdf1.'" target="_blank">Solicitud_PDF</a><br>';
  						}
  						if($servicio->documento_pdf2 != null){
  							echo'<a href="../biblioteca_imagenes/servicios_autorizados/'.$servicio->documento_pdf2.'" target="_blank">Correo_PDF</a><br>';

  						}
  						?>
  					</td>
  					<td>
              @if($servicio->estado_servicio_app==2)
                <a style="font-size: 11px; padding: 5px 7px; margin-bottom: 5px;" target="_blank" href="{{url('facturacion/exportarconstancia/'.$servicio->id)}}" class="btn btn-danger">
                    CONSTANCIA
                </a>
              @endif
              <a style="font-size: 11px; padding: 5px 7px;" class="btn btn-default" href="{{url('facturacion/revisar/'.$servicio->id)}}">Revisar</a>
            </td>

  				</tr>
  			@endforeach
  			</tbody>
  		</table>

      <a title="Ir a Revisar los Servicios Seleccionados" id="" style="padding: 8px 8px; float: right; margin-bottom: 30px" class="btn btn-info revisar_seleccion">Revisar Selección <i class="fa fa-pencil-square-o"></i></a>

  	</div>
	@endif

</div>

<div class="novedad_container hidden">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>NOVEDAD</strong><i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i>
      </div>
      <div class="panel-body">
            <h4 class="list-group-item-heading" id="seleccion_opcion"></h4>
            <small style="font-size: 12px" class="text-success" id="created_at"></small><br>
            <small style="font-size: 12px" class="text-info" id="usuario_novedad"></small><br>
            <span class="input-font" id="descripcion"></span><br>
      </div>
      <div class="panel-footer">
        <a id="exportarpdf" class="btn btn-danger btn-icon">PDF<i class="fa fa-file-pdf-o icon-btn"></i></a>
      </div>
    </div>
  </div>
</div>

<div class="novedad_container_app hidden">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>NOVEDAD APP</strong><i style="float: right; font-weight:100" class="fa fa-close cerrar_popup"></i>
      </div>
      <div class="panel-body">
        <ul class="list-group" id="novedades_app_list"></ul>
        <ul class="list-group" id="novedades_app_user"></ul>
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
                    <label>Escriba las razones por las cuales se va a eliminar este servicio.</label>
                    <textarea disabled id="input_motivo_rechazo" cols="30" rows="10" class="form-control input-font"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@include('scripts.scripts')

@include('otros.firebase_cloud_messaging')


<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>

<script type="text/javascript">

  $('.select_all').change(function(e){
      if ($(this).is(':checked')) {
          $('#example tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 11:
                          $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);
                      break;
                  }
              });
          });
      }else if(!$(this).is(':checked')){
          $('#example tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 11:
                          $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);
                      break;
                  }
              });
          });
      }
  });

  $('.revisar_seleccion').click(function(e) {

    var idArray = [];
    var dt = '';

    $('#example tbody tr').each(function(index){

      $(this).children("td").each(function (index2){
          switch (index2){
              case 11:
                  var $objeto = $(this).find('.services');

                  if ($objeto.is(':checked')) {
                      idArray.push($objeto.attr('data-id'));
                      dt += $objeto.attr('data-id')+',';
                  }

              break;
          }
      });

    });

    //console.log(idArray)
    //console.log(dt)

    if(dt!=''){
      location.href = "../facturacion/revisarseleccion/"+idArray;
    }else{

      $.confirm({
          title: 'Atención',
          content: '¡No has seleccionado ningún servicio!',
          buttons: {
              confirm: {
                  text: 'Ok',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){


                  }

              }
          }
      });

    }

  });

</script>

</body>
</html>
