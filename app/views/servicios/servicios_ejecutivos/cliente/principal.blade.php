<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Solicitud de Servicios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

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

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">SOLICITUDES DE SERVICIOS</h3>

        <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-primary btn-icon" data-toggle="modal" data-target=".mymodal">
          SOLICITUD INDIVIDUAL<i class="fa fa-plus icon-btn" aria-hidden="true"></i>
        </a>

        <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-success btn-icon" data-toggle="modal" data-target=".mymodal2">
          SOLICITUD MASIVA<i class="fa fa-upload icon-btn" aria-hidden="true"></i>
        </a>

        <!--<a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-warning btn-icon" data-toggle="modal" data-target=".mymodal0">
          Ver tarifas<i class="fa fa-money icon-btn" aria-hidden="true"></i>
        </a>-->

        @if(isset($servicios))
          <table id="example_solicitados" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Solicitante</th>
                  <th>Ciudad</th>
                  <th>Fecha Orden / Fecha Servicio</th>
                  <th>Itinerario</th>
                  <th>Desde</th>
                  <th>Hasta</th>
                  <th>Detalle</th>
                  <th>Centro de Costo</th>
                  <th>Pax</th>
                  <th>Horario</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Solicitante</th>
                    <th>Ciudad</th>
                    <th>Fecha Orden / Fecha Servicio</th>
                    <th>Itinerario</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Detalle</th>
                    <th>Centro de Costo</th>
                    <th>Pax</th>
                    <th>Horario</th>
                </tr>
            </tfoot>
            <tbody>
              <?php $st=0; ?>
                @foreach($servicios as $servicio)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;

                    ?>
                    <tr id="{{$servicio->id}}" class="danger">
                        <td>{{$o++}}</td>
                        <td>{{$servicio->solicitado_por}}</td>
                        <td>
                          @if($servicio->ciudad!=null)
                            {{$servicio->ciudad}}
                          @elseif($servicio->ciudad_excel!=null)
                            {{$servicio->ciudad_excel}}
                          @endif
                        </td>
                        <td>{{$servicio->request_date.'<br>'.$servicio->date}}</td>
                        <td>
                            @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                            @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                            @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                            @if($servicio->vuelo==='')@else Vuelo:<br>{{$servicio->vuelo}}@endif<br>
                            @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                            @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                        </td>
                        <td>{{$servicio->pickup}}</td>
                        <td>{{$servicio->destination}}</td>
                        <td>{{$servicio->requeriments}}</td>
                        <td><span class="bolder">{{$servicio->expediente}}</span></td>
                        <td>
                          <?php
                                if($st===0){
                                  $st=1;
                                }else{
                                  $st=0;
                                }
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
                                      if (isset($celular)){
                                          echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';
                                      }else{
                                          echo '<a>'.$nombre.'</a><br>';
                                      }

                                  }



                          ?>
                        </td>
                        <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->time)))}}<br> Hora real:<br> {{$servicio->time}}</td>

                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('servicios.servicios_ejecutivos.cliente.modal_nuevoservicio')
    <!--MODAL PARA SUBIR EXCEL -->
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: " class="success">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>SOLICITUD MASIVA</strong>
          </div>
          <div class="modal-body tabbable">
            <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 430px;">
              <form style="display: inline" id="form_ruta">
                <div class="row">
                  <div class="col-md-4">
                    <div style="display: inline-block; margin-bottom: 15px;">
                       <input id="excel_servicios" type="file" value="Subir" name="excel" >
                     </div>
                  </div>
                  <div class="col-md-4">

                  </div>
                </div>

              </form>

               <table name="mytable" id="data_import" class="table table-hover table-bordered tablesorter">
                  <thead>
                    <tr style="background: gray; color: white">
                     <td>#</td>
                      <td>CIUDAD</td>
                      <td>CC</td>
                      <td>PASAJEROS</td>
                      <td>CEL</td>
                      <td>EMAIL</td>
                      <td>FECHA</td>
                      <td>HORA</td>
                      <td>RECOGIDA</td>
                      <td>DESTINO</td>
                      <td>DETALLES</td>

                      <td>ORIGEN</td>
                      <td>DESTINO</td>
                      <td>AEROLINEA</td>
                      <td>VUELO</td>
                      <td>HSALIDA</td>
                      <td>HLLEGADA</td>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-lg-3">
                <label class="obligatorio" style="float: left" for="sede_a_solicitar">Sede a solicitar</label>
                <select class="form-control input-font" id="sede_a_solicitar2">
                <option>Seleccionar Sede</option>
                <option>Barranquilla</option>
                <option>Bogota</option>
                </select>
              </div>

              <div class="col-lg-9">
                <button type="button" style="float: right" data-number="1" class="guardar_archivo button" id="guardar_archivo">Enviar Solicitud <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                <!--<a style="float: right; margin: 0 20px 0 30px;" id="guardar_archivo" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>-->
                <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
                <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!--MODAL PARA VER TARIFAS -->
    <div class="modal fade mymodal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>TARIFAS</strong>
          </div>
          <div class="modal-body tabbable">
            <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 430px;">

              <table id="tarifas" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ciudad del traslado</th>
                    <th>Nombre del traslado</th>
                    <th>Automovil</th>
                    <th>Minivan</th>
                    <th>Van</th>
                    <th>Buseta</th>
                    <th>Bus</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Ciudad del traslado</th>
                    <th>Nombre del traslado</th>
                    <th>Automovil</th>
                    <th>Minivan</th>
                    <th>Van</th>
                    <th>Buseta</th>
                    <th>Bus</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php $i = 1; ?>
                  @foreach($tarifas as $tarifa)

                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$tarifa->tarifa_ciudad}}</td>
                      <td>{{$tarifa->tarifa_nombre}}</td>
                      <td>

                        @if($tarifa->tarifa_cliente_automovil_329!=null && $tarifa->tarifa_cliente_automovil_329!=0)
                          $ {{number_format($tarifa->tarifa_cliente_automovil_329)}}
                        @else
                          No definida
                        @endif

                      </td>
                      <td>

                        @if($tarifa->tarifa_cliente_minivan_329!=null && $tarifa->tarifa_cliente_minivan_329!=0)
                          $ {{number_format($tarifa->tarifa_cliente_minivan_329)}}
                        @else
                          No definida
                        @endif

                      </td>
                      <td>

                        @if($tarifa->tarifa_cliente_van_329!=null && $tarifa->tarifa_cliente_van_329!=0)
                          $ {{number_format($tarifa->tarifa_cliente_van_329)}}
                        @else
                          No definida
                        @endif

                      </td>
                      <td>

                        @if($tarifa->tarifa_cliente_buseta_329!=null && $tarifa->tarifa_cliente_buseta_329!=0)
                          $ {{number_format($tarifa->tarifa_cliente_buseta_329)}}
                        @else
                          No definida
                        @endif

                      </td>
                      <td>

                        @if( $tarifa->tarifa_cliente_bus_329!=null && $tarifa->tarifa_cliente_bus_329!=0 )
                          $ {{number_format($tarifa->tarifa_cliente_bus_329)}}
                        @else
                          No definida
                        @endif

                      </td>
                    </tr>
                    <?php $i++; ?>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/serviciosejecutivos.js')}}"></script>

    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

  </body>
</html>
