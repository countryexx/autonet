<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Salidas Solicitadas</title>
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
        <h3 class="h_titulo">Solictudes Enviadas</h3>
      </div>
    </div>

    @if(isset($usuarios))

      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>#</th>
                <th>Solicitado Por</th>
                <th>Fecha de Rutas</th>
                <th>Cantidad de Pasajeros</th>
                <th>Tipo de Ruta</th>
                <th>Hora de Solicitud</th>
                <th>Acciones</th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>#</th>
            <th>Solicitado Por</th>
            <th>Fecha de Rutas</th>
            <th>Cantidad de Pasajeros</th>
            <th>Tipo de Ruta</th>
            <th>Hora de Solicitud</th>
            <th>Acciones</th>
          </tr>
          </tfoot>
          <tbody>
            <?php  
            $o = 1;
            ?>
          @foreach($usuarios as $usuario)
            <tr>
              <td>{{$o}}</td>
              <td>{{$usuario->first_name.' '.$usuario->last_name}}</td>
              <td>{{$usuario->fecha}}</td>
              <td>
                {{$usuario->cantidad_usuarios}} Pasajeros
              </td>
              <td>
                @if($usuario->tipo_ruta==1)
                  ENTRADAS
                @else
                  SALIDAS
                @endif
              </td>
              <td>{{$usuario->created_at}}</td>
              <td>
                <a class="btn btn-primary btn-list-table" href="{{url('reportes/salidassolicitadass/'.$usuario->id)}}">Ver Usuarios <i class="fa fa-external-link" aria-hidden="true"></i></a>
              </td>
            </tr>
            <?php $o++; ?>
          @endforeach
          </tbody>
      </table>
    @endif
    
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
                                    <input class="form-control input-font" type="text" id="id_empleado">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="nombres">Nombres</label>
                                      <input class="form-control input-font" type="text" id="nombres">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="apellidos">Apellidos</label>
                                      <input class="form-control input-font" type="text" id="apellidos">
                                  </div>
                                  
                                  <div class="col-xs-3 representante">
                                      <label class="obligatorio" for="telefono">Teléfono</label>
                                      <input type="text" class="form-control input-font" id="telefono">
                                  </div>
                                  <div class="col-xs-3" style="min-height: 0px;">
                                      <label class="obligatorio cedula" for="programa">Programa</label>
                                      <select class="form-control" id="programa" aria-label="Floating label select example">
                                        <option value="0">Selecciona una Opción</option>
                                        <option value="CENTER 1">CENTER 1</option>
                                        <option value="CENTER 2">CENTER 2</option>
                                        <option value="CENTER 3">CENTER 3</option>
                                        <option value="CENTER 4">CENTER 4</option>
                                        <option value="CENTER 5">CENTER 5</option>
                                      </select>
                                  </div>
                                  <div class="col-xs-3" style="min-height: 0px;">
                                      <label class="obligatorio cedula" for="horario_entrada">Horario Entrada</label>
                                      <input type="text" id="horario_entrada" class="form-control input-font">
                                  </div>
                                  <div class="col-xs-3">
                                      <label for="direccion" class="obligatorio">Horario Salida</label>
                                      <input class="form-control input-font" id="horario_salida" type="text">
                                  </div>
                              </div>
                          </fieldset>
                      </div>

                      <div class="col-xs-12" id="container_contacto">
                          <fieldset style="margin-bottom: 5px;"><legend class="margin_label">Domicilio de Pasajero</legend>
                              <div class="row">
                                  <div class="col-xs-6">
                                      <label class="obligatorio" for="dir">Dirección</label>
                                      <input class="form-control input-font" id="dir" type="text">
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

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
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
      var latitude = $('#latitud').val();
      var longitude = $('#longitud').val();
      var programa = $('#programa').val();

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de agregar este nuevo usuario?',
          buttons: {
              confirm: {
                  text: 'Si, Crear!',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'nuevousuario',
                      method: 'post',
                      data: {id_empleado: id_empleado, nombres: nombres, apellidos: apellidos, telefono: telefono, horario_entrada: horario_entrada, horario_salida: horario_salida, direccion: direccion, latitude: latitude, longitude: longitude, programa: programa}
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
      }else{
        var estado = 'INACTIVAR';
      }

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de <b>'+estado+'</b> a <b>'+nombre+'</b>?',
          buttons: {
              confirm: {
                  text: estado,
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'estadousuario',
                      method: 'post',
                      data: {user_id: user_id, value: value}
                    }).done(function(data){

                      if(data.response==true){                       

                        $.alert({
                          title: 'Realizado!',
                          content: 'Se ha cambiado el estado del pasajero!',
                        });

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

    $('.select_all').change(function(e){
      if ($(this).is(':checked')) {
          $('#example tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 10:
                          $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);
                      break;
                  }
              });
          });
      }else if(!$(this).is(':checked')){
          $('#example tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 10:
                          $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);
                      break;
                  }
              });
          });
      }
  });

    $('.enviar_solicitud').click(function() {

        var idArray = [];
        var horaArray = [];
        var dt = '';
        var cant = 0;

        $('#example tbody tr').each(function(index){

          $(this).children("td").each(function (index2){
              switch (index2){
                  case 10:
                      var $objeto = $(this).find('.services');

                      if ($objeto.is(':checked')) {
                          idArray.push($objeto.attr('data-id'));
                          horaArray.push($objeto.attr('data-hora'));
                          dt += $objeto.attr('data-id')+',';
                          cant++;
                      }

                  break;
              }
          });

        });

        //console.log(idArray)
        //console.log(dt)

        if(dt!=''){
          
          var fecha = $('#fecha').val();

          $.confirm({
              title: 'Confirmación',
              content: 'Estás seguro de enviar solicitud de ruta para <b>'+cant+' usuarios</b> el <b>'+fecha+'</b>?',
              buttons: {
                  confirm: {
                      text: 'Enviar',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'solicitarrutas',
                          method: 'post',
                          data: {idArray: idArray, horaArray: horaArray, fecha: fecha, cantidad_usuarios: cant, tipo_ruta: null}
                        }).done(function(data){

                          if(data.response==true){                       

                            $.alert({
                              title: 'Realizado!',
                              content: 'Solicitud enviada con éxito!',
                            });

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

        }else{

          $.confirm({
              title: 'Atención',
              content: '¡No has seleccionado ningún pasajero!',
              buttons: {
                  confirm: {
                      text: 'Ok',
                      btnClass: 'btn-danger',
                      keys: ['enter', 'shift'],
                      action: function(){


                      }

                  }
              }
          });

        }

    });

    $('input[type=file]').bootstrapFileInput(); 
    $('.file-inputs').bootstrapFileInput();

    $('.datetime_fecha').datetimepicker({
        locale: 'en',
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
            {'sWidth': '3%'},
            {'sWidth': '3%'},
            {'sWidth': '2%'},
            {'sWidth': '2%'},
            {'sWidth': '1%'},
            {'sWidth': '2%'},
        ],
        "order": [[1, 'asc']]
    });

</script>
</body>
</html>
