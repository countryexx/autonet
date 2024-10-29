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
        <h4 >{{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
      </div>
      <!-- INFO VEHICULO -->
      <div class="col-lg-18" style="margin-bottom: 5px">
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

      <div class="col-lg-18" style="margin-bottom: 10px">

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

      <div class="col-lg-18" style="margin-bottom: 10px">
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
            <span><?php if($vehiculo->numero_vin != null){$vehiculo->cilindraje;}else{echo "n/a";} ?></span>
        </div>
        <div class="col-xs-1">
            <strong># VIN:</strong>
        </div>
        <div class="col-xs-3">
            <span><?php if($vehiculo->numero_vin != null){$vehiculo->numero_vin;}else{echo "n/a";} ?></span>
        </div>


      </div>

        <ul class="nav nav-tabs" >
          <li class="active"><a href="#DatosGenerales" data-toggle="tab">Datos Generales</a></li>
          <li><a href="#DocumentosVehiculos" data-toggle="tab">Documentacion Vehiculos</a></li>
          <li><a href="#ConductoresAsignados" data-toggle="tab">Conductores Asignados</a></li>
          <li><a href="#Comparendos" data-toggle="tab">Comparendos</a></li>
          <li><a href="#IncidentesoAccidentes" data-toggle="tab">Incidentes o Accidentes</a></li>
        </ul>

      <div class="tab-content" >
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

              <button class="btn btn-redu btn-icon" id="subir">SUBIR ARCHIVOS<i class="fa fa-upload icon-btn"></i></button>
          </div>


          <!-- DOCUMENTACION VEHICULOS -->
          @include('hvdocumentacion')

          <!-- CONDUCTORES VEHICULOS -->
          <h4 class="h_titulo">Conductores</h4>
          <div id="conductorestable" style="margin-bottom: 10px;">
            <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
              <thead>
                <tr>
                  <th>NOMBRE COMPLETO</th>
                  <th>DESDE</th>
                  <th>HASTA</th>

                  <th style="width: 100px"></th>
                </tr>

              </thead>

              <tbody>
                @foreach($hojavida_conductores as $conductor_vehiculos)
                <tr >
                  <td>{{$conductor_vehiculos->conductor_id}}</td>
                  <td>{{$conductor_vehiculos->fecha_inicial}}</td>
                  <td>{{$conductor_vehiculos->fecha_final}}</td>
                  <td >
                    <input type="hidden" name="id_conductorhv" value="{{$conductor_vehiculos->id}}" id="id_conductorhv">
                    <a id="editar_hvdoc" class="btn btn-success btn-icon fa fa-pencil icon-btn"> </a>
                    <a id="eliminar_hvdoc" class="btn btn-danger btn-icon fa fa-times icon-btn"> </a>
                  </td>

                </tr>
                @endforeach
              </tbody>

            </table>

            <button type="button" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></button>
          </div>

          <!-- COMPARENDOS VEHICULOS -->
          <h4 class="h_titulo">Comparendos</h4>
          <div id="comparendostable" style="margin-bottom: 10px;">
            <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
              <thead>
                <tr>
                  <th>NUMERO COMPARENDO</th>
                  <th>CAUSAL</th>
                  <th>FECHA</th>
                  <th>DETALLE</th>
                  <th>VALOR</th>
                  <th>NUMERO DE DESCARGUE</th>
                  <th> </th>

                  <th style="width: 100px;"></th>
                </tr>

              </thead>

              <tbody>
                @foreach($hojavida_comparendos as $comparendos)
                <tr >
                  <td>{{$comparendos->numero_comparendo}}</td>
                  <td>{{$comparendos->causal}}</td>
                  <td>{{$comparendos->fecha_comparendo}}</td>
                  <td>{{$comparendos->detalle_comparendo}}</td>
                  <td>{{$comparendos->valor_comparendo}}</td>
                  <td>{{$comparendos->numero_descargue}}</td>
                  <td >
                    <input type="hidden" name="id_comparendohv" value="{{$comparendos->id}}" id="id_comparendohv">
                    <a id="editar_hvdoc" class="btn btn-success btn-icon fa fa-pencil icon-btn"> </a>
                    <a id="eliminar_hvdoc" class="btn btn-danger btn-icon fa fa-times icon-btn"> </a>
                  </td>

                </tr>
                @endforeach
              </tbody>

            </table>

            <button type="button" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></button>
          </div>

          <!-- SUCESOS VEHICULOS -->
          <h4 class="h_titulo">Insidencias - Acidentes</h4>
          <div id="sucesotable" style="margin-bottom: 10px;">
            <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
              <thead>
                <tr>
                  <th>SUCESO</th>
                  <th>FECHA</th>
                  <th>CONDUCTOR</th>
                  <th>CLIENTE SERVICIO</th>
                  <th>CONSECUENCIAS</th>
                  <th>DESCRIPCION</th>

                  <th style="width: 100px;"></th>
                </tr>

              </thead>

              <tbody>
                @foreach($hojavida_suceso as $suceso)
                <tr >
                  <td>{{$suceso->suceso}}</td>
                  <td>{{$suceso->fecha_suceso}}</td>
                  <td>{{$suceso->conductor_id}}</td>
                  <td>{{$suceso->centrosdecosto_id}}</td>
                  <td>{{$suceso->consecuencia}}</td>
                  <td>{{$suceso->descripcion_suceso}}</td>
                  <td >
                    <input type="hidden" name="id_sucesohv" value="{{$suceso->id}}" id="id_sucesohv">
                    <a id="editar_hvdoc" class="btn btn-success btn-icon fa fa-pencil icon-btn"> </a>
                    <a id="eliminar_hvdoc" class="btn btn-danger btn-icon fa fa-times icon-btn"> </a>
                  </td>

                </tr>
                @endforeach
              </tbody>

            </table>

            <button type="button" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></button>
          </div>



        </div>
        <div class="tab-pane fade" id="DocumentosVehiculos" >
          <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
            <thead>
              <tr>
                <th>TIPO DOCUMENTO</th>
                <th>EMPRESA QUE EMITE</th>
                <th>NUMERO DEL DOCUMENTO</th>
                <th>FECHA EMISION</th>
                <th>FECHA VENCIMIENTO</th>
                <th >DIAS RESTANTES</th>
                <th>VALOR</th>
                <th style="width: 100px;"></th>
              </tr>

            </thead>

            <tbody>

              <tr >
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td >
                  <a id="editar_hvdoc" class="btn btn-success btn-icon fa fa-pencil icon-btn"> </a>
                  <a id="eliminar_hvdoc" class="btn btn-danger btn-icon fa fa-times icon-btn"> </a>
                </td>

              </tr>

            </tbody>

          </table>
        </div>


        <div class="tab-pane fade" id="ConductoresAsignados">listado de conductores</div>
        <div class="tab-pane fade" id="Comparendos">listado comparendos</div>
        <div class="tab-pane fade" id="IncidentesoAccidentes">listado de incidentes o accidentes.</div>
      </div>



    </div>

    <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <h4 class="modal-title">NUEVO CONDUCTOR</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                  <div class="col-xs-2">
                                      <label class="obligatorio" for="tipo_transporte"># Interno</label>
                                      <input type="text" class="form-control input-font" id="numero_interno">
                                  </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="tipo_transporte">Tipo Transporte</label>
                                        <select class="form-control input-font" id="tipo_transporte">
                                            <option>-</option>
                                            <option>PRIVADO</option>
                                            <option>PUBLICO</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="placa">Placa</label>
                                        <input type="text" class="form-control input-font" id="placa">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="numero_motor">Numero del Motor</label>
                                        <input type="text" class="form-control input-font" id="numero_motor">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="clase">Clase</label>
                                        <select class="form-control input-font" id="clase">
                                            <option>-</option>
                                            <option>AUTOMOVIL</option>
                                            <option>CAMIONETA</option>
                                            <option>BUSETA</option>
                                            <option>BUS</option>
                                            <option>MICROBUS</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="marca">Marca</label>
                                        <input type="text" class="form-control input-font" id="marca">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="modelo">Linea</label>
                                        <input type="text" class="form-control input-font" id="modelo">
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <label for="anos" class="obligatorio">Modelo</label>
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="anos">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="capacidad">Capacidad</label>
                                        <input type="text" class="form-control input-font" id="capacidad">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="color">Color</label>
                                        <input class="form-control input-font" type="text" id="color">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="propietario">Propietario del Vehiculo</label>
                                        <input class="form-control input-font" type="text" id="propietario">
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="cc">C.C</label>
                                                <input class="form-control input-font" type="text" id="cc">
                                            </div>
                                            <div class="col-xs-3" id="container_empresa_afiliada">
                                                <label for="empresa_afiliada">Empresa afiliada</label>
                                                <select type="text" class="form-control input-font" id="empresa_afiliada">
                                                  <option value="0">-</option>
                                                  <option value="1">AOTOUR</option>
                                                  <option value="2">OTRO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-3 cual_empresa hidden">
                                                <label for="cual_empresa">Cual?</label>
                                                <input type="text" class="form-control input-font" id="cual_empresa">
                                            </div>
                                            <div class="col-xs-3" id="container_tarjeta_operacion">
                                                <label for="tarjeta_operacion">Tarjeta de Operacion</label>
                                                <input type="text" class="form-control input-font" id="tarjeta_operacion">
                                            </div>
                                            <div class="col-xs-3" id="container_vigencia">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="fecha_vigencia_operacion" class="obligatorio">Fecha de Vigencia</label>
                                                    <div class='input-group date' id='datetimepicker2'>
                                                        <input type='text' class="form-control input-font" id="fecha_vigencia_operacion">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="fecha_vigencia_soat" class="obligatorio">Vigencia del Soat</label>
                                                    <div class='input-group date' id='datetimepicker3'>
                                                        <input type='text' class="form-control input-font" id="fecha_vigencia_soat">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="fecha_vigencia_tecnomecanica">Vigencia de tecnomecanica</label>
                                                    <div class='input-group date' id='datetimepicker4'>
                                                        <input type='text' class="form-control input-font" id="fecha_vigencia_tecnomecanica">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label class="obligatorio" for="mantenimiento_preventivo">Mantenimiento Preventivo</label>
                                                    <div class='input-group date' id='datetimepicker5'>
                                                        <input type='text' class="form-control input-font" id="mantenimiento_preventivo">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="poliza_todo_riesgo" class="obligatorio">Poliza contra todo riesgo</label>
                                                    <div class='input-group date' id='datetimepicker6'>
                                                        <input type='text' class="form-control input-font" id="poliza_todo_riesgo">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3" id="container_contractual">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="poliza_contractual" class="obligatorio">Poliza contractual</label>
                                                    <div class='input-group date' id='datetimepicker7'>
                                                        <input type='text' class="form-control input-font" id="poliza_contractual">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3" id="container_extracontractual">
                                                <div class="form-group" style="margin-bottom: 0px;">
                                                    <label for="poliza_extracontractual" class="obligatorio">Poliza extracontractual</label>
                                                    <div class='input-group date' id='datetimepicker8'>
                                                        <input type='text' class="form-control input-font" id="poliza_extracontractual">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label for="observaciones">Observaciones</label>
                                                <textarea class="form-control input-font" id="observaciones" rows="1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" data-id="{{$id}}" id="guardar" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
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

    <script>
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 4,
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
    <script src="{{url('jquery/')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
  </body>
</html>
