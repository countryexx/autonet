<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Validar Pagos</title>
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
@include('admin.menu')

<h1 style="margin: 0 10px 10px 16px" class="h_titulo">VALIDACIONES</h1>

<!--<img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/1140835204.png" />-->

 <div class="container-fluid" id="ex_ruta">

   <div class="row">
         <!--<div class="col-lg-4 col-md-4 col-sm-4">
               <div class="panel panel-default">
                   <div class="panel-heading">Validación de Transacciones WOMPI
                     <a style="float: right;" id="validar_pagos" class="detalles_centro btn btn-list-table btn-primary disabled ">Validar</a>
                     <span style="background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon"><i class="fa fa-spinner fa-spin icon-btn"></i></span>
                     <span style="background-color: #F8FAF7; color: black;" class="hidden" id="cargado" class="btn btn-primary btn-icon"><i class="fa fa-check icon-btn"></i></span>
                     <span style="background-color: #F8FAF7; color: black;" class="hidden" id="nocargado" class="btn btn-primary btn-icon"><i class="fa fa-times icon-btn"></i></span>
                     <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">NO HAY ARCHIVO! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                   </div>
                   <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 270px;">
                     <form style="display: inline" id="form_transacciones">
                         <div class="row">
                            <div class="col-md-6" style="margin-top: 15px; margin-bottom: 15px">
                              <input id="trasactions" type="file" value="Subir" name="excel">
                            </div>
                         </div>
                     </form>


                     <table name="mytableT" id="transacciones" class="table table-hover table-bordered tablesorter">
                        <thead>
                          <tr>
                           <td>#</td>
                            <td># TRANSACCIÓN</td>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                   </div>
               </div>
         </div>-->
         <!--<div class="col-lg-4 col-md-4 col-sm-4">
             <div class="panel panel-default">
                 <div class="panel-heading">Validación Individual</div>
                 <div class="panel-body">
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"># Transacción:</span>
                         <input class="form-control input-font" id="numero_transaccion" class="numero_transaccion" aria-describedby="basic-addon1" value="">
                         <a style="float: right; width: 100%; margin-top: 10px" id="validar_transaccion" class="detalles_centro btn btn-list-table btn-primary ">Validar</a>
                     </div>
                 </div>
             </div>
         </div>-->
         <div class="col-lg-12 col-md-12 col-sm-12">
           <div class="panel panel-default">
               <div class="panel-heading">Envío de Emails
                <!--<a href="tel:3000000000" style="float: right;" class="detalles_centro btn btn-list-table btn-primary ">Llamar</a>
                 <a style="float: right;" id="notificar" class="detalles_centro btn btn-list-table btn-primary ">Notificar</a>-->

                 <a style="float: right;" id="waa" class="detalles_centro btn btn-list-table btn-success ">API Whatsapp</a>

                 <a style="float: right; margin-right: 15px;" id="auth" class="auth btn btn-list-table btn-info ">Auth</a>

                 <a style="float: right; margin-right: 15px;" id="voz" class="voz btn btn-list-table btn-info ">Voz</a>

                 <a style="float: left;" id="factura" class="detalles_centro btn btn-list-table btn-danger ">Facturas</a>

                 <!--<a style="float: right;" id="enviar_emails" class="detalles_centro btn btn-list-table btn-success disabled ">Enviar</a>-->
                 <span style="background-color: #F8FAF7; color: black;" class="hidden" id="cargandoe" class="btn btn-primary btn-icon"><i class="fa fa-spinner fa-spin icon-btn"></i></span>
                 <span style="background-color: #F8FAF7; color: black;" class="hidden" id="cargandoe" class="btn btn-primary btn-icon"><i class="fa fa-check icon-btn"></i></span>
                 <span style="background-color: #F8FAF7; color: black;" class="hidden" id="nocargadoe" class="btn btn-primary btn-icon"><i class="fa fa-times icon-btn"></i></span>
                 <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">NO HAY ARCHIVO! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
               </div>
               <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 270px;">
                 <form style="display: inline" id="form_emails">
                     <div class="row">
                        <div class="col-md-6" style="margin-top: 15px; margin-bottom: 15px">
                          <input id="email_send" type="file" value="Subir" name="excel">
                        </div>
                     </div>
                 </form>

                 <!-- TABLA -->
                 <table name="mytableE" id="emails" class="table table-hover table-bordered tablesorter">
                    <thead>
                      <tr>
                        <td>#</td>
                       <td>Contrato</td>
                        <td>Nombre Padre</td>
                        <td>Nombre Estudiante</td>
                        <td>Curso</td>
                        <td>Email</td>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>


               </div>
           </div>

            <div>
                <audio id="audio">
                    <source src="{{url('biblioteca_imagenes/11.mp3')}}" type="audio/mpeg">
                </audio>
                <button id="playPauseBTN" onclick="playPause()">Play &#9658;</button>
                &nbsp;
                &nbsp;
                <button>Stop &#9611;</button>
                <?php 

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v15.0/102100369400004/messages');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"messaging_product\": \"whatsapp\",\n  \"recipient_type\": \"individual\",\n  \"to\": \"573004580108\",\n  \"type\": \"text\",\n  \"text\": { // the text object\n    \"preview_url\": true,\n    \"body\": \"Message content including a URL begins with https:// or http://\"\n  }\n}");

                $headers = array();
                $headers[] = 'Authorization: Bearer EAAHPlqcJlZCMBAJNW9B35ImPNGs0AqXHYP1PVTBVZBntbyZBcBUiaQQQQyiUTEwrRFUkevCaZCg4L9t4YxZCEJHpOZAb6jeI2k4SuVq0ZA2PZCXvRO9dujwxm1Ce6I1xixvybDptkPZC40QAN9hwXHnLklcVzuB3jyYPFUkpEZC7KoO16fL53dP4PpC4IzA6mqLlACvmdRxuQMKpVKC2LmJNooL5hpmguzXtIZD';
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }else{
                    echo $ch;
                }
                curl_close($ch);


                ?>
            </div>
            <div>
                <a target="_blank" href="https://apps.apple.com/co/app/aotour-client-app/id1496087652"> <img width="80px" height="35px" src="{{url('img/app_store.WEBP')}}"> </a>
                <img src="{{url('img/google_play.WEBP')}}">
            </div>

            <div>
                <?php 

                $email_a = 'bogus@mail.com';
                $email_b = 'bogus';

                if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
                    echo "Esta dirección de correo ($email_a) es válida.";
                }
                if (filter_var($email_b, FILTER_VALIDATE_EMAIL)) {
                    echo "Esta dirección de correo ($email_b) es válida.";
                }

                 $qr = Crypt::encryptString('10430278662022-11-1918-00535449'); //Encryptación del valor de QR

    echo $qr;

                ?>
            </div>

         </div>
   </div>

   <div class="modal fade" tabindex="-1" role="dialog" id='modal_detalles'>
     <div class="modal-dialog modal-md" role="document">
       <div class="modal-content">

           <div class="modal-body">

             <div class="panel panel-default">
                 <div class="panel-heading">Detalles del Pago</div>
                 <div class="panel-body">
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"><b>NOMBRE DEL ACUDIENTE</b></span>
                         <input class="form-control input-font" id="nombre_acudiente" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"> <b>NOMBRE DEL ESTUDIANTE</b> </span>
                         <input class="form-control input-font" id="nombre_estudinate" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"> <b># TRANSACCIÓN</b> </span>
                         <input class="form-control input-font" id="numero_t" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"> <b>VALOR $</b> </span>
                         <input class="form-control input-font" id="valor" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"> <b>MÉTODO DE PAGO</b> </span>
                         <input class="form-control input-font" id="metodo_p" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <div class="input-group margin_input">
                         <span class="input-group-addon" id="basic-addon1"> <b>ESTADO DEL PAGO</b> </span>
                         <input class="form-control input-font" id="estado_pay" aria-describedby="basic-addon1" value="" disabled>
                     </div>
                     <button style="float: right" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                 </div>
             </div>
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

  <script>
    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
  </script>

  <script type="text/javascript">

    var audio = document.getElementById('audio');
    var playPauseBTN = document.getElementById('playPauseBTN');

    var count = 0 ;

    function playPause(){
        if(count==0){
            count = 1;
            audio.play();
        }else{
            count = 0;
            audio.pause();
        }
    }

  $( document ).ready(function() {

    /**/

    

    var isPlaying = false;
    var songTime = 0;
    var song = document.createElement('audio');
    song.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3');
    //$.get();
    $('#play').click(function() {
        song.play();
        isPlaying = true;
        console.log("Playing...");
    });

    $('#stop').click(function() {
        song.pause();
        isPlaying = false;
        console.log("Paused");
    });

    setInterval(function() {
        if(isPlaying == true){
            songTime++;
            $('#time').text("Play Time: " + songTime)
        }
    }, 1000);

    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3');
    
    audioElement.addEventListener('ended', function() {
        this.play();
    }, false);
    
    audioElement.addEventListener("canplay",function(){
        $("#length").text("Duration:" + audioElement.duration + " seconds");
        $("#source").text("Source:" + audioElement.src);
        $("#status").text("Status: Ready to play").css("color","green");
    });
    
    audioElement.addEventListener("timeupdate",function(){
        $("#currentTime").text("Current second:" + audioElement.currentTime);
    });
    
    $('#play').click(function() {
        //audioElement.play();
        $("#status").text("Status: Playing");

        const audio = new Audio('http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3')
        audio.play()
    });
    
    $('#pause').click(function() {
        audioElement.pause();
        $("#status").text("Status: Paused");
    });
    
    $('#restart').click(function() {
        audioElement.currentTime = 0;
    });


    $('#nequi').click(function() {

        $.ajax({
          url: 'nequis',
          method: 'post',
          data: {numero: 1}
        }).done(function(data){

        });

    });

    $('#waa').click(function() {

        $.ajax({
          url: 'waa',
          method: 'post',
          data: {numero: 1}
        }).done(function(data){

        });

    });

    $('.auth').click(function() {

        $.ajax({
          url: 'auth',
          method: 'post',
          data: {numero: 1}
        }).done(function(data){

        });

    });

    $('.voz').click(function() {

        $.ajax({
          url: 'voz',
          method: 'post',
          data: {numero: 1}
        }).done(function(data){

        });

    });

    var request = setInterval(function(){

      console.log('test function');

      var numero = 1;

      /*2 Y 1 HORA END*/
      $.ajax({
          url: 'notificacion',
          method: 'post',
          data: {numero: numero}
        }).done(function(data){

          if(data.respuesta===true){
            console.log('trueeee')
          }else if(data.respuesta==false){

          }else if(data.response==false){
            alert('Error');
          }

        });
        /*2 Y 1 HORA END*/

        /*30 y 15 MINUTOS START*/
        $.ajax({
            url: 'notificacion2',
            method: 'post',
            data: {numero: numero}
        }).done(function(data){

          if(data.respuesta===true){
            console.log('trueeee')
          }else if(data.respuesta==false){

          }else if(data.response==false){
            alert('Error');
          }

        });
        /*30 Y 15 MINUTOS END*/
    }, 20000);
  });

  </script>

</body>
</html>
