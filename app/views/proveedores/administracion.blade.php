<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Administracion</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
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
            <h3 class="h_titulo">ADMINISTRACION DE VEHICULOS</h3>
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
                  @if(Sentry::getUser()->id === 2)
                    <!--<button id="registrar_pago22" class="btn btn-primary btn-icon" type="button" name="button">REGISTRAR PAGO BAQ<i class="fa fa-save icon-btn"></i></button>
                    <button id="registrar_pago_masivo" class="btn btn-primary btn-icon" type="button" name="button">REGISTRAR PAGO BOG<i class="fa fa-save icon-btn"></i></button>-->
                  @endif
              </div>
          </div>
      </form>
      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>#</th>
            <th>Proveedor</th>
            <th>Vehiculo</th>
            <th>Informacion</th>
          </tr>
          </thead>
          <tfoot>
          <tr>
            <th>#</th>
            <th>Proveedor</th>
            <th>Vehiculo</th>
            <th>Informacion</th>
          </tr>
          </tfoot>
          <tbody>

          </tbody>
      </table>
  </div>

  <div class="contenedor_administracion hidden">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-heading"><strong>PAGO DE ADMINISTRACION</strong><i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i></div>
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
                <option value="2023">2023</option>
                <option selected value="2024">2024</option>
              </select>
            </div>
            <div class="col-xs-12">
              <table id="meses" style="margin-top: 5px; margin-bottom: 0px" class='table table-bordered table-hover'>
                <thead>
                  <tr>
                    <th style="text-align:center;"><strong>ENE</strong></th>
                    <th style="text-align:center;"><strong>FEB</strong></th>
                    <th style="text-align:center;"><strong>MAR</strong></th>
                    <th style="text-align:center;"><strong>ABR</strong></th>
                    <th style="text-align:center;"><strong>MAY</strong></th>
                    <th style="text-align:center;"><strong>JUN</strong></th>
                    <th style="text-align:center;"><strong>JUL</strong></th>
                    <th style="text-align:center;"><strong>AGO</strong></th>
                    <th style="text-align:center;"><strong>SEP</strong></th>
                    <th style="text-align:center;"><strong>OCT</strong></th>
                    <th style="text-align:center;"><strong>NOV</strong></th>
                    <th style="text-align:center;"><strong>DIC</strong></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">
                      <i id="enero" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="1" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="febrero" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="2" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="marzo" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="3" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="abril" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="4" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="mayo" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="5" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="junio" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="6" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="julio" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="7" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="agosto" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="8" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="septiembre" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="9" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="octubre" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="10" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="noviembre" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="11" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                    <td class="text-center">
                      <i id="diciembre" style="margin-bottom: 5px" class="fa fa-close list-close"></i><br>
                      <button data-mes="12" data-toggle="modal" data-target=".mymodal" class="btn btn-primary btn-list-table ver_detalles_administracion">VER</button>
                    </td>
                  </tr>
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
                  <div class="form-group" style="margin-bottom: 0px">
                    <label for="">Numero de Ingreso</label>
                    <input type="text" class="form-control input-font" id="numero_ingreso">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="editar" class="btn btn-success btn-icon hidden">EDITAR<i class="icon-btn fa fa-pencil-square-o"></i></button>
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
  <script src="{{url('jquery/administracion.js')}}"></script>
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
            { 'sWidth': '25%' },
            { 'sWidth': '25%' },
            { 'sWidth': '20%' },
        ]
    });
  </script>
  </body>
</html>
