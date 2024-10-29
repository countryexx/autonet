<html>
<head>
	<title>Autonet | Factura Proveedor Detalles</title>
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
	@include('admin.menu')

		<div class="col-lg-12">
			<h3 class="h_titulo">DETALLE DEL PAGO AP</h3>
			@if($pago_proveedores_detalles!=null)
				<div class="col-lg-4">
					<div class="row">
					<table class="table" style="margin-bottom:0px">
						<tbody>
							<tr>
								<td>NUMERO DE FACTURA</td>
								<td><span style="color: #F47321;">{{$pago_proveedores->numero_factura}}</span></td>
							</tr>
							<tr>
								<td>FECHA INICIAL</td>
								<td>{{$pago_proveedores->fecha_inicial}}</td>
							</tr>
							<tr>
								<td>CENTRO DE COSTO</td>
								<td>@if($pago_proveedores->centrodecostonombre===$pago_proveedores->nombresubcentro) {{$pago_proveedores->centrodecostonombre}} @elseif($pago_proveedores->centrodecostonombre!=$pago_proveedores->nombresubcentro) {{$pago_proveedores->centrodecostonombre.' / '.$pago_proveedores->nombresubcentro}} @endif</td>
							</tr>
							<tr style="border-bottom: 1px solid #ddd;">
								<td>VALOR</td>
								<td style="color: #F47321;">$ {{number_format($pago_proveedores->valor)}}</td>
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
								<tr>
									<td>FECHA FINAL</td>
									<td>{{$pago_proveedores->fecha_final}}</td>
								</tr>
								<tr>
									<td>PROVEEDOR</td>
									<td>{{$pago_proveedores->proveedornombre}}</td>
								</tr>
								<tr style="border-bottom: 1px solid #ddd;">
									<td>NO COBRADO</td>
									<td style="color: #F47321;">$ {{number_format($pago_proveedores->valor_no_cobrado)}}</td>
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
									<td>CONSECUTIVO</td>
									<td style="color: #F47321;">{{$pago_proveedores->consecutivo}}</td>
								</tr>
								<tr style="border-bottom: 1px solid #ddd;">
									<td>CREADO POR</td>
									<td>{{$pago_proveedores->first_name.' '.$pago_proveedores->last_name}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="row">
							<p style="text-align: center; margin-top:10px" class="subtitulo">CRONOGRAMA DE PAGO DE SERVICIOS DEL {{$pago_proveedores->fecha_inicial.' AL '.$pago_proveedores->fecha_final}}</p>
					</div>
				</div>
				<table class="table table-bordered hover tabla" cellspacing="0" width="100%">
			    	<thead>
			    		<tr>
			    			<td>Codigo</td>
			    			<td>Fecha</td>
			    			<td>#Constancia</td>
			    			<td>Pasajeros</td>
			    			<td>Detalle</td>
			    			<td>Observacion</td>
			    			<td>Valor</td>
			    			<td>Real Pagado</td>
			    			<td>Fecha de Pago</td>
			    			<td>Factura</td>
			    			<td>Orden Factura</td>
			    			<td>Consecutivo</td>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		@foreach($pago_proveedores_detalles as $pago)
							<tr>
								<td>{{$pago->id}}</td>
								<td>{{$pago->fecha_servicio}}</td>
								<td>{{$pago->numero_planilla}}</td>
								<td>
										<?php

		                    $pax = explode('/',$pago->pasajeros);

		                    for ($i=0; $i < count($pax); $i++) {
		                        $pasajeros[$i] = explode(',', $pax[$i]);
		                    }


		                    for ($i=0; $i < count($pax)-1; $i++) {

		                        for ($j=0; $j < count($pasajeros[$i]); $j++) {

		                            if ($j===0) {
										$nombre = $pasajeros[$i][$j];
									}

									if ($j===1) {
										$celular = $pasajeros[$i][$j];
									}

									if ($j===2) {
										$email = $pasajeros[$i][$j];
									}

									if ($j===3) {
										$nivel = $pasajeros[$i][$j];
									}

		                        }
								
								if (!isset($celular)){
									$celular = "";
								}
								
								if (!isset($nombre)){
									$nombre = "";
								}
							
		                        echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';

		                    }

                    ?>
        				</td>
								<td>{{$pago->detalle_recorrido}}</td>
								<td>{{$pago->observacion}}</td>
								<td>{{$pago->total_pagado}}</td>
								<td>{{$pago->pagado_real}}</td>
								<td>{{$pago->fecha_pago}}</td>
								<td>{{$pago->pfactura}}</td>
								<td>
									<span style="font-size: 10px; color: #24649a" class="bolder">
										# FACTURA:
										<a href="../verdetalle/{{$pago->id_orden_factura}}">
											{{$pago->numero_factura}}
										</a>
									</span><br>
									<span style="font-size: 10px; color: #24649a" class="bolder">
										F.EXPEDICION:
										{{$pago->fecha_expedicion}}
									</span><br>
								</td>
								<td>
									<span style="font-size: 10px; color: #F47321" class="bolder">
									#: {{$pago->consecutivo}}
								  </span><br>
									@if($pago->ingreso===null)
										{{'<span class="text-danger">NO TIENE INGRESO<span/>'}}
									@elseif($pago->ingreso!=null)
										{{'<span style="color: #42ad44; font-size: 10px" class="bolder">TIENE INGRESO</span>'}}
									@endif</td>

							</tr>
						@endforeach
			    	</tbody>
			    	<tfoot>
			    		<tr>
			    		<tr>
			    			<td>Codigo</td>
			    			<td>Fecha</td>
			    			<td>#Constancia</td>
			    			<td>Pasajeros</td>
			    			<td>Detalle</td>
			    			<td>Observacion</td>
			    			<td>Valor</td>
			    			<td>Real Pagado</td>
			    			<td>Fecha de Pago</td>
			    			<td>Factura</td>
			    			<td>Orden Factura</td>
			    			<td>Consecutivo</td>
			    		</tr>
			    	</tfoot>
			    </table>
			    <div class="col-lg-4 col-md-6 col-sm-6">
					<div class="row">
						<div style="margin-bottom: 10px" class="panel panel-default">
							<div class="panel-heading">REVISION DE PAGO</div>
							<div class="panel-body">
								<table style="margin-bottom: 10px" class="table table-bordered hover">
									<tbody>
										<tr>
											<td>FECHA DE PAGO</td>
											<td>
												<div class="input-group" id="datetime_fecha" style="display: inline-block; width: 130px">
                                                <div class='input-group date' id='datetimepicker10'>
                                                <input id="fecha_pago" name="fecha_pago" type='text' class="form-control input-font" value="{{$pago->fecha_pago}}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                                </div>
                                                </div>
                                                <button data-id="{{$pago_proveedores->idpago}}" id="cambiar_fecha_pago" class="btn btn-default" style="
                                                                            display: inline-block;
                                                                            vertical-align: top;
                                                                            margin-top: 2px;
                                                                        ">CAMBIAR</button>
                                            </td>
                                        </tr>
										<tr>
											<td>REVISION DE PAGO</td>
											<td>
                          @if(isset($permisos->contabilidad->factura_proveedores->revisar))
                              @if($permisos->contabilidad->factura_proveedores->revisar==='on')
                                  <button data-id="{{$pago_proveedores->idpago}}" class="btn btn-info btn-icon" id="revisar_pago" @if(intval($pago_proveedores->revisado)===1) {{'disabled'}} @endif>REVISAR<i class="icon-btn fa fa-check"></i>
                                  </button>
                              @else
                                  <button class="btn btn-info btn-icon" disabled>REVISAR<i class="icon-btn fa fa-check"></i>
                                  </button>
                              @endif
                          @else
                              <button class="btn btn-info btn-icon disabled">REVISAR<i class="icon-btn fa fa-check"></i>
                              </button>
                          @endif
                      </td>
										</tr>
										<tr>
											<td>ANULACION</td>
											<td>
                                                @if(isset($permisos->contabilidad->factura_proveedores->anular) || $permisos->contabilidad->factura_proveedores->anular===null)
                                                    @if($permisos->contabilidad->factura_proveedores->anular==='on')
                                                    <textarea style="margin-bottom: 8px" rows="4" class="form-control input-font" id="motivo_anulacion"></textarea>
                                                    <button
                                                    <?php
                                                        if (intval($pago_proveedores->preparado)!=1) {
                                                            echo 'data-id="'.$pago_proveedores->idpago.'" id="anular_factura_proveedor"';
                                                        }else{
                                                            echo 'disabled';
                                                        }
                                                    ?>  class="btn btn-danger btn-icon">ANULAR<i class="fa fa-close icon-btn"></i></button>
                                                    @else
														<textarea style="margin-bottom: 8px" rows="4" class="form-control input-font" disabled></textarea>
														<button disabled class="btn btn-danger btn-icon">ANULAR<i class="fa fa-close icon-btn"></i></button>
													@endif
                                                @endif
											</td>
										</tr>
									</tbody>
								</table>
								<div class="form-group" style="margin-bottom: 0px">
									<label for="observaciones">Observaciones</label>
									<textarea disabled rows="3" id="observaciones" class="form-control input-font">{{strtoupper($pago_proveedores->observaciones)}}</textarea>
								</div>
							</div>

						</div>

					</div>
				</div>
			@endif
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="row">
					<a style="margin-bottom:10px" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
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
  function goBack(){
      window.history.back();
  }
</script>
</body>
</html>
