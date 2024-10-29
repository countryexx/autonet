<html>
<head>
	<title>Autonet | Orden de facturacion</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
@include('scripts.styles')
<link rel="stylesheet" href=" {{url('bootstrap/css/datatables.css')}} ">
<link rel="stylesheet" href=" {{url('datatables/media/css/datatables.bootstrap.css')}} ">
<link rel="stylesheet" href=" {{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}} ">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')
<div class="container-fluid">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="row">
			<h3 class="h_titulo">ORDEN DE FACTURACION</h3>
			<label class="titulo_orden">NUMERO DE ORDEN</label>
			@if(isset($ordenes_facturacion))
				<label class="titulo_orden" style="color: #F47321"> {{$ordenes_facturacion->consecutivo}} - {{$ordenes_facturacion->numero_factura}} </label>
				<p style="margin-bottom:5px;" class="subtitulo">CIERRE DE PERIODO
					@if($ordenes_facturacion->razonsocial===$ordenes_facturacion->nombresubcentro)
						 {{$ordenes_facturacion->razonsocial}}
					@endif
					DEL  {{$ordenes_facturacion->fecha_inicial}}  AL  {{$ordenes_facturacion->fecha_final}}
					CIUDAD:  {{$ordenes_facturacion->ciudad}} </p>
				@if(intval(Sentry::getUser()->id_tipo_usuario)===1)
					@if(intval($ordenes_facturacion->anulado)===1)
					 <p style=" color: #FD0000;" class="text-danger subtitulo">
					NOTA CRÉDITO @if($ordenes_facturacion->anulado==1 and $ordenes_facturacion->diferencia>0){{'PARCIAL'}}@else{{'TOTAL'}}@endif REGISTRADA POR : {{$ordenes_facturacion->first_name.' '.$ordenes_facturacion->last_name}}</p>
					@endif
				@endif
				<div class="col-lg-4 col-md-6 col-sm-6" style="margin-bottom:10px">
					<div class="row">

						@if(intval($ordenes_facturacion->tipo_orden)===2)
							<?php
							$detalles_otros = DB::table('otros_servicios_detalles')->where('id_factura',$ordenes_facturacion->id)->first();
							$otros_servicios = DB::table('otros_servicios')->where('id_servicios_detalles',$detalles_otros->id)->get();

							?>
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
											<thead>
											<tr>
												<th class="titulo_orden">INFORMACION</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td>CONSECUTIVO</td>
												<td><p style="margin: 10px 0;"> {{$detalles_otros->consecutivo}} </p></td>
											</tr>
											@if($ordenes_facturacion->razonsocial==='PERSONA NATURAL')
											<tr>
												<td>IDENTIFICACION</td>
												<td><p style="margin: 10px 0;"> {{$ordenes_facturacion->identificacion}} </p></td>
											</tr>
											<tr>
												<td>CLIENTE</td>
												<td><p style="margin: 10px 0;"> {{$ordenes_facturacion->nombresubcentro}} </p></td>
											</tr>
											@else
											<tr>
												<td>CLIENTE</td>
												<td><p style="margin: 10px 0;">@if($ordenes_facturacion->razonsocial===$ordenes_facturacion->nombresubcentro) {{$ordenes_facturacion->razonsocial}} @else  {{$ordenes_facturacion->razonsocial.'/'.$ordenes_facturacion->nombresubcentro}}  @endif</p></td>
											</tr>
											@endif
											<tr>
												<td>FECHA DE SERVICIO</td>
												<td><p style="margin: 10px 0;"> {{$detalles_otros->fecha}} </p></td>
											</tr>
											<tr>
												<td>COMENTARIOS</td>
												<td><textarea class="form-control input-font" style="margin: 10px 0;"> {{$detalles_otros->comentarios}} </textarea></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="row">
										<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
											<table class="table table-hover tabla" style="margin-bottom:0px">
												<thead>
												<tr>
													<th class="titulo_orden">INGRESOS</th>
												</tr>
												</thead>
												<tbody>
												<tr>
													<td>TOTAL FACTURADO CLIENTE</td>
													<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_facturado_cliente}} " disabled></td>
												</tr>
												<tr>
													<td>TOTAL OTROS INGRESOS</td>
													<td><input id="total_otros_ingresos" type="text" class="form-control input-font" @if($ordenes_facturacion->total_otros_ingresos!=null)  {{'disabled'}}  @endif value="@if($ordenes_facturacion->total_otros_ingresos!=null) {{$ordenes_facturacion->total_otros_ingresos}} @else {{'0'}} @endif"></td>
												</tr>
												<tr>
													<td>CONCEPTO</td>
													<td><textarea rows="5" id="concepto" type="text" class="form-control input-font" @if($ordenes_facturacion->concepto!=null) {{'disabled'}}  @endif> {{$ordenes_facturacion->concepto}} </textarea></td>
												</tr>
												<tr>
													<td>TOTAL INGRESOS</td>
													<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_facturado_cliente+$ordenes_facturacion->total_otros_ingresos}} " disabled></td>
												</tr>
												<tr>
													<td>TOTAL INGRESOS PROPIOS</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->valor;} echo $contador; ?>" disabled></td>
												</tr>

												</tbody>
											</table>
										</div>
									</div>
							</div>
						@else
							<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="row">
										<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
											<table class="table table-hover tabla" style="margin-bottom:0px">
												<thead>
													<tr>
														<th class="titulo_orden">INGRESOS</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>TOTAL FACTURADO CLIENTE</td>
														<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_facturado_cliente}} " disabled></td>
													</tr>
													<tr>
														<td>TOTAL OTROS INGRESOS</td>
														<td><input id="total_otros_ingresos" type="text" class="form-control input-font" value="@if($ordenes_facturacion->total_otros_ingresos!=null) {{$ordenes_facturacion->total_otros_ingresos}} @else {{'0'}} @endif"></td>
													</tr>
													<tr>
														<td>CONCEPTO</td>
														<td><textarea rows="5" id="concepto" type="text" class="form-control input-font"></textarea></td>
													</tr>
													<tr>
														<td>TOTAL INGRESOS</td>
														<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_facturado_cliente+$ordenes_facturacion->total_otros_ingresos}} " disabled></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
							</div>
						@endif

						@if(intval($ordenes_facturacion->tipo_orden)===2)
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
											<thead>
														 <tr>
																<th class="titulo_orden">COSTO DE LOS SERVICIOS</th>
														 </tr>
											</thead>
											<tbody>
												<tr>
													<td>IVA COMISION</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->iva_comision;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>OTROS</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->otros;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>IMPUESTOS</td>
													<td><input id="total_otros_ingresos" type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->impuesto;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>TASA AERO</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->tasa_aero;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>OTRAS TASAS</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->otras_tasas;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>IVA SERVICIO</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->iva_servicio;} echo $contador; ?>" disabled></td>
												</tr>
												<tr>
													<td>TOTAL COSTOS</td>
													<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_costo}} " disabled></td>
												</tr>
												<tr>
													<td>UTILIDAD BRUTA DEL PERIODO</td>
													<td><input type="text" class="form-control input-font" value="<?php $contador=0; foreach ($otros_servicios as $otros) { $contador = $contador+$otros->valor_comision;} echo $contador; ?>" disabled></td>
												</tr>
												</tbody>
										</table>
									</div>
								</div>
							</div>
						@endif

						@if(intval($ordenes_facturacion->tipo_orden)===2)
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
									<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">COSTOS</th>
													 </tr>
										</thead>
										<tbody>
											<tr>
												<td>TOTAL GASTOS</td>
												<td><input type="text" class="form-control input-font" value="@if($ordenes_facturacion->total_gastos_operacionales!=null) {{$ordenes_facturacion->total_gastos_operacionales}} @else {{'0'}} @endif" ></td>
											</tr>
											<tr>
												<td>UTILIDAD OPERACIONAL</td>
												<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_utilidad}} " disabled></td>
											</tr>
											</tbody>
									</table>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
										<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">ANALISIS RENTABILIDAD</th>
													 </tr>
										</thead>
										<tbody>
											<tr>
												<td>TOTAL INGRESOS PROPIOS</td>
												<td><input type="text" class="form-control input-font" value="<?php $contador_valor=0; foreach ($otros_servicios as $otros) { $contador_valor = $contador_valor+$otros->valor;} echo $contador_valor; ?>" disabled></td>
											</tr>
											<tr>
												<td>UTILIDAD OPERACIONAL DEL PERIODO</td>
												<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_utilidad}} " disabled></td>
											</tr>
											<tr>
												<td>% RENTABILIDAD</td>
												<td><input type="text" class="form-control input-font" value=" {{round(intval($ordenes_facturacion->total_utilidad)/intval($contador_valor),3)*100}}  %" disabled></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@else
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
									<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">COSTOS</th>
													 </tr>
										</thead>
										<tbody>
											<tr>
												<td>TOTAL COSTOS</td>
												<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_costo}} " disabled></td>
											</tr>
											<tr>
												<td>UTILIDAD BRUTA</td>
												<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_utilidad}} " disabled></td>
											</tr>
											<tr>
												<td>TOTAL GASTOS</td>
												<td><input type="text" class="form-control input-font" value="@if($ordenes_facturacion->total_gastos_operacionales!=null) {{$ordenes_facturacion->total_gastos_operacionales}} @else {{'0'}} @endif" ></td>
											</tr>
											<tr>
												<td>UTILIDAD OPERACIONAL</td>
												<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->total_utilidad}} " disabled></td>
											</tr>
											</tbody>
									</table>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
										<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">ANALISIS RENTABILIDAD</th>
													 </tr>
										</thead>
										<tbody>
											<tr>
												<td>TOTAL FACTURADO AL CLIENTE</td>
												<td><input type="text" class="form-control input-font" value=" {{number_format($ordenes_facturacion->total_facturado_cliente+$ordenes_facturacion->total_otros_ingresos)}} " disabled></td>
											</tr>
											<tr>
												<td>UTILIDAD OPERACIONAL DEL PERIODO</td>
												<td><input type="text" class="form-control input-font" value=" {{number_format($ordenes_facturacion->total_utilidad)}} " disabled></td>
											</tr>

											@if($ordenes_facturacion->anulado!=null)
												<tr style="background: pink">
													<td>VALOR NOTA CRÉDITO</td>
													<td><input type="text" class="form-control input-font" value=" {{number_format($ordenes_facturacion->valor_nota)}} " disabled></td>
												</tr>

												<tr>
													<td>UTILIDAD REAL</td>
													<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->diferencia}} " disabled></td>
												</tr>
											@endif
											@if($ordenes_facturacion->anulado!=1)
												<tr>
													<td>% RENTABILIDAD</td>
													<td><input type="text" class="form-control input-font" value=" {{round(intval($ordenes_facturacion->total_utilidad)/intval($ordenes_facturacion->total_facturado_cliente),3)*100}}  %" disabled></td>
												</tr>
											@endif
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@endif
						@if(intval($ordenes_facturacion->tipo_orden)===2)
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row">
										<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">BASE TARIFARIA</th>
													 </tr>
										</thead>
										<tbody>
											<tr>
												<td><textarea rows="5" class="form-control"></textarea></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
						</div>
						@endif

						<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="row">
									<div class="container-facturacion" style="margin-right: 5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
										<table class="table table-hover tabla" style="margin-bottom:0px">
											<thead>
														 <tr>
																	<th class="titulo_orden">FACTURACION</th>
														 </tr>
											</thead>
											<tbody>
												<tr>
													<td>NUMERO DE FACTURA</td>
													<td><input disabled id="numero_factura" type="text" class="form-control input-font" value=" {{$ordenes_facturacion->numero_factura}} " @if($ordenes_facturacion->facturado===1) {{'disabled'}} @endif></td>
												</tr>
												<tr>
													<td>FECHA DE EXPEDICION</td>
													<td><input type="text" class="form-control input-font" value=" {{$ordenes_facturacion->fecha_expedicion}} " disabled></td>
												</tr>
												<!--<tr>
																<td>FECHA DE FACTURA</td>
																<td>
																	<div class="input-group">
															<div class="input-group date datetime_fecha">
																<input id="fecha_factura" style="width: 89px;" value=" {{$ordenes_facturacion->fecha_factura}} " type="text" class="form-control input-font" @if($ordenes_facturacion->facturado===1) {{'disabled'}} @endif>
																<span class="input-group-addon">
																	<span class="fa fa-calendar">
																	</span>
																</span>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>FECHA DE VENCIMIENTO</td>
													<td>
														<div class="input-group">
																					<div class="input-group date datetime_fecha">
																						<input id="fecha_vencimiento" style="width: 89px;" value=" {{$ordenes_facturacion->fecha_vencimiento}} " type="text" class="form-control input-font" @if($ordenes_facturacion->facturado===1) {{'disabled'}} @endif>
																						<span class="input-group-addon">
																								<span class="fa fa-calendar">
																								</span>
																						</span>
																					</div>
																			</div>
																	</td>
												</tr>
												<tr>
													<td></td>
													<td><a class="btn btn-success btn-icon editar">EDITAR<i class="icon-btn fa fa-pencil"></i></a></td>
													<td><a data-factura-id=" {{$ordenes_facturacion->id}} " class="btn btn-default btn-icon @if($ordenes_facturacion->facturado===1)  {{'disabled'}}  @endif" id="ingresos_facturacion">FACTURAR<i class="icon-btn fa fa-file-text-o"></i></a></td>
												</tr>-->
												</tbody>
										</table>
									</div>
								</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								<div class="container-facturacion" style="margin-right:5px; box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.1);">
									<table class="table table-hover tabla" style="margin-bottom:0px">
										<thead>
													 <tr>
															<th class="titulo_orden">INGRESO CLIENTE</th>
													 </tr>
										</thead>
										<tbody>
											<tr style="background: gray">
												<td style="color: white">FECHA DE INGRESO</td>
												<td>
													<div class="input-group">
														<div class="input-group date datetime_fecha">
															<input  id="fecha_ingreso" style="width: 89px;" type="text" class="form-control input-font" @if($ordenes_facturacion->fecha_ingreso!=null) {{'disabled'}} @endif value="@if($ordenes_facturacion->fecha_ingreso!=null) {{$ordenes_facturacion->fecha_ingreso}} @endif ">
															<span class="input-group-addon">
																<span class="fa fa-calendar">
																</span>
															</span>
														</div>
													</div>
												</td>
											</tr>
																				@if($permisos->facturacion->ordenes_de_facturacion->ingreso_imagenes==='on')
											<!--<tr style="border-bottom: 1px solid #dddddd;">
												<td>IMAGEN</td>
												<td>
													<form style="display: inline" id="ingreso_imagen">
														<input @if($ordenes_facturacion->revision_ingreso==1){{'disabled'}}@endif id="detalle_imagen" style="margin-bottom: 5px" type="text" class="form-control input-font" placeholder="DETALLES">
														<input @if($ordenes_facturacion->revision_ingreso==1){{'disabled'}}@endif name="foto" type="file">
														<button @if($ordenes_facturacion->revision_ingreso==1){{'disabled'}}@endif data-id="{{$ordenes_facturacion->id}}" class="btn btn-default" id="subir_imagen">GUARDAR <i class="fa fa-save"></i></button>

													</form>

												</td>
											</tr>-->
																				@endif
											<?php
											/*	if($ordenes_facturacion->foto_ingreso!=null):
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
												endif;*/
											?>

											<tr>
												<td></td><!--<td><a class="btn btn-success btn-icon editar">EDITAR<i class="icon-btn fa fa-edit"></i></a></td>-->
												<!--<td>
													@if($permisos->facturacion->ordenes_de_facturacion->ingreso==='on')
														<a data-factura-id="{{$ordenes_facturacion->id}}"
															 class="btn btn-default btn-icon @if($ordenes_facturacion->ingreso===1) {{'disabled'}} @endif"
															 id="ingreso_cliente">INGRESO DE CLIENTE<i class="icon-btn fa fa-usd"></i>
														</a>
													@else
														<a class="btn btn-default btn-icon disabled" id="ingreso_cliente">
																												INGRESO DE CLIENTE
															<i class="icon-btn fa fa-usd"></i>
														</a>
													@endif
												</td>-->
											</tr>
												<!--<tr>
													<td>REVISAR INGRESO</td>
													<td>
													@if($permisos->facturacion->ordenes_de_facturacion->revision==='on')
														<button @if($ordenes_facturacion->ingreso===null){{'disabled'}}@elseif($ordenes_facturacion->revision_ingreso!=null){{'disabled'}}@endif data-id="{{$ordenes_facturacion->id}}" id="revision_ingreso" class="btn btn-primary btn-icon">REVISAR
															<i class="fa fa-check icon-btn"></i>
														</button>
													@else
														<button class="btn btn-primary btn-icon disabled">REVISAR
															<i class="fa fa-check icon-btn"></i>
														</button>
													@endif
												</td>
											</tr>-->
											</tbody>
									</table>
								</div>
								</div>
							</div>
					</div>
				</div>

				<div class="col-lg-8 col-md-4 col-sm-4">
              @if($ordenes_facturacion->id_siigo!=null and $ordenes_facturacion->pdf==1)

								<div class="panel panel-default">
										<div class="panel-heading">Factura Siigo @if($ordenes_facturacion->anulado==1)
											<b style="float: right; font-size: 20px; color: white; background-color: red; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON NC @if($ordenes_facturacion->anulado==1 and $ordenes_facturacion->diferencia>0){{'PARCIAL'}}@else{{'TOTAL'}}@endif <i class="fa fa-ban" aria-hidden="true"></i></b>
											@if($ordenes_facturacion->ingreso==1)
												<b style="float: right; font-size: 20px; color: white; background-color: green; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON INGRESO <i class="fa fa-check" aria-hidden="true"></i></b>
											@endif
											@elseif($ordenes_facturacion->ingreso==1)
											<b style="float: right; font-size: 20px; color: white; background-color: green; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON INGRESO <i class="fa fa-check" aria-hidden="true"></i></b>
											@else
											<b style="float: right; font-size: 20px; color: white; background-color: orange; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">SIN INGRESO <i class="fa fa-times" aria-hidden="true"></i></b>@endif</div>
											<div class="panel-body">
												<div class="documento">
													<center>
														<iframe id="pdf" style="width: 750px; height: 760px;" src="{{url('biblioteca_imagenes/facturacion/siigo/' .$id. '.pdf')}}"></iframe>
													</center>
												</div>
										</div>
								</div>
							@else
							<div class="panel panel-default">
									<div class="panel-heading">Factura Siigo  @if($ordenes_facturacion->pdf==null or $ordenes_facturacion->pdf==0) <b style="float: right; font-size: 20px; color: white; background-color: gray; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">FACTURA EN PROCESO <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></b> @elseif($ordenes_facturacion->anulado==1)
										<b style="float: right; font-size: 20px; color: white; background-color: red; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON NC @if($ordenes_facturacion->anulado==1 and $ordenes_facturacion->diferencia>0){{'PARCIAL'}}@else{{'TOTAL'}}@endif <i class="fa fa-ban" aria-hidden="true"></i></b>
										@if($ordenes_facturacion->ingreso==1)
											<b class="bg-success" style="float: right; font-size: 20px; color: white; background-color: green; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON INGRESO <i class="fa fa-check" aria-hidden="true"></i></b>
										@endif
										@if($ordenes_facturacion->ingreso==1)
											<b style="float: right; font-size: 20px; color: white; background-color: green; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON INGRESO <i class="fa fa-check" aria-hidden="true"></i></b>
										@endif
										@elseif($ordenes_facturacion->ingreso==1)
										<b style="float: right; font-size: 20px; color: white; background-color: green; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">CON INGRESO <i class="fa fa-check" aria-hidden="true"></i></b>
										@else
										<b style="float: right; font-size: 20px; color: white; background-color: orange; margin-right: 5px; padding-left: 10px; padding-right: 10px; margin-top: -5px;">SIN INGRESO <i class="fa fa-times" aria-hidden="true"></i></b>@endif</div>
										<div class="panel-body">
											<center>
												<!--<img src="{{url('img/loader.gif')}}" alt="" height="180px" width="180px">-->

												<img src="{{url('img/loaders.gif')}}" alt="" height="180px" width="180px">
											</center>
									</div>
							</div>
							@endif
        </div>

				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="row">
						@if($permisos->facturacion->ordenes_de_facturacion->anular==='on')
							@if(intval($ordenes_facturacion->tipo_orden)===2)
							<div class="col-lg-4 col-md-6 col-sm-6">
								<div class="row">
									<div class="form-group" style="margin-bottom:0px">
										<label for="motivo_anulacion">MOTIVO DE ANULACION</label>
										<textarea style="margin-bottom: 10px" class="form-control input-font" @if(intval($ordenes_facturacion->anulado)===1) {{'disabled'}} @endif rows="2" id="motivo_anulacion">{{$ordenes_facturacion->motivo_anulacion}}</textarea>
									</div>
									<a data-id=" {{$ordenes_facturacion->id}} " id="anular_factura_otros_servicios" style="margin-bottom:10px" class="btn btn-danger btn-icon @if(intval($ordenes_facturacion->anulado)===1) {{'disabled'}} @endif">ANULAR FACTURA<i class="icon-btn fa fa-close"></i></a>
								</div>
							</div>
							@elseif(intval($ordenes_facturacion->tipo_orden)===1)
							<div class="col-lg-4 col-md-6 col-sm-6">
								<div class="row">
									<div class="form-group" style="margin-bottom:0px">
										<!--<label for="motivo_anulacion">MOTIVO DE ANULACION</label>
										<textarea style="margin-bottom: 10px" class="form-control input-font" @if(intval($ordenes_facturacion->anulado)===1) {{'disabled'}} @endif rows="2" id="motivo_anulacion">{{$ordenes_facturacion->motivo_anulacion}}</textarea>-->
										@if($ordenes_facturacion->ingreso!=1)
											<a data-id="{{$ordenes_facturacion->id}}" data-invoice="{{$ordenes_facturacion->numero_factura}}" data-valor="{{$ordenes_facturacion->total_facturado_cliente}}" id="anular_factura" style="margin-bottom:10px" class="btn btn-danger btn-icon @if(intval($ordenes_facturacion->anulado)===1) {{'disabled'}} @endif">NOTA CRÉDITO<i class="icon-btn fa fa-sticky-note-o"></i></a>
										@endif
									</div>
								</div>
							</div>
							@endif
						@else
							@if(intval($ordenes_facturacion->tipo_orden)===2)
								<div class="col-lg-4">
									<div class="row">
										<div class="form-group" style="margin-bottom:0px">
											<label for="motivo_anulacion">MOTIVO DE ANULACION</label>
											<textarea style="margin-bottom: 10px" class="form-control input-font" disabled rows="2">{{$ordenes_facturacion->motivo_anulacion}}</textarea>
										</div>
										<a style="margin-bottom:10px" class="btn btn-danger btn-icon disabled">ANULAR FACTURA<i class="icon-btn fa fa-close"></i></a>
									</div>
								</div>
							@elseif(intval($ordenes_facturacion->tipo_orden)===1)
								<div class="col-lg-4 col-md-6 col-sm-6">
									<div class="row">
										<div class="form-group" style="margin-bottom:0px">
											<label for="motivo_anulacion">MOTIVO DE ANULACION</label>
											<textarea style="margin-bottom: 10px" class="form-control input-font" disabled rows="2">{{$ordenes_facturacion->motivo_anulacion}}</textarea>
											<a style="margin-bottom:10px" class="btn btn-danger btn-icon disabled">ANULAR FACTURA<i class="icon-btn fa fa-close"></i></a>
										</div>
									</div>
								</div>
							@endif
						@endif
					</div>
				</div>
			@endif
		</div>
	</div>
