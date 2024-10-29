<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Live View</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
     <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>      
      #map {
        height: 110%;
      }
      html, body {
        height: 90%;
        margin: 0;
        padding: 0;
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
    @include('admin.menu')
    <div class="col-lg-3">
      
      <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 18px; padding: 3px 5px; width: 100%; border-radius: 2px; text-align: center;">Conductores en servicio <i class="fa fa-car esconder parpadea" aria-hidden="true"></i> <i class="fa fa-eye desesconder hidden" aria-hidden="true"></i> </div>

      <table id="drivers" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <td style="text-align: center;">Conductor</td>
            <td style="text-align: center;">Servicio</td>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
        <tfoot>
          <tr>
          <tr>
            <td style="text-align: center;">Conductor</td>
            <td style="text-align: center;">Servicio</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="col-lg-2">
      
      <div class="estado_servicio_app" style="background: blue; color: white; margin: 2px 0px; font-size: 18px; padding: 3px 5px; width: 100%; border-radius: 2px; text-align: center;">Conductores Disponibles <i style="margin-left: 5px" class="fa fa-car esconder parpadea" aria-hidden="true"></i> </div>
      <!--<h2 style="text-align: center">Conductores en servicio</h2>-->

      <table id="availables" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <td style="text-align: center;">Nombre</td>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
        <tfoot>
          <tr>
          <tr>
            <td style="text-align: center;">Nombre</td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div id="map"></div>
    @include('scripts.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/javascript">

      //$(document).on("click", ".localizar", function(){
         //alert($(this).attr('data-id'))
      //});

      var map;
      var markers = [];
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

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat: 4.699686, lng: -74.0812367},
          ////sab center: {lat: 10.635061, lng: -74.928533}
          ////center: {lat: 10.9966892, lng: -74.8006768}
          ////baq 10.9966892 -74.8006768
          ////sab 10.635061 -74.928533
          ////bog 4.699686 -74.0812367
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

        });

        //var trafficLayer = new google.maps.TrafficLayer();
        //trafficLayer.setMap(map);

        positionao = {
          lat: 4.6271526,
          lng: -74.0739239
        }

        var marker_oficina = new google.maps.Marker({
          position: positionao,
          map: map,
          title: 'OFICINA AOTOUR BOGOTÁ',
          animation: google.maps.Animation.DROP,
          icon: {
            url: "{{url('img/marker3.png')}}",
            scaledSize: new google.maps.Size(40, 40)
          },
          zIndex: 5000
        });  
        //INFO WINDOW
        var contentString = '<div>'+
        '<h4>OFICINA AOTOUR BOGOTÁ</h4>'
        '</div>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        //console.log(infowindow);

        marker_oficina.addListener('click', function() {
          infowindow.open(map, marker_oficina);
        });
        //

        //
        setTimeout(function(){

         $.ajax({
            url: 'consultardisponibilidadbog',
            data: {
              id: 1
            },
            method: 'post',
            dataType: 'json',
            success: function(data){

                if (data.respuesta===true) {                    
                      //console.log(data.conductores);
                      var markersconductores = [];
                      var markersconductoresdispo = [];
                     for (var i in data.servicio) {                      

                        var marcador_conductor = data.servicio[i].id;
                        //console.log(marcador_conductor); no se si esto va...
                        /*var nuevas_posiciones = JSON.parse(data.servicio[i].recorrido_gps);
                        
                        if(nuevas_posiciones!=null){
                          
                          var value = nuevas_posiciones.length - 1;
                
                          position = {
                            lat: parseFloat(nuevas_posiciones[value].latitude),
                            lng: parseFloat(nuevas_posiciones[value].longitude)
                          }
                        }*/
                        var name = data.servicio[i].nombre_completo;
                        var ids = data.servicio[i].id;
                        marcador_conductor = new google.maps.Marker({
                          position: null,
                          map: map,
                          title: name,
                          animation: google.maps.Animation.DROP,
                          icon: {
                            url: "{{url('img/car.png')}}",
                            scaledSize: new google.maps.Size(45, 45)
                          },
                          zIndex: 5000
                        }); 
                        //INFO WINDOW
                        var contentString = '<div>'+
                        '<h4>'+name+'</h4>'+
                        '</div>';

                        ids = new google.maps.InfoWindow({
                          content: contentString
                        });
                        //console.log(infowindow);

                        marcador_conductor.addListener('click', function() {
                          ids.open(map, marcador_conductor);
                        });
                        // 
                        markersconductores.push(marcador_conductor);
                                               
                     }         
                     //INSERCIÓN DE MARKERS DE LOS CONDUCTORES EN NULL         
                     for(var i in data.conductores){
                      var id = data.conductores[i].id;
                      var name = data.conductores[i].nombre_completo;
                      
                      id = new google.maps.Marker({
                        position: null,
                        map: map,
                        title: name,
                        animation: google.maps.Animation.DROP,
                        icon: {
                          url: "{{url('img/marker3-final.png')}}",
                          scaledSize: new google.maps.Size(40, 40)
                        },
                        zIndex: 5000
                      });  
                      markersconductoresdispo.push(id);

                     }
                  
                    //INICIO INTERVAL FUNCION 
                          var contadorPosicion = 0;  
                          var position2 = {
                            lat: 0,
                            lng: 0
                          }   
                          var sw = 0;
                          var sw2 = 0;
                          $trackingGps = setInterval(function(){
                            $.ajax({
                              url: 'actualizarmapabog',
                              method: 'post',
                            }).done(function(data){

                              var htmlCode = '';
                              var htmlCodes = '';

                              for (var i in data.servicio) {
                                  var nuevas_posiciones = JSON.parse(data.servicio[i].recorrido_gps);                                    
                                  if(nuevas_posiciones!=null){
                                    //console.log(nuevas_posiciones);
                                    
                                    var value = nuevas_posiciones.length - 1;                                    
                                    position = {
                                      lat: parseFloat(nuevas_posiciones[value].latitude),
                                      lng: parseFloat(nuevas_posiciones[value].longitude)
                                    }
                                    
                                    if(data.servicio[i].estado_servicio_app === 2){
                                      markersconductores[i].setPosition(new google.maps.LatLng(position2));
                                    }else{
                                      markersconductores[i].setPosition(new google.maps.LatLng(position));

                                      var btn = '<a data-id="'+data.servicio[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; float: right" type="button" class="btn btn-info btn-list-table localizar" title="Localizar conductor en el mapa" aria-haspopup="true" aria-expanded="true"><i class="fa fa-eye" aria-hidden="true" style="font-size: 12px;"></i></a>';

                                      var recoger = data.servicio[i].recoger_en;
                                      var dejar = data.servicio[i].dejar_en;

                                      htmlCode += '<tr>'+
                                        '<td><a style="color: #f47321" data-id="'+data.servicio[i].id+'" class="localizar"><b style="font-size: 14px">'+data.servicio[i].nombre_completo+'</b></a></td>'+
                                        '<td><b style="font-size: 14px"> <span style="color: #f47321"><i class="fa fa-map-marker" aria-hidden="true"></i> : </span>'+recoger+'</b><br><b style="font-size: 14px"> <span style="color: #f47321"><i class="fa fa-location-arrow" aria-hidden="true"></i> : </span> '+dejar+'<br><span style="color: #f47321"><i class="fa fa-clock-o" aria-hidden="true"></i> : </span> '+data.servicio[i].hora_servicio+'</b></td>'+
                                      '<tr>';
                                    }

                                                                         
                                }

                              }

                              $('#drivers tbody').html('').append(htmlCode);

                              //Update de markers conductores disponibles
                              for(var o in data.conductores){
                                  var posiciones = JSON.parse(data.conductores[o].gps);
                                  if(posiciones!=null){
                                    var valor = posiciones.length - 1;
                                    
                                    nueva_posicion = {
                                      lat: parseFloat(posiciones[valor].latitude),
                                      lng: parseFloat(posiciones[valor].longitude)
                                    }
                                    //ACTUALIZACIÓNDE GPS CONDUCTORES DISPONIBLES
                                    if(data.conductores[o].estado_aplicacion === 0){
                                      markersconductoresdispo[o].setPosition(new google.maps.LatLng(nueva_posicion));
                                      markersconductoresdispo[o].setIcon({
                                        url: "{{url('img/desconectado.png')}}",
                                        scaledSize: new google.maps.Size(35, 55),
                                        fillColor: "#00F",
                                        fillOpacity: 0.8,
                                        strokeWeight: 1
                                      });
                                    }else{

                                      markersconductoresdispo[o].setPosition(new google.maps.LatLng(nueva_posicion));
                                      markersconductoresdispo[o].setIcon({
                                        url: "{{url('img/marker3-final.png')}}",
                                        scaledSize: new google.maps.Size(45, 45),
                                        fillColor: "#00F",
                                        fillOpacity: 0.8,
                                        strokeWeight: 1
                                      });

                                      htmlCodes += '<tr>'+
                                        '<td><a data-id="'+data.conductores[o].id+'" style="color: blue" class="localizar_available"><b style="font-size: 14px">'+data.conductores[o].nombre_completo+'</b></a></td>'+
                                      '<tr>';
                                    }  
                                  }
                              }

                              $('#availables tbody').html('').append(htmlCodes);
                              
                            }).fail(function(data){
                                alert('Hubo un error en la conexion');
                            });
                        }, 4000);  
                    
                    //FIN INTERVAL FUNCION
            }
          }
        });

     }, 1500);        
        
      }

      $('.esconder').click(function() {
        $(this).addClass('hidden');
        $('.desesconder').removeClass('hidden');
        $('.navbar-custom').addClass('hidden');
      });

      $('.desesconder').click(function() {
        $(this).addClass('hidden');
        $('.esconder').removeClass('hidden');
        $('.navbar-custom').removeClass('hidden');
      });

      $('#drivers').on('click', '.localizar', function(event) {

        var id = $(this).attr('data-id');

        $.ajax({
          url: 'localizarconductor',
          method: 'post',
          data: {id: id}
        }).done(function(data){

          if(data.respuesta==true){
            
            var nuevas_posiciones = JSON.parse(data.servicio.recorrido_gps);
            var value = nuevas_posiciones.length - 1;                                    
            var position = {
              lat: parseFloat(nuevas_posiciones[value].latitude),
              lng: parseFloat(nuevas_posiciones[value].longitude)
            }
            
            changeCenter(position);

          }else if(data.respuesta==false){

          }

        });

        //alert($(this).attr('data-id'))

      });

      $('#availables').on('click', '.localizar_available', function(event) {

        var id = $(this).attr('data-id');

        $.ajax({
          url: 'localizarconductoravailable',
          method: 'post',
          data: {id: id}
        }).done(function(data){

          if(data.respuesta==true){
            
            var nuevas_posiciones = JSON.parse(data.conductor.gps);
            var value = nuevas_posiciones.length - 1;                                    
            var position = {
              lat: parseFloat(nuevas_posiciones[value].latitude),
              lng: parseFloat(nuevas_posiciones[value].longitude)
            }
            
            changeCenter(position);

          }else if(data.respuesta==false){

          }

        });

        //alert($(this).attr('data-id'))

      });

      function changeCenter(center) {

        //var map = new google.maps.Map(document.getElementById('map'), {
          //zoom: 12,
        //});
        map.setCenter(center);
        map.setZoom(18);
        //marker.setPosition(center);
    }

      $drivers = $('#drivers').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
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
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' }
        ],
      });

      $availables = $('#availables').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
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
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '2%' },
          { 'sWidth': '2%' }
        ],
      });

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfYETaybjwqKK2NqkgvQlZd0eswjUmDjY&callback=initMap">
    </script>
    
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>

  </body>
</html>