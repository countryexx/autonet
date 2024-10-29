<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Licencias de Conducción</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <style type="text/css">
      a.notif {
        position: relative;
        display: block;
        height: 50px;
        width: 50px;
        background: url('http://i.imgur.com/evpC48G.png');
        background-size: contain;
        text-decoration: none;
      }
      .num {
        position: absolute;
        right: 11px;
        top: 6px;
        color: #fff;
      }
    </style>
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
    <h1 class="h_titulo">DOCUMENTACIÓN DE CONDUCTORES</h1>
    @if(isset($conductores))
      <table id="documentos_conductores" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Tipo de Licencia</th>
              <th>Fecha de expedición</th>
              <th>Fecha de Vigencia</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>#</th>
              <th>Proveedor</th>
              <th>Conductor</th>
              <th>Tipo de Licencia</th>
              <th>Fecha de expedición</th>
              <th>Fecha de Vigencia</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; $fecha = date('Y-m-d');?>
          @foreach($conductores as $proveedor)
            <tr data-id="{{$proveedor->id}}" >
              <td>{{$i}}</td>
              <td>{{$proveedor->razonsocial}}</td>
              <td>{{$proveedor->nombre_completo}}</td>
              <td>{{$proveedor->tipodelicencia}}</td>
              <td>{{$proveedor->fecha_licencia_expedicion}}</td>

              <!-- LICENCIA DE CONDUCCIÓN -->
              <td>

                  <span class="data-fecha">{{$proveedor->fecha_licencia_vigencia}}</span>

                @if($proveedor->licencia_conduccion_pdf!=null)
                  <button data-option="1" data-value="{{$proveedor->id}}" data-url="{{$proveedor->licencia_conduccion_pdf}}" data-documento="LICENCIA DE CONDUCCIÓN" data-razon="{{$proveedor->nombre_completo}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-warning ver_pdfc" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>

            </tr>
            <?php $i++; ?>
          @endforeach
          </tbody>
      </table>
    @endif

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
            <div class="col-md-3">
              <div class='input-group date' id='datetimepicker1'>
                  <input name="fecha" id="fecha_expedida" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Expedida">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
            <div class="col-md-3">
              <div class='input-group date' id='datetimepicker1'>
                  <input name="fecha" id="fecha" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Vigencia">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-primary okeyc" style="float: left;">GUARDAR</button>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-warning nookeyc" data-dismiss="modal" style="float: left;">NO APROBAR</button>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-danger" data-dismiss="modal" float: right;">Cerrar</button>
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
                      <a id="confirmar_rechazoc" class="btn btn-success btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
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
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

</script>
</body>
</html>
