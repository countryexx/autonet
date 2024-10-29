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

              <a class="btn btn-success btn-list-table confirmar_ubicacion parpadea" style="float: right">Confirmar ubicación <i class="fa fa-check" aria-hidden="true"></i></a>

              <a class="btn btn-primary btn-list-table actualizar parpadea hidden" style="float: right">Actualizar ubicación <i class="fa fa-floppy-o" aria-hidden="true"></i></a>
            </div>
              <div class="panel-body">
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Nombre:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$usuario->nombres}}" disabled>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Dirección:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="dir" value="{{$usuario->direccion}}" >
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Barrio:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="bar" value="{{$usuario->barrio}}" disabled>
                  </div>

                  @if($usuario->localidad!=null)
                    <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b style="font-size: 11px">Localidad:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="loc" value="{{$usuario->localidad}}" disabled>
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
                      <div>
                          <strong style="font-family: monospace; font-size: 14px; color: #2FCC2C; text-align: center; margin: 15px"><i class="fa fa-info-circle" aria-hidden="true" style="color: orange"></i> Mueve el marcador hacia tu dirección exacta. <br> </strong>
                      </div>
                  </div>
                </div>
        
              
            </div>
          </div>
              </div>
              <!--<div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="panel panel-default">
                      <div class="panel-heading"><b style="font-size: 20px;">QR</b></div>
                      <div class="panel-body">
                        <img src="{{url('biblioteca_imagenes/qr_codes/'.$usuario->id.'.png')}}" style="width: 300px; height: 280px; border: white 6px solid; margin-left: 55px;" id="imagen">
                      </div>
                  </div>
              </div>-->
              <!--<div class="col-lg-4 col-md-4 col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><b style="font-size: 20px;"></b></div>
                    <div class="panel-body">
                      <span style="font-size: 18px"></span>
                    </div>
                </div>
              </div>-->

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
            setMap(coords);  //pasamos las coordenadas al metodo para crear el mapa
            //$('#form_editar_pasajeros [name="latitud"]').value = latt;
            //$('#form_editar_pasajeros [name="longitud"]').value = lngg;
            //document.getElementById("latitud").value = latt;
            //document.getElementById("longitud").value = lngg;
            //document.getElementById("coords").value = latt+","+ lngg;
            
           
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

      });

      var image={
        url: 'https://www.flaticon.com/svg/vstatic/svg/1483/1483234.svg?token=exp=1611942318~hmac=7f7d6082eecba34c4c66e02a501a681e',
        scaledSize: new google.maps.Size(55, 55),
      };

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
//        icon: image,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),

      });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("latitud").value = this.getPosition().lat();
        document.getElementById("longitud").value = this.getPosition().lng();
        console.log(this)
      });

      //
      var geocoder = new google.maps.Geocoder();     

      //le asignamos una funcion al eventos dragend del marcado
      google.maps.event.addListener(marker, 'dragend', function() {

        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {

            var address=results[0]['formatted_address'];
            //$('#form_editar_pasajeros [name="direccion"]').val(address);
            document.getElementById("dir").value = address;

          }

        });

      });
      //

      //TEST AUTOCOMPLETAR
            var card = document.getElementById("pac-card");
        var input = document.getElementById("dir");
        //map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var autocomplete = new google.maps.places.Autocomplete(input);
        
        autocomplete.bindTo("bounds", map);
        
        autocomplete.setFields([
          "address_components",
          "geometry",
          "icon",
          "name",
        ]);
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        /*var marker = new google.maps.Marker({
          map,
          anchorPoint: new google.maps.Point(0, -29),
          icon: null
        });*/
        autocomplete.addListener("place_changed", () => {

          $('.confirmar_ubicacion').addClass('hidden');
          $('.actualizar').removeClass('hidden');

          $('.actualizar').addClass('parpadea').removeAttr('disabled', 'disabled');

          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          
          if (!place.geometry) {
            
            window.alert(
              "No details available for input: '" + place.name + "'"
            );
            return;
          }

          
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(16); // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          document.getElementById("latitud").value = place.geometry.location.lat();
          document.getElementById("longitud").value = place.geometry.location.lng();
          //$('#latitud').val(place.geometry.location.lat())
          //$('#longitud').val(place.geometry.longitude.lng())
          let address = "";

          if (place.address_components) {
            address = [
              (place.address_components[0] &&
                place.address_components[0].short_name) ||
                "",
              (place.address_components[1] &&
                place.address_components[1].short_name) ||
                "",
              (place.address_components[2] &&
                place.address_components[2].short_name) ||
                "",
            ].join(" ");
          }
        });
            //FIN AUTOCOMPLETAR
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// Carga de la libreria de google maps 

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>


