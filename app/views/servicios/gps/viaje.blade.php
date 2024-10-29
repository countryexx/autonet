<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AOTOUR | Trip Code: {{$id_ser}}</title>
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
        <h1>Sorry, this route is not available for gps tracking.</h1>
      </div>
    @else
      <h4 style="text-align: center;">GPS TRACKING <i class="fa fa-map-marker" aria-hidden="true"></i></h4>
    	<hr>
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
              <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                      <div class="panel panel-default">
                          <div class="panel-heading"><p style="text-align: left; color: #FF7433"><b>DRIVER INFORMATION</b></p></div>
                          <div class="panel-body" style="height: 100%">
                              <!-- PANEL DE INFORMACIÓN # 1 -->
                              <div class="row">
                                <center>
                                  @if($servicios->foto!='FALSE' and $servicios->foto!='NULL')
                                    <img class="foto_conductor" src="{{url('https://app.aotour.com.co/autonet/biblioteca_imagenes/proveedores/conductores/'.$servicios->foto.'')}}" alt="" style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;">
                                    <!--
                              	     <img class="imagenconductor" src="{{url('https://app.aotour.com.co/autonet/biblioteca_imagenes/proveedores/conductores/'.$servicios->foto.'')}}" width="280px" height="240px" display= "block" >
