<html>
<head>
	<title>Autonet | Listado de Pagos a Preparar</title>
</head>
@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
<body>
	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">PAGO A LEGALIZAR</h3>

		<form class="form-inline" id="form_buscar" action="{{url('facturacion/excel')}}" method="get">
	        <div class="col-lg-12 hidden" style="margin-bottom: 5px">
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
							<option value="0">TODOS</option>
							<option value="1" selected>NO AUTORIZADO</option>
						</select>
					</div>
	                <a proceso="2" id="buscar_pagos" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </a>
            		<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
	            </div>
	        </div>
	    </form>
	    <table id="example6" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>Proveedor</td>
	    			<td>Consecutivo</td>
	    			<td>Fecha Pago</td>
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
	    		@foreach($pagos as $pago)
	    			<tr>
	    				<td>{{$pago->razonsocial}}</td>
	    				<td>{{$pago->id}}</td>
	    				<td>{{$pago->fecha_pago}}</td>
	    				<td><?php echo '$ '. number_format($pago->total_pagado) ?></td>
	    				<td><?php echo '$ '. number_format($pago->descuento_retefuente) ?></td>
	    				<td><?php echo '$ '. number_format($pago->otros_descuentos) ?></td>
	    				<td><?php echo '$ '. number_format($pago->descuento_prestamo) ?></td>
	    				<td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;"><?php echo '$ '.number_format($pago->total_neto);  ?></p></td>
	    				<td>{{$pago->first_name}} {{$pago->last_name}}</td>
	    				<td>
	    					<a href="{{url('/facturacion/detalleap/' .$pago->id) }}" target="_blank" class="btn btn-list-table btn-primary">DETALLES</a>
	    				</td>
	    				<td>
	    					<span style="line-height: 25px; margin-right:5px; font-size: 10px" class="text-info bolder">AUTORIZAR</span><div style="display:inline-block"><input id="{{$pago->id}}" type="checkbox" class="seguridad_social"></div>
	    				</td>
	    			</tr>
	    		@endforeach
	    	</tbody>
	    	<tfoot>
	    		<tr>
	    		<tr>
	    			<td>Proveedor</td>
	    			<td>Consecutivo</td>
	    			<td>Fecha Pago</td>
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
			<div class="col-lg-12">
				<div class="row">
					@if(isset($permisos->contabilidad->listado_de_pagos_autorizar->autorizar))
						@if($permisos->contabilidad->listado_de_pagos_autorizar->autorizar==='on')
				  		<button id="autorizar_pagov2" style="margin-top: 15px; margin-bottom:10px" class="btn btn-default">AUTORIZAR</button>
						@else
						<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">AUTORIZAR</button>
                        @endif
                    @else
                        <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">AUTORIZAR</button>
                    @endif
				</div>
			</div>


	</div>

	<div id="modal-activar-reconfirmacion" class="hidden" style="opacity: 1;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Fecha de Pago<i id="cerrar_alerta" style="float: right; cursor:pointer; font-weight:100" class="fa fa-close"></i></div>
				<div class="panel-body">
					<label>Digite la fecha para la cual desea autorizar el pago</label><br>
					<div class="input-group" id="datetime_fecha" style="float: left; margin-right: 5px;">
						<div class="input-group date" id="datetimepicker10">
							<input id="fecha_pago_real" name="fecha_pago_real" style="width: 100px;" type="text" class="form-control input-font" placeholder="FECHA DE PAGO">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
						</div>
					</div>
                    @if(isset($permisos->contabilidad->listado_de_pagos_autorizar->autorizar))
                        @if($permisos->contabilidad->listado_de_pagos_autorizar->autorizar==='on')
					        <a id="autorizar_pagov2" style="float: left" class="btn btn-success btn-icon">AUTORIZAR<i class="fa fa-check icon-btn"></i></a>
                        @else
                            <a style="float: left" class="btn btn-success btn-icon disabled">AUTORIZAR<i class="fa fa-check icon-btn"></i></a>
                        @endif
                    @else
                        <a style="float: left" class="btn btn-success btn-icon disabled">AUTORIZAR<i class="fa fa-check icon-btn"></i></a>
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
<script src="{{url('jquery/facturacion.js')}}"></script>
<script type="text/javascript">

	$( document ).ready(function() {
		$('#total_pagado').html()
	});

	$('#autorizar_pagov2').click(function(e){

        var fecha_pago_real = $('#fecha_pago_real').val();
        var idArray = [];

        e.preventDefault();
        $('#example6 tbody tr').each(function(index){

            $(this).children("td").each(function (index2){
                switch (index2){
                    case 10:
                        var $objeto = $(this).find('.seguridad_social');
                        var id = $objeto.attr('id');
                        if ($objeto.is(':checked')) {
                            idArray.push($objeto.attr('id'));
                            $(this).html('<span id="'+id+'" class="bolder seguridad_social" style="margin-right:4px; font-size: 10px">AUTORIZANDO...</span><i class="fa fa-spin fa-spinner"></i>');
                        }
                    break;
                }
            });
        });

        formData = new FormData();
        formData.append('idArray',idArray);
        formData.append('fecha_pago_real',fecha_pago_real);
        if (idArray.length===0) {
            alert('No hay pagos por autorizar!');
        }else{

          $.ajax({
            type: "post",
            url: "../autorizarpago",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {

              if (data.respuesta===true) {
                for (var i in idArray) {
                  $('#example6 tbody tr').each(function(index, el) {

                    if(parseInt($(this).find('td').eq(10).find('.seguridad_social').attr('id'))===parseInt(idArray[i])){
                      $(this).find('td').eq(10).html('<span class="bolder text-success" style="margin-right:4px; font-size: 10px">AUTORIZADO</span><i class="fa fa-check list-check"></i>');

					  $(this).closest('tr').fadeOut(function(){$(this.remove())});

                    }
                  });
                }
				$('#modal-activar-reconfirmacion').addClass('hidden');
              }
            }
          });
        }

    });

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
