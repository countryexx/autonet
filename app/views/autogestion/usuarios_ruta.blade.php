<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Subida de Rutas</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
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

    </style>
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
  
    <div class="col-lg-12">
      <div class="row">
        
        <div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 120px; border-radius: 2px;">Subida de Rutas</div>
        
      </div>
    </div>

    @if(isset($usuarios))
      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>#</th>
                <th>ID empleado</th>
                <th>Nombre Completo</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Tipo Ruta</th>
                <th>Programa</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Barrio</th>
                <th>Localidad</th>
                <th>Ciudad</th>
                <th>Ubicación</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>#</th>
            <th>ID empleado</th>
            <th>Nombre Completo</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th>Tipo Ruta</th>
            <th>Programa</th>
            <th>Telefono</th>
            <th>Dirección</th>
            <th>Barrio</th>
            <th>Localidad</th>
            <th>Ciudad</th>
            <th>Ubicación</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>
            <?php  
            $o = 1;
            ?>
          @foreach($usuarios as $usuario)
            <tr data-id="{{$usuario->id}}" class="@if(intval($usuario->estado)===1){{'success'}}@elseif(intval($usuario->estado)===2){{'danger'}}@endif">
              <td>{{$o}}</td>
              <td>{{$usuario->id_empleado}}</td>
              <td>{{$usuario->nombres}}</td>
              <td>{{$usuario->fecha}}</td>
              <td>{{$usuario->hora}}</td>
              <td>
                <center><div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 80px; border-radius: 2px;">
                @if($usuario->tipo==1)
                  ENTRADA
                @else
                  SALIDA
                @endif
              </div></center>
              </td>
              <td>{{$usuario->programa}}</td>
              <td>{{$usuario->telefono}}</td>
              <td>{{$usuario->direccion}}</td>
              <td>{{$usuario->barrio}}</td>
              <td>{{$usuario->localidad}}</td>
              <td>{{$usuario->ciudad}}</td>
              <td>
                <a name-user="{{$usuario->nombres.' '.$usuario->apellidos}}" dir-user="{{$usuario->direccion}}" lat="{{$usuario->latitude}}" lng="{{$usuario->longitude}}" class="btn btn-success btn-list-table ver_ubicacion">Ver Ubicación <i class="fa fa-map-marker" aria-hidden="true"></i></a>

                  <!--@if($usuario->confirmado==1)
                    <center><div class="estado_servicio_app" style="background: #2FCC2C; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 180px; border-radius: 2px;">
                      ¡Confirmada!
                    <i class="fa fa-check-circle" aria-hidden="true"></i></div></center>
                  @else
                    <center><div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 180px; border-radius: 2px;">
                      ¡Por confirmar!
                    <i class="fa fa-warning" aria-hidden="true"></i></div></center>
                  @endif-->

                
              </td>
              <td id="{{$usuario->id}}">
                
                <!--<a id-empleado="{{$usuario->id_empleado}}" nombres="{{$usuario->nombres}}" apellidos="{{$usuario->apellidos}}" telefono="{{$usuario->telefono}}" horario-entrada="{{$usuario->horario_entrada}}" horario-salida="{{$usuario->horario_salida}}" data-id="{{$usuario->id}}" class="btn btn-primary btn-list-table editar">Actualizar</a>-->

              </td>
            </tr>
            <?php $o=$o+1; ?>
          @endforeach
          </tbody>
      </table>
    @endif
    <button type="button" class="btn btn-success btn-icon" data-toggle="modal" data-target=".mymodal2">Subir Excel<i class="fa fa-upload icon-btn"></i></button>
    <!--<button type="button" class="btn btn-primary btn-icon" data-toggle="modal" data-target=".mymodal">Agregar nuevo pasajero<i class="fa fa-plus icon-btn"></i></button>-->
</div>

