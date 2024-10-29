<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de Vehiculos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
</head>
<body>
  @include('admin.menu')

  <div class="col-lg-12">
      <h3 class="h_titulo">LISTADO DE VEHICULOS</h3>
      <div class="col-sm-3">
        <div class="row">
          <div class="form-group">
            <select class="form-control input-font selectpicker" name="listado_vehiculos">
              <option value="0">-</option>
              <option value="1">TODOS</option>
              <option value="2">ARCHIVADOS</option>
            </select>
          </div>
        </div>
      </div>
      <table class="table table-bordered table-hover" id="listado_vehiculos">
        <thead>
        <tr>
          <th>Proveedor</th>
          <th>Placa</th>
          <th>Clase</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Año</th>
          <th>Capacidad</th>
          <th>Propietario</th>
          <th>Empresa</th>
          <th>Tarjeta de Operacion</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <?php

           #CANTIDAD DE VEHICULOS CON DOCUMENTOS VENCIDOS
           $documentos_vehiculos_vencidos = 0;

           ##CANTIDAD DE VEHICULOS CON DOCUMENTOS POR VENCER
           $documentos_vehiculos_por_vencer = 0;

           ##CANTIDAD DE DOCUMENTOS POR VENCER POR VEHICULO
           $cantidad_documentos_por_vencer = 0;

           ##CANTIDAD DE DOCUMENTOS VENCIDOS POR VEHICULO
           $documentos_vencidos_por_vehiculos = 0;
        ?>
        @foreach($vehiculos as $vehiculo)

            <?php

              //Inicializar todas las variables
              $tarjeta_operacion = null;
              $mantenimiento_preventivo = null;
              $soat = null;
              $tecnomecanica = null;
              $poliza_extracontractual = null;
              $poliza_contractual = null;

              $i = 0;

              ##CANTIDAD DE DOCUMENTOS
              $documentos_vencidos_por_vehiculos = 0;
              $cantidad_documentos_por_vencer = 0;

              $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
              $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
              $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
              $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
              $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
              $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

              ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
              if ($tarjeta_operacion<0 or $soat<0 or $tecnomecanica<0 or $mantenimiento_preventivo<0
                      or $poliza_contractual<0 or $poliza_extracontractual<0){
                  $documentos_vehiculos_vencidos++;
              }

              ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
              if (($tarjeta_operacion>=0 && $tarjeta_operacion<=30) or
                      ($soat>=0 && $soat<=30) or
                      ($tecnomecanica>=0 && $tecnomecanica<=30) or
                      ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=30) or
                      ($poliza_contractual>=0 && $poliza_contractual<=30) or
                      ($poliza_extracontractual>=0 && $poliza_extracontractual<=30))
              {
                  $documentos_vehiculos_por_vencer++;
              }

              ##TARJETA DE OPERACION VENCIDA
              if ($tarjeta_operacion<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($tarjeta_operacion>=0 && $tarjeta_operacion<=30){
                  $cantidad_documentos_por_vencer++;
              }

              ##SOAT
              if ($soat<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($soat>=0 && $soat<=30){
                  $cantidad_documentos_por_vencer++;
              }

              ##TECNOMECANICA
              if($tecnomecanica<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($tecnomecanica>=0 && $tecnomecanica<=30){
                  $cantidad_documentos_por_vencer++;
              }

              ##MANTENIMIENTO PREVENTIVO
              if($mantenimiento_preventivo<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=30){
                  $cantidad_documentos_por_vencer++;
              }

              ##POLIZA CONTRACTUAL
              if($poliza_contractual<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($poliza_contractual>=0 && $poliza_contractual<=30){
                  $cantidad_documentos_por_vencer++;
              }

              ##POLIZA EXTRACONTRACTUAL
              if($poliza_extracontractual<0){
                  $documentos_vencidos_por_vehiculos++;
              }

              if ($poliza_contractual>=0 && $poliza_contractual<=30){
                  $cantidad_documentos_por_vencer++;
              }

            ?>

            <tr data-vehiculo-id="{{$vehiculo->id}}" data-vencido="<?php if($documentos_vencidos_por_vehiculos>0): echo '1'; else: echo '0'; endif; ?>"
                data-por-vencer="<?php if($cantidad_documentos_por_vencer>0): echo '1'; else: echo '0'; endif; ?>"
                class="@if($vehiculo->bloqueado_total==1 and $vehiculo->bloqueado==1){{'danger warning'}}@elseif($vehiculo->bloqueado_total==1){{'danger'}}@elseif($vehiculo->bloqueado==1){{'warning'}}@endif">
                <td>{{$vehiculo->proveedor->razonsocial}}</td>
                <td>{{$vehiculo->placa}}</td>
                <td>{{$vehiculo->clase}}</td>
                <td>{{$vehiculo->marca}}</td>
                <td>{{$vehiculo->modelo}}</td>
                <td>{{$vehiculo->ano}}</td>
                <td>{{$vehiculo->capacidad}}</td>
                <td>{{$vehiculo->propietario}}</td>
                <td>{{$vehiculo->empresa_afiliada}}</td>
                <td>{{$vehiculo->tarjeta_operacion}}</td>
                <td>
                    <div class="btn-group dropdown" style="display: inline-block">
                      <button style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success dropdown-toggle btn-list-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          ver <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                          <a href="{{url('proveedores/vehiculos/'.$vehiculo->proveedores_id)}}">DOCUMENTACION</a>
                        </li>
                        <li>
                          <a class="bloqueo_vehiculos" href="#" data-toggle="modal" data-target="#open_modal_bloqueo_vehiculos" data-vehiculo-id="{{$vehiculo->id}}">BLOQUEOS</a>
                        </li>
                        <li>
                          <a href="{{url('hvvehiculos/hvvehiculos/'.$vehiculo->id)}}">HOJA DE VIDA</a>
                        </li>
                        <li><a data-vehiculo-id="{{$vehiculo->id}}" href="#" class="archivar">ARCHIVAR</a></li>
                      </ul>
                    </div>
                    <a <?php
                         if($tarjeta_operacion<=30){
                             echo 'data-tarjeta-operacion="'.$tarjeta_operacion.'"';
                         }
                         if($mantenimiento_preventivo<=30){
                             echo 'data-mantenimiento-preventivo="'.$mantenimiento_preventivo.'"';
                         }
                         if($soat<=30){
                             echo 'data-soat="'.$soat.'"';
                         }
                         if($tecnomecanica<=30){
                             echo 'data-tecnomecanica="'.$tecnomecanica.'"';
                         }
                         if($poliza_extracontractual<=30){
                             echo 'data-poliza-extracontractual="'.$poliza_extracontractual.'"';
                         }
                         if($poliza_contractual<=30){
                             echo 'data-poliza-contractual="'.$poliza_contractual.'"';
                         }

                       ?>
                        class="btn btn-<?php if($documentos_vencidos_por_vehiculos>0): echo 'danger'; else: echo 'default'; endif ?> btn-list-table mostrar_alertas" style="padding: 6px 6px; display: inline-block" data-toggle="modal" data-target=".mdl_alertas" data-vehiculo-id="{{$vehiculo->vehiculo_id}}">
                        <i class="fa fa-envelope-o">
                            <span style="padding: 0 4px;" class="badge"><?php echo $documentos_vencidos_por_vehiculos; ?></span>
                        </i>
                    </a>
                    <a class="btn btn-info asignar_conductores" data-proveedor-id="{{$vehiculo->proveedores_id}}" data-vehiculo-id="{{$vehiculo->id}}">
                      <i class="fa fa-user"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
      </table>
      <a id="mostrar_por_vencer" style="margin-top: 5px" class="btn btn-default btn-icon">POR VENCER <i class="fa fa-filter icon-btn"></i></a>
      <a id="mostrar_vencidos" style="margin-top: 5px" class="btn btn-default btn-icon">VENCIDOS <i class="fa fa-ban icon-btn"></i></a>
      <a id="mostrar_todos" style="margin-top: 5px" class="btn btn-default btn-icon">TODOS <i class="fa fa-car icon-btn" aria-hidden="true"></i></a>
  </div>

  <div class="ventana_modal">
      <div class="col-lg-12">
          <div class="panel panel-primary">
              <div class="panel-heading"><strong>ALERTAS DE DOCUMENTACION</strong>
                  <i style="cursor: pointer; float: right; font-weight:100" class="fa fa-close cerrar_ventana"></i>
              </div>
              <div class="panel-body">
                  <a id="open_modal_restricciones_vehiculos" style="cursor: pointer;">Restricciones de vehiculos</a><br>
                  <a id="mostrar_vencidos_modal" style="cursor: pointer;">Hay un total de <strong><?php echo $documentos_vehiculos_vencidos; ?></strong> vehiculos con documentos vencidos!</a><br>
                  <a id="mostrar_por_vencer_modal" style="cursor: pointer;">Hay un total de <strong><?php echo $documentos_vehiculos_por_vencer; ?></strong> vehiculos con documentos prontos a vencer!</a><br>

                  <br>Hay un total de <strong>{{$cont_vehiculos_sin_prog_mtn}}</strong> Vehiculos sin hacer la Programacion de Mantenimiento!
  				        <br>Hay un total de <strong>{{$cont_vehiculo_sin_1rev}}</strong> Vehiculos Sin hacer la primera Programacion de Mantenimiento!
              </div>
          </div>
      </div>
  </div>

  <div class="ventana_modal hidden">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">Documentos vencidos
                  <i id="cerrar_alerta_sino" style="cursor: pointer; float: right; font-weight:100" class="fa fa-close"></i>
              </div>
              <div class="panel-body">
                  <label>Desea activar la reconfirmacion?</label><br>

              </div>
          </div>
      </div>
  </div>

  <div class="modal fade mdl_alertas" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-medium">
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
          </div>
      </div>
  </div>

  <div class="modal" id="open_modal_bloqueo_vehiculos" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>BLOQUEO VEHICULO</strong>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-info" id="restriccion">RESTRICCION</a>
          <a type="button" class="btn btn-warning" id="bloqueo_uso">BLOQUEO DE USO</a>
          <a type="button" class="btn btn-danger" id="bloqueo_total">BLOQUEO TOTAL</a>
          <a type="button" class="btn btn-default" data-dismiss="modal">CERRAR</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="open_modal_restriccion" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="form_restriccion_vehiculo" style="margin-bottom: 0px;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <strong>RESTRICCION VEHICULO</strong>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="">Detalles</label>
              <textarea type="text" class="form-control input-font" name="detalles" rows="6" id="" placeholder="DETALLES DE LA RESTRICCION" autocomplete="off"></textarea>
              <small class="text-danger hidden"></small>
            </div>
            <div class="form-group">
              <label for="fecha_vencimiento">Fecha de vencimiento</label>
              <input type="text" class="form-control input-font fecha" name="fecha_vencimiento" id="fecha_vencimiento" placeholder="YYYY-MM-DD" autocomplete="off">
              <small class="text-danger hidden"></small>
            </div>
            <div class="container_restricciones hidden">
              <ul class="list-group">
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">GUARDAR <i class="fa fa-spinner fa-spin hidden" aria-hidden="true"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal" id="open_modal_bloqueo_uso" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="form_bloqueo_uso_vehiculo" style="margin-bottom: 0px">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <strong>BLOQUEO DE USO DE VEHICULO</strong>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="detalles_bloqueo_uso">Detalles</label>
              <textarea type="text" class="form-control input-font" name="detalles" rows="6" id="detalles_bloqueo_uso"
                        placeholder="Digite la razon por la que este vehiculo sera bloqueado"></textarea>
              <small class="text-danger hidden"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">BLOQUEAR</button>
            <a class="btn btn-primary desbloquear_uso_vehiculo hidden">DESBLOQUEAR</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal" id="open_modal_bloqueo_total" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="form_bloqueo_total_vehiculo" style="margin-bottom: 0px">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <strong>BLOQUEO TOTAL DE VEHICULO</strong>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="detalles_bloqueo_total">Detalles</label>
              <textarea type="text" class="form-control input-font" name="detalles" rows="6" id="detalles_bloqueo_total"
                        placeholder="Digite la razon por la que este vehiculo sera bloqueado"></textarea>
              <small class="text-danger hidden"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">BLOQUEAR</button>
            <a class="btn btn-primary desbloquear_total_vehiculo hidden">DESBLOQUEAR</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal" id="modal_listado_restricciones_vehiculos" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>LISTADO DE RESTRICCIONES</strong>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="container_table">
                <table class="table table-hovered table-bordered" id="tabla_restricciones_vehiculos">
                  <thead>
                    <tr>
                      <th>PROVEEDOR</th>
                      <th>PLACA</th>
                      <th>RESTRICCION</th>
                      <th>FECHA DE VENCIMIENTO</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_asignar_conductores" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form id="form_asignar_conductores">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <strong>ASIGNAR CONDUCTORES</strong>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="select_asignar_conductores">Conductores</label>
                  <select class="form-control selectpicker show-tick" title="Seleccionar conductor" id="select_asignar_conductores"
                          name="conductores" multiple data-max-options="2">
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            <button type="submit" class="btn btn-primary">GUARDAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{url('dist/vehiculos.js')}}"></script>
  <script>
      $('.ventana_modal')
          .animate({
              opacity: 1,
          },1500);
  </script>

</body>
</html>
