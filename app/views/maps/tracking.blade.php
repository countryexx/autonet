<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tracking GPS</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	@include('scripts.styles')
	 <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">    
    <style>     

      /**/
      .rat {
          float: left;
          height: 46px;
          padding: 0 10px;
      }
      .rat:not(:checked) > input {
          position:absolute;
          top:-9999px;
      }
      .rat:not(:checked) > label {
          float:right;
          width:1em;
          overflow:hidden;
          white-space:nowrap;
          cursor:pointer;
          font-size:30px;
          color:#ccc;
      }
      .rat:not(:checked) > label:before {
          content: '★ ';
      }
      .rat > input:checked ~ label {
          color: #ffc700;    
      }
      .rat:not(:checked) > label:hover,
      .rat:not(:checked) > label:hover ~ label {
          color: #deb217;  
      }
      .rat > input:checked + label:hover,
      .rat > input:checked + label:hover ~ label,
      .rat > input:checked ~ label:hover,
      .rat > input:checked ~ label:hover ~ label,
      .rat > label:hover ~ input:checked ~ label {
          color: #c59b08;
      }
      /**/

      .rate {
          float: left;
          height: 46px;
          padding: 0 10px;
          margin-left: 85px;
      }
      .rate:not(:checked) > input {
          position:absolute;
          top:-9999px;
      }
      .rate:not(:checked) > label {
          float: right;
          width:1em;
          overflow:hidden;
          white-space:nowrap;
          cursor:pointer;
          font-size:30px;
          color:#ccc;
      }
      .rate:not(:checked) > label:before {
          content: '★ ';
      }
      .rate > input:checked ~ label {
          color: #ffc700;    
      }
      .rate:not(:checked) > label:hover,
      .rate:not(:checked) > label:hover ~ label {
          color: #deb217;  
      }
      .rate > input:checked + label:hover,
      .rate > input:checked + label:hover ~ label,
      .rate > input:checked ~ label:hover,
      .rate > input:checked ~ label:hover ~ label,
      .rate > label:hover ~ input:checked ~ label {
          color: #c59b08;
      }

      .imagenconductor{
        border: silver 15px solid;
        border-image-source: url("img/img_borde.png");
        border-image-slice: 25;
        height: 100%;

        text-align: justify;
      }
      #map{
        height: 400px;
        width: 100%;
      }
      .text {        
        font-weight:bold;    
        text-transform:uppercase;
      }
      .parpadea {
        
        animation-name: parpadeo;
        animation-duration: 6s;
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
  </style>
</head>
<body>

  @foreach ($servicio as $servicios)
    @if($servicios->ruta===1)
      <div class="container">
        <h1>Disculpa, este servicio no está disponible para darle seguimiento gps.</h1>
      </div>      
    @else

        <div id="right-panel" class="hidden">    
            <div>
                <b>Start:</b>
                <select id="start">
                  <!--Direccion de Inicio -->
                  <option value="{{$servicios->recoger_en}}">PICK UP LOCATION</option>    
                </select>
                <br>
                <b>Waypoints:</b> <br>
                <i>(Ctrl+Click or Cmd+Click for multiple selection)</i> <br>
                <select multiple id="waypoints">
                  <option value="CENTRO COMERCIAL BUENAVISTA, CALLE 98, BARRANQUILLA, ATLÁNTICO, COLOMBIA">Montreal, QBC</option>      
                </select>
                <br>
                <b>End:</b>
                <select id="end">
                  <!--Direccion de Destino -->
                  <option value="{{$servicios->dejar_en}}">DESTINATION PLACE</option>      
                </select>
                <br>
                <input type="submit" id="submit">
            </div>
            <div id="directions-panel"></div>
            <div id="directions-panel2"></div>
        </div>
        
        <div class="col-lg-12" style="height: 100px">
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4 col-xs-5">
              <!--<img src="{{url('img/logo_aotour.png')}}" width="120px">-->
            </div>
            <div class="col-md-12 col-xs-12">
              <!--<h4 style="text-align: left;">TRACKING <i class="fa fa-map-marker" aria-hidden="true"></i></h4>-->
              <center><img src="{{url('img/logo_aotour.png')}}" width="120px"></center>
            </div>
          </div>
          <hr>

          <div class="row">
            <center>
            <div class="col-md-8 col-xs-hidden">
              <label id="estatus" style="color: gray"><span style="color: orange"><b>CARGANDO <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></b></span></label>
              </p>
              <h6 style="margin-bottom: 20px;" class="mensajess">Tracking disponible cuando tu conductor vaya en camino.<br></h6>
            </div> 

          <br>
            <div class="col-md-6 col-xs-6">
              <label id="time" style="color: gray;"><span style="color: orange"><b><!--... <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>--></b></span></label>
              </p>
            </div>  
            <div class="col-md-6 col-xs-6">
              <label id="distance" style="color: gray;"><span style="color: orange"><b><!--... <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>--></b></span></label>
              </p>
            </div>  
            </center>
          </div>
              <div class="row">                         
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: gray">
                          <div class="row">
                            <div class="col-md-12 col-xs-12">
                              <button style="margin-bottom: 7px; float: right; background-color: #f47321" type="button" class="btn btn-warning btn-icon" data-toggle="modal" data-target=".mymodal2">Conductor / Driver<i class="fa fa-info icon-btn" aria-hidden="true"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                        <div class="panel-body">
                          <!-- PANEL DE INFORMACIÓN # 2 MAPA-->
                          <div id="map"></div>
                        </div>                                          
                    </div>
                </div>                          
              </div>
              <div class="row">
                <div class="col-xs-8 calificado">
                    
                  <div class="row">
                    
                      <span style="margin-left: 15px">Servicio Calificado</span>
                        <div class="rat">
                            <input type="radio" id="star5" name="rat" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rat" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rat" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rat" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rat" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>

                    
                  </div>

                </div>

                <!-- Servicio por calificar -->
                <div class="col-xs-6 por_calificar">
                    
                  <div class="row">
                    
                        <span style="margin-left: 15px">Califica tu Servicio</span>
                        <div class="rat">
                            <input type="radio" id="star5" name="rat" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rat" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rat" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rat" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rat" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>

                    
                  </div>

                </div>
                <!-- Servicio por calificar -->
              </div>
              <!--<div class="row">
                <div class="col-xs-6">
                    <span style="margin-left: 15px">Califica el vehículo</span>
                  <div class="row">
                    <div class="col-lg-4 col-lg-push-5">
                    
                        <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>

                    </div>
                  </div>

                </div>
                <div class="col-xs-6">
                  <span style="margin-left: 15px">Califica tu conductor</span>
                  <div class="row">
                    <div class="col-lg-4 col-lg-push-5">
                    
                        <div class="rat">
                            <input type="radio" id="star5" name="rat" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rat" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rat" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rat" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rat" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>

                    </div>
                  </div>
                </div>
              </div>  -->           
              <div class="modal fade mymodal2" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color: #FF7433">
                      <div class="row">
                        <div class="col-md-8 col-xs-8">
                          <h6 class="modal-title" style="text-align: left; font-size: 15px">Información del Conductor</h6>
                        </div>
                        <div class="col-md-4 col-xs-4">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      </div>                      
                    </div>
                    <div class="modal-body">
                      @include('maps.modales.datos_servicio')
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar / Close</button>
                    </div>
                  </div>
                </div>
              </div>              
        </div>

        
    @endif
  @endforeach

  <div class="modal fade" tabindex="-1" role="dialog" id='modal_opciones' data-backdrop="false">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: white">
              <h4 class="modal-title" style="text-align: center; color: black;" id="name"><b id="title" class="parpadea">Califica tu Experiencia </b></h4>
            </div>
            <div class="modal-body">
              <center>
                <div class="row">
                  <div class="col-lg-12">
                    <center><span>¡Tu Servicio ha Finalizado!<br><br>Tu Opinión es muy importante para nosotros. Te invitamos a calificar tu experiencia con nuestro servicio.</span></center>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    
                        <div class="rate">
                            
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">1 star</label>
                            
                        </div>

                    </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <textarea class="form-control" rowspan="10" type="" name="" placeholder="Escribe un comentario (Opcional)" id="comentario"></textarea>
                  </div>
                </div>
                <div class="row" style="margin-top: 10px">
                  <button style="width: 80%;" type="buttom" disabled class="btn btn-success enviar_calificacion">Enviar Calificación <i class="fa fa-star-o" aria-hidden="true"></i></button>
                </div>
              </center>
            </div>

            <div class="modal-footer">
              

              
            </div>
        </div>
      </div>
    </div>
    <input type="number" name="" value="{{$id_ser}}" class="hidden" id="id_ser">
    <div>
      <audio id="audio1">
          <source id="avisos" src="{{url('biblioteca_imagenes/audio-one.mp3')}}" type="audio/mpeg">
      </audio>
      <audio id="audio2">
          <source id="avisos" src="{{url('biblioteca_imagenes/audio-two.mp3')}}" type="audio/mpeg">
      </audio>
      <audio id="audio3">
          <source id="avisos" src="{{url('biblioteca_imagenes/audio-3.mp3')}}" type="audio/mpeg">
      </audio>
      <audio id="audio4">
          <source id="avisos" src="{{url('biblioteca_imagenes/audio-4.mp3')}}" type="audio/mpeg">
      </audio>
    </div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap" async defer></script>

  <script type="text/javascript">

      var count1 = 0;
      var count2 = 0;
      var count3 = 0;
      var count4 = 0;

      $('#star1').click(function(){
        $('.enviar_calificacion').removeAttr('disabled','disabled');
        $('.enviar_calificacion').attr('data-rate',1);
      });

      $('#star2').click(function(){
        $('.enviar_calificacion').removeAttr('disabled','disabled');
        $('.enviar_calificacion').attr('data-rate',2);
      });

      $('#star3').click(function(){
        $('.enviar_calificacion').removeAttr('disabled','disabled');
        $('.enviar_calificacion').attr('data-rate',3);
      });

      $('#star4').click(function(){
        $('.enviar_calificacion').removeAttr('disabled','disabled');
        $('.enviar_calificacion').attr('data-rate',4);
      });

      $('#star5').click(function(){
        $('.enviar_calificacion').removeAttr('disabled','disabled');
        $('.enviar_calificacion').attr('data-rate',5);
      });

      $('.enviar_calificacion').click(function(){

        var id = $('#id_ser').val();
        //alert(id)
        var rate = $(this).attr('data-rate');
        var comentarios = $('#comentario').val();

        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: rate, id: id, comentarios: comentarios}
        }).done(function(data){

          if(data.respuesta==true){
            
            $.confirm({
            title: 'Gracias!',
            content: 'Se ha enviado tu calificación.',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-primary',
                    keys: ['enter', 'shift'],
                    action: function(){

                      location.reload();

                    }

                }
            }        
        });

          }else if(data.respuesta==false){

          }

        });

      });

      function makeMarker( position, icon, title ) {
       new google.maps.Marker({
        position: position,
        map: map,
        icon: icon,
        title: title
       });
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

      function clearMarkers() {
        setMapOnAll(null);
      }
      function deleteMarkers() {  
        markers = [];
      }    
    var la = null;
    var lo = null;

    function initMap(){
      //usamos la API para geolocalizar el usuario
      var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        
        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };

            var id = $('#id_ser').val();

            $.ajax({
              url: '../validarpoliticas',
              method: 'post',
              data: {id: id}
            }).done(function(data){

              if(data.respuesta==false){
                
                $.confirm({
                    title: 'Políticas de tratamiento de datos',
                    content: 'En este enlace puedes consultar los terminos y políticas de uso de datos: <a href="https://aotour.com.co/politicas" target="_blank">https://aotour.com.co/politicas</a>',
                    buttons: {
                        confirm: {
                            text: 'Continuar',
                            btnClass: 'btn-primary',
                            keys: ['enter', 'shift'],
                            action: function(){

                              setMapa(coords);

                            }

                        }
                    }        
                });

              }else if(data.respuesta==true){

                setMapa(coords);

              }

            });
            
           
          },function(error){console.log(error);});
    }

    function setMapa(coords) {

        var polylineOptionsActual = new google.maps.Polyline({
          strokeColor: '#5F6062',
          strokeOpacity: 0.6,
          strokeWeight: 4
        });

        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true, polylineOptions: polylineOptionsActual});  

        // Start/Finish icons
         var icons = {
          start: new google.maps.MarkerImage(
           // URL
           'start.png',
           // (width,height)
           new google.maps.Size( 44, 32 ),
           // The origin point (x,y)
           new google.maps.Point( 0, 0 ),
           // The anchor point (x,y)
           new google.maps.Point( 22, 32 )
          ),
          end: new google.maps.MarkerImage(
           // URL
           'end.png',
           // (width,height)
           new google.maps.Size( 44, 32 ),
           // The origin point (x,y)
           new google.maps.Point( 0, 0 ),
           // The anchor point (x,y)
           new google.maps.Point( 22, 32 )
          )
         };     

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          mapTypeControl: false,
          center: new google.maps.LatLng(coords.lat,coords.lng),
          
          styles: [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#523735"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "administrative",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#c9b2a6"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#dcd2be"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#ae9e90"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#93817c"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#a5b076"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#447530"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f5f1e6"
      }
    ]
  },
  {
    "featureType": "road.arterial",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#fdfcf8"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#f8c967"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#e9bc62"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#e98d58"
      }
    ]
  },
  {
    "featureType": "road.highway.controlled_access",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#db8555"
      }
    ]
  },
  {
    "featureType": "road.local",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#806b63"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8f7d77"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#ebe3cd"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#dfd2ae"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#b9d3c2"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#92998d"
      }
    ]
  }
]
  

        });
        directionsRenderer.setMap(map);

        

        var waypts = [];
        var checkboxArray = document.getElementById('waypoints');
        for (var i = 0; i < checkboxArray.length; i++) {
          if (checkboxArray.options[i].selected) {
            waypts.push({
              location: checkboxArray[i].value,
              stopover: true
            });
          }
        }        

        var id = '{{$id_ser}}';

        var boundsv = new google.maps.LatLngBounds();
        var boundsv2 = new google.maps.LatLngBounds();

        const marcador = new google.maps.Marker({
          position: null,
          map: map,
          title: 'Pick-Up',
          animation: google.maps.Animation.DROP,
          icon: {
            url: "{{url('img/marker_pasajero_recogido.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          zIndex: 5000
        });

        //INFO WINDOW
        var contentStringg = '<div id="content">'+
        '<h4 style="color: orange">Punto de recogida <i class="fa fa-car" aria-hidden="true"></i></h4>'
        '</div>';

        var infowindoww = new google.maps.InfoWindow({
          content: contentStringg
        });

        marcador.addListener('click', function() {
          infowindoww.open(map, marcador);
        });

        //Marcador de ubicación actual
        const ubicacion_usuario = new google.maps.Marker({
          position: null,
          map: map,
          title: 'Aquí estás',
          animation: google.maps.Animation.DROP,
          icon: {
            url: "{{url('img/marker_pasajero.png')}}",
            scaledSize: new google.maps.Size(27, 40)
          },
          zIndex: 5000
        });
        //INFO WINDOW
        var contentStringgs = '<div id="content">'+
        '<h4 style="color: orange">Estás aquí <i class="fa fa-thumb-tack" aria-hidden="true"></i></h4>'
        '</div>';

        var infowindowws = new google.maps.InfoWindow({
          content: contentStringgs
        });

        ubicacion_usuario.addListener('click', function() {
          infowindowws.open(map, ubicacion_usuario);
        });

        var dispo = null;
              
        $.ajax({
            url: '../servicioruta',
            data: {
              id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){                
                //INSTANCIA DEL MARCADOR DEL CONDUCTOR

                //USANDO
                //Marcador del conductor
                var conductor = new google.maps.Marker({
                  position: null,
                  map: map,
                  title: 'Driver',
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: "{{url('img/car.png')}}",
                    scaledSize: new google.maps.Size(45, 45)
                  },
                  zIndex: 5000
                });

                var destinations = new google.maps.Marker({
                  position: null,
                  map: map,
                  title: 'Destino',
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: "{{url('img/marker_bandera2.png')}}",
                    scaledSize: new google.maps.Size(35, 35)
                  },
                  zIndex: 5000
                });

                //INFO WINDOW
                var contentStringd = '<div id="content">'+
                '<h4 style="color: orange">Punto de Destino: '+data.servicio.dejar_en+'</h4>'
                '</div>';

                var infowindowd = new google.maps.InfoWindow({
                  content: contentStringd
                });

                destinations.addListener('click', function() {
                  infowindowd.open(map, destinations);
                });

                //INFO WINDOW
                var contentString = '<div id="content">'+
                '<h4 style="color: orange">Conductor: '+data.conductor+' <i class="fa fa-car" aria-hidden="true"></i></h4>'
                '</div>';

                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                conductor.addListener('click', function() {
                  infowindow.open(map, conductor);
                });

                var positionss =  JSON.parse(data.servicio.hasta);

                console.log(JSON.parse(data.servicio.hasta)[0].lat)
                console.log(parseFloat(positionss[0].lat))

                if(JSON.parse(data.servicio.hasta)[0].lat=='undefined'){
                  //alert('hasta disposicion')
                  dispo = 1;
                }
                //var termina = {
                  //lat: parseFloat(positionss[0].lat),
                  //lng: parseFloat(positionss[0].lng)
                //}

                //USANDO


                  var posicionvacia = {
                    lat: 0,
                    lng: 0
                  }  

                  //Marcador para disposición
                  var marker_disposicion = new google.maps.Marker({
                    position: null,
                    map: map,
                    title: 'Pick-Up',
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: "{{url('img/marker_auto.png')}}",
                      scaledSize: new google.maps.Size(40, 40)
                    },
                    zIndex: 5000
                  });   

                  //INFO WINDOW
                  var contenido_info = '<div id="content">'+
                  '<h4 style="color: orange">Passenger pick-up location <i class="fa fa-map-marker" aria-hidden="true"></i></h4>'
                  '</div>';

                  var infoventana = new google.maps.InfoWindow({
                    content: contenido_info
                  });

                  marker_disposicion.addListener('click', function() {
                    infoventana.open(map, marker_disposicion);
                  });

                               

                  

                if (data.respuesta===true) {  

                  var bounds = new google.maps.LatLngBounds(); 

                  var location_pass = null;
                  var coor = null;

                  var disposicion = 0;
                  var sw = 0;

                  var contadorPosicion = 0;
                  
                  $('.calificado').addClass('hidden');
                  $('.por_calificar').addClass('hidden');

                  if(data.servicio.estado_servicio_app === 2){
                         //servicio finalizado
                        var polyLinesRuta = [];

                        $('.mensajess').addClass('hidden');

                        var posiciones = JSON.parse(data.servicio.recorrido_gps);

                        var estado_servicio_app = data.servicio.estado_servicio_app;

                        var cantidad = posiciones.length;

                        var $divEstado = $('#estado_servicio_modal');

                        var bounds = new google.maps.LatLngBounds();
                        
                        if(data.servicio.calificacion_app_cliente_calidad!=null){
                          
                          $('.calificado').removeClass('hidden');
                          $('.por_calificar').addClass('hidden');

                          if(data.servicio.calificacion_app_cliente_calidad===1){
                            //$('#').attr('style','color: #c59b08');
                            //alert('test')
                            var template = '<input type="radio" id="star5" name="rat" value="5" />'+
                            '<label for="star5" title="text">5 stars</label>'+
                            '<input type="radio" id="star4" name="rat" value="4" />'+
                            '<label for="star4" title="text">4 stars</label>'+
                            '<input type="radio" id="star3" name="rat" value="3" />'+
                            '<label for="star3" title="text">3 stars</label>'+
                            '<input type="radio" id="star2" name="rat" value="2" />'+
                            '<label for="star2" title="text">2 stars</label>'+
                            '<input type="radio" id="star1" name="rat" value="1" />'+
                            '<label for="star1" title="text" style="color: #c59b08">1 star</label>';

                            $('.rat').html(template);

                          }else if(data.servicio.calificacion_app_cliente_calidad===2){

                            var template = '<input type="radio" id="star5" name="rat" value="5" />'+
                            '<label for="star5" title="text">5 stars</label>'+
                            '<input type="radio" id="star4" name="rat" value="4" />'+
                            '<label for="star4" title="text">4 stars</label>'+
                            '<input type="radio" id="star3" name="rat" value="3" />'+
                            '<label for="star3" title="text">3 stars</label>'+
                            '<input type="radio" id="star2" name="rat" value="2" />'+
                            '<label for="star2" title="text" style="color: #c59b08">2 stars</label>'+
                            '<input type="radio" id="star1" name="rat" value="1" />'+
                            '<label for="star1" title="text" style="color: #c59b08">1 star</label>';

                            $('.rat').html(template);

                          }else if(data.servicio.calificacion_app_cliente_calidad===3){

                            var template = '<input type="radio" id="star5" name="rat" value="5" />'+
                            '<label for="star5" title="text">5 stars</label>'+
                            '<input type="radio" id="star4" name="rat" value="4" />'+
                            '<label for="star4" title="text">4 stars</label>'+
                            '<input type="radio" id="star3" name="rat" value="3" />'+
                            '<label for="star3" title="text" style="color: #c59b08">3 stars</label>'+
                            '<input type="radio" id="star2" name="rat" value="2" />'+
                            '<label for="star2" title="text" style="color: #c59b08">2 stars</label>'+
                            '<input type="radio" id="star1" name="rat" value="1" />'+
                            '<label for="star1" title="text" style="color: #c59b08">1 star</label>';

                            $('.rat').html(template);

                          }else if(data.servicio.calificacion_app_cliente_calidad===4){

                            var template = '<input type="radio" id="star5" name="rat" value="5" />'+
                            '<label for="star5" title="text">5 stars</label>'+
                            '<input type="radio" id="star4" name="rat" value="4" />'+
                            '<label for="star4" title="text" style="color: #c59b08">4 stars</label>'+
                            '<input type="radio" id="star3" name="rat" value="3" />'+
                            '<label for="star3" title="text" style="color: #c59b08">3 stars</label>'+
                            '<input type="radio" id="star2" name="rat" value="2" />'+
                            '<label for="star2" title="text" style="color: #c59b08">2 stars</label>'+
                            '<input type="radio" id="star1" name="rat" value="1" />'+
                            '<label for="star1" title="text" style="color: #c59b08">1 star</label>';

                            $('.rat').html(template);

                          }else if(data.servicio.calificacion_app_cliente_calidad===5){

                            var template = '<input type="radio" id="star5" name="rat" value="5" />'+
                            '<label for="star5" title="text" style="color: #c59b08">5 stars</label>'+
                            '<input type="radio" id="star4" name="rat" value="4" />'+
                            '<label for="star4" title="text" style="color: #c59b08">4 stars</label>'+
                            '<input type="radio" id="star3" name="rat" value="3" />'+
                            '<label for="star3" title="text" style="color: #c59b08">3 stars</label>'+
                            '<input type="radio" id="star2" name="rat" value="2" />'+
                            '<label for="star2" title="text" style="color: #c59b08">2 stars</label>'+
                            '<input type="radio" id="star1" name="rat" value="1" />'+
                            '<label for="star1" title="text" style="color: #c59b08">1 star</label>';

                            $('.rat').html(template);

                          }

                        }else{

                          $('.calificado').addClass('hidden');
                          $('.por_calificar').removeClass('hidden');

                        }
                        setTimeout(function(){

                          var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                          var primeraPolyline = {
                            lat: parseFloat(posiciones[0].latitude),
                            lng: parseFloat(posiciones[0].longitude)
                          };

                          polyLinesRuta.push(primeraPolyline);

                          var mapOptions = {
                              center: latLong,
                              zoom: 18,
                              mapTypeId: google.maps.MapTypeId.ROADMAP,
                              disableDefaultUI: true
                          };

                          var icon = {
                              url: 'img/marker3.png',
                              scaledSize: new google.maps.Size(50, 50),
                              origin: new google.maps.Point(0,0),
                              anchor: new google.maps.Point(0, 0)
                          }

                          if (map===null) {
                            map = new google.maps.Map(document.getElementById("map"), mapOptions);
                          }

                          if (trazadoRuta!=null) {
                            trazadoRuta.setMap(null);
                          }                          

                          var marker = new google.maps.Marker({
                            position: latLong,
                            map: map,
                            title: 'Pick-Up',
                            animation: google.maps.Animation.DROP,
                            icon: {
                              url: "{{url('img/marker_pasajero_recogido.png')}}",
                              scaledSize: new google.maps.Size(40, 40)
                            },
                            zIndex: 5000
                          });

                          //INFO WINDOW
                          var contenido = '<div id="content">'+
                          '<h4>Pick-Up: ' +data.servicio.recoger_en+'</h4>'
                          '</div>';

                          var infowindow = new google.maps.InfoWindow({
                            content: contenido
                          });

                          marker.addListener('click', function() {
                            infowindow.open(map, marker);
                          });

                          contadorPosicion++;
                          bounds.extend(marker.position);
                          markers.push(marker);

                          for (var i in posiciones) {

                              if (i>0 && i<cantidad) {
                                position = {
                                  lat: parseFloat(posiciones[i].latitude),
                                  lng: parseFloat(posiciones[i].longitude)
                                }
                                polyLinesRuta.push(position);
                                var latLong = new google.maps.LatLng(posiciones[i].latitude, posiciones[i].longitude);
                                bounds.extend(position);
                                contadorPosicion++;
                              }
                          }

                          if (cantidad>=2) {

                            var finalPolyline = {
                              lat: parseFloat(posiciones[cantidad-1].latitude),
                              lng: parseFloat(posiciones[cantidad-1].longitude)
                            };

                            polyLinesRuta.push(finalPolyline);

                            var latLong = new google.maps.LatLng(posiciones[cantidad-1].latitude, posiciones[cantidad-1].longitude);
                         
                            markerFinal = new google.maps.Marker({
                              position: latLong,
                              map: map,
                              title: 'Destination',
                              animation: google.maps.Animation.DROP,
                              icon: {
                                url: "{{url('img/marker_bandera.png')}}",
                                scaledSize: new google.maps.Size(35, 35)
                              },
                              zIndex: 5000
                            });

                            //INFO WINDOW
                            var contenidofinal = '<div id="content">'+
                            '<h4>Destination: ' +data.servicio.dejar_en+'</h4>'
                            '</div>';

                            var infowindowfinal = new google.maps.InfoWindow({
                              content: contenidofinal
                            });

                            markerFinal.addListener('click', function() {
                              infowindowfinal.open(map, markerFinal);
                            });

                            bounds.extend(markerFinal.position);

                            markers.push(markerFinal);

                          }else{

                            var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                            markerFinal = new google.maps.Marker({
                              position: latLong,
                              map: map,                        
                              animation: google.maps.Animation.DROP,
                              icon: {
                                url: 'img/marker_bandera.png',
                                scaledSize: new google.maps.Size(35, 35)
                              },
                              zIndex: 4000
                            });

                            markers.push(markerFinal);
                          }

                          trazadoRuta = new google.maps.Polyline({
                            path: polyLinesRuta,
                            geodesic: true,
                            strokeColor: '#ff6d33',
                            strokeOpacity: 1.0,
                            strokeWeight: 4,
                            editable: false
                          });

                          trazadoRuta.setMap(map);

                          map.fitBounds(bounds);

                        }, 1500);
                      
                        document.getElementById('estatus').innerHTML = '<span style="background: #FE1111; color: white; font-size: 11px; padding: 6px 5px; width: 67px; border-radius: 2px;">'+ '<b>FINALIZADO</b>'+'</span>';  

                        document.getElementById('time').innerHTML = '';  

                        document.getElementById('distance').innerHTML = '';      


                }else if (data.servicio.estado_servicio_app===1 || data.servicio.estado_servicio_app===null) {
                      
                      const latitud = 10.9987706;
                      const longitud = -74.8001521;
                      
                      const co = {
                        lng: longitud,
                        lat: latitud
                      }

                      if(data.servicio.estado_servicio_app==1 && data.servicio.recoger_pasajero!=1){

                        $('.mensajess').addClass('hidden');

                        var pos =  JSON.parse(data.servicio.recorrido_gps);
                        var valor = pos.length -1;
                        posicion_conductor = {
                          lat: parseFloat(pos[valor].latitude),
                          lng: parseFloat(pos[valor].longitude)
                        }

                        var posisiones =  JSON.parse(data.servicio.desde);

                        var arranca = {
                          lat: parseFloat(posisiones[0].lat),
                          lng: parseFloat(posisiones[0].lng)
                        }

                        //alert()
                        if(data.servicio.recoger_pasajero===null){
                          playPause1();
                        }else{
                          playPause2();
                        }
                        
                        directionsService.route({
                          origin: posicion_conductor,
                          destination: arranca,//'CENTRO COMERCIAL GRAN CENTRO CARRERA 53 NORTE CENTRO HISTORICO BARRANQUILLA ',
                          waypoints: waypts,
                          optimizeWaypoints: true,
                          travelMode: 'DRIVING'
                        }, function(response, status) {
                          if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                            var route = response.routes[0];
                            var summaryPanel = document.getElementById('directions-panel');
                            summaryPanel.innerHTML = '';
                            for (var i = 0; i < route.legs.length; i++) {

                              makeMarker( response.routes[0].legs[0].start_location, icons.start, "title" );
                              makeMarker( response.routes[0].legs[0].end_location, icons.end, 'title' );

                              var routeSegment = i + 1;
                              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                  '</b><br>';
                              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                            }
                          }
                        });


                        conductor.setPosition(posicion_conductor);

                        navigator.geolocation.getCurrentPosition(
                        function (position){
                          coords =  {
                            lng: position.coords.longitude,
                            lat: position.coords.latitude
                          };
                          var latt = position.coords.latitude;
                          var lngg = position.coords.longitude;

                          marcador.setPosition(arranca);

                          //boundsv.extend(posicion_conductor);
                          //boundsv.extend(coords);
                          //map.setZoom(18)
                          //map.fitBounds(boundsv);
                         
                        },function(error){console.log(error);

                        });

                        

                      }else if(data.servicio.estado_servicio_app==1 && data.servicio.recoger_pasajero==1){

                        $('.mensajess').addClass('hidden');

                        var pos =  JSON.parse(data.servicio.recorrido_gps);
                        var valor = pos.length -1;
                        posicion_conductor = {
                          lat: parseFloat(pos[valor].latitude),
                          lng: parseFloat(pos[valor].longitude)
                        }
                        conductor.setPosition(posicion_conductor);
                        playPause3();

                        var posisiones =  JSON.parse(data.servicio.hasta);

                        var termina = {
                          lat: parseFloat(posisiones[0].lat),
                          lng: parseFloat(posisiones[0].lng)
                        }

                        destinations.setPosition(termina);

                        directionsService.route({
                          origin: posicion_conductor,
                          destination: termina,//'CENTRO COMERCIAL GRAN CENTRO CARRERA 53 NORTE CENTRO HISTORICO BARRANQUILLA ',
                          waypoints: waypts,
                          optimizeWaypoints: true,
                          travelMode: 'DRIVING'
                        }, function(response, status) {
                          if (status === 'OK') {
                            directionsRenderer.setDirections(response);

                            makeMarker( response.routes[0].legs[0].start_location, icons.start, "title" );
                            makeMarker( response.routes[0].legs[0].end_location, icons.end, 'title' );

                            var route = response.routes[0];
                            var summaryPanel = document.getElementById('directions-panel');
                            summaryPanel.innerHTML = '';
                            for (var i = 0; i < route.legs.length; i++) {
                              var routeSegment = i + 1;
                              summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                  '</b><br>';
                              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                              summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                            }
                          }
                        });

                      }else if(data.servicio.estado_servicio_app==null){

                        //playPause4();

                        navigator.geolocation.getCurrentPosition(
                        function (position){
                          coords =  {
                            lng: position.coords.longitude,
                            lat: position.coords.latitude
                          };
                          var latt = position.coords.latitude;
                          var lngg = position.coords.longitude;
                          ubicacion_usuario.setPosition(coords);

                          //boundsv.extend(coordss);
                          //boundsv.extend(coords);
                          //map.setZoom(18)
                          //map.fitBounds(boundsv);
                         
                         

                        },function(error){console.log(error);

                        });   

                        coords =  {
                          lng: parseFloat(JSON.parse(data.servicio.desde)[0].lng),
                          lat: parseFloat(JSON.parse(data.servicio.desde)[0].lat)
                        };
                        //alert(parseFloat(JSON.parse(data.servicio.desde)[0].lng))
                        marcador.setPosition(coords);
                        
                        //alert(JSON.parse(data.servicio.desde)[0].lat)
                        posicion_conductor = null;
                      }

                      //SERVICIO PROGRAMADO O INICIADO
                      var switch_pasajero_recogido = 0; //SWITCH QUE DETECTA SI EL PASAJERO HA SIDO RECOGIDO Y ELIMINAR EL MARKER DEL CONDUCTOR
                      var control_servicio_activo_moviendose = 0; //SWITCH QUE CONTROLA SI EL SERVICIO ESTÁ ACTIVO Y MOVIENDOSE GPS
                      var control_inicial = 0; //SWITCH PARA QUE INICIE EL MAPA SIEMPRE AL CARGAR LA PÁGINA
                      var control_posicion_interno = 0;
                      var control_global_posiciones = 0; //SWITCH QUE DETECTA SI EL CARRO CAMBIÓ DE COORDENADAS
                      var control_global_posiciones2 = 0; //SWITCH QUE DETECTA SI EL CARRO CAMBIÓ DE COORDENADAS
                      var ultimo_estado = null;
                      var control_cambio = 0;

                      if(data.estado == 1){
                        
                        document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #409641; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;">EN RUTA</span>';                                  
                      }else if(data.estado == null){
                        
                        document.getElementById('estatus').innerHTML = '<span style="background: #0009FF; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>PROGRAMADO</b></span>';
                      }
                      var prueba = 0;

                      $trackingGps = setInterval(function(){

                          $.ajax({
                            url: '../actualizarmapaviaje',
                            method: 'post',
                            data: {
                              id: id
                            }
                          }).done(function(data){                          
                            
                              //SI NO ESTÁ INICIADO
                              if(data.estado===null){
                                //SE INSTANCIA EL CENTRO DEL MAPA Y EL MAKER DEL RECOGER EN
                                  navigator.geolocation.getCurrentPosition(
                                  function (position){
                                    coords =  {
                                      lng: position.coords.longitude,
                                      lat: position.coords.latitude
                                    };
                                    var latt = position.coords.latitude;
                                    var lngg = position.coords.longitude;

                                    //map.setCenter(coords);
                                    ubicacion_usuario.setPosition(coords);
                                   
                                  },function(error){console.log(error);});  
                                  sw = 1;

                                  coords =  {
                                    lng: parseFloat(JSON.parse(data.desde)[0].lng),
                                    lat: parseFloat(JSON.parse(data.desde)[0].lat)
                                  };
                                  //alert(parseFloat(JSON.parse(data.desde)[0].lng))
                                  marcador.setPosition(coords);
                                
                              //SI ESTÁ INICIADO
                              }else if(data.estado===1 && data.recoger!=1){//ACTIVO, SE MUEVEN LOS MARKERS

                                $('.mensajess').addClass('hidden');

                                conductor.setIcon({
                                  url: "{{url('img/car.png')}}",
                                  scaledSize: new google.maps.Size(45, 45),
                                  fillColor: "#00F",
                                  fillOpacity: 0.8,
                                  strokeWeight: 1
                                });

                                //UBICACIÓN ACTUAL DEL USUARIO
                                navigator.geolocation.getCurrentPosition(
                                function (position){
                                  coords =  {
                                    lng: position.coords.longitude,
                                    lat: position.coords.latitude
                                  };
                                  var latt = position.coords.latitude;
                                  var lngg = position.coords.longitude;
                                  
                                  ubicacion_usuario.setPosition(coords);

                                },function(error){console.log(error);

                                });

                                var pos =  JSON.parse(data.servicio);
                                var valor = pos.length -1;
                                posicion_conductor = {
                                  lat: parseFloat(pos[valor].latitude),
                                  lng: parseFloat(pos[valor].longitude)
                                } 
                                if(valor>control_global_posiciones2){
                                  
                                  var posisionesss =  JSON.parse(data.desde);

                                  var arranca = {
                                    lat: parseFloat(posisionesss[0].lat),
                                    lng: parseFloat(posisionesss[0].lng)
                                  }

                                  marcador.setPosition(arranca);
                                  conductor.setPosition(posicion_conductor);

                                  directionsService.route({
                                    origin: posicion_conductor,
                                    destination: arranca,// 'CENTRO COMERCIAL GRAN CENTRO CARRERA 53 NORTE CENTRO HISTORICO BARRANQUILLA ',
                                    waypoints: waypts,
                                    optimizeWaypoints: true,
                                    travelMode: 'DRIVING'
                                  }, function(response, status) {
                                    if (status === 'OK') {
                                      directionsRenderer.setDirections(response);
                                      var route = response.routes[0];
                                      var summaryPanel = document.getElementById('directions-panel');
                                      summaryPanel.innerHTML = '';

                                      makeMarker( response.routes[0].legs[0].start_location, icons.start, "title" );
                            makeMarker( response.routes[0].legs[0].end_location, icons.end, 'title' );

                                      var time = response.routes[0].legs[0].duration.text;
                                      var distance = response.routes[0].legs[0].distance.text;
                                      //$('#time').html(time)

                                      document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';  

                                      document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                                      for (var i = 0; i < route.legs.length; i++) {
                                        var routeSegment = i + 1;
                                        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                            '</b><br>';
                                        summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                      }
                                    }
                                  });
                                  
                                  boundsv.extend(arranca);
                                  boundsv.extend(posicion_conductor);
                                  map.fitBounds(boundsv);

                                }
                                control_global_posiciones2 = valor;
                              //SI ESTÁ INICIADO Y EL PASAJERO RECOGIDO
                              }else if(data.estado===1 && data.recoger===1){

                                $('.mensajess').addClass('hidden');

                                //UBICACIÓN ACTUAL DEL USUARIO
                                  ubicacion_usuario.setPosition(null)
                                  conductor.setIcon({
                                    url: "{{url('img/car.png')}}",
                                    scaledSize: new google.maps.Size(45, 45),
                                    fillColor: "#00F",
                                    fillOpacity: 0.8,
                                    strokeWeight: 1
                                  });

                                  //UBICACIÓN ACTUAL DEL USUARIO
                                navigator.geolocation.getCurrentPosition(
                                function (position){
                                  coords =  {
                                    lng: position.coords.longitude,
                                    lat: position.coords.latitude
                                  };
                                  var latt = position.coords.latitude;
                                  var lngg = position.coords.longitude;
                                  
                                  var pos =  JSON.parse(data.servicio);
                                  var valor = pos.length -1;
                                  posicion_conductor = {
                                    lat: parseFloat(pos[valor].latitude),
                                    lng: parseFloat(pos[valor].longitude)
                                  } 
                                  if(valor>control_global_posiciones2){
                                    
                                    var posisionesss =  JSON.parse(data.hasta);

                                    var arranca = {
                                      lat: parseFloat(posisionesss[0].lat),
                                      lng: parseFloat(posisionesss[0].lng)
                                    }

                                    //marcador.setPosition(arranca);
                                    conductor.setPosition(posicion_conductor);
                                    destinations.setPosition(arranca);

                                    //boundsv.extend(coords);
                                    //boundsv.extend(posicion_conductor);
                                    //map.fitBounds(boundsv);

                                    if(dispo!=1){

                                      directionsService.route({
                                      origin: posicion_conductor,
                                      destination: arranca,// 'CENTRO COMERCIAL GRAN CENTRO CARRERA 53 NORTE CENTRO HISTORICO BARRANQUILLA ',
                                      waypoints: waypts,
                                      optimizeWaypoints: true,
                                      travelMode: 'DRIVING'
                                    }, function(response, status) {
                                      if (status === 'OK') {
                                        directionsRenderer.setDirections(response);
                                        var route = response.routes[0];
                                        var summaryPanel = document.getElementById('directions-panel');
                                        summaryPanel.innerHTML = '';

                                        var time = response.routes[0].legs[0].duration.text;
                                        var distance = response.routes[0].legs[0].distance.text;
                                        //$('#time').html(time)

                                        document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';  

                                        document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                                        /*for (var i = 0; i < route.legs.length; i++) {
                                          var routeSegment = i + 1;
                                          summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                              '</b><br>';
                                          summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                          summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                          summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                        }*/
                                      }
                                    });

                                    }else{
                                      directionsRenderer.setMap(null)
                                    }
                                    
                                    //map.setZoom(12);

                                  }
                                  control_global_posiciones2 = valor;

                                },function(error){console.log(error);

                                });  

                                  /*var pos =  JSON.parse(data.servicio);
                                  var valor = pos.length -1;
                                  posicion_conductor = {
                                    lat: parseFloat(pos[valor].latitude),
                                    lng: parseFloat(pos[valor].longitude)
                                  } 
                                  //$('#directions-panel').addClass('hidden');
                                  //$('#directions-panel2').removeClass('hidden');
                                  if(valor>control_global_posiciones2){

                                    var posisiones =  JSON.parse(data.hasta);
                                    //alert(posisiones)
                                    var termina = {
                                      lat: parseFloat(posisiones[0].lat),
                                      lng: parseFloat(posisiones[0].lng)
                                    }

                                    marcador.setPosition(null);
                                    conductor.setPosition(posicion_conductor);

                                    boundsv2.extend(posicion_conductor);
                                    //boundsv2.extend(termina);
                                    map.fitBounds(boundsv2);
                                    if(prueba==0){
                                      map.setZoom(14);
                                      prueba=1;
                                    }                                    

                                    //aqui

                                    directionsService.route({
                                      origin: posicion_conductor,
                                      destination: termina,//'CENTRO COMERCIAL GRAN CENTRO CARRERA 53 NORTE CENTRO HISTORICO BARRANQUILLA ',
                                      waypoints: waypts,
                                      optimizeWaypoints: true,
                                      travelMode: 'DRIVING'
                                    }, function(response, status) {
                                      if (status === 'OK') {
                                        directionsRenderer.setDirections(response);
                                        var route = response.routes[0];
                                        var summaryPanel = document.getElementById('directions-panel');
                                        summaryPanel.innerHTML = '';

                                        var time = response.routes[0].legs[0].duration.text;
                                        var distance = response.routes[0].legs[0].distance.text;

                                        document.getElementById('time').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+time+' <i class="fa fa-clock-o" aria-hidden="true"></i></span>';  

                                        document.getElementById('distance').innerHTML = '<span class="text" style="background: gray; color: white; font-size: 13px; padding: 6px 5px; width: 90px; border-radius: 2px;">'+distance+' <i class="fa fa-location-arrow" aria-hidden="true"></i></span>';

                                        for (var i = 0; i < route.legs.length; i++) {
                                          var routeSegment = i + 1;
                                          summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                              '</b><br>';
                                          summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                          summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                          summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                        }
                                      }
                                    });
                                  }
                                  control_global_posiciones2 = valor;  */ 
                              }
                              
                              //OPCIÓN DE FINALIZACIÓN DE SEVICIO O DEJAR DE VER EL MAPA (EVALUAR)
                              //if(data.estado!=ultimo_estado){

                                if(data.estado === 1 && data.recoger === null){
                                  document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #f47321; color: white; padding: 12px; font-size: 15px; width: 100px; border-radius: 10px;">TU CONDUCTOR VIENE EN CAMINO...</span>';
                                }else if(data.estado === 1 && data.recoger === 0){
                                  document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #D1B402; color: white; padding: 12px; font-size: 15px; width: 100px; border-radius: 10px;">TU CONDUCTOR TE ESTÁ ESPERANDO...</span>';
                                }else if(data.estado === 1 && data.recoger === 1){
                                  document.getElementById('estatus').innerHTML = '<span class="text" style="background: #409641; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;">EN RUTA. BUEN VIAJE!</span>';
                                  marcador.setPosition(null);
                                }else if(data.estado === 2){                             
                                  clearInterval($trackingGps);
                                  //alert('SERVICIO FINZALIZADO');

                                  //mostrar ventana de servicio finalizado!
                                  $('#modal_opciones').modal('show');
                                  //location.reload();
                                }else{
                                  document.getElementById('estatus').innerHTML = '<span style="background: #0009FF; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>PROGRAMADO</b></span>';
                                  switch_pasajero_recogido = 1;
                                }
                              //}

                            ultimo_estado = data.estado;

                          }).fail(function(data){//fin ajax
                            alert('Connection problems. Please, check the status of your internet.');
                          });//fin ajax
                      }, 1000);//fin interval funcion
                  }

                }else if (data.respuesta==='relogin') {
                  location.reload();
                }
            }
        });        
    }

    function centerMap(location)
    {
    //var myLatlng = new google.maps.LatLng(location.coords.latitude,location.coords.longitude);
    //map.setCenter(myLatlng);
    //map.setZoom(15);

        //$("#lat").text("Latitude : " + location.coords.latitude);
        //$("#lon").text("Longitude : " + location.coords.longitude);
        //show current location on map
        
        //ubicacion_actual = new google.maps.Marker({
        //position: myLatlng,
        //map: map,
        //zIndex:1
        //});

    //navigator.geolocation.clearWatch(watchId);

     }
    var trazadoRuta = null;
    var markers = [];
  </script>
</body>
</html>