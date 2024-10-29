<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>AOTOUR | My Services</title>
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
    <!-- VIDEO -->
    <script src="{{url('js/video.js')}}"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/video-js.css')}}">
    <!-- FIN VIDEO -->

    <style>
     

      .btn .dropdown-toggle{
        padding: 8px 12px;
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

    </style>
  </head>
  <body>
    <h5 style="text-align: center;"><b>LIST OF MY SERVICES</b> <i class="fa fa-list" aria-hidden="true"></i></h5>
  <hr>
    <div class="col-lg-12">
        <h3 class="h_titulo">MY SERVICES</h3>  

        <button style="background: #f47321; color: white; margin: 0 0 20px 0" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">VIDEO INFO<i class="fa fa-info icon-btn" aria-hidden="true"></i>
                              </button>  

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
                        <input name="codigo" placeholder="CODE" style="width: 100px" type="text" class="form-control input-font">
                    </div>
                    <div class="hidden">
                        <input name="correo" id="correo" placeholder="Correo" style="width: 100px" type="text" value="{{$email}}" class="form-control input-font">
                    </div>
                    <button data-option="1" id="buscar" class="btn btn-default btn-icon">
                        Search<i class="fa fa-search icon-btn"></i>
                    </button>                    
                </div>
            </div>
        </form>

        @if(isset($servicios))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Code</th>
                  <th>Applicant</th>
                  <th>City</th>
                  <th>Date: Order / Service</th>
                  <th>Itinerary</th>
                  <th>Pick up place</th>
                  <th>Destination place</th>
                  <th>Details</th>
                  <th>Schedule</th>
                  <th>Status</th>
                  <th>Tracking GPS</th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Applicant</th>
                    <th>City</th>
                    <th>Date: Order / Service</th>
                    <th>Itinerary</th>
                    <th>Pick up place</th>
                    <th>Destination place</th>
                    <th>Details</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Tracking GPS</th>
                    
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
                        <td>{{$servicio->solicitado_por}}</td>                        
                        <td>{{$servicio->ciudad}}</td>
                        <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
                        <td>
                            @if($servicio->origen==='')@else Origin:<br>{{$servicio->origen}}@endif<br>
                            @if($servicio->destino==='')@else Destination:<br>{{$servicio->destino}}@endif<br>
                            @if($servicio->aerolinea==='')@else Airline:<br>{{$servicio->aerolinea}}@endif<br>
                            @if($servicio->vuelo==='')@else Flight:<br>{{$servicio->vuelo}}@endif<br>
                            @if($servicio->hora_salida==='')@else Departure Time:<br>{{$servicio->hora_salida}}@endif<br>
                            @if($servicio->hora_llegada==='')@else Arrival Time:<br>{{$servicio->hora_llegada}}@endif<br>
                        </td>
                        <td>{{$servicio->recoger_en}}</td>
                        <td>{{$servicio->dejar_en}}</td>
                        <td>{{$servicio->detalle_recorrido}}</td>
                        <td>Appointment Time:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Real Time:<br> {{$servicio->hora_servicio}}                                                 
                        </td>                                                
                        <td>
                          <?php
                          if (intval($servicio->estado_servicio_app)===1) {
                                      echo '<div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">ON SERVICE</div>';
                                  }else if(intval($servicio->estado_servicio_app)===2){
                                      echo '<div class="estado_servicio_app" style="background: #EC0000; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 67px; border-radius: 2px;">FINISHED</div>';
                                  }else{
                                      echo '<div class="estado_servicio_app" style="background: #0009FF; color: white; margin: 2px 0px; font-size: 10px; padding: 4px 5px; width: 77px; border-radius: 2px;">SCHEDULED</div>';                                      
                                  }
                                  ?>
                        </td>
                        <td>
                          <?php
                              $encrypted = Crypt::encryptString($servicio->id);                              
                            ?>
                            <a style="color: black !important; background:#0ABB04; font-size:12px; padding:3px 1px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; text-decoration:none; display: block; text-align: center;" target="_blank" href="{{url('serviciosgps/viaje/'.$encrypted)}}">SEE <i class="fa fa-map-marker" aria-hidden="true"></i></a>

                          <!--<button class="btn-success"><a style="color: black !important" href="{{url('serviciosgps/viaje/'.$encrypted)}}" target="_blank">VER <i class="fa fa-map-marker" aria-hidden="true"></i></a></button>-->
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>   

    <div class="modal fade mymodal2" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #f47321; color: white">
              <h5 class="modal-title" style="text-align: center; font-size: 20px">Video Info</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <main>
                <div class="contenedor">
                  <video id="myVideoPlayer" class="fm-video video-js vjs-16-9 vjs-big-play-centered" data-setup="{}" controls id="fm-video">
                    <source src="{{url('biblioteca_imagenes/English.mp4')}}" type="video/mp4">
                  </video>
                </div>
              </main>
              <br>
            </div>
            <div class="modal-footer">
              <button onclick="pausar();" type="button" id="pausevideo" class="btn btn-secondary pausesamuel" data-dismiss="modal" style="background-color: #92908F; color: white">Close</button>
            </div>
          </div>
        </div>
      </div> 

    @include('scripts.scripts')    

    <script>

    var reproductor = videojs('fm-video', {
      fluid: true
    });

    //FUNCIÓN PARA PAUSAR EL VIDEO SI SE CIERRA EL MODAL
    function pausar(){

      $('body').on('hidden.bs.modal', '.mymodal2', function () {
        $('video').get(0).load();
        });
    }

  </script>
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/misserviciosgps.js')}}"></script>
    <script src="{{url('js/video.js')}}"></script>

  </body>
</html>
