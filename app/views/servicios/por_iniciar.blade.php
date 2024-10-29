<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Por Iniciar BOG</title>
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

      .parpadea {

        animation-name: parpadeo;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
      }

      @-moz-keyframes parpadeo{
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      @-webkit-keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
         100% { opacity: 1.0; }
      }

      @keyframes parpadeo {
        0% { opacity: 1.0; }
         50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .bootstrap-select>.dropdown-toggle{
        padding: 8px;
      }

      .proveedor, [data-id="proveedor"]{
        z-index: 10 !important;
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

      .oval {
        width: 200px;
        height: 65px;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
        /*background: #fff;*/
        border: 1px solid #000000;
        /* opacity: 0.5;*/
        display: flex;
        /*justify-content: center;*/
        align-items: center;
        margin-top: 10px;
        margin-bottom: 10px;
        float: left;
      }

      .crono {
        color: #000000;
        font-family: 'Agency FB', arial;
        font-size: 300%;
        text-shadow: 4px 4px 4px #aaa;
        padding-left: 49px;
      }

      .rojo {
        color: red !important;
      }

    </style>
  </head>
  <body>

    <div class="col-lg-12">
      <!--<center><span style="font-size: 40px" id="hora"><?php echo date('H:i')?></span><center>-->
        <span style="font-size: 40px; float: right;" id="hora"><?php echo date('H:i')?></span>

        <center>
        <section class="oval">
          <div id="cronometro">
            <div class="crono">

              <span id="reloj_sg">00</span>:
              <span id="reloj_cs">00</span>
            </div>
          </div>
        </section>
      </center>
      <!--<button id="start">iniciar</button>
      <button id="stop">parar</button>
      <button id="reset">reiniciar</button>-->

        <div>
          <audio id="audio1">
              <source id="avisos" src="{{url('biblioteca_imagenes/1.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio2">
              <source id="avisos" src="{{url('biblioteca_imagenes/2.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio3">
              <source id="avisos" src="{{url('biblioteca_imagenes/3.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio4">
              <source id="avisos" src="{{url('biblioteca_imagenes/4.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio5">
              <source id="avisos" src="{{url('biblioteca_imagenes/5.mp3')}}" type="audio/mpeg">
          </audio>

          <audio id="audio6">
              <source id="avisos" src="{{url('biblioteca_imagenes/6.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio7">
              <source id="avisos" src="{{url('biblioteca_imagenes/7.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio8">
              <source id="avisos" src="{{url('biblioteca_imagenes/8.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio9">
              <source id="avisos" src="{{url('biblioteca_imagenes/9.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio10">
              <source id="avisos" src="{{url('biblioteca_imagenes/10.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio11">
              <source id="avisos" src="{{url('biblioteca_imagenes/11.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio12">
              <source id="avisos" src="{{url('biblioteca_imagenes/12.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio13">
              <source id="avisos" src="{{url('biblioteca_imagenes/13.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio14">
              <source id="avisos" src="{{url('biblioteca_imagenes/14.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio15">
              <source id="avisos" src="{{url('biblioteca_imagenes/15.mp3')}}" type="audio/mpeg">
          </audio>

          <audio id="audio16">
              <source id="avisos" src="{{url('biblioteca_imagenes/16.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio17">
              <source id="avisos" src="{{url('biblioteca_imagenes/17.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio18">
              <source id="avisos" src="{{url('biblioteca_imagenes/18.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio19">
              <source id="avisos" src="{{url('biblioteca_imagenes/19.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio20">
              <source id="avisos" src="{{url('biblioteca_imagenes/20.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio21">
              <source id="avisos" src="{{url('biblioteca_imagenes/21.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio22">
              <source id="avisos" src="{{url('biblioteca_imagenes/22.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio23">
              <source id="avisos" src="{{url('biblioteca_imagenes/23.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio24">
              <source id="avisos" src="{{url('biblioteca_imagenes/24.mp3')}}" type="audio/mpeg">
          </audio>
          <audio id="audio25">
              <source id="avisos" src="{{url('biblioteca_imagenes/25.mp3')}}" type="audio/mpeg">
          </audio>
          <!--<button id="playPauseBTN" onclick="playPause()">Play &#9658;</button>
          &nbsp;
          &nbsp;
          <button>Stop &#9611;</button>-->
        </div>
    </div>

    <!--<div class="col-lg-4">
      <div style="text-align: center; border: 1px solid; background: orange; color: white;"><b>FINALIZADOS</b></div>
      <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Info</th>
          </tr>
        </thead>
        <tfoot>
            <tr>
              <th>Info</th>
            </tr>
        </tfoot>
        <tbody>
          @foreach($servicios as $servicio)
            @if($servicio->estado_servicio_app===2)
            <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
              <td style="text-align: center; background: orange; color: white; font-size: 15px;">
                {{$servicio->razonsocial}} <br>
                {{$servicio->nombre_completo}}<br>
                {{$servicio->hora_servicio}}
              </td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>-->

    <div class="col-lg-6"> <!-- ACTIVOS -->

      <!--<center class="doss">

        <span class="ayer hidden" style="float: left; margin-top: -50px; margin-left: 30px;">Código de Ayer</span>
        <img class="ayer hidden" src="https://app.aotour.com.co/autonet/biblioteca_imagenes/control_ingreso/112477894392345793295673199026163247702541531412822022-12-2711.png" height="70px" style="margin-bottom: 20px; margin-top: -70px;">

        <span class="hoy hidden" style="float: right; margin-top: -50px; margin-right: 30px;">Código de Hoy</span>
        <img class="hoy hidden" src="https://app.aotour.com.co/autonet/biblioteca_imagenes/control_ingreso/112477894392345793295673199026163247702541531412822022-12-2711.png" height="70px" style="margin-bottom: 20px; margin-top: -70px; margin-left: 70px;">
      </center>-->

      <div style="text-align: center; border: 1px solid; background: #4CAF50; color: white;"><b>EN SERVICIO</b></div>
      <table id="example2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Info</th>
          </tr>
        </thead>
        <tfoot>
            <tr>
              <th>Info</th>
            </tr>
        </tfoot>
        <tbody>
          @foreach($servicios as $servicio)
            @if($servicio->estado_servicio_app===1)
              <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
                <td style="text-align: center; background: #4CAF50; color: white; font-size: 15px;">
                  {{$servicio->razonsocial}} <br>
                  {{$servicio->nombre_completo}}<br>
                  {{$servicio->hora_servicio}}
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-lg-6"> <!-- PROGRAMADOS -->
      <div style="text-align: center; border: 1px solid; background: #f47321; color: white;"><b>PROGRAMADOS</b></div>
      <table id="example3" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Info</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Info</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($servicios as $servicio)
            @if($servicio->estado_servicio_app===NULL)
              <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
                <td style="text-align: center; background: #f47321; color: white; font-size: 15px;">
                  {{$servicio->razonsocial}} <br>
                  {{$servicio->nombre_completo}}<br>
                  {{$servicio->hora_servicio}}
                </td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_reconfirmacion' data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f47321">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea"></b></h4>
            </div>
            <div class="modal-body">
              <table id="example4" class="table table-bordered hover tabla" cellspacing="0" width="100%" style="margin-top: 85px; border-radius: 100px;">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <!--<button type="button" class="btn btn-success guardar_pdf">Guardar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
            </div>
        </div>
      </div>
    </div>

    <!--<div id="motivo_eliminacion" class="motivo_eliminacion hidden" style="width: 1000px; background: gray; border-radius: 100px;">

      <div style="text-align: center; border: 1px solid; background: gray; color: white; font-size: 30px; font-family: Bahnschrift;"><b id="title" class="parpadea"></b></div>

      <div class="col-lg-12">
          <div class="panel panel-default">
              <table id="example4" class="table table-bordered hover tabla" cellspacing="0" width="100%" style="margin-top: 85px; border-radius: 100px;">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th></th>
                      <th></th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
              </table>
          </div>
      </div>
  </div>-->

    @include('modales.transportes.envio_mails_servicios')

    <!-- Opcion de reconfirmacion, variable obligatoria -->
    <?php $option_reconfirmacion = 1; ?>

    @include('scripts.scripts')

    @include('otros.firebase_cloud_messaging')

    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    @include('otros.pusher.servicios_cancelados')

    <script type="text/javascript" src="{{asset('typeahead.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <script type="text/javascript">

      var $table = $('#example').DataTable({
      paging: false,
      searching: false,
      language: {
          processing:     "Procesando...",
          //search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN SERVICIO FINALIZADO EN EL MOMENTO",
          paginate: {
              first:      "Primer",
              previous:   "Antes",
              next:       "Siguiente",
              last:       "Ultimo"
          },
          aria: {
              sortAscending:  ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      'bAutoWidth': false ,
      'aoColumns' : [
          { 'sWidth': '3%' },
      ],
      processing: true,
      "bProcessing": true
      });

      var $table2 = $('#example2').DataTable({
      paging: false,
      searching: false,
      language: {
          processing:     "Procesando...",
          //search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN SERVICIO ACTIVO EN EL MOMENTO",
          paginate: {
              first:      "Primer",
              previous:   "Antes",
              next:       "Siguiente",
              last:       "Ultimo"
          },
          aria: {
              sortAscending:  ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      'bAutoWidth': false ,
      'aoColumns' : [
          { 'sWidth': '3%' },
      ],
      processing: true,
      "bProcessing": true
      });

      var $table3 = $('#example3').DataTable({
      paging: false,
      searching: false,
      language: {
          processing:     "Procesando...",
          //search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN SERVICIO PROGRAMADO EN EL MOMENTO",
          paginate: {
              first:      "Primer",
              previous:   "Antes",
              next:       "Siguiente",
              last:       "Ultimo"
          },
          aria: {
              sortAscending:  ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      'bAutoWidth': false ,
      'aoColumns' : [
          { 'sWidth': '3%' },
      ],
      processing: true,
      "bProcessing": true
      });

      var $table4 = $('#example4').DataTable({
      paging: false,
      searching: false,
      language: {
          processing:     "Procesando...",
          //search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN SERVICIO PROGRAMADO EN EL MOMENTO",
          paginate: {
              first:      "Primer",
              previous:   "Antes",
              next:       "Siguiente",
              last:       "Ultimo"
          },
          aria: {

          }
      },
      'bAutoWidth': false ,
      'aoColumns' : [
          { 'sWidth': '10%' },
          { 'sWidth': '2%' },
      ],
      processing: true,
      "bProcessing": true
      });

    /*Ejecución Validación de Servicios*/
    $( document ).ready(function() {

      var request = setInterval(function(){



        var url = $('meta[name="url"]').attr('content');
        var numero = 1;

        //CONSULTA DE HORA ACTUAL, SERVICIOS POR RECONFIRMAR
        $table3.clear().draw();

        document.getElementById("reloj_sg").classList.remove("rojo");
        document.getElementById("reloj_cs").classList.remove("rojo");
        clearInterval(counter);
        count = initial;
        displayCount(count);

          $.ajax({
              type: 'post',
              url: url+'/transportesbog/buscarordenes',
              processData: false,
              contentType: false,
              success: function(data) {

                  $('#hora').html(data.horaActual)

                  if(data.mensaje===true){

                    var services = 'SERVICIOS';

                    if(data.cantidad===1){
                      playPause1();
                      services = 'SERVICIO';
                    }else if(data.cantidad===2){
                      playPause2();
                    }else if(data.cantidad===3){
                      playPause3();
                    }else if(data.cantidad===4){
                      playPause4();
                    }else if(data.cantidad===5){
                      playPause5();
                    }else if(data.cantidad===6){
                      playPause6();
                    }else if(data.cantidad===7){
                      playPause7();
                    }else if(data.cantidad===8){
                      playPause8();
                    }else if(data.cantidad===9){
                      playPause9();
                    }else if(data.cantidad===10){
                      playPause10();
                    }else if(data.cantidad===11){
                      playPause11();
                    }else if(data.cantidad===12){
                      playPause12();
                    }else if(data.cantidad===13){
                      playPause13();
                    }else if(data.cantidad===14){
                      playPause14();
                    }else if(data.cantidad===15){
                      playPause15();
                    }else if(data.cantidad===16){
                      playPause16();
                    }else if(data.cantidad===17){
                      playPause17();
                    }else if(data.cantidad===18){
                      playPause18();
                    }else if(data.cantidad===19){
                      playPause19();
                    }else if(data.cantidad===20){
                      playPause20();
                    }

                    if(services>1){
                      var complement = 'PENDIENTES POR CONFIRMAR';
                    }else{
                      var complement = 'PENDIENTE POR CONFIRMAR';
                    }
                    $('#title').text('HAY '+data.cantidad+' '+services+' '+complement)

                    $('table#example4 tbody').html('');

                    for(i in data.servicios) {

                        var colorBackgr = '';

                        colorBackgr = 'success';

                        //var btn = '<a type="button" class="btn btn-primary btn-block llamar" data-id="'+data.servicios[i].id+'">Esperando confirmación de usuario <i class="fa fa-mobile" aria-hidden="true"></i></a>';

                        var btn = '<center><div class="estado_servicio_app" style="background: #4CAF50; color: white; margin: 2px 0px; font-size: 14px; padding: 3px 5px; width: 380px; border-radius: 2px; text-align: center">Esperando confirmación de '+data.servicios[i].nombre_completo+'</div></center>'

                        $('table#example4 tbody')
                        .append('<tr id="'+data.servicios[i].id+'">'+
                          '<td style="text-align: center; background: gray; color: white; font-size: 18px; font-family: Bahnschrift">'+data.servicios[i].razonsocial+' - '+data.servicios[i].nombre_completo+' - '+data.servicios[i].hora_servicio+'</td>'+
                          '<td>'+btn+'</td>'+
                          '</tr>');

                      }

                    //$('.motivo_eliminacion').removeClass('hidden');

                    $('#modal_reconfirmacion').modal('show');

                    /*$('#avisos').removeAttr('src').attr('src','http://localhost/autonet/biblioteca_imagenes/'+data.cantidad+'.mp3');
                    var sam = $('#avisos').attr('src');
                    console.log(data.cantidad+ ' , '+sam)*/



                  }else{
                    //$('.motivo_eliminacion').addClass('hidden');
                    $('#modal_reconfirmacion').modal('hide');
                  }

                  document.getElementById("reloj_sg").classList.remove("rojo");
                  document.getElementById("reloj_cs").classList.remove("rojo");
                  clearInterval(counter);
                  initialMillis = Date.now();
                  counter = setInterval(timer, 1);

              },
              error: function (request, status, error) {

              },
              complete: function(){
                var pos = window.name || 0;
                window.scrollTo(0,pos);
                spinf = 'BUSCAR<i class="fa fa-search icon-btn"></i>';
                $('#buscar').html('').append(spinf);

              }
          });

        //servicios activos
        $table2.clear().draw();

          $.ajax({
              type: 'post',
              url: url+'/transportesbog/buscarordenesactivas',
              processData: false,
              contentType: false,
              success: function(data) {

                  if(data.mensaje===true){

                      var j=1;

                      for(i in data.servicios) {

                        var colorBackgr = '';

                        colorBackgr = 'success';

                        if(data.servicios[i].numero_reconfirmaciones==null){
                          var dato = 0;
                        }else{
                          var dato = data.servicios[i].numero_reconfirmaciones;
                        }

                        if(data.servicios[i].celular!=null){
                          var disabled = '';
                        }else{
                          var disabled = 'disabled';
                        }

                        var btn = '<a target="_blank" href="https://wa.me/57'+data.servicios[i].celular+'?text=Aún%20en%20Servicio???%20Recuerde%20finalizar%20el%20servicio%20en%20la%20APP%20cuando%20haya%20finalizado%20el%20recorrido!" type="button" class="btn btn-primary btn-block llamar '+disabled+'" data-id="'+data.servicios[i].id+'">Fin <i class="fa fa-whatsapp" aria-hidden="true"></i></a>';

                        $table2.row.add([
                          data.servicios[i].hora_servicio+'<br>'+data.servicios[i].nombre_completo+'<br>'+data.servicios[i].razonsocial+'<span style="background: #409641; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 50px; border-radius: 200px; float: right">'+dato+'</span>'+'<div style="color: white; margin: 2px 0px; font-size: 11px; padding: 3px 5px; width: 80px; border-radius: 20px; float: left">'+btn+'</div>'
                        ]).draw().nodes().to$().attr('style', 'text-align: center; background: #4CAF50; color: white; font-size: 15px;');

                        j++;
                      }
                    //}
                  }

              },
              error: function (request, status, error) {
                  //alert('Hubo un error, llame al administrador del sistema'+request+status+error);
                  //alert(request.responseText);
                  /*location.reload();*/
              },
              complete: function(){
                var pos = window.name || 0;
                window.scrollTo(0,pos);
                spinf = 'BUSCAR<i class="fa fa-search icon-btn"></i>';
                $('#buscar').html('').append(spinf);

              }
          });

          //servicios finalizados DONE
          /*$table.clear().draw();

            $.ajax({
                type: 'post',
                url: url+'/transportesbog/buscarordenesfinalizadas',
                processData: false,
                contentType: false,
                success: function(data) {

                    if(data.mensaje===true){

                      var j=1;

                      for(i in data.servicios) {

                        var colorBackgr = '';

                        colorBackgr = 'danger';

                        if(data.servicios[i].numero_reconfirmaciones==null){
                          var dato = 0;
                        }else{
                          var dato = data.servicios[i].numero_reconfirmaciones;
                        }
                        $table.row.add([
                          data.servicios[i].hora_servicio+'<br>'+data.servicios[i].nombre_completo+'<br>'+data.servicios[i].razonsocial+'<span style="background: #409641; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 50px; border-radius: 200px; float: right">'+dato+'</span>'
                        ]).draw().nodes().to$().attr('style', 'text-align: center; background: orange; color: white; font-size: 15px;');

                        j++;
                      }

                    }

                },
                error: function (request, status, error) {
                    //alert('Hubo un error, llame al administrador del sistema'+request+status+error);
                    //alert(request.responseText);
                    /*location.reload();
                },
                complete: function(){
                  var pos = window.name || 0;
                  window.scrollTo(0,pos);
                  spinf = 'BUSCAR<i class="fa fa-search icon-btn"></i>';
                  $('#buscar').html('').append(spinf);

                }
            });*/

            //servicios programados
            $table3.clear().draw();

              $.ajax({
                  type: 'post',
                  url: url+'/transportesbog/buscarordenesporiniciar',
                  processData: false,
                  contentType: false,
                  success: function(data) {

                      if(data.mensaje===true){

                          var j=1;

                          for(i in data.servicios) {

                            var colorBackgr = '';

                            colorBackgr = 'info';

                            if(data.servicios[i].numero_reconfirmaciones==null){
                              var dato = 0;
                            }else{
                              var dato = data.servicios[i].numero_reconfirmaciones;
                            }

                            if(data.servicios[i].aceptado_app==0 || data.servicios[i].aceptado_app==null){
                              var acept = '<a href="tel:'+data.servicios[i].celular+'" type="button" class="btn btn-primary btn-block no_aceptado" data-id="'+data.servicios[i].id+'"><i class="fa fa-phone" aria-hidden="true"></i></a>';
                              var btn = '';
                              var color = 'red';
                            }else{
                              var acept = '<a href="tel:'+data.servicios[i].celular+'" type="button" class="btn btn-success btn-block aceptado" data-id="'+data.servicios[i].id+'"><i class="fa fa-phone" aria-hidden="true"></i></a>';
                              var color = '#409641';
                            }


                            $table3.row.add([
                              data.servicios[i].hora_servicio+'<br>'+data.servicios[i].nombre_completo+'<br>'+data.servicios[i].razonsocial+'<span style="background: #409641; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 130px; border-radius: 200px; float: right">Confirmaciones<br>'+dato+'</span>'+'<div style="color: white; margin: 2px 0px; font-size: 11px; padding: 3px 5px; width: 80px; border-radius: 20px; float: left">'+acept+'</div>'
                            ]).draw().nodes().to$().attr('style', 'text-align: center; background: #f47321; color: white; font-size: 12px;');

                            j++;
                          }
                        //}
                      }

                  },
                  error: function (request, status, error) {

                  },
                  complete: function(){
                    var pos = window.name || 0;
                    window.scrollTo(0,pos);
                    spinf = 'BUSCAR<i class="fa fa-search icon-btn"></i>';
                    $('#buscar').html('').append(spinf);
                  }
              });

      }, 10800);
    });

      var count = 0 ;
      var count1 = 0 ;
      var count2 = 0 ;
      var count3 = 0 ;
      var count4 = 0 ;
      var count5 = 0 ;
      var count6 = 0 ;
      var count7 = 0 ;
      var count8 = 0 ;
      var count9 = 0 ;
      var count10 = 0 ;
      var count11 = 0 ;
      var count12 = 0 ;
      var count13 = 0 ;
      var count14 = 0 ;
      var count15 = 0 ;
      var count16 = 0 ;
      var count17 = 0 ;
      var count18 = 0 ;
      var count19 = 0 ;
      var count20 = 0 ;
      var count21 = 0 ;
      var count22 = 0 ;
      var count23 = 0 ;
      var count24 = 0 ;
      var count25 = 0 ;

      function playPause(){
        if(count==0){
            count = 1;
            audio.play();
        }else{
            count = 0;
            audio.pause();
        }
      }

      function playPause1(){
        if(count1==0){
            count1 = 1;
            audio1.play();
        }else{
            count1 = 0;
            audio1.pause();
        }
      }

      function playPause2(){
        if(count2==0){
            count2 = 1;
            audio2.play();
        }else{
            count2 = 0;
            audio2.pause();
        }
      }

      function playPause3(){
        if(count3==0){
            count3 = 1;
            audio3.play();
        }else{
            count3 = 0;
            audio3.pause();
        }
      }

      function playPause4(){
        if(count4==0){
            count4 = 1;
            audio4.play();
        }else{
            count4 = 0;
            audio4.pause();
        }
      }

      function playPause5(){
        if(count5==0){
            count5 = 1;
            audio5.play();
        }else{
            count5 = 0;
            audio5.pause();
        }
      }

      function playPause6(){
        if(count6==0){
            count6 = 1;
            audio6.play();
        }else{
            count6 = 0;
            audio6.pause();
        }
      }

      function playPause7(){
        if(count7==0){
            count7 = 1;
            audio7.play();
        }else{
            count7 = 0;
            audio7.pause();
        }
      }

      function playPause8(){
        if(count8==0){
            count8 = 1;
            audio8.play();
        }else{
            count8 = 0;
            audio8.pause();
        }
      }

      function playPause9(){
        if(count9==0){
            count9 = 1;
            audio9.play();
        }else{
            count9 = 0;
            audio9.pause();
        }
      }

      function playPause10(){
        if(count10==0){
            count10 = 1;
            audio10.play();
        }else{
            count10 = 0;
            audio10.pause();
        }
      }

      function playPause11(){
        if(count11==0){
            count11 = 1;
            audio11.play();
        }else{
            count11 = 0;
            audio11.pause();
        }
      }

      function playPause12(){
        if(count12==0){
            count12 = 1;
            audio12.play();
        }else{
            count12 = 0;
            audio12.pause();
        }
      }

      function playPause13(){
        if(count13==0){
            count13 = 1;
            audio13.play();
        }else{
            count13 = 0;
            audio13.pause();
        }
      }

      function playPause14(){
        if(count14==0){
            count14 = 1;
            audio14.play();
        }else{
            count14 = 0;
            audio14.pause();
        }
      }

      function playPause15(){
        if(count15==0){
            count15 = 1;
            audio15.play();
        }else{
            count15 = 0;
            audio15.pause();
        }
      }

      function playPause16(){
        if(count16==0){
            count16 = 1;
            audio16.play();
        }else{
            count16 = 0;
            audio16.pause();
        }
      }

      function playPause17(){
        if(count17==0){
            count17 = 1;
            audio17.play();
        }else{
            count17 = 0;
            audio17.pause();
        }
      }

      function playPause18(){
        if(count18==0){
            count18 = 1;
            audio18.play();
        }else{
            count18 = 0;
            audio18.pause();
        }
      }

      function playPause19(){
        if(count19==0){
            count19 = 1;
            audio19.play();
        }else{
            count19 = 0;
            audio19.pause();
        }
      }

      function playPause20(){
        if(count20==0){
            count20 = 1;
            audio20.play();
        }else{
            count20 = 0;
            audio20.pause();
        }
      }

      function playPause21(){
        if(count21==0){
            count21 = 1;
            audio21.play();
        }else{
            count21 = 0;
            audio21.pause();
        }
      }

      function playPause22(){
        if(count22==0){
            count22 = 1;
            audio22.play();
        }else{
            count22 = 0;
            audio22.pause();
        }
      }

      function playPause23(){
        if(count23==0){
            count23 = 1;
            audio23.play();
        }else{
            count23 = 0;
            audio23.pause();
        }
      }

      function playPause24(){
        if(count24==0){
            count24 = 1;
            audio24.play();
        }else{
            count24 = 0;
            audio24.pause();
        }
      }

      function playPause25(){
        if(count25==0){
            count25 = 1;
            audio25.play();
        }else{
            count25 = 0;
            audio25.pause();
        }
      }

      $('#example4').on('click', '.llamar', function(event) {

        var id = $(this).attr('data-id');

        formData = new FormData();
        formData.append('id',id);

        $.ajax({
          type: "post",
          url: 'reconfirmarconductorinicio',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.response===true) {

              $('#example4 tbody tr[id="'+id+'"]').fadeOut(1000, function() {

                $(this).remove();
                $.alert('Fue notificado el conductor');

                if ($('#example4 tbody tr').length<1){
                  $('#modal_reconfirmacion').modal('hide');
                }

              });

            }else if (data.response===false) {
              alert('Error en la ejecución!');
            }
        }
        });

      });

      $('#example3').on('click', '.no_aceptado', function(event) {

        var id = $(this).attr('data-id');

        formData = new FormData();
        formData.append('id',id);

        $.ajax({
          type: "post",
          url: 'notificarconductor',
          data: formData,
          processData: false,
          contentType: false,
          success: function(data) {
            if (data.response===true) {

            }else if (data.response===false) {
              alert('Error en la ejecución!');
            }
        }
        });

      });

      var initial = 10 * 1000;
      var count = initial;
      var counter; //10 will  run it every 100th of a second
      var initialMillis;

      function timer() {
        if (count <= 0) {
          clearInterval(counter);
          return;
        }
        var current = Date.now();

        count = count - (current - initialMillis);
        initialMillis = current;
        displayCount(count);
      }

      function displayCount(count) {
        let res = Math.floor(count / 1000);
        let milliseconds = count.toString().substr(-3);
        let seconds = res;


        if (seconds <= 0 && milliseconds <= 0) {
          document.getElementById("reloj_sg").classList.add("rojo");
          document.getElementById("reloj_cs").classList.add("rojo");
          document.getElementById("reloj_sg").innerHTML = 0;
          document.getElementById("reloj_cs").innerHTML = 0;
        } else {
          document.getElementById("reloj_sg").innerHTML = seconds;
          document.getElementById("reloj_cs").innerHTML = milliseconds;
        }

      }

      $('#start').on('click', function() {
        document.getElementById("reloj_sg").classList.remove("rojo");
        document.getElementById("reloj_cs").classList.remove("rojo");
        clearInterval(counter);
        initialMillis = Date.now();
        counter = setInterval(timer, 1);
      });

      $('#stop').on('click', function() {
        clearInterval(counter);
      });

      $('#reset').on('click', function() {
        document.getElementById("reloj_sg").classList.remove("rojo");
        document.getElementById("reloj_cs").classList.remove("rojo");
        clearInterval(counter);
        count = initial;
        displayCount(count);
      });

      displayCount(initial);

    </script>
  </body>
</html>
