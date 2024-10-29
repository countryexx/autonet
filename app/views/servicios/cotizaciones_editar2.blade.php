<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Cotizaciones Editar</title>
  </head>
  <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
  @include('scripts.styles')
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <body>
  @include('admin.menu')
  <div class="col-lg-12">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-2">
          <div class="row">
    				<ol style="margin-bottom: 5px" class="breadcrumb">
    					<li><a href="{{url('cotizaciones')}}">Inicio</a></li>
    					<li><a href="{{url('cotizaciones/listado')}}">Listado</a></li>
    				</ol>
    			</div>
        </div>
        <div class="col-lg-12">
        	<div class="row">
        		<h3 class="h_titulo">EDITAR  COTIZACION  {{$cotizaciones->consecutivo}}</h3>
        	</div>
        </div>
      </div>
		</div>
    <div class="col-lg-9">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">Cotizaciones</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-2">
                  <label for="fecha">Fecha</label>
                  <input disabled class="form-control input-font" type="text" value="{{$cotizaciones->fecha}}">
              </div>
              <div class="col-xs-2">
                  <label for="fecha">Fecha Vencimiento</label>
                  <div class="input-group">
                    <div class="input-group date" id="datetimepicker1">
                        <input disabled id="fecha_vencimiento" value="{{$cotizaciones->fecha_vencimiento}}" name="fecha_vencimiento" style="width: 115;" type="text" class="form-control input-font">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
              </div>
              <div class="col-lg-4">
                <label class="obligatorio" for="nombre_completo">Nombre Completo o Razon social</label>
                <input disabled id="nombre_completo" class="form-control input-font" value="{{$cotizaciones->nombre_completo}}">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" for="identificacion">Nit o Identificacion</label>
                <input disabled id="identificacion" class="form-control input-font" value="{{$cotizaciones->nit}}">
              </div>
			</div>
			<div class="row">
              <div class="col-lg-2">
                <label class="obligatorio" for="direccion">Direccion</label>
                <input id="direccion" class="form-control input-font" value="{{$cotizaciones->direccion}}">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" for="telefono">Celular o Telefono</label>
                <input id="telefono" class="form-control input-font" value="{{$cotizaciones->celular}}">
              </div>
              <div class="col-lg-3">
                <label for="contacto">Contacto</label>
                <input type="text" id="contacto" class="form-control input-font" value="{{$cotizaciones->contacto}}">
              </div>
              <div class="col-lg-3">
                <label class="obligatorio" for="email">Email</label>
                <input id="email" class="form-control input-font" value="{{$cotizaciones->email}}">
              </div>
			</div>
			<div class="row">
              <div class="col-lg-4">
                <label class="obligatorio" for="asunto">Asunto</label>
                <input id="asunto" class="form-control input-font" value="{{$cotizaciones->asunto}}">
              </div>
              <div class="col-lg-3">
                <label class="obligatorio" for="tipo">Tipo</label>
                <select id="tipo" class="form-control input-font">
                  <option value="0">-</option>
                  @if(intval($cotizaciones->tipo)===1)
                    <option selected value="1">TRANSPORTE</option>
                  @else
                    <option value="1">TRANSPORTE</option>
                  @endif
                  @if(intval($cotizaciones->tipo)===2)
                    <option selected value="2">PLAN TURISTICO</option>
                  @else
                    <option value="2">PLAN TURISTICO</option>
                  @endif
                  @if(intval($cotizaciones->tipo)===3)
                    <option selected value="3">AMBAS</option>
                  @else
                    <option value="3">AMBAS</option>
                  @endif
                </select>
              </div>
              <div class="col-lg-3">
                <label class="obligatorio" for="vendedor">Vendedor</label>
                <input id="vendedor" class="form-control input-font" type="text" value="{{$cotizaciones->vendedor}}">
              </div>
			</div>

			<div class="row col-lg-12" style="margin-top: 35px;">
				<table style="margin-bottom: 0" class="table table-hover table-bordered" id="tbcotizaciones">
					<thead>
						<tr align="center">
							<td>#</td>
							<td>FECHA SERVICIO</td>
							<td>TIPO DE SERVICIO</td>
							<td>DESCRIPCION</td>
							<td>CIUDAD</td>
							<td>TIPO DE VEHICULO</td>
							<td># PAX</td>
							<td># VEHICULOS</td>
							<td>VALOR TRAYECTO X VEHICULO</td>
							<td>VALOR TOTAL</td>

							<td></td>
						</tr>
					</thead>
					<tbody id="servicios_otros">
          <?php $total=0; $i=1; ?>
					@foreach($cotizaciones_det as $cot_det)
						<tr data-id="{{ $i }}">
              <td>{{$i}}</td>
							<td>{{$cot_det->fecha_servicio}}</td>
							<td>{{$cot_det->tipo_servicio}}</td>
							<td>{{$cot_det->descripcion}}</td>
							<td>{{$cot_det->ciudad}}</td>
							<td>{{$cot_det->tipo_vehiculo}}</td>
							<td align="center">{{$cot_det->pax}}</td>
							<td align="center">{{$cot_det->vehiculos}}</td>
							<td align="center">{{$cot_det->valorxvehiculo}}</td>
							<td align="right">{{$cot_det->valortotal}}</td>
							<td align="center">
                <!--<a data-id="{{$i}}" data-toggle="modal" data-target=".mymodal" style="padding: 5px 6px; margin-bottom: 5px" class="btn btn-success item_select" title="Editar" ><i class="fa fa-pencil"></i></a>-->
                <a data-id="{{$i}}" data-toggle="modal" data-target=".mymodal" style="padding: 5px 6px; margin-bottom: 5px" class="btn btn-success item_select" title="Editar" ><i class="fa fa-pencil"></i></a>
								<a style="padding: 5px 6px;" class="btn btn-danger eliminar" title="Anular"><i class="fa fa-close"></i></a>
							</td>
						</tr>
            <?php

              $total = floatval($cot_det->valortotal) + $total;
              $i++;
            ?>
					@endforeach
					</tbody>
				</table>
				<div class="col-lg-12" >
					<div style="margin-left:900px; margin-top: 10px; float: left;" class="input-font total content-facturado">
						<label style="margin-bottom: 0">TOTAL $</label>
						<label style="color: #F47321; font-size: 15px; margin-left: 20px; margin-bottom: 0" id="total_general">{{number_format($total)}}</label>
					</div>
				</div><br/>

				<a id="agregar_ruta" style="margin-top: 10px" data-toggle="modal" class="btn btn-default btn-icon" data-target=".mymodal">ITEMS<i class="fa fa-plus icon-btn"></i></a>
			</div>

              <div class="col-lg-12" style="margin-top: 15px">
                <div class="form-group">
                  <label for="observaciones">Observaciones</label>
                  <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{$cotizaciones->observacion}}</textarea>

                </div>

              </div>

            @if(isset($permisos->comercial->cotizaciones->editar))
              @if($permisos->comercial->cotizaciones->editar==='on')
                  <!-- <button type="button" class="btn btn-success btn-icon" id="editar">EDITAR<i class="fa fa-pencil icon-btn"></i></button> -->
                  <button type="button" data-id="{{$cotizaciones->id}}" class="btn btn-primary btn-icon" id="actualizarcot">GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
              @else

                 <button type="button" class="btn btn-primary btn-icon" disabled>GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
              @endif
            @else

                 <button type="button" class="btn btn-primary btn-icon" disabled>GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
            @endif
            <!-- <button type="button" class="btn btn-info btn-icon" id="sumar">SUMAR<i class="fa fa-plus icon-btn"></i></button>
            <button type="button" class="btn btn-info btn-icon" id="multiplicar">MULTIPLICA<i class="fa fa-close icon-btn"></i></button>
            <br><br><br>
			<a onclick="goBack()" class="btn btn-info btn-icon">VOLVER<i class="fa fa-arrow-left icon-btn"></i></a>-->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
      <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
      <ul>
      </ul>
  </div>

  <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<form id="formulario_servicio" autocomplete="off">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
						<h4 class="modal-title">AGREGAR ITEM TARIFA</h4>
					</div>
					<div class="modal-body"><form id="form_items">
						<div class="row">
							<div class="col-xs-2">
								<div class="form-group" style="margin-bottom: 0px;">
									<label for="fecha_servicio" >Fecha Servicio</label>
									<div class='input-group date' id='datetimepicker3'>
										<input type='text' class="form-control input-font" id="fecha_servicio" value="{{date('Y-m-d')}}">
										<span class="input-group-addon">
											<span class="fa fa-calendar">
											</span>
										</span>
									</div>
								</div>
							</div>
              <input type="hidden" id="idHide">
							<div class="col-xs-2">
								<label for="Ciudades" >Ciudades</label>
								<select name="ciudades" id="ciudades" class="form-control input-font">
									@foreach($ciudades as $ciudad)
										<option>{{$ciudad->ciudad}}</option>
									@endforeach
								</select>
							</div>

							<div class="col-xs-2">
								<label for="t_vehiculoedit" >Tipo Vehiculo</label>
								<select name="t_vehiculoedit" id="t_vehiculoedit" class="form-control input-font">
									<option>AUTOMOVIL</option>
									<option>MINIVANS</option>
									<option>VANS</option>
									<option>BUS</option>
									<option>BUSETA</option>

								</select>
							</div>
							<div class="col-xs-2">
								<label for="t_servicioedit" >Tipo de Servicio</label>
								<select name="t_servicioedit" id="t_servicioedit" class="form-control input-font">
  								@foreach($rutas as $ruta)
  									<option value="{{$ruta->id}}">{{$ruta->nombre_ruta}}</option>
  								@endforeach
								</select>
							</div>
							<div class="col-xs-3">
								<label for="descripcion" >Descripcion</label>
								<input type="text" class="form-control input-font" id="descripcion">
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-xs-1">
								<label for="pax" ># PAX</label>
								<input type="text" class="form-control input-font solo-numero" id="pax">
							</div>
							<div class="col-xs-2">
								<label for="n_vehiculos" >Vehiculos</label>
								<input type="text" class="form-control input-font solo-numero" id="n_vehiculos">
							</div>
							<div class="col-xs-3">
								<label for="valor_trayecto" >Valor Trayecto X Vehiculo</label>
								<input type="text" class="form-control input-font solo-numero" id="valor_trayecto">
							</div>
							<div class="col-xs-2">
								<label for="valor_total" >Valor Total</label>
								<input type="text" class="form-control input-font solo-numero" id="valor_total">
							</div>
						</div>
						</form>
					</div>
					<div class="modal-footer" >
						<a class="btn btn-success btn-icon" id="agregar_itemsedit" >AGREGAR<i class="fa fa-check icon-btn" ></i></a>
						<a class="btn btn-success btn-icon hidden" id="mod_itemsedit">MODIFICAR<i class="fa fa-check icon-btn" ></i></a>
					</div>
				</div><!-- /.modal-content -->
			</form>
		</div><!-- /.modal-dialog -->
	</div>

  @include('scripts.scripts')
  <script src="{{url('bootstrap-fileinput-master\js\plugins\canvas-to-blob.min.js')}}" type="text/javascript"></script>
  <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
       This must be loaded before fileinput.min.js -->
  <script src="{{url('bootstrap-fileinput-master\js\plugins\sortable.min.js')}}" type="text/javascript"></script>

  <script src="{{url('bootstrap-fileinput-master\js\plugins\purify.min.js')}}" type="text/javascript"></script>
  <!-- the main fileinput plugin file -->
  <script src="{{url('bootstrap-fileinput-master\js\fileinput.min.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/cotizaciones.js')}}" type="text/javascript"></script>
  <!-- <script src="{{url('tinymce_4.4.1\tinymce\js\tinymce\tinymce.min.js')}}"></script>
  <script src="{{url('tinymce_4.4.1\tinymce\editor.js')}}"></script> -->


  </body>
</html>
