<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Hoja de Vida Vehiculos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    @include('scripts.styles')
</head>
<body>
@include('admin.menu')
    <div class="container">
      <h2 class="h_titulo">Hoja de Vida Vehiculo </h2>
      <div class="col-lg-18" style="margin-bottom: 5px">
        <h4 style="border-bottom: 1px dashed #CCCCCC;">{{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
      </div>
      <!-- INFO VEHICULO -->
      <div class="col-lg-18" style="margin-bottom: 5px;">
		<div class="row" style="border-bottom: 1px dashed #CCCCCC;">
			<div class="col-xs-1">
				<strong># Aotour:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->numero_interno}}</span>
			</div>

			<div class="col-xs-1">
				<strong>Marca:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->marca}}</span>
			</div>

			<div class="col-xs-1">
				<strong># Motor:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->numero_motor}}</span>
			</div>
			<div class="col-xs-1">
				<strong>Año:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->ano}}</span>
			</div>
			<div class="col-xs-1">
				<strong>Afiliada:</strong>
			</div>
			<div class="col-xs-3">
				<span>{{$vehiculo->empresa_afiliada}}</span>
			</div>
		</div>

      </div>

      <div class="col-lg-18" style="margin-bottom: 10px">
		<div class="row" style="border-bottom: 1px dashed #CCCCCC;">
			<div class="col-xs-1">
				<strong>Clase:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->clase}}</span>
			</div>

			<div class="col-xs-1">
				<strong>Color:</strong>
			</div>
			<div class="col-xs-2">
				<span>{{$vehiculo->color}}</span>
			</div>
			<div class="col-xs-1">
				<strong>Modelo:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->modelo}}</span>
			</div>

			<div class="col-xs-1">
				<strong>CC.Propietario:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->cc}}</span>
			</div>
			<div class="col-xs-1">
				<strong>Propietario:</strong>
			</div>
			<div class="col-xs-2">
				<span>{{$vehiculo->propietario}}</span>
			</div>
		</div>

      </div>

      <div class="col-lg-18" style="margin-bottom: 10px">
		<div class="row" style="border-bottom: 1px dashed #CCCCCC;">
			<div class="col-xs-1">
				<strong>Capacidad:</strong>
			</div>
			<div class="col-xs-1">
				<span>{{$vehiculo->capacidad}}</span>
			</div>
			<div class="col-xs-1">
				<strong>T.Operacion:</strong>
			</div>
			<div class="col-xs-2">
				<span>{{$vehiculo->tarjeta_operacion}}</span>
			</div>
			<div class="col-xs-1">
				<strong>Cilindraje:</strong>
			</div>
			<div class="col-xs-1">
				<span>@if($vehiculo->cilindraje != null)
						  {{$vehiculo->cilindraje}}
						@else
						  N/A
					  @endif</span>
			</div>
			<div class="col-xs-1">
				<strong># VIN:</strong>
			</div>
			<div class="col-xs-3">
				<span>@if($vehiculo->numero_vin != null)
						  {{$vehiculo->numero_vin}}
						@else
						  N/A
					  @endif</span>
			</div>
		</div>
      </div>
