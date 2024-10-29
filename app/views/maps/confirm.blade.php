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
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        width: 100%;
        height: 70%;
      }
      #coords{width: 500px;}

      *{margin: 0; padding: 0;}
        .doc{
          display: flex;
          flex-flow: column wrap;
          width: 100vw;
          height: 100vh;
          justify-content: center;
          align-items: center;
          background: #333944;
        }
        .box{
          width: 300px;
          height: 300px;
          background: #CCC;
          overflow: hidden;
        }

        .box img{
          width: 100%;
          height: auto;
        }
        @supports(object-fit: cover){
            .box img{
              height: 100%;
              object-fit: cover;
              object-position: center center;
            }
        }
     

      .btn .dropdown-toggle{
        padding: 8px 12px;
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
    </style>
    
    @include('transportederuta.nabvar')
  
    <div class="col-lg-12">

      <h4 class="h_titulo" style="font-size: 25px;"><b style="font-size: 20px;">Asignación de Ruta - Aquí puedes confirmar tu punto de recogida exacto</b></h4>

      <div class="row">
        
        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="panel panel-default">
              <div class="panel-heading"><span style="font-size: 15px;"><b style="font-size: 20px;">Mis Datos</b> - 
                @if($actualizado!=1) 
                <span style="color: red">Sólo podrás actualizarla una vez en esta ruta</span>
                @else
                  <span style="color: green">Actualizaste tu dirección el <b>{{date("d-m-Y", strtotime(explode(' ',$fecha_actualizado)[0]))}}</b> a las <b>{{explode(' ',$fecha_actualizado)[1]}}</b></span>
                @endif
              </span></div>
              <div class="panel-body">
                <div class="input-group margin_input">
                  <span class="input-group-addon" id="basic-addon1"><b>Nombre:</b></span>
                  <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$fullname}}" disabled>
                </div>
                <div class="input-group margin_input">
                  <span class="input-group-addon" id="basic-addon1"><b>Dirección:</b></span>
                  <input class="form-control input-font" aria-describedby="basic-addon1" id="dir" value="{{$address}}" >
                </div>


          <div class="col-lg-12">

            <div style="width: 100%">
              <center> <strong style="font-family: Arial; font-size: 20px">
                <div class="row">
                  <div class="col-lg-5">
                    <input  type="text" id="latitud" name="latitud" class="hidden" />  
                  </div>
                  <div class="col-lg-5">
                    <input  type="text" id="longitud" name="longitud" class="hidden" />    
                  </div>
                </div>
                <input  type="text" id="id_pasajero" name="id_pasajero" hidden disabled value="{{$id_user}}" />   
                <div class="row">
                  <div class="col-md-3">
                    
                  </div>
                </div>

                <div class="row" style="width: 100%">
                  <div style="height: 300px" id="map"></div>
                    <div class="row">
                      <div class="col-lg-12">
                        <img src="" width="16" height="16" id="place-icon" />
                        <span id="place-name" class="title"></span><br />
                        <span id="place-address"></span>
                      </div>
                      <div class="col-lg-12">
                        <button data-update={{$actualizado}} data-id="{{$id_user}}" id="actualizar_direccion" disabled style="margin-top: 10px;" class="btn btn-danger">Actualizar Punto de recogida</button>
                      </div>
                      
                    </div>
                    <div>
                        <strong style="font-family: monospace; font-size: 17px; color: green; float: right; margin: 15px"><i class="fa fa-info-circle" aria-hidden="true" style="color: orange"></i> Mueve el marcador hacia tu dirección de recogida exacta. <br> </strong>
                    </div>
                </div>

            </div>
            
            
              
          </div>
              </div>
          </div>
              </div>
              

      </div>
        
    </div>  

    

    


    @include('scripts.scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>  
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
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            var latt = position.coords.latitude;
            var lngg = position.coords.longitude;
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
            //$('#form_editar_pasajeros [name="latitud"]').value = latt;
            //$('#form_editar_pasajeros [name="longitud"]').value = lngg;
            document.getElementById("latitud").value = latt;
            document.getElementById("longitud").value = lngg;
            //document.getElementById("coords").value = latt+","+ lngg;
            
           
          },function(error){console.log(error);});
    
}



function setMapa (coords)
{     
      var lats = '{{$lat}}';
      var lngs = '{{$lng}}';
      var address = '{{$address}}';

      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 15,
        center:new google.maps.LatLng(lats,lngs),
        disableDefaultUI: true,

      });

      var image={
        url: 'https://app.aotour.com.co/autonet/img/marker_pasajero.png',
        scaledSize: new google.maps.Size(30, 44),
      };

      if($('#actualizar_direccion').attr('data-update') == 1){
        var statuss = false;
      }else{
        var statuss = true;
      }
      
      marker = new google.maps.Marker({
        map: map,
        icon: image,
        draggable: statuss,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(lats,lngs),

      });
      
      //INFO WINDOW
      var contenidofinal = '<div id="content">'+
      '<h4>Aquí te recogeremos: ' +address+'</h4>'
      '</div>';

      var infowindowfinal = new google.maps.InfoWindow({
        content: contenidofinal
      });

      marker.addListener('click', function() {
        infowindowfinal.open(map, marker);
      });

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
            var sw = $('#actualizar_direccion').attr('data-update');
            if(sw!=1){
              $('#actualizar_direccion').removeAttr('disabled')
            }

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
            map.setZoom(17); // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          document.getElementById("latitud").value = place.geometry.location.lat();
          document.getElementById("longitud").value = place.geometry.location.lng();
          
          $('#actualizar_direccion').removeAttr('disabled')

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
          /*infowindowContent.children["place-icon"].src = place.icon;
          infowindowContent.children["place-name"].textContent = place.name;
          infowindowContent.children["place-address"].textContent = address;
          infowindow.open(map, marker);*/
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

    $('#actualizar_direccion').click(function() {

      var id = $('#id_pasajero').val();
      var lat = $('#latitud').val();
      var lng = $('#longitud').val();

      console.log(id)
      console.log(lat)
      console.log(lng)

      $.confirm({
          title: 'Atención',
          content: 'Confirmas la actualización de tu ubicación de recogida?<br><br>Recuerda que al confirmar no podrás volver a actualizarla...',
          buttons: {
              confirm: {
                  text: '¡Confirmo!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: '../actualizarrecogida',
                      method: 'post',
                      data: {id: id, lat: lat, lng: lng}
                    }).done(function(data){

                      if(data.respuesta==true){
                        
                        $.confirm({
                          title: 'Magnífico!',
                          content: 'Tu punto de recogida se ha actualizado. <br>Al presionar OK verás tu punto de recogida actualizado!',
                          buttons: {
                            confirm: {
                              text: 'OK',
                              btnClass: 'btn-success',
                              keys: ['enter', 'shift'],
                              action: function(){

                                location.reload();

                              }

                            }
                          }        
                        });

                      }else if(data.respuesta==false){

                        $.confirm({
                          title: 'Ooops!',
                          content: 'No se pudo actualizar tu punto de recogida. Recuerda que sólo lo puedes hacer una vez por ruta.',
                          buttons: {
                            confirm: {
                              text: 'Entendido!',
                              btnClass: 'btn-success',
                              keys: ['enter', 'shift'],
                              action: function(){

                                

                              }

                            }
                          }        
                        });

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

    // Carga de la libreria de google maps 

    </script>
    <!--
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap">
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&libraries=places" async defer></script>
    -->

    <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>