-->
                                    <img class="hidden" src="{{url('img/samuel.JPEG')}}" width="280px" height="168px" display= "block" >
                                   @else
                                    <img class="foto_conductor" src="{{url('https://app.aotour.com.co/autonet/biblioteca_imagenes/foto-perfil.jpg')}}" alt="" style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;">
                                   @endif
                                 </center>
                              </div>
                              <hr>
                              @include('modales.conductor')
                          </div>
                      </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><p style="text-align: left; color: #FF7433"><b>MAP</b></p>
                          <div class="row">
                            <div class="col-md-6 col-xs-6">
                              <button style="margin-bottom: 7px;" type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">MORE INFORMATION<i class="fa fa-info icon-btn" aria-hidden="true"></i>
                              </button>
                            </div>
                            <div class="col-md-6 col-xs-6">
                              <p style="color: #918984"><b>STATUS:</b>
                              <label id="estatus" style="color: gray"><span style="color: orange"><b>LOADING <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></b></span></label>
                              </p>
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
                      <h5 class="modal-title" style="text-align: center; font-size: 20px">Service Information</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      @include('modales.tabla')
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: #918984; color: white">Close the window</button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    @endif
  @endforeach

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap" async defer></script>

  <script type="text/javascript">
      function clearMarkers() {
        setMapOnAll(null);
      }
      function deleteMarkers() {
        markers = [];
      }

    function initMap() {

        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: 4.570868, lng: -74.297333},
					disableDefaultUI: true
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

        $.ajax({
            url: '../servicioruta',
            data: {
              id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){
                //INSTANCIA DEL MARCADOR DEL CONDUCTOR
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
                      url: "{{url('img/marker_pasajero_recogido.png')}}",
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

                  //Marcador del conductor
                  var conductor = new google.maps.Marker({
                    position: null,
                    map: map,
                    title: 'Driver',
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: "{{url('img/marker_auto.png')}}",
                      scaledSize: new google.maps.Size(40, 40)
                    },
                    zIndex: 5000
                  });

                  //INFO WINDOW
                  var contentString = '<div id="content">'+
                  '<h4 style="color: orange">I am '+data.conductor+', I am driving... <i class="fa fa-car" aria-hidden="true"></i></h4>'
                  '</div>';

                  var infowindow = new google.maps.InfoWindow({
                    content: contentString
                  });

                  conductor.addListener('click', function() {
                    infowindow.open(map, conductor);
                  });

                if (data.respuesta===true) {

                  var bounds = new google.maps.LatLngBounds();

                  var location_pass = null;
                  var coor = null;

                  var disposicion = 0;
                  var sw = 0;

                  var contadorPosicion = 0;

                  if(data.servicio.estado_servicio_app === 2){

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
                              zoom: 15,
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

                        document.getElementById('estatus').innerHTML = '<span style="background: #FE1111; color: white; font-size: 11px; padding: 6px 5px; width: 67px; border-radius: 2px;">'+ '<b>FINISHED</b>'+'</span>';

                }else if (data.servicio.estado_servicio_app===1 || data.servicio.estado_servicio_app===null) {
                      //SERVICIO PROGRAMADO O INICIADO
                      var switch_pasajero_recogido = 0; //SWITCH QUE DETECTA SI EL PASAJERO HA SIDO RECOGIDO Y ELIMINAR EL MARKER DEL CONDUCTOR
                      var control_servicio_activo_moviendose = 0; //SWITCH QUE CONTROLA SI EL SERVICIO ESTÁ ACTIVO Y MOVIENDOSE GPS
                      var control_inicial = 0; //SWITCH PARA QUE INICIE EL MAPA SIEMPRE AL CARGAR LA PÁGINA
                      var control_posicion_interno = 0;
                      var control_global_posiciones = 0; //SWITCH QUE DETECTA SI EL CARRO CAMBIÓ DE COORDENADAS
                      var control_global_posiciones2 = 0; //SWITCH QUE DETECTA SI EL CARRO CAMBIÓ DE COORDENADAS
                      var ultimo_estado = null;
                      var control_cambio = 0;
                      $trackingGps = setInterval(function(){

                          $.ajax({
                            url: '../actualizarmapaviaje',
                            method: 'post',
                            data: {
                              id: id
                            }
                          }).done(function(data){
                            if(disposicion===0){

                                if(data.estado===null){
                                  //SI ESTÁ EN ESTADO PROGRAMADO, MUESTRA LA UBICACIÓN (PUNTO A) ORIGINAL (RECOGER EN)
                                  position = document.getElementById('start').value;

                                }else{

                                  //SI ESTÁ EN INICIADO, SE OBTIENEN LAS COORDENADAS EN UNA VARIABLE
                                  var nuevas_posiciones = JSON.parse(data.servicio);
                                  var value = nuevas_posiciones.length - 1;
                                  position = {
                                    lat: parseFloat(nuevas_posiciones[value].latitude),
                                    lng: parseFloat(nuevas_posiciones[value].longitude)
                                  }

                                  //VALIDA SI EL PASAJERO FUE RECOGIDO Ó SI ESTÁ EL SERVICIO ACTIVO
                                  if(value>control_posicion_interno || data.recoger===1){
                                    switch_pasajero_recogido = 2;
                                  }else{
                                    switch_pasajero_recogido = 1;
                                  }

                                  //VALIDA EL SI HUBO CAMBIO DE POSICIÓN EN EL GPS
                                  if(value>control_global_posiciones){
                                    control_servicio_activo_moviendose = 1;
                                  }else{
                                    control_servicio_activo_moviendose = 0;
                                  }
                                }
                                if(control_inicial==0){

                                  //ENTRA PRIMERO CADA VEZ QUE SE CARGA LA PÁGINA
                                      directionsService.route({
                                        origin: document.getElementById('start').value,
                                        destination: document.getElementById('end').value,
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
                                            var routeSegment = i + 1;
                                            summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                                '</b><br>';
                                            summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                            summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                            summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                          }
                                        }else{
                                          disposicion = 1;

                                           //ADDRESS TO COORD DEL PASAJERO
                                            geocoder = new google.maps.Geocoder();
                                            geocoder.geocode({'address': document.getElementById('start').value}, function(results, status) {
                                              if (status === 'OK') {
                                                location_pass = results[0].geometry.location;
                                                coor = JSON.stringify(location_pass);
                                                //var a = t.lat;
                                                //alert(a)
                                              } else {
                                                alert('Geocode was not successful for the following reason: ' + status);
                                              }
                                            });
                                        }
                                      });

                                }else if(switch_pasajero_recogido==2){
                                  //ENTRA AQUÍ SI ESTÁ El SERVICIO ACTIVO
                                  if(data.recoger===null){
                                    //SI NO HA RECOGIDO AL PASAJERO, SOLO SE ACTUALIZA LA POSICIÓN DEL MARKER DEL CONDUCTOR
                                      var pos =  JSON.parse(data.servicio);
                                      var valor = pos.length -1;
                                      posicion_conductor = {
                                        lat: parseFloat(pos[valor].latitude),
                                        lng: parseFloat(pos[valor].longitude)
                                      }
                                      conductor.setPosition(new google.maps.LatLng(posicion_conductor));
                                  }else if(data.recoger!=null && control_servicio_activo_moviendose===1){
                                    //SI YA RECOGIÓ AL PASAJERO, SE ELIMINA EL MARKER DEL CONDUCTOR Y SE MUEVEN LOS OTROS MARKERS CON LAS UBICACIONES DE PARTIDA (GPS) Y DESTINO (DEJAR EN)
                                      directionsService.route({
                                        origin: position,
                                        destination: document.getElementById('end').value,
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
                                            var routeSegment = i + 1;
                                            summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment +
                                                '</b><br>';
                                            summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                            summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                            summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                          }
                                        }
                                      });
                                      conductor.setPosition(new google.maps.LatLng(posicionvacia));
                                  }
                                  //ASIGNAR VALOR DE CONTADOR DE LA ÚLTIMA POSICIÓN OBTENIDA PARA COMPARAR
                                  control_posicion_interno = value;
                                }//CIERRE switch_pasajero_recogido=2 EN SERVICIO

                                if(control_inicial!=0){
                                  control_global_posiciones = value;
                                }
                                control_inicial=1; //SE ASIGNA 1 PARA QUE NO ENTRE EN LA CARGA INICIAL DEL MAPA

                                if(data.estado === 1){
                                  document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #409641; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;">ON SERVICE</span>';
                                }else if(data.estado === 2){
                                  clearInterval($trackingGps);
                                  alert('FINISHED SERVICE');
                                  location.reload();
                                }else{
                                  document.getElementById('estatus').innerHTML = '<span style="background: #0009FF; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>SCHEDULED</b></span>';
                                  switch_pasajero_recogido = 1;
                                }

                            }else{//else de disposicion

                              //SI NO ESTÁ INICIADO
                              if(data.estado===null){
                                //SE INSTANCIA EL CENTRO DEL MAPA Y EL MAKER DEL RECOGER EN
                                if(sw===0){
                                  sw = 1;
                                  map.setCenter(location_pass);
                                  marker_disposicion.setPosition(location_pass);
                                }
                              //SI ESTÁ INICIADO SIN RECOGER AL PASAJERO
                              }else if(data.estado===1 && data.recoger===null){//ACTIVO, SOLO SE MUEVE EL MARKER CONDUCTOR

                                if(sw===0){
                                  sw = 1;
                                  map.setCenter(location_pass);
                                  marker_disposicion.setPosition(location_pass);
                                }

                                var pos =  JSON.parse(data.servicio);
                                var valor = pos.length -1;
                                posicion_conductor = {
                                  lat: parseFloat(pos[valor].latitude),
                                  lng: parseFloat(pos[valor].longitude)
                                }
                                if(valor>control_global_posiciones2){
                                  conductor.setPosition(new google.maps.LatLng(posicion_conductor));

                                  //SE CENTRA EL MAPA CON RESPECTO A LA POSICIÓN DEL CONDUCTOR Y DEL PASAJERO
                                  bounds.extend(conductor.position);
                                  bounds.extend(marker_disposicion.position);
                                  map.fitBounds(bounds);
                                }
                                control_global_posiciones2 = valor;

                              //SI ESTÁ INICIADO Y EL PASAJERO RECOGIDO
                              }else if(data.estado===1 && data.recoger===1){

                                var pos =  JSON.parse(data.servicio);
                                var valor = pos.length -1;
                                posicion_conductor = {
                                  lat: parseFloat(pos[valor].latitude),
                                  lng: parseFloat(pos[valor].longitude)
                                }

                                if(control_cambio===0){
                                  map.setCenter(posicion_conductor);
                                  map.setZoom(15);
                                  marker_disposicion.setPosition(null);
                                  control_cambio = 1;
                                }

                                if(valor>control_global_posiciones2){
                                  conductor.setPosition(new google.maps.LatLng(posicion_conductor));

                                  map.setCenter(posicion_conductor);
                                }

                                control_global_posiciones2 = valor;
                              }

                              if(data.estado!=ultimo_estado){

                                if(data.estado === 1){
                                  document.getElementById('estatus').innerHTML = '<span class="parpadea text" style="background: #409641; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;">ON SERVICE</span>';
                                }else if(data.estado === 2){
                                  clearInterval($trackingGps);
                                  alert('FINISHED SERVICE');
                                  location.reload();
                                }else{
                                  document.getElementById('estatus').innerHTML = '<span style="background: #0009FF; color: white; font-size: 10px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>SCHEDULED</b></span>';
                                  switch_pasajero_recogido = 1;
                                }
                              }
                              //alert(conductor.position);
                              //alert(marker_disposicion.position);
                              ultimo_estado = data.estado;

                            }

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
