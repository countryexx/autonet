<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Autonet | Contratos</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')
      <div class="col-lg-12">
        <div class="col-lg-4">
          <div class="row">
             @include('proveedores.menu_proveedores')
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <h3 class="h_titulo">CONTRATOS</h3>
          </div>
        </div>

          <table id="example" class='table table-bordered table-hover'>
            <thead>
              <tr>
                <th># Contrato</th>
                <th>Fecha Inicio</th>
                <th>Fecha Vencimiento</th>
                <th>Contratante</th>
                <th>Nit o CC Contratante</th>
                <th>Representante Legal</th>
                <th>C.C Representante</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Cliente</th>
                <th>Informacion</th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach ($contratos as $contrato) {

                  $cliente = '';
                  $fecha_actual = new DateTime("now");
                  $fecha_inicio = new DateTime($contrato->fecha_inicio);
                  $fecha_vencimiento = new DateTime($contrato->fecha_vencimiento);

                  if ($fecha_actual->format('Y-m-d')>=$fecha_inicio->format('Y-m-d') and $fecha_actual->format('Y-m-d')<=$fecha_vencimiento->format('Y-m-d')) {
                    $clase = 'info';
                  }else{
                    $clase = 'warning';
                  }

                  if ($contrato->cliente==1) {
                    $cliente = 'SI';
                  }else{
                    $cliente = 'NO';
                  }

                  echo '<tr class="'.$clase.'">';
                  echo '<td>'.$contrato->numero_contrato.'</td>';
                  echo '<td>'.$contrato->fecha_inicio.'</td>';
                  echo '<td>'.$contrato->fecha_vencimiento.'</td>';
                  echo '<td>'.$contrato->contratante.'</td>';
                  echo '<td>'.$contrato->nit_contratante.'</td>';
                  echo '<td>'.$contrato->representante_legal.'</td>';
                  echo '<td>'.$contrato->cc_representante.'</td>';
                  echo '<td>'.$contrato->telefono_representante.'</td>';
                  echo '<td>'.$contrato->direccion_representante.'</td>';
                  echo '<td>'.$cliente.'</td>';
                  echo '<td>';

                  if(isset($permisos->administrativo->contratos->editar)):
                    if($permisos->administrativo->contratos->editar==='on'):
                        echo '<a data-toggle="modal" data-target=".modal_editar_contrato" style="margin-right: 3px" data-id="'.$contrato->id.'" class="btn btn-list-table btn-primary editar">EDITAR</a>';
                    else:
                        echo '<a style="margin-right: 3px" class="btn btn-list-table btn-primary disabled">EDITAR</a>';
                    endif;
                  else:
                      echo '<a style="margin-right: 3px" class="btn btn-list-table btn-primary disabled">EDITAR</a>';
                  endif;

                  if(isset($permisos->administrativo->contratos->renovar)):
                    if($permisos->administrativo->contratos->renovar==='on'):
                        echo '<a data-id="'.$contrato->id.'" class="btn btn-list-table btn-'.$clase.' renovar">RENOVAR</a>';
                    else:
                        echo '<a class="btn btn-list-table btn-'.$clase.' disabled">RENOVAR</a>';
                    endif;
                  else:
                      echo '<a class="btn btn-list-table btn-'.$clase.' disabled">RENOVAR</a>';
                  endif;


                  echo '</td>';
                  echo '</tr>';
                }
               ?>

            </tbody>
            <tfoot>
              <tr>
                <th># Contrato</th>
                <th>Fecha Inicio</th>
                <th>Fecha Vencimiento</th>
                <th>Contratante</th>
                <th>Nit o CC Contratante</th>
                <th>Representante Legal</th>
                <th>C.C Representante</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Cliente</th>
                <th>Informacion</th>
              </tr>
            </tfoot>
          </table>
          @if(isset($permisos->administrativo->contratos->crear))
              @if($permisos->administrativo->contratos->crear==='on')
                  <button data-toggle="modal" data-target=".mymodal" style="margin-top: 5px" class="btn btn-default btn-icon input-font">AGREGAR<i class="fa fa-plus icon-btn"></i></button>
              @else
                  <button style="margin-top: 5px" class="btn btn-default btn-icon input-font disabled" disabled>AGREGAR<i class="fa fa-plus icon-btn"></i></button>
              @endif
          @else
              <button class="btn btn-default btn-icon input-font disabled" disabled>AGREGAR<i class="fa fa-plus icon-btn"></i></button>
          @endif

      </div>

      <div class="renovar_contrato hidden">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <strong>RENOVAR CONTRATO</strong><i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-6">
                    <label class="obligatorio">Fecha Inicial</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="r_fecha_inicial" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <label class="obligatorio">Fecha Vencimiento</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="r_fecha_vencimiento" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
              </div>
            </div>
            <div class="panel-footer">
              <div style="margin-bottom: 10px;"><strong>HISTORIAL</strong></div>
              <ul style="overflow-y: scroll; height: 199px" class="list-group" id="listado_historial">

              </ul>
              <button id="actualizar_contrato" type="button" class="btn btn-primary btn-icon">RENOVAR<i class="fa fa-refresh icon-btn"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade mymodal" id="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-contratos">
          <div class="modal-content">
            <div class="modal-header">
              <i style="zoom: 60%;" type="button" class="close fa fa-close fa-2x" data-dismiss="modal" aria-hidden="true"></i>
              <strong>NUEVO CONTRATO</strong>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-2">
                  <div class="input-group">
                      <label class="obligatorio">Fecha Inicial</label>
                      <div class='input-group date' id='datetimepicker1'>
                          <input name="fecha_inicial" style="width: 83px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                  </div>
                </div>
                <div class="col-xs-2">
                  <div class="input-group">
                      <label class="obligatorio">Fecha Final</label>
                      <div class='input-group date' id='datetimepicker1'>
                          <input name="fecha_final" style="width: 83px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                  </div>
                </div>
                <div class="col-xs-4">
                  <label class="obligatorio" for="contratante">Contratante</label>
                  <input type="text" class="form-control input-font" id="contratante">
                </div>
                <div class="col-xs-2">
                    <label class="obligatorio" for="nit">Nit o C.C</label>
                    <input type="text" class="form-control input-font" id="nit">
                </div>
                <div class="col-xs-3 hidden representante_legal_container">
                    <label class="obligatorio" for="representante_legal">Representante Legal</label>
                    <input type="text" class="form-control input-font" id="representante_legal">
                </div>
                <div class="col-xs-2 hidden representante_legal_container">
                    <label class="obligatorio" for="cc_representante">C.C</label>
                    <input type="text" class="form-control input-font" id="cc_representante">
                </div>
                <div class="col-xs-2 hidden representante_legal_container">
                    <label class="obligatorio" for="telefono_representante">Telefono</label>
                    <input type="text" class="form-control input-font" id="telefono_representante">
                </div>
                <div class="col-xs-3 hidden representante_legal_container">
                    <label class="obligatorio" for="direccion_representante">Direccion</label>
                    <input type="text" class="form-control input-font" id="direccion_representante">
                </div>
                <div class="col-xs-2">
                    <label class="obligatorio" for="cliente">Cliente</label>
                    <select class="form-control input-font" id="cliente">
                      <option selected value="1">SI</option>
                      <option value="2">NO</option>
                    </select>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button id="guardar_contrato" type="button" class="btn btn-primary btn-icon input-font">GUARDAR<i class="fa fa-save icon-btn"></i></button>
              <button type="button" class="btn btn-danger btn-icon input-font" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade modal_editar_contrato" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-contratos">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <strong>EDITAR CONTRATO</strong>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-2">
                  <div class="input-group">
                      <label class="obligatorio">Fecha Inicial</label>
                      <div class='input-group date' id='datetimepicker1'>
                          <input name="fecha_inicial_editar" style="width: 83px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                  </div>
                </div>
                <div class="col-xs-2">
                  <div class="input-group">
                      <label class="obligatorio">Fecha Final</label>
                      <div class='input-group date' id='datetimepicker1'>
                          <input name="fecha_final_editar" style="width: 83px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label class="obligatorio" for="contratante">Contratante</label>
                  <input type="text" class="form-control input-font" id="contratante_editar">
                </div>
                <div class="col-xs-2">
                    <label class="obligatorio" for="nit">Nit o C.C</label>
                    <input type="text" class="form-control input-font" id="nit_editar">
                </div>
                <div class="col-xs-3 representante_legal_editar_container">
                    <label class="obligatorio" for="representante_legal">Representante Legal</label>
                    <input type="text" class="form-control input-font" id="representante_legal_editar">
                </div>
                <div class="col-xs-2 representante_legal_editar_container">
                    <label class="obligatorio" for="cc_representante">C.C</label>
                    <input type="text" class="form-control input-font" id="cc_representante_editar">
                </div>
                <div class="col-xs-2 representante_legal_editar_container">
                    <label class="obligatorio" for="telefono_representante">Telefono</label>
                    <input type="text" class="form-control input-font" id="telefono_representante_editar">
                </div>
                <div class="col-xs-3 representante_legal_editar_container">
                    <label class="obligatorio" for="direccion_representante">Direccion</label>
                    <input type="text" class="form-control input-font" id="direccion_representante_editar">
                </div>
                <div class="col-xs-2">
                    <label class="obligatorio" for="cliente">Cliente</label>
                    <select class="form-control input-font" id="cliente_editar">
                      <option value="1">SI</option>
                      <option value="2">NO</option>
                    </select>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="actualizar" class="btn btn-primary input-font btn-icon">
                ACTUALIZAR<i class="icon-btn fa fa-refresh"></i>
              </button>
              <button type="button" class="btn btn-danger input-font btn-icon" data-dismiss="modal">CERRAR<i class="icon-btn fa fa-close"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
          <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
          <ul>
          </ul>
      </div>
    @include('scripts.scripts')
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script>
        $table = $('#example').DataTable({
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
                      sortDescending: ": activer pour trier la colonne par ordre d�croissant"
                  }
              },
              'bAutoWidth': false ,
              'aoColumns' : [
                  { 'sWidth': '1%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '7%' },
                  { 'sWidth': '1%' },
                  { 'sWidth': '5%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '2%' },
                  { 'sWidth': '2%' }
              ]
          });

          window.onload=function(){
            var pos=window.name || 0;
            window.scrollTo(0,pos);

              }
              window.onunload=function(){
              window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
              }

          function nobackbutton(){

             window.location.hash="no-back-button";

             window.location.hash="Again-No-back-button" //chrome

             window.onhashchange=function(){
               window.location.hash="no-back-button";
             }
          }

    </script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/contratos.js')}}"></script>
  </body>
</html>
