<html>
<head>
	<meta charset="UTF-8">
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Liquidacion</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	@include('scripts.styles')
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
		  <h3 class="h_titulo">LISTADO DE ORDENES DE SERVICIOS REVISADAS</h3>
		</div>
	</div>
	<form class="form-inline" id="form_buscar" action="{{url('facturacion/exportarlistadocorteservicios')}}" method="post">
        <div class="col-lg-12" style="margin-bottom: 5px">
            <div class="row">
            		<!--<div class="form-group">
                    <select style="width: 109px;" class="form-control input-font" name="tipo_afiliado">
                        <option value="0">TIPO AFILIADO</option>
                        <option value="1">TODOS</option>
                        <option value="2">AFILIADOS INTERNO</option>
                        <option value="3">AFILIADOS EXTERNO</option>
                    </select>
                </div>-->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group date datetime_fecha">
                            <input id="fecha_inicial" name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                            <input id="fecha_final" name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                 		<option value="1">NO LIQUIDADOS</option>
                 		<option value="2">NO FACTURADOS</option>
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
                        @if(isset($centrosdecosto))
	                        @foreach($centrosdecosto as $centrodecosto)
	                            <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
	                        @endforeach
	                    @endif
                    </select>
                </div>
                <div class="form-group">
                    <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="ciudades" style="width: 107px;" name="ciudades" class="form-control input-font">
                        <option>CIUDADES</option>
                        @if(isset($ciudades))
	                        @foreach($ciudades as $ciudad)
	                            <option>{{$ciudad->ciudad}}</option>
	                        @endforeach
	                    @endif
                    </select>
                </div>
                <div class="form-group">
                    <select style="width: 107px;" class="form-control input-font" name="usuario">
                        <option value="0">USUARIOS</option>
                        @if(isset($usuarios))
	                        @foreach($usuarios as $usuario)
	                            <option value="{{$usuario->id}}">{{$usuario->first_name.' '.$usuario->last_name}}</option>
	                        @endforeach
	                    @endif
                    </select>
                </div>
				<!-- EXPEDIENTE -->
				<div class="form-group expedientes hidden">
                    <select style="width: 107px;" class="form-control input-font" id="expedientes" name="expedientes">
                        <option>EXPEDIENTES</option>
                        <!--@if(isset($expedientes))
	                        @foreach($expedientes as $expediente)
	                            <option value="{{$usuario->id}}">{{$usuario->first_name.' '.$usuario->last_name}}</option>
	                        @endforeach
	                    @endif-->
                    </select>
                </div>
				<!-- EXPEDIENTE -->
                <button id="buscar_liquidacion" class="btn btn-default btn-icon input-font">
                    Buscar<i class="fa fa-search icon-btn"></i>
                </button>
								<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
            </div>
        </div>
    </form>

    @if(isset($servicios))
	<div class="tabla">
		<table id="example2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Fecha servicio</th>
				<th>Numero orden</th>
				<th>Pax</th>
				<th>Proveedor</th>
				<th>Recoger en</th>
				<th>Dejar en</th>
				<th>Cliente</th>
				<th>Observacion</th>
				<th>Unitario cobrado</th>
				<th>Unitario Pagado</th>
				<th>Total Cobrado</th>
				<th>Total Pagado</th>
				<th>Utilidad</th>
				<th>Revision <input style="font-size: 40px" type="checkbox" id="cbox1" class="select_all" value="second_checkbox"></th>
				<th>Rentabilidad</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th>Fecha servicio</th>
				<th>Numero orden</th>
				<th>Pax</th>
				<th>Proveedor</th>
				<th>Recoger en</th>
				<th>Dejar en</th>
				<th>Cliente</th>
				<th>Observacion</th>
				<th>Unitario cobrado</th>
				<th>Unitario Pagado</th>
				<th>Total Cobrado</th>
				<th>Total Pagado</th>
				<th>Utilidad</th>
				<th>Revision</th>
				<th>Rentabilidad</th>
			</tr>
			</tfoot>
			<tbody>

			@foreach($servicios as $servicio)
				<tr id="{{$servicio->id}}">
					<td>{{$servicio->fecha_servicio}}</td>
					<td>{{$servicio->numero_planilla}}</td>
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

							echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';

						}

						?>

						{{$servicio->pasajeros()}}
					</td>
					<td>
						<a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonproveedor}}</a><br>
						<a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
					</td>
					<td>
						@if($servicio->desde!=null)
							{{$servicio->desde}}

						@else
							{{$servicio->recoger_en}}
						@endif

					</td>
					<td>
						@if($servicio->hasta!=null)
							{{$servicio->hasta}}
						@else
							{{$servicio->dejar_en}}
						@endif
					</td>
					<td class="bolder">
						@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}}
						@else {{$servicio->razonsocial.'<br><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}
						@endif
					</td>
					<td>{{$servicio->observacion}}</td>
					<td><input data-facturacion-id="{{$servicio->servicio_id}}" type="text" class="form-control input-font unitario_cobrado" value="@if($servicio->unitario_cobrado===null or $servicio->unitario_cobrado===0){{'0'}}@else{{number_format($servicio->unitario_cobrado)}}@endif"></td>
					<td><input data-facturacion-id="{{$servicio->servicio_id}}" type="text" class="form-control input-font unitario_pagado" value="@if($servicio->unitario_pagado===null or $servicio->unitario_pagado===0){{'0'}}@else{{number_format($servicio->unitario_pagado)}}@endif"></td>
					<td><input disabled type="text" class="form-control input-font total_cobrado" value="@if($servicio->total_cobrado===null or $servicio->total_cobrado===0){{'0'}}@else{{number_format($servicio->total_cobrado)}}@endif"></td>
					<td><input disabled type="text" class="form-control input-font total_pagado" value="@if($servicio->total_pagado===null or $servicio->total_pagado===0){{'0'}}@else{{number_format($servicio->total_pagado)}}@endif"></td>
					<td><input disabled type="text" class="form-control input-font utilidad" value="@if($servicio->utilidad===null or $servicio->utilidad===0){{'0'}}@else{{number_format($servicio->utilidad)}}@endif"></td>
					<td>
						@if($permisos->facturacion->liquidacion->liquidar==='on')
							<a ruta="@if($servicio->nombresubcentro==='RUTAS'){{'1'}}@else{{'0'}}@endif"  hora_servicio="{{$servicio->hora_servicio}}" style="color: @if(intval($servicio->facturado)===1){{'none'}}@elseif(intval($servicio->liquidado)===1){{'green'}} @endif" data-id-facturacion="{{$servicio->servicio_id}}" data-liquidado="@if($servicio->liquidado===null){{'0'}}@elseif($servicio->liquidado!=null){{$servicio->liquidado}}@endif" class="btn-default btn liquidar input-font btn-icon @if(intval($servicio->facturado)===1 or intval($servicio->liquidado_autorizado)===1){{'disabled'}}@endif">
								@if(intval($servicio->facturado)===1){{'FACTURADO'}}@elseif(intval($servicio->liquidado)===1){{'REALIZADO'}}@else{{'LIQUIDAR'}}@endif
								<span class="icon-btn">
									<i style="padding: 10px 0px 9px 0px; color: @if(intval($servicio->facturado)===1){{'none'}}@elseif(intval($servicio->liquidado)===1){{'green'}} @endif" class="fa fa-@if(intval($servicio->facturado)===1){{'file'}}@elseif(intval($servicio->liquidado)===1){{'check'}}@else{{'calculator'}}@endif">
									</i>
								</span>
							</a>
						@else
							<a style="color: @if(intval($servicio->facturado)===1){{'none'}}@elseif(intval($servicio->liquidado)===1){{'green'}} @endif" class="btn-default btn liquidar input-font btn-icon disabled">
								@if(intval($servicio->facturado)===1){{'FACTURADO'}}@elseif(intval($servicio->liquidado)===1){{'REALIZADO'}}@else{{'LIQUIDAR'}}@endif
								<span class="icon-btn">
								<i style="padding: 10px 0px 9px 0px; color: @if(intval($servicio->facturado)===1){{'none'}}@elseif(intval($servicio->liquidado)===1){{'green'}} @endif" class="fa fa-@if(intval($servicio->facturado)===1){{'file'}}@elseif(intval($servicio->liquidado)===1){{'check'}}@else{{'calculator'}}@endif">
								</i>
							</span>
							</a>
						@endif
					</td>
				  <td>
						<?php
							$color = '';
							$rentabilidad = 0;
							if (floatval($servicio->total_cobrado!=0)) {
									$rentabilidad = round(((floatval($servicio->utilidad)/floatval($servicio->total_cobrado))*100),1);
							}

							if ($rentabilidad>=30) {
								$color = 'green';
							}else if($rentabilidad<30 and $rentabilidad>20){
								$color = '#337ab7';
							}else if ($rentabilidad<=20) {
								$color = '#a94442';
							}
						?>
						<a data-id="21106" data-autorizado="1" class="btn btn-default input-font rentabilidad disabled">
							<span style="display: inline-block; vertical-align: bottom; margin-right: 5px; color: {{$color}}">
								<span class="bolder">@if(intval($servicio->total_cobrado)!=0){{$rentabilidad = round(((floatval($servicio->utilidad)/floatval($servicio->total_cobrado))*100),1)}}@else{{'0'}}@endif%</span>
							</span>
							<input @if(intval($servicio->liquidado_autorizado)===1){{'checked="checked"'}}@endif @if(intval(Sentry::getUser()->id)!=12){{'disabled'}}@endif type="checkbox" style="vertical-align: top; margin-top: 1px; cursor: pointer;">

						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<a title="Ir a Revisar los Servicios Seleccionados" id="" style="padding: 8px 8px; float: right; margin-bottom: 30px" class="btn btn-success revisar_seleccion">Liquidar Selección <i class="fa fa-pencil-square-o"></i></a>

	</div>
	<div class="col-lg-5" style="margin-top: 20px">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">DATOS DE LIQUIDACION</div>
				<div class="panel-body">
					<table style="margin-bottom: 10px" class="table table-bordered hover">
						<?php
							$total_generado_cobrado = 0;
							$total_generado_pagado = 0;
							$total_generado_utilidad = 0;

							foreach ($servicios as $servicio){
								$total_generado_cobrado = $total_generado_cobrado + $servicio->total_cobrado;
								$total_generado_pagado = $total_generado_pagado + $servicio->total_pagado;
								$total_generado_utilidad = $total_generado_utilidad + $servicio->utilidad;
							}

						?>
						    <tr>
						    	<td>TOTAL GENERADO COBRADO</td>
						    	<td><span class="span-total" id="total_generado_cobrado"><?php echo '$ '.number_format(intval($total_generado_cobrado)); ?></span></td>
						    </tr>
						    <tr>
						    	<td>TOTAL GENERADO PAGADO</td>
						    	<td><span class="span-total" id="total_generado_pagado"><?php echo '$ '.number_format(intval($total_generado_pagado)); ?></span></td>
						    </tr>
						    <tr>
						    	<td>TOTAL GENERADO UTILIDAD</td>
						    	<td><span class="span-total" id="total_generado_utilidad"><?php echo '$ '.number_format(intval($total_generado_utilidad)); ?></span></td>
						    </tr>
							<tr>
						    	<td>OTROS INGRESOS</td>
						    	<td><input id="otros_ingresos_valor" type="text" class="form-control input-font " style="width: 130px;" value="0"></td>
						    </tr>
							<tr>
						    	<td>OTROS COSTOS</td>
						    	<td><input id="otros_costos_valor" type="text" class="form-control input-font " style="width: 130px;" value="0"></td>
						    </tr>
							<tr>
						    	<td>OTRAS UTILIDADES</td>
						    	<td><span class="span-total" id="otras_utilidades">$ 0</span></td>
						    </tr>
					</table>
					<div class="form-group">
						<label>Observaciones</label>
						<textarea id="observaciones" class="form-control input-font" rows="5"></textarea>
					</div>
					@if($permisos->facturacion->liquidacion->generar_liquidacion==='on')
						<a id="generar_liquidacion" class="btn btn-info btn-icon input-font disabled">GENERAR LIQUIDACION<i class="fa fa-file-text-o icon-btn"></i></a>
						<a id="reliquidacion" class="btn btn-info btn-icon input-font disabled">RELIQUIDAR<i class="fa fa-file-text-o icon-btn"></i></a>
					@else
						<a class="btn btn-info btn-icon input-font disabled">GENERAR LIQUIDACION<i class="fa fa-file-text-o icon-btn"></i></a>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif
</div>
<div id="prefactura_container" class="hidden">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Facturacion <i id="cerrar_alerta_sino" style="cursor: pointer; float: right; font-weight:100" class="fa fa-close"></i></div>
			<div class="panel-body">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="row">
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<label>Seleccione el numero de pre-facturas que desea realizar</label>
								</div>
							</div>
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
								<div class="row">
									<div class="form-group">
										<select id="numero_facturas" type="text" class="form-control input-font">
											<option value="0">-</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
										</select>
									</div>
								</div>
							</div>
							<div id="factura_valores" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<fieldset><legend>Totales</legend>
										<div>
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
												<div class="row">
													<div class="form-group">
														<label>Totales cobrado</label>
														<input disabled id="t_gen_cobrado" type="text" class="form-control input-font">
													</div>
												</div>
											</div>
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
												<div class="form-group">
													<label>Totales pagado</label>
													<input disabled id="t_gen_pagado" type="text" class="form-control input-font">
												</div>
											</div>
											<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
												<div class="row">
													<div class="form-group">
														<label>Totales utilidad</label>
														<input disabled id="t_gen_utilidad" type="text" class="form-control input-font">
													</div>
												</div>
											</div>
										</div>
									</fieldset>
									<fieldset><legend>Facturas</legend>
										<div id="facturas_lista">
										</div>
									</fieldset>
									<button id="generar_preliquidacion" class="btn btn-default btn-icon">GENERAR <i class="fa fa-file-text-o icon-btn"></i></button>

								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
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

<div id="motivo_rechazo" class="hidden">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Servicios sin Revisar <i id="cerrar_alerta_sino" style="float: right; cursor: pointer" class="fa fa-close"></i><br>
				<span style="color: blue;">Bogotá - </span><span style="color: green">Barranquilla</span></div>
			<div class="panel-body-page" style="height: 150px;">
				<label></label><br>

			</div>
		</div>
	</div>
</div>

@if(Session::get('mensaje'))
<div class="guardado bg-success text-success model" style="background: white; border: 1px solid #bfb8b8; color: gray;">
		<i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
		{{$mensaje = Session::get('mensaje')}}
</div>
@endif

@include('scripts.scripts')
@include('otros.firebase_cloud_messaging')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>
<script>
	$('#example2').on('onmouseover', '.liquidar', function () {
		alert('hover');
	});

	$('.select_all').change(function(e){
      if ($(this).is(':checked')) {
          $('#example2 tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 13:
                          $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);
                      break;
                  }
              });
          });
      }else if(!$(this).is(':checked')){
          $('#example2 tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 13:
                          $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);
                      break;
                  }
              });
          });
      }
  });

	$('.revisar_seleccion').click(function(e) {

    var idArray = [];
		var cobradoArray = [];
    var dt = '';

    $('#example2 tbody tr').each(function(index){

      $(this).children("td").each(function (index2){
          switch (index2){

							case 8:
									var $objeto = $(this).find('.services');
									//var $objetos = $(this).find('.unitario_cobrado');
									var $objetos = $(this).closest('tr');

									if ($objeto.is(':checked')) {
											idArray.push($objeto.attr('data-id'));
											dt += $objeto.attr('data-id')+',';

											var $objetos = $(this).find('.unitario_cobrado');
											console.log($objetos.val())
											//cobradoArray.push($objetos.find('.unitario_cobrado').val().trim().replace(',','').replace(',','').replace(',',''))
											cobradoArray.push($objetos.val())
									}

							break;

              case 13:
                  var $objeto = $(this).find('.services');

                  if ($objeto.is(':checked')) {
                      idArray.push($objeto.attr('data-id'));
                      dt += $objeto.attr('data-id')+',';
											//$objeto.find('.unitario_cobrado').val(number_format(unitario_cobrado)).attr('value',unitario_cobrado);
                  }

              break;


          }
      });

    });

		//test
		var cobradoArray = [];
		var pagadoArray = [];
		var utilidadArray = [];

		$('#example2 tbody tr').each(function () {

			var $objeto = $(this).find('td').eq(13).find('.services');

			if ($objeto.is(':checked')) {

				var valueCobrado = $(this).find('td').eq(8).find('.unitario_cobrado').val();
				var valuePagado = $(this).find('td').eq(9).find('.unitario_pagado').val();
				var valueUtilidad = $(this).find('td').eq(12).find('.utilidad').val();

				cobradoArray.push(valueCobrado.replace(',','').replace(',','').replace(',',''))
				pagadoArray.push(valuePagado.replace(',','').replace(',','').replace(',',''))
				utilidadArray.push(valueUtilidad.replace(',','').replace(',','').replace(',',''))

			}

    });

		console.log(cobradoArray);
		console.log(pagadoArray);

		//test

		console.log(idArray);

    if(dt!=''){

			$.ajax({
				url: '../facturacion/liquidarmasivo',
				method: 'post',
				data: {idArray: idArray, cobradoArray: cobradoArray, pagadoArray: pagadoArray, utilidadArray: utilidadArray}
			}).done(function(data){

				if(data.respuesta==true){

					$.confirm({
							title: 'Atención',
							content: 'Se han liquidado los servicios!!!',
							buttons: {
									confirm: {
											text: 'Ok',
											btnClass: 'btn-primary',
											keys: ['enter', 'shift'],
											action: function(){

												location.reload();

											}

									}
							}
					});

				}else if(data.respuesta==false){

				}

			});

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

	$('#expedientes').change(function(){

		var sc = $(this).val(); //Valor del

		var html = $('#expedientes option:selected').attr('data-expediente'); //Valor del expediente

		$('#subcentrodecosto_search').val(sc); //Aignación del subcentro que corresponde a ese expediente

		$.ajax({
            method: 'post',
            url: '../transportesrutas/consultarfechas',
            data: {'expediente':html},
            dataType: 'json',
            success: function (data) {

                if(data.respuesta===true){

                    $('#fecha_inicial').val(data.fecha_inicial)
                    $('#fecha_final').val(data.fecha_final)

                }else if(data.respuesta===false){

                	var btn = '';

                	for(var i in data.servicios){
                		if(data.servicios[i].localidad!=1){
                			var color = 'success';
                		}else{
                			var color = 'primary';
                		}
                		btn += '<a style="margin: 12px" target="_blank" href="{{url("facturacion/revisar/'+data.servicios[i].id+'")}}" class="btn-'+color+' btn">'+data.servicios[i].id+'</a>';

                	}

                	$('.panel-body-page').html('').append(btn);

                	$('#motivo_rechazo').removeClass('hidden');
                	//alert('Hay '+data.cantidad+' servicios sin revisar!\n<a href="app.aotour.com.co/autonet"></a>');
                }

            }
        });
    });

		$('#example2').on('keyup', '.unitario_cobrado, .unitario_pagado', function(e){
      valor = $(this).val();
			var value = $(this).attr('data-facturacion-id')

			if(e.which == 48 || e.which == 49 || e.which == 50 || e.which == 51 || e.which == 52 || e.which == 53 || e.which == 54 || e.which == 55 || e.which == 56 || e.which == 57 || e.which == 96 || e.which == 97 || e.which == 98 || e.which == 99 || e.which == 100 || e.which == 101 || e.which == 102 || e.which == 103 || e.which == 104 || e.which == 105 ) {
				$('#example2 tbody tr').each(function(index){

	            $(this).children("td").each(function (index2){

	                switch (index2){

	                  case 13:
												var id = $(this).find('.liquidar').attr('data-id-facturacion');
												//alert(value)
												//alert(id)
												if(value===id) {
													$(this).find('.liquidar').removeClass('btn-default btn liquidar').addClass('btn-warning btn liquidar')
												}
												break;
	                }
	            });
	        });
			}
    });

</script>
</body>
</html>