<br/>
        <ul class="nav nav-tabs" >
          <li class="active"><a href="#DatosGenerales" data-toggle="tab">DATOS GENERALES</a></li>
          <li><a href="#progmantenimiento" data-toggle="tab">PROGRAMACION DE MANTENIMIENTO</a></li>
           <li><a href="#histomantenimiento" data-toggle="tab">HISTORIAL DE MANTENIMIENTO</a></li>
          <!--<li><a href="#controlcombustible" data-toggle="tab">CONTROL DE COMBUSTIBLE</a></li>
          <li><a href="#gastosvehiculo" data-toggle="tab">GASTOS DEL VEHICULO</a></li> -->
        </ul>

      <div class="tab-content" style="margin-top: 10px;">
        <div class="tab-pane fade in active" id="DatosGenerales" style="margin-top: 10px;">

          <!-- IMAGENES VEHICULOS -->
          <h4 class="h_titulo">Imagenes del Vehiculo:</h4>
          <div class="panel-body" style="border: 1px">
            <div id="lista_imagenes">

            </div>

              <form class="dropzone" id="my-dropzone">
                  <input type="hidden" name="id" value="{{$id}}" id="id_vehiculo">
                  <div class="dz-message" data-dz-message><span>Sube Las Imagenes Del Vehiculo</span></div>
              </form>

              <button class="btn btn-redu btn-icon" id="subir">SUBIR ARCHIVOS jpeg,bmp,png<i class="fa fa-upload icon-btn"></i></button>
          </div>


          <!-- DOCUMENTACION VEHICULOS -->
          @include('hvvehiculos.hvdocumentacion')

          <!-- CONDUCTORES VEHICULOS -->
          @include('hvvehiculos.hvconductores')

          <!-- COMPARENDOS VEHICULOS -->
          @include('hvvehiculos.hvcomparendos')

          <!-- SUCESOS VEHICULOS -->
          @include('hvvehiculos.hvsucesos')


        </div>
        <div class="tab-pane fade" id="progmantenimiento" >
            <div style="overflow-y: auto; height: 420px;">
                <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
                  <thead>
                      <tr>
                          <th colspan="2"> </th>
                          @foreach($mantenimiento_kilometraje as $mtm_kilometraje)
                              <th>{{$mtm_kilometraje->kilometraje}}</th>
                          @endforeach

                      </tr>

                  </thead>

                  <tbody>
                      @foreach($mantenimiento_operacion as $mtm_operacion)
                          <tr>
                              <th>{{$mtm_operacion->id}}</th>
                              <th>{{$mtm_operacion->item}}</th>
                          </tr>    
                      @endforeach
                  </tbody>

                </table>
            </div>
            <div style="margin-bottom: 20px;"><br/>
                <button type="button" class="btn btn-default btn-icon agregar_revision" data-toggle="modal" data-target=".mymodaladmatm" >Agregar<i class="fa fa-plus icon-btn"></i></button>
            </div>
            
            <div class="modal fade mymodaladmatm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg">
                    <form id="formulario_revision">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                                <h4 class="modal-title">NUEVA REVISION {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>

                            </div>
                            <div class="modal-body">
                                <div class="col-xs-10">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="tipo_documento">Kilometraje Control</label>
                                                <select class="form-control input-font" id="km_control">
                                                    <option>-</option>
                                                      @foreach($mantenimiento_kilometraje as $mtm_kilometraje_control)
                                                          <option value='{{$mtm_kilometraje_control->id}}'>{{$mtm_kilometraje_control->kilometraje}}</option>
                                                      @endforeach

                                                </select>

                                            </div>
                                            
                                            <div class="col-xs-3" id="container_frev">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="fecha_revision" >Fecha Revision</label>
                                                    <div class='input-group date' id='datetimepickerhv7'>
                                                        <input type='text' class="form-control input-font" id="fecha_revision" value="{{date('Y-m-d')}}">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-3">
                                                <label  for="km_recorrido">Kilometraje Recorrido</label>
                                                <input type="text" class="form-control input-font" id="km_recorrido">
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="row" style="overflow-y: auto; height: 500px;">
                                            <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>OPERACION</th>
                                                    <th style="width: 70px">REALIZADO</th>
                                                   
                                                    <th style="width: 100px">ESTADO</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($mantenimiento_operacion as $mtm_operacion_control)
                                                    <tr>
                                                        <td>{{$mtm_operacion_control->id}}</td>
                                                        <td>{{$mtm_operacion_control->item}}</td>
                                                        <td align="center"><input type="checkbox" name="realizado1" id="realizado1"></td>
                                                        
                                                        <td><div id='km_estado' style="border: 1px solid; height: 30px;"></div></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                        </div>

                                    </div>


                            </div>
                            <div class="modal-footer">
                                <div class="col-xs-12"><br/>
                                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarev" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </form>
                </div><!-- /.modal-dialog -->
            </div>
        </div>


        <div class="tab-pane fade" id="histomantenimiento">
            <!-- LISTADO DE MANTENIMIENTOS DE VEHICULOS -->
          @include('hvvehiculos.hvhistorial')
        </div>
        <!--<div class="tab-pane fade" id="controlcombustible">Control Combustible en proceso...</div>
        <div class="tab-pane fade" id="gastosvehiculo">Gastos de Vehiculo en proceso...</div> -->
      </div>

      <div class="errores-modal bg-danger text-danger hidden model">
          <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
          <ul>
          </ul>
      </div>

      <div class="guardado bg-success text-success hidden model">
          <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
          <ul style="margin: 0;padding: 0;">
          </ul>
      </div>



    </div>

    <script>
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 1,
            maxFiles: 4,
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: '../../proveedores/subirimagenes',
            init: function() {
                var submitBtn = document.querySelector("#subir");

                myDropzone = this;
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("addedfile", function(file) {

                });
                this.on("complete", function(file) {

                });
                myDropzone.on("success", function(file, response) {
                    if(response.mensaje===true){
                        $(file.previewElement).fadeOut({
                            complete: function() {
                                // If you want to keep track internally...
                                myDropzone.removeFile(file);
                            }
                        });
                        alert(response.respuesta);
                    }else if(response.mensaje===false){
                        alert(response.respuesta);
                    }

                });
            }
        };

    </script>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/hvvehiculos.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
  </body>
</html>
