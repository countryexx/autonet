<html>
<head>
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Factura pago de proveedores</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>

	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">FACTURA PROVEEDORES VERSIÓN ANTIGUA</h3>
		<div class="col-lg-12">

</div>
		<form class="form-inline" id="form_buscar">
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
	                    <div class="input-group" id="datetime_fecha">
	                        <div class='input-group date' id='datetimepicker10'>
	                            <input id="fecha_pago" name="fecha_pago" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA DE PAGO" value="">
	                            <span class="input-group-addon">
	                                <span class="fa fa-calendar">
	                                </span>
	                            </span>
	                        </div>
	                    </div>
	                </div>
	                <div class="form-group">
	                	<select id="opcion_numero" class="form-control input-font">
	                		<option>-</option>
	                		<option value="1">NUMERO DE FACTURA</option>
	                		<option value="2">NUMERO CONSECUTIVO AP</option>
	                	</select>
	                </div>
	                <div class="form-group">
	                	<input placeholder="DIGITE NUMERO" id="numero" class="form-control input-font" name="pagado">
	                </div>
	                <button id="buscar_factura_pago_proveedores" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </button>
	            </div>
	        </div>
	    </form>
	    <table id="example5" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>Consecutivo</td>
	    			<td>Factura</td>
	    			<td>Fecha de Expedicion</td>
	    			<td>Centro de Costo</td>
	    			<td>Proveedor</td>
	    			<td>Fecha Inicial</td>
	    			<td>Fecha Final</td>
	    			<td>Fecha de Pago</td>
	    			<td>Valor</td>
	    			<td>Usuario</td>
	    			<td></td>
	    		</tr>
	    	</thead>
	    	<tbody>

	    	</tbody>
	    	<tfoot>
	    		<tr>
	    		<tr>
	    			<td>Consecutivo</td>
	    			<td>Factura</td>
	    			<td>Fecha de Expedicion</td>
	    			<td>Centro de Costo</td>
	    			<td>Proveedor</td>
	    			<td>Fecha Inicial</td>
	    			<td>Fecha Final</td>
	    			<td>Fecha de Pago</td>
	    			<td>Valor</td>
	    			<td>Usuario</td>
	    			<td></td>
	    		</tr>
	    	</tfoot>
	    </table>
	    <div style="margin-top: 15px;" class="col-lg-5">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading">TOTALES</div>
					<div class="panel-body">
						<table style="margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);" class="table table-bordered hover">
						    <tr>
						    	<td>TOTAL CUENTAS DE COBRO</td>
						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_cuentas">$ 0</label></td>
						    </tr>
						    <!--<tr>
						    	<td>IVA</td>
						    	<td>
						    		<select class="form-control input-font" id="iva">
						    			<option value="0">-</option>
						    			<option value="1">SI</option>
						    			<option value="2">NO</option>
						    		</select>
						    	</td>
						    </tr>
						    <tr id="valor_iva" class="hidden">
						    	<td>VALOR IVA</td>
						    	<td><input disabled class="form-control input-font valor_iva"></td>
						    </tr>-->
						    <tr>
						    	<td>DESCUENTO RETEFUENTE</td>
						    	<td><input class="form-control input-font" id="descuento_retefuente"></td>
						    </tr>
						    <tr id="valor_retefuente" class="hidden">
						    	<td>VALOR RETEFUENTE</td>
						    	<td><input disabled class="form-control input-font valor_retefuente"></td>
						    </tr>
								<tr class="table_botones">
									<td>DESCUENTOS</td>
									<td>
										<a id="agregar_descuento" style="margin-right: 3px;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
										<a id="eliminar_descuento" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>
									</td>
								</tr>
						</table>
						<table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
						</table>
						<table class="table table-bordered hover" style="margin-bottom: 0px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
						    <tr>
						    	<td style="width: 190px;">TOTAL OTROS DESCUENTOS</td>
						    	<td><input class="form-control input-font" id="otros_descuentos"></td>
						    </tr>

						    <!--<tr class="test hidden" id="ti">
						    	<td>CONCEPTO DE PRESTAMOS</td>
						    	<td>
						    		<a id="modal_detalles" proveedor-id="" class="btn btn-danger btn-icon">VER DETALLES<i class="fa fa-eye icon-btn"></i></a>
						    	</td>
						    </tr>-->
								<tr class="por_descontar hidden">
									<td colspan="2">
										<table class="table table-bordered table-hover" id="exampleselect">
												<thead>
												<tr>
													<th style="text-align: center; width: 40%">VALOR TOTAL DEL PRÉSTAMO</th>
													<th style="text-align: center; width: 40%">TIPO DE ABONO</th>
												</tr>
												</thead>
												<tbody>

												</tbody>
										</table>
									</td>
								</tr>
								<tr class="test hidden" id="te">
						    	<td class="columna1" style="width: 41%">VALOR POR DESCONTAR DE PRESTAMOS</td>
						    	<td class="columna2 hidden" style="width: 44%">VALOR DESCONTADO DE PRESTAMOS</td>
						    	<td><input class="form-control input-font" id="prestamo1" disabled></td>
						    </tr>

								<!-- -->
								<tr class="descontado hidden">
									<td colspan="2">
										<table class="table table-bordered table-hover" id="exampledescontado">
												<thead>
												<tr>
													<th style="text-align: center; width: 32%">#</th>
													<th style="text-align: center; width: 40%">VALOR DEL PRÉSTAMO</th>
												</tr>
												</thead>
												<tbody>

												</tbody>
										</table>
									</td>
								</tr>
								<!-- -->
						    <!--<tr class="norealizado">
						    	<td>VALOR DESCONTADO DE PRESTAMOS</td>
						    	<td><input class="form-control input-font" id="prestamo2" disabled></td>
						    </tr>-->
								<tr class="norealizado">
						    	<td>TOTAL PAGADO</td>
						    	<td><input class="form-control input-font" id="totales_pagado" disabled></td>
								<tr class="realizado hidden">
						    	<td>TOTAL PAGADO</td>
						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_todo">$ 0</label></td>
						    </tr>
								<tr class="observaciones">
						    	<td>OBSERVACIONES</td>
						    	<td><textarea style="margin-bottom: 0px" class="form-control input-font" id="observaciones"></textarea></td>
						    </tr>
							<tr class="info_pago hidden">
								<td style="width: 291px;"></td>
							</tr>
							<tr class="guardar_pago">
						    	<td></td>
						    	<td>
									@if($permisos->contabilidad->factura_proveedores->cerrar_pago==='on')
									    <a id="guardar_pago" class="btn btn-default btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
									@else
                                        <a class="btn btn-default btn-icon disabled">GUARDAR<i class="icon-btn fa fa-save"></i></a>
									@endif
								</td>
						    </tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- -->
		<div class="modal fade" tabindex="-1" role="dialog" id='modal_vista'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="width: 800px">
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">DETALLES DE LOS PRESTAMOS</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      <!-- -->
                      <table class="table table-bordered table-hover" id="exampledetalles">
                          <thead>
                          <tr>
                      		<th>#</th>
                            <th>CREADO POR</th>
                            <th>CONCEPTO</th>
                            <th>VALOR</th>
                            <th>FECHA Y HORA</th>
                          </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>
		<!-- -->
	</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}">

</script>
<script>

	function goBack(){
	    window.history.back();
	}

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
