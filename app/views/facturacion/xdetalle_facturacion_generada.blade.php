	<html>
<head>
	<title>Autonet | Detalles Facturacion</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
<link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">

<body>
@include('admin.menu')
<div class="col-lg-12">
<h3 class="h_titulo">DETALLE DE ORDEN DE FACTURACION GENERADA</h3>

@if(isset($ordenes_facturacion))

	@if(intval($ordenes_facturacion->tipo_orden)===1)

	<div class="col-lg-4">
		<div class="row">
			<table class="table tabla" style="margin-bottom:0px">
				<tbody>
					<tr>
						<td>NUMERO DE ORDEN</td>
						<td><span style="color: #F47321;">{{$ordenes_facturacion->consecutivo}}</span></td>
					</tr>
					<tr>
						<td>FECHA INICIAL</td>
						<td>{{$ordenes_facturacion->fecha_inicial}}</td>
					</tr>
					<tr>
						<td>CENTRO DE COSTO</td>
						<td>{{$ordenes_facturacion->razonsocial}}</td>
					</tr>
					<tr>
						<td>NUMERO FACTURA</td>
						<td>{{$ordenes_facturacion->numero_factura}}</td>
					</tr>
					<tr style="border-bottom: 1px solid #ddd;">
						<td>FECHA DE VENCIMIENTO</td>
						<td>{{$ordenes_facturacion->fecha_vencimiento}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="row">
			<table class="table tabla" style="margin-bottom:0px">
				<tbody>
					<tr>
						<td>TIPO DE ORDEN</td>
						<td>@if(intval($ordenes_facturacion->tipo_orden)===1){{'TRANSPORTE'}}@endif</td>
					</tr>
					<tr>
						<td>FECHA FINAL</td>
						<td>{{$ordenes_facturacion->fecha_final}}</td>
					</tr>
					<tr>
						<td>CIUDAD</td>
						<td>{{$ordenes_facturacion->ciudad}}</td>
					</tr>
					<tr style="border-bottom: 1px solid #ddd;">
						<td>FECHA DE FACTURA</td>
						<td>{{$ordenes_facturacion->fecha_factura}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="row">
				<p style="text-align: center; margin-top:10px" class="subtitulo">CRONOGRAMA DE FACTURACION DE SERVICIOS DEL {{$ordenes_facturacion->fecha_inicial.' '.$ordenes_facturacion->fecha_final}}</p>
		</div>
	</div>

	@if(isset($servicios))

	<table class="table table-bordered table-hover tabla" style="margin-bottom:0px">
		<thead>
			<tr>
				<td>FECHA</td>
				<td>NUMERO DE ORDEN</td>
				<td>PASAJERO</td>
				<td>PROVEEDOR</td>
				<td>AP PROVEEDOR</td>
				<td>OBSERVACION</td>
				<td>UNITARIO COBRADO</td>
				<td>UNITARIO PAGADO</td>
				<td>TOTAL COBRADO</td>
				<td>TOTAL PAGADO</td>
				<td>UTILIDAD</td>
			</tr>
		</thead>
		<tbody>
			@foreach($servicios as $servicio)
			<tr>
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
					<a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonsocial}}</a><br>
					<a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
				</td>
				<td>
					@if($servicio->consecutivo!=null)
						<span class="bolder" style="font-size: 10px; color: #F47321">
						#: {{$servicio->consecutivo}}</span><br>
						@if(intval($servicio->revisado)===1)
							{{'<span class="bolder" style="font-size: 10px; color: #409641">REVISADO</span>'}}
						@else
							{{'<span class="bolder" style="font-size: 10px; color: #dc3e3b;">SIN REVISION</span>'}}
						@endif
						@if(intval($servicio->programado)===1)
							{{'<br><span class="bolder" style="font-size: 10px; color: #3e92bb;">PROGRAMADO PARA PAGO</span>'}}
						@endif
						@if(intval($servicio->autorizado)===1)
							{{'<br><span class="bolder" style="font-size: 10px; color: white; background-color: #409641; padding: 3px; border-radius: 4px; display: inline-block;">PAGADO<i style=" margin-left: 2px" class="fa fa-check"></i></span>'}}
						@elseif(intval($servicio->auditado)===1)
							{{'<br><span class="bolder" style="font-size: 10px; color: #b79f41;">PAGO AUDITADO</span>'}}
						@elseif(intval($servicio->preparado)===1)
							{{'<br><span class="bolder" style="font-size: 10px; color: #24649a;">PAGO PREPARADO</span>'}}
						@endif
					@else
						{{'<span class="bolder" style="color: #dc3e3b; font-size: 10px">SIN AP</span>'}}
					@endif</td>
				<td>{{$servicio->observacion}}</td>
				<td>{{$servicio->unitario_cobrado}}</td>
				<td>{{$servicio->unitario_pagado}}</td>
				<td>{{$servicio->total_cobrado + $ordenes_facturacion->otros_ingresos}}</td>
				<td>{{$servicio->total_pagado}}</td>
				<td>{{$servicio->utilidad}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="col-lg-4" style="margin-top:10px">
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
							    	<td><span id="total_generado_cobrado"><?php echo '$ '.number_format(floatval($total_generado_cobrado)); ?></span></td>
							    </tr>
									<!-- <tr>
							    	<td>TOTAL GENERADO COBRADO + OTROS INGRESOS</td>
							    	<td><span id="total_generado_cobrado"><?php echo '$ '.number_format(floatval($total_generado_cobrado+$ordenes_facturacion->otros_ingresos)); ?></span></td>
							    </tr> -->
							    <tr>
							    	<td>TOTAL GENERADO PAGADO</td>
							    	<td><span id="total_generado_pagado"><?php echo '$ '.number_format(floatval($total_generado_pagado)); ?></span></td>
							    </tr>
							    <tr>
							    	<td>TOTAL GENERADO UTILIDAD</td>
							    	<td><span id="total_generado_utilidad"><?php echo '$ '.number_format(floatval($total_generado_utilidad)); ?></span></td>
							    </tr>
									<tr>
							    	<td>OTROS INGRESOS</td>
							    	<td><span><?php echo '$ '.number_format(floatval($ordenes_facturacion->otros_ingresos)); ?></span></td>
							    </tr>
									<tr>
							    	<td>OTROS COSTOS</td>
							    	<td><span><?php echo '$ '.number_format(floatval($ordenes_facturacion->otros_costos)); ?></span></td>
							    </tr>
									<tr>
							    	<td>TOTAL RENTABILIDAD</td>
							    	<td>
											<span id="total_generado_utilidad">
												<?php
														if ($total_generado_cobrado > 0) {
																$rentabilidad = ($total_generado_utilidad/$total_generado_cobrado)*100;
																echo round($rentabilidad,2).' %';
														 } else {
																echo "0 %";
																}
												?>
										  </span>
									</td>
							    </tr>
						</table>
						<div class="form-group" style="margin-bottom: 5px">
							<label>Observaciones</label>
							<textarea class="form-control">{{$ordenes_facturacion->observaciones}}</textarea>
						</div>
						<label>Ingreso Cliente</label>
						<table class="table-bordered table">
							<tr>
								<td>FECHA DE INGRESO</td>
								<td>
									<input type="text" name="name" class="form-control input-font" disabled value="{{$ordenes_facturacion->fecha_ingreso}}">
								</td>
							</tr>
							<tr>
								<td>MODO DE INGRESO</td>
								<td>
									<select class="form-control input-font" disabled>
										@if($ordenes_facturacion->modo_ingreso==='CHEQUE')
											<option>CHEQUE</option>
										@endif
										@if($ordenes_facturacion->modo_ingreso==='EFECTIVO')
											<option>EFECTIVO</option>
										@endif
										@if($ordenes_facturacion->modo_ingreso==='TRANSFERENCIA')
											<option>TRANSFERENCIA</option>
										@endif
										@if($ordenes_facturacion->modo_ingreso==='TARJETA DE CREDITO')
											<option>TARJETA DE CREDITO</option>
										@endif
										@if($ordenes_facturacion->modo_ingreso==='TARJETA DE DEBITO')
											<option>TARJETA DE DEBITO</option>
										@endif
										@if($ordenes_facturacion->modo_ingreso==='DESCUENTO')
											<option>DESCUENTO</option>
										@endif
									</select>
								</td>
							</tr>
							<tr>
								<td>DOCUMENTO</td>
								<td><input type="text" class="form-control input-font" name="name" value="{{$ordenes_facturacion->recibo_caja}}" disabled></td>
							</tr>
							<?php
							if($ordenes_facturacion->foto_ingreso!=null):
								$array = json_decode($ordenes_facturacion->foto_ingreso);
								if (is_array($array)){
									foreach ($array as $arr):
										echo '<tr>'.
												'<td>'.$arr->detalle.'</td>'.
												'<td><button data-img="'.$arr->nombre_imagen.'" data-id="'.$ordenes_facturacion->id.'" class="btn btn-default ver_ingreso">VER IMAGEN</button></td>'.
												'</tr>';
									endforeach;
								}else{
									echo '<tr>'.
											'<td>INGRESO # 1</td>'.
											'<td><button data-img="'.$ordenes_facturacion->foto_ingreso.'" data-id="'.$ordenes_facturacion->id.'" class="btn btn-default ver_ingreso">VER IMAGEN</button></td>'.
											'</tr>';
								}

							endif;
							?>
						</table>

					</div>
				</div>
			</div>
	</div>

	@endif

	@elseif(intval($ordenes_facturacion->tipo_orden)===2)

	<div class="col-lg-12">
		<div class="row">
		    <div class="col-lg-10">
				<div class="row">
					<div class="panel panel-primary">
						<div class="panel-heading"><strong>OTROS SERVICIOS</strong></div>
						<div class="panel-body">
							<fieldset style="margin-bottom: 15px;"><legend>Informacion Basica</legend>
								<div class="row">
									<div class="col-xs-2">
										<label for="fecha_orden" class="obligatorio">Fecha de orden</label>
										<div class="input-group">
											<div class="input-group date" id='datetimepicker1'>
												<input style="width: 147px" type='text' class="form-control input-font" id="fecha_orden" value="{{$otros_servicios_detalles->fecha}}" disabled>
											<span class="input-group-addon">
												<span class="fa fa-calendar">
												</span>
											</span>
											</div>
										</div>
									</div>
									<div class="col-xs-2">
										<label for="ciudad">Consecutivo</label>
										<input class="form-control input-font" value="{{$otros_servicios_detalles->consecutivo}}" disabled>

									</div>
									<div class="col-xs-2">
										<label for="n_factura">Numero Factura</label>
										<input class="form-control input-font" value="{{$ordenes_facturacion->numero_factura}}" disabled>

									</div>
									@if($ordenes_facturacion->razonsocial===$ordenes_facturacion->nombresubcentro)
									<div class="col-xs-3" id="centro_alerta">
										<label for="centro_de_costo">Centro de costo</label>
										<select class="form-control input-font" id="centro_de_costo" disabled>
											<option>{{$ordenes_facturacion->razonsocial}}</option>
										</select>
										<small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
									</div>

									@else
										<div class="col-xs-3" id="centro_alerta">
											<label for="centro_de_costo">Centro de costo</label>
											<select class="form-control input-font" id="centro_de_costo" disabled>
												<option>{{$ordenes_facturacion->razonsocial}}</option>
											</select>
											<small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
										</div>
										<div class="subcentros">
											<div class="col-xs-2">
												<label for="subcentros">Subcentro de costo</label>
												<select class="form-control input-font" id="subcentros" disabled>
													<option>{{$ordenes_facturacion->nombresubcentro}}</option>
												</select>
											</div>
										</div>
									@endif
									<?php

										if ($ordenes_facturacion->razonsocial==='PERSONA NATURAL') {

											$datos = DB::table('subcentrosdecosto')->where('nombresubcentro',$ordenes_facturacion->nombresubcentro)->first();
											echo '<div class="col-xs-2"><label>Identificacion</label><input disabled type="text" class="form-control input-font" value="'.$datos->identificacion.'"></div>';
											echo '<div class="col-xs-2"><label>Telefono</label><input disabled type="text" class="form-control input-font" value="'.$datos->telefono.'"></div>';
											echo '<div class="col-xs-2"><label>Celular</label><input disabled type="text" class="form-control input-font" value="'.$datos->celular.'"></div>';
											echo '<div class="col-xs-2"><label>Direccion</label><input disabled type="text" class="form-control input-font" value="'.$datos->direccion.'"></div>';
											echo '<div class="col-xs-3"><label>Email</label><input disabled type="text" class="form-control input-font" value="'.$datos->email_contacto.'"></div>';

										}

									?>
								</div>
							</fieldset>
							<fieldset id="servicios"><legend>Servicios</legend>
								<div class="otros">
									CLIENTE
									<table style="margin-bottom: 0" class="table table-hover table-bordered">
										<thead>
										<tr>
											<td>PRODUCTO</td>
											<td>DESTINO / DETALLE</td>
											<td>% COMISION</td>
											<td>VALOR COMISION</td>
											<td>DERIVADOS</td>
											<td>OTROS</td>
											<td>VALOR EN DOLARES</td>
											<td><b>TOTAL</b></td>

										</tr>
										</thead>
										<tbody id="servicios_otros">
											@foreach($otros_servicios as $otros)
												<tr>
													<td>{{$otros->producto}}</td>
													<td>{{$otros->destino_detalle}}</td>
													<td>{{$otros->porcentaje}}</td>
													<td>{{$otros->valor_comision}}</td>
													<td>{{$otros->iva_comision}}</td>
													<td>{{$otros->otros}}</td>
													<td>{{$otros->valor_dolares}}</td>
													<td><b>{{$otros->valor_comision+$otros->iva_comision+$otros->otros}}</b></td>

												</tr>
											@endforeach
										</tbody>
									</table></br>
									PROVEEDOR
									<table style="margin-bottom: 0" class="table table-hover table-bordered" >
										<thead>
											<tr>
												<td>PRODUCTO</td>
												<td>DESTINO / DETALLE</td>
												<td >VALOR</td>
												<td>IVA SERVICIO</td>
												<td>TASA AERO</td>
												<td>OTRAS TASAS</td>
												<td>IMPUESTOS</td>
												<td>DESCUENTOS</td>
												<td><b>TOTAL</b></td>
											</tr>
											</thead>
											<tbody id="servicios_otros2">
												@foreach($otros_servicios as $otros)
												<tr>
													<td>{{$otros->producto}}</td>
													<td>{{$otros->destino_detalle}}</td>
													<td>{{$otros->valor}}</td>
													<td>{{$otros->iva_servicio}}</td>
													<td>{{$otros->tasa_aero}}</td>
													<td>{{$otros->otras_tasas}}</td>
													<td>{{$otros->impuesto}}</td>
													<td>{{$otros->descuento}}</td>
													<td><b>{{intval($otros->valor)+intval($otros->iva_servicio)+intval($otros->tasa_aero)+intval($otros->otras_tasas)+intval($otros->impuesto)-intval($otros->descuento)}}</b></td>
												</tr>
												@endforeach
											</tbody>
										</table>
									<div></br>
										<div class="input-font total">
											<div style="margin-right: 68px; float: left" class="content-facturado">
												<label style="margin-bottom: 0">TOTAL FACTURADO</label><label style="color: #F47321; font-size: 15px; margin-left: 5px; margin-bottom: 0" id="total_facturado">{{'$ '.number_format($ordenes_facturacion->total_facturado_cliente)}}</label>
											</div>
											<div class="content-facturado">
												<label style="margin-bottom: 0">TOTAL UTILIDAD</label><label style="color: #F47321; font-size: 15px; margin-left: 5px; margin-bottom: 0" id="total_utilidad">{{'$ '.number_format($ordenes_facturacion->total_utilidad)}}</label>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset style="margin-top: 15px;"><legend>Informacion de pago</legend>
								<div class="row">
									<div id="informacion_pago">
										<div class="col-xs-2">
											<label for="fecha">Fecha</label>
											<div class="input-group">
												<div class="input-group date" id='datetimepicker1'>
													<input style="width: 147px" type='text' class="form-control input-font" id="fecha" value="{{date('Y-m-d')}}" disabled>
													<span class="input-group-addon">
														<span class="fa fa-calendar">
														</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-2">
											<label for="valor" class="obligatorio">Valor</label>
											<input type='text' class="form-control input-font" id="valor" value="{{$otros_servicios_detalles->valor}}" disabled>
										</div>
										<div class="col-xs-1">
											<label for="negocio" class="obligatorio"># Negocio</label>
											<input type='text' class="form-control input-font" id="negocio" value="{{$otros_servicios_detalles->negocio}}" disabled>
										</div>

										<div class="col-xs-1">
											<label for="tercero" class="obligatorio">Tercero</label>
											<select class="form-control input-font" id="tercero" disabled>
												@if(intval($otros_servicios_detalles->tercero)===1)
												<option>SI</option>
												@elseif(intval($otros_servicios_detalles->tercero)===2)
												<option>NO</option>
												@endif
											</select>
										</div>
										@if(intval($otros_servicios_detalles->tercero)===1)
										<div class="col-xs-2 nombre_tercero">
											<label for="nombre_tercero" class="obligatorio">Nombre del Tercero</label>
											<select id="id_tercero" class="form-control input-font" disabled>
												<option value="0">-</option>
												@foreach($terceros as $tercero)
													@if(intval($tercero->id)===intval($otros_servicios_detalles->id_tercero))
													<option selected value="{{$tercero->id}}">{{$tercero->nombre_completo}}</option>
													@else
													<option value="{{$tercero->id}}">{{$tercero->nombre_completo}}</option>
													@endif
												@endforeach
											</select>
										</div>
										@endif

										<div class="col-xs-2">
											<label for="pagado_proveedor">Pagado a Proveedor</label>
											<select disabled class="form-control input-font" id="pagado_proveedor">
												@if(intval($otros_servicios_detalles->pagado_proveedor)===1)
												<option value="1">EFECTIVO</option>
												@elseif(intval($otros_servicios_detalles->pagado_proveedor)===2)
												<option value="2">CREDITO</option>
												@elseif(intval($otros_servicios_detalles->pagado_proveedor)===3)
												<option value="3">NO APLICA</option>
												@endif
											</select>
										</div>

										<div class="col-xs-4">
											<label class="obligatorio">Forma de pago</label>
											<div class="input-group" style="margin-top: 7px">

												@if(intval($otros_servicios_detalles->forma_pago)===1)
												<label class="radio-inline input-font">
													<input disabled type="radio" checked name="inlineRadioOptions" id="inlineRadio1" value="1"> EFECTIVO
												</label>
												@else
												<label class="radio-inline input-font">
													<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> EFECTIVO
												</label>
												@endif

												@if(intval($otros_servicios_detalles->forma_pago)===2)
												<label class="radio-inline input-font">
													<input disabled type="radio" checked name="inlineRadioOptions" id="inlineRadio2" value="2"> CHEQUE
												</label>
												@else
												<label class="radio-inline input-font">
													<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2"> CHEQUE
												</label>
												@endif

												@if(intval($otros_servicios_detalles->forma_pago)===3)
												<label class="radio-inline input-font">
													<input disabled type="radio" checked name="inlineRadioOptions" id="inlineRadio3" value="3"> TARJETA DE CREDITO
												</label>
												@else
												<label class="radio-inline input-font">
													<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3"> TARJETA DE CREDITO
												</label>
												@endif

												@if(intval($otros_servicios_detalles->forma_pago)===4)
												<label class="radio-inline input-font">
													<input disabled type="radio" checked name="inlineRadioOptions" id="inlineRadio3" value="4"> CREDITO
												</label>
												@else
												<label class="radio-inline input-font">
													<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio3" value="4"> CREDITO
												</label>
												@endif

											</div>
										</div>
										<div class="col-xs-12">
											<div class="row">
												<div class="col-lg-6">
													<label for="concepto" class="obligatorio">Concepto</label>
													<textarea id="concepto" rows="5" class="form-control input-font disabled" >{{$otros_servicios_detalles->concepto}}</textarea>
												</div>
												<div class="col-xs-6">
													<label for="comentario">Comentarios</label>
													<textarea id="comentario" rows="5" class="form-control input-font" disabled>{{$otros_servicios_detalles->comentarios}}</textarea>
												</div>
												@if(intval($otros_servicios_detalles->forma_pago)===4)
												<div class="col-lg-3 autorizado_por">
													<label for="autorizado_por" class="obligatorio">Autorizado por</label>
													<select id="autorizado_por" class="form-control input-font" disabled>
														@if(intval($otros_servicios_detalles->autorizado_por)===1)
														<option>DAVID COBA</option>
														@endif
													</select>
												</div>
												<div class="col-lg-2 plazo">
													<label for="plazo" class="obligatorio">Plazo en dias</label>
													<input id="plazo" class="form-control input-font" disabled value="{{$otros_servicios_detalles->plazo}}">
												</div>
												@endif
											</div>
										</div>

										<div style="margin-top: 15px; " class="col-lg-4">
											<table class="table-bordered table" style="margin-bottom: 0px">
												<tr>
													<td>FECHA DE INGRESO</td>
													<td>
														<input type="text" name="name" class="form-control input-font" disabled value="{{$ordenes_facturacion->fecha_ingreso}}">
													</td>
												</tr>
												<tr>
													<td>MODO DE INGRESO</td>
													<td>
														<select class="form-control input-font" disabled>
															@if($ordenes_facturacion->modo_ingreso==='CHEQUE')
																<option>CHEQUE</option>
															@endif
															@if($ordenes_facturacion->modo_ingreso==='EFECTIVO')
																<option>EFECTIVO</option>
															@endif
															@if($ordenes_facturacion->modo_ingreso==='TRANSFERENCIA')
																<option>TRANSFERENCIA</option>
															@endif
															@if($ordenes_facturacion->modo_ingreso==='TARJETA DE CREDITO')
																<option>TARJETA DE CREDITO</option>
															@endif
															@if($ordenes_facturacion->modo_ingreso==='TARJETA DE DEBITO')
																<option>TARJETA DE DEBITO</option>
															@endif
															@if($ordenes_facturacion->modo_ingreso==='DESCUENTO')
																<option>DESCUENTO</option>
															@endif
														</select>
													</td>
												</tr>
												<tr>
													<td>DOCUMENTO</td>
													<td><input type="text" class="form-control input-font" name="name" value="{{$ordenes_facturacion->recibo_caja}}" disabled></td>
												</tr>
												<?php
												if($ordenes_facturacion->foto_ingreso!=null):
													$array = json_decode($ordenes_facturacion->foto_ingreso);
													if (is_array($array)){
														foreach ($array as $arr):
															echo '<tr>'.
																	'<td>'.$arr->detalle.'</td>'.
																	'<td><button data-img="'.$arr->nombre_imagen.'" data-id="'.$ordenes_facturacion->id.'" class="btn btn-default ver_ingreso">VER IMAGEN</button></td>'.
																	'</tr>';
														endforeach;
													}else{
														echo '<tr>'.
																'<td>INGRESO # 1</td>'.
																'<td><button data-img="'.$ordenes_facturacion->foto_ingreso.'" data-id="'.$ordenes_facturacion->id.'" class="btn btn-default ver_ingreso">VER IMAGEN</button></td>'.
																'</tr>';
													}

												endif;
												?>
											</table>

										</div>

									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
		    </div>
		</div>
    </div>

	@endif


@endif
<div style="top:50% !important" class="modal_ingreso_imagen hidden" id="alert_eliminar">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">Soporte de Ingreso <i id="cerrar" style="float: right;" class="fa-close fa"></i></div>
		<div class="panel-body">
			<img class="img-responsive" id="img_ingreso" src="">
		</div>
	</div>
</div>
</div>
</div>
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>
</body>
</html>
