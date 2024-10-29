<script>

  //inicializar variables
  var $trackingGps = null;
  var map = null;
  var markers = [];
  var trazadoRuta = null;
  var markerFinal = null;

  $('input[type=file]').bootstrapFileInput();
  $('.file-inputs').bootstrapFileInput();

  function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }

  function clearMarkers() {
    setMapOnAll(null);
  }

  function deleteMarkers() {
    clearMarkers();
    markers = [];
  }

  //Iniciar mapa
  function iniciarMapa(id){

    //Ocultar hora de inicio
    if (!$('#label_hora_inicio').hasClass('hidden')) {
      $('#label_hora_inicio').addClass('hidden');
    }

    //Ocultar hora de inicio
    if (!$('#label_hora_final').hasClass('hidden')) {
      $('#label_hora_final').addClass('hidden');
    }

    //url global
    var url = $('meta[name="url"]').attr('content');

    //Request Ajax
    $.ajax({
        url: url+'/transportes/servicioruta',
        data: {
          id: id
        },
        method: 'post',
        dataType: 'json',
        success: function(data){

            if(data.servicio.recorrido_gps==null){

              var text = 'Este servicio no tiene GPS';
              trazadoRuta.setMap(null);
              $.confirm({
                title: 'Atención',
                content: text,
                buttons: {
                    confirm: {
                        text: 'Ok',
                        btnClass: 'btn-primary',
                        keys: ['enter', 'shift'],
                        action: function(){



                        }

                    }
                }
            });

          }else if (data.respuesta===true) {

              var contadorPosicion = 0;

              //Array para polilineas
              var polyLinesRuta = [];

              //Objecto para guardar las coordenadas y timestamps recibidos
              var posiciones = JSON.parse(data.servicio.recorrido_gps);

              //Estado del servicio 1 iniciado, 2 finalizado
              var estado_servicio_app = data.servicio.estado_servicio_app;

              //Hora inicial
              var timestamp_inicial = posiciones[0].timestamp;

              //Cantidad de posiciones (marcadores)
              var cantidad = posiciones.length;

              //Hora final
              var timestamp_final = posiciones[cantidad-1].timestamp;

              //Div de los estados, en servicio o finalizado
              var $divEstado = $('#estado_servicio_modal');

              var bounds = new google.maps.LatLngBounds();

              //Si el servicio esta en proceso (iniciado)
              if (parseInt(estado_servicio_app)===1) {

                  //coloca hora inicial
                  if (data.servicio.hora_inicio) {
                    $('#hora_estado_inicio').text(data.servicio.hora_inicio);
                  }else {
                    $('#hora_estado_inicio').text(timestamp_inicial);
                  }

                  $('#label_hora_inicio').removeClass('hidden');

                  $divEstado.text('EN SERVICIO').addClass('estado_en_servicio').removeClass('estado_en_finalizado');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }

              //Si el servicio esta finalizado
              }else if(parseInt(estado_servicio_app)===2){

                  //Colocar hora inicial
                  if (data.servicio.hora_inicio!=null) {
                    $('#hora_estado_inicio').text(data.servicio.hora_inicio);
                  }else {
                    $('#hora_estado_inicio').text(timestamp_inicial);
                  }

                  //Colocar la hora final
                  if (data.servicio.hora_finalizado!=null) {
                    $('#hora_estado_final').text(data.servicio.hora_finalizado);
                  }else {
                    $('#hora_estado_final').text(timestamp_inicial);
                  }

                  $('#label_hora_inicio').removeClass('hidden');
                  $('#label_hora_final').removeClass('hidden');

                  $divEstado.text('FINALIZADO').addClass('estado_en_finalizado').removeClass('estado_en_servicio').removeClass('parpadea');

                  $('.letrero').addClass('hidden');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }
              }

              //Cargar y inicializar mapa
              setTimeout(function(){

                //Eliminar todos los marcadores.
                deleteMarkers();

                //Posicion inicial
                var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                //insertar primera polilinea
                var primeraPolyline = {
                  lat: parseFloat(posiciones[0].latitude),
                  lng: parseFloat(posiciones[0].longitude)
                };

                //Agregar polilinea a array
                polyLinesRuta.push(primeraPolyline);

                //opciones para inicio de google maps
                var mapOptions = {
                    center: latLong,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    styles: [
                        {
                            "featureType": "water",
                            "stylers": [
                                {
                                    "saturation": 43
                                },
                                {
                                    "lightness": -11
                                },
                                {
                                    "hue": "#0088ff"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "hue": "#ff0000"
                                },
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 99
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.stroke",
                            "stylers": [
                                {
                                    "color": "#808080"
                                },
                                {
                                    "lightness": 54
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ece2d9"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ccdca1"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#767676"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.stroke",
                            "stylers": [
                                {
                                    "color": "#ffffff"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.natural",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "color": "#EBE5E0"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.sports_complex",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ]
                };

                //icon aotour google maps
                var icon = {
                    url: url+'/img/partida.png', // url
                    scaledSize: new google.maps.Size(45, 45), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                }

                //si la variable mapa esta vacia, iniciarla para evitar cargar mapa nuevamente cada vez que se abre
                if (map===null) {
                  map = new google.maps.Map(document.getElementById("map"), mapOptions);
                }

                //si se han iniciado las polilineas limpiarlas
                if (trazadoRuta!=null) {
                  trazadoRuta.setMap(null);
                }

                //marcador inicial
                var marker = new google.maps.Marker({
                  position: latLong,
                  map: map,
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: url+'/img/partida.png',
                    scaledSize: new google.maps.Size(45, 45)
                  },
                  zIndex: 2
                });

                //INFO WINDOW
                var contenidoss = '<div id="content">'+
                '<h4>Aquí inició UP DRIVER</h4>'+
                '</div>';

                var infowindowss = new google.maps.InfoWindow({
                  content: contenidoss
                });

                marker.addListener('click', function() {
                  infowindowss.open(map, marker);
                });

                if(data.servicio.hasta!=null){

                    var posisionesss =  JSON.parse(data.servicio.hasta);

                    var hasta = {
                      lat: parseFloat(posisionesss[0].lat),
                      lng: parseFloat(posisionesss[0].lng)
                    }

                }else{

                    var hasta = {
                        lat: 10.997073,
                        lng: -74.80063
                    }

                }

                var marcador = new google.maps.Marker({
                    position: hasta,
                    map: map,
                    title: 'Lugar de Destino',
                    animation: google.maps.Animation.BOUNCE,
                    icon: {
                      url: "{{url('img/marker_bandera2.png')}}",
                      scaledSize: new google.maps.Size(45, 45)
                    },
                    //zIndex: 5000
                  });

                  //INFO WINDOW
                  var contenidos = '<div id="content">'+
                  '<h4>Lugar de Destino</h4>'+
                  '</div>';

                  var infowindows = new google.maps.InfoWindow({
                    content: contenidos
                  });

                  marcador.addListener('click', function() {
                    infowindows.open(map, marcador);
                  });

                  //MARCADOR DONDE EL SE LLEVARÁ AL PASAJERO
                  if(data.servicio.desde!=null){

                    var posisionees =  JSON.parse(data.servicio.desde);

                    var desde = {
                        lat: parseFloat(posisionees[0].lat),
                        lng: parseFloat(posisionees[0].lng)
                    }

                  }else{

                    var desde = {
                        lat: 10.997073,
                        lng: -74.80063
                    }

                  }

                  var marcadors = new google.maps.Marker({
                      position: desde,
                      map: map,
                      title: 'Lugar de Recogida',
                      animation: google.maps.Animation.BOUNCE,
                      icon: {
                        url: "{{url('img/inicio.png')}}",
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      //zIndex: 5000
                    });

                    //INFO WINDOW
                    var contenido = '<div id="content">'+
                    '<h4>Lugar de Recogida</h4>'+
                    '</div>';

                    var infowindow = new google.maps.InfoWindow({
                      content: contenido
                    });

                    marcadors.addListener('click', function() {
                      infowindow.open(map, marcadors);
                    });
                  //MARCADOR DONDE SE LLEVARÁ AL PASAJERO

                  markers.push(marcador);
                  markers.push(marcadors);

                //contar primer punto
                contadorPosicion++;

                bounds.extend(marker.position);

                markers.push(marker);

                //colocar polilineas
                for (var i in posiciones) {

                    if (i>0 && i<cantidad) {

                      position = {
                        lat: parseFloat(posiciones[i].latitude),
                        lng: parseFloat(posiciones[i].longitude)
                      }

                      polyLinesRuta.push(position);

                      var latLong = new google.maps.LatLng(posiciones[i].latitude, posiciones[i].longitude);

                      bounds.extend(position);

                      //contar puntos
                      contadorPosicion++;

                    }

                }

                if (cantidad>=2) {

                  //polilinea final
                  var finalPolyline = {
                    lat: parseFloat(posiciones[cantidad-1].latitude),
                    lng: parseFloat(posiciones[cantidad-1].longitude)
                  };

                  polyLinesRuta.push(finalPolyline);

                  var latLong = new google.maps.LatLng(posiciones[cantidad-1].latitude, posiciones[cantidad-1].longitude);

                  if(data.servicio.estado_servicio_app==2){
                    //marcador final
                    markerFinal = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: url+'/img/marker_bandera.png',
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      zIndex: 2
                    });
                  }else{
                    //marcador final
                    markerFinal = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: url+'/img/car.png',
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      zIndex: 2
                    });
                  }

                  bounds.extend(markerFinal.position);

                  markers.push(markerFinal);

                }else{

                  var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                  markerFinal = new google.maps.Marker({
                    position: latLong,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: url+'/img/car.png',
                      scaledSize: new google.maps.Size(45, 45)
                    },
                    zIndex: 3
                  });

                  markers.push(markerFinal);
                }

                //trazar ruta con las polylineas
                trazadoRuta = new google.maps.Polyline({
                  path: polyLinesRuta,
                  geodesic: true,
                  strokeColor: 'gray',
                  strokeOpacity: 1.0,
                  strokeWeight: 4,
                  editable: false
                });

                if (data.servicio.recoger_pasajero==1) {

                  var passengerLocation = JSON.parse(data.servicio.recoger_pasajero_location);

                  var ubicacionPasajero = new google.maps.LatLng(passengerLocation.latitude, passengerLocation.longitude);
                  console.log(passengerLocation.latitude)
                  var markerPasajero = new google.maps.Marker({
                    position: ubicacionPasajero,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: url+'/img/no-show.png',
                      scaledSize: new google.maps.Size(45, 45)
                    },
                    zIndex: 1
                  });
//alert(passengerLocation.latitude)
                  /*
                  var markerVelocidad = new google.maps.Marker({
                    position: ubicacionPasajero,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    label: {
                      color: '#ffffff',
                      fontWeight: 'regular',
                      fontSize: '14px',
                      text: '80'
                    },
                    zIndex: 1
                  });*/

                  markers.push(markerPasajero);

                }

                //agregar al mapa
                trazadoRuta.setMap(map);

                map.fitBounds(bounds);

              }, 1500);

              if (estado_servicio_app!=2) {

                $trackingGps = setInterval(function(){

                    $.ajax({
                      url: url+'/transportes/actualizarmapa',
                      method: 'post',
                      data: {
                        id: id
                      }
                    }).done(function(data){

                      var nuevas_posiciones = JSON.parse(data.servicio);

                      for (var i in nuevas_posiciones) {

                        if (i>(contadorPosicion-1)) {

                          position = {
                            lat: parseFloat(nuevas_posiciones[i].latitude),
                            lng: parseFloat(nuevas_posiciones[i].longitude)
                          }

                          polyLinesRuta.push(position);

                          trazadoRuta.setPath(polyLinesRuta);

                          //bounds.extend(position);

                          //map.fitBounds(bounds);

                          contadorPosicion++;

                        }

                      }

                      if (contadorPosicion>1) {
                          markerFinal.setPosition(new google.maps.LatLng(nuevas_posiciones[contadorPosicion-1].latitude, nuevas_posiciones[contadorPosicion-1].longitude));
                      }

                      if(data.estado==1) {
                        //alert('estado activo')
                        $('#hora_estado_inicio').text(timestamp_inicial);

                        $('#label_hora_inicio').removeClass('hidden');

                        $divEstado.text('EN SERVICIO').addClass('parpadea').removeClass('estado_en_finalizado');

                        if ($divEstado.hasClass('hidden')) {
                          $divEstado.removeClass('hidden')
                        }

                        if( $('.letrero').hasClass('hidden')){
                          $('.letrero').removeClass('hidden');
                        }

                        if(data.recoger==null){
                          $('.estado_mensaje').html('El conductor se dirige a buscar al pasajero');
                        }else if(data.recoger==0){
                          $('.estado_mensaje').html('El conductor está esperando al pasajero');
                        }else{
                          $('.estado_mensaje').html('El conductor recogió al pasajero y se dirige al punto de destino');
                        }

                      }else if(data.estado==2){

                        $('#hora_estado_final').text(data.finalizado);

                        $('#label_hora_final').removeClass('hidden');

                        $divEstado.text('FINALIZADO').removeClass('parpadea').removeClass('estado_en_finalizado');

                        $('.estado_mensaje').html('El servicio fue finalizado por el conductor').removeClass('parpadea');

                        markerFinal.setIcon({
                          url: "{{url('img/marker_bandera.png')}}",
                          scaledSize: new google.maps.Size(45, 45),
                          fillColor: "#00F",
                          fillOpacity: 0.8,
                          strokeWeight: 1
                        });
                        //if ($divEstado.hasClass('hidden')) {
                          //$divEstado.removeClass('hidden')
                        //}

                        clearInterval($trackingGps);

                      }

                    }).fail(function(data){
                        alert('Hubo un error en la conexion');
                    });



                }, 3000);

              }

            }else if (data.respuesta==='relogin') {
                location.reload();
            }
        }
    });

  }

  function iniciarMaparuta(id){

    //Ocultar hora de inicio
    if (!$('#label_hora_inicio').hasClass('hidden')) {
      $('#label_hora_inicio').addClass('hidden');
    }

    //Ocultar hora de inicio
    if (!$('#label_hora_final').hasClass('hidden')) {
      $('#label_hora_final').addClass('hidden');
    }

    //url global
    var url = $('meta[name="url"]').attr('content');

    //Request Ajax
    $.ajax({
        url: url+'/transportes/servicioruta',
        data: {
          id: id
        },
        method: 'post',
        dataType: 'json',
        success: function(data){

            if(data.servicio.recorrido_gps==null){

              var text = 'Este servicio no tiene GPS';

              $.confirm({
                title: 'Atención',
                content: text,
                buttons: {
                    confirm: {
                        text: 'Ok',
                        btnClass: 'btn-primary',
                        keys: ['enter', 'shift'],
                        action: function(){



                        }

                    }
                }
            });

            }else if (data.respuesta===true) {

              var contadorPosicion = 0;

              //Array para polilineas
              var polyLinesRuta = [];

              //Objecto para guardar las coordenadas y timestamps recibidos
              var posiciones = JSON.parse(data.servicio.recorrido_gps);

              //Estado del servicio 1 iniciado, 2 finalizado
              var estado_servicio_app = data.servicio.estado_servicio_app;

              //Hora inicial
              var timestamp_inicial = posiciones[0].timestamp;

              //Cantidad de posiciones (marcadores)
              var cantidad = posiciones.length;

              //Hora final
              var timestamp_final = posiciones[cantidad-1].timestamp;

              //Div de los estados, en servicio o finalizado
              var $divEstado = $('#estado_servicio_modal');

              var bounds = new google.maps.LatLngBounds();

              //Si el servicio esta en proceso (iniciado)
              if (parseInt(estado_servicio_app)===1) {

                  //coloca hora inicial
                  if (data.servicio.hora_inicio) {
                    $('#hora_estado_inicio').text(data.servicio.hora_inicio);
                  }else {
                    $('#hora_estado_inicio').text(timestamp_inicial);
                  }

                  $('#label_hora_inicio').removeClass('hidden');

                  $divEstado.text('EN SERVICIO').addClass('estado_en_servicio').removeClass('estado_en_finalizado');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }

              //Si el servicio esta finalizado
              }else if(parseInt(estado_servicio_app)===2){

                  //Colocar hora inicial
                  if (data.servicio.hora_inicio!=null) {
                    $('#hora_estado_inicio').text(data.servicio.hora_inicio);
                  }else {
                    $('#hora_estado_inicio').text(timestamp_inicial);
                  }

                  //Colocar la hora final
                  if (data.servicio.hora_finalizado!=null) {
                    $('#hora_estado_final').text(data.servicio.hora_finalizado);
                  }else {
                    $('#hora_estado_final').text(timestamp_inicial);
                  }

                  $('#label_hora_inicio').removeClass('hidden');
                  $('#label_hora_final').removeClass('hidden');

                  $divEstado.text('FINALIZADO').addClass('estado_en_finalizado').removeClass('estado_en_servicio').removeClass('parpadea');

                  $('.letrero').addClass('hidden');

                  if ($divEstado.hasClass('hidden')) {
                    $divEstado.removeClass('hidden')
                  }
              }

              //Cargar y inicializar mapa
              setTimeout(function(){

                //Eliminar todos los marcadores.
                deleteMarkers();

                //Posicion inicial
                var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                //insertar primera polilinea
                var primeraPolyline = {
                  lat: parseFloat(posiciones[0].latitude),
                  lng: parseFloat(posiciones[0].longitude)
                };

                //Agregar polilinea a array
                polyLinesRuta.push(primeraPolyline);

                //opciones para inicio de google maps
                var mapOptions = {
                    center: latLong,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDefaultUI: true,
                    styles: [
                        {
                            "featureType": "water",
                            "stylers": [
                                {
                                    "saturation": 43
                                },
                                {
                                    "lightness": -11
                                },
                                {
                                    "hue": "#0088ff"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "hue": "#ff0000"
                                },
                                {
                                    "saturation": -100
                                },
                                {
                                    "lightness": 99
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry.stroke",
                            "stylers": [
                                {
                                    "color": "#808080"
                                },
                                {
                                    "lightness": 54
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.man_made",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ece2d9"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "color": "#ccdca1"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [
                                {
                                    "color": "#767676"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.stroke",
                            "stylers": [
                                {
                                    "color": "#ffffff"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "landscape.natural",
                            "elementType": "geometry.fill",
                            "stylers": [
                                {
                                    "visibility": "on"
                                },
                                {
                                    "color": "#EBE5E0"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.park",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        },
                        {
                            "featureType": "poi.sports_complex",
                            "stylers": [
                                {
                                    "visibility": "on"
                                }
                            ]
                        }
                    ]
                };

                //icon aotour google maps
                var icon = {
                    url: url+'/img/partida.png', // url
                    scaledSize: new google.maps.Size(45, 45), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                }

                //si la variable mapa esta vacia, iniciarla para evitar cargar mapa nuevamente cada vez que se abre
                if (map===null) {
                  map = new google.maps.Map(document.getElementById("map"), mapOptions);
                }

                //si se han iniciado las polilineas limpiarlas
                if (trazadoRuta!=null) {
                  trazadoRuta.setMap(null);
                }

                //marcador inicial
                var marker = new google.maps.Marker({
                  position: latLong,
                  map: map,
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: url+'/img/partida.png',
                    scaledSize: new google.maps.Size(45, 45)
                  },
                  zIndex: 2
                });

                var cont = 1;

                for(var o in data.usuarios) {
                  if(data.usuarios[o].coords!=null){
                    var posisionesss =  JSON.parse(data.usuarios[o].coords);
                    var name = data.usuarios[o].fullname+' - '+data.usuarios[o].address;
                    var hasta = {
                      lat: parseFloat(posisionesss[0].lat),
                      lng: parseFloat(posisionesss[0].lng)
                    }

                    var ids = data.usuarios[o].id;

                    if(data.servicio.tipo_ruta!=1){

                      ids = new google.maps.Marker({
                        position: hasta,
                        map: map,
                        title: name,
                        animation: google.maps.Animation.BOUNCE,
                        icon: {
                          url: "{{url('img/stop.png')}}",
                          scaledSize: new google.maps.Size(45, 45)
                        },
                        //zIndex: 5000
                      });

                    }else{

                      var nombre_marcador = '';

                      if(data.usuarios[o].status==1){
                        if(data.usuarios[o].novedad!=null){
                          nombre_marcador = 'recogido-novedad';
                          name += '\n'+data.usuarios[o].novedad;
                        }else{
                          nombre_marcador = 'recogido';
                        }
                      }else if(data.usuarios[o].status==2){
                        nombre_marcador = 'no-show';
                      }else{
                        nombre_marcador = 'sin_estado';
                      }

                      ids = new google.maps.Marker({
                        position: hasta,
                        map: map,
                        title: name,
                        animation: google.maps.Animation.BOUNCE,
                        icon: {
                          url: "{{url('img/"+nombre_marcador+".png')}}",
                          scaledSize: new google.maps.Size(45, 45)
                        },
                        //zIndex: 5000
                      });

                    }

                    markers.push(ids);
                  }
                  cont++;
                }

                if(data.servicio.tipo_ruta==1){ //RUTA DE INGRESO

                  if(data.servicio.hasta!=null){

                        var positions =  JSON.parse(data.servicio.hasta);

                        var hasta = {
                          lat: parseFloat(positions[0].lat),
                          lng: parseFloat(positions[0].lng)
                        }

                    }else{

                        var hasta = {
                            lat: 10.997073,
                            lng: -74.80063
                        }

                    }

                  var marcadorss = new google.maps.Marker({
                      position: hasta,
                      map: map,
                      title: 'Lugar de Destino',
                      animation: google.maps.Animation.BOUNCE,
                      icon: {
                        url: "{{url('img/marker_bandera2.png')}}",
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      //zIndex: 5000
                    });

                    //INFO WINDOW
                    var contenidoss = '<div id="content">'+
                    '<h4>Lugar de Destino</h4>'+
                    '</div>';

                    var infowindowss = new google.maps.InfoWindow({
                      content: contenidoss
                    });

                    marcadorss.addListener('click', function() {
                      infowindowss.open(map, marcadorss);
                    });

                }else{ //RUTA DE SALIDA

                  if(data.servicio.desde!=null){

                        var positions =  JSON.parse(data.servicio.desde);

                        var desde = {
                            lat: parseFloat(positions[0].lat),
                            lng: parseFloat(positions[0].lng)
                          }

                    }else{

                        var desde = {
                            lat: 10.997073,
                            lng: -74.80063
                        }

                    }

                  var marcadorss = new google.maps.Marker({
                      position: desde,
                      map: map,
                      title: 'Lugar de Recogida',
                      animation: google.maps.Animation.BOUNCE,
                      icon: {
                        url: "{{url('img/inicio.png')}}",
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      //zIndex: 5000
                    });

                    markers.push(marcadorss);

                    //INFO WINDOW
                    var contenidoss = '<div id="content">'+
                    '<h4>Lugar de Destino</h4>'+
                    '</div>';

                    var infowindowss = new google.maps.InfoWindow({
                      content: contenidoss
                    });

                    marcadorss.addListener('click', function() {
                      infowindowss.open(map, marcadorss);
                    });

                }

                //contar primer punto
                contadorPosicion++;

                bounds.extend(marker.position);

                markers.push(marker);
                markers.push(marcadorss);

                //colocar polilineas
                for (var i in posiciones) {

                    if (i>0 && i<cantidad) {

                      position = {
                        lat: parseFloat(posiciones[i].latitude),
                        lng: parseFloat(posiciones[i].longitude)
                      }

                      polyLinesRuta.push(position);

                      var latLong = new google.maps.LatLng(posiciones[i].latitude, posiciones[i].longitude);

                      bounds.extend(position);

                      //contar puntos
                      contadorPosicion++;

                    }

                }

                if (cantidad>=2) {

                  //polilinea final
                  var finalPolyline = {
                    lat: parseFloat(posiciones[cantidad-1].latitude),
                    lng: parseFloat(posiciones[cantidad-1].longitude)
                  };

                  polyLinesRuta.push(finalPolyline);

                  var latLong = new google.maps.LatLng(posiciones[cantidad-1].latitude, posiciones[cantidad-1].longitude);

                  if(data.servicio.estado_servicio_app==2){
                    //marcador final
                    markerFinal = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: url+'/img/marker_bandera.png',
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      zIndex: 2
                    });
                  }else{
                    //marcador final
                    markerFinal = new google.maps.Marker({
                      position: latLong,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: {
                        url: url+'/img/car.png',
                        scaledSize: new google.maps.Size(45, 45)
                      },
                      zIndex: 2
                    });
                  }

                  bounds.extend(markerFinal.position);

                  markers.push(markerFinal);

                }else{

                  var latLong = new google.maps.LatLng(posiciones[0].latitude, posiciones[0].longitude);

                  markerFinal = new google.maps.Marker({
                    position: latLong,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: url+'/img/car.png',
                      scaledSize: new google.maps.Size(45, 45)
                    },
                    zIndex: 3
                  });

                  markers.push(markerFinal);
                }

                //trazar ruta con las polylineas
                trazadoRuta = new google.maps.Polyline({
                  path: polyLinesRuta,
                  geodesic: true,
                  strokeColor: 'gray',
                  strokeOpacity: 1.0,
                  strokeWeight: 4,
                  editable: false
                });

                if (data.servicio.recoger_pasajero==1) {

                  var passengerLocation = JSON.parse(data.servicio.recoger_pasajero_location);

                  var ubicacionPasajero = new google.maps.LatLng(passengerLocation.latitude, passengerLocation.longitude);

                  var markerPasajero = new google.maps.Marker({
                    position: ubicacionPasajero,
                    title: 'Aquí el conductor recogió a todos sus pasajeros',
                    map: map,
                    animation: google.maps.Animation.DROP,
                    icon: {
                      url: url+'/img/marker_pasajero_recogido.png',
                      scaledSize: new google.maps.Size(45, 45)
                    },
                    zIndex: 1
                  });

                  /*
                  var markerVelocidad = new google.maps.Marker({
                    position: ubicacionPasajero,
                    map: map,
                    animation: google.maps.Animation.DROP,
                    label: {
                      color: '#ffffff',
                      fontWeight: 'regular',
                      fontSize: '14px',
                      text: '80'
                    },
                    zIndex: 1
                  });*/

                  markers.push(markerPasajero);

                }

                //agregar al mapa
                trazadoRuta.setMap(map);

                map.fitBounds(bounds);

              }, 1500);

              if (estado_servicio_app!=2) {

                $trackingGps = setInterval(function(){

                    $.ajax({
                      url: url+'/transportes/actualizarmapa',
                      method: 'post',
                      data: {
                        id: id
                      }
                    }).done(function(data){

                      var nuevas_posiciones = JSON.parse(data.servicio);

                      for (var i in nuevas_posiciones) {

                        if (i>(contadorPosicion-1)) {

                          position = {
                            lat: parseFloat(nuevas_posiciones[i].latitude),
                            lng: parseFloat(nuevas_posiciones[i].longitude)
                          }

                          polyLinesRuta.push(position);

                          trazadoRuta.setPath(polyLinesRuta);

                          //bounds.extend(position);

                          //map.fitBounds(bounds);

                          contadorPosicion++;

                        }

                      }

                      if (contadorPosicion>1) {
                          markerFinal.setPosition(new google.maps.LatLng(nuevas_posiciones[contadorPosicion-1].latitude, nuevas_posiciones[contadorPosicion-1].longitude));
                      }

                      if(data.estado==1) {
                        //alert('estado activo')
                        $('#hora_estado_inicio').text(timestamp_inicial);

                        $('#label_hora_inicio').removeClass('hidden');

                        $divEstado.text('EN SERVICIO').addClass('parpadea').removeClass('estado_en_finalizado');

                        if ($divEstado.hasClass('hidden')) {
                          $divEstado.removeClass('hidden')
                        }

                        if( $('.letrero').hasClass('hidden')){
                          $('.letrero').removeClass('hidden');
                        }

                        if(data.recoger==null){
                          $('.estado_mensaje').html('El conductor está recogiendo a sus pasajeros');
                        }else if(data.recoger==0){
                          $('.estado_mensaje').html('El conductor está esperando al pasajero');
                        }else{
                          $('.estado_mensaje').html('El conductor terminó de recoger a sus pasajeros y se dirige al punto de destino');
                        }

                      }else if(data.estado==2){

                        $('#hora_estado_final').text(data.finalizado);

                        $('#label_hora_final').removeClass('hidden');

                        $divEstado.text('FINALIZADO').removeClass('parpadea').removeClass('estado_en_finalizado');

                        $('.estado_mensaje').html('El servicio fue finalizado por el conductor').removeClass('parpadea');

                        markerFinal.setIcon({
                          url: "{{url('img/marker_bandera.png')}}",
                          scaledSize: new google.maps.Size(45, 45),
                          fillColor: "#00F",
                          fillOpacity: 0.8,
                          strokeWeight: 1
                        });

                        clearInterval($trackingGps);

                      }

                    }).fail(function(data){
                        alert('Hubo un error en la conexion');
                    });



                }, 3000);

              }

            }else if (data.respuesta==='relogin') {
                location.reload();
            }
        }
    });

  }

  $('#example').on('click', '.ruta_mapa', function(){

    var id = $(this).attr('data-id');

    if( $(this).attr('data-ruta')!=1 ) {
      iniciarMapa(id);
    }else{
      iniciarMaparuta(id);
    }

  });

  /*$('#example').on('click', '.ruta_mapa', function(){

    var id = $(this).attr('data-id');
    iniciarMaparuta(id);

  });*/

  //detener el trackingGps cuando cierran la ventana modal
  $('.mymodal4').on('hidden.bs.modal', function (e) {
      clearInterval($trackingGps);
  });

</script>
