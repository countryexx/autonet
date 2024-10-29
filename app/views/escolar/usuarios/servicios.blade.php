<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Autonet | Rutas</title>
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

      *{margin: 0; padding: 0;}
.doc{
  display: flex;
  flex-flow: column wrap;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  background: #333944;
}
.box{
  width: 300px;
  height: 300px;
  background: #CCC;
  overflow: hidden;
}

.box img{
  width: 100%;
  height: auto;
}
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}


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
    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">RUTAS PROGRAMADAS</h3>
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">

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

                  <button data-option="1" id="buscar" class="btn btn-default btn-icon">Filtrar<i class="fa fa-filter icon-btn"></i></button>

                </div>
            </div>
        </form>

          <table id="example_servicios" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>#</th>
                  <th>Fecha de Ruta</th>
                  <th>Hora de Ruta</th>
                  <th>Estado</th>
                  <th></th>

              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Fecha de Ruta</th>
                    <th>Hora de Ruta</th>
                    <th>Estado</th>
                    <th></th>

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
                    <tr>
                        <td>1</td>
                        <td>{{$servicio->fecha_servicio}}</td>
                        <td>{{$servicio->hora_servicio}}</td>
                        <td>@if($servicio->estado_ruta == 1){{'PASAJERO RECOGIDO'}}@elseif($servicio->novedad_c == 1){{'NO SALIÓ A TIEMPO'}}@elseif($servicio->novedad_c == 2){{'ESTUDIANTE INCAPACITADO'}}@elseif($servicio->novedad_c == 3){{'LO RECOGIÓ EL ACUDIENTE'}}@else{{'POR RECOGER'}}@endif</td>

                        <td>
                          <?php
                           $encrypted = Crypt::encryptString($servicio->id);
                           //$encrypted = $servicio->id;
                           ?>
                          <a href="{{url('transporteescolar/tracking/'.$encrypted)}}" target="_blank" id="enlace" class="btn btn-success">GPS <i class="fa fa-location-arrow" aria-hidden="true"></i></a>

                          <!-- NOVEDADES  -->
                          @if($servicio->novedad_p!=null)
                              <a target="_blank" id="ver_novedad" class="btn btn-primary" id_servicio="{{$servicio->id}}" data-id="{{$contrato}}" data-novedad="{{$servicio->novedad_p}}">VER <i class="fa fa-eye" aria-hidden="true"></i></a>
                          @else
                            <div class="btn-group dropdown">
                                <button @if( (date('H:i',strtotime('-120 minute',strtotime($servicio->hora_servicio))) > $hora && $servicio->fecha_servicio === $fecha_actual) or  $servicio->fecha_servicio > $fecha_actual){{''}}@else{{'disabled'}}@endif style="padding: 7px 8px 6px 8px;" type="button" class="btn btn-warning dropdown-toggle btn-list-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    NOVEDAD <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>

                                        <a id_servicio="{{$servicio->id}}" data-id="{{$contrato}}" data-inactivo="" class="no_recoger"><span class="input-font">NO RECOGER</span> <i class="fa fa-warning"></i></a></li>

                                    <li>

                                        <a id_servicio="{{$servicio->id}}" data-id="{{$contrato}}" data-inactivo-total="" class="novedades"><span class="input-font">OTRA</span> <i class="fa fa-close"></i></a>


                                    </li>
                                </ul>
                            </div>
                          @endif
                        </td>

                    </tr>
              @endforeach
            </tbody>
          </table>

    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/escolar.js')}}"></script>

  </body>
</html>
