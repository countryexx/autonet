<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Documentos de Vehículos</title>
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
  <h1 class="h_titulo">DOCUMENTACIÓN DE VEHÍCULOS</h1>
    @if(isset($vehiculos))
      <table id="documentos_vehiculos" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Razon Social</th>
              <th>Placa</th>
              <th>T. Operación</th>
              <th>Soat</th>
              <th>Tecnomecánica</th>
              <th>M. Preventivo</th>
              <th>Poliza Contractual</th>
              <th>Poliza Extracontractual</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>#</th>
              <th>Razon Social</th>
              <th>Placa</th>
              <th>T. Operación</th>
              <th>Soat</th>
              <th>Tecnomecánica</th>
              <th>M. Preventivo</th>
              <th>Poliza Contractual</th>
              <th>Poliza Extracontractual</th>
            </tr>
          </tfoot>
          <tbody>
            <?php $i = 1; $fecha = date('Y-m-d');?>
          @foreach($vehiculos as $proveedor)
            <tr data-id="{{$proveedor->id}}" >
              <td>{{$i}}</td>
              <td>{{$proveedor->razonsocial}}</td>
              <td>{{$proveedor->placa}}</td>
              <!-- TARJETA DE OPERACIÓN -->
              <td @if($proveedor->fecha_vigencia_operacion<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->fecha_vigencia_operacion}}</span>

                @if($proveedor->tarjeta_operacion_pdf!=null)
                  <button data-option="1" data-value="{{$proveedor->id}}" data-url="{{$proveedor->tarjeta_operacion_pdf}}" data-documento="TARJETA DE OPERACIÓN" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>
              <!-- SOAT -->
              <td @if($proveedor->fecha_vigencia_soat<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->fecha_vigencia_soat}}</span>

                @if($proveedor->soat_pdf!=null)
                  <button data-option="2" data-value="{{$proveedor->id}}" data-url="{{$proveedor->soat_pdf}}" data-documento="SOAT" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>
              <!-- TECNOMECÁNICA -->
              <td @if($proveedor->fecha_vigencia_tecnomecanica<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->fecha_vigencia_tecnomecanica}}</span>

                @if($proveedor->tecnomecanica_pdf!=null)
                  <button data-option="3" data-value="{{$proveedor->id}}" data-url="{{$proveedor->tecnomecanica_pdf}}" data-documento="TECNOMECÁNICA" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>
              <!-- M. PREVENTIVO -->
              <td @if($proveedor->mantenimiento_preventivo<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->mantenimiento_preventivo}}</span>

                @if($proveedor->preventivo_pdf!=null and (Sentry::getUser()->id_rol==28 or Sentry::getUser()->id_rol==1))
                  <button data-option="4" data-value="{{$proveedor->id}}" data-url="{{$proveedor->preventivo_pdf}}" data-documento="MANTENIMIENTO PREVENTIVO" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>
              <!-- POLIZA CONTRACTUAL -->
              <td @if($proveedor->poliza_contractual<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->poliza_contractual}}</span>

                @if($proveedor->poliza_contractual_pdf!=null)
                  <button data-option="5" data-value="{{$proveedor->id}}" data-url="{{$proveedor->poliza_contractual_pdf}}" data-documento="POLIZA CONTRACTUAL" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

                  <button data-value="{{$proveedor->id}}" class="btn btn-info tarjeta_e hidden disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @else
                  <button data-value="{{$proveedor->id}}" class="btn btn-info disabled" style="float: right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                @endif
              </td>
              <!-- POLIZA EXTRACONRTACTUAL -->
              <td @if($proveedor->poliza_extracontractual<$fecha){{'style="background: #D34D4B"'}}@else{{'style="background: #29B443"'}}@endif>

                  <span style="color: white" class="data-fecha">{{$proveedor->poliza_extracontractual}}</span>

                @if($proveedor->poliza_extracontractual_pdf!=null)
                  <button data-option="6" data-value="{{$proveedor->id}}" data-url="{{$proveedor->poliza_extracontractual_pdf}}" data-documento="POLIZA EXTRACONTRACTUAL" data-razon="{{$proveedor->placa}}" data-fecha="{{date('Y-m-d')}}" class="btn btn-dark ver_pdf" style="float: right;"><i class="fa fa-eye badge_menu_head fontbulger" aria-hidden="true"></i></button>

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
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
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
            <div class="col-md-3 valor_tarjeta">
              <input type="number" name="numero_tarjeta" class="form-control input-font" placeholder="NUM DE TARJETA" id="valor_tarjeta">
            </div>
            <div class="col-md-3">
              <div class='input-group date' id='datetimepicker1'>
                  <input name="fecha" id="fecha" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha Vigencia">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-success okey" data-dismiss="modal" style="float: left;">OK</button>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-danger nookey" data-dismiss="modal" style="float: left;">ELIMINAR</button>
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4; float: right;">Cerrar</button>
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
