<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios por Programar BAQ</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="manifest" href="{{url('manifest.json')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style media="screen">


      .button {
        padding: 5px 12px 5px 12px;
        color: #FFF;
        background-color: #4bc970;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border-radius: 5px;
        width: 20%;
        border: 1px solid #3ac162;
        border-width: 1px 1px 3px;
        box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
        margin-bottom: 10px;
      }

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
          @include('servicios.servicios_ejecutivos.menu_servicios')
          <h3 class="h_titulo">SERVICIOS EJECUTIVOS PENDIENTES POR PROGRAMAR</h3>
          <div class="col-sm-8">
          </div>
          <table id="tabla_servicios" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Centro de Costo / Solicitante</th>
                <th># Expediente</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Itinerario</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Pasajero(s)</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Centro de Costo / Solicitante</th>
                <th># Expediente</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th>Itinerario</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Pasajero(s)</th>
                <th>Estado</th>
              </tr>
            </tfoot>
            <tbody>
              <?php $l=1; ?>
              @foreach ($servicios as $servicio)
                <tr data-id-servicio="{{$servicio->id}}" class="@if($servicio->estado_programado!=1){{'text-warning'}}@endif">
                  <td>{{$l}}
                    @if($servicio->tipo_request===1)
                      <i class="fa fa-file-excel-o" style="color: green" aria-hidden="true"></i>
                    @endif</td>
                  <td>{{$servicio->razonsocial}}<br><hr><b>{{$servicio->solicitado_por}}<b></td>
                  <td>
                    {{$servicio->expediente}}
                  </td>
                  <td>{{$servicio->pickup}}</td>
                  <td>{{$servicio->destination}}</td>
                  <td>
                    @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                    @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                    @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                    @if($servicio->vuelo==='')@else Vuelo:<br>{{$servicio->vuelo}}@endif<br>
                    @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                    @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                  </td>
                  <td>{{$servicio->requeriments}}</td>
                  <td>{{$servicio->date}}</td>
                  <td>{{$servicio->time}}</td>
                  <td>
                    <?php
                      $pax = explode('/',$servicio->passengers);

                        for ($i=0; $i < count($pax); $i++) {
                            $pasajeros[$i] = explode(',', $pax[$i]);
                        }

                        for ($i=0; $i < count($pax)-1; $i++) {

                            for ($j=0; $j < count($pasajeros[$i]); $j++) {

                              if ($j===0) {
                                $nombre = $pasajeros[$i][$j];
                              }

                              if ($j===1) {
                                $celular = $pasajeros[$i][$j];
                              }

                              if ($j===2) {
                                $email = $pasajeros[$i][$j];
                              }

                              if ($j===3) {
                                $nivel = $pasajeros[$i][$j];
                              }

                            }

                            if (!isset($celular)){
                              $celular = "";
                            }

                            if (!isset($nombre)){
                              $nombre = "";
                            }

                            if(!isset($email)){
                              $email = "";
                            }

                            echo '<a href title="'.$celular.' | '.$email.'">'.$nombre.'</a><br>';


                        }
                      ?>
                  </td>
                  <td class="text-center">
                      @if ($servicio->estado_programado==null)
                        <button type="button" name="button" data-toggle="modal" class="btn btn-default cancelar_servicio"data-id-servicio="{{$servicio->id}}" style="background-color: red; color: white;">CANCELAR</button>
                        <button type="button" name="button" data-toggle="modal" data-target="#modal_programar_servicio" class="btn btn-default programar_servicio"data-id-servicio="{{$servicio->id}}" style="background-color: green; color: white">PROGRAMAR</button>
                      @endif
                      <br>
                      <br>
                      @if($servicio->pago_id!=null)
                      <div class="estado_servicio_app paradea" style="float: right; background: #f47321; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 100%; border-radius: 2px;"><span class="mensaje">Este servicio fue pagado con TARJETA y se debe programar lo más pronto posible <i class="fa fa-credit-card" aria-hidden="true"></i></span>
                        </div>
                      @endif

                  </td>
                </tr>
                <?php $l++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    @include('servicios.servicios_ejecutivos.modal_programar_servicio')

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

                        <option value="0">tarifa</option>
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
    <script src="{{url('jquery/serviciosejecutivos.js')}}"></script>
    @include('otros.pusher.servicios_cancelados')

  </body>
</html>
