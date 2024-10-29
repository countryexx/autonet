<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios Empresariales</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="manifest" href="{{url('manifest.json')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style media="screen">

      .alert-minimalist {
        background-color: rgb(255, 255, 255);
        border-color: rgba(149, 149, 149, 0.3);
        border-radius: 3px;
        color: rgb(149, 149, 149);
        padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
        height: 50px;
        margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
        color: rgb(51, 51, 51);
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

      .bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover{
        color: black;
        padding: 9px;
      }

      .proveedor_content{
        z-index: 5;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .input-group .bootstrap-select.form-control .dropdown-toggle{
        padding: 8px;
      }

      .edit_select{
        position: absolute;
        top: 10px;
        right: 5px;
        padding: 3px 6px 3px 6px;
        border-radius: 50%;
        background: green;
      }

      .edit_select i{
        font-size: 12px;
      }

      .popover-title {
          font-size: 12px;
      }

      .bootstrap-select .dropdown-menu li{
        font-size: 12px;
      }

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="h_titulo">SOLICITUDES DE SERVICIO</h3>
          <div class="col-sm-8">
            <div class="row">
              @include('breadcrumbs.servicios_mobile')
            </div>
          </div>
          <table id="tabla_servicios" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th># Solicitud / Aprobación Wompi</th>
                <th>Recoger / Destino</th>
                <th>Recoger / Destino (Opcional)</th>
                <th>Zona</th>
                <th>Fecha / Hora</th>
                <th>Vehiculo</th>
                <th>Detalles</th>
                <th>Usuario solicitante</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th># Solicitud / Aprobación Wompi</th>
                <th>Recoger / Destino</th>
                <th>Recoger / Destino (Opcional)</th>
                <th>Zona</th>
                <th>Fecha / Hora</th>
                <th>Vehiculo</th>
                <th>Detalles</th>
                <th>Usuario solicitante</th>
                <th>Estado</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($servicios_aplicacion as $servicio)
                <tr class="@if($servicio->empresarial==1){{'success'}}@endif">
                  <td>{{$i}}</td>
                  <td>
                    {{$servicio->id}}
                    @if ($servicio->pago_servicio_id!=null)
                      <hr style="margin: 5px 0px; border: 1px dotted #868686;">
                      <a href="#" class="ver_estado_pago" data-pago-servicio-id="{{$servicio->pago_servicio_id}}" title="VER ESTADO DEL PAGO">
                        {{$servicio->reference_code}}
                      </a>
                    @endif
                  </td>

                  <td>{{$servicio->address_recoger.' / '.$servicio->address_destino}}</td>
                  <td>{{$servicio->formatted_address_recoger.' / '.$servicio->formatted_address_destino}}</td>
                  <!--<td><a class="btn btn-default"><i class="fa fa-map-marker" aria-hidden="true"></i></a></td>-->
                  <td>{{ucwords($servicio->destino_zona).' / '.ucwords($servicio->recoger_zona)}}</td>
                  @if ($servicio->multiple==1)
                    <td>{{$servicio->fechas.' / '.substr($servicio->hora, 0, -3)}}</td>
                  @else
                    <td>{{$servicio->fecha.' / '.substr($servicio->hora, 0, -3)}}</td>
                  @endif
                  <td>{{ucwords($servicio->tipo_vehiculo)}}</td>
                  <td>{{strtoupper($servicio->nota)}}</td>
                  <td>
                    <strong>
                      @if ($servicio->empresarial==1)
                        {{$servicio->razonsocial}}<br>
                        @if (isset($servicio->subcentrodecosto))
                          {{$servicio->nombresubcentro}}<br>
                        @endif
                        <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                      @endif
                    </strong>
                    {{$servicio->first_name.' '.$servicio->last_name.'<hr style="margin: 5px 0px; border: 1px dotted #868686;">'.$servicio->telefono}}
                  </td>
                  <td class="text-center">

                    @include('mobile.button')

                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" id="tarifa_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <form id="tarifar_servicio">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">TARIFA</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">Tarifa</label>
                    <select class="form-control input-font" name="nombre_tarifa" id="nombre_tarifa">
                      <option value="0">SELECCIONE UNA TARIFA</option>
                      @foreach ($tarifas as $tarifa)
                        <option value="{{$tarifa->id}}">{{strtoupper($tarifa->tarifa_ciudad.' / '.$tarifa->tarifa_nombre)}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Tipo de vehiculo</label>
                    <select class="form-control input-font disabled" id="vehiculo_tarifa" disabled name="vehiculo_tarifa"></select>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
              <button type="submit" class="btn btn-primary">GUARDAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @include('modales.mobile.programar_servicio')

    @include('modales.mobile.revisar_servicio')

    @include('modales.mobile.ver_liquidacion')

    @include('modales.mobile.ver_estado_pago')

    <div class="documentacion_conductor hidden">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>DOCUMENTACION DEL CONDUCTOR</strong>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
                <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="
                " style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
              </li>
            </ul>
            <button type="button" class="btn btn-primary btn-block ok">
              OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="documentacion_vehiculo hidden">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <strong>DOCUMENTACION DEL VEHICULO</strong>
          </div>
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item">
                <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
              </li>
              <li class="list-group-item">
                <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
              </li>
              <li class="list-group-item">
                <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
              </li>
              <li class="list-group-item">
                <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
              </li>
            </ul>
            <button type="button" class="btn btn-primary btn-block ok">
              OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')

    @include('otros.firebase_cloud_messaging')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    @include('scripts.momentjs')
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/servicios_mobile.js')}}"></script>
    @include('otros.pusher.servicios_cancelados')

  </body>
</html>
