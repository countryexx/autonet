<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Conductores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
  @include('admin.menu')

  <div class="col-lg-12">

      <h3 class="h_titulo">CONDUCTORES | {{$nombre_razonsocial}}</h3>
      @if(isset($conductores))
          <table id="example" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Nombre Completo</th>
                  <th>Celular</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Tipo Licencia</th>
                  <th>Detalles</th>
              </tr>
              </thead>

              <tfoot>
              <tr>
                  <th>#</th>
                  <th>Nombre Completo</th>
                  <th>Celular</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Tipo Licencia</th>
                  <th>Detalles</th>
              </tr>
              </tfoot>
              <tbody>
              @foreach($conductores as $conductor)
                  <tr @if($conductor->bloqueado_total!=null){{'class="danger"'}}@elseif($conductor->bloqueado!=null){{'class="warning"'}}@endif>
                      <td>{{$i++}}</td>
                      <td>{{$conductor->nombre_completo}} 

                        @if($conductor->bloqueado_total!=null)
                          
                          <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">@if($conductor->genero==='MASCULINO'){{'BLOQUEADO'}}@else{{'BLOQUEADA'}}@endif TOTAL</div>

                        @elseif($conductor->bloqueado!=null)

                          <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">@if($conductor->genero==='MASCULINO'){{'BLOQUEADO'}}@else{{'BLOQUEADA'}}@endif DE USO</div>

                        @endif

                      </td>
                      <td>{{$conductor->celular}}</td>
                      <td>{{$conductor->telefono}}</td>
                      <td>{{$conductor->direccion}}</td>
                      <td>{{$conductor->tipodelicencia}}</td>
                      <td>
                        <a class="btn btn-primary btn-list-table mostrar_conductor" data-toggle="modal" data-target=".mymodal2" data-conductor-id="{{$conductor->id}}" data-proveedor-id="{{$conductor->proveedores_id}}">DETALLES</a>
                        <a class="btn btn-default btn-list-table info_exa_cond" data-toggle="modal" data-target=".mymodal3" data-conductor-id="{{$conductor->id}}" data-proveedor-id="{{$conductor->proveedores_id}}">EXAMENES</a>

                        @if($conductor->bloqueado!=null)
                          
                          <a data-conductor-id="{{$conductor->id}}" class="btn btn-warning btn-list-table desbloqueo_uso" style="width: 75px" data-proveedor-id="{{$conductor->proveedores_id}}">Desbloqueo</a>

                        @else

                          <a data-conductor-id="{{$conductor->id}}" class="btn btn-warning btn-list-table bloqueo_uso" style="width: 75px" data-proveedor-id="{{$conductor->proveedores_id}}">Bloqueo</a>

                        @endif

                        @if($conductor->bloqueado_total!=null)
                          
                          <a class="btn btn-danger btn-list-table desbloqueo_total" style="width: 75px" data-conductor-id="{{$conductor->id}}" data-proveedor-id="{{$conductor->proveedores_id}}">Desbloqueo</a>

                        @else

                          <a class="btn btn-danger btn-list-table bloqueo_total" style="width: 75px" data-conductor-id="{{$conductor->id}}" data-proveedor-id="{{$conductor->proveedores_id}}">Bloqueo</a>

                        @endif

                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
      @endif
      @if(isset($permisos->administrativo->proveedores->crear))
          @if($permisos->administrativo->proveedores->crear==='on')
              <button type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">Agregar<i class="fa fa-plus icon-btn"></i></button>
          @else
              <button type="button" class="btn btn-default btn-icon" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
          @endif
      @else
          <button type="button" class="btn btn-default btn-icon" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
      @endif

      <div class="btn-group dropup">
          <button style="padding: 8px" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              ver <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
              <li><a class="tama�o-dropdownmayus" href="../ver/{{$nombre_razonsocial}}">Proveedor <i class="fa fa-car"></i></a></li>
              <li><a class="tama�o-dropdownmayus" href="../vehiculos/{{$id}}">Vehiculos <i class="fa fa-bus"></i></a></li>
          </ul>
      </div>
      <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
  </div>

  <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg-conductores">

              <div class="modal-content">
                <form id="formulario">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                      <h4 class="modal-title">NUEVO CONDUCTOR</h4>
                  </div>

                      <div class="modal-body">
                          <div class="row">
                              <div class="col-xs-2">
                                  <label>Fecha Vinculacion</label>
                                  <div class="input-group">
                                      <div class='input-group date' id='datetimepicker'>
                                          <input type='text' class="form-control input-font" id="fecha_vinculacion">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-2">
                                  <label>Fecha de Nacimiento</label>
                                  <div class="input-group">
                                      <div class='input-group date' id='datetimepicker'>
                                          <input type='text' class="form-control input-font" id="fecha_nacimiento">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="departamento">Departamento</label>
                                  <select class="form-control input-font" id="departamento">
                                      <option>-</option>
                                      @foreach($departamentos as $departamento)
                                          <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                  <select disabled class="form-control input-font" id="ciudad">
                                      <option>-</option>
                                  </select>
                              </div>
                              <div class="col-xs-4">
                                  <label class="obligatorio" for="nombre_completo">Nombre Completo</label>
                                  <input type="text" class="form-control input-font" id="nombre_completo">
                              </div>
                              <div class="col-xs-3">
                                  <label class="obligatorio" for="cc">C.C</label>
                                  <input type="text" class="form-control input-font" id="cc">
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="celular">Celular</label>
                                  <input type="text" class="form-control input-font" id="celular">
                              </div>
                              <div class="col-xs-2">
                                  <label for="telefono">Telefono</label>
                                  <input type="text" class="form-control input-font" id="telefono">
                              </div>
                              <div class="col-xs-3">
                                  <label class="obligatorio" for="direccion">Direccion</label>
                                  <input type="text" class="form-control input-font" id="direccion">
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="tipodelicencia">Tipo de licencia</label>
                                  <select class="form-control input-font" id="tipodelicencia">
                                      <option>-</option>
                                      <option>A1</option>
                                      <option>A2</option>
                                      <option>B1</option>
                                      <option>B2</option>
                                      <option>B3</option>
                                      <option>C1</option>
                                      <option>C2</option>
                                      <option>C3</option>
                                  </select>
                              </div>
                              <div class="col-xs-2">
                                  <label>Fecha de Expedicion</label>
                                  <div class="input-group">
                                      <div class='input-group date' id='datetimepicker'>
                                          <input type='text' class="form-control input-font" id="fecha_licencia_expedicion">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-2">
                                  <label>Fecha de Vigencia</label>
                                  <div class="input-group">
                                      <div class="input-group date" id="datetimepicker">
                                          <input type="text" class="form-control input-font" id="fecha_licencia_vigencia">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-xs-1">
                                  <label class="obligatorio" for="edad">Edad</label>
                                  <input type="text" class="form-control input-font" id="edad">
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="genero">Genero</label>
                                  <select class="form-control input-font" id="genero">
                                      <option>-</option>
                                      <option>MASCULINO</option>
                                      <option>FEMENINO</option>
                                  </select>
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="grupo_trabajo">Grupo de Trabajo</label>
                                  <select class="form-control input-font" id="grupo_trabajo">
                                      <option>-</option>
                                      <option>OPERATIVO</option>
                                  </select>
                              </div>
                              <div class="col-xs-3">
                                  <label class="obligatorio" for="tipo_contrato">Tipo de Contrato</label>
                                  <select class="form-control input-font" id="tipo_contrato">
                                      <option>-</option>
                                      <option>P. DE SERVICIOS</option>
                                  </select>
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="cargo">Cargo</label>
                                  <input type="text" class="form-control input-font" id="cargo">
                              </div>
                              <div class="col-xs-1">
                                  <label class="obligatorio" for="experiencia">Experiencia</label>
                                  <input type="text" class="form-control input-font" id="experiencia">
                              </div>
                              <div class="col-xs-3">
                                  <label class="obligatorio" for="accidentes">Accidentes en 5 a&ntildeos</label>
                                  <select class="form-control input-font" id="accidentes">
                                      <option>-</option>
                                      <option>SI</option>
                                      <option>NO</option>
                                  </select>
                              </div>
                              <div class="col-xs-6">
                                  <label for="descripcion_accidente">Descripcion del Accidente</label>
                                  <textarea rows="1" class="form-control input-font" id="descripcion_accidente"></textarea>
                              </div>
                              <div class="col-xs-12">
                                  <div class="row">
                                      <div class="col-xs-2">
                                          <label class="obligatorio" for="incidentes">Incidentes materiales, no personales</label>
                                          <select class="form-control input-font" id="incidentes">
                                              <option>-</option>
                                              <option>SI</option>
                                              <option>NO</option>
                                          </select>
                                      </div>
                                      <div class="col-xs-3">
                                          <label style="margin-top: 22px;" for="frecuencia_desplazamiento">Frencuencia de Desplazamiento</label>
                                          <input type="text" class="form-control input-font" id="frecuencia_desplazamiento">
                                      </div>
                                      <div class="col-xs-2">
                                          <label class="obligatorio" for="vehiculo_propio_desplazamiento">Vehiculo propio para desplazamiento</label>
                                          <select class="form-control input-font" id="vehiculo_propio_desplazamiento">
                                              <option>-</option>
                                              <option>SI</option>
                                              <option>NO</option>
                                          </select>
                                      </div>
                                      <div class="col-xs-2">
                                          <label class="obligatorio" for="trayecto_casa_trabajo">Trayecto casa - trabajo</label>
                                          <select class="form-control input-font" id="trayecto_casa_trabajo">
                                              <option>-</option>
                                              <option>VEHICULO</option>
                                              <option>OTROS</option>
                                          </select>
                                      </div>
                                      <div class="col-xs-2">
                                          <label style="margin-top: 22px;" for="foto">Insertar Foto</label>
                                          <input type="file" data-filename-placement="inside" name="foto">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">

                      </div>
                    </form>

                    <div class="row" style="margin-bottom: 15px; margin-left: 5px;">
                      <div class="col-lg-3">
                        <input type="number" maxlength="10" class="form-control input-font" id="identification" placeholder="Ingrese cédula para buscar">
                      </div>
                      <div class="col-lg-9">
                        <button style="float: right; margin-left: 5px; margin-right: 5px;" type="submit" data-id="{{$id}}" id="guardar" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                          <a style="float: right;" data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                      </div>
                    </div>
              </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->
  </div>

  <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg-conductores-edicion">
          <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">PERFIL DEL CONDUCTOR</h4>
                </div>
                <div class="modal-body">
                    <div class="row conductor_edicion">
                        <div class="col-xs-2">
                            <form style="margin-bottom: 0px" id="upload_imagen_conductor">
                              <div class="contenedor_imagen_perfil">
                                  <input id="input_imagen" type="file" value="Subir" name="foto_perfil" class="image_perfil">
                                  <img id="imagen_perfil" class="img-thumbnail" src="http://placehold.it/250x316">
                                  <div class="icon_spin hidden">
                                    <i class="fa fa-spin fa-spinner"></i>
                                  </div>
                              </div>
                            </form>
                        </div>
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-2">
                                    <label>Fecha Vinculacion</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control input-font" id="conductor_fecha_vinculacion">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <label>Fecha de Nacimiento</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control input-font" id="conductor_fecha_nacimiento">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_departamento">Departamento</label>
                                    <select class="form-control input-font" id="conductor_departamento">
                                        <option selected>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_ciudad">Ciudad o Municipio</label>
                                    <select disabled class="form-control input-font" id="conductor_ciudad">
                                        <option selected>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label for="conductor_nombre_completo">Nombre Completo:</label>
                                    <input class="form-control input-font" disabled id="conductor_nombre_completo">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_cc">C.C</label>
                                    <input class="form-control input-font" disabled id="conductor_cc">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_celular">Celular:</label>
                                    <input class="form-control input-font" disabled id="conductor_celular">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_telefono">Telefono:</label>
                                    <input class="form-control input-font" disabled id="conductor_telefono">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_direccion">Direccion</label>
                                    <input class="form-control input-font" disabled id="conductor_direccion">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_tipolicencia">Tipo de Licencia:</label>
                                    <select class="form-control input-font" disabled id="conductor_tipolicencia">
                                        <option selected>-</option>
                                        <option>A1</option>
                                        <option>A2</option>
                                        <option>B1</option>
                                        <option>B2</option>
                                        <option>B3</option>
                                        <option>C1</option>
                                        <option>C2</option>
                                        <option>C3</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_fecha_expedicion">Fecha de Expedicion</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control input-font" id="conductor_fecha_expedicion">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_fecha_vigencia">Fecha de Vigencia</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control input-font" id="conductor_fecha_vigencia">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <label for="conductor_edad">Edad</label>
                                    <input class="form-control input-font" disabled id="conductor_edad">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_genero">Genero</label>
                                    <select class="form-control input-font" id="conductor_genero">
                                        <option selected>-</option>
                                        <option>MASCULINO</option>
                                        <option>FEMENINO</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_grupo_trabajo">Grupo de Trabajo</label>
                                    <select class="form-control input-font" id="conductor_grupo_trabajo">
                                        <option selected>-</option>
                                        <option>OPERATIVO</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label for="conductor_tipo_contrato">Tipo de Contrato</label>
                                    <select class="form-control input-font" id="conductor_tipo_contrato">
                                        <option selected>-</option>
                                        <option>P. DE SERVICIOS</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_cargo">Cargo</label>
                                    <input class="form-control input-font" disabled id="conductor_cargo">
                                </div>
                                <div class="col-xs-1">
                                    <label for="conductor_experiencia">Experiencia</label>
                                    <input class="form-control input-font" disabled id="conductor_experiencia">
                                </div>
                                <div class="col-xs-2">
                                    <label for="conductor_accidentes">Accidentes</label>
                                    <select class="form-control input-font" id="conductor_accidentes">
                                        <option>-</option>
                                        <option>SI</option>
                                        <option>NO</option>
                                    </select>
                                </div>
                                <div class="col-xs-5">
                                    <label for="conductor_descripcion">Descripcion del Accidente</label>
                                    <textarea rows="1" class="form-control input-font" id="conductor_descripcion"></textarea>
                                </div>
                                <div class="col-xs-4">
                                    <label for="conductor_incidentes">Incidentes materiales, no personales</label>
                                    <select class="form-control input-font" id="conductor_incidentes">
                                        <option>-</option>
                                        <option>SI</option>
                                        <option>NO</option>
                                    </select>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <label for="conductor_frecuencia">Frecuencia de desplazamiento</label>
                                            <input type="text" class="form-control input-font" id="conductor_frecuencia">
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="vehiculo_propio_desplazamiento">Vehiculo propio para desplazamiento</label>
                                            <select class="form-control input-font" id="conductor_vehiculo_propio_desplazamiento">
                                                <option>-</option>
                                                <option>SI</option>
                                                <option>NO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="conductor_trayecto_casa_trabajo">Trayecto casa - trabajo</label>
                                            <select class="form-control input-font" id="conductor_trayecto_casa_trabajo">
                                                <option>-</option>
                                                <option>VEHICULO</option>
                                                <option>OTROS</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-2">
                                        <label for="conductor_estado">Estado Proveedor</label>
                                        <select class="form-control input-font" id="conductor_estado">
                                            <option selected>-</option>
                                            <option>ACTIVO</option>
                                            <option>INACTIVO</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(isset($permisos->administrativo->proveedores->editar))
                        @if($permisos->administrativo->proveedores->editar==='on')
                            <a id="editar_conductor" class="btn btn-success btn-icon">Editar<i class="fa fa-pencil icon-btn"></i></a>
                            <a id="actualizar_conductor" class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
                        @else
                            <a class="btn btn-success btn-icon disabled">Editar<i class="fa fa-pencil icon-btn"></i></a>
                            <a class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
                        @endif
                    @else
                        <a class="btn btn-success btn-icon disabled">Editar<i class="fa fa-pencil icon-btn"></i></a>
                        <a class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
                    @endif
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>

          </div>
      </div>
  </div>

  <div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg-conductores-edicion">
              <div class="modal-content">
                <form id="conductor_examenesad">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                          <h4 class="modal-title">EXAMENES PSICOSENSOMETRICOS, ALCOHOL Y DROGAS</h4>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-xs-6">
                                <h4 class="modal-title">Historial Examenes:</h4>
                                  <div style="overflow-y: auto; height: 300px;">
                                      <table class="table table-bordered table-hover" id="hist_examenes" width="40%">
                                          <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Novedad</th>
                                                <th></th>
                                            </tr>

                                          </thead>
                                          <tbody>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <div class="col-xs-6">
                                  <div class="row">
                                      <div class="col-xs-3">
                                          <label>Fecha Examenes</label>
                                          <div class="input-group">
                                              <div class='input-group date' id='datetimepicker'>
                                                  <input type='text' class="form-control input-font" id="fecha_examen">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-6">
                                          <label for="novedad_examenes">Novedad</label>
                                          <textarea class="form-control" id="novedad_examenes"></textarea>
                                      </div>

                                  </div>
                              </div>
                          </div>
                        </div>

                      <div class="modal-footer">
                          <a class="btn btn-primary btn-icon" id="save_examenes">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>

                          <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                      </div>

                </form>
              </div><!-- /.modal-content -->

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

  @include('scripts.scripts')
  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/conductores.js')}}"></script>
