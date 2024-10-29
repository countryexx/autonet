<html>
<head>
	<title>Autonet | Listado de Pagos a Procesar</title>
</head>
@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		<style>
		.card {
			/* Add shadows to create the "card" effect */
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			transition: 0.3s;
		}

		/* On mouse-over, add a deeper shadow */


		/* Add some padding inside the card container */

		.card {
			box-shadow: 0 2px 8px 0 black;
			transition: 0.3s;
			border-radius: 10px; /* 5px rounded corners */
		}
		</style>
<body>
	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">LISTADO DE PAGOS POR PROCESAR - {{$lote->nombre. ' - ' .$lote->fecha}}</h3>

		<form class="form-inline" id="form_buscar" action="{{url('facturacion/excelauditar')}}" method="get">
	        <div class="col-lg-12" style="margin-bottom: 5px">
	            <div class="row">

					<input type="text" name="lote" value="{{$lote->id}}" class="hidden">


	                </a>
	                <button type="submit" title="Exportar información de pago a Proveedores" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
	            </div>
	        </div>
	    </form>
		<!--<form class="form-inline" id="form_buscar">
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

						<select data-option="1" name="proveedores" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">
							<option value="0">PROVEEDORES</option>
							@foreach($proveedores as $proveedor)
								<option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
							@endforeach
						</select>
						<span style="cursor: pointer" class="input-group-addon proveedor_eventual_pagos"><i class="fa fa-car"></i></span>
					</div>
	                <a proceso="0" id="buscar_pagos" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </a>
	            </div>
	        </div>
	    </form>-->
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
					<?php
						$total_pagado = 0;
						$descuento_retefuente = 0;
						$otros_descuentos = 0;
						$prestamos = 0;
						$total_neto = 0;
						$total_procesado = 0;
						$por_procesar = 0;
					?>
					@foreach($pagos as $pago)
						<tr>
							<td>{{$pago->razonsocial}}</td> <!-- OK -->
							<td>{{$pago->id}}</td> <!-- Ok -->
							<td>
								<center>{{$pago->fecha_pago}}</center></td> <!-- Ok -->
							<td>$ {{number_format($pago->total_pagado)}}</td>
							<td>$ {{number_format($pago->descuento_retefuente)}}</td>
							<td>$ {{number_format($pago->otros_descuentos)}}</td>
							<td>
								<?php
								if ($pago->descuento_prestamo!=0) {
									$clase = 'success';
								}else{
										$clase = 'danger';
								}
								?>
								<a style="width: 90%" data-id="{{$pago->id}}" class="btn btn-list-table btn-{{$clase}} verprestamos">$ {{number_format($pago->descuento_prestamo)}}</a>
							</td>
							<td>
								<p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">$ {{number_format($pago->total_neto)}}</p>
							</td>
							<td>{{$pago->first_name.' '.$pago->last_name}}</td>
							<td>
								<a href="{{url('facturacion/detalleap/'.$pago->id)}}" target="_blank" class="btn btn-list-table btn-primary">DETALLES</a><br>
							</td>
							<td>
									<?php
                  if($pago->seguridad_social!=null){
                      $disabled = '';
											$clase = 'success';
                  }else{
                      $disabled = 'disabled';
											$clase = 'danger';
                  }
									?>

									@if(Sentry::getUser()->id!=170)
										@if($pago->preparado!=1)
											<div style="display:inline-block"><input data-seg="{{$pago->seguridad_social}}" id="{{$pago->id}}" data-rete="{{$pago->descuento_retefuente}}" data-fechas="{{$pago->fecha_pago}}" data-dates="{{$lote->fecha}}" data-razons="{{$pago->razonsocial}}" data-valor="{{$pago->total_neto}}" type="checkbox" class="seguridad_social"> PROCESAR</div>'
											<div style="display:inline-block"><input data-seg="{{$pago->seguridad_social}}" id="{{$pago->id}}" data-rete="{{$pago->descuento_retefuente}}" data-fechas="{{$pago->fecha_pago}}" data-dates="{{$lote->fecha}}" data-razons="{{$pago->razonsocial}}" data-valor="{{$pago->total_neto}}" type="checkbox" class="cancelar"> CANCELAR</div>'
										@else
											<span class="bolder text-success" style="margin-right:4px; font-size: 10px">PROCESADO</span><i class="fa fa-check list-check"></i>
										@endif
									@endif

							</td>
						</tr>
						<?php
							$total_pagado = floatval($total_pagado)+floatval($pago->total_pagado);
							$descuento_retefuente = floatval($descuento_retefuente)+floatval($pago->descuento_retefuente);
							$otros_descuentos = floatval($otros_descuentos)+floatval($pago->otros_descuentos);
							$prestamos = floatval($prestamos)+floatval($pago->descuento_prestamo);
							$total_neto = floatval($total_neto)+floatval($pago->total_neto);
							if($pago->preparado==1){
								$total_procesado = floatval($total_procesado)+floatval($pago->total_neto);
							}else{
								$por_procesar = floatval($por_procesar)+floatval($pago->total_neto);
							}
						?>
					@endforeach
	    	</tbody>
	    	<tfoot>
	    		<tr>
	    		<tr>
	    			<td>Proveedor</td>
	    			<td>Consecutivo</td>
	    			<td style="text-align: center">Fecha de Pago Estimada </td>
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
			<a title="Ir a Revisar los Servicios Seleccionados" id="" style="padding: 8px 8px; float: right; margin-bottom: 30px" class="btn btn-danger cancelar_seleccion">Cancelar Pagos <i class="fa fa-times"></i></a>
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
										<td><span class="span-total" id="total_pagado">$ {{number_format($total_pagado)}}</span></td>
									</tr>
									<tr>
										<td>TOTAL DESCUENTO RETEFUENTE</td>
										<td><span class="span-total" id="descuento_retefuente">$ {{number_format($descuento_retefuente)}}</span></td>
									</tr>
									<tr>
										<td>OTROS DESCUENTOS</td>
										<td><span class="span-total" id="otros_descuentos">$ {{number_format($otros_descuentos)}}</span></td>
									</tr>
									<tr>
										<td>DESCUENTOS DE PRÉSTAMOS</td>
										<td><span class="span-total" id="prestamos_valores">$ {{number_format($prestamos)}}</span></td>
									</tr>
									<tr>
										<td>TOTAL NETO A PAGAR</td>
										<td><span class="span-total" id="total_neto">$ {{number_format($total_neto)}}</span></td>
									</tr>
								</tbody>
							</table>
					  </div>
					</div>
				</div>
			</div>

			<div class="col-lg-3" style="margin-left: 30px">
				<div class="row">
					<div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px">
					  <div class="panel-heading">
					    <strong>PROCESADO</strong>
					  </div>
					  <div class="panel-body">
							<table style="margin-bottom: 0px;" class="table table-bordered">
								<tbody>

									<tr>
										<td>TOTAL PROCESADO</td>
										<td><span class="span-total" id="total_neto">$ {{number_format($total_procesado)}}</span></td>
									</tr>
									<tr>
										<td>PENDIENTE POR PROCESAR</td>
										<td><span class="span-total" id="total_neto">$ {{number_format($por_procesar)}}</span></td>
									</tr>
								</tbody>
							</table>
					  </div>
					</div>
				</div>
			</div>

			<div class="col-lg-12">
				<!--<div class="row">
                    @if(isset($permisos->contabilidad->listado_de_pagos_preparar->preparar))
                        @if($permisos->contabilidad->listado_de_pagos_preparar->preparar==='on')
						    <button id="preparar" style="margin-top: 15px; margin-bottom:10px" class="btn btn-default">PROCESAR</button>
                        @else
                            <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">PROCESAR</button>
                        @endif
                    @else
                        <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">PROCESAR</button>
                    @endif
				</div>-->
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
                        <a id="preparar_pago" style="float: left" class="btn btn-success btn-icon">PROCESAR<i class="fa fa-check icon-btn"></i></a>
                    @else
                        <a style="float: left" class="btn btn-success btn-icon">PROCESAR<i class="fa fa-check icon-btn"></i></a>
                    @endif
                @else
                    <a style="float: left" class="btn btn-success btn-icon">PROCESAR<i class="fa fa-check icon-btn"></i></a>
                @endif

                </div>
            </div>
        </div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id='modal_vista'>
    <div class="modal-dialog modal-md" role="document" style="height: 100%;">
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

	<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_details'>
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
						<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Detalles del pago a Procesar</b></h4>
					</div>
					<div class="modal-body">

						<div class="card">
							<span style='font-size:30px;'>&#128201;</span>
            	<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="retefuente_descontado"></b></h5>
        		</div>

						<div class="card">
							<span style='font-size:30px;'>&#128180;</span>
							<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="prestamos_pendientes"></b></h5>
						</div>

					<div class="card">
						<span style='font-size:30px;'>&#128181;</span>
						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="ingreso_de_factura"></b></h5>
					</div>

					<div class="card">
						<span class="nott hidden" style='font-size:30px;'>&#128275;</span>
						<span class="yess hidden" style='font-size:30px;'>&#128274;</span><span style="line-height: 25px; margin-right:5px; font-size: 10px; margin-bottom: 20px; margin-left: 10px" class="text-info bolder text_ss hidden"><a target="_blank" class="btn btn-list-table btn-success boton_ss">Ver Seguridad Social</a></span>
						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="seguridadsoc"></b></h5>
					</div>

					<hr>

					<div class="card">
						<span class="nott hidden" style='font-size:30px;'>&#128185;</span>

						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: #66BB6A; margin-left: 8px; margin-bottom: 10px;"><b id="beneficiario_t"></b></h5>

						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="beneficiario"></b></h5>
						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="numero_cuenta"></b></h5>
						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="tipo_cuenta"></b></h5>
						<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="banco"></b></h5>

						<a style="margin-bottom: 20px; margin-left: 8px; width: 110px" target="_blank" class="btn btn-list-table btn-primary certis">Ver Certificación</a><br>

						<a style="margin-bottom: 20px; margin-left: 8px; width: 110px" target="_blank" class="btn btn-list-table btn-warning pod">Ver Poder</a><br>

					</div>

						</div>
						<div class="modal-footer">
							<div class="col-lg-3">
								<div class='input-group'>
									<label class="h5 text-center mt-3 mb-4 pb-3">Comentarios</label>
									<input class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="Ingresa un comentario" id="comentario"></input>
								</div>
							</div>
							<div class="col-lg-3">
								<label class="h5 text-left mt-3 mb-4 pb-3">Fecha Estimada para el Pago</label>
	              <div class='input-group date' id='datetime_fecha'>
	                  <input id="fechas_p" name="fecha_pago" style="width: 100%;" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
	                  <span class="input-group-addon">
	                      <span class="fa fa-calendar">
	                      </span>
	                  </span>
	              </div>
							</div>

							<!--<a style="margin-top: 40px" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>-->

							<a style="margin-top: 40px" lote-id="{{$lote->id}}" id="procesar_pago" class="btn btn-success btn-icon">PROCESAR<i class="fa fa-check icon-btn"></i></a>

							<center>
								<span id="invoices"></span>
							</center>

						</div>
					</div>
			</div>
		</div>

		<!-- Modal otro lote -->
		<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_otro_lote'>
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title" style="text-align: center;" id="name"><b id="titless" class="parpadea">Cambiar el pago de lote</b></h4>
						</div>
						<div class="modal-body">


								<div class="row">
									<div class="col-md-4 col-lg-push-1">
										<!--<a class="btn btn-success lote_nuevo" role="button">LOTE NUEVO </a>-->
										<!--<a style="margin-left: 100px" class="btn btn-danger lote_existente" role="button" >LOTE EXISTENTE </a>-->
									</div>
								</div>
								<div class="row form_lote_existente hidden">

								</div>

								<div class="row form_lote_nuevo">
									<div class="col-md-3">
										<label for="">Fecha del lote</label>
										<div class="input-group date datetime_fecha" style="width: 100%;">
											<input disabled placeholder="Fecha de Ingreso" id="fecha_nuevo_lote" style="width: 100%; " type="text" class="form-control input-font">
											<span class="input-group-addon">
												<span class="fa fa-calendar">
												</span>
											</span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="">Nombre del Lote</label>
										<input placeholder="DIGITE NOMBRE" id="valor_nombre_lote" class="form-control input-font" name="pagado">
									</div>
								</div>

						</div>
							<div class="modal-footer">
								<h5 class="h6 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="nombre_proveedor_pago"></b></h5>
								<h5 class="h6 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="valor_proveedor_pago"></b></h5>
								<a id="procesar_pago_nuevo_lote" class="btn btn-success btn-icon">PROCESAR<i class="fa fa-check icon-btn"></i></a>
							</div>
						</div>
				</div>
			</div>
			<!-- Modal otro lote -->
	</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script type="text/javascript">

	$('.lote_nuevo').click(function() {
		$(this).attr('class','btn btn-success lote_nuevo');
		$('.lote_existente').attr('class','btn btn-danger lote_existente');
		$('.form_lote_nuevo').removeClass('hidden');
		$('.form_lote_existente').addClass('hidden');
	})

	$('.lote_existente').click(function() {
		$(this).attr('class','btn btn-success lote_existente');
		$('.lote_nuevo').attr('class','btn btn-danger lote_nuevo');

		$('.form_lote_nuevo').addClass('hidden');
		$('.form_lote_existente').removeClass('hidden');
	})
	window.onload=function(){
		var pos=window.name || 0;
		window.scrollTo(0,pos);
	}

	window.onunload=function(){
		window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
	}

	$('#example6').on('click', '.seguridad_social', function (e) {

		e.preventDefault();
    var valor_retefuente = $(this).attr('data-rete');
    var id = $(this).attr('id');
    var href = $(this).attr('data-seg');
    var fechas = $(this).attr('data-fechas');
		var dates = $(this).attr('data-dates'); //Fecha del lote
    //alert(fechas)
    $('#fechas_p').val(fechas);

    $('#procesar_pago').attr('data-razons',$(this).attr('data-razons'));
		$('#procesar_pago').attr('data-valor',$(this).attr('data-valor'));
		$('#procesar_pago').attr('data-id-pago',id);

    if(valor_retefuente>0){
        $('.retefuente_descontado').html('El total descontado en retefuente en este pago es: $ '+number_format(valor_retefuente)+'<br><br>')
    }else{
        $('.retefuente_descontado').html('Este pago no tiene descuento de Retefuente.<br><br>')
    }

    var prestamos_pen = '';
    var sin_ingreso = '';

    //start
    $.ajax({
      url: '../consultaspago',
      method: 'post',
      data: {id: id}
    }).done(function(data){

      if(data.response==true){

        if(data.totalPrestamos>0){

            $('.prestamos_pendientes').html('');
            //if()
            prestamos_pen += 'Este proveedor tienes préstamos sin descontar <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br>';

            for (var o in data.prestamos){
                prestamos_pen += 'Consecutivo N° '+data.prestamos[o].id+', por valor: $ '+number_format(data.prestamos[o].valor_prestado)+'<br>';
            }

            $('.prestamos_pendientes').html(prestamos_pen+'<br>')

        }else{

            $('.prestamos_pendientes').html('');

            prestamos_pen += 'Este proveedor NO tiene prestamos pendientes. <i class="fa fa-check-square" aria-hidden="true"></i><br><br>';
            $('.prestamos_pendientes').html(prestamos_pen)

        }

        $('.ingreso_de_factura').html('');
        if(data.totalFacturas>0){

            sin_ingreso += 'Este pago tiene facturas sin ingreso <i class="fa fa-arrow-down" aria-hidden="true"></i><br><br>';
            for (var o in data.query){

                sin_ingreso += 'Factura N° <a target="_blank" href="https://app.aotour.com.co/autonet/facturacion/verorden/'+data.query[o].id+'">'+data.query[o].numero_factura+'</a>, por valor: $ '+number_format(data.query[o].total_facturado_cliente)+'<br>';
            }

            $('.ingreso_de_factura').html(sin_ingreso+'<br>');

        }else{
            sin_ingreso += 'Todas la facturas de este pago tienen ingreso! <i class="fa fa-check-square" aria-hidden="true"></i><br><br>';
            $('.ingreso_de_factura').html(sin_ingreso);
        }

        var segg = '';
				//alert(href)
        if(href===null || href==='') {
            segg += '<b style="color: red">Este pago NO cuenta con seguridad social</b><br> ¿Deseas procesar este pago sin este documento? <br> Recuerda que es obligatoria para el proceso de pago...<br><br>';
						$('.boton_ss').attr('href',urlss)
						$('.text_ss').attr('href',urlss)
						$('.nott').removeClass('hidden')
						$('.yess').addClass('hidden')
            $('.seguridadsoc').html(segg);
        }else{
            segg += '<h4>¡¡¡Este Pago cuenta con seguridad social!!! <i class="fa fa-check-square" aria-hidden="true"></i></h4><br>';
						var urlss = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/sss/cuentas/'+data.pago.seguridad_social;
						$('.boton_ss').attr('href',urlss)
						$('.text_ss').removeClass('hidden')
						$('.nott').addClass('hidden')
						$('.yess').removeClass('hidden')
            $('.seguridadsoc').html(segg);
        }

				//Datos bancarios
				if(data.pago.poder_t!=null){
					var text = 'PAGO A UN TERCERO'
					var razon = data.pago.razonsocial_t;
					var numero = data.pago.numero_cuenta_t;
					var tipo = data.pago.tipo_cuenta_t;
					var banco = data.pago.entidad_bancaria_t;
					var certificacion = data.pago.certificacion_bancaria_t;
					var poder = data.pago.poder_t;
					var urlPoder = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/proveedores/documentos/poderes/'+poder;
					$('.pod').removeClass('hidden').attr('href',urlPoder)
				}else{
					var text = 'PAGO AL PROVEEDOR'
					var razon = data.pago.razonsocial;
					var numero = data.pago.numero_cuenta;
					var tipo = data.pago.tipo_cuenta;
					var banco = data.pago.entidad_bancaria;
					var certificacion = data.pago.certificacion_bancaria;
					$('.pod').addClass('hidden').removeAttr('href')
				}

				var url = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/proveedores/documentos/certificacion/'+certificacion;

				$('#beneficiario_t').html(text)
				$('#beneficiario').html('Beneficiario: '+razon)
				$('#numero_cuenta').html('Número de cuenta: '+numero)
				$('#tipo_cuenta').html('Tipo de cuenta: '+tipo)
				$('#banco').html('Entidad Bancaria: '+banco)
				$('.certis').attr('href',url)

				$('#procesar_pago').attr('data-date',dates)

      }else if(data.response==false){

      }

    });
    //end

    $('#modal_details').modal('show');

  });

	$('#procesar_pago').click(function(){

    var id = $(this).attr('data-id-pago');
    var fecha_preparacion = $('#fechas_p').val();
		var comentario = $('#comentario').val();
		var lote = $(this).attr('lote-id');
		var razons = $(this).attr('data-razons');
		var valor_pago = $(this).attr('data-valor');

		var nueva_fecha = $(this).attr('data-date')

		//alert(nueva_fecha);

		//
		$.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de procesar este pago?',
          buttons: {
              confirm: {
                  text: '¡Si!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

										if(1>0) {

											$.ajax({
									          url: '../buscarlotes',
									          method: 'post',
									          data: {fecha: fecha_preparacion, lote: lote}
									        }).done(function(data){

									          if(data.respuesta==true){

															$.confirm({
												          title: 'Atención',
												          content: 'Existe un lote para la fecha seleccionada...<br><br> ¿Deseas añadir este pago al lote  '+data.lote.nombre+'?',
												          buttons: {
												              confirm: {
												                  text: 'Si',
												                  btnClass: 'btn-success',
												                  keys: ['enter', 'shift'],
												                  action: function(){

																						$.confirm({
																			          title: 'Atención',
																			          content: 'Estás seguro de añadir este pago al lote  '+data.lote.nombre+'?',
																			          buttons: {
																			              confirm: {
																			                  text: 'Si',
																			                  btnClass: 'btn-danger',
																			                  keys: ['enter', 'shift'],
																			                  action: function(){

																													$.ajax({
																									          url: '../cambiardeloteexistente',
																									          method: 'post',
																									          data: {id: id, fecha: fecha_preparacion, id_lote: data.lote.id}
																									        }).done(function(data){

																									          if(data.respuesta==true){

																															$.confirm({
																																	title: '¡Realizado!',
																																	content: 'El pago fue movido al lote '+data.nombre+' exitosamente!',
																																	buttons: {
																																			confirm: {
																																					text: 'Cerrar',
																																					btnClass: 'btn-danger',
																																					keys: ['enter', 'shift'],
																																					action: function(){
																																						location.reload();
																																					}

																																			}
																																	}
																															});

																														}

																													});

																			                  }

																			              },
																		                cancel: {
																		                  text: 'Cancelar',
																		                }
																			          }
																			      });

												                  }

												              },
											                cancel: {
											                  text: 'No',
											                  action: function(){

											                  		if(comentario==''){
																			comentario = null;
																		}

																    formData = new FormData();
																    formData.append('idArray',id);
																    formData.append('fecha_preparacion',fecha_preparacion);
																		formData.append('comentario',comentario);
																		formData.append('lote',lote);

																    $.ajax({
																        type: "post",
																        url: "../procesarpago",
																        data: formData,
																        processData: false,
																        contentType: false,
																        success: function(data) {

																          if (data.respuesta===true) {

																            alert('¡Pago procesado!');
																						location.reload();

																          }else if(data.respuesta==='completo'){

																						$.confirm({
																				        title: 'Realizado!',
																				        content: 'Has procesado todos los pagos de este lote.<br><br> Serás redirigido a la ventada de lotes por Aprobar al presionar OK.',
																				        buttons: {
																				            confirm: {
																				                text: 'OK',
																				                btnClass: 'btn-danger',
																				                keys: ['enter', 'shift'],
																				                action: function(){

																													location.href = "../lotesporaprobar";

																				                }

																				            }
																				        }
																				    });

																					}else{
																            alert('No hubo cambios!');
																          }

																        }
																    });

											                  }
											                }
												          }
												      });

									          }else if(data.respuesta==false){

															$.confirm({
												          title: 'Atención',
												          content: 'La fecha del pago no coincide con la del lote<br><br> <b>No hay ningún lote para esta fecha</b><br><br> Deseas añadir este pago a un nuevo lote?',
												          buttons: {
												              confirm: {
												                  text: 'Si',
												                  btnClass: 'btn-success',
												                  keys: ['enter', 'shift'],
												                  action: function(){

																						$('#modal_details').modal('hide');
																						$('#fecha_nuevo_lote').val(fecha_preparacion);
																						$('#procesar_pago_nuevo_lote').attr('pago-id',id);
																						$('#procesar_pago_nuevo_lote').attr('data-fecha',fecha_preparacion);
																						$('#titless').html('Cambiar el pago N° '+id+' de lote')
																						$('#nombre_proveedor_pago').html('Provedor: '+razons)
																						$('#valor_proveedor_pago').html('Valor: $ '+number_format(valor_pago))
																						$('#modal_otro_lote').modal('show');

												                  }

												              },
											                cancel: {
											                  text: 'Cancelar',
											                }
												          }
												      });
									          }

									        });

										}else{

											if(comentario==''){
												comentario = null;
											}

									    formData = new FormData();
									    formData.append('idArray',id);
									    formData.append('fecha_preparacion',fecha_preparacion);
											formData.append('comentario',comentario);
											formData.append('lote',lote);

									    $.ajax({
									        type: "post",
									        url: "../procesarpago",
									        data: formData,
									        processData: false,
									        contentType: false,
									        success: function(data) {

									          if (data.respuesta===true) {

									            alert('¡Pago procesado!');
															location.reload();

									          }else if(data.respuesta==='completo'){

															$.confirm({
													        title: 'Realizado!',
													        content: 'Has procesado todos los pagos de este lote.<br><br> Serás redirigido a la ventada de lotes por Aprobar al presionar OK.',
													        buttons: {
													            confirm: {
													                text: 'OK',
													                btnClass: 'btn-danger',
													                keys: ['enter', 'shift'],
													                action: function(){

																						location.href = "../lotesporaprobar";

													                }

													            }
													        }
													    });

														}else{
									            alert('No hubo cambios!');
									          }

									        }
									    });
										}

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }
      });

  });

	$('#procesar_pago_nuevo_lote').click(function(){

		var id = $(this).attr('pago-id');
		var fecha = $(this).attr('data-fecha');
		var nombre = $('#valor_nombre_lote').val().toUpperCase();

		if( nombre==='') {

			$.confirm({
					title: 'Atención!',
					content: 'El nombre del lote es obligatorio.',
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

			//start
	    $.ajax({
	      url: '../cambiardelote',
	      method: 'post',
	      data: {id: id, fecha: fecha, nombre: nombre}
	    }).done(function(data){

	      if(data.respuesta==true){

					$.confirm({
							title: '¡Realizado!',
							content: 'El pago fue movido al lote '+nombre+' exitosamente!',
							buttons: {
									confirm: {
											text: 'Cerrar',
											btnClass: 'btn-danger',
											keys: ['enter', 'shift'],
											action: function(){
												location.reload();
											}

									}
							}
					});

	      }else if(data.respuesta=='eliminar'){

					$.confirm({
							title: '¡Realizado!',
							content: 'El lote <b>'+data.nombre+'</b> quedó sin pagos y valor total de $0.<br><br>¿Quieres <b>eliminarlo</b>?',
							buttons: {
									confirm: {
											text: 'Eliminar!',
											btnClass: 'btn-danger',
											keys: ['enter', 'shift'],
											action: function(){

												$.ajax({
													url: '../eliminarlote',
													method: 'post',
													data: {id: data.lote, nombre: data.nombre}
												}).done(function(data){

													if(data.respuesta==true){

														$.confirm({
																title: '¡Realizado!',
																content: 'El lote <b>'+data.nombre+'</b> fue eliminado exitosamente!<br><br>Serás redirigido a lista de <b>Lotes por Aprobar</b>',
																buttons: {
																		confirm: {
																				text: 'Cerrar',
																				btnClass: 'btn-danger',
																				keys: ['enter', 'shift'],
																				action: function(){
																					location.href = "../../facturacion/lotesporaprobar";
																				}

																		}
																}
														});

													}

												});

											}

									},
									cancel: {
										text: 'Conservarlo',
										btnClass: 'btn-success',
									}
							}
					});

	      }

	    });

		}
		console.log(id);
		console.log(fecha);
		console.log(nombre);

	});

	$('.cancelar_seleccion').click(function(){

		var idArray = [];

		$('#example6 tbody tr').each(function(index){

      $(this).children("td").each(function (index2){
          switch (index2){
              case 10:
                  var $objeto = $(this).find('.cancelar');

                  if ($objeto.is(':checked')) {
                      idArray.push($objeto.attr('id'));
                      //dt += $objeto.attr('data-id')+',';
                  }

              break;
          }
      });

    });

		$.confirm({
				title: 'Atención',
				content: 'Estás seguro de cancelar los pagos seleccionados?',
				buttons: {
						confirm: {
								text: 'Si',
								btnClass: 'btn-danger',
								keys: ['enter', 'shift'],
								action: function(){

									$.ajax({
										url: '../cancelarpagos',
										method: 'post',
										data: {idArray: idArray}
									}).done(function(data){

										if(data.respuesta==true){

											$.confirm({
													title: '¡Realizado!',
													content: 'Se han cancelado '+data.i+' pagos de este lote!',
													buttons: {
															confirm: {
																	text: 'Cerrar',
																	btnClass: 'btn-danger',
																	keys: ['enter', 'shift'],
																	action: function(){
																		location.reload();
																	}

															}
													}
											});

										}

									});

								}

						},
						cancel: {
							text: 'Cancelar',
						}
				}
		});

		console.log(idArray)

	})

</script>
</body>
</html>
