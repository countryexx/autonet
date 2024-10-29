<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Seguridad social</title>
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
              <h3 class="h_titulo">SEGURIDAD SOCIAL DE CONDUCTORES</h3>
          </div>
        </div>

        <form class="form-inline" id="form_buscar">
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                      <select id="proveedores" class="form-control input-font">
                        <option value="0">-</option>
                        @foreach ($proveedores as $key => $proveedor)
                        <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                        @endforeach
                      </select>
                    </div>
                    <button id="buscar" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                </div>
            </div>
        </form>
        <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
            <thead>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Estado</th>
              <th>Informacion</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Estado</th>
              <th>Informacion</th>
            </tr>
            </tfoot>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="contenedor_seguridadsocial hidden">
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
                </select>
              </div>
              <div class="col-lg-12" style="margin-top: 15px;">
                <button data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">AGREGAR</button>
              </div>
              <div class="col-xs-12">
                <table id="meses" style="margin-top: 5px; margin-bottom: 0px" class='table table-bordered table-hover'>
                  <thead>
                    <tr>
                      <th style="text-align:center;">#</th>
                      <th style="text-align:center;">FECHA INICIAL</th>
                      <th style="text-align:center;">FECHA FINAL</th>
                      <th style="text-align:center;"># PLANILLA</th>
                      <th style="text-align:center;">CREADO POR</th>                      
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

    @include('scripts.scripts')
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/seguridadsocial.js')}}"></script>
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
              { 'sWidth': '5%' },
          ]
      });

    </script>
  </body>
</html>
