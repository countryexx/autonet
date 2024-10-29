<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Información Personal</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
</head>

<body onload="nobackbutton();">
@include('admin.menu')

<h1 style="margin: 0 10px 10px 16px" class="h_titulo">INFORMACIÓN GENERAL</h1>

    <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto;">

      <div class="col-lg-5 col-md-5 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">Informacion del Estudiante</div>
                <div class="panel-body">
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Nombre:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->nombre_estudiante}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Tipo de Ruta:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->tipo_ruta}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1"># de contrato:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->contrato}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Teléfono:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->telefono}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Direccion:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->direccion}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Barrio:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$escolar->barrio}}" disabled>
                    </div>
                    <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">Valor:</span>
                        <input class="form-control input-font" aria-describedby="basic-addon1" value="$ {{number_format($escolar->valor)}}" disabled>
                    </div>
                </div>
            </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="panel panel-default">
              <div class="panel-heading">Contacto AOTOUR</div>
              <div class="panel-body">
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1">Email:</span>
                      <a href="mailto:escolar@aotour.com.co" style="float: right" target="_blank" class="btn btn-danger"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1">WhatsApp:</span>
                      <a href="https://wa.me/573147484288?text=Hola!" style="float: right;" target="_blank" id="enlace" class="btn btn-success"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1">Lllamada:</span>
                      <a href="tel:573147484288" style="float: right" target="_blank" >+57 314 748 4288 <i class="fa fa-phone" aria-hidden="true"></i></a>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="panel panel-default">
            <div class="panel-heading">Código QR</div>
            <div class="panel-body">
                <div class="col-md-12">
                  <img src="{{url('biblioteca_imagenes/escolar/codigos/'.$data.'.png')}}" width="100%" />
                </div>
                <div class="col-md-12">
                  <?php
                   $encrypted = Crypt::encryptString($data);
                   ?>
                  <a href="{{ url('transporteescolar/descargarcodigoqr/' . $encrypted) }}" title="Descargar Código en formato PDF" style="float: right; width: 100%; margin-top: 20px" target="_blank" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
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
  <script src="{{url('jquery/escolar.js')}}"></script>

</body>
</html>