</div>


<div style="top:50% !important" class="modal_ingreso_imagen hidden" id="alert_eliminar">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">Soporte de Ingreso <i id="cerrar" style="float: right; cursor: pointer;" class="fa-close fa"></i></div>
			<div class="panel-body">
				<img class="img-responsive" id="img_ingreso">
			</div>
		</div>
	</div>
</div>

<div class="camera_position hidden">
	<div id="my_camera" style="width:500px; height:400px; background: white;"></div>
	<a id="btn-camera1" class="btn btn-primary btn-camera" href="javascript:void(take_snapshot())"><i class="fa fa-2x fa-camera"></i></a>
</div>

<div class="camera_position hidden">
		<div id="my_result"></div>
		<form id="myform" method="post" action="{{url('facturacion/imagencamara')}}">
    		<input id="mydata" type="hidden" name="mydata" value=""/>
    		<input id="id" type="hidden" name="id" value="{{$ordenes_facturacion->id}}"/>
		</form>
		<a style="padding: 20px 22px !important;" id="btn-camera2" class="btn btn-primary btn-camera"><i class="fa fa-2x fa-save"></i></a>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_nota'>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header" style="background: #E53935">
					<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">NOTA CRÉDITO</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<form id="reci">

							<center>
								<h4>Adjuntar soporte de Nota Crédito</h4>
								<input class="recibo" type="file" value="Subir" name="recibo" id="recibo">
							</center>

						</form>
					</center>
				</div>

				<div class="modal-footer">
					<span style="float: left">Factura N° <b id="invoice" style="color: #F47321;"></b> <b style="color: #F47321;" id="valor_invoice"></b> </span>
					<a id="guardar_soporte" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>
					<input name="codigo" id="valor" placeholder="Valor de la NC" style="width: 130px; float: right" type="text" class="form-control input-font">
				</div>
		</div>
	</div>
