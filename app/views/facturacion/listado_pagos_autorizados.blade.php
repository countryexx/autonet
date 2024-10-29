<html>
<head>
	<title>Autonet | Listado de Pagos Autorizados</title>
</head>
@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		<style >
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
		<h3 class="h_titulo">LISTADO DE PAGOS POR APROBAR - {{$lote->nombre. ' - ' .$lote->fecha}}</h3>
		<input id="sw" type="text" name="" value="{{$lote->id}}" class="hidden">

		<!--<form class="form-inline" id="form_buscar" action="{{url('facturacion/excel')}}" method="get">
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

	                <a proceso="2" id="buscar_pagos" class="btn btn-default btn-icon">
	                    Buscar<i class="fa fa-search icon-btn"></i>
	                </a>
            		<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
	            </div>
	        </div>
	    </form>-->
	    <table id="example69" class="table table-bordered hover tabla" cellspacing="0" width="100%">
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
					?>
					@foreach($pagos as $pago)
						<tr>
							<td>{{$pago->razonsocial}}</td> <!-- OK -->
							<td>{{$pago->id}}</td> <!-- Ok -->
							<td>
								<center>{{$pago->fecha_preparacion}}</center></td> <!-- Ok -->
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
								<a href="{{url('facturacion/detalleap/'.$pago->id)}}" target="_blank" class="btn btn-list-table btn-primary">DETALLES</a> <a data-seg="{{$pago->seguridad_social}}" id="{{$pago->id}}" data-rete="{{$pago->descuento_retefuente}}" data-fechas="{{$pago->fecha_pago}}" data-dates="{{$lote->fecha}}" data-razons="{{$pago->razonsocial}}" data-valor="{{$pago->total_neto}}" type="checkbox" class="btn btn-list-table btn-default seguridad_social22"><i class="fa fa-eye" aria-hidden="true"></i></a><br>
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

									@if($pago->autorizado!=1)

                    <i style="color: gray; font-size: 16px;" class="fa fa-square" aria-hidden="true"></i> <i style="color: #2874A6; font-size: 22px; margin-left: 5px; margin-right: 8px" class="fa fa-square" aria-hidden="true"></i> <span style="line-height: 25px; margin-right:5px; font-size: 10px" class="text-info bolder">APROBAR</span>
										<div style="display:inline-block"><input id="{{$pago->id}}" data-rete="{{$pago->descuento_retefuente}}" data-fechas="{{$pago->fecha_pago}}" type="checkbox" class="seguridad_social"></div>'

                  @elseif($pago->autorizado==1)

                    <i style="color: gray; font-size: 16px;" class="fa fa-square" aria-hidden="true"></i> <i style="color: #2874A6; font-size: 22px; margin-left: 5px" class="fa fa-square" aria-hidden="true"></i> <i style="color: #1B5E20; font-size: 31px; margin-left: 5px; padding-right: 8px" class="fa fa-square" aria-hidden="true"></i>;

                  @endif

							</td>
							<td>

								<?php

									$mess = date('m');
									$ano = date('Y');
									$dia = date('d');

									if($mess==1){
										$end = '31';
									}else if($mess==2){
										$end = '28';
									}else if($mess==3){
										$end = '31';
									}else if($mess==4){
										$end = '30';
									}else if($mess==5){
										$end = '31';
									}else if($mess==6){
										$end = '30';
									}else if($mess==7){
										$end = '31';
									}else if($mess==8){
										$end = '31';
									}else if($mess==9){
										$end = '30';
									}else if($mess==10){
										$end = '31';
									}else if($mess==11){
										$end = '30';
									}else if($mess==12){
										$end = '31';
									}

									$fechaInicial = $ano.$mess.'01';
									$fechaInicial = strtotime ('-3 month', strtotime($fechaInicial));
      						$fechaInicial = date('Y-m-d' , $fechaInicial);

									$fechaFinal = $ano.$mess.$end;
									$fechaFinal = strtotime ('-1 month', strtotime($fechaFinal));
      						$fechaFinal = date('Y-m-d' , $fechaFinal);

									$select2 = "SELECT DISTINCT ordenes_facturacion.id, ordenes_facturacion.numero_factura, ordenes_facturacion.fecha_inicial, ordenes_facturacion.fecha_final, ordenes_facturacion.total_facturado_cliente, ordenes_facturacion.ingreso, pago_proveedores.id as id_ap, pagos.id as id_pago, centrosdecosto.razonsocial FROM ordenes_facturacion LEFT JOIN facturacion ON facturacion.factura_id =  ordenes_facturacion.id LEFT JOIN servicios ON servicios.id = facturacion.servicio_id LEFT JOIN pago_proveedores ON pago_proveedores.id = facturacion.pago_proveedor_id LEFT JOIN pagos ON pagos.id = pago_proveedores.id_pago LEFT JOIN centrosdecosto ON centrosdecosto.id = ordenes_facturacion.centrodecosto_id WHERE ordenes_facturacion.ingreso IS NULL and pago_proveedores.id is not NULL AND servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND pagos.id = ".$pago->id."";

									$query2 = DB::select($select2);

