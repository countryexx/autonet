<html>
<head>
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Ordenes de facturacion</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
</head>
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
		  <h3 class="h_titulo">ADMINISTRACION DE ORDENES DE FACTURACION</h3>
		</div>
	</div>
	<?php
		$fechaActual = date('Y-m-d');
		$horaActual = date('H:i:s');
		$token = DB::table('siigo')->where('id',1)->first();
		$newDate = date("d/m/Y", strtotime($token->fecha_vence));
	?>
	@if( ($fechaActual<$token->fecha_vence) or ( $fechaActual==$token->fecha_vence and $horaActual<=$token->hora_vence) )
		<div class="col-lg-12" style="margin-bottom: 20px">
			<div class="row">
	  		<span style="font-size: 15px; ">El token tiene validez hasta el: <b style="font-size: 20px; ">{{$newDate}}</b> a las <b style="font-size: 20px; ">{{$token->hora_vence}}</b></span>
				<a class="btn btn-list-table btn-primary actualizar_token" style="margin-left: 5px">Actualizar Token de Siigo <i class="fa fa-refresh" aria-hidden="true"></i></a>
				<img class="loader hidden" src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">
			</div>
		</div>
	@else
		<div class="col-lg-12">
			<div class="row">
				<span>El token venció el: <b style="font-size: 20px; ">{{$newDate}}</b> a las <b style="font-size: 20px; ">{{$token->hora_vence}}</b></span>
				<a class="btn btn-list-table btn-danger actualizar_token" style="margin-left: 5px">Actualizar Token de Siigo <i class="fa fa-refresh" aria-hidden="true"></i></a>
				<img class="loader hidden" src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">
			</div>
		</div>
	@endif

	@if($option===3 or $option===5)
		<form class="form-inline" id="form_buscar" action="exportarexcelordenes" method="post">
        <div class="col-lg-12" style="margin-bottom: 5px">
            <div class="row">
		          	<div class="form-group">
		                <select style="width: 89px;" class="form-control input-font" id="tipo_cliente" name="tipo_cliente">
						          <option value="0">-</option>
						          <option value="1">TODOS</option>
						          <option value="2">INTERNOS</option>
						          <option value="3">AFILIADOS EXTERNO</option>
						        </select>
		            </div>
								<div class="input-group">
								  <div class="input-group date datetime_fecha">
									  <input name="fecha_inicial" style="width: 89px;" type="text" class="form-control input-font" placeholder="FECHA INICIAL">
										<span class="input-group-addon">
											<span class="fa fa-calendar">
											</span>
										</span>
								  </div>
						  	</div>
								<div class="input-group">
								  <div class="input-group date datetime_fecha">
									  <input name="fecha_final" style="width: 89px;" type="text" class="form-control input-font" placeholder="FECHA FINAL">
										  <span class="input-group-addon">
											  <span class="fa fa-calendar">
											  </span>
										  </span>
								  </div>
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
                    <select style="width: 107px;" class="form-control input-font" name="opcion">
                        <option value="0">TODOS</option>
                        <option value="1">SIN INGRESO</option>
                        <option value="2">INGRESO SIN REVISION</option>
                        <option value="3">INGRESO CON REVISION</option>
                    </select>
                </div>
                <div class="form-group">
                	<select class="form-control input-font" name="opcion2">
                		<option value="0">-</option>
										<option value="1">NUMERO CONSECUTIVO</option>
                		<option value="2">NUMERO DE FACTURA</option>
                	</select>
                </div>

								<div class="form-group">
                	<select class="form-control input-font" name="vencimiento">
                		<option value="0">Días de Vencimiento</option>
										<option value="5">Hasta 5 días de vencimiento</option>
                		<option value="10">Hasta 10 días de vencimiento</option>
										<option value="11">+10 días de vencimiento</option>
                	</select>
                </div>

                <div class="form-group">
                    <input name="numero" class="form-control input-font" placeholder="DIGITE EL NUMERO">
                </div>
                <button id="buscar_ordenes_facturacion" class="btn btn-default btn-icon">
                    BUSCAR<i class="fa fa-search icon-btn"></i>
                </button>
								<button type="submit" class="btn btn-success btn-icon">
                    EXCEL<i class="fa fa-file-excel-o icon-btn" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </form>
	@endif

  @if(isset($ordenes_facturacion))

	<div class="tabla">
		<table id="example3" class="table table-bordered hover tabla" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Consecutivo</th>
					<th>Centro de costo</th>
					<th>Ciudad</th>
					<th>Fecha de expedicion</th>
					<th>Fecha inicial</th>
					<th>Fecha final</th>
					<th>Fecha Vencimiento</th>
					<th>Numero factura</th>
					<th>Cobrado</th>
					<th>Tipo orden</th>
					<th>Informacion</th>
				</tr>
			</thead>
			<tfoot>
			<tr>
				<th>Consecutivo</th>
				<th>Centro de costo</th>
				<th>Ciudad</th>
				<th>Fecha de expedicion</th>
				<th>Fecha inicial</th>
				<th>Fecha final</th>
				<th>Fecha Vencimiento</th>
				<th>Numero factura</th>
				<th>Cobrado</th>
				<th>Tipo orden</th>
				<th>Informacion</th>
			</tr>
			</tfoot>
			<tbody>
			<?php $totales_cobrado = 0; ?>
			@foreach($ordenes_facturacion as $orden)
				@if(intval($option)===0 or intval($option)===1)
					<?php $totales_cobrado = $totales_cobrado+intval($orden['total_facturado_cliente']); ?>
				<tr @if ($orden['anulado']==1) {{'class="info"'}} @elseif ($orden['tipo_cliente']==2) {{'class="info"'}} @endif dias_vencidos="{{$orden['dias_vencidos']}}" operador="{{$orden['operador']}}">
					<td>{{$orden['consecutivo']}}</td>
					<td><span class="bolder">@if($orden['razonsocial']===$orden['nombresubcentro']){{$orden['razonsocial']}}@else{{$orden['razonsocial'].' / '.$orden['nombresubcentro']}} @endif</span></td>
					<td>{{$orden['ciudad']}}</td>
					<td>{{$orden['fecha_expedicion']}}</td>
					<td>{{$orden['fecha_inicial']}}</td>
					<td>{{$orden['fecha_final']}}</td>
					@if(intval($option)===0)
					<td class="bolder text-primary">
						<span class="bolder">{{$orden['fecha_vencimiento']}}</span>
						@if($orden['ingreso']==1)
							{{'<br><span style="font-size: 10px" class="text-success bolder">CON INGRESO <i class="fa fa-usd"></i></span>'}}
						@else
							{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN INGRESO VQ <i class="fa fa-close"></i></span>'}}
						@endif


						@if($orden['revision_ingreso']==1)
							{{'<br><span style="font-size: 10px" class="text-success bolder">REVISADO <i class="fa fa-check"></i></span>'}}
						@else
							{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN REVISION <i class="fa fa-close"></i></span>'}}
						@endif
					</td>
					@elseif(intval($option)===1)
						<td>
							<a style="cursor: pointer">{{$orden['fecha_vencimiento']}}</a>
							@if($orden['ingreso']==1)
								{{'<br><span style="font-size: 10px" class="text-success bolder">CON INGRESO <i class="fa fa-usd"></i></span>'}}
							@else
								{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN INGRESO <i class="fa fa-close"></i></span>'}}
							@endif
							@if($orden['revision_ingreso']==1)
								{{'<br><span style="font-size: 10px" class="text-success bolder">REVISADO <i class="fa fa-check"></i></span>'}}
							@else
								{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN REVISION <i class="fa fa-close"></i></span>'}}
							@endif
						</td>
					@endif
					<td>{{$orden['numero_factura']}}</td>
					<td><span class="bolder">$ {{number_format($orden['total_facturado_cliente'])}}</span></td>
					<td>{{$orden['tipo_orden']}}</td>
					<td>
						<a class="btn btn-list-table btn-success">EXPORTAR</a>
						<a class="btn btn-list-table btn-primary" href="{{url('facturacion/verorden/'.$orden['id'])}}">Orden</a>
						<a class="btn btn-list-table btn-info  " href="{{url('facturacion/verdetalle/'.$orden['id'])}}">Detalles</a>
					</td>
				</tr>
				@elseif(intval($option)===2 or intval($option===3) or intval($option)===4 or intval($option)===5)
					<?php
						$totales_cobrado = $totales_cobrado+intval($orden->total_facturado_cliente);
					?>
					<tr @if($orden->anulado==1 and $orden->diferencia>0) {{'class="info"'}} @elseif ($orden->anulado==1) {{'class="danger"'}} @elseif ($orden->tipo_cliente==2) {{'class="info"'}} @endif>
						<td>{{$orden->consecutivo}} @if($orden->id_siigo!=null)<img src="{{url('img/siigo.png')}}" alt="" width="35px" height="20px">@endif </td>
						<td><span class="bolder">@if($orden->razonsocial===$orden->nombresubcentro){{$orden->razonsocial}}@else{{$orden->razonsocial.' / '.$orden->nombresubcentro}} @endif</span></td>
						<td>{{$orden->ciudad}}</td>
						<td>{{$orden->fecha_expedicion}}</td>
						<td>{{$orden->fecha_inicial}}</td>
						<td>{{$orden->fecha_final}}</td>
						<?php
							$fecha_expedicion = new DateTime($orden->fecha_expedicion);
							if ($orden->credito==1){
								$plazo_pago = $orden->plazo_pago;

								$fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string($plazo_pago.' days'));
							}else{
								$fecha_vencimiento = date_add($fecha_expedicion, date_interval_create_from_date_string('1 days'));
							}
						?>
						<td class="bolder text-primary">
							@if(isset($orden->fecha_vencimiento))
								{{$orden->fecha_vencimiento}}
							@else
								{{date_format($fecha_vencimiento, 'Y-m-d')}}
							@endif

							<?php

								if($orden->id_siigo==null){

									if($orden->ingreso==1){
										$estadodePago = 0;
									}else{
							    	$estadodePago = 1;
							    }

								}else if($orden->id_siigo!=null){ //SI ES FACTURA DE SIIGO Y NO TIENE PDF GENERADO

									if($orden->pdf==null){

										$token = DB::table('siigo')->where('id',1)->pluck('token');

										$ch = curl_init();
										curl_setopt($ch, CURLOPT_URL, "https://api.siigo.com/v1/invoices/{".$orden->id_siigo."}");
								    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
								    curl_setopt($ch, CURLOPT_HEADER, FALSE);
								    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								      "Authorization: ".$token."",
											"Partner-Id: AUTONET"
								    ));
								    $response = curl_exec($ch);
								    curl_close($ch);

										if(isset(json_decode($response)->stamp->cufe)){
											$updates = DB::table('ordenes_facturacion')
							    		->where('id',$orden->id)
							    		->update([
							    			'pdf' => 0
							    		]);
										}

										/*if( (json_decode($response)->balance < $orden->totalfactura) and ($orden->anulado==null) ){ //NC
											$orden_facturacion = Ordenfactura::find($orden->id);
											$orden_facturacion->anulado = 1;
											$orden_facturacion->diferencia = intval($orden_facturacion->total_facturado_cliente)-intval(Input::get('valor'));
											$orden_facturacion->save();
										}*/

								    $estadodePago = 1;

									}else{

										if($orden->ingreso==1){
											$estadodePago = 0;
										}else{
											$estadodePago = 1;
										}

									}

						    }else{

									if($orden->ingreso==1){
										$estadodePago = 0;
									}else{
							    	$estadodePago = 1;
							    }

								}
							?>

							@if($orden->anulado==1)

								<!-- VALIDAR SI TIENE INGRESO UNA FACTURA CON NC PARCIAL -->
								@if($orden->diferencia>0)
									@if($orden->ingreso==1)
										<br><span style="font-size: 10px" class="text-success bolder">CON INGRESO <i class="fa fa-usd"></i></span>
									@endif
								@endif

							<br><span style="font-size: 10px" class="text-danger bolder">
								<a data-url="{{$orden->nota_file}}" data-inv="{{$orden->numero_factura}}" style="color: @if($orden->pdf==null or $orden->pdf==0){{'gray'}}@else{{'red'}}@endif" class="@if($orden->nota_file!=null){{'ver_nc'}}@endif">Nota Crédito @if($orden->anulado==1 and $orden->diferencia>0){{'Parcial'}}@else{{'Total'}}@endif</a> </span>
							@elseif($estadodePago!=0)
								<br><span style="font-size: 10px" class="text-danger bolder">
									<a data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="color: @if($orden->pdf==null or $orden->pdf==0){{'gray'}}@else{{'red'}}@endif" class="rc">@if($orden->pdf==null or $orden->pdf==0){{'EN PROCESO'}}@else{{'SIN INGRESO'}}@endif</a> <i style="color: @if($orden->pdf==null or $orden->pdf==0){{'gray'}}@else{{'red'}}@endif" class="fa fa-@if($orden->pdf==null or $orden->pdf==0){{'spinner fa-spin'}}@else{{'times'}}@endif"></i></span>
							@else
								{{'<br><span style="font-size: 10px" class="text-success bolder">CON INGRESO <i class="fa fa-usd"></i></span>'}}
							@endif

							@if($orden->revision_ingreso==1)
								<br><span style="font-size: 10px" class="text-success bolder">REVISADO <i class="fa fa-check"></i></span>

								@if($orden->observaciones_revision!=null)
								<br><span style="font-size: 10px" class="text-primary bolder"><a data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="color: #1565C0" class="comentario">COMENTARIO</a> <i class="fa fa-commenting-o"></i></span>
									<span class="hidden {{$orden->id}}">{{$orden->observaciones_revision}}</span>
								@endif
							@elseif($orden->ingreso==1 and $orden->revision_ingreso!=1)
								<br>

									@if($orden->ingreso==1 and $orden->rc!=null)
										<span style="font-size: 10px" class="text-danger bolder"><a data-id="{{$orden->id}}" data-valor="{{$orden->total_facturado_cliente}}" style="color: gray" class="ver_rc_revision">SIN REVISION</a> <i style="color: gray" class="fa fa-close"></i></span>
									@else
										<span style="font-size: 10px" class="text-danger bolder">SIN REVISIÓN <i style="color: gray" class="fa fa-close"></i></span>
									@endif

							@else

							@endif

						</td>
						<td>
							<?php
							$sw = 0;
								if( date('Y-m-d')>$orden->fecha_vencimiento and ( $orden->ingreso==null and $orden->anulado==null) and $orden->id_siigo!=null){

									$sw = 1;
									$start_date = new DateTime($orden->fecha_vencimiento);
									$end_date = new DateTime(date('Y-m-d'));

									$interval = $start_date->diff($end_date);
									$cantidad = intval($interval->format('%R%a'));
									if($cantidad<=5){
										$color = 'green';
									}else if($cantidad>=6 and $cantidad<10){
										$color = 'orange';
									}else{
										$color = 'red';
									}

								}
							//}

							?>
							{{$orden->numero_factura}}
							@if($sw==1)
								<b style="float: right; color: {{$color}}">-{{abs($interval->format('%R%a'))}}</b>
							@endif
							@if($orden->pdf==null and $orden->id_siigo!=null) <!-- NO HABILITADO PARA HACER PDF -->
								<!--<i class="fa fa-arrow-down" aria-hidden="true" style="color: orange; font-size: 16px"></i>-->

								<img style="float: right" src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">

								<!--<a data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="width: 50%" class="btn btn-list-table btn-info pdf_factura">PDF</a>-->
								<!-- NUEVO | GENERAR PDF EN CUALQUIER MOMENTO -->
							@elseif($orden->pdf==0 and $orden->id_siigo!=null) <!-- SI HABILITADO PARA HACER PDF -->
								<i data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" class="fa fa-file-pdf-o pdf_factura" aria-hidden="true" style="color: gray; font-size: 16px; float: right"></i>
							@endif

							@if ($orden->anulado==1)

								<!--<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 70px; border-radius: 2px;">

										@if($orden->anulado==1 and $orden->nota_file!=null)

										<a data-url="{{$orden->nota_file}}" data-inv="{{$orden->numero_factura}}" class="ver_nc" style="color: white">

											<i class="fa fa-eye" aria-hidden="true"></i>

										@endif

										@if($orden->anulado==1 and $orden->diferencia>0)
											VER NC PAR
										@else
											VER NC
										@endif


								</div>-->
								@if( $orden->nota_file==null and Sentry::getUser()->id != 3801)

								<a style="width: 35px; height: 25px" data-id="{{$orden->id}}" data-invoice="{{$orden->numero_factura}}" data-v="11" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="width: 90%" class="btn btn-list-table btn-default anular_factura">Adj <i data-id="{{$orden->id}}" data-invoice="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" id="anular_factura" class="fa fa-paperclip" style="font-size: 10px"> </i></a>


									<!--<a  style="margin-bottom:10px" class="btn btn-success btn-icon anular_factura">Adjuntar<i class="icon-btn fa fa-sticky-note-o"></i></a>-->
								@endif
							@endif</td>
						<td><span class="bolder">$ {{number_format($orden->total_facturado_cliente)}}</span></td>
						<td>@if(intval($orden->tipo_orden)===1){{'TRANSPORTE'}}@else{{'OTROS'}}@endif

							@if($orden->ingreso==1 and $orden->rc===null and $orden->id_siigo!=null)
								<a data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="width: 90%" class="btn btn-list-table btn-success rc">NOVEDAD <i class="fa fa-plus-square" aria-hidden="true"></i></a>
							@elseif($orden->ingreso!=1 and $orden->rc===null and $orden->id_siigo!=null)
								<a data-id="{{$orden->id}}" data-factura="{{$orden->numero_factura}}" data-valor="{{$orden->total_facturado_cliente}}" style="width: 90%" class="btn btn-list-table btn-danger rc @if($orden->ingreso!=1){{'hidden'}}@endif">Novedad <i class="fa fa-plus-square" aria-hidden="true"></i></a>
							@elseif($orden->id_siigo!=null)
								<a data-id="{{$orden->id}}" data-valor="{{$orden->total_facturado_cliente}}" style="width: 90%" class="btn btn-list-table btn-default ver_rc">VER SOPORTES <i class="fa fa-eye" aria-hidden="true"></i></a>
							@endif

						</td>
						<td>
							@if(intval($orden->dividida)===1)
									<a style="margin-right: 3px;" class="btn btn-list-table btn-success " href="exportarordenfacturacion/{{$orden->id}}">Exportar</a>
							@else
									<a style="margin-right: 3px;" class="btn btn-list-table btn-success " href="exportarordenfacturacion/{{$orden->id}}">Exportar</a>
							@endif
							<a class="btn btn-list-table btn-primary" href="{{url('facturacion/verorden/'.$orden->id)}}">Orden</a>
							@if(intval($orden->dividida)===1)
								<a class="btn btn-list-table btn-info  " href="{{url('facturacion/verdetalle/'.$orden->id_detalle)}}">Detalles</a>
							@else
								<a class="btn btn-list-table btn-info  " href="{{url('facturacion/verdetalle/'.$orden->id)}}">Detalles</a>
							@endif
						</td>
					</tr>
				@endif
			@endforeach
			</tbody>

		</table>

		<div class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" id='modal_nota'>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
						<div class="modal-header" style="background: #E53935">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title" style="text-align: center;" id="name"><b id="titles" class="parpadea">NOTA CRÉDITO</b></h4>
						</div>
						<div class="modal-body">
							<center>
								<form id="recin">

									<center>
										<h4>Adjuntar soporte</h4>
										<input class="recibos" type="file" value="Subir" name="recibo" id="recibo">
									</center>

								</form>
							</center>
						</div>

						<div class="modal-footer">
							<span style="float: left">Factura N° <b id="invoice" style="color: #F47321;"></b> </span><br>
							<span style="float: left">Valor<b style="color: #F47321;" id="valor_invoice"></b> </span>
							<a id="guardar_soporte1" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>
							<input name="codigo" id="valor" placeholder="Valor de la NC" style="width: 130px; float: right" type="text" class="form-control input-font hidden">

							<input type="checkbox" id="parcials" name="parcials" class="parcials">
							<label class="not_parcial" for="vehicle1" style="margin-right: 20px"> Nota crédito Parcial </label>

						</div>
				</div>
			</div>
		</div>

		<div id="modal-activar-reconfirmacion" class="hidden" style="opacity: 1; width: 400px">
	        <div class="col-lg-12">
	            <div class="panel panel-default">
	                <div class="panel-heading">Importar soportes<i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i></div>
	                <div class="panel-body">
										<center>
										<input type="checkbox" name="cerrar_alertas" class="cerrar_alertas">
										<label for="vehicle1" style="margin-right: 20px; font-size: 25px; color: red"> Nota crédito Total </label></center><br>
	                    <div class="row">


	                    		<center>
														<h4>Soportes del Banco</h4>
														<form class="dropzone" id="my-dropzone">
							                  <input type="hidden" name="id" id="id_fac">
							                  <div class="dz-message" data-dz-message><span>Presiona para subir las imágenes</span></div>
							              </form>


													</center>

													<hr>
												<form id="reci">

													<center>
														<h4>Adjuntar recibo de Caja</h4>
														<input class="recibo" id="recii" type="file" value="Subir" name="recibo">
													</center>
													<hr>

													<center>
														<div class="input-group date datetime_fecha" style="width: 50%; margin-left: 20px">
															<input placeholder="Fecha de Ingreso" id="fecha_ingreso" style="width: 100%; " type="text" class="form-control input-font">
															<span class="input-group-addon">
																<span class="fa fa-calendar">
																</span>
															</span>
														</div>
													</center>

	                    		<a id="guardar_soporte" style="float: right; margin-top: 35px; margin-right: 6px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>

	                    	</form>


	                    </div>
	                    <!--<div class="row" style="float: left; margin-right: 8px;">
		                    <div class="col-lg-12">
		                      <input disabled id="otro_valor" name="fecha_preparacion" type="number" class="form-control input-font disabled" placeholder="Valor">

		                    </div>
		                </div>-->



                    <div class="row" style="float: left; margin-right: 8px;">
		                    <div class="col-lg-12">
		                      <br>
		                    </div>
		                </div>


	                </div>
	            </div>
	        </div>
		</div>
		<div class="col-lg-12" style="margin-top: 10px">
			<div class="row">
				<div class="col-lg-4">
					<div class="row">
						<div style="margin-bottom: 10px;" class="panel panel-default">
							<div class="panel-heading">TOTALES</div>
							<div class="panel-body">
								<table style="margin-bottom: 0px;" class="table table-hovered table-bordered">
									<tr>
										<td>TOTALES COBRADO</td>
										<td class="bolder"><span class="tcobradofacturacion" style="font-size: 12px">$ <?php echo number_format($totales_cobrado); ?></span></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<?php
			if(intval($option)===4 or intval($option)===2 or intval($option)===5 or intval($option)===3):
				echo '<span style="display: inherit">Mostrando '.$ordenes_facturacion->getFrom().' de '.$ordenes_facturacion->getTo().' de '.$ordenes_facturacion->getTotal().' Registros</span>';
				echo $ordenes_facturacion->links();
			endif;
		?>

	</div>
	@endif
</div>

<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_nc'>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header" style="background: #de0000">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Nota Crédito</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<iframe  class="old_file" id="pdf_nc" style="width: 850px; height: 560px;" ></iframe>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<span id="invoices"></span>
					</center>
					<!--<button type="button" class="btn btn-success guardar_pdf">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
				</div>
		</div>
	</div>
</div>

<div class="modal" id='modal_rc' style="position: fixed;" data-backdrop="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header" style="background: #0FAEF3">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: black; font-size: 25px; float: right">&times</span></button>
					<h4 class="modal-title" style="text-align: center;" id="name"><b id="title">SOPORTES</b></h4>
				</div>
				<div class="modal-body">

					<center>
					<h4 style="text-aling: center">Soportes del Banco</h4>
					<!--<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-warning modificar2">MODIFICAR</button>-->
					<div style="margin-bottom: 10px" class="images">



					</div>

					<span style="color: red">Presiona click en ver imagen para ver los soportes*</span>

					</center>
					<hr>
					<center>

						<form id="reci2">

							<center>
								<h4 class="new_file hidden">Adjuntar recibo de Caja</h4>
								<input class="recibo2 new_file hidden" type="file" value="Subir" name="recibo">
							</center>
							<a id="guardar_soporte2" style="float: right; margin-top: 20px; margin-right: 6px; margin-bottom: 15px" class="btn btn-primary btn-icon new_file hidden">GUARDAR<i class="fa fa-check icon-btn"></i></a>

						</form>

						<h4 class="old_file">Recibo de caja Siigo</h4>
						<!--<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-warning modificar">MODIFICAR</button>-->
						<!--<center><a data-name="'+data.invoice[i].nombre_imagen+'" style="margin-top: 15px; margin-bottom:10px" class="btn btn-danger delete_img">ELIMINAR <i class="fa fa-trash" aria-hidden="true"></i></a></center>-->
						<iframe  class="old_file" id="pdf_rc" style="width: 850px; height: 360px;" ></iframe>
					</center>
				</div>

				<div class="dat">
					<h4 class="new_soporte hidden">Soportes del Banco</h4>
					<form class="dropzone hidden new_soporte" id="my-awesome-dropzone">
							<input type="hidden" name="id" id="id_fac">
							<div class="dz-message hidden new_soporte" data-dz-message><span>Presiona para subir las imágenes</span></div>
					</form>
				</div>
				<div class="modal-footer">
					<!--<button type="button" class="btn btn-success guardar_pdf">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
				</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_rc_revision'>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header" style="background: #FFAB40">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: black; font-size: 40px">&times</span></button>
					<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">REVISIÓN DE SOPORTES</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<h4>Recibo de Caja Siigo</h4>
						<iframe id="pdf_rc_revision" style="width: 850px; height: 360px;" ></iframe>
					</center>
				</div>
				<hr style="border: 1px solid">

				<center>
					<h4>Soportes del Banco</h4>
					<div style="margin-bottom: 10px" class="images_revision">

					</div>

					<span style="color: red">Presiona click en ver imagen para ver los soportes*</span>
				</center>
				<div class="modal-footer" style="margin-top: 20px">
					<textarea style="float: left" name="name" rows="3" cols="100" placeholder="Ingresar Comentarios de Revisión" id="observaciones_revision"></textarea>
					<button class="btn btn-primary btn-icon revision_ingreso">REVISAR
						<i class="fa fa-check icon-btn"></i>
					</button>
					<!--<button type="button" class="btn btn-success guardar_pdf">Guardar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
				</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_parla'>
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
				<div class="modal-header" style="background: #1565C0">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 40px">&times</span></button>
					<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">COMENTARIOS</b></h4>
				</div>
				<div class="modal-body">
					<center>
						<span id="parla"></span>
					</center>
				</div>
		</div>
	</div>
</div>

<!--<div id="modal-activar-reconfirmacion" style="opacity: 1;" class="hidden">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Vencimiento<i id="cerrar_alert" style="float: right; font-weight:100; cursor: pointer;" class="fa fa-close"></i></div>
			<div class="panel-body">
				<small class="text-primary" id="vplazo_pago"></small><br>
				<small class="text-primary" id="vdias_vencidos"></small>
			</div>
		</div>
	</div>
</div>-->

<div class="modal" id='modal_img' tabindex="-1" style="position: fixed;" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button>-->
            <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea h4 text-center mt-3 mb-4 pb-3">Soporte</b></h4>
          </div>
          <div class="modal-body">

							<div class="panel-body">
								<img class="img-responsive" id="img_ingreso">
							</div>

          </div>

          <div class="modal-footer">

            <a id="cerrar" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>

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
<script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">

	var currentUrl = window.location.href;
	urlArray = currentUrl.split('/');

	if(urlArray[6]==='facturasporvencer' || urlArray[6]==='facturasvencidas'){

	}else{
		$numerob = setInterval(function(){
			$('#example3_info').addClass('hidden');
		}, 1);
	}

	$('#example3').on('click', '.anular_factura', function () {

		var factura = $(this).attr('data-id');
		var valor_factura = $(this).attr('data-valor');

		console.log('Test factura '+valor_factura)

		console.log('testessss :  1 '+$(this).attr('data-v'))

			$('#valor').removeClass('hidden');
			$('.parcials').prop('checked',true).attr('disabled',true).addClass('hidden');
			$('.not_parcial').addClass('hidden');

		$('#titles').html('NOTA CRÉDITO PARCIAL')
		$('#modal_nota').modal('show');
		$('#guardar_soporte1').attr('data-id',factura);
		$('#guardar_soporte1').attr('data-valor-factura',valor_factura);
		$('#invoice').html($(this).attr('data-invoice'));
		$('#valor_invoice').html(' : '+number_format($(this).attr('data-valor')));

	});

	$('#cerrar_alerta').click(function(e){
    $(this).closest('#alert_eliminar').addClass('hidden');
  });

	$('.cerrar_alertas').click(function(e){

		var factura = $(this).attr('data-id');
		var valor_factura = $(this).attr('data-valor');

		$('.cerrar_alertas').prop('checked',false);

		$('#guardar_soporte1').attr('data-id',factura);
		$('#guardar_soporte1').attr('data-valor-factura',valor_factura);
		$('#invoice').html($(this).attr('data-invoice'));
		$('#valor_invoice').html(' : '+number_format($(this).attr('data-valor')));

		$('#valor').addClass('hidden');
		$('.parcials').prop('checked',false).attr('disabled',true);

		$.confirm({
        title: '¡Atención!',
        content: '¿Estás seguro de registrar <b>Nota crédito Total</b> en esta factura?',
        buttons: {
            confirm: {
                text: 'Si, Lo estoy!',
                btnClass: 'btn-danger',
                keys: ['enter', 'shift'],
                action: function(){

									$('#titles').html('NOTA CRÉDITO TOTAL')
									$('.not_parcial').addClass('hidden')
									$('.parcials').addClass('hidden')
									$('.cerrar_alertas').closest('#modal-activar-reconfirmacion').addClass('hidden');
									$('#modal_nota').modal('show');

                }

            },
            cancel: {
              text: 'Cancelar',
            }
        }
    });

  });

	$('#guardar_soporte1').click(function() {

		 var valor = $('#valor').val().trim().replace(',','').replace(',','').replace(',','');
		 var file = $('#recibo').val();
		 var id = $(this).attr('data-id');
		 var noica = $('.parcials').val();
		 var valor_factura = $(this).attr('data-valor-factura');

		 if(!$('.parcials').is(':checked')){
			 valor = valor_factura;
		 }

		 console.log($('.parcials').is(':checked'))
		 //console.log(file)
		 //console.log(id)

		 //alert('Valor : '+valor)
		 //alert('Valor Factura : '+valor_factura)

		if( file === '' && $('#valor').hasClass('hidden') ){

			var data = '';

			if(file === ''){
				data += 'Debe adjuntar un archivo...<br><br>';
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

		}else if( file === '' || valor === '' ){

			var data = '';

			if(file === ''){
				data += 'Debe adjuntar un archivo...'
			}

			if(valor === ''){
				data += '<br><br>El campo valor está vacío...';
			}

			/*if(valor>=valor_factura){

				data += '<br><br>Estás ingresando un valor igual o mayor al valor de la factura... 1';
			}*/

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

			formData = new FormData($('#recin')[0]);
			formData.append('valor',valor);
			formData.append('recibo',$('#recibo').val());
			formData.append('data-id',id);

			console.log($('#recibo').val());

			$.ajax({
					type: "post",
					url: "anularfacturatransportefile",
					data: formData,
					processData: false,
					contentType: false,
					success: function(data) {

							if(data.respuesta===false){
								$.alert('No se pudo registrar la Nota Crédito.');
							}else if(data.respuesta===true){

								$.alert('Nota Crédito Registrada!');
								$('#modal_nc').modal('hide');
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

	$('.pagination').css({
		'margin-top': '10px'
	});

	$('.modificar').click(function() {
		$('.old_file').addClass('hidden');
		$('.new_file').removeClass('hidden');
		$(this).addClass('hidden');
	})

	$('.modificar2').click(function() {
		$('.images').addClass('hidden');
		$('.new_soporte').removeClass('hidden');
		$(this).addClass('hidden');
	});

	$('#example3').on('click', '.rc', function () {
		console.log('test '+$(this).attr('data-id'))
		$('#guardar_soporte').attr('id-factura',$(this).attr('data-id'));
		$('#guardar_soporte2').attr('id-factura',$(this).attr('data-id'));
		$('#subir_imagenv2').attr('data-id',$(this).attr('data-id'));
		$('#id_fac').val($(this).attr('data-id'))
		$('#titulo').html('FV-2-'+$(this).attr('data-factura'))
		$('#modal-activar-reconfirmacion').removeClass('hidden')
		$('.cerrar_alertas').attr('data-id',$(this).attr('data-id'))
		$('.cerrar_alertas').attr('data-valor',$(this).attr('data-valor'))
		$('.cerrar_alertas').attr('data-invoice',$(this).attr('data-factura'))
		$('.save').attr('data-id',$(this).attr('data-id'))
		$('.save').attr('data-valor',$(this).attr('data-valor'))
	})

	$('#example3').on('click', '.ver_rc_revision', function () {

		var factura = $(this).attr('data-id');
		console.log('Revisión : '+factura)

		$.ajax({
      url: '../facturacion/verrcrevision',
      method: 'post',
      data: {factura: factura}
    }).done(function(data){

      if(data.respuesta==true){

					$('.revision_ingreso').attr('data-id',factura);
        	//$.alert('Recibo de Caja <br><br>N° '+data.recibo);
					//var url = 'http://localhost/autonet/biblioteca_imagenes/contabilidad/rc/'+data.id_recibo+'';
					var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/contabilidad/rc/'+data.id_recibo+'';

					$('#pdf_rc_revision').attr('src',url);

					$('#modal_rc_revision').modal('show');

					$('.images_revision').html('');

					for(var i in data.invoice){
						var img = '';
						//img = '<img src="http://localhost/autonet/biblioteca_imagenes/facturacion/ingresos/'+data.invoice[i].nombre_imagen+'" alt="" width="200px" height="150px" style="margin-left: 15px">';
						img = '<a type="button" data-id="'+data.invoice[i].nombre_imagen+'" alt="" class="btn btn-default btn-list-table test2" alt="" width="200px" height="150px" style="margin-left: 15px">Ver Imagen</a>';
						console.log(img)
						$('.images_revision').append(img);
					}

      }else if(data.response==false){

      }

    });

	})

	$('.revision_ingreso').click(function() {

		var observaciones = $('#observaciones_revision').val();
		console.log(observaciones);

		var factura = $(this).attr('data-id');
		console.log(factura);

		$.ajax({
      url: '../facturacion/revisioningreso',
      method: 'post',
      data: {id: factura, observaciones: observaciones}
    }).done(function(data){

      if(data.respuesta==true){

				location.reload();

      }else if(data.response==false){

      }

    });

	});

	$('#subir_imagenv2').click(function(e){

      e.preventDefault();

      var $objeto = $(this);
      var detalle_imagen = 'ff';//$('#detalle_imagen').val().toUpperCase().trim();
      var formData = new FormData($('#ingreso_imagen')[0]);
      formData.append('id',$(this).attr('data-id'));
      formData.append('detalle','test');
			//formData.append('foto',$('#foto').val());

      if(detalle_imagen===''){
          alert('Debe digitar un detalle!');
      }else{
          $.ajax({
              url: 'ingresoimagenv2',
              data: formData,
              method: 'post',
              processData: false,
              contentType: false,
              success: function(data){

                  if (data.respuesta===true) {
                      alert('Realizado');
                      $('.image_perfil').addClass('disabled');
                      $('.file-input-name').text('');
                      //location.reload();
                  }else if (data.respuesta===false) {
                      alert('Debe adjuntar un archivo de imagen!');
                  }

              },
              error: function(data){

              }
          });
      }


  });

	$('#example3').on('click', '.ver_rc', function () {

		var factura = $(this).attr('data-id');
		console.log(factura)

		$.ajax({
      url: '../facturacion/verrc',
      method: 'post',
      data: {factura: factura}
    }).done(function(data){

      if(data.respuesta==true){

        	//$.alert('Recibo de Caja <br><br>N° '+data.recibo);
					//var url = 'http://localhost/autonet/biblioteca_imagenes/contabilidad/rc/'+data.id_recibo+'';
					var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/contabilidad/rc/'+data.id_recibo+'';

					$('#pdf_rc').attr('src',url);

					//console.log('pruebas  '+factura)
					$('#modal_rc').modal('show');
					$('#guardar_soporte2').attr('id-factura',factura);

					$('.images').html('');

					for(var i in data.invoice){
						var img = '';
						img = '<a type="button" class="btn btn-default btn-list-table test" data-id="'+data.invoice[i].nombre_imagen+'" alt="" width="200px" height="150px" style="margin-left: 15px">Ver Imagen</a>';
						//img = '<img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/'+data.invoice[i].nombre_imagen+'" alt="" width="200px" height="150px" style="margin-left: 15px">';
						console.log(img)
						$('.images').append(img);
						//$('.images').html('').append(img);
					}

					if(data.revision===1){
						//console.log('revision 1 ON')
						$('.modificar').attr('disabled','disabled');
						$('.modificar2').attr('disabled','disabled');
						$('.delete_img').attr('disabled','disabled');
					}else{
						$('.modificar').removeAttr('disabled');
						$('.modificar2').removeAttr('disabled');
						$('.delete_img').removeAttr('disabled','disabled');
					}

      }else if(data.response==false){

      }

    });

	});

	$('#example3').on('click', '.ver_nc', function () {

		var factura = $(this).attr('data-url');
		console.log(factura)

		$('#invoices').html('Factura N° '+$(this).attr('data-inv'))

		//var url = 'http://localhost/autonet/biblioteca_imagenes/contabilidad/nc/'+factura+'';
		var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/contabilidad/nc/'+factura+'';

		$('#pdf_nc').attr('src',url);
		$('#modal_nc').modal('show');
/*
  	//$.alert('Recibo de Caja <br><br>N° '+data.recibo);
		var url = 'http://localhost/autonet/biblioteca_imagenes/contabilidad/rc/'+data.id_recibo+'';

		$('#pdf_rc').attr('src',url);

		console.log('pruebas  '+factura)
		$('#modal_rc').modal('show');
		$('#guardar_soporte2').attr('id-factura',factura);

		for(var i in data.invoice){
			var img = '';
			img = '<div class="col-lg-6 delete_img"><img src="http://localhost/autonet/biblioteca_imagenes/facturacion/ingresos/'+data.invoice[i].nombre_imagen+'" alt="" width="300px" height="250px" style="margin-left: 15px"><center><button onclick="myFunction('+data.invoice[i].nombre_imagen+')" class="btn btn-danger delete_img" data-name="'+data.invoice[i].nombre_imagen+'" style="margin-top: 15px; margin-bottom:10px">ELIMINAR <i class="fa fa-trash" aria-hidden="true"></i></button></center></div>';
			//console.log(img)
			$('.images').html('').append(img);
		}

		if(data.revision===1){
			console.log('revision 1 ON')
			$('.modificar').attr('disabled','disabled');
			$('.modificar2').attr('disabled','disabled');
			$('.delete_img').attr('disabled','disabled');
		}else{
			$('.modificar').removeAttr('disabled');
			$('.modificar2').removeAttr('disabled');
			$('.delete_img').removeAttr('disabled','disabled');
		}
*/
	});

	function myFunction(data){
		console.log('myFunction : '+data)
	}

	$('.delete_img').click(function() {
		var name = $(this).attr('data-name');
		console.log(name)
	});

	$('.pagototal').click(function() {
		if($(this).attr('data-value')!=1){
			console.log('total')
			$('.save').removeAttr('disabled','disabled')
			$('.save').removeClass('disabled')

			$('#otro_valor').attr('disabled','disabled')
			$('#otro_valor').addClass('disabled')
			$('#otro_valor').val('')
		}
		$(this).attr('data-value',1);
		$('.parcial').attr('data-value',0);

	})

	$('.parcial').click(function() {
		if($(this).attr('data-value')!=1){
			console.log('parcial')
			if($('#otro_valor').val()!=''){
				$('.save').removeAttr('disabled','disabled')
				$('.save').removeClass('disabled')

				$('#otro_valor').removeAttr('disabled','disabled')
				$('#otro_valor').removeClass('disabled')

			}else{
				$('.save').attr('disabled','disabled')
				$('.save').addClass('disabled')

				$('#otro_valor').removeAttr('disabled','disabled')
				$('#otro_valor').removeClass('disabled')

			}
		}
		$(this).attr('data-value',1);
		$('.pagototal').attr('data-value',0);
	})

	$('#otro_valor').keyup(function() {
		if($(this).val()!=''){
			$('.save').removeAttr('disabled','disabled')
			$('.save').removeClass('disabled')
		}else{
			$('.save').attr('disabled','disabled')
			$('.save').addClass('disabled')
		}
	})

	$('.save').click(function() {
		console.log('test '+$(this).attr('data-id'))
		var factura = $(this).attr('data-id');
		var valor = $(this).attr('data-valor');

		$.confirm({
            title: 'Confirmación',
            content: 'Estás seguro de la generación del RC por el valor total?<br><br> Valor: $ '+valor+'',
            buttons: {
                confirm: {
                    text: 'Si, Generar Recibo!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
                        url: '../facturacion/rc',
                        method: 'post',
                        data: {factura: factura}
                      }).done(function(data){

                        if(data.respuesta==true){

                        	console.log('aprobado')
	                    	$('#otro_valor').val('');
	                    	$('#modal-activar-reconfirmacion').addClass('hidden')
	                    	$('.save').removeAttr('data-id');

	                    	$('.pagototal').prop('selected', false);
	                    	$('.parcial').prop('selected', false);
	                    	location.reload()
                          	$.alert('Recibo de Caja Generado!');

                        }else if(data.response==false){

                        }

                      });
                    }

                },
                cancel: {
                  text: 'Cancelar',
                }
            }
        });
	})

	$('.comentario').click(function() {
		var id = $(this).attr('data-id');

		$.ajax({
      url: '../facturacion/vercomentario',
      method: 'post',
      data: {id: id}
    }).done(function(data){

      if(data.respuesta==true){

					$('#parla').html(data.comentario);

					$('#modal_parla').modal('show');

      }else if(data.response==false){

      }

    });

	})

	$('#guardar_soporte').click(function() {

		console.log($('#recii').val())
		console.log($(this).attr('id-factura'))

		if( $('#recii').val()==='' || $('#fecha_ingreso').val()==='' ){
			var data = '';

			if( $('#recii').val()==='' ) {
				data += '<li>Debes adjuntar el recibo de caja.</li>';
			}

			if( $('#fecha_ingreso').val()==='' ) {
				data += '<li>No has seleccionado la fecha del ingreso.</li>';
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
	    formData.append('recibo',$('.recibo').val());
			formData.append('id',$(this).attr('id-factura'));
			formData.append('fecha',$('#fecha_ingreso').val());

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
	    });

		}

	});

	$('#guardar_soporte2').click(function() {

		console.log($('.recibo2').val())
		console.log($(this).attr('id-factura'))

		formData = new FormData($('#reci2')[0]);
        formData.append('recibo',$('.recibo2').val());
				formData.append('id',$(this).attr('id-factura'));

        console.log($('.recibo2').val());

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
        });

	});

</script>

<script>
		Dropzone.options.myDropzone = {
				autoProcessQueue: true,
				uploadMultiple: false,
				maxFilezise: 1,
				maxFiles: 4,
				addRemoveLinks: 'dictCancelUploadConfirmation ',
				url: '../facturacion/ingresoimagenv2',
				init: function() {
						var submitBtn = document.querySelector("#subir");

						myDropzone = this;
						submitBtn.addEventListener("click", function(e){
								e.preventDefault();
								e.stopPropagation();
								myDropzone.processQueue();
						});
						this.on("addedfile", function(file) {

						});
						this.on("complete", function(file) {

						});
						myDropzone.on("success", function(file, response) {
								if(response.mensaje===true){
										$(file.previewElement).fadeOut({
												complete: function() {
														// If you want to keep track internally...
														myDropzone.removeFile(file);
												}
										});
										alert(response.respuesta);
								}else if(response.mensaje===false){
										alert(response.respuesta);
								}

						});
				}
		};

		Dropzone.options.myAwesomeDropzone = {
				autoProcessQueue: true,
				uploadMultiple: false,
				maxFilezise: 1,
				maxFiles: 4,
				addRemoveLinks: 'dictCancelUploadConfirmation ',
				url: '../facturacion/ingresoimagenv2',
				init: function() {
						var submitBtn = document.querySelector("#subir");

						myAwesomeDropzone = this;
						submitBtn.addEventListener("click", function(e){
								e.preventDefault();
								e.stopPropagation();
								myAwesomeDropzone.processQueue();
						});
						this.on("addedfile", function(file) {

						});
						this.on("complete", function(file) {

						});
						myAwesomeDropzone.on("success", function(file, response) {
								if(response.mensaje===true){
										$(file.previewElement).fadeOut({
												complete: function() {
														// If you want to keep track internally...
														myAwesomeDropzone.removeFile(file);
												}
										});
										alert(response.respuesta);
								}else if(response.mensaje===false){
										alert(response.respuesta);
								}

						});
				}
		};

		$('.pdf_factura').click(function(){
			//Generar PDF

			var id = $(this).attr('data-id');

			$.confirm({
          title: 'Confirmación',
          content: '¿Estás seguro de generar la Factura de Siigo?',
          buttons: {
              confirm: {
                  text: 'Si, Generar PDF!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

										$.ajax({
								      url: '../facturacion/generarpdffactura',
								      method: 'post',
								      data: {id: id}
								    }).done(function(data){

								      if(data.respuesta==true){

												alert('Documento generado satisfactoriamente!');
												location.reload();
								      }else if(data.response==false){
												alert('No generado. Intente nuevamente...');
								      }

								    });

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }
      });

		});

		$(document).on('click', '.test', function(){

			var url = $(this).attr('data-id');

			//alert('Pruebas : '+url);

			//var data = $(this).attr('data-url');

      //var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/actividades/diarias/'+url;
			var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/'+url;

      //$('.img_view').attr('src',url);
      $('#modal_img').modal('show');

			$('#modal_rc').modal('hide');

			var imagenSrc = $(this).attr('data-id');
      $('#cerrar').removeAttr('data-option');
      $('#img_ingreso').attr('src',url);

		});

		$(document).on('click', '.test2', function(){

			var url = $(this).attr('data-id');

			//alert('Pruebas : '+url);

			//var data = $(this).attr('data-url');

      //var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/actividades/diarias/'+url;
			var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/'+url;

      //$('.img_view').attr('src',url);
      $('#modal_img').modal('show');

			$('#modal_rc').modal('hide');

			var imagenSrc = $(this).attr('data-id');
      $('#cerrar').attr('data-option',1);
      $('#img_ingreso').attr('src',url);

		});

		$('#cerrar').click(function(){

			$('#modal_img').modal('hide');

			if( $(this).attr('data-option')!=1 ){
				$('#modal_rc').modal('show');
			}

			//$("html, body").animate({ scrollTop: $(document).height() }, 1000);

		});

		/*$('.test').click(function(){
			alert('Pruebas');
		});*/

		$('.activar_nc').click(function(){

			var id = $(this).attr('data-value-id');
			var numero = $(this).attr('data-value-factura');

			$.confirm({
          title: '¡Atención!',
          content: '¿Estás seguro de habilitar la Factura N° <b>' +numero+ '</b> para que se le aplique nota crédito?',
          buttons: {
              confirm: {
                  text: 'Si, Habilitarla!',
                  btnClass: 'btn-warning',
                  keys: ['enter', 'shift'],
                  action: function(){

										$.ajax({
						          url: '../facturacion/activarnc',
						          method: 'post',
						          data: {id: id}
						        }).done(function(data){

						          if(data.respuesta==true){
						            alert('Nota crédito habilitada para la factura N° '+numero);
												location.reload();
						          }else if(data.respuesta==false){
												alert('No se pudo habilitar la Nota crédito para la factura N° '+numero);
						          }

						        });

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }
      });

		});

		$('.parcials').change(function(){

			var noica = $('.parcials').val();

			if($('.parcials').is(':checked')){
				noica = 'checked';
				$('#valor').removeClass('hidden');
				$('#titles').html('NOTA CRÉDITO PARCIAL')
			}else{
				noica = 'nochecked';
				$('#valor').addClass('hidden');
				$('#titles').html('NOTA CRÉDITO TOTAL')
			}

			console.log(noica)

		});

		$('.actualizar_token').click(function(){

			$('.loader').removeClass('hidden');
			$(this).addClass('hidden');

			$.ajax({
				url: 'actualizartoken',
				method: 'post',
				data: {id: 12}
			}).done(function(data){

				if(data.respuesta==true){

					$('.loader').addClass('hidden');
					$('.actualizar_token').removeClass('hidden');

					$.confirm({
		          title: '¡Token Generado!',
		          content: 'Se ha actualizado el token y su fecha de vencimiento es el <b>'+data.fecha+'</b> a las <b>'+data.hora+'</b>.',
		          buttons: {
		              confirm: {
		                  text: 'Recargar Página',
		                  btnClass: 'btn-success',
		                  keys: ['enter', 'shift'],
		                  action: function(){

												location.reload();

		                  }

		              }
		          }
		      });

				}else if (data.respuesta==='error') {

						$('.loader').addClass('hidden');
						$('.actualizar_token').removeClass('hidden');

						 $.confirm({
								 title: 'Atención! <i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i>',
								 content: '¡Se ha generado un error en la generación de Token Siigo!<br><br><b>Detalles <i style="color: red" class="fa fa-arrow-down" aria-hidden="true"></i></b><br><b>error:</b> <span style="color: red">'+data.code+'</span><br><b>info:</b> '+data.message,
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

		});

		$('input[type=file]').bootstrapFileInput();
  	$('.file-inputs').bootstrapFileInput();

</script>

</body>
</html>
