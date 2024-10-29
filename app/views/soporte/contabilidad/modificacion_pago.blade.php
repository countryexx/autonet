<html>
<head>
	<title>Soporte | Modificar Valores de Pagos</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
</head>
@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
<body>
	@include('admin.menu')
	
	<div class="col-lg-12">
		<h3 class="h_titulo">MODIFICACIÓN DE VALORES DE PAGOS A PROVEEDORES</h3>

		<form class="form-inline" id="form_buscar">
	        <div class="col-lg-12" style="margin-bottom: 5px">
	            <div class="row">
	            	<div class="form-group">
	                    <div class="input-group" id="datetime_fecha">
	                        <div class='input-group date' id='datetimepicker10'>
	                            <input id="fecha_inicial" name="fecha_pago" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
	                            <span class="input-group-addon">
	                                <span class="fa fa-calendar">
	                                </span>
	                            </span>
	                        </div>
	                    </div>
	                </div>
					<div class="form-group">
						<div class="input-group" id="datetime_fecha">
							<div class='input-group date' id='datetimepicker10'>
								<input id="fecha_final" name="fecha_pago" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
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
						<select data-option="1" name="estado" style="width: 130px;" class="form-control input-font">
							<option value="0">-</option>
							<option value="1">NO PREPARADO</option>
						</select>
					</div>
	                <a proceso="0" id="buscar_pagos" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </a>
	            </div>
	        </div>
	    </form>
	    <table id="example6" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>#</td>
	    			<td>Proveedor</td>
	    			<td>Fecha Registro</td>
	    			<td>Fecha Pago</td>
	    			<td>Total Pagado</td>
	    			<td>Descuento Retefuente</td>
	    			<td>Otros Descuentos</td>
	    			<td>Total Neto</td>
	    			<td>Usuario</td>
	    			<td></td>
	    			<td></td>
	    		</tr>
	    	</thead>
	    	<tbody>

	    	</tbody>
	    	<tfoot>
	    		<tr>
	    		<tr>
	    			<td>#</td>
	    			<td>Proveedor</td>
	    			<td>Fecha Registro</td>
	    			<td>Fecha Pago</td>
	    			<td>Total Pagado</td>
	    			<td>Descuento Retefuente</td>
	    			<td>Otros Descuentos</td>
	    			<td>Total Neto</td>
	    			<td>Usuario</td>
	    			<td></td>
	    			<td></td>
	    		</tr>
	    	</tfoot>
	    </table>
			<div class="col-lg-3">
				<div class="row">
					<div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px">
					  <div class="panel-heading">
					    <strong>TOTALES</strong>
					  </div>
					  <div class="panel-body">
							<table style="margin-bottom: 0px;" class="table table-bordered">
								<tbody>
									<tr>
										<td>TOTAL PAGADO</td>
										<td><span class="span-total" id="total_pagado">$ 0</span></td>
									</tr>
									<tr>
										<td>TOTAL DESCUENTO RETEFUENTE</td>
										<td><span class="span-total" id="descuento_retefuente">$ 0</span></td>
									</tr>
									<tr>
										<td>OTROS DESCUENTOS</td>
										<td><span class="span-total" id="otros_descuentos">$ 0</span></td>
									</tr>
									<tr>
										<td>TOTAL NETO</td>
										<td><span class="span-total" id="total_neto">$ 0</span></td>
									</tr>
								</tbody>
							</table>
					  </div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="row">
                    @if(isset($permisos->contabilidad->listado_de_pagos_preparar->preparar))
                        @if($permisos->contabilidad->listado_de_pagos_preparar->preparar==='on')
						    <button id="preparar" style="margin-top: 15px; margin-bottom:10px" class="btn btn-default">PREPARAR</button>
                        @else
                            <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">PREPARAR</button>
                        @endif
                    @else
                        <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">PREPARAR</button>
                    @endif
				</div>
			</div>
	</div>
	<div id="modal-activar-reconfirmacion" class="hidden" style="opacity: 1;">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Fecha de Pago<i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i></div>
                <div class="panel-body">
                    <label>Digite la fecha para la cual desea preparar el pago</label><br>
                    <div class="input-group" id="datetime_fecha" style="float: left; margin-right: 5px;">
                    <div class="input-group date" id="datetimepicker10">
                      <input id="fecha_preparacion" name="fecha_preparacion" style="width: 100px;" type="text" class="form-control input-font" placeholder="FECHA DE PAGO">
                      <span class="input-group-addon">
                          <span class="fa fa-calendar">
                          </span>
                      </span>
                    </div>
                </div>
                @if(isset($permisos->contabilidad->listado_de_pagos_preparar->preparar))
                    @if($permisos->contabilidad->listado_de_pagos_preparar->preparar==='on')
                        <a id="preparar_pago" style="float: left" class="btn btn-success btn-icon">PREPARAR<i class="fa fa-check icon-btn"></i></a>
                    @else
                        <a style="float: left" class="btn btn-success btn-icon">PREPARAR<i class="fa fa-check icon-btn"></i></a>
                    @endif
                @else
                    <a style="float: left" class="btn btn-success btn-icon">PREPARAR<i class="fa fa-check icon-btn"></i></a>
                @endif

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
<script src="{{url('jquery/soporte.js')}}"></script>
<script type="text/javascript">

	window.onload=function(){
		var pos=window.name || 0;
		window.scrollTo(0,pos);
	}

	window.onunload=function(){
		window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
	}

</script>
</body>
</html>
