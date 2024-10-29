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
	<div class="col-lg-6">
		<div class="row">
			@include('facturacion.menu_facturacion')
		</div>
	</div>

	<div class="col-lg-12">
		<div class="row">
		  <h3 class="h_titulo">FACTURAS ANULADAS</h3>
		</div>
	</div>
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
				<tr @if ($orden['tipo_cliente']==2) {{'class="info"'}} @endif dias_vencidos="{{$orden['dias_vencidos']}}" operador="{{$orden['operador']}}">
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
							{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN INGRESO <i class="fa fa-close"></i></span>'}}
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
					<tr >
						<td>{{$orden->consecutivo}}</td>
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
							{{date_format($fecha_vencimiento, 'Y-m-d')}}
							@if($orden->ingreso==1)
								{{'<br><span style="font-size: 10px" class="text-success bolder">CON INGRESO <i class="fa fa-usd"></i></span>'}}
							@else
								{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN INGRESO <i class="fa fa-close"></i></span>'}}
							@endif
							@if($orden->revision_ingreso==1)
								{{'<br><span style="font-size: 10px" class="text-success bolder">REVISADO <i class="fa fa-check"></i></span>'}}
							@else
								{{'<br><span style="font-size: 10px" class="text-danger bolder">SIN REVISION <i class="fa fa-close"></i></span>'}}
							@endif
						</td>
						<td>{{$orden->numero_factura}}</td>
						<td><span class="bolder">$ {{number_format($orden->total_facturado_cliente)}}</span></td>
						<td>@if(intval($orden->tipo_orden)===1){{'TRANSPORTE'}}@else{{'OTROS'}}@endif</td>
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


<div id="modal-activar-reconfirmacion" style="opacity: 1;" class="hidden">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Vencimiento<i id="cerrar_alert" style="float: right; font-weight:100; cursor: pointer;" class="fa fa-close"></i></div>
			<div class="panel-body">
				<small class="text-primary" id="vplazo_pago"></small><br>
				<small class="text-primary" id="vdias_vencidos"></small>
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
<script src="{{url('jquery/facturacion.js')}}"></script>
<script type="text/javascript">

	var currentUrl = window.location.href;
	urlArray = currentUrl.split('/');

	if(urlArray[6]==='facturasporvencer' || urlArray[6]==='facturasvencidas'){

	}else{
		$numerob = setInterval(function(){
			$('#example3_info').addClass('hidden');
		}, 1);
	}



	$('.pagination').css({
		'margin-top': '10px'
	});

</script>
</body>
</html>
