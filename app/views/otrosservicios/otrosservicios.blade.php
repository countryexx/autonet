<html>
<head>
	<title>Autonet | Otros servicios</title>
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
</head>

<body>
@include('admin.menu')
<div class="col-lg-12">
		<div class="col-lg-2">
			<div class="row">
				<ol style="margin-bottom: 5px" class="breadcrumb">
					<!--<li><a href="#">Proveedores</a></li>-->
					<li class="active"><i class="fa fa-home"></i></li>
					<li><a href="{{url('otrosservicios/listado')}}">Listado</a></li>
				</ol>
			</div>
		</div>
    <div class="col-lg-12">
    	<div class="row">
    		<h3 class="h_titulo">INGRESO DE OTROS SERVICIOS</h3>
    	</div>
    </div>

    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
		<div class="row">
				<div class="panel panel-primary">
				<div class="panel-heading"><strong>OTROS SERVICIOS</strong></div>
				<div class="panel-body">
					<fieldset style="margin-bottom: 15px;"><legend>Informacion Basica</legend>
						<div class="row">
							<div class="col-xs-2">
								<label for="fecha_orden" class="obligatorio">Fecha de orden</label>
								<div class="input-group">
									<div class="input-group date" id="datetimepicker1">
										<input style="width: 147px;" type='text' class="form-control input-font" id="fecha_orden" value="{{date('Y-m-d')}}">
										<span class="input-group-addon">
											<span class="fa fa-calendar">
											</span>
										</span>
									</div>
								</div>
							</div>
							<div class="col-xs-3" id="centro_alerta">
								<label class="obligatorio" for="centro_de_costo">Centro de costo</label>
								<select class="form-control input-font" id="centro_de_costo">
									<option>-</option>

									@foreach($centrosdecosto as $centrodecosto)
										@if($centrodecosto->inactivo==1)
											<option disabled value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
										@else
											<option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
										@endif
									@endforeach
								</select>
								<small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
							</div>
							<div class="subcentros hidden">
								<div class="col-xs-3">
									<label class="obligatorio" for="subcentros">Subcentro de costo</label>
									<select class="form-control input-font" id="subcentros">
										<option>-</option>
									</select>
								</div>
							</div>
							<div class="col-xs-2">
								<label class="obligatorio" for="departamento">Departamento</label>
								<select class="form-control input-font" id="departamento">
									<option>-</option>
									@foreach($departamento as $depar)
										<option value="{{$depar->id}}">{{$depar->departamento}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-xs-2">
								<label class="obligatorio" for="ciudad">Ciudad</label>
								<select class="form-control input-font" id="ciudad" disabled>
									<option>-</option>
								</select>
							</div>
						    <div class="col-xs-12 hidden cliente_eventual">
						    	<div class="row">
										<div class="col-xs-2">
						    			<label>Nombre o Razon Social</label>
						    			<input type="text" id="persona_natural" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-2" id="clienteev_alerta">
						    			<label class="obligatorio">C.C</label>
						    			<input type="text" id="cc" class="form-control input-font">
						    			<small id="alerta_cliente" class="help-block hidden">Rellene este campo	!</small>
						    		</div>
						    		<div class="col-xs-3">
						    			<a id="buscar_cliente" style="margin-top: 26px;" class="btn btn-default btn-icon">BUSCAR<i class="fa fa-search icon-btn"></i></a>
						    			<a id="nuevo_cliente" style="margin-top: 26px;" class="btn btn-info btn-icon">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
						    		</div>
						    	</div>
						    </div>
						    <div class="col-xs-12 agregar_cliente hidden">
						    	<div class="row">
						    		<div class="col-xs-3">
						    			<label class="obligatorio">Nombre completo</label>
						    			<input id="nombre_completo_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-2">
						    			<label class="obligatorio">C.C</label>
						    			<input id="cc_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-3">
						    			<label class="obligatorio">Direccion</label>
						    			<input id="direccion_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-2">
						    			<label>Telefono</label>
						    			<input id="telefono_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-2">
						    			<label class="obligatorio">Celular</label>
						    			<input id="celular_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-3">
						    			<label>Email</label>
						    			<input id="email_cliente" type="text" class="form-control input-font">
						    		</div>
						    		<div class="col-xs-3">
										<a id="guardar_nuevo_cliente" style="margin-top: 26px;" type="text" class="btn btn-success btn-icon">GUARDAR<i class="fa fa-save icon-btn"></i></a>
						    		</div>
						    	</div>
						    </div>

							<div class="col-xs-12">
								<a id="agregar_otros" style="margin-top: 10px" data-toggle="modal" class="btn btn-default btn-icon" data-target=".mymodal">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
							</div>
						</div>
					</fieldset>
					<fieldset id="servicios" class="hidden"><legend>Servicios</legend>
						<div class="otros">
							<table style="margin-bottom: 0" class="table table-hover table-bordered">
								<thead>
								<tr>
									<td>PRODUCTO</td>
									<td>DESTINO / DETALLE</td>
									<td>% COMISION</td>
									<td>VALOR COMISION</td>
									<td>IVA COMISION</td>
									<td>OTROS</td>
									<td>VALOR EN DOLARES</td>
									<td>VALOR</td>
									<td>IVA SERVICIO</td>
									<td>TASA AERO</td>
									<td>OTRAS TASAS</td>
									<td>IMPUESTOS</td>
									<td>DESCUENTOS</td>
									<td>TOTAL</td>
									<td></td>
								</tr>
								</thead>
								<tbody id="servicios_otros">
								</tbody>
							</table>
							<div>
								<div class="input-font total">
									<div style="margin-right: 68px; float: left" class="content-facturado">
										<label style="margin-bottom: 0">TOTAL FACTURADO</label><label style="color: #F47321; font-size: 15px; margin-left: 5px; margin-bottom: 0" id="total_facturado"></label>
									</div>
									<div class="content-facturado">
										<label style="margin-bottom: 0">TOTAL UTILIDAD</label><label style="color: #F47321; font-size: 15px; margin-left: 5px; margin-bottom: 0" id="total_utilidad"> </label>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					<fieldset style="margin-top: 15px;"><legend>Informacion de pago <input type="checkbox" id="habilitar"></legend>
						<div class="row">
							<div id="informacion_pago">
								<div class="col-xs-2">
									<label class="obligatorio" for="fecha">Fecha</label>
									<div class="input-group">
										<div class="input-group date" id='datetimepicker1'>
											<input style="width: 147px;" type='text' class="form-control input-font" id="fecha" value="{{date('Y-m-d')}}" disabled>
											<span class="input-group-addon">
												<span class="fa fa-calendar">
												</span>
											</span>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<label for="valor" class="obligatorio">Valor</label>
									<input type='text' class="form-control input-font" id="valor" disabled>
								</div>
								<div class="col-xs-1">
									<label for="negocio" class="obligatorio"># Negocio</label>
									<input type='text' class="form-control input-font" id="negocio" disabled>
								</div>
								<div class="col-xs-1">
									<label for="tercero" class="obligatorio">Tercero</label>
									<select class="form-control input-font" id="tercero" disabled>
										<option value="0">-</option>
										<option value="1">SI</option>
										<option value="2">NO</option>
									</select>
								</div>
								<div class="col-xs-2 nombre_tercero hidden">
									<label for="id_tercero" class="obligatorio">Nombre del Tercero</label>
									<select id="id_tercero" class="form-control input-font">
										<option value="0">-</option>
										@foreach($terceros as $tercero)
											<option value="{{$tercero->id}}">{{$tercero->nombre_completo}}</option>
										@endforeach
							  	</select>
								</div>
								<div class="col-xs-2">
									<label for="pagado_proveedor">Pagado a Proveedor</label>
									<select class="form-control input-font" id="pagado_proveedor" disabled>
										<option value="0">-</option>
										<option value="1">EFECTIVO</option>
										<option value="2">CREDITO</option>
										<option value="3">NO APLICA</option>
									</select>
								</div>
								<div class="col-xs-4">
									<label class="obligatorio">Forma de pago</label>
									<div class="input-group" style="margin-top: 7px">
										<label class="radio-inline input-font">
											<input disabled type="radio" checked name="inlineRadioOptions" id="inlineRadio1" value="1"> EFECTIVO
										</label>
										<label class="radio-inline input-font">
											<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2"> CHEQUE
										</label>
										<label class="radio-inline input-font">
											<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3"> TARJETA DE CREDITO
										</label>
										<label class="radio-inline input-font">
											<input disabled type="radio" name="inlineRadioOptions" id="inlineRadio3" value="4"> CREDITO
										</label>
									</div>
								</div>
								<div class="col-xs-12">
									<div class="row">
										<div class="col-lg-6">
											<label for="concepto" class="obligatorio">Concepto</label>
											<textarea id="concepto" rows="5" class="form-control input-font" disabled></textarea>
										</div>
										<div class="col-lg-3 hidden autorizado_por">
											<label for="autorizado_por" class="obligatorio">Autorizado por</label>
											<select id="autorizado_por" class="form-control input-font" disabled>
												<option>-</option>
												<option value="1">DAVID COBA</option>
											</select>
										</div>
										<div class="col-lg-2 hidden plazo">
											<label for="plazo" class="obligatorio">Plazo en dias</label>
											<input id="plazo" class="form-control input-font" disabled>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<label for="comentario">Comentarios</label>
									<textarea id="comentario" rows="5" class="form-control input-font" disabled></textarea>
								</div>
							</div>
						</div>
					</fieldset>
					@if(isset($permisos->turismo->otros->crear))
						@if($permisos->turismo->otros->crear==='on')
							<a style="margin-top:15px" class="btn btn-primary btn-icon" id="guardar">GUARDAR<i class="fa fa-save icon-btn"></i></a>
						@else
							<a style="margin-top:15px" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></a>
						@endif
					@else
						<a style="margin-top:15px" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></a>
					@endif
				</div>
			</div>
		</div>
    </div>
 </div>
<div class="modal fade mymodal" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;">
	<div class="modal-dialog modal-otros">
		<div class="modal-content ui-draggable">
			<div class="modal-header ui-draggable-handle">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="fa fa-times"></i>
				</button>
				<strong>NUEVO ITEM</strong>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-4">
								<label for="producto" class="obligatorio">Producto</label>
								<select id="producto" class="form-control input-font">
									<option>-</option>
									<option value="1">TIQUETES AEREOS</option>
									<option value="2">PLANES TURISTICOS</option>
									<option value="3">CRUCEROS</option>
									<option value="4">VIAJES EN TRENES</option>
									<option value="5">HOSPEDAJE</option>
									<option value="6">ALQUILER DE AUTOS</option>
									<option value="7">CITY TOURS Y CIRCUIT</option>
									<option value="8">GUIA TURISTICOS PRO</option>
									<option value="9">CURSOS DE IDIOMAS EN</option>
									<option value="10">TARJETAS DE ASISTENCIA</option>
									<option value="11">TRAMITE DE DOCUMENTOS</option>
									<option value="12">OTROS</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3 destino hidden">
						<label for="destino" class="obligatorio">Destino</label>
						<select id="destino" class="form-control input-font">
							<option>-</option>
							<option value="1">NACIONAL</option>
							<option value="2">INTERNACIONAL</option>
						</select>
					</div>
					<div class="col-sm-3">
						<label for="valor_servicio" class="obligatorio">Valor servicio</label>
						<input id="valor_servicio" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3 hidden otras_tasas">
						<label for="otras_tasas" class="obligatorio">Otras tasas</label>
						<input id="otras_tasas" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-6 detalle hidden">
						<label for="detalle" class="obligatorio">Detalle</label>
						<input id="detalle" type="text" class="form-control input-font">
					</div>
					<div class="col-sm-3">
						<label for="comision" class="obligatorio">% Comision</label>
						<input id="comision" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3">
						<label for="valor_comision" class="obligatorio">Valor TA</label>
						<input id="valor_comision" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3">
						<label for="iva_comision" class="obligatorio">Iva TA</label>
						<input id="iva_comision" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3">
						<label for="otros_u" class="obligatorio">Otros</label>
						<input id="otros_u" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3 hidden dolar_iata">
						<label for="dolar_iata" class="obligatorio">Dolar Iata</label>
						<input id="dolar_iata" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3 hidden valor_dolares">
						<label for="valor_dolares" class="obligatorio">Valor en dolares</label>
						<input id="valor_dolares" type="text" class="form-control input-font" value="0">
					</div>

					<div class="col-sm-3">
						<label for="impuestos" class="obligatorio">Impuestos</label>
						<input id="impuestos" type="text" class="form-control input-font" value="0">
					</div>

					<div class="col-sm-3 tasa_aero hidden">
						<label for="tasa_aero" class="obligatorio">Tasa aero</label>
						<input id="tasa_aero" type="text" class="form-control input-font" value="0">
					</div>

					<div class="col-sm-3 hidden iva_servicio">
						<label for="iva_servicio" class="obligatorio">Iva servicio</label>
						<input id="iva_servicio" type="text" class="form-control input-font" value="0">
					</div>
					<div class="col-sm-3">
						<label for="descuento" class="obligatorio">Descuento</label>
						<input id="descuento" type="text" class="form-control input-font" value="0">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-success btn-icon" id="agregar">AGREGAR<i class="fa fa-check icon-btn"></i></a>
				<a class="btn btn-success btn-icon hidden" id="editar">EDITAR<i class="fa fa-pencil icon-btn"></i></a>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div>
<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/otrosservicios.js')}}"></script>
</body>
</html>