<script type="text/javascript">

    function goBack(){
        window.history.back();
    }

</script>
<script>

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    $("#identification").on('keyup', function (e) {
      var keycode = e.keyCode || e.which;
        if (keycode == 13) {

          var cedula = $('#identification').val();

          console.log(cedula);

          $.ajax({
            url: '../buscarconductor',
            method: 'post',
            data: {cedula: cedula}
          }).done(function(data){

            if(data.respuesta===false){

              $('#fecha_vinculacion').val('')
              $('#nombre_completo').val('')
              $('#cc').val('')
              $('#celular').val('')
              $('#direccion').val('')
              $('#tipodelicencia').val('-')
              $('#fecha_licencia_expedicion').val('')
              $('#fecha_licencia_vigencia').val('')
              $('#edad').val('')
              $('#genero').val('-')
              $('#grupo_trabajo').val('-')
              $('#tipo_contrato').val('-')
              $('#cargo').val('-')

              $('#experiencia').val('')
              $('#accidentes').val('-')
              $('#descripcion_accidente').val('')
              $('#incidentes').val('-')
              $('#frecuencia_desplazamiento').val('-')

              $('#vehiculo_propio_desplazamiento').val('-')
              $('#trayecto_casa_trabajo').val('-')

              $.confirm({
                  title: '¡Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                  content: 'La cédula digitada no existe en el sistema.',
                  type: 'yellow',
                  typeAnimated: true,
                  buttons: {
                    tryAgain: {
                      text: 'Cancelar',
                      btnClass: 'btn-danger',
                      action: function(){
                      }
                    },cancel: {
                      text: 'Continuar',
                      btnClass: 'btn-success',
                      action: function(){
                          mostrarFormulario();
                      }
                    }
                  }
              });

            }else if(data.respuesta==true){

              $('#fecha_vinculacion').val(data.conductor[0].fecha_vinculacion)
              //$('#fecha_vinculacion').val(data.conductor[0].fecha_vinculacion)
              //$('#fecha_vinculacion').val(data.conductor[0].fecha_vinculacion)
              $('#nombre_completo').val(data.conductor[0].nombre_completo)
              $('#cc').val(data.conductor[0].cc)
              $('#celular').val(data.conductor[0].celular)
              //$('#telefono').val(data.conductor[0].telefono)
              $('#direccion').val(data.conductor[0].direccion)
              $('#tipodelicencia').val(data.conductor[0].tipodelicencia)
              $('#fecha_licencia_expedicion').val(data.conductor[0].fecha_licencia_expedicion)
              $('#fecha_licencia_vigencia').val(data.conductor[0].fecha_licencia_vigencia)
              $('#edad').val(data.conductor[0].edad)
              $('#genero').val(data.conductor[0].genero)
              $('#grupo_trabajo').val(data.conductor[0].grupo_trabajo)
              $('#tipo_contrato').val(data.conductor[0].tipo_contrato)
              $('#cargo').val(data.conductor[0].cargo)

              $('#experiencia').val(data.conductor[0].experiencia)
              $('#accidentes').val(data.conductor[0].accidentes)
              $('#descripcion_accidente').val(data.conductor[0].descripcion_accidente)
              $('#incidentes').val(data.conductor[0].incidentes)
              $('#frecuencia_desplazamiento').val(data.conductor[0].frecuencia_desplazamiento)

              $('#vehiculo_propio_desplazamiento').val(data.conductor[0].vehiculo_propio_desplazamiento)
              $('#trayecto_casa_trabajo').val(data.conductor[0].trayecto_casa_trabajo)

            }else if(data.response==false){
              alert('Error');
            }
          });
          //alert("Enter!");
        }
    });

    $('.bloqueo_uso').click(function(event) {

      event.preventDefault();

      //var $form = $(this);
      var conductor_id = $(this).attr('data-conductor-id');
      var url = $('meta[name="url"]').attr('content');

      var formData = new FormData();
      formData.append('conductor_id', conductor_id);

      var confirm = window.confirm('Esta opcion bloqueara a este conductor para que no sea programado para servicios, estas seguro de bloquear este conductor?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/bloqueousoconductorv2',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            $conductor = data.responseJSON.conductor;

            //$('#form_bloqueo_uso_conductor textarea').attr('disabled', 'disabled').addClass('disabled');

            //$form.find('button[type="submit"]').addClass('hidden');
            //$form.find('.desbloquear_uso_conductor').removeClass('hidden');

            //$form.find('small.text-danger').addClass('hidden');
            //$('#listado_conductores tr[data-conductor-id="'+conductor_id+'"]').addClass('warning');
            location.reload();

          }

        })
        .fail(function(data) {

          if (data.status==400) {

            $.each(data.responseJSON.errors, function(index, el) {

              $('#form_bloqueo_uso_conductor [name="'+index+'"]').next().removeClass('hidden').text(el);

            });

          }else if(data.status==401){

            location.reload();

          }

        });

      }

    });

    $('.desbloqueo_uso').click(function(event) {

      event.preventDefault();
      var url = $('meta[name="url"]').attr('content');
      var conductor_id = $(this).attr('data-conductor-id');

      var confirm = window.confirm('Esta opcion desbloqueara a este conductor para que sea programado para servicios, estas seguro de desbloquear este conductor?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/desbloqueousoconductorv2',
          type: 'post',
          dataType: 'json',
          data: {
            conductor_id: conductor_id
          }
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            location.reload();

          }

        })
        .fail(function() {

        });

      }

    });

    $('.bloqueo_total').click(function(event) {

      event.preventDefault();

      var conductor_id = $(this).attr('data-conductor-id');
      var url = $('meta[name="url"]').attr('content');

      var formData = new FormData();
      formData.append('conductor_id', conductor_id);

      var confirm = window.confirm('Esta opcion bloqueara a este conductor para que no este presente en el sistema, estas seguro de bloquear este conductor?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/bloqueototalconductorv2',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            $conductor = data.responseJSON.conductor;

            location.reload();

          }

        })
        .fail(function(data) {

          if (data.status==400) {

            $.each(data.responseJSON.errors, function(index, el) {

              $('#form_bloqueo_total_conductor [name="'+index+'"]').next().removeClass('hidden').text(el);

            });

          }else if(data.status==401){

            location.reload();

          }

        });

      }

    });

    $('.desbloqueo_total').click(function(event) {

      event.preventDefault();

      var url = $('meta[name="url"]').attr('content');
      var conductor_id = $(this).attr('data-conductor-id');

      var confirm = window.confirm('Esta opcion desbloqueara a este conductor para este presente en el sistema, estas seguro de desbloquear este conductor?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/desbloqueototalconductorv2',
          type: 'post',
          dataType: 'json',
          data: {
            conductor_id: conductor_id
          }
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            location.reload();

          }

        })
        .fail(function() {



        });

      }

    });


</script>

</body>
</html>
