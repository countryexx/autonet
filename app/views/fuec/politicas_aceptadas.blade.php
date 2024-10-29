<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Politicas aceptadas</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <style media="screen">
      textarea{
        overflow-y: scroll;
      }
    </style>
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1 col-xs-12">
              <div class="text-center">
                <img style="margin-top: 20px;" src="{{url('img/logo_aotour.png')}}" width="200px;">
                <p style="margin: 25px;">Has aceptado nuestras politicas, ahora puedes descargar tus fuecs para el vehiculo de placas: <strong style="color: #f47321;">{{$envio_fuec->vehiculo->placa}}</strong> </p>
              </div>
              <table class="table table-responsive table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Contratante</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Vigencia</th>
                    <th>Enlace</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($envio_fuec->fuec as $fuec)
                    <tr>
                      <td>{{$fuec->id}}</td>
                      <td>{{$fuec->contrato->contratante}}</td>
                      <td>{{$fuec->rutafuec->origen}}</td>
                      <td>{{$fuec->rutafuec->destino}}</td>
                      <td>{{$fuec->rutafuec->destino}}</td>
                      <td>
                          <a class="btn btn-success" href="{{url('descargar/fuec_link/numero/'.$fuec->id)}}">
                            DESCARGAR
                            <i class="fa fa-download"></i>
                          </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>


          </div>
        </div>
      </div>
      <script src="{{url('dist/fuec.js')}}"></script>
  </body>
</html>