<div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                  <h4 class="modal-title">NUEVO PASAJERO</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12">
                          <fieldset style="margin-bottom: 5px;"><legend class="margin_label">Datos Generales</legend>
                              <div class="row">
                                  
                                  <div class="col-xs-3">
                                    <label class="obligatorio" for="id_empleado">ID empleado</label>
                                    <input class="form-control input-font" type="text" id="id_empleado" placeholder="Escribe el id del empleado">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="nombres">Nombres</label>
                                      <input class="form-control input-font" type="text" id="nombres" placeholder="Escribe el primer nombre">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="apellidos">Apellidos</label>
                                      <input class="form-control input-font" type="text" id="apellidos" placeholder="Escribe el primer apellido">
                                  </div>
                                  
                                  <div class="col-xs-3 representante">
                                      <label class="obligatorio" for="telefono">Teléfono</label>
                                      <input type="number" class="form-control input-font" id="telefono" placeholder="Escribe el teléfono">
                                  </div>
                                  <div class="col-xs-3" style="min-height: 0px;">
                                      <label class="obligatorio cedula" for="programa">Programa</label>
                                      <select class="form-control" id="programa" aria-label="Floating label select example">
                                        <option value="{{Sentry::getUser()->empresa}}" selected>{{Sentry::getUser()->empresa}}</option>
                                      </select>
                                  </div>
                                  <div class="col-xs-3" style="min-height: 0px;">
                                      <label class="obligatorio cedula" for="horario_entrada">Horario Entrada</label>
                                      <div class="input-group">
                                        <div class="input-group date" id="datetimepicker3">
                                            <input type="text" class="form-control input-font" id="horario_entrada" autocomplete="off" placeholder="Selecciona un horario">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                      </div>
                                      <!--<input type="text" id="horario_entrada" class="form-control input-font" placeholder="Escribe el primer nombre">-->
                                  </div>
                                  <div class="col-xs-3">
                                      <label for="direccion" class="obligatorio">Horario Salida</label>
                                      <div class="input-group">
                                        <div class="input-group date" id="datetimepicker3">
                                            <input type="text" class="form-control input-font" id="horario_salida" autocomplete="off" placeholder="Selecciona un horario">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                      </div>
                                      <!--<input class="form-control input-font" id="horario_salida" type="text">-->
                                  </div>
                              </div>
                          </fieldset>
                      </div>

                      <div class="col-xs-12" id="container_contacto">
                          <fieldset style="margin-bottom: 5px;"><legend class="margin_label">Domicilio de Pasajero</legend>
                              <div class="row">
                                  <div class="col-xs-6">
                                      <label class="obligatorio" for="dir">Dirección</label>
                                      <input class="form-control input-font" id="dir" type="text" placeholder="Escribe una dirección">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="dir">Barrio</label>
                                      <input class="form-control input-font" id="barrio" type="text" placeholder="Escribe el barrio">
                                  </div>
                                  <div class="col-xs-3">
                                      
                                        <label class="obligatorio" for="dir">Localidad (Opcional)</label>
                                          <select class="form-control" id="localidad" aria-label="Floating label select example">
                                            <option value="0">Selecciona una Opción</option>
                                            <option value="USME">USME</option>
                                            <option value="SOACHA">SOACHA</option>
                                            <option value="SAN CRISTÓBAL">SAN CRISTÓBAL</option>
                                            <option value="CHAPINERO">CHAPINERO</option>
                                            <option value="USAQUÉN">USAQUÉN</option>
                                          </select>
                                      
                                      <!--<input class="form-control input-font" id="localidad" type="text" placeholder="Escribe la localidad">-->
                                  </div>
                              </div>
                          </fieldset>
                      </div>

                      <div class="col-xs-12" id="container_informacion_tributaria">
                          <fieldset><legend class="margin_label">Ubicación en Google Maps</legend>
                              <div class="row">
                                  <div class="col-xs-12">
                                      
                                      <div style="height: 300px" id="map"></div>
                                      <div id="infowindow-content">
                                        <img src="" width="16" height="16" id="place-icon" />
                                        <span id="place-name" class="title"></span><br />
                                        <span id="place-address"></span>
                                      </div>
                                      <input id="latitud" name="" class="hidden">
                                      <input id="longitud" name="" class="hidden">
                                  </div>
                                  
                              </div>
                          </fieldset>
                          <div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 100%; border-radius: 2px;">Si no encuentras la dirección, mueve el marcador hacia el punto que quieras...</div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button id="guardar" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                  <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
              </div>
          </div>

    </div>
</div>

