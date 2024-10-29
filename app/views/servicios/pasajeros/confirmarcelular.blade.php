<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="url" content="{{url('/')}}">
    <title>Confirmación de celular AO</title>
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

      <style type="text/css">
      *, *:before, *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
      }

      body {
        font-family: 'Nunito', sans-serif;
        color: #384047;
      }

      form {
        max-width: 300px;
        margin: 10px auto;
        padding: 15px 20px;
        background: #f4f7f8;
        border-radius: 8px;
      }

      h1 {
        margin: 0 0 30px 0;
        text-align: center;
      }

      input[type="text"],
      input[type="password"],
      input[type="date"],
      input[type="datetime"],
      input[type="email"],
      input[type="number"],
      input[type="search"],
      input[type="tel"],
      input[type="time"],
      input[type="url"],
      textarea,
      select {
        background: orange;
        border: none;
        font-size: 16px;
        height: auto;
        margin: 0;
        outline: 0;
        padding: 15px;
        width: 100%;
        background-color: white;
        color: #8a97a0;
        box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
        margin-bottom: 30px;
      }

      input[type="radio"],
      input[type="checkbox"] {
        margin: 0 4px 8px 0;
      }

      select {
        padding: 6px;
        height: 32px;
        border-radius: 2px;
      }

      button {
        padding: 10px;
        color: #FFF;
        background-color: #4bc970;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border-radius: 5px;
        width: 100%;
        border-width: 1px 1px 3px;
        box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
        margin-bottom: 10px;
      }

      fieldset {
        margin-bottom: 30px;
        border: none;
      }

      legend {
        font-size: 2.4em;
        margin-bottom: 10px;
      }

      label {
        display: block;
        margin-bottom: 8px;
      }

      label.light {
        font-weight: 300;
        display: inline;
      }

      .number {
        background-color: #5fcf80;
        color: #fff;
        height: 30px;
        width: 30px;
        display: inline-block;
        font-size: 0.8em;
        margin-right: 4px;
        line-height: 30px;
        text-align: center;
        text-shadow: 0 1px 0 rgba(255,255,255,0.2);
        border-radius: 100%;
      }

      @media screen and (min-width: 480px) {

        form {
          max-width: 880px;
        }

      }

      .campo_vacio{
          background: red;
      }
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
<body style="background-color: #DC4405;" onload="nobackbutton();">
    
    <div class="text-center">
      <form id="confirmarcel">
      <fieldset class="uno">
          <legend><span class="number">2</span>Confirmación de Celular</legend>
        <div class="row" style="margin-top: 10px">
          <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2  col-xs-12">
              <!--<div class="text-center">
                <img style="margin-top: 20px;" src="{{url('img/logo_aotour.png')}}" width="200px;">
              </div>-->
              <h5 class="text-center">
              </h5>
              <div class="text-center" style="margin-top: 5px">
                <div class="row">
                  <div class="col-lg-12">
                    <article>
                      <header style="background: gray">
                        <h2 style="color: white">Introduce tu código de confirmación <i class="fa fa-arrow-down" aria-hidden="true"></i></h2>
                      </header>
                      <p style="font-size: 16px">Pronto recibirás un SMS en +57 {{$Destino}} en el que se te proporcionará el código de confirmación.</p>
                    </article>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-xs-hidden" style="margin-top: 5px">
                    <p style="font-size: 20px">Introduce el código aquí <i class="fa fa-arrow-right" aria-hidden="true"></i></p>
                  </div>
                  <div class="col-lg-4" style="margin-top: 5px">
                    <input type="center" class="form-control" name="codigo" id="codigo">
                  </div>
                </div>
                <hr style="margin-top: 15px; margin-bottom: 4px; border-top: 2px solid orange;">
                <div class="row" style="margin-top: 15px">
                </div>
                <div class="row" style="margin-top: 15px">
                  <div class="col-lg-6 col-xs-12">
                    <button style="border: 1px solid gray; background-color: gray" type="button" data-id="{{$id}}" class="reenviar_codigo" disabled="true">45 Reenviar Código <i class="fa fa-repeat" aria-hidden="true"></i></button>
                    <!--<input type="button" class="btn bg-orange btn-block btn-lg waves-effect" style="margin-top: 5px" value="Volver a enviar el código" onclick="EnviarSms();"  >-->
                    <!-- <a  href="" onclick="enviarsms()"><p style="font-size: 15px; margin-top: 10px" >Volver a enviar el código</p></a> -->
                  </div>
                  <div class="col-lg-6 col-xs-12">
                    <button style="border: 1px solid #3ac162;" type="button" data-id="{{$id}}" class="confirmar">Confirmar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    <!--<button type="submit" class="btn btn-primary" style="margin-top: 5px; float: right;" name="button">Confirmar</button>              -->
                  </div>
                </div>
              </div>
              
              
          </div>
        </div>
      </fielset>
      </form>
    </div>
    <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

  @include('scripts.scripts')

  <script type="text/javascript">
    
    function nobackbutton(){
      var min = 44;
     //for(i=0; i<10; i++){

      $trackingGps = setInterval(function(){

        $('.reenviar_codigo').html('').append(min+' Reenviar Código <i class="fa fa-repeat" aria-hidden="true"></i>');
            
            min = min - 1;
            //alert(min)            

        }, 1000);    

     //}
      setTimeout(function(){
        $('.reenviar_codigo').removeAttr('style').attr('style', 'background: blue;').removeAttr('disabled','disabled');
        clearInterval($trackingGps);
        $('.reenviar_codigo').html('').append('Reenviar Código <i class="fa fa-repeat" aria-hidden="true"></i>');
      }, 45000);
    }

  </script>

  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/pasajeros.js')}}"></script>

</body>	
</html>