</div>

@include('scripts.scripts')

<script src=" {{url('jquery/jquery-ui.min.js')}} "></script>
<script src=" {{url('jquery/bootstrap.file-input.js')}} "></script>
<script src=" {{url('datatables/media/js/jquery.datatables.js')}} "></script>
<script src=" {{url('bootstrap-datetimepicker\js\moment.js')}} "></script>
<script src=" {{url('bootstrap-datetimepicker\js\moment-with-locales.js')}} "></script>
<script src=" {{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}} "></script>
<script src=" {{url('jquery/facturacion.js')}} "></script>
<script src=" {{url('webcamjs-master/webcam.js')}} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    $('input[type=file]').bootstrapFileInput();
	  $('.file-inputs').bootstrapFileInput();

		$('#anular_factura').click(function() {

			var factura = $(this).attr('data-id');

			console.log('Test factura '+factura)

			$('#modal_nota').modal('show');
			$('#guardar_soporte').attr('data-id',factura);
			$('#invoice').html($(this).attr('data-invoice'));
			$('#valor_invoice').html(' - '+number_format($(this).attr('data-valor')));

		});

		$('#guardar_soporte').click(function() {

			//string.replace('string','new string');

			 var valor = $('#valor').val().trim().replace(',','').replace(',','').replace(',','');
			 var file = $('#recibo').val();
			 var id = $(this).attr('data-id');

			 console.log(valor)
			 console.log(file)
			 console.log(id)

			if(valor === '' || file === ''){

				var data = '';

				if(file === ''){
					data += 'Debe adjuntar un archivo...<br><br>'
				}

				if(valor === ''){
					data += 'El campo valor está vacío...';
				}
				$.confirm({
            title: '¡Atención!',
            content: data,
            buttons: {
                confirm: {
                    text: 'Cerrar',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){



                    }

                }
            }
        });

			}else{

				formData = new FormData($('#reci')[0]);
        formData.append('valor',valor);
				formData.append('recibo',$('#recibo').val());
				formData.append('data-id',id);

        console.log($('#recibo').val());

        $.ajax({
            type: "post",
            url: "../anularfacturatransporte",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {

                if(data.respuesta===false){
									$.alert('No se pudo registrar la Nota Crédito.');
                }else if(data.respuesta===true){

									$.alert('Nota Crédito Registrada!');
									location.reload();

                }
            },
            error: function (request, status, error) {
                console.log('Hubo un error, llame al administrador del sistema'+request+status+error);
            }
        });

			}
			/*console.log($('#recibo').val())
			console.log($(this).attr('id-factura'))

			formData = new FormData($('#reci')[0]);
	        formData.append('recibo',$('.recibo').val());
					formData.append('id',$(this).attr('id-factura'));

	        console.log($('#recibo').val());

	        $.ajax({
	            type: "post",
	            url: "recibo",
	            data: formData,
	            processData: false,
	            contentType: false,
	            success: function(data) {

	                if(data.mensaje===false){

	                }else if(data.mensaje===true){

										$.alert('Archivo cargado exitosamente!');
										location.reload();

	                }
	            },
	            error: function (request, status, error) {
	                console.log('Hubo un error, llame al administrador del sistema'+request+status+error);
	            }
	        });*/

		});

		$('#valor').keyup(function(){
			$(this).val(number_format($(this).val()))
		});

		$('#activar_camara').click(function(e){
			$('#my_camera').closest('.camera_position').removeClass('hidden');
			Webcam.attach('#my_camera');
			$('#btn-camera').removeClass('hidden');
			if (!$('#my_result').closest('.camera_position').hasClass('hidden')) {
				$('#my_result').closest('.camera_position').addClass('hidden');
			}
		});
		Webcam.set({
			width: 640,
	    height: 480,
	    dest_width: 640,
	    dest_height: 480,
	    image_format: 'jpeg',
	    jpeg_quality: 90,
	    force_flash: false
		})
		function take_snapshot() {
				Webcam.snap( function(data_uri) {
						document.getElementById('my_result').innerHTML = '<img src="'+data_uri+'"/>';
						var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
    				document.getElementById('mydata').value = raw_image_data;
				});
				$('#my_camera').closest('.camera_position').addClass('hidden');
				$('#my_result').closest('.camera_position').removeClass('hidden');
				$('#btn-camera2').removeClass('hidden');
		}

</script>
</body>
</html>
