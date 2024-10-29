<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Pasajeros</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style type="text/css">
     

    // centering
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .pac-container {
      z-index: 100000;
    }

    .parpadea {
        
      animation-name: parpadeo;
      animation-duration: 2s;
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

  @include('transportederuta.nabvar')
  
    <div class="col-lg-12">

      <h4 class="h_titulo" style="font-size: 18px;"><b style="font-size: 14px;">Confirmación de Ruta - ''{{$tipo}}''</b></h4>

      <div class="row">
        
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="panel panel-default">
              <div class="panel-heading"><span style="font-size: 12px;"><b style="font-size: 12px;">{{$usuario->fecha}} a las {{$usuario->hora}}</b></span> 


              
            </div>
              <div class="panel-body">
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Nombre:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$usuario->nombres}}" disabled>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Dirección:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="dir" value="{{$usuario->direccion}}" disabled>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Barrio:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$usuario->barrio}}" disabled>
                  </div>

                  @if($usuario->localidad!=null)
                    <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Localidad:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$usuario->localidad}}" disabled>
                    </div>
                  @endif
                  
                  <!-- dos -->
              

                <div class="row">
                  <div class="col-lg-5">
                    <input  type="text" id="latitud" name="latitud" class="hidden" value="{{$usuario->latitude}}" />  
                  </div>
                  <div class="col-lg-5">
                    <input  type="text" id="longitud" name="longitud" class="hidden" value="{{$usuario->longitude}}" />    
                  </div>
                </div>
                <input  type="text" id="user_id" name="user_id" class="hidden" value="{{$usuario->id}}" />
      
                <div >
            
                  <div style="width: 100%">
                    <div style="height: 300px" id="map"></div>
                      <div id="infowindow-content">
                        <img src="" width="16" height="16" id="place-icon" />
                        <span id="place-name" class="title"></span><br />
                        <span id="place-address"></span>
                      </div>
                      <center><div class="estado_servicio_app" style="background: #2FCC2C; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 180px; border-radius: 2px;">¡Dirección confirmada! <i class="fa fa-check-circle" aria-hidden="true"></i></div></center>
                  </div>
                </div>
        
              
            </div>
          </div>
              </div>

      </div>
        
    </div> 

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script>


    var marker;          //variable del marcador
    var coords = {};    //coordenadas obtenidas con la geolocalización

    //Funcion principal
    initMap = function () 
    {

      //usamos la API para geolocalizar el usuario
      navigator.geolocation.getCurrentPosition(
        function (position){
          coords =  {
            lng: $('#longitud').val(),
            lat: $('#latitud').val()
          };
          var latt = position.coords.latitude;
          var lngg = position.coords.longitude;
          setMap(coords);
         
        },function(error){console.log(error);});
        
    }



function setMap (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 16,
        center:new google.maps.LatLng(coords.lat,coords.lng),
        disableDefaultUI: true,
        /*styles: [
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
              "elementType": "labels",
              "stylers": [
                {
                  "visibility": "off"
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
              "elementType": "labels.text",
              "stylers": [
                {
                  "visibility": "off"
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
              "featureType": "poi.business",
              "stylers": [
                {
                  "visibility": "off"
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
              "featureType": "road",
              "elementType": "labels.icon",
              "stylers": [
                {
                  "visibility": "off"
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
              "elementType": "labels",
              "stylers": [
                {
                  "visibility": "off"
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
              "featureType": "transit",
              "stylers": [
                {
                  "visibility": "off"
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
          ]*/

      });

      var image={
        url: 'https://www.flaticon.com/svg/vstatic/svg/1483/1483234.svg?token=exp=1611942318~hmac=7f7d6082eecba34c4c66e02a501a681e',
        scaledSize: new google.maps.Size(55, 55),
      };

      marker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),

      });

}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
</body>
</html>
