<!DOCTYPE html>
<html>
  <meta name="url" content="{{url('/')}}">
  <head>
    <meta charset="utf-8">
    <title>Autonet | Cotizaciones</title>
  </head>
  <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
  @include('scripts.styles')
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}"><link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
  <style>
        .btn-file{
          padding: 8px 7px 9px !important;
        }
        .fileinput-upload{
          display: none;
          padding: 8px 8px 7px;
        }
        .fileinput-remove{
          padding: 8px 7px 7px;
        }
        .kv-file-upload{
          display: none;
        }

  </style>

  <body>
  @include('admin.menu')
  <div class="col-lg-12">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-2">
          <div class="row">
    				<ol style="margin-bottom: 5px" class="breadcrumb">
              <li><a href="{{url('cotizaciones/listado')}}">Cotizaciones</a></li>
    					<li><a href="{{url('cotizaciones')}}">Crear Cotización</a></li>
    				</ol>
    			</div>
        </div>
        <div class="col-lg-12">
        	<div class="row">
        		<h3 class="h_titulo">NUEVA COTIZACIÓN</h3>
        	</div>
        </div>

      </div>
		</div>
    <div class="col-lg-12">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">Cotizaciones</div>
          <div class="panel-body">
            <form id="formulario">
		             <div class="row">
                   <div class="col-xs-2">
                       <label class="bg-danger obligatorio" for="fecha">Fecha de Solicitud</label>
                       <div class="input-group" >
                         <div class="input-group date" id="datetimepicker1">
                             <input id="fecha_solicitud" value="{{date('Y-m-d')}}" name="fecha_solicitud" style="width: 115;" type="text" class="form-control input-font bg-danger">
                             <span class="input-group-addon">
                                 <span class="fa fa-calendar">
                                 </span>
                             </span>
                         </div>
                       </div>
                   </div>
                    <div class="col-xs-2">
                        <label for="fecha">Fecha de Creación</label>
                        <input disabled class="form-control input-font" type="text" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-xs-2">
                        <label class="bg-danger obligatorio" for="fecha">Fecha Vencimiento</label>
                        <div class="input-group" >
                          <div class="input-group date" id="datetimepicker1">
                              <input id="fecha_vencimiento" value="{{date('Y-m-d')}}" name="fecha_vencimiento" style="width: 115;" type="text" class="form-control input-font bg-danger">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                        </div>
                    </div>
	                  <div class="col-lg-2"><label class="obligatorio" for="centrodecosto">Cliente</label>
                      <select id="centrodecosto_search" class="form-control input-font" name="centrodecosto">
                          <option>SELECCIONAR</option>
                          <option value="0" style="background: orange">CLIENTE NO CREADO</option>
                          @foreach($centrosdecosto as $centro)
                              <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                          @endforeach
                      </select>
                  </div>
                <div id="name_c" class="col-lg-2 hidden">
                    <label class="obligatorio" for="nombre_completo">Nombre Completo o Razon Social</label>
                    <input id="nombre_completo" class="form-control input-font"></label>
                </div>
                <div id="nit_c" class="col-lg-2 hidden">
                  <label class="obligatorio" for="identificacion">Nit o Identificacion</label>
                  <input id="identificacion" class="form-control input-font"></label>
                </div>

			</div>
			<div class="row">
				<div class="col-lg-3">
                  <label class="obligatorio" for="direccion">Direccion</label>
                  <input id="direccion" class="form-control input-font"></label>
                </div>
                <div class="col-lg-3">
                  <label class="obligatorio" for="telefono">Celular o Telefono</label>
                  <input id="telefono" class="form-control input-font solo-numero"></label>
                </div>

                <div class="col-lg-4">
                  <label for="email">Email</label>
                  <input id="email" class="form-control input-font"></label>
                  <p style="font-size: 13px; color: red">*A este email llegará la cotización en PDF</p>
                </div>
                <div class="col-lg-3">
                  <label class="obligatorio" for="quien">Para quién son los servicios?</label>

                  <select  id="quien" class="form-control input-font">
                    <option value="0">Seleccionar</option>
                    <option value="1">Para el solicitante</option>
                    <option value="2">Para otra(s) persona(s)</option>
                    <option value="3">PARA UN GRUPO</option>
                  </select>
                </div>
                <div class="contact col-lg-2">
                  <label for="contacto">Contacto</label>
                  <input type="text" id="contacto" class="form-control input-font" placeholder="Ingresa el nombre del solicitante">
                </div>
                <div class="col-lg-4">

                  <label class="obligatorio" for="asunto">Asunto</label>
                  <input id="asunto" class="form-control input-font"></label>
                  <!--<p style="font-size: 10px">*El Asunto por defecto será <b>COTIZACIÓN N° 123</b>, más lo que agregues en este campo</p>-->
                </div>
                <div class="col-lg-1">

                  <label for="pdf_soat">Soporte PDF:</label>
                  <input id="pdf_soporte" accept="application/pdf" class="pdf_soporte" type="file" value="Subir" name="pdf_soporte">
                </div>
                <div class="col-lg-2 hidden">
                  <label class="obligatorio" for="tipo">Tipo</label>
                  <select  id="tipo" class="form-control input-font">
                    <option value="0">-</option>
                    <option selected value="1">TRANSPORTE</option>
                    <option value="2">PLAN TURISTICO</option>
                    <option value="3">AMBAS</option>
                  </select>
                </div>
                <div class="col-lg-3 hidden">
                  <label class="obligatorio" for="vendedor">Vendedor</label>
                  <input disabled id="vendedor" class="form-control input-font" type="text" value="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
                </div>
			</div>
			<div class="row col-lg-12" style="margin-top: 5px;">

        <div class="col-lg-12" style="margin-top: 5px;">
        <p style="margin-top: 25px;">¿Qué quieres cotizar?</p>
        <a id="agregar_ruta" style="margin-top: 10px" data-toggle="modal" class="btn btn-default btn-icon" data-target=".mymodal">Agregar Traslados<i class="fa fa-plus icon-btn"></i></a>
        <br><br>
        <input type="checkbox" id="no_mostrar" name="no_mostrar" class="no_mostrar">
        <label for="vehicle1" style="color: red; font-size: 18px"> No mostrar el total cotizado </label>
        <br>
				<table style="margin-bottom: 0" class="table table-hover table-bordered" id="tbcotizaciones">
					<thead>
						<tr align="center">
							<td>#</td>
							<td>FECHA SERVICIO</td>
							<td>TRAYECTO</td>
							<td>NOTA</td>
							<td>CIUDAD</td>
							<td>TIPO DE VEHICULO</td>
							<td># PAX</td>
							<td># VEHICULOS</td>
							<td>VALOR TRAYECTO POR VEHICULO</td>
							<td>VALOR TOTAL</td>

							<td></td>
						</tr>
					</thead>
					<tbody id="servicios_otros">
					</tbody>
				</table>
      </div>
				<div class="col-lg-12" >
					<div style="margin-left:750px; margin-top: 10px; float: left;" class="input-font total content-facturado">
						<label style="margin-bottom: 0">TOTAL $</label>
						<label style="color: #F47321; font-size: 15px; margin-left: 20px; margin-bottom: 0" id="total_general">0</label>
					</div>
				</div><br/>

			</div>
			<div class="row">
                <div class="col-lg-12" style="margin-top: 25px">

                    <label for="observaciones">Observaciones Generales de la Cotización</label>

					<textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>

                </div>

                <div class="col-lg-2" style="margin-top: 25px;">
                  <label for="cantidad_v" >Fotos de Vehículos</label>
                  <select name="cantidad_v" id="cantidad_v" class="form-control input-font">
                    <option value="0">Seleccionar</option>
                    <option value="1">1</option>
                    <!--<option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>-->
                  </select>
                </div>

                <div class="row col-lg-12" style="margin-top: 25px;">

                <div class="col-lg-6 1 hidden" style="margin-top: 5px;">

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Descripción Vehículo</label>
                      <input type="text" class="form-control input-font" id="desv1">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 1</label>
                      <input type="text" class="form-control input-font" id="c1v1">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 2</label>
                      <input type="text" class="form-control input-font" id="c2v1">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 3</label>
                      <input type="text" class="form-control input-font" id="c3v1">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="margin-top: 20px">
                      <input id="input-44" name="archivos[]" type="file" multiple class="file-loading">
                      <span>Inserta aquí las imágenes de los Vehículos.<br><hr></span>
                    </div>
                  </div>

                </div>

                <div class="col-lg-6 2 hidden" style="margin-top: 5px;">

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Descripción Vehículo</label>
                      <input type="text" class="form-control input-font" id="desv2">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 1</label>
                      <input type="text" class="form-control input-font" id="c1v2">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 2</label>
                      <input type="text" class="form-control input-font" id="c2v2">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 3</label>
                      <input type="text" class="form-control input-font" id="c3v2">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="margin-top: 20px">
                      <input id="input-45" name="archivos2[]" type="file" multiple class="file-loading">
                      <span>Inserta aquí las imágenes del Vehículo 2.<br><hr></span>
                    </div>
                  </div>

                </div>

                <div class="col-lg-6 3 hidden" style="margin-top: 5px;">

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Descripción Vehículo</label>
                      <input type="text" class="form-control input-font" id="desv3">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 1</label>
                      <input type="text" class="form-control input-font" id="c1v3">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 2</label>
                      <input type="text" class="form-control input-font" id="c2v3">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 3</label>
                      <input type="text" class="form-control input-font" id="c3v3">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="margin-top: 20px">
                      <input id="input-46" name="archivos3[]" type="file" multiple class="file-loading">
                      <span>Inserta aquí las imágenes del Vehículo 3.<br><hr></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 4 hidden" style="margin-top: 5px;">

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Descripción Vehículo</label>
                      <input type="text" class="form-control input-font" id="desv4">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 1</label>
                      <input type="text" class="form-control input-font" id="c1v4">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 2</label>
                      <input type="text" class="form-control input-font" id="c2v4">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 3</label>
                      <input type="text" class="form-control input-font" id="c3v4">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="margin-top: 20px">
                      <input id="input-47" name="archivos4[]" type="file" multiple class="file-loading">
                      <span>Inserta aquí las imágenes del Vehículo 4.<br><hr></span>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 5 hidden" style="margin-top: 5px;">

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Descripción Vehículo</label>
                      <input type="text" class="form-control input-font" id="desv5">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 1</label>
                      <input type="text" class="form-control input-font" id="c1v5">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 2</label>
                      <input type="text" class="form-control input-font" id="c2v5">
                    </div>

                    <div class="col-lg-4">
                      <label for="n_vehiculos" >Característica 3</label>
                      <input type="text" class="form-control input-font" id="c3v5">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12" style="margin-top: 20px">
                      <input id="input-48" name="archivos5[]" type="file" multiple class="file-loading">
                      <span>Inserta aquí las imágenes del Vehículo 5.<br><hr></span>
                    </div>
                  </div>
                </div><br/>

              </div>


                <div class="col-lg-12" style="margin-top: 15px">
                    @if(isset($permisos->comercial->cotizaciones->crear))
                        @if($permisos->comercial->cotizaciones->crear==='on')
                            <button type="button" disabled class="btn btn-primary btn-icon disabled" id="save_cotizacion">GUARDAR Y ENVIAR<i class="fa fa-send icon-btn"></i></button>
                            <button type="button" class="btn btn-success btn-icon hidden" id="guardando">GENERANDO COTIZACIÓN <i class="fa fa-spinner fa-spin icon-btn"></i></button>
                        @else
                            <button type="button" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                    @endif

                    <!--<button type="button" class="btn btn-info btn-icon" id="sumar">SUMAR<i class="fa fa-plus icon-btn"></i></button>
                    <button type="button" class="btn btn-info btn-icon" id="multiplicar">MULTIPLICA<i class="fa fa-close icon-btn"></i></button>-->
                </div>
			</div>
			</form>
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
			<form id="formulario_servicio">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
						<h4 class="modal-title">Agregar Traslados</h4>
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
							<div class="col-xs-2">
								<label for="Ciudades" >Ciudades</label>
								<select name="ciudades" id="ciudades" class="form-control input-font">

									@foreach($ciudades as $ciudad)
										<option>{{$ciudad->ciudad}}</option>
									@endforeach
								</select>
							</div>

							<div class="col-xs-2">
								<label for="t_vehiculo" >Tipo Vehiculo</label>
								<select name="t_vehiculo" id="t_vehiculo" class="form-control input-font">
									<option>CAMIONETA</option>
									<option>MINIVANS</option>
									<option>VANS</option>
									<option>MICROBUS</option>
									<option>BUSETA</option>

								</select>
							</div>
							<div class="col-xs-4">
								<label for="t_servicio" >Trayecto</label>
								<select name="t_servicio" id="t_servicio" class="form-control input-font">

								</select>
                <p class="trayect" style="font-size: 11px; color: red; float: left">Añadir un Trayecto <i class="fa fa-plus crear_trayecto" aria-hidden="true"></i></p>
							</div>

						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-xs-2">
								<label for="pax" ># PAX</label>
								<input type="text" class="form-control input-font solo-numero" id="pax">
                <p class="cantidad hidden" style="font-size: 11px; color: red; float: left"></p>
							</div>
							<div class="col-xs-1">
								<label for="n_vehiculos" >Vehiculos</label>
								<input type="text" class="form-control input-font solo-numero" id="n_vehiculos">
							</div>
							<div class="col-xs-2">
								<label for="valor_trayecto" >Valor Trayecto Unitario</label>
								<input type="text" class="form-control input-font solo-numero" id="valor_trayecto">
                <p class="sin_tarifa hidden" style="font-size: 11px; color: red; float: right">*Sin Tarifa. Agrega un Valor</p>
							</div>
							<div class="col-xs-2">
								<label for="valor_total" >Valor Total</label>
								<input type="text" class="form-control input-font solo-numero" id="valor_total">
							</div>
              <div class="col-xs-3">
								<label for="descripcion" >Nota</label>
								<input type="text" class="form-control input-font" id="descripcion">
							</div>
						</div>
            <br>
            <hr>
            <div class="row trayecto_nuevo hidden" >
              <div class="col-xs-12">
                <p><b>NUEVO TRAYECTO</b></p>
              </div>
              <div class="col-xs-3">
								<label for="descripcion" >Nombre del Trayecto</label>
								<input type="text" class="form-control input-font" id="nombre_trayecto" placeholder="Ingresa el nombre del trayecto">
							</div>
              <div class="col-xs-3">
								<label for="descripcion" >Tarifa Cliente</label>
								<input type="text" class="form-control input-font" id="tarifa_cliente" placeholder="Ingresa Tarifa Cliente">
							</div>
              <div class="col-xs-3">
								<label for="descripcion" >Tarifa Proveedor</label>
								<input type="text" class="form-control input-font" id="tarifa_proveedor" placeholder="Ingresa Tarifa Proveedor">
							</div>
              <div class="col-xs-3">
                <label for="descripcion" >Guardar y Asignar Trayecto</label>
                <a class="btn btn-primary btn-icon" id="nuevo_trayecto" >Guardar Trayecto<i class="fa fa-check icon-btn" ></i></a>
              </div>
            </div>
            <hr>
						</form>
					</div>
					<div class="modal-footer" >
						<a class="btn btn-success btn-icon" id="agregar_items" >AGREGAR<i class="fa fa-check icon-btn" ></i></a>
						<a class="btn btn-success btn-icon hidden" id="mod_items" >MODIFICAR<i class="fa fa-check icon-btn" ></i></a>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/cotizaciones.js')}}" type="text/javascript"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <!--<script src="{{url('tinymce_4.4.1\tinymce\js\tinymce\tinymce.min.js')}}"></script>
  <script src="{{url('tinymce_4.4.1\tinymce\editor.js')}}"></script>-->

  <!--<script type="text/javascript">
  editor_config.selector = "textarea";
  tinymce.init(editor_config);
  </script>-->

  <script>
    $(document).on('ready', function() {

      $("#input-44").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-45").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-46").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-47").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-48").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-49").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-50").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

      $("#input-51").fileinput({
          uploadUrl: '/file-upload-batch/2',
          maxFilePreviewSize: 10240
      });

    });

    $('#nuevo_trayecto').click(function(){

      var nombre = $('#nombre_trayecto').val().toUpperCase();
      var cliente = $('#tarifa_cliente').val();
      var proveedor = $('#tarifa_proveedor').val();
      var cc = $('#centrodecosto_search').val();
      var vehiculo = $('#t_vehiculo').val();
      var ciudad = $('#ciudades').val();

      var ids = null;

      console.log(nombre)
      console.log(cliente)
      console.log(proveedor)
      console.log(cc)
      console.log(vehiculo)
      console.log(ciudad)

      $.ajax({
        url: 'cotizaciones/nuevotrayecto',
        method: 'post',
        data: {nombre: nombre, cliente: cliente, proveedor: proveedor, cc: cc, vehiculo: vehiculo, ciudad: ciudad}
      }).done(function(data){


        //$('#seen').html('Estás viendo '+month.toUpperCase())
        //$('.menus').addClass('hidden');

        if(data.respuesta==true){

          alert('Trayecto creado exitosamente')

          ids = data.traslado;

          $.ajax({
      			url: 'cotizaciones/buscartarifa',
      			method: 'post',
      			data: {'tipo_serv': data.traslado, 'tipo_veh':vehiculo, 'cc': cc},
      			success: function(data){
      				if(data.mensaje===false){
                $('#valor_trayecto').val('');
                $('#valor_total').val('');
                $('.sin_tarifa').removeClass('hidden');
      				}else if(data.mensaje===true){
      					if(!($('.errores-modal').hasClass('hidden'))){
      					  $('.errores-modal').addClass('hidden');
      					}

      					$('#n_vehiculos').val('1');
      					$('#valor_trayecto').val(data.cotizacion_re[0].tarifa);
      					$('#valor_total').val(data.cotizacion_re[0].tarifa);
                $('.sin_tarifa').addClass('hidden');


      				}else if(data.mensaje==='relogin'){
      				  location.reload();
      				}else{
      					$('.errores-modal ul li').remove();
      					$('.errores-modal').addClass('hidden');
      				}
      			}
      		});

          //trayecto

          var url = $('meta[name="url"]').attr('content');

          $.ajax({
            url: url+'/cotizaciones/tiposervicios',
            method: 'post',
            data: {
              'ciudad': ciudad
            },
            success: function(data2){

              if(data2.mensaje===false){

                //$('#ruta').find('option').remove().end();

              }else if(data2.mensaje===true){

                //$('#agregar_ruta').removeClass('hidden');
                //alert('true')

                $('#t_servicio').find('option').remove().end();

                for(j in data2.tipo_servicio){
                  $('#t_servicio').append('<option value="'+data2.tipo_servicio[j].id+'">'+data2.tipo_servicio[j].nombre+'</option>');
                }

                $('#t_servicio').val(ids);

                $('.trayecto_nuevo').addClass('hidden');

                $('#nombre_trayecto').val('');
                $('#tarifa_cliente').val('');
                $('#tarifa_proveedor').val('');

              }

            }

          });

        }else if(data.respuesta==false){

          $('.products-row').html('');

          $('#sin_datos').removeClass('hidden');
          $('#sin_datos').html('Oops! Parece que no hay datos en el mes seleccionado.');

        }

      });


    });

    $('.crear_trayecto').click(function(){

      $('.trayecto_nuevo').removeClass('hidden');


    });

    $('#quien').change(function () {

        var valor = $(this).val();
        console.log(valor);
        if(valor==3){
          $('#asunto').val('GRUPO');
        }else if(valor==1){
          $('.contact').removeClass('hidden');
        }else{
          $('#asunto').val('');
        }

    });

    $('#cantidad_v').change(function() {

      var num = $(this).val();

      for (var i = 1; i <= 8; i++) {
        if(num>=i){
          $('.'+i+'').removeClass('hidden');
        }else{
          $('.'+i+'').addClass('hidden');
        }
      }

      //$('.'+num+'').removeClass()

      //alert(num);

    });



      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();



  </script>
  </body>
</html>
