<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Seguridad social por ciudad</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
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
              <h3 class="h_titulo">SEGURIDAD SOCIAL DE CONDUCTORES POR CIUDAD</h3>
          </div>
        </div>

        <form class="form-inline" id="form_buscar">
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                      <select id="ciudad_select" class="form-control input-font">
                        <option value="0">CIUDAD PROVEEDPR</option>
                        <option value="1">BARRANQUILLA</option>
                        <option value="2">BOGOTA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select id="proveedores" class="form-control input-font">
                        <option value="0">SELECCIONAR PROVEEDORES CARGADOS</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select id="estado_select" class="form-control input-font">
                        <option value="0">TODOS</option>
                        <option value="1">BLOQUEADOS</option>
                        <option value="2">DESBLOQUEADOS</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select id="mes_select" class="form-control input-font">
                        <option value="0">MES</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                      </select>
                    </div>
                    <button id="buscar" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                </div>
            </div>
        </form>
        <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Estado</th>
              <th>Fecha de vencimiento</th>
              <th>Informacion</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Estado</th>
              <th>Fecha de vencimiento</th>
              <th>Informacion</th>
            </tr>
            </tfoot>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="contenedor_seguridadsocial hidden" style="position: absolute; top: 360px">
      <div class="col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-heading"><strong>PAGO DE SEGURIDAD SOCIAL</strong><i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-3">
                <label for="">Año</label>
                <select id="ano" class="form-control input-font">
                  <option value="0">-</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                </select>
              </div>
              <div class="col-lg-12" style="margin-top: 15px;">
                <button data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">AGREGAR</button>
              </div>
              <div class="col-xs-12">
                <table id="meses" style="margin-top: 5px; margin-bottom: 0px; text-align: center;" class='table table-bordered table-hover'>
                  <thead>
                    <tr>
                      <th style="text-align:center;">#</th>
                      <th style="text-align:center;">FECHA INICIAL</th>
                      <th style="text-align:center;">FECHA FINAL</th>
                      <th style="text-align:center;"># PLANILLA</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-small mymodal" id="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            INGRESO DE ADMINISTRACION
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="col-xs-12">
                  <div class="row">
                    <div class="input-group">
                      <label for="">Numero de Planilla</label>
                      <input type="text" class="form-control input-font" id="numero_ingreso">
                    </div>
                    <div class="row" style="margin-top: 10px">
                      <div class="col-lg-6">
                        <div class="input-group">
                          <label for="">Fecha Inicial</label>
                          <div class='input-group date' id="datetimepickerinicial">
                              <input name="fecha_inicial" id="fecha_inicial" type='text' class="form-control input-font" value="">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="input-group">
                          <label for="">Fecha Final</label>
                          <div class='input-group date' id="datetimepickerfinal">
                              <input name="fecha_final" id="fecha_final" type='text' class="form-control input-font" value="">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="registrar_pago" class="btn btn-primary btn-icon" type="button" name="button">REGISTRAR PAGO<i class="fa fa-save icon-btn"></i></button>
            <button type="button" class="btn btn-danger btn-icon" data-dismiss="modal">Close<i class="fa fa-close icon-btn"></i></button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL PDF -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #079F33">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name"></h4>
            </div>
            <div class="modal-body">
              <div class="documento">
                <center>
                  <iframe id="pdf" style="width: 550px; height: 460px;" src="archivo.pdf"></iframe>
                </center>
              </div>
            </div>
            <div class="modal-footer">
              <div class="row">
                <!--<div class="col-md-9">
                  <p id="novedades_modal" style="text-align: left;"></p>
                </div>-->
                <div class="col-md-5">
                      <input name="numero_planilla" id="numero_planilla" type='text' class="form-control input-font" value="" placeholder="NÚMERO DE PLANILLA">
                </div>
                <div class="col-md-3">
                  <div class='input-group date' id='datetimepicker1'>
                      <input name="fecha_inicial" id="fecha_inicial_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha INICIAL">
                      <span class="input-group-addon">
                          <span class="fa fa-calendar">
                          </span>
                      </span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class='input-group date' id='datetimepicker2'>
                      <input name="fecha_final" id="fecha_final_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha FINAL">
                      <span class="input-group-addon">
                          <span class="fa fa-calendar">
                          </span>
                      </span>
                  </div>
                </div>

                <!--<div class="col-md-3">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4; float: right;">Cerrar</button>
                </div>-->
              </div>
              <div class="row" style="margin-top: 20px">
                <div class="col-md-2 col-md-offset-8">
                  <button type="button" class="btn btn-warning nookey" data-dismiss="modal" style="float: left;">NO APROBAR</button>
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-primary okey" style="float: left;">GUARDAR</button>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <div id="motivo_rechazo" class="hidden">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ingresar Motivo</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea id="descripcion" cols="60" rows="10" class="form-control input-font"></textarea>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                      <div class="col-md-4">
                          <a id="confirmar_rechazo" class="btn btn-success btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
                      </div>
                      <div class="col-md-4">
                          <a id="cancelar_aprobacion_cuenta" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
                      </div>
                    </div>
                    <!-- BUTOMS -->
                </div>
            </div>

        </div>
    </div>

    @include('scripts.scripts')
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/seguridadsocial_ciudades.js')}}"></script>
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
          paging: false,
          'bAutoWidth': false ,
          'aoColumns' : [
              { 'sWidth': '10%' },
              { 'sWidth': '20%' },
              { 'sWidth': '25%' },
              { 'sWidth': '10%' },
              { 'sWidth': '10%' },
              { 'sWidth': '10%' },
          ]
      });


      $tablem = $('#meses').DataTable({
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
          paging: false,
          'bAutoWidth': false ,
          'aoColumns' : [
              { 'sWidth': '1%' },
              { 'sWidth': '3%' },
              { 'sWidth': '3%' },
              { 'sWidth': '3%' },
          ]
      });

    </script>
  </body>
</html>