<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
          <h4 class="modal-title">Subida de Archivo</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-xs-12">

                      <div class="input-group">
                        <div class="input-group date" id="datetimepicker3">
                            <input type="text" class="form-control input-font" id="fecha_solicitud" autocomplete="off" placeholder="Selecciona la fecha">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                      </div>
                      <br>
                      <label class="obligatorio" for="dir">Tipo de Ruta</label>
                      <select class="form-control" id="tipo_ruta" aria-label="Floating label select example" style="width: 170px">
                        <option value="0">Seleccionar</option>
                        <option value="NULL">SALIDA</option>
                        <option value="1">ENTRADA</option>
                      </select>
                      <br>
                      <form style="display: inline" id="form_users">
                        <div style="display: inline-block; margin-bottom: 15px;">
                          <input id="excel_usuarios" type="file" value="Subir" name="excel">
                        </div>
                      </form>

                      <table name="mytable" id="users_import" class="table table-hover table-bordered tablesorter">
                          <thead>
                              <tr>
                                  <td>EMPLOY ID</td>
                                  <td>NOMBRES</td>
                                  <td>TELÉFONO</td>
                                  <td>DIRECCION</td>
                                  <td>BARRIO</td>
                                  <td>LOCALIDAD</td>
                                  <td>CIUDAD</td>
                                  <td>PROGRAMA</td>
                                  <td>HORARIO</td>
                                  <td>CORREO</td>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
              </div>

          </div>
      </div>
      <div class="modal-footer">
        <a id="guardando" class="btn btn-primary btn-icon hidden">PROCESANDO EXCEL... <i class="fa fa-spinner fa-spin icon-btn" aria-hidden="true"></i></a>
        <i class="fa fa-spinner fa-spin icon-btn hidden loading" style="color: green" aria-hidden="true"></i>
        <i class="fa fa-check icon-btn hidden ok" style="color: green" aria-hidden="true"></i>
          
        <a id="confirmar" class="btn btn-success btn-icon hidden">CONFIRMAR <i class="fa fa-check icon-btn" aria-hidden="true"></i></a>

        <button id="save" class="btn btn-primary btn-icon hidden">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_ubicacion'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;" id="name"></h4>
        </div>
        <div class="modal-body">
          <center>
            <div style="height: 400px" id="mapa"></div>
            </center>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              <input type="text" id="dirs" name="" class="form-control" style="float: left">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>                    
        </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_editar'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;">Editar Pasajero</h4>
        </div>
        <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12">
                          <fieldset style="margin-bottom: 5px;"><legend class="margin_label">Datos Generales</legend>
                              <div class="row">
                                  
                                  <div class="col-xs-3">
                                    <label class="obligatorio" for="id_empleado">ID empleado</label>
                                    <input class="form-control input-font" type="text" id="id_empleado_editar">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="nombres">Nombres</label>
                                      <input class="form-control input-font" type="text" id="nombres_editar">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="apellidos">Apellidos</label>
                                      <input class="form-control input-font" type="text" id="apellidos_editar">
                                  </div>
                                  
                                  <div class="col-xs-3 representante">
                                      <label class="obligatorio" for="telefono">Teléfono</label>
                                      <input type="text" class="form-control input-font" id="telefono_editar">
                                  </div>
                                  <div class="col-xs-3" style="min-height: 0px;">
                                      <label class="obligatorio cedula" for="horario_entrada">Horario Entrada</label>
                                      <input type="text" id="horario_entrada_editar" class="form-control input-font">
                                  </div>
                                  <div class="col-xs-3">
                                      <label for="direccion" class="obligatorio">Horario Salida</label>
                                      <input class="form-control input-font" id="horario_salida_editar" type="text">
                                  </div>
                              </div>
                          </fieldset>
                      </div>
                  </div>
              </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-primary actualizar">Actualizar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>                    
        </div>
    </div>
  </div>
</div>

<div class="errores-modal bg-danger text-danger hidden model" style="top: 10%;">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

<div class="confirmar bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
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
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };
            var latt = position.coords.latitude;
            var lngg = position.coords.longitude;
            setMap(coords);  //pasamos las coordenadas al metodo para crear el mapa
            //$('#form_editar_pasajeros [name="latitud"]').value = latt;
            //$('#form_editar_pasajeros [name="longitud"]').value = lngg;
            document.getElementById("latitud").value = latt;
            document.getElementById("longitud").value = lngg;
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMapa&libraries=places&v=weekly"
      defer
    ></script>


