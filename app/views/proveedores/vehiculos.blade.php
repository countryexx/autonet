<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Vehiculos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('dropzonejs/dist/dropzone.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">

    <h3 class="h_titulo">VEHICULOS | {{$nombre_razonsocial}}</h3>

    @if(isset($vehiculos))
        <table id="listado_vehiculos_proveedores" class="table table-bordered hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Color</th>
                <th>Informacion</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Color</th>
                <th>Informacion</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($vehiculos as $vehiculo)
                  <tr class="<?php $i = 0;

                  $tarjeta_operacion = floor(abs((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400));
                  $soat = floor(abs((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400));
                  $tecnomecanica = floor(abs((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400));
                  $mantenimiento_preventivo = floor(abs((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400));
                  $poliza_contra_riesgo = floor(abs((strtotime($vehiculo->poliza_todo_riesgo)-strtotime(date('Y-m-d')))/86400));
                  $poliza_contractual = floor(abs((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400));
                  $poliza_extracontractual = floor(abs((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400));

                  if($tarjeta_operacion<=30){
                      $i++;
                  }
                  if($soat<=30){
                      $i++;
                  }
                  if($tecnomecanica<=30){
                      $i++;
                  }
                  if($mantenimiento_preventivo<=30){
                      $i++;
                  }
                  if($poliza_contra_riesgo<=30){
                      $i++;
                  }
                  if($poliza_contractual<=30){
                      $i++;
                  }
                  if($poliza_extracontractual<=30){
                      $i++;
                  }
                  
                    if($vehiculo->bloqueado_total!=null){ 
                        echo 'danger'; 
                    }elseif($vehiculo->bloqueado!=null){ 
                        echo 'warning';
                    }
                  ?>">
                      <td>{{$count++}}</td>
                      <td>
                        {{$vehiculo->clase}}
                        @if(Sentry::getUser()->id_rol==28 or Sentry::getUser()->id_rol==1)

                            @if($vehiculo->bloqueado_mantenimiento!=null)

                                <a data-vehiculo-id="{{$vehiculo->id}}" class="btn btn-success btn-list-table desbloqueo_mantenimiento" data-detalles="{{$vehiculo->motivo_bloqueo_mantenimiento}}" style="width: 85px" data-proveedor-id="{{$vehiculo->proveedores_id}}">Desbloquear</a>

                            @else

                                <a data-vehiculo-id="{{$vehiculo->id}}" class="btn btn-danger btn-list-table bloqueo_mantenimiento" style="width: 85px" data-proveedor-id="{{$vehiculo->proveedores_id}}">Bloquear</a>

                            @endif

                        @endif
                      </td>
                      <td>

                        {{$vehiculo->placa}}

                        @if($vehiculo->bloqueado_total!=null)
                          
                          <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">BLOQUEADO TOTAL</div>

                        @elseif($vehiculo->bloqueado!=null)

                          <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">BLOQUEADO DE USO</div>

                        @endif

                        @if($vehiculo->bloqueado_mantenimiento!=null)
                            <div class="estado_servicio_app motivo_mant" data-value="{{$vehiculo->motivo_bloqueo_mantenimiento}}" style="background: #4FAE3F; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 180px; border-radius: 2px;">BLOQUEADO POR MANTENIMIENTO</div>
                        @endif

                      </td>
                      <td>
                        {{$vehiculo->modelo}}
                      </td>
                      <td>{{$vehiculo->marca}}</td>
                      <td>{{$vehiculo->color}}</td>
                      <td>
                         <a class="btn btn-primary btn-list-table mostrar_vehiculo" data-toggle="modal" data-target=".mymodal2" data-vehiculo-id="{{$vehiculo->id}}" data-proveedor-id="{{$vehiculo->proveedores_id}}">INF</a>
                         <!--<a class="btn btn-success btn-list-table mostrar_imagenes" data-toggle="modal" data-target=".mymodal3" data-vehiculo-id="{{$vehiculo->id}}" data-proveedor-id="{{$vehiculo->proveedores_id}}">IMAGENES</a>-->
                         <a <?php

                            $i = 0;

                            $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
                            $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
                            $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
                            $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
                            $poliza_contra_riesgo = floor((strtotime($vehiculo->poliza_todo_riesgo)-strtotime(date('Y-m-d')))/86400);
                            $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
                            $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

                            if($tarjeta_operacion<=30){
                                $i++;
                                echo 'data-tarjeta-operacion="'.$tarjeta_operacion.'"';
                            }
                            if($soat<=30){
                                $i++;
                                echo 'data-soat="'.$soat.'"';
                            }
                            if($tecnomecanica<=30){
                                $i++;
                                echo 'data-tecnomecanica="'.$tecnomecanica.'"';
                            }
                            if($mantenimiento_preventivo<=30){
                                $i++;
                                echo 'data-mantenimiento-preventivo="'.$mantenimiento_preventivo.'"';
                            }
                            if($poliza_contractual<=30){
                                $i++;
                                echo 'data-poliza-contractual="'.$poliza_contractual.'"';
                            }
                            if($poliza_extracontractual<=30){
                                $i++;
                                echo 'data-poliza-extracontractual="'.$poliza_extracontractual.'"';
                            }

                            ?>
                            class="btn btn-<?php if($i>0){echo 'danger ';}elseif($i===0){echo 'default ';} ?>btn-list-table mostrar_alertas" style="padding: 6px 6px;" data-toggle="modal" data-target=".mymodal4" data-vehiculo-id="{{$vehiculo->id}}" data-proveedor-id="{{$vehiculo->proveedores_id}}">
                             <!--<i class="fa fa-envelope-o">
                                 <span style="padding: 0 4px;" class="badge"><?php echo $i ?></span>
                             </i>-->
                         </a>

                         @if(isset($permisos->administrativo->proveedores->crear))

                            @if($permisos->administrativo->proveedores->crear==='on')

                                @if($vehiculo->bloqueado!=null)
                          
                                  <a data-vehiculo-id="{{$vehiculo->id}}" class="btn btn-warning btn-list-table desbloqueo_uso" style="width: 75px" data-proveedor-id="{{$vehiculo->proveedores_id}}">Desbloqueo</a>

                                @else

                                  <a data-vehiculo-id="{{$vehiculo->id}}" class="btn btn-warning btn-list-table bloqueo_uso" style="width: 75px" data-proveedor-id="{{$vehiculo->proveedores_id}}">Bloqueo</a>

                                @endif

                                @if($vehiculo->bloqueado_total!=null)
                                  
                                  <a class="btn btn-danger btn-list-table desbloqueo_total" style="width: 75px" data-vehiculo-id="{{$vehiculo->id}}" data-proveedor-id="{{$vehiculo->proveedores_id}}">Desbloqueo</a>

                                @else

                                  <a class="btn btn-danger btn-list-table bloqueo_total" style="width: 75px" data-vehiculo-id="{{$vehiculo->id}}" data-proveedor-id="{{$vehiculo->proveedores_id}}">Bloqueo</a>

                                @endif
                        
                            @endif

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
            <button type="button" class="btn btn-default btn-icon disabled">Agregar<i class="fa fa-plus icon-btn"></i></button>
        @endif
    @else
        <button type="button" class="btn btn-default btn-icon disabled">Agregar<i class="fa fa-plus icon-btn"></i></button>
    @endif
    <div class="btn-group dropup">
        <button style="padding: 9px 8px 8px 10px;" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            ver <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="tama�o-dropdownmayus" href="../ver/{{$nombre_razonsocial}}">Proveedor <i class="fa fa-car"></i></a></li>
            <li><a class="tama�o-dropdownmayus" href="../conductores/{{$id}}">Conductores <i class="fa fa-user"></i></a></li>
        </ul>
    </div>
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        
            <div class="modal-content">
                <form id="formulario">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">NUEVO VEHICULO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="numero_interno"># Interno</label>
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
                                        <option>CAMPERO</option>
                                        <option>CAMIONETA</option>
                                        <option>BUSETA</option>
                                        <option>BUS</option>
                                        <option>MICROBUS</option>
										<option>MINIVAN</option>
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
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="color">Cilindraje</label>
                                    <input class="form-control input-font" type="text" id="cilindraje">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="color">V/N</label>
                                    <input class="form-control input-font" type="text" id="vn">
                                </div>

                                <div class="col-xs-12">
                                    <div class="row">
                                      <div class="col-xs-4">
                                          <label class="obligatorio" for="propietario">Propietario del Vehiculo</label>
                                          <input class="form-control input-font" type="text" id="propietario">
                                      </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="cc">C.C</label>
                                            <input class="form-control input-font" type="text" id="cc">
                                        </div>
                                        <div class="col-xs-2" id="container_empresa_afiliada">
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



                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
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
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
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
                    
                </div>
                </form>

                <div class="row" style="margin-bottom: 15px; margin-left: 5px;">
                  <div class="col-lg-3">
                    <input type="text" maxlength="10" class="form-control input-font" id="plate" placeholder="Ingrese placa para buscar">
                  </div>
                  <div class="col-lg-9">
                    <button style="float: right; margin-left: 5px; margin-right: 5px" type="submit" data-id="{{$id}}" id="guardar" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a style="float: right;" data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                  </div>
                </div>

            </div><!-- /.modal-content -->
        
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="conductor_perfil">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">INFORMACION DE VEHICULO</h4>
                </div>
                <div class="modal-body">
                    <div class="row edicion">
                        <div class="col-xs-12">
                            <div class="row">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="vehiculo_numero_interno"># Interno</label>
                                  <input type="text" class="form-control input-font" id="vehiculo_numero_interno">
                              </div>
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="vehiculo_tipo_transporte">Tipo Transporte</label>
                                  <select class="form-control input-font" id="vehiculo_tipo_transporte">
                                      <option>-</option>
                                      <option>PRIVADO</option>
                                      <option>PUBLICO</option>
                                  </select>
                              </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_placa">Placa</label>
                                    <input type="text" disabled class="form-control input-font" id="vehiculo_placa">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_numero_motor">Numero del Motor</label>
                                    <input type="text" disabled class="form-control input-font" id="vehiculo_numero_motor">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_clase">Clase</label>
                                    <select class="form-control input-font" disabled id="vehiculo_clase">
                                        <option>-</option>
                                        <option>AUTOMOVIL</option>
                                        <option>CAMIONETA</option>
                                        <option>BUSETA</option>
                                        <option>BUS</option>
                                        <option>MICROBUS</option>
										<option>MINIVAN</option>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_marca">Marca</label>
                                    <input type="text" disabled class="form-control input-font" id="vehiculo_marca">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_modelo">Linea</label>
                                    <input type="text" disabled class="form-control input-font" id="vehiculo_modelo">
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="vehiculo_anos" class="obligatorio">Modelo</label>
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' disabled class="form-control input-font" id="vehiculo_anos">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_capacidad">Capacidad</label>
                                    <input type="text" disabled class="form-control input-font" id="vehiculo_capacidad">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_color">Color</label>
                                    <input class="form-control input-font" disabled type="text" id="vehiculo_color">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_cilindraje">Cilindraje</label>
                                    <input class="form-control input-font" type="text" id="vehiculo_cilindraje">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="vehiculo_vn">V/N</label>
                                    <input class="form-control input-font" type="text" id="vehiculo_vn">
                                </div>

                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label class="obligatorio" for="vehiculo_propietario">Propietario del Vehiculo</label>
                                            <input class="form-control input-font" disabled type="text" id="vehiculo_propietario">
                                        </div>
                                        <div class="col-xs-3">
                                            <label class="obligatorio" for="vehiculo_cc">C.C</label>
                                            <input class="form-control input-font" disabled type="text" id="vehiculo_cc">
                                        </div>
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="vehiculo_empresa_afiliada">Empresa afiliada</label>
                                            <select class="form-control input-font" disabled id="vehiculo_empresa_afiliada">
                                                <option value="0">-</option>
                                                <option value="1">AOTOUR</option>
                                                <option value="2">OTRO</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-3 vehiculo_cual_empresa hidden">
                                            <label class="obligatorio" for="vehiculo_empresa_afiliada">Cual?</label>
                                            <input type="text" class="form-control input-font" id="vehiculo_cual_empresa">
                                        </div>


                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
                                      <div class="col-xs-3">
                                          <label class="obligatorio" for="vehiculo_tarjeta_operacion">Tarjeta de Operacion</label>
                                          <input type="text" disabled class="form-control input-font" id="vehiculo_tarjeta_operacion">
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_fecha_vigencia_operacion" class="obligatorio">Fecha de Vigencia</label>
                                              <div class='input-group date' id='datetimepicker2'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_fecha_vigencia_operacion">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_fecha_vigencia_soat" class="obligatorio">Vigencia del Soat</label>
                                              <div class='input-group date' id='datetimepicker3'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_fecha_vigencia_soat">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_fecha_vigencia_tecnomecanica" class="obligatorio">Vigencia de tecnomecanica</label>
                                              <div class='input-group date' id='datetimepicker4'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_fecha_vigencia_tecnomecanica">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_mantenimiento_preventivo" class="obligatorio">Mantenimiento Preventivo</label>
                                              <div class='input-group date' id='datetimepicker4'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_mantenimiento_preventivo">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_poliza_todo_riesgo" class="obligatorio">Poliza contra todo riesgo</label>
                                              <div class='input-group date' id='datetimepicker5'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_poliza_todo_riesgo">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_poliza_contractual" class="obligatorio">Poliza contractual</label>
                                              <div class='input-group date' id='datetimepicker6'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_poliza_contractual">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-3">
                                          <div class="form-group" style="margin-bottom: 0px;">
                                              <label for="vehiculo_poliza_extracontractual" class="obligatorio">Poliza extracontractual</label>
                                              <div class='input-group date' id='datetimepicker7'>
                                                  <input type='text' disabled class="form-control input-font" id="vehiculo_poliza_extracontractual">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-6">
                                          <label class="obligatorio" for="vehiculo_observaciones">Observaciones</label>
                                          <textarea class="form-control input-font" disabled id="vehiculo_observaciones" rows="1"></textarea>
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
                            <a id="editar_vehiculo" class="btn btn-success btn-icon">Editar<i class="fa fa-pencil icon-btn"></i></a>
                            <a id="actualizar_vehiculo" class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
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
            </div><!-- /.modal-content -->
        </form>

    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="conductor_perfil">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">IMAGENES</h4>
                </div>
                <div class="panel-body">
                  <div id="lista_imagenes">

                  </div>

                    <form class="dropzone" id="my-dropzone">
                        <input type="hidden" name="id" value="1" id="id_vehiculo">
                        <div class="dz-message" data-dz-message><span>Sube Las Imagenes Del Vehiculo</span></div>
                    </form>

                    <button class="btn btn-redu btn-icon" id="subir">SUBIR ARCHIVOS .jpg<i class="fa fa-upload icon-btn"></i></button>
                </div>
            </div><!-- /.modal-content -->
        </form>

    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-medium">
        <form id="conductor_perfil">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <strong>ALERTAS</strong>
                </div>
                <div class="modal-body">
                    <div id="alertas_vigencia">

                    </div>
                </div>
                <div class="modal-footer">
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

<div class="modal" id="open_modal_bloqueo_motivo" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>MOTIVO DE BLOQUEO</strong>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="detalles_bloqueo_uso">Detalles</label>
            <textarea disabled type="text" class="form-control input-font" name="detalles" rows="6" id="motivos"
                      placeholder="Digite la razon por la que este vehículo será bloqueado"></textarea>
            <small class="text-danger hidden"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="open_modal_bloqueo_mantenimiento" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>BLOQUEO DE MANTENIMIENTO</strong>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="detalles_bloqueo_uso">Detalles</label>
            <textarea type="text" class="form-control input-font" name="detalles" rows="6" id="detalles_bloqueo_mantenimiento"
                      placeholder="Digite la razon por la que este vehículo será bloqueado"></textarea>
            <small class="text-danger hidden"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
          <button type="submit" class="btn btn-primary" id="bloquear_mantenimientos">BLOQUEAR</button>
          <a class="btn btn-primary desbloquear_uso_conductor hidden">DESBLOQUEAR</a>
        </div>
    </div>
  </div>
</div>

<div class="modal" id="open_modal_desbloqueo_mantenimiento" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>DESBLOQUEO DE MANTENIMIENTO</strong>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="detalles_bloqueo_uso">Motivo del Bloqueo</label>
            <textarea type="text" disabled class="form-control input-font" name="detalles" rows="6" id="detalles_desbloqueo_mantenimiento"
                      placeholder="Digite la razon por la que este vehículo será bloqueado"></textarea>
            <small class="text-danger hidden"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
          <button type="submit" class="btn btn-warning" id="desbloquear_mantenimientos">DESBLOQUEAR</button>
          <a class="btn btn-primary desbloquear_uso_conductor hidden">DESBLOQUEAR</a>
        </div>
    </div>
  </div>
</div>

<script src="{{url('dist/vehiculos.js')}}"></script>

<script type="text/javascript">
    function goBack(){
        window.history.back();
    }//desbloqueo_mantenimiento

    $('.bloqueo_mantenimiento').click(function(){

        var id = $(this).attr('data-vehiculo-id');

        $('#bloquear_mantenimientos').attr('data-id',id);
        $('#open_modal_bloqueo_mantenimiento').modal('show');

    });

    $('#bloquear_mantenimientos').click(function(){
       
        //motivo_bloqueo_mantenimiento
        
        var id = $(this).attr('data-id');
        var detalles = $('#detalles_bloqueo_mantenimiento').val().trim().toUpperCase();

        if(detalles===''){

            var text ="El campo detalles es obligatorio.";

            
            alert(text)

        }else{

            $.ajax({
            url: '../bloqueomantenimiento',
            method: 'post',
            data: {id: id, detalles: detalles}
          }).done(function(data){

            if(data.response===true){
            
                location.reload();

            }else if(data.response==false){

                console.log('false')

            }

          });
        }

    });

    $('.desbloqueo_mantenimiento').click(function(){

        var id = $(this).attr('data-vehiculo-id');
        var detalles = $(this).attr('data-detalles');

        $('#desbloquear_mantenimientos').attr('data-id',id);
        $('#detalles_desbloqueo_mantenimiento').val(detalles);
        $('#open_modal_desbloqueo_mantenimiento').modal('show');

    });

    $('#desbloquear_mantenimientos').click(function(){
       
        //motivo_bloqueo_mantenimiento
        
        var id = $(this).attr('data-id');
        //var detalles = $('#detalles_desbloqueo_mantenimiento').val().trim().toUpperCase();

        $.ajax({
            url: '../desbloqueomantenimiento',
            method: 'post',
            data: {id: id}
        }).done(function(data){

            if(data.response===true){
            
                location.reload();

            }else if(data.response==false){

                console.log('false')

            }

        });

    });

    $('.motivo_mant').click(function(){

        $('#motivos').val($(this).attr('data-value'));

        $('#open_modal_bloqueo_motivo').modal('show');

    });

    $("#plate").on('keyup', function (e) {
      var keycode = e.keyCode || e.which;
        if (keycode == 13) {

          var placa = $('#plate').val();
          
          console.log(placa);

          $.ajax({
            url: '../buscarvehiculo',
            method: 'post',
            data: {placa: placa}
          }).done(function(data){

            if(data.respuesta===false){
            
              console.log('prueba false')

              /*
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
              });*/

            }else if(data.respuesta==true){

              console.log('prueba true')

              $('#numero_interno').val(data.vehiculo[0].numero_interno)
              //$('#fecha_vinculacion').val(data.vehiculo[0].fecha_vinculacion)
              //$('#fecha_vinculacion').val(data.vehiculo[0].fecha_vinculacion)
              $('#tipo_transporte').val('PUBLICO')
              $('#placa').val(data.vehiculo[0].placa)
              $('#numero_motor').val(data.vehiculo[0].numero_motor)
              $('#clase').val(data.vehiculo[0].clase)
              
              $('#marca').val(data.vehiculo[0].marca)
              $('#modelo').val(data.vehiculo[0].modelo)
              $('#anos').val(data.vehiculo[0].ano)
              $('#capacidad').val(data.vehiculo[0].capacidad)
              $('#color').val(data.vehiculo[0].color)
              $('#cilindraje').val(data.vehiculo[0].cilindraje)
              $('#vn').val(data.vehiculo[0].numero_vin)
              $('#propietario').val(data.vehiculo[0].propietario)
              $('#cc').val(data.vehiculo[0].cc)
              
              if(data.vehiculo[0].empresa_afiliada==='AOTOUR'){
                $('#empresa_afiliada').val(1)
              }else{
                
                $('#empresa_afiliada').val(2)
                
                $('#cual_empresa').val(data.vehiculo[0].empresa_afiliada)
                $('.cual_empresa').removeClass('hidden');
              
              }

              $('#tarjeta_operacion').val(data.vehiculo[0].tarjeta_operacion)
              $('#fecha_vigencia_operacion').val(data.vehiculo[0].fecha_vigencia_operacion)
              $('#fecha_vigencia_soat').val(data.vehiculo[0].fecha_vigencia_soat)
              $('#fecha_vigencia_tecnomecanica').val(data.vehiculo[0].fecha_vigencia_tecnomecanica)

              $('#mantenimiento_preventivo').val(data.vehiculo[0].mantenimiento_preventivo)

              $('#poliza_todo_riesgo').val(data.vehiculo[0].poliza_todo_riesgo)

              $('#poliza_contractual').val(data.vehiculo[0].poliza_contractual)
              $('#poliza_extracontractual').val(data.vehiculo[0].poliza_extracontractual)
              $('#observaciones').val(data.vehiculo[0].observaciones)

            }else if(data.response==false){
              alert('Error');
            }
          });
          //alert("Enter!");
        }
    });
</script>
<!--<script>

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

</script>-->

<script type="text/javascript">
    
    $('.bloqueo_uso').click(function(event) {

      event.preventDefault();

      var vehiculo_id = $(this).attr('data-vehiculo-id');
      var url = $('meta[name="url"]').attr('content');

      var formData = new FormData();
      formData.append('vehiculo_id', vehiculo_id);

      var confirm = window.confirm('Esta opcion bloqueara este vehiculo para la programacion de servicios, estas seguro de bloquear este vehiculo?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/bloqueousovehiculov2',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            location.reload();

          }

        })
        .fail(function(data) {

          if (data.status==400) {

            $.each(data.responseJSON.errors, function(index, el) {

              $('#form_bloqueo_uso_vehiculo [name="'+index+'"]').next().removeClass('hidden').text(el);

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
      var vehiculo_id = $(this).attr('data-vehiculo-id');

      var confirm = window.confirm('Esta opcion desbloqueara este vehiculo para que sea programado en el sistema, estas seguro de bloquear este vehiculo?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/desbloqueousovehiculov2',
          type: 'post',
          dataType: 'json',
          data: {
            vehiculo_id: vehiculo_id
          }
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            location.reload();

          }

        })
        .fail(function(data) {

          if(data.status==401){

            location.reload();

          }

        });

      }

    });

    $('.bloqueo_total').click(function(event) {

      event.preventDefault();

      var vehiculo_id = $(this).attr('data-vehiculo-id');
      var url = $('meta[name="url"]').attr('content');

      var formData = new FormData();
      formData.append('vehiculo_id', vehiculo_id);

      var confirm = window.confirm('Esta opcion bloqueara este vehiculo para que no este presente en el sistema, estas seguro de bloquear este vehiculo?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/bloqueototalvehiculov2',
          type: 'post',
          data: formData,
          contentType: false,
          processData: false
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            var $vehiculo = data.responseJSON.vehiculo;

            location.reload();

          }

        })
        .fail(function(data) {

          if (data.status==400) {

            $.each(data.responseJSON.errors, function(index, el) {

              $('#form_bloqueo_total_vehiculo [name="'+index+'"]').next().removeClass('hidden').text(el);

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
      var vehiculo_id = $(this).attr('data-vehiculo-id');

      var confirm = window.confirm('Esta opcion desbloqueara este vehiculo para que este presente en el sistema, estas seguro de desbloquear este vehiculo?');

      if (confirm == true) {

        $.ajax({
          url: url+'/proveedores/desbloqueototalvehiculov2',
          type: 'post',
          dataType: 'json',
          data: {
            vehiculo_id: vehiculo_id
          }
        })
        .done(function(response, responseStatus, data) {

          if (data.status==200) {

            location.reload();

          }

        })
        .fail(function(data) {

          if(data.status==401){

            location.reload();

          }

        });

      }

    });

</script>
</body>
</html>
