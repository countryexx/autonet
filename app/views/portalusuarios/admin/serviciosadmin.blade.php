<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios Ejecutivos</title>
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

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">VISUALIZACIÓN DE SERVICIOS EJECUTIVOS</h3>
       @if(Sentry::getUser()->id === 643 or Sentry::getUser()->id === 4093)
          <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">
              SOLICITAR<i class="fa fa-plus icon-btn" aria-hidden="true"></i>
          </a> 
        @endif
        @if(Sentry::getUser()->id === 605 or Sentry::getUser()->id === 643)
          <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            SUBIR SOLICITUD MASIVA CON EXCEL<i class="fa fa-upload icon-btn" aria-hidden="true"></i>
          </a>
        @endif          

        <form class="form-inline" id="form_buscar">
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                    </div>                    
                    <button data-option="1" id="buscar" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                </div>
            </div>
        </form>

        @if(isset($servicios))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Codigo</th>
                  <th>Solicitante/Fecha</th>
                  <th>Ciudad</th>
                  <th>Fecha Orden / Fecha Servicio</th>
                  <th>Itinerario</th>
                  <th>Desde</th>
                  <th>Hasta</th>
                  <th>Detalle</th>
                  <th>Site</th>
                  <th>Pax</th>
                  <th>Horario</th>
                  <th>Estado</th>
                  <th>GPS</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Codigo</th>
                    <th>Solicitante/Fecha</th>
                    <th>Ciudad</th>
                    <th>Fecha Orden / Fecha Servicio</th>
                    <th>Itinerario</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Detalle</th>
                    <th>Site</th>
                    <th>Pax</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th>GPS</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($servicios as $servicio)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
                        <td>{{$o++}}</td>
                        <td>{{$servicio->id}}</td>
                        <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>                        
                        <td>{{$servicio->ciudad}}</td>
                        <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
                        <td>
                            @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                            @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                            @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                            @if($servicio->vuelo==='')@else Vuelo:<br>{{$servicio->vuelo}}@endif<br>
                            @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                            @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                        </td>
                        <td>{{$servicio->recoger_en}}</td>
                        <td>{{$servicio->dejar_en}}</td>
                        <td>{{$servicio->detalle_recorrido}}</td>
                        <td><span class="bolder">{{$servicio->nombresubcentro}}</span></td>
                        <td>
                          <?php

                              if ($servicio->ruta!=null) {

                                  $pax = explode('/',$servicio->pasajeros);

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

                                      echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';


                                  }
                                  echo '<a data-id="'.$servicio->id.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

                              }else{

                                  $pax = explode('/',$servicio->pasajeros);

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

                              }

                          ?>
                        </td>                        
                        <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                        <td><?php
                          if (intval($servicio->estado_servicio_app)===1) {
                              echo '<div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">EN SERVICIO</div>';
                          }else if(intval($servicio->estado_servicio_app)===2){
                              echo '<div class="estado_servicio_app" style="background: #EC0000; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 67px; border-radius: 2px;">FINALIZADO</div>';
                          }else{
                              echo '<div class="estado_servicio_app" style="background: #0009FF; color: white; margin: 2px 0px; font-size: 10px; padding: 4px 5px; width: 77px; border-radius: 2px;">PROGRAMADO</div>';                                      
                          }
                          ?>
                        </td>
                        <td>
                          
                          
                            <?php
                                $encrypted = Crypt::encryptString($servicio->id);                              
                              ?>
                              <a style="color: black !important; background:#0ABB04; font-size:12px; padding:3px 1px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; text-decoration:none; display: block; text-align: center;" target="_blank" href="{{url('serviciosgps/viaje/'.$encrypted)}}">VER <i class="fa fa-map-marker" aria-hidden="true"></i></a>

                            <!--<button class="btn-success"><a style="color: black !important" href="{{url('serviciosgps/viaje/'.$encrypted)}}" target="_blank">VER <i class="fa fa-map-marker" aria-hidden="true"></i></a></button>-->
                          
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('modales.nuevo_servicio_portal')
    <!--MODAL PARA SUBIR EXCEL --> 
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: green">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>SUBIR EXCEL</strong>
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
                      <td>SITE</td>
                      <td>JOB CODE</td>
                      <td>PASSENGERS</td>
                      <td>PHONE</td>
                      <td>EMAIL</td>
                      <td>DATE</td>
                      <td>TIME</td>
                      <td>PICK-UP</td>
                      <td>DESTINATION</td>         
                      <td>FLIGHT NUMBER</td>
                      <td>SPECIAL REQUERIMENTS</td>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
            </div>
          </div>
          <div class="modal-footer">
              <a style="float: right; margin: 0 20px 0 30px;" id="guardar_archivo" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
              <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
              <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
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
    <script src="{{url('jquery/serviciosadmin.js')}}"></script>    

  </body>
</html>
