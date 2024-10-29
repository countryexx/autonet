<html>
<head>
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Facturas con AP, Sin ingreso</title>
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
	<div class="col-lg-12">
		<div class="row">
			@include('facturacion.menu_facturacion')
		</div>
	</div>

	<div class="col-lg-12">
		<div class="row">
		  <h3 class="h_titulo">FACTURAS CON AP SIN INGRESO</h3>
		</div>
	</div>
	<!--
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
    </form>-->

  @if(isset($facturas))

	<div class="tabla">
		<table id="example33" class="table table-bordered hover tabla" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>AP</th>
					<th>Fecha inicial</th>
					<th>Fecha final</th>
					<th>Cliente</th>
					<th># de Factura</th>
					<th>Valor</th>
					<th>Pago</th>
				</tr>
			</thead>
			<tfoot>
			<tr>
				<th>AP</th>
				<th>Fecha inicial</th>
				<th>Fecha final</th>
				<th>Cliente</th>
				<th># de Factura</th>
				<th>Valor</th>
				<th>Pago</th>
			</tr>
			</tfoot>
			<tbody>
			<?php $totales_cobrado = 0;  $i=1;?>
			@foreach($facturas as $factura)

				<tr>
					<td class="bolder text-danger"><a target="_blank" href="{{url('facturacion/detallepagoproveedores/'.$factura->id_ap)}}">{{$factura->id_ap}}</a></td>
					<td>{{$factura->fecha_inicial}}</td>
					<td>{{$factura->fecha_final}}</td>
					<td><b>{{$factura->razonsocial}}</b></td>
					<td class="bolder text-primary"><a href="{{url('facturacion/verdetalle/'.$factura->id)}}">{{$factura->numero_factura}}</a></td>
					<td class="bolder text-primary">{{number_format($factura->total_facturado_cliente)}}</td>

					<td class="bolder text-primary"><a href="{{url('facturacion/detalleap/'.$factura->id_pago)}}">{{$factura->id_pago}}</a></td>
				</tr>
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

	$tablec = $('#example33').DataTable( {
        "order": [[ 0, "desc" ]],
        paging: false,

        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        'bAutoWidth': false,
        'aoColumns' : [
        	{ 'sWidth': '5%' },
            { 'sWidth': '5%' },
            { 'sWidth': '5%' },
            { 'sWidth': '16%' },
            { 'sWidth': '5%' },
            { 'sWidth': '5%' },
            { 'sWidth': '4%' },
            //{ 'sWidth': '5%' },
            //{ 'sWidth': '4%' },
            //{ 'sWidth': '9%' }
        ],
    });

    $('#example33').on('click','td', function(){

        var objeto = $(this).closest('tr');
        if (objeto.hasClass('table_seleccion')) {
            objeto.removeClass('table_seleccion');
        }else{
            objeto.addClass('table_seleccion');
        }
    });

</script>
</body>
</html>