<script type="text/javascript">

    $('#dir').keyup(function(e){
      $('.confirmar_ubicacion').addClass('hidden');
      $('.actualizar').removeClass('hidden');
      $('.actualizar').removeClass('parpadea').attr('disabled', 'disabled');
    });

    //$('.confirmar_ubicacion').

    $('.ver_ubicacion').click(function () {

      var lat = $(this).attr('lat');
      var lng = $(this).attr('lng');

      //usamos la API para geolocalizar el usuario
        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            var latt = position.coords.latitude;
            var lngg = position.coords.longitude;

            //Se crea una nueva instancia del objeto mapa
            var map = new google.maps.Map(document.getElementById('mapa'),
            {
              zoom: 16,
              center:new google.maps.LatLng(lat,lng),

            });

            var image={
              url: 'https://www.flaticon.com/svg/vstatic/svg/1483/1483234.svg?token=exp=1611942318~hmac=7f7d6082eecba34c4c66e02a501a681e',
              scaledSize: new google.maps.Size(55, 55),
            };

            marker = new google.maps.Marker({
              map: map,
              draggable: false,
              animation: google.maps.Animation.DROP,
              position: new google.maps.LatLng(lat,lng),

            });
           
          },function(error){console.log(error);});

      $('#name').html($(this).attr('name-user'));
      $('#dirs').val($(this).attr('dir-user'));
      $('#modal_ubicacion').modal('show')

    });

    $('.actualizar, .confirmar_ubicacion').click(function() {

      var user_id = $('#user_id').val();
      var direccion = $('#dir').val();
      var barrio = $('#bar').val();
      var localidad = $('#loc').val();
      var lat = $('#latitud').val();
      var lng = $('#longitud').val();

      var texts = '<p style="font-size: 20px">Este es tu resumen:</p>'+
        '<b>DIRECCIÓN:</b> '+direccion+'<br>'+
        '<b>BARRIO: </b>'+barrio+'<br>'+
        //'<b>LOCALIDAD: </b>'+localidad+''+
        '<br><b style="color: red" class="parpadea">Verifica que el punto en el mapa sea el correcto, de lo contrario mueve el marcador hasta tu dirección.</b>'
        '<br><br>Estás seguro de confirmar con la información descrita?';

      $.confirm({
        title: 'Confirmación',
        content: texts,//'Confirmas que <b>'+direccion+'</b> es tu dirección?',
        buttons: {
            confirm: {
                text: 'Confirmar',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  $.ajax({
                    url: '../actualizarubicacion',
                    method: 'post',
                    data: {id: user_id, direccion: direccion, lat: lat, lng: lng}
                  }).done(function(data){

                    if(data.response==true){                       

                      $.confirm({
                        title: '¡Realizado!',
                        content: 'Gracias por confirmar tu dirección!<br><br>Se recargará la página y verás tu ubicación confirmada.',
                        buttons: {
                          confirm: {
                            text: 'Entendido',
                            btnClass: 'btn-success',
                            keys: ['enter', 'shift'],
                            action: function(){

                              location.reload();

                            }

                          }
                        }        
                      });

                    }else if(data.response==false){

                    }

                  });

                }

            },
            cancel: {
              text: 'Volver',
            } 
        }        
      });

    });


</script>
</body>
</html>
