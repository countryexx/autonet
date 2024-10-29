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

        <div id="right-panel" class="hidden">    
            <div>
                <b>Start:</b>
                <select id="start">
                  <!--Direccion de Inicio -->
                  <option value="">PICK UP LOCATION</option>    
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
                  <option value="">DESTINATION PLACE</option>      
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
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar / Close</button>
                    </div>
                  </div>
                </div>
              </div>              
        </div>


    @include('scripts.scripts')

    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap" async defer></script>

  <script type="text/javascript">

      function makeMarker( position, icon, title ) {
       new google.maps.Marker({
        position: position,
        map: map,
        icon: icon,
        title: title
       });
      }

      function clearMarkers() {
        setMapOnAll(null);
      }
      function deleteMarkers() {  
        markers = [];
      }    
    var la = null;
    var lo = null;

    function initMapss(){

      var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        
        navigator.geolocation.getCurrentPosition(

          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            
           
          },function(error){console.log(error);});
    }

    function initMap(coords) {

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
          center: new google.maps.LatLng(10.996449624162183,-74.80035671901716),
          
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


        $trackingGps = setInterval(function(){

          $.ajax({
            url: 'actualizarmapanav',
            method: 'post',
            data: {
              id: 123
            }
          }).done(function(data){
              
              coordenadas =  {
                lat: parseFloat(data.coords[0].latitude),
                lng: parseFloat(data.coords[0].longitude)
              };

              console.log(data.coords[0].latitude);
              console.log(data.coords[0].longitude);

              ubicacion_usuario.setPosition(coordenadas);

          }).fail(function(data){
            alert('Connection problems.');
          });

        }, 2000);
                  
  

    var trazadoRuta = null;
    var markers = [];

  }

  </script>
</body>
</html>