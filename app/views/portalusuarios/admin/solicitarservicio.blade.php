<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Solicitar Servicio</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
   <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>-->
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      [data-notify="progressbar"] {
          margin-bottom: 0px;
          position: absolute;
          bottom: 0px;
          left: 0px;
          width: 100%;
          height: 5px;
      }

    </style>
</head>
<body>
@include('admin.menu')
<div class="container-fluid">    
        <div class="row">
            <form id="formularioservicio">
            
              <div class="modal-header" style="background: white">                    
                <center>  <strong style="font-size: 26px; color: black">INFORMACIÓN DEL SERVICIO</strong></center>
              </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                          <div class="row">
                            <div class="col-lg-12">
                                <label class="obligatorio" for="nombres" style="color: black;">Solicitado por</label>
                                <input class="form-control input-font" type="text" id="nombres" placeholder="Nombre del Solicitante">
                            </div>
                            <div class="col-lg-12">
                                <label class="obligatorio" for="fecha" style="color: black;">Fecha del Servicio</label>
                                <input class="form-control input-font" type="text" id="fecha" placeholder="FECHA DEL SERVICIO">
                            </div>
                            <div class="col-lg-12">
                                <label class="obligatorio" for="hora" style="color: black;">Hora del Servicio</label>
                                <input class="form-control input-font" type="text" id="hora" placeholder="Hora del Servicio">
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                  <div class="col-lg-6">
                                    <label class="obligatorio" for="cantidadpasajeros" style="color: black;">Cantidad de pasajeros</label>
                                    <input class="form-control input-font" type="text" id="cantidadpasajeros" placeholder="# de pasajeros">
                                  </div>
                                  <div class="col-lg-6">
                                    <label class="obligatorio" for="cantidadvehiculos" style="color: black;"># de vehiculos</label>
                                    <input class="form-control input-font" type="text" id="cantidadvehiculos" placeholder="# de vehiculos">
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12 col-xs-12">
                                <label class="obligatorio" for="lugarrecogida" style="color: black;">Lugar de Recogida</label>
                                <input class="form-control input-font" type="text" id="lugarrecogida" placeholder="DE">
                            </div>
                            
                            <div class="col-lg-12 col-xs-12">
                                <label  for="lugardestino" style="color: black;">Lugar de Destino</label>
                                <input class="form-control input-font" type="text" id="lugardestino" placeholder="HASTA">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <label class="obligatorio" for="departamento" style="color: black;">Departamento</label>
                                <select class="form-control input-font" id="departamento">
                                    <option>-</option>
                                    @foreach($departamentos as $departamento)
                                      <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>  
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-6 col-xs-12">
                              <label class="obligatorio" for="ciudad" style="color: black;">Ciudad</label>
                              <select disabled class="form-control input-font" name="ciudad" id="ciudad">
                                  <option>-</option>
                              </select>
                            </div>                                                    
                          </div>  
                          <button id="solicitarservicioadministrador" style="margin-top: 30px; float: right;" type="submit" disabled="true" class="btn btn-primary btn-icon">Solicitar<i class="fa fa-send icon-btn" ></i></button> 
                          <!-- <button type="submit" class="" id="solicitarservicioadministrador" style="margin-top: 30px; float: right;">Solicitar</button>  -->                                                  
                        </div>
                        
                    </div>
                      
                </div>                            
        </form>              
            
        </div>
    
</div>

</div>
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
<script src="{{url('jquery/clientes.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

</script>
</body>
</html>
