<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aotour | Descarga</title>
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

<body onload="nobackbutton();">

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                <div class="row">
                  <div class="col-md-12">
                    <img src="{{url('img/logo_aotour.png')}}" alt="">
                  </div>
                  <div class="col-md-12" style="margin-top: 30px">
                    <img src="{{url('/biblioteca_imagenes/escolar/codigos/'.$data.'.png')}}" alt="">
                  </div>
                  <div class="col-md-12" style="margin-top: 30px">
                    <p>Gracias por utilizar nuestros servicios!</p>
                  </div>
                </div>


                  <!--<h1>¡DESCARGA EL CÓDIGO EN FORMATO PDF!</h1>-->
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


<script>
  //inicializar variables

  $('input[type=file]').bootstrapFileInput();
  $('.file-inputs').bootstrapFileInput();


</script>

<script type="text/javascript">

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);

    }
    window.onunload=function(){
    window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

    function nobackbutton(){

       window.location.hash="no-back-button";

       window.location.hash="Again-No-back-button" //chrome

       window.onhashchange=function(){
         window.location.hash="no-back-button";
       }
    }

</script>
</body>
</html>