?>
									@if( count($query2)>0 )

										<div class="col-lg-3">
											<div class="estado_servicio_app sin_ingresos" data-id="{{$pago->id}}" style="background: #E53935; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 22px; border-radius: 2px;">
												<center><a target="_blank" style="color: white;"><i style="color: white; font-size: 12px" class="fa fa-usd" aria-hidden="true"></i></a></center>

											</div>
										</div>

									@endif

								<?php

									$mess = date('m');
									$ano = date('Y');
									$dia = date('d');

									if($mess==1){
										$end = '31';
									}else if($mess==2){
										$end = '28';
									}else if($mess==3){
										$end = '31';
									}else if($mess==4){
										$end = '30';
									}else if($mess==5){
										$end = '31';
									}else if($mess==6){
										$end = '30';
									}else if($mess==7){
										$end = '31';
									}else if($mess==8){
										$end = '31';
									}else if($mess==9){
										$end = '30';
									}else if($mess==10){
										$end = '31';
									}else if($mess==11){
										$end = '30';
									}else if($mess==12){
										$end = '31';
									}

									$fechaInicial = $ano.$mess.'01';
									$fechaInicial = strtotime ('-3 month', strtotime($fechaInicial));
      						$fechaInicial = date('Y-m-d' , $fechaInicial);

									$fechaFinal = $ano.$mess.$end;
									$fechaFinal = strtotime ('-1 month', strtotime($fechaFinal));
      						$fechaFinal = date('Y-m-d' , $fechaFinal);

									$select = "SELECT DISTINCT ordenes_facturacion.id, ordenes_facturacion.numero_factura, pago_proveedores.id as id_ap, pagos.id as id_pago FROM ordenes_facturacion LEFT JOIN facturacion ON facturacion.factura_id =  ordenes_facturacion.id LEFT JOIN servicios ON servicios.id = facturacion.servicio_id LEFT JOIN pago_proveedores ON pago_proveedores.id = facturacion.pago_proveedor_id LEFT JOIN pagos ON pagos.id = pago_proveedores.id_pago LEFT JOIN centrosdecosto ON centrosdecosto.id = ordenes_facturacion.centrodecosto_id WHERE servicios.centrodecosto_id = 100 AND servicios.fecha_servicio BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' AND pagos.id = ".$pago->id."";

									$query = DB::select($select);

									if( count($query)>0 ) {
									?>
									<div class="col-lg-3">
										<div class="estado_servicio_app persona_nat" data-id="{{$pago->id}}" style="background: green; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 22px; border-radius: 2px;">
											<center><a target="_blank" style="color: white;"><i style="color: white; font-size: 12px" class="fa fa-male" aria-hidden="true"></i></a></center>

										</div>
									</div>

									<?php
									}
									?>


								@if( $pago->comentario!=null and $pago->comentario!='NULL' )
									<div class="col-lg-3">
										<div class="estado_servicio_app comenta" data-id="{{$pago->id}}" data-comentario="{{$pago->comentario}}" style="background: #F6A036; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 22px; border-radius: 2px;">
											<a target="_blank" style="color: white;"><i style="color: white; font-size: 12px" class="fa fa-commenting-o" aria-hidden="true"></i></a>
											<!--@foreach($query2 as $que2)
												<a target="_blank" href="{{url('facturacion/verdetalle/'.$que2->id)}}" style="color: white;">{{$que2->numero_factura}}</a>
											@endforeach-->
										</div>
									</div>
								@endif
							</td>
						</tr>
						<?php
							$total_pagado = floatval($total_pagado)+floatval($pago->total_pagado);
							$descuento_retefuente = floatval($descuento_retefuente)+floatval($pago->descuento_retefuente);
							$otros_descuentos = floatval($otros_descuentos)+floatval($pago->otros_descuentos);
							$prestamos = floatval($prestamos)+floatval($pago->descuento_prestamo);
							$total_neto = floatval($total_neto)+floatval($pago->total_neto);
						?>
					@endforeach
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
						<td></td>
	    		</tr>
	    	</tfoot>
	    </table>
			<div class="col-lg-3">
				<div class="row">
					<div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px">
					  <div class="panel-heading">
					    <strong>TOTALES</strong>
					    @if($lote->estado!=3)
								<input style="width: 15px; height: 15px; float: right; margin-left: 10px" type="checkbox" class="select_all_pagos">
					    	<label style="float: right;">Seleccionar todos</label>
							@endif
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
										<td>TOTAL NETO</td>
										<td><span class="span-total" id="total_neto">$ {{number_format($total_neto)}}</span></td>
									</tr>
								</tbody>
							</table>
					  </div>
					</div>
				</div>
			</div>

			<div class="col-lg-12">
				<div class="row">
					@if(isset($permisos->contabilidad->listado_de_pagos_autorizar->autorizar))
						@if($permisos->contabilidad->listado_de_pagos_autorizar->autorizar==='on')
							@if($lote->estado!=3)
				  			<button lote-id="{{$lote->id}}" id="btn_autorizar_pago" style="margin-top: 15px; margin-bottom:10px" class="btn btn-default">APROBAR</button>
							@endif
						@else
						<button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">APROBAR</button>
                        @endif
                    @else
                        <button style="margin-top: 15px; margin-bottom:10px" class="btn btn-default disabled">APROBAR</button>
                    @endif
				</div>
			</div>


	</div>

	<!-- Modal otro lote -->
	<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_otro_lote'>
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
						<h4 class="modal-title" style="text-align: center;" id="name"><b id="titless" class="parpadea">Añadir nuevo lote</b></h4>
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
								<!--<div class="col-md-3">
									<label for="">Fecha tentativa</label>
									<div class="input-group date datetime_fecha" style="width: 100%;">
										<input disabled placeholder="Fecha de Ingreso" id="fecha_nuevo_lote" style="width: 100%; " type="text" class="form-control input-font">
										<span class="input-group-addon">
											<span class="fa fa-calendar">
											</span>
										</span>
									</div>
								</div>-->
								<div class="col-md-6">
									<label for="">Nombre del Lote</label>
									<input placeholder="DIGITE NOMBRE" id="valor_nombre_lote" class="form-control input-font" name="pagado">
								</div>
							</div>

					</div>
						<div class="modal-footer">
							<!--<h5 class="h6 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="nombre_proveedor_pago"></b></h5>
							<h5 class="h6 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="valor_proveedor_pago"></b></h5>-->
							<a id="procesar_pago_nuevo_lote" class="btn btn-success btn-icon">AÑADIR<i class="fa fa-plus icon-btn"></i></a>
						</div>
					</div>
			</div>
		</div>
		<!-- Modal otro lote -->

	<div id="modal-activar-reconfirmacion" class="hidden" style="opacity: 1;">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Fecha de Pago<i id="cerrar_alerta" style="float: right; cursor:pointer; font-weight:100" class="fa fa-close"></i></div>
				<div class="panel-body">
					<label>Digite la fecha para la cual desea Aprobar el pago</label><br>
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
													@if($lote->estado!=3)
			        							<a lote-id="{{$lote->id}}" id="autorizar_pago" style="float: left" class="btn btn-success btn-icon">APROBAR<i class="fa fa-check icon-btn"></i></a>
													@endif
                        @else
                          <a style="float: left" class="btn btn-success btn-icon disabled">APROBAR<i class="fa fa-check icon-btn"></i></a>
                        @endif
                    @else
                        <a style="float: left" class="btn btn-success btn-icon disabled">APROBAR<i class="fa fa-check icon-btn"></i></a>
                    @endif
				</div>
			</div>
		</div>
	</div>

	<!-- -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_vista'>
          <div class="modal-dialog modal-md" role="document" style="height: 80%;">
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

		<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_ingresos'>
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
						<div class="modal-header" style="background: #E53935">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title" style="text-align: center;" id="name"><b id="titulo_modal" class="parpadea">Facturas sin ingreso del pago </b></h4>
						</div>
						<div class="modal-body">



								<table class="table table-bordered table-hover" id="tabla_facturas">
										<thead>
										<tr>
											<th>#</th>
											<th>Factura</th>
											<th>Cliente</th>
											<th>Fecha Inicial</th>
											<th>Fecha Final</th>
											<th>Valor</th>
											<th>Ciudad</th>
											<th style="text-align: center">Ver</th>
											<th style="text-align: center">Ver</th>
										</tr>
										</thead>
										<tbody>

										</tbody>
								</table>



						</div>
							<div class="modal-footer">

							</div>
						</div>
				</div>
			</div>

			<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_natural'>
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
							<div class="modal-header" style="background: green">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title" style="text-align: center;" id="name"><b id="titulo_modal2" class="parpadea">Facturas sin ingreso del pago </b></h4>
							</div>
							<div class="modal-body">



								<table class="table table-bordered table-hover" id="tabla_natural">
										<thead>
										<tr>
											<th>#</th>
											<th>Factura</th>
											<th>Cliente</th>
											<th>Fecha Inicial</th>
											<th>Fecha Final</th>
											<th>Valor</th>
											<th>Ciudad</th>
											<th style="text-align: center">Ver</th>
											<th style="text-align: center">Ver</th>
										</tr>
										</thead>
										<tbody>

										</tbody>
								</table>



						</div>
							<div class="modal-footer">

							</div>
						</div>
				</div>
			</div>

			<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_comentario'>
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
							<div class="modal-header" style="background: #F6A036">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title" style="text-align: center;" id="name"><b id="titulo_modal3" class="parpadea"></b></h4>
							</div>
							<div class="modal-body">

								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><center><b id="comentaa"></b></center></h5>

							</div>
							<div class="modal-footer">

							</div>
						</div>
				</div>
			</div>

			<div class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" id='modal_details'>
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Detalles del pago a Aprobar</b></h4>
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

							<div class="card hidden">
								<span style='font-size:30px;'>&#128181;</span>
								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="ingreso_de_factura"></b></h5>
							</div>

							<div class="card">
								<span class="nott hidden" style='font-size:30px;'>&#128275;</span>
								<span class="yess hidden" style='font-size:30px;'>&#128274;</span><span style="line-height: 25px; margin-right:5px; font-size: 10px; margin-bottom: 20px; margin-left: 10px" class="text-info bolder text_ss hidden"><a target="_blank" style="width: 130px" class="btn btn-list-table btn-success boton_ss">Ver Seguridad Social</a></span>
								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b class="seguridadsoc"></b></h5>
							</div>

							<hr>

							<div class="card">
								<span class="nott hidden" style='font-size:30px;'>&#128185;</span>

								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: #66BB6A; margin-left: 8px; margin-bottom: 10px; margin-top: 12px"><b id="beneficiario_t"></b></h5>

								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="beneficiario"></b></h5>
								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="numero_cuenta"></b></h5>
								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="tipo_cuenta"></b></h5>
								<h5 class="h4 text-left mt-3 mb-4 pb-3" style="color: gray; margin-left: 8px; margin-bottom: 10px;"><b id="banco"></b></h5>

								<a style="margin-bottom: 20px; margin-left: 8px; width: 110px" target="_blank" class="btn btn-list-table btn-primary certis">Ver Certificación</a><br>

								<a style="margin-bottom: 20px; margin-left: 8px; width: 110px" target="_blank" class="btn btn-list-table btn-warning pod">Ver Poder</a><br>

							</div>

								</div>
								<div class="modal-footer">




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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		var id = $('#sw').val();

		$.ajax({
			url: '../consultarestado',
			method: 'post',
			data: {id: id}
		}).done(function(data){

			if(data.respuesta==true){

				if(data.cantidad>1){
					var data1 = 'pagos';
					var data2 = 'pendientes';
					var data3 = 'añadirlos';
				}else{
					var data1 = 'pago';
					var data2 = 'pendiente';
					var data3 = 'añadirlo';
				}

				$.confirm({
						title: 'Atención',
						content: 'Este Lote tiene <b>'+data.cantidad+'</b> '+data1+' '+data2+' de aprobación. <br><br> ¿Quieres '+data3+' a otro lote?',
						buttons: {
								confirm: {
										text: 'Si',
										btnClass: 'btn-primary',
										keys: ['enter', 'shift'],
										action: function(){

											$('#procesar_pago_nuevo_lote').attr('lote-id',data.lote);

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

	});

	window.onload=function(){
		var pos=window.name || 0;
		window.scrollTo(0,pos);

	}
	window.onunload=function(){
		window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
	}

	$('#btn_autorizar_pago').click(function () {
      $('#modal-activar-reconfirmacion').removeClass('hidden');
  });

  $('#autorizar_pago').click(function(e){

      var fecha_pago_real = $('#fecha_pago_real').val();
      var idArray = [];
      var lote = $(this).attr('lote-id');

      e.preventDefault();
      $('#example69 tbody tr').each(function(index){

          $(this).children("td").each(function (index2){
              switch (index2){
                  case 10:
                      var $objeto = $(this).find('.seguridad_social');
                      var id = $objeto.attr('id');
                      if ($objeto.is(':checked')) {
                          idArray.push($objeto.attr('id'));
                          $(this).html('<span id="'+id+'" class="bolder seguridad_social" style="margin-right:4px; font-size: 10px">APROBANDO...</span><i class="fa fa-spin fa-spinner"></i>');
                      }
                  break;
              }
          });
      });

      formData = new FormData();
      formData.append('idArray',idArray);
      formData.append('fecha_pago_real',fecha_pago_real);
      formData.append('lote',lote);
      if (idArray.length===0) {
          alert('No hay pagos por autorizar!');
      }else{

        var url = $('meta[name="url"]').attr('content');
        console.log(url)
        $.ajax({
          type: "post",
          url: url+"/../../autorizarpago",
          data: formData,
          processData: false,
          contentType: false,
          success: function(data) {

            if (data.respuesta===true) {
              for (var i in idArray) {
                $('#example69 tbody tr').each(function(index, el) {

                  if(parseInt($(this).find('td').eq(10).find('.seguridad_social').attr('id'))===parseInt(idArray[i])){
                    $(this).find('td').eq(10).html('<span class="bolder text-success" style="margin-right:4px; font-size: 10px">AUTORIZADO</span><i class="fa fa-check list-check"></i>');

				  					$(this).closest('tr').fadeOut(function(){$(this.remove())});

                  }
                });
              }
							$('#modal-activar-reconfirmacion').addClass('hidden');

							if(data.pendientes>0){

								var id = null;
								var fecha_preparacion = null;
								var razons = null;
								var valor_pago = null;

								$.confirm({
	                  title: 'Atención',
	                  content: 'Los pagos seleccionados fueron aprobados!!!<br><br>¡OJO! Quedan pagos pendientes por aprobar en este lote. <br><br> ¿Quieres añadirlos a otro lote?',
	                  buttons: {
	                      confirm: {
	                          text: 'Si',
	                          btnClass: 'btn-primary',
	                          keys: ['enter', 'shift'],
	                          action: function(){

															$('#procesar_pago_nuevo_lote').attr('lote-id',data.lote);

															$('#modal_otro_lote').modal('show');

	                          }

	                      },
				                  cancel: {
				                    text: 'Volver',
														action: function(){

															$.confirm({
								                  title: 'Atención',
								                  content: '¿Estás seguro de no añadirlos a otro lote?',
								                  buttons: {
								                      confirm: {
								                          text: 'Si',
								                          btnClass: 'btn-primary',
								                          keys: ['enter', 'shift'],
								                          action: function(){


								                          }

								                      },
											                  cancel: {
											                    text: 'Volver',
											                  }
								                  }
								              });

														}
				                  }
	                  }
	              });

							}

            }else if(data.respuesta==='completo') {

							$.confirm({
									title: '¡Realizado!',
									content: 'Todos los pagos de este lote fueron aprobados!!!.<br><br>Al presionar OK, serás redirigido a la vista de <b>Lotes Aprobados</b>.',
									buttons: {
											confirm: {
													text: 'OK',
													btnClass: 'btn-success',
													keys: ['enter', 'shift'],
													action: function(){
														location.href = "../../facturacion/lotesaprobados";
													}
											}
									}
							});

            }
          }
        });
      }

  });

	$('#procesar_pago_nuevo_lote').click(function(){

		$(this).attr('disabled',true);
		$(this).addClass('disabled');

		var id = $(this).attr('lote-id');
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

										$('#procesar_pago_nuevo_lote').removeAttr('disabled');
										$('#procesar_pago_nuevo_lote').removeClass('disabled');

									}

							}
					}
			});

		}else{

	    $.ajax({
	      url: '../actualizarlote',
	      method: 'post',
	      data: {id: id, nombre: nombre}
	    }).done(function(data){

	      if(data.respuesta==true){

					$.confirm({
							title: '¡Realizado!',
							content: 'Los pagos pendientes de este lote fueron añadidos al lote creado.<br><br> El lote pagado lo encontrarás en <b>Lotes Aprobados</b>!<br>El nuevo lote creado, lo encontrarás en <b>Lotes por Aprobar</b>!<br><br>Al presionar OK, serás redirigido a la vista de <b>Lotes Aprobados</b>.',
							buttons: {
									confirm: {
											text: 'OK',
											btnClass: 'btn-success',
											keys: ['enter', 'shift'],
											action: function(){
												location.href = "../../facturacion/lotesaprobados";
											}
									}
							}
					});

	      }else if(data.respuesta==false){

	      }

	    });

		}

	});

	$('.sin_ingresos').click(function(){

		var id = $(this).attr('data-id');

		$.ajax({
			url: '../buscarfac',
			method: 'post',
			data: {id: id}
		}).done(function(data){

			if(data.respuesta==true){

				$('#titulo_modal').html('Facturas sin ingreso del pago N° '+id)

				$('#tabla_facturas tbody').html('');

				var a = 1;
				for (var o in data.facturas) {

            var htmls = '';

						var url = 'https://app.aotour.com.co/autonet/facturacion/verdetalle/'+data.facturas[o].id;
						var url2 = 'https://app.aotour.com.co/autonet/facturacion/verorden/'+data.facturas[o].id;
						if(data.facturas[0].id_siigo!=null){
							var imgs = '<img src="https://app.aotour.com.co/autonet/img/siigo.png" alt="" width="35px" height="20px">';
						}else{
							var imgs = '';
						}
            htmls += '<tr>'+
                        '<td>'+
													a+imgs+
                        '</td>'+
												'<td>'+
													data.facturas[o].numero_factura+
                        '</td>'+
												'<td>'+
													data.facturas[o].razonsocial+
                        '</td>'+
												'<td>'+
													data.facturas[o].fecha_inicial+
                        '</td>'+
												'<td>'+
													data.facturas[o].fecha_final+
                        '</td>'+
												'<td>'+
													'$ '+number_format(data.facturas[o].total_facturado_cliente)+
                        '</td>'+
												'<td>'+
													data.facturas[o].ciudad+
                        '</td>'+
												'<td>'+
													'<center><a target="_blank" href="'+url+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-primary btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true">Orden</a></center>'+
                        '</td>'+
												'<td>'+
													'<center><a target="_blank" href="'+url2+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-info btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true">Detalles</a></center>'+
                        '</td>'+
                      '</tr>';

            $('#tabla_facturas tbody').append(htmls);
						a++;

        }

				$('#modal_ingresos').modal('show')

			}else if(data.respuesta==false){

			}

		});

	});

	$('.persona_nat').click(function(){

		//alert($(this).attr('data-id'))
		var id = $(this).attr('data-id');

		$.ajax({
			url: '../buscarpn',
			method: 'post',
			data: {id: id}
		}).done(function(data){

			if(data.respuesta==true){

				$('#titulo_modal2').html('Facturas de PN en el pago N° '+id)

				$('#tabla_natural tbody').html('');

				var a = 1;
				for (var o in data.facturas) {

            var htmls = '';

						var url = 'https://app.aotour.com.co/autonet/facturacion/verdetalle/'+data.facturas[o].id;
						var url2 = 'https://app.aotour.com.co/autonet/facturacion/verorden/'+data.facturas[o].id;

						if(data.facturas[0].id_siigo!=null){
							var imgs = '<img src="https://app.aotour.com.co/autonet/img/siigo.png" alt="" width="35px" height="20px">';
						}else{
							var imgs = '';
						}

            htmls += '<tr>'+
                        '<td>'+
													a+imgs+
                        '</td>'+
												'<td>'+
													data.facturas[o].numero_factura+
                        '</td>'+
												'<td>'+
													data.facturas[o].razonsocial+
                        '</td>'+
												'<td>'+
													data.facturas[o].fecha_inicial+
                        '</td>'+
												'<td>'+
													data.facturas[o].fecha_final+
                        '</td>'+
												'<td>'+
													'$ '+number_format(data.facturas[o].total_facturado_cliente)+
                        '</td>'+
												'<td>'+
													data.facturas[o].ciudad+
                        '</td>'+
												'<td>'+
													'<center><a target="_blank" href="'+url+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-primary btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true">Orden</a></center>'+
                        '</td>'+
												'<td>'+
													'<center><a target="_blank" href="'+url2+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-info btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true">Detalles</a></center>'+
                        '</td>'+
                      '</tr>';

            $('#tabla_natural tbody').append(htmls);
						a++;

        }

				$('#modal_natural').modal('show')

			}else if(data.respuesta==false){

			}

		});

	});

	$('.comenta').click(function(){

		var comentario = $(this).attr('data-comentario');
		var id = $(this).attr('data-id');

		$('#titulo_modal3').html('Comentario del pago N° '+id)

		$('#comentaa').html(comentario)

		$('#modal_comentario').modal('show')

	});

	$('#example69').on('click', '.seguridad_social22', function (e) {

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
        $('.retefuente_descontado').html('Este pago no tiene descuento de Retefuente<br><br>')
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
            prestamos_pen += 'Este proveedor tiene préstamos sin descontar <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';

            for (var o in data.prestamos){
                console.log('trues')
                prestamos_pen += '<br><br>Consecutivo N° '+data.prestamos[o].id+', por valor: $ '+number_format(data.prestamos[o].valor_prestado)+'';
            }

            $('.prestamos_pendientes').html(prestamos_pen+'<br><br>')

        }else{

            $('.prestamos_pendientes').html('');
            //if()
            prestamos_pen += 'Este proveedor NO tiene prestamos pendientes. <i class="fa fa-check-square" aria-hidden="true"></i>';
            $('.prestamos_pendientes').html(prestamos_pen+'<br><br>')

        }

        $('.ingreso_de_factura').html('');
        if(data.totalFacturas>0){

            sin_ingreso += 'Este pago tiene facturas sin ingreso <i class="fa fa-arrow-down" aria-hidden="true"></i><br><br>';
            for (var o in data.query){

                sin_ingreso += 'Factura N° <a target="_blank" href="https://app.aotour.com.co/autonet/facturacion/verorden/'+data.query[o].id+'">'+data.query[o].numero_factura+'</a>, por valor: $ '+number_format(data.query[o].total_facturado_cliente)+'<br><br>';
            }

            //$('.ingreso_de_factura').html(sin_ingreso);

        }else{
            sin_ingreso += 'Todas la facturas de este pago tienen ingreso! <i class="fa fa-check-square" aria-hidden="true"></i>';
            //$('.ingreso_de_factura').html(sin_ingreso);
        }

        var segg = '';
				//alert(href)
        if(href===null || href==='') {
            segg += '<b style="color: red">Este pago NO cuenta con seguridad social<br><br>';
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

	$('#example69').on('click', '.verprestamos', function () {

    console.log('test '+$(this).attr('data-id'))

    //var url = 'http://localhost/autonet';
        var url = 'https://app.aotour.com.co/autonet';
        //var url = $('meta[name="url"]').attr('content');

        var data_option = $(this).attr('data-option');

        var id = $(this).attr('proveedor-id');  //ID DEL PRESTAMO
        var pago_id = $(this).attr('data-id'); //ID EL PAGO

        //alert(url+' '+id)

        //
        $.ajax({
          url: url+'/facturacion/detallesdeprestamo',
          method: 'post',
          data: {
              id: id, //ID DEL PRESTAMO
              pago_id: pago_id, //ID DEL PAGO
              data_option: data_option
          }
      }).done(function (response, responseStatus, data){

          var $data = data.responseJSON;

          if (data.status==200) {

              if ($data.respuesta==true) {

								if ($data.prestamo!=null){
									var cont = 1;
									var total = 0;
									for(var u in $data.prestamo){

											var $json = JSON.parse($data.prestamo[u].detalles_valores);
											console.log($json)
											console.log('hola')

											//var $json = JSON.parse($data.prestamo.detalles_valores);

											var htmlJson;

											for(i in $json){
													htmlJson += '<tr>'+
															'<td>'+cont+'</td>'+
															'<td>'+$json[i].usuario+'</td>'+
															'<td>'+$json[i].concepto+'</td>'+
															'<td>'+'$ '+number_format($json[i].valor)+'</td>'+
															'<td>'+$json[i].timestamp+'</td>'+
														'</tr>';
														cont++;
														total = parseFloat(total)+parseFloat($json[i].valor);
											}

									}
									htmlJson +='<tr>'+
											'<td colspan="4"></td>'+
											'<td>TOTAL: $ '+number_format(total)+'</td>'+
										'</tr>';

										$('#exampledetalles tbody').html('').append(htmlJson);

										$('#modal_vista').modal('show');

								} else if($data.prestamo==null){

                      $.alert({
                          title: 'Autonet',
                          content: 'No hay prestamos para este proveedor!'
                      });

                  }

              }else if($data.respuesta==false){
                alert('No hay ningún préstamo activo para este proveedor!');
              }
          }

      }).fail(function(){

      });

  });

	$tablef = $('#example69').DataTable( {
      "order": [[ 0, "asc" ]],
      paging: false,

      language: {
          processing:     "Procesando...",
          search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
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
          { 'sWidth': '7%' },
          { 'sWidth': '1%' },
          { 'sWidth': '5%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '3%' },
          { 'sWidth': '2%' },
          { 'sWidth': '5%' },
					{ 'sWidth': '4%' }
      ],
  });

</script>
</body>
</html>
