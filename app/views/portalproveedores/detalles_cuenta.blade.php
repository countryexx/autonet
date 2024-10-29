<html>
<head>
	<title>Autonet | Detalles Cuenta de Cobro</title>
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
	@include('admin.menu')

		<div class="col-lg-12">
			<h3 class="h_titulo">DETALLE CUENTA DE COBRO</h3>
			@if($pago_proveedores_detalles!=null)
				<div class="col-lg-4">
					<div class="row">
					<table class="table" style="margin-bottom:0px">
						<tbody>
							<tr>
								<td>PROVEEDOR</td>
								<td><span style="color: #F47321;">{{$pago_proveedores->proveedornombre}}</span></td>
							</tr>
							<tr style="border-bottom: 1px solid #ddd;">
								<td>FECHA INICIAL</td>
								<td>{{$pago_proveedores->fecha_inicial}}</td>
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
									<td>FECHA DE EXPEDICION</td>
									<td>{{$pago_proveedores->fecha_expedicion}}</td>
								</tr>
								<tr style="border-bottom: 1px solid #ddd;">
									<td>FECHA FINAL</td>
									<td>{{$pago_proveedores->fecha_final}}</td>
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
									<td># DE CUENTA</td>
									<td>{{$pago_proveedores->id_cuenta}}</td>
								</tr>
								<tr style="border-bottom: 1px solid #ddd;">
									<td>VALOR</td>
									<td style="color: #F47321;"><?php echo '$ '.number_format($pago_proveedores->valor_cuenta); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="row">
							<p style="text-align: center; margin-top:10px" class="subtitulo">LISTADO DE SERVICIOS {{$pago_proveedores->fecha_inicial.' AL '.$pago_proveedores->fecha_final}}</p>
					</div>
				</div>
				<table class="table table-bordered hover tabla" cellspacing="0" width="100%">
			    	<thead>
			    		<tr>
			    			<td>#</td>
			    			<td>#Constancia</td>
			    			<td>Pasajeros</td>
			    			<td>Recoger en</td>
			    			<td>Dejar en</td>
			    			<td>Fecha</td>
			    			<td>Hora</td>
			    			<!--<td>Detalle</td>-->
			    			<td>Valor</td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<?php $nombre_anterior = ''; $i = 1;?>

			    		@foreach($pago_proveedores_detalles as $pago)
			    			@if($nombre_anterior!=$pago->razoncentro)
	                            <tr class="success">
	                                <td colspan="9"><b>{{$pago->razoncentro}}</b></td>
	                            </tr>
	                        @endif
							<tr>
								<td>{{$i++}}</td>
								<td>{{$pago->numero_planilla}}</td>
								<td>{{$pago->nombresubcentro}}</td>
								<td>{{$pago->recoger_en}}</td>
								<td>{{$pago->dejar_en}}</td>
								<td>{{$pago->fecha_servicio}}</td>
								<td>{{$pago->hora_servicio}}</td>
								<!--<td>{{$pago->detalle_recorrido}}</td>-->
								<td>$ {{number_format($pago->total_pagado)}}</td>
							</tr>
							<?php $nombre_anterior = $pago->razoncentro?>
						@endforeach
			    	</tbody>
			    	<tfoot>
			    		<tr>
			    		<tr>
			    			<td>#</td>
			    			<td>#Constancia</td>
			    			<td>Site</td>
			    			<td>Recoger en</td>
			    			<td>Dejar en</td>
			    			<td>Fecha</td>
			    			<td>Hora</td>
			    			<!--<td>Detalle</td>-->
			    			<td>Valor</td>
			    		</tr>
			    	</tfoot>
			    </table>

			@endif
			<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px">
				<div class="row">
					<a style="margin-bottom:10px" href="{{url('portalproveedores/historialdecuentas')}}" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>

					<a target="_blank" href="{{url('portalproveedores/pdfcuenta/'.$pago_proveedores->id_cuenta)}}" style="margin-bottom: 10px;" class="btn btn-warning btn-icon input-font">Descargar Cuenta<i class="fa fa-file-pdf-o icon-btn"></i></a>
				</div>
			</div>
		</div>

	@include('scripts.scripts')
	<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
	<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
	<script src="{{url('jquery/portalproveedores.js')}}"></script>

	<script type="text/javascript">
	  function goBack(){
	      window.history.back();
	  }
	</script>

</body>
</html>