<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

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

    $('#guardar').click(function() {

      var id_empleado = $('#id_empleado').val();
      var nombres = $('#nombres').val();
      var apellidos = $('#apellidos').val();
      var telefono = $('#telefono').val();
      var horario_entrada = $('#horario_entrada').val();
      var horario_salida = $('#horario_salida').val();
      var direccion = $('#dir').val();
      var barrio = $('#barrio').val();
      var localidad = $('#localidad').val();
      var latitude = $('#latitud').val();
      var longitude = $('#longitud').val();
      var programa = $('#programa').val();

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de agregar este nuevo usuario?',
          buttons: {
              confirm: {
                  text: 'Si, Crear!',
                  btnClass: 'btn-primary',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'nuevousuario',
                      method: 'post',
                      data: {id_empleado: id_empleado, nombres: nombres, apellidos: apellidos, telefono: telefono, horario_entrada: horario_entrada, horario_salida: horario_salida, direccion: direccion, barrio: barrio, localidad: localidad, latitude: latitude, longitude: longitude, programa: programa}
                    }).done(function(data){

                      if(data.response==true){                       

                        $.alert({
                          title: 'Realizado!'
                        });

                        location.reload();

                      }else if(data.response==false){

                      }

                    });

                  }

              },
              cancel: {
                text: 'Cancelar',
              } 
          }        
      });
    });

    $('.editar').click(function() {

      $('#id_empleado_editar').val($(this).attr('id-empleado'));
      $('#nombres_editar').val($(this).attr('nombres'));
      $('#apellidos_editar').val($(this).attr('apellidos'));
      $('#telefono_editar').val($(this).attr('telefono'));
      $('#horario_entrada_editar').val($(this).attr('horario-entrada'));
      $('#horario_salida_editar').val($(this).attr('horario-salida'));

      $('.actualizar').attr('data-id',$(this).attr('data-id'));
      $('#modal_editar').modal('show');

    });

    $('.actualizar').click(function () {

      var id = $(this).attr('data-id');
      var id_empleado = $('#id_empleado_editar').val();
      var nombres = $('#nombres_editar').val();
      var apellidos = $('#apellidos_editar').val();
      var telefono = $('#telefono_editar').val();
      var horario_entrada = $('#horario_entrada_editar').val();
      var horario_salida = $('#horario_salida_editar').val();

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de Actualizar los datos de este usuario?',
          buttons: {
              confirm: {
                  text: 'Si, Actualizar!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'actualizarusuario',
                      method: 'post',
                      data: {id: id, id_empleado: id_empleado, nombres: nombres, apellidos: apellidos, telefono: telefono, horario_entrada: horario_entrada, horario_salida: horario_salida}
                    }).done(function(data){

                      if(data.response==true){                       

                        $.alert({
                          title: 'Realizado!'
                        });

                        location.reload();

                      }else if(data.response==false){

                      }

                    });

                  }

              },
              cancel: {
                text: 'Cancelar',
              } 
          }        
      });
      alert('test')

    });

    $('select.estado').change(function(){

      var user_id = $(this).attr('data-id');
      var value = $(this).val()
      var nombre = $(this).attr('nombres');

      if(value==1) {
        var estado = 'ACTIVAR';
        var btn = 'success';
        var old = 2;
      }else{
        var estado = 'INACTIVAR';
        var btn = 'danger';
        var old = 1;
      }

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de <b>'+estado+'</b> a <b>'+nombre+'</b>?',
          buttons: {
              confirm: {
                  text: estado,
                  btnClass: 'btn-'+btn+'',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'estadousuario',
                      method: 'post',
                      data: {user_id: user_id, value: value}
                    }).done(function(data){

                      if(data.response==true){                       

                        $('#example tbody tr').each(function () {
                            if($(this).attr('data-id')==user_id){
                              if(value==1) {
                                $(this).removeClass('danger').addClass('success');
                              }else{
                                $(this).removeClass('success').addClass('danger');
                              }
                            }
                        });

                      }else if(data.response==false){

                      }

                    });

                  }

              },
              cancel: {
                text: 'Cancelar',
                action: function(){


                  $('#example tbody tr').each(function () {

                      if($(this).attr('data-id')==user_id){
                        $(this).find('td').eq(6).find('.estado').val(old);
                      }

                  });

                }
              } 
          }        
      });

    });

    $('#datetimepicker3, #datetimepicker4').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });


    //NEW MODELO
    $('#excel_usuarios').change(function(e){

        $('table#users_import tbody').html('');
        $('#save').addClass('hidden');
        $('#guardando').removeClass('hidden');
        var colors = '';

        formData = new FormData($('#form_users')[0]);

        $.ajax({
            url: 'importarexcel',
            method: 'post',
            async: true,
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){

              data = JSON.parse(data);

              var paxs = data.pasajeros;
              var htmlPaxqr = '';
              var nombreRutaOptionsHtml = '';
              var y = 1;

              for (i in paxs){

                var id_employer = '';
                var nombres = '';
                var apellidos = '';
                var direccion = '';
                var barrio = '';
                var localidad = '';
                var programa = '';
                var ciudad = '';
                var hora = '';
                var telefono = '';
                var dato = '';
                var dato2 = '';
                var correo = '';

                if (paxs[i].id_employer!=null) {
                  id_employer = paxs[i].id_employer;
                }else if (paxs[i].id_employer===null) {
                  id_employer = '';
                }

                paxs[i].nombres!=null ?
                  nombres = paxs[i].nombres.trim() :
                paxs[i].nombres===null ?
                  nombres = '' : false;

                if (paxs[i].apellidos!=null) {
                  apellidos = paxs[i].apellidos.trim();
                }else if (paxs[i].apellidos===null) {
                  apellidos = '';
                }

                if (paxs[i].direccion!=null) {

                  var address = paxs[i].direccion+', Cundinamarca colombia';
                  direccion = paxs[i].direccion;
                  
                  var geocoder = new google.maps.Geocoder();
                  var dam = '';
                  
                  var userData = "https://maps.googleapis.com/maps/api/geocode/json?address=" 
                  + encodeURIComponent(address) 
                  + "&key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0";
                    console.log(userData);
                    $.ajax({
                      async: false,
                      type: "GET",
                      url: userData,
                      success: function(data) {
                        
                        dato = data['results'][0]['geometry']['location'].lat
                        dato2 = data['results'][0]['geometry']['location'].lng
                        console.log(paxs[i].nombres+' : '+dato+','+dato2)
                        
                      }
                    });

                }else if (paxs[i].direccion===null) {
                    direccion = '';
                }

                if (paxs[i].telefono!=null) {
                  telefono = paxs[i].telefono.trim();
                }else if (paxs[i].telefono===null) {
                  telefono = '';
                }

                if (paxs[i].barrio!=null) {
                  barrio = paxs[i].barrio;
                }else if (paxs[i].barrio===null) {
                  barrio = '';
                }

                if (paxs[i].correo!=null) {
                  correo = paxs[i].correo;
                }else if (paxs[i].correo===null) {
                  correo = '';
                }

                if (paxs[i].programa!=null) {
                  programa = paxs[i].programa;
                }else if (paxs[i].programa===null) {
                  programa = '';
                }

                if (paxs[i].ciudad!=null) {
                  ciudad = paxs[i].ciudad;
                }else if (paxs[i].ciudad===null) {
                  ciudad = '';
                }

                if (paxs[i].localidad!=null) {
                  localidad = paxs[i].localidad;
                }else if (paxs[i].localidad===null) {
                  localidad = '';
                }

                if (paxs[i].hora===null) {
                  hora = '';
                }else if (paxs[i].hora.date!=null) {
                  hora =  moment(paxs[i].hora.date).format('HH:mm');
                }

                var complemento = '';

                var color = '';

                htmlPaxqr += '<tr style="background-color: '+color+'">'+
                      '<td>'+id_employer+'</td>'+
                      '<td>'+nombres+'</td>'+
                      '<td>'+telefono+'</td>'+
                      '<td data-latitude="'+dato+'" data-longitude="'+dato2+'">'+direccion+'</td>'+
                      '<td>'+barrio+'</td>'+
                      '<td>'+localidad+'</td>'+
                      '<td>'+ciudad+'</td>'+
                      '<td>'+programa+'</td>'+
                      '<td>'+hora+'</td>'+
                      '<td>'+correo+'</td>'+
                '</tr>';

                y++;

              }

              $('table#users_import tbody').append(htmlPaxqr);

              $('#save').addClass('hidden');
              $('#guardando').addClass('hidden');
              $('#confirmar').removeClass('hidden');

            },error: function(data){

              $('#save').addClass('hidden');
              $('#guardando').addClass('hidden');
              $('#confirmar').addClass('hidden');

            }
        });
    });
    
    $('#confirmar').click(function(e){

      var rt_pasajeros = [];
      var fecha = $('#fecha_solicitud').val();
      var tipo_ruta = $('#tipo_ruta').val();

      if(fecha==='' || tipo_ruta==='0') {

        var text = '';

        console.log(fecha)

        if(fecha==='') {
          text = '¡No ha seleccionado la fecha!<br>';
        }

        if(tipo_ruta==='0') {
          text += '¡No ha seleccionado el tipo de ruta!';
        }

        $.confirm({
          title: 'Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
          content: text,
          type: 'red',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'Cerrar',
              btnClass: 'btn-danger',
              action: function(){

              }
            }
          }
        });

      }else{

        $.confirm({
            title: 'Confirmación',
            content: 'Estás seguro de enviar esta solicitud de rutas?',
            type: 'green',
            typeAnimated: true,
            buttons: {
              tryAgain: {
                text: '¡Enviar Solicitud!',
                btnClass: 'btn-success',
                action: function(){
                  
                  $('#users_import tbody tr').each(function(index){

                    var $td = $(this).find('td');

                    rt_pasajeros.push({
                      "id_employer": $td.eq(0).html().trim(),
                      "nombres": $td.eq(1).html().trim(),
                      "telefono": $td.eq(2).html().trim(),
                      "direccion": $td.eq(3).html().trim(),
                      "barrio": $td.eq(4).html().trim(),
                      "localidad": $td.eq(5).html().trim(),
                      "ciudad": $td.eq(6).html().trim(),
                      "programa": $td.eq(7).html().trim(),
                      "hora": $td.eq(8).html(),
                      "correo": $td.eq(9).html(),
                      "latitude": $td.eq(3).attr('data-latitude'),
                      "longitude": $td.eq(3).attr('data-longitude')
                    });

                  });

                  $('#confirmar').addClass('hidden');
                  $('.loading').removeClass('hidden');

                  var formData = new FormData();
                  formData.append('pasajeros', JSON.stringify(rt_pasajeros));
                  formData.append('fecha', fecha);
                  formData.append('tipo_ruta', tipo_ruta);

                  $.ajax({
                      url: 'subirusuarios',
                      data: formData,
                      method: 'post',
                      contentType: false,
                      processData: false,
                      success: function(data){

                        if (data.response===true) {
                            

                              var rutas = data.contadora;
                              var cliente = data.cliente;
                              var data_id = data.id;

                              $('.loading').addClass('hidden');
                              $('.ok').removeClass('hidden');

                              $.confirm({
                                  title: 'REALIZADO! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                                  content: 'Se han solicitado las rutas!',
                                  type: 'green',
                                  typeAnimated: true,
                                  buttons: {
                                    tryAgain: {
                                      text: 'Cerrar',
                                      btnClass: 'btn-success',
                                      action: function(){
                                        
                                        $.ajax({
                                          url: 'organizarhoras',
                                          method: 'post',
                                          data: {id: data_id}
                                        }).done(function(data){

                                          if(data.response==true){

                                            location.reload();

                                          }else if(data.response==false){

                                          }

                                        });
                                      }
                                    }
                                  }
                              });

                            
                        }else if(data.respuesta==='documentacion'){

                          $.confirm({
                              title: 'Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                              content: 'Documentación vencida...',
                              type: 'red',
                              typeAnimated: true,
                              buttons: {
                                tryAgain: {
                                  text: 'Cerrar',
                                  btnClass: 'btn-danger',
                                  action: function(){

                                  }
                                }
                              }
                          });

                        }

                      }
                  });

                }
              }
            }
        });

      }

    });

    $('input[type=file]').bootstrapFileInput(); 
    $('.file-inputs').bootstrapFileInput();

    var oTable = $('#example').DataTable({
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        paging: false,
        language: {
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ Registros",
            info: "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty: "Mostrando 0 de 0 de 0 Registros",
            infoFiltered: "(Filtrando de _MAX_ registros en total)",
            infoPostFix: "",
            loadingRecords: "Cargando...",
            zeroRecords: "NINGUN REGISTRO ENCONTRADO",
            emptyTable: "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
            paginate: {
                first: "Primer",
                previous: "Antes",
                next: "Siguiente",
                last: "Ultimo"
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre d�croissant"
            }
        },
        'bAutoWidth': false,
        'aoColumns': [
            {'sWidth': '1%'},
            {'sWidth': '2%'},
            {'sWidth': '4%'},
            {'sWidth': '1%'},
            {'sWidth': '1%'},
            {'sWidth': '1%'},
            {'sWidth': '1%'},
            {'sWidth': '2%'},
            {'sWidth': '2%'},
            {'sWidth': '1%'},
            {'sWidth': '3%'},
            {'sWidth': '1%'},
            {'sWidth': '1%'},
            {'sWidth': '1%'}
        ],
        "order": [[1, 'asc']]
    });

</script>
</body>
</html>
