<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AOTOUR | Estado del pago</title>
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

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jumbotron">

                <img src="{{url('img/logo_aotour.png')}}" style="margin-left: 20px; margin-bottom: 20px">

                @if($estado===1)

                  <h2 style="text-align: center">¡PAGO REALIZADO!</h2>
                  <p style="text-align: center">Gracias por utilizar nuestros servicios!</p>

                @else

                  <h3 style="text-align: center">¡ERROR EN EL PAGO!</h3>
                  <p style="text-align: center">Por favor, Inténtelo de nuevo.</p>

                @endif

                <span>{{$transaccion}}</span>

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
