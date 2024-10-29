<html>
<head>
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Pago Proveedores</title>
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">PAGO A PROVEEDORES</h3>
		<form class="form-inline" id="form_buscar" method="post"  action="{{url('facturacion/exportarpagosproveedores')}}">
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
	                    <div class="input-group datetime_fecha">
	                        <div class='input-group date' id='datetimepicker1'>
	                            <input id="fecha_inicial" name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
	                            <span class="input-group-addon">
	                                <span class="fa fa-calendar">
	                                </span>
	                            </span>
	                        </div>
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="input-group datetime_fecha">
	                        <div class='input-group date' id='datetimepicker1'>
	                            <input id="fecha_final" name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
	                        <span class="input-group-addon">
	                            <span class="fa fa-calendar">
	                            </span>
	                        </span>
	                        </div>
	                    </div>
	                </div>
					<div class="input-group proveedor_content">
						<select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
							<option value="0">PROVEEDORES</option>
							@foreach($proveedores as $proveedor)
								<option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
							@endforeach
						</select>
						<span style="cursor: pointer" class="input-group-addon proveedor_eventual_pagos"><i class="fa fa-car"></i></span>
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
	                	<select id="pagado" class="form-control input-font" name="pagado">
	                		<option>-</option>
	                		<option value="1">PAGADOS</option>
	                		<option value="2">NO PAGADOS</option>
	                	</select>
	                </div>
	                <button id="buscar_pago_proveedores" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </button>
									<button class="btn btn-success btn-icon" type="submit" name="button">EXCEL<i class="fa fa-file-excel-o icon-btn" aria-hidden="true"></i></button>
	            </div>
	        </div>
	    </form>
	    <table id="example4" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>Codigo</td>
	    			<td>Fecha</td>
	    			<td># Constancia</td>
	    			<td>Pasajeros</td>
	    			<td>Detalle</td>
	    			<td>Observacion</td>
	    			<td>Valor</td>
	    			<td>Factura</td>
	    			<td>Consecutivo</td>
	    			<td>Revisado</td>
	    		</tr>
	    	</thead>
	    	<tbody>

	    	</tbody>
	    	<tfoot>
	    		<tr>
	    		<tr>
	    			<td>Codigo</td>
	    			<td>Fecha</td>
	    			<td># Constancia</td>
	    			<td>Pasajeros</td>
	    			<td>Detalle</td>
	    			<td>Observacion</td>
	    			<td>Valor</td>
	    			<td>Factura</td>
	    			<td>Consecutivo</td>
	    			<td>Revisado</td>
	    		</tr>
	    	</tfoot>
	    </table>
	    <div style="margin-top: 15px;" class="col-lg-4">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">DATOS DEL PAGO <input style="width: 15px; height: 15px; float: right; margin-left: 10px" type="checkbox" class="select_all_servicios"> 
					    <label style="float: right;">Seleccionar todos</label></div>
					<div class="panel-body">
						<table style="margin-bottom: 10px" class="table table-bordered hover">
						    <tr>
						    	<td>NUMERO DE FACTURA</td>
						    	<td><input id="numero_factura" type="text" class="form-control input-font"></td>
						    </tr>
						    <tr>
						    	<td>FECHA DE PAGO</td>
						    	<td>
						    		<div class="input-group datetime_fecha">
				                        <div class='input-group date' id='datetimepicker1'>
				                            <input id="fecha_pago" name="fecha_pago" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
				                            <span class="input-group-addon">
				                                <span class="fa fa-calendar">
				                                </span>
				                            </span>
				                        </div>
				                    </div>
				                </td>
						    </tr>
						    <tr>
						    	<td>VALOR NO COBRADO</td>
						    	<td><span id="valor_no_cobrado">0</span></td>
						    </tr>
						    <tr>
						    	<td>SUBTOTAL GENERAL A PAGAR</td>
						    	<td><span class="span-total bolder" id="subtotal_generado_pagar">0</span></td>
						    </tr>
						    <tr>
						    	<td>TOTAL REAL A PAGAR</td>
						    	<td><span class="span-total bolder" id="total_real_pagar">0</span></td>
						    </tr>
						</table>
						<div class="form-group">
							<label>Observaciones</label>
							<textarea id="observaciones" class="form-control input-font"></textarea>
						</div>
						@if($permisos->contabilidad->pago_proveedores->generar_orden_pago==='on')
							<a id="generar_orden_proveedores" class="btn btn-default btn-icon">GENERAR ORDEN DE PAGO DE PROVEEDOR<i class="fa fa-save icon-btn"></i></a>
						@else
							<a class="btn btn-default btn-icon disabled">GENERAR ORDEN DE PAGO DE PROVEEDOR<i class="fa fa-save icon-btn"></i></a>
						@endif
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
