<html>
<head>
	<title>Autonet | Listado de Pagos a Preparar</title>
</head>
@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
<body>
	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">LISTADO DE PAGOS A AUDITAR</h3>

		<form class="form-inline" id="form_buscar" action="{{url('facturacion/excelauditar')}}" method="get">
	        <div class="col-lg-12" style="margin-bottom: 5px">
	            <div class="row">
					<div class="form-group">
						<div class="input-group" id="datetime_fecha">
							<div class='input-group date' id='datetimepicker10'>
								<input id="fecha_inicial" name="fecha_pago1" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
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
								<input id="fecha_final" name="fecha_pago2" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
	                            <span class="input-group-addon">
	                                <span class="fa fa-calendar">
	                                </span>
	                            </span>
							</div>
						</div>
					</div>
					<div class="input-group proveedor_content">
						<select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">
							<option value="0">PROVEEDORES</option>
							@foreach($proveedores as $proveedor)
								<option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
							@endforeach
						</select>
						<span style="cursor: pointer" class="input-group-addon proveedor_eventual_pagos"><i class="fa fa-car"></i></span>
					</div>
					<!--<div class="form-group">
						<select data-option="1" name="estado" style="width: 130px;" class="form-control input-font">
							<option value="0">-</option>
							<option value="1">NO AUDITADO</option>
						</select>
					</div>-->
	                <a proceso="1" id="buscar_pagos" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </a>
	                <button type="submit" title="Exportar información de pago a Proveedores" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
	            </div>
	        </div>
	    </form>
	    <table id="example6" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>Proveedor</td>
	    			<td>Consecutivo</td>
	    			<td style="text-align: center">Fecha de Pago Estimada</td>
	    			<td>Total Pagado</td>
	    			<td>Descuento Retefuente</td>
	    			<td>Otros Descuentos</td>
	    			<td>Valor Préstamos</td>
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
	    			<td>Proveedor</td>
	    			<td>Consecutivo</td>
	    			<td style="text-align: center">Fecha de Pago Estimada</td>
	    			<td>Total Pagado</td>
	    			<td>Descuento Retefuente</td>
	    			<td>Otros Descuentos</td>
	    			<td>Valor Préstamos</td>
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
										<td>DESCUENTOS DE PRÉSTAMOS</td>
										<td><span class="span-total" id="prestamos_valores">$ 0</span></td>
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
					@if(isset($permisos->contabilidad->listado_de_pagos_auditar->auditar))
						@if($permisos->contabilidad->listado_de_pagos_auditar->auditar==='on')
							<button id="auditar_pago" style="margin-top: 15px; margin-bottom:10px" class="btn btn-default">AUDITAR</button>
						@else
							<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">AUDITAR</button>
						@endif
					@else
						<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">AUDITAR</button>
					@endif
				</div>
			</div>
			<!-- -->
		    <div class="modal fade" tabindex="-1" role="dialog" id='modal_vista'>
		          <div class="modal-dialog modal-md" role="document">
		            <div class="modal-content" style="height: 80%; width: 800px">
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
<script src="{{url('jquery/facturacion.js')}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
window.onload=function(){
	var pos=window.name || 0;
	window.scrollTo(0,pos);

}
window.onunload=function(){
window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
}

$('.verprestamos').click(function(){

	console.log('test')

    /*var option = parseInt($(this).val());
    var url = $('meta[name="url"]').attr('content');
    var htmlSelect = '';

    $.ajax({
      url: url+'/centrodecosto/vercentrosdecosto',
      method: 'post',
      data: {
        tipo_afiliado: option
      },
      dataType: 'json',
    }).done(function(data){

      if (data.respuesta===true) {

        $('select[name="centrodecosto"]').html('');
        $('select[name="centrodecosto"]').append('<option value="0">CENTROS DE COSTO</option>');

        for (var i in data.centrosdecosto) {

          htmlSelect += '<option value='+data.centrosdecosto[i].id+'>'+data.centrosdecosto[i].razonsocial+'</option>';

        }

        $('select[name="centrodecosto"]').append(htmlSelect);

      }

    });*/

  });
</script>

</body>
</html>
