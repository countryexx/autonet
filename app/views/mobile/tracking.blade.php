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


      .imagenconductor{
        border: silver 15px solid;
        border-image-source: url("img/img_borde.png");
        border-image-slice: 25;
        height: 100%;

        text-align: justify;
      }
      #map{
        height: 470px;
        width: 100%;
      }
      .text {        
        font-weight:bold;    
        text-transform:uppercase;
      }
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
        </div>
        
        <div class="col-lg-12">
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-4 col-xs-5">
              <img src="{{url('img/logo_aotour.png')}}" width="120px">
            </div>
            <div class="col-md-4 col-xs-6">
              <h4 style="text-align: left;">TRACKING <i class="fa fa-map-marker" aria-hidden="true"></i></h4>
            </div>
          </div>
          <hr style="border: 1px solid black">
          <div class="row">
          <div class="col-md-6 col-xs-6">
            <label id="estatus" style="color: gray"><span style="color: orange"><b>CARGANDO <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></b></span></label>
            </p>
          </div>  
        </div>
              <div class="row">                         
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: gray">
                          <div class="row">
                            <div class="col-md-12 col-xs-12">
                              <button style="margin-bottom: 7px; float: right;" type="button" class="btn btn-warning btn-icon" data-toggle="modal" data-target=".mymodal2">Detalles<i class="fa fa-info icon-btn" aria-hidden="true"></i>
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
                          <h6 class="modal-title" style="text-align: left; font-size: 15px">Información de la Ruta</h6>
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
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar esta Ventana</button>
                    </div>
                  </div>
                </div>
              </div>              
        </div>
    @endif
  @endforeach

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap" async defer></script>

  <script type="text/javascript">
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
        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa        
           
          },function(error){console.log(error);});
    }

    function setMapa(coords) {

        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;       

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: new google.maps.LatLng(coords.lat,coords.lng),
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
            url: "{{url('img/marker_pasajero.png')}}",
            scaledSize: new google.maps.Size(27, 40)
          },
          zIndex: 5000
        });
              
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
                    url: "{{url('img/loading.png')}}",
                    scaledSize: new google.maps.Size(70, 50)
                  },
                  zIndex: 5000
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
                  
                  if(data.servicio.estado_servicio_app === 2){
                        /* //servicio finalizado
                        var polyLinesRuta = [];

                        var posiciones = JSON.parse(data.servicio.recorrido_gps);

                        var estado_servicio_app = data.servicio.estado_servicio_app;

                        var cantidad = posiciones.length;

                        var $divEstado = $('#estado_servicio_modal');

                        var bounds = new google.maps.LatLngBounds();
                        

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
                                scaledSize: new google.maps.Size(40, 40)
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
                                scaledSize: new google.maps.Size(40, 40)
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
                      
                        document.getElementById('estatus').innerHTML = '<span style="background: #FE1111; color: white; font-size: 11px; padding: 6px 5px; width: 67px; border-radius: 2px;">'+ '<b>FINALIZADO</b>'+'</span>';      */                                      

                }else if (data.servicio.estado_servicio_app===1 || data.servicio.estado_servicio_app===null) {
                      
                      const latitud = 10.9987706;
                      const longitud = -74.8001521;
                      
                      const co = {
                        lng: longitud,
                        lat: latitud
                      }

                      if(data.servicio.estado_servicio_app==1 && data.servicio.recoger_pasajero==null){
                        var pos =  JSON.parse(data.servicio.recorrido_gps);
                        var valor = pos.length -1;
                        posicion_conductor = {
                          lat: parseFloat(pos[valor].latitude),
                          lng: parseFloat(pos[valor].longitude)
                        }
                        conductor.setPosition(posicion_conductor);

                        navigator.geolocation.getCurrentPosition(
                        function (position){
                          coords =  {
                            lng: position.coords.longitude,
                            lat: position.coords.latitude
                          };
                          var latt = position.coords.latitude;
                          var lngg = position.coords.longitude;

                          marcador.setPosition(coords);

                          boundsv.extend(posicion_conductor);
                          boundsv.extend(coords);
                          //map.setZoom(18)
                          map.fitBounds(boundsv);
                         
                        },function(error){console.log(error);

                        });   

                      }else if(data.servicio.estado_servicio_app==1 && data.servicio.recoger_pasajero==1){

                        var pos =  JSON.parse(data.servicio.recorrido_gps);
                        var valor = pos.length -1;
                        posicion_conductor = {
                          lat: parseFloat(pos[valor].latitude),
                          lng: parseFloat(pos[valor].longitude)
                        }
                        conductor.setPosition(posicion_conductor);

                      }else if(data.servicio.estado_servicio_app==null){

                        navigator.geolocation.getCurrentPosition(
                        function (position){
                          coords =  {
                            lng: position.coords.longitude,
                            lat: position.coords.latitude
                          };
                          var latt = position.coords.latitude;
                          var lngg = position.coords.longitude;

                          marcador.setPosition(coords);

                          boundsv.extend(posicion_conductor);
                          boundsv.extend(coords);
                          //map.setZoom(18)
                          map.fitBounds(boundsv);
                         
                        },function(error){console.log(error);

                        });   

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
                                    marcador.setPosition(coords);
                                   
                                  },function(error){console.log(error);});  
                                  sw = 1;
                                
                              //SI ESTÁ INICIADO
                              }else if(data.estado===1 && data.recoger===null){//ACTIVO, SE MUEVEN LOS MARKERS

                                conductor.setIcon({
                                  url: "{{url('img/marker_auto.png')}}",
                                  scaledSize: new google.maps.Size(50, 50),
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
                                    
                                    marcador.setPosition(coords);
                                    conductor.setPosition(posicion_conductor);

                                    boundsv.extend(coords);
                                    boundsv.extend(posicion_conductor);
                                    map.fitBounds(boundsv);
                                    //map.setZoom(12);

                                  }
                                  control_global_posiciones2 = valor;

                                },function(error){console.log(error);

                                });                              
                              //SI ESTÁ INICIADO Y EL PASAJERO RECOGIDO
                              }else if(data.estado===1 && data.recoger===1){
                                //UBICACIÓN ACTUAL DEL USUARIO
                                  
                                  conductor.setIcon({
                                    url: "{{url('img/374-3746809_vehicle-tracker-google-map-marker-car-hd-png.png')}}",
                                    scaledSize: new google.maps.Size(70, 50),
                                    fillColor: "#00F",
                                    fillOpacity: 0.8,
                                    strokeWeight: 1
                                  });

                                  var pos =  JSON.parse(data.servicio);
                                  var valor = pos.length -1;
                                  posicion_conductor = {
                                    lat: parseFloat(pos[valor].latitude),
                                    lng: parseFloat(pos[valor].longitude)
                                  } 
                                  if(valor>control_global_posiciones2){

                                    marcador.setPosition(null);
                                    conductor.setPosition(posicion_conductor);

                                    boundsv2.extend(posicion_conductor);
                                    map.fitBounds(boundsv2);
                                    if(prueba==0){
                                      map.setZoom(16);
                                      prueba=1;
                                    }                                    

                                  }
                                  control_global_posiciones2 = valor;   
                              }
                              
                              //OPCIÓN DE FINALIZACIÓN DE SEVICIO O DEJAR DE VER EL MAPA (EVALUAR)
                              //if(data.estado!=ultimo_estado){

                                if(data.estado === 1 && data.recoger === null){
                                  document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #409641; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;">EL CONDUCTOR VIENE EN CAMINO...</span>'; 
                                }else if(data.estado === 1 && data.recoger === 1){
                                  document.getElementById('estatus').innerHTML = '<span class="text" style="background: #409641; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;">EN RUTA. BUEN VIAJE!</span>';
                                  marcador.setPosition(null);
                                }else if(data.estado === 2){                             
                                  clearInterval($trackingGps);
                                  alert('SERVICIO FINZALIZADO');
                                  location.reload();
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
    var trazadoRuta = null;
    var markers = [];
  </script>
</body>
</html>