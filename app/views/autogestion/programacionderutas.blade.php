<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Programación de Rutas</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.css"/>
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

      .bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover{
        color: black;
        padding: 9px;
      }

      .proveedor_content{
        z-index: 5;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .input-group .bootstrap-select.form-control .dropdown-toggle{
        padding: 8px;
      }

      .edit_select{
        position: absolute;
        top: 10px;
        right: 5px;
        padding: 3px 6px 3px 6px;
        border-radius: 50%;
        background: green;
      }

      .edit_select i{
        font-size: 12px;
      }

      .popover-title {
          font-size: 12px;
      }

      .bootstrap-select .dropdown-menu li{
        font-size: 12px;
      }

    </style>

</head>
<body>

@include('admin.menu')
<div class="col-xs-12">

    <!--<div class="estado_servicio_app" style="background: #FF6B34; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 100%; border-radius: 2px;"></b></div>-->

    Solicitud de Rutas de <b style="font-size: 22px">@if($request->tipo_ruta==1){{'ENTRADA'}}@else{{'SALIDA'}}@endif</b> para el {{$request->fecha}} - <b style="font-size: 22px">{{$request->razonsocial}}</b> / <b style="font-size: 22px">{{$request->nombresubcentro}}</b>

    <!--<form class="form-inline" id="form_buscar">
      <div class="col-lg-12" style="margin-bottom: 5px">
          <div class="row">
              <div class="form-group">
                  <select class="form-control input-font horario" class="form-control input-font" style="width: 170px">
                    <option value="0">Todos los Horarios</option>
                    @foreach($horarios as $hora)
                      <option value="{{$hora->hora}}">{{$hora->hora}}</option>
                    @endforeach
                  </select>
              </div>
          </div>
      </div>
    </form>-->
    <!--<button class="ordenar">ordenar</button>-->
    @if(isset($usuarios))

      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>#</th>
                <th>Localidad</th>
                <th>Barrio</th>
                <th>Employ ID</th>
                <th>Nombre</th>
                <th>Campaña</th>
                <th>Horario</th>
                <th>Dirección</th>
                <th>Estado Dirección</th>
                <th>Ubicación</th>
                <th>Teléfono</th>
                <th>Ruta</th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>#</th>
            <th>Localidad</th>
            <th>Barrio</th>
            <th>Employ ID</th>
            <th>Nombre</th>
            <th>Campaña</th>
            <th>Horario</th>
            <th>Dirección</th>
            <th>Estado Dirección</th>
            <th>Ubicación</th>
            <th>Teléfono</th>
            <th>Ruta</th>
          </tr>
          </tfoot>
          <tbody>
            <?php  
            $i = 1;
            $locality = '';
            ?>
          @foreach($usuarios as $usuario)

          <?php

            $color = '';

            if($usuario->localidad=='ENGATIVA') {
              $color = '#ffa3ff';
            }else if($usuario->localidad=='SUBA') {
              $color = '#ff4d4d';
            }else if($usuario->localidad=='USAQUEN') {
              $color = '#a1b8e1';
            }else if($usuario->localidad=='FONTIBON') {
              $color = '#FFFF00';
            }else if($usuario->localidad=='BOSA') {
              $color = '#F4B084';
            }else if($usuario->localidad=='KENNEDY') {
              $color = '#ED7D31';
            }else if($usuario->localidad=='TEUSAQUILLO' or $usuario->localidad=='CHAPINERO' or $usuario->localidad=='BARRIOS UNIDOS') {
              $color = '#b9d4ed';
            }else if($usuario->localidad=='CIUDAD BOLIVAR') {
              $color = '#9900CC';
            }else if($usuario->localidad=='TUNJUELITO') {
              $color = '#CC99FF';
            }else if($usuario->localidad=='SANTA FE' or $usuario->localidad=='LA CANDELARIA' or $usuario->localidad=='LOS MARTIRES') {
              $color = '#87a771';
            }else if($usuario->localidad=='ANTONIO NARIÑO') {
              $color = '#A9D08E';
            }else if($usuario->localidad=='PUENTE ARANDA') {
              $color = '#A6A6A6';
            }else if($usuario->localidad=='USME') {
              $color = '#996633';
            }else if($usuario->localidad=='RAFAEL URIBE URIBE') {
              $color = '#D61086';
            }else if($usuario->localidad=='SAN CRISTOBAL SUR') {
              $color = '#FFCCCC';
            }else if($usuario->localidad=='SOACHA') {
              $color = '#96EEEC';
            }else if($usuario->localidad=='SABANA') {
              $color = '#BF8F00';
            }else{
              $color = 'white';
            }

          ?>

            <tr data-id="{{$usuario->id}}" data-hora="{{$usuario->hora}}" class="{{$usuario->hora}}" style="background: {{$color}};">
              <td>{{$o}}
              <input class="lat hidden" type="" name="" value="{{$usuario->latitude}}">
              <input class="lng hidden" type="" name="" value="{{$usuario->longitude}}">
              </td>
              <td>{{$usuario->localidad}}</td>
              <td>{{$usuario->barrio}}</td>
              <td>{{$usuario->id_empleado}}</td>
              <td>
                 {{$usuario->nombres}}
              </td>
              <td>
                 {{$usuario->programa}}
              </td>
              <td>{{$usuario->horario}}</td>
              <td>
                {{$usuario->direccion}}
              </td>
              <td>
                @if($usuario->confirmado==1)

                  <center><div class="estado_servicio_app" style="background: #2FCC2C; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 130px; border-radius: 2px;">Confirmada! <i class="fa fa-check-circle" aria-hidden="true"></i></div></center>

                @else

                  <center><div class="estado_servicio_app" style="background: #FF6B34; color: white; margin: 2px 0px; font-size: 15px; padding: 3px 5px; width: 130px; border-radius: 2px;">Por confirmar <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></div></center>

                @endif
              </td>
              <td>
                
                <a name-user="{{$usuario->nombres.' '.$usuario->apellidos}}" dir-user="{{$usuario->direccion}}" lat="{{$usuario->latitude}}" lng="{{$usuario->longitude}}" class="btn btn-success btn-list-table ver_ubicacion">Ver Ubicación <i class="fa fa-map-marker" aria-hidden="true"></i></a>
              
              </td>
              <td>
               {{$usuario->telefono}}
              </td>
              <td>

                <?php

                  if($locality!=$usuario->localidad) {

                    $consulta = DB::table('nombre_ruta')
                    ->leftjoin('barrios', 'barrios.ruta_id', '=', 'nombre_ruta.id')
                    ->select('nombre_ruta.id', 'barrios.nombre')
                    ->where('barrios.nombre',$usuario->localidad)
                    ->first();

                    if($consulta) {
                      $consult = $consulta->id;
                    }else{
                      $consult = 757;
                    }

                  }else{
                    $consult = $consult;
                  }
                  ?>

                <select data-live-search="true" class="form-control input-font ruta" data-id="{{$usuario->id}}">
                  <option data-value="9999" value="9999">Z</option>
                  @foreach($rutas as $ruta)

                    @if($consult==$ruta->id)
                      <option data-loc="{{$ruta->loc}}" selected data-value="{{$ruta->color}}" data-nombre="{{$ruta->nombre}}" value="{{$ruta->id}}">{{$ruta->nombre}}</option>
                    @else
                      <option data-loc="{{$ruta->loc}}" data-value="{{$ruta->color}}" data-nombre="{{$ruta->nombre}}" value="{{$ruta->id}}">{{$ruta->nombre}}</option>
                    @endif

                    <?php $locality = $usuario->localidad; ?>

                  @endforeach
                </select>
              </td>

            </tr>
            <?php $o++; ?>
          @endforeach
          </tbody>
      </table>
    @endif
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
    <button data-id="{{$request->id}}" class="btn btn-success btn-icon siguiente parpadea" id="siguiente">Siguiente <i class="fa fa-forward icon-btn"></i></button>
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

<div class="modal fade" tabindex="-1" role="dialog" id='modal_programar' data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;">Asigna los conductores a las rutas</h4>
        </div>
        <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12">
                          <table id="ruta_a_programar" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>RUTA</td>
                                    <td>PAX</td>
                                    <td>CONDUCTOR</td>
                                    <td>VEHICULO</td>
                                    <td>RECOGER EN</td>
                                    <td>DEJAR EN</td>
                                    <td>HORA</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                      </div>
                  </div>
              </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-12">
            
              <button data-centro-id="{{$request->centro_id}}" data-subcentro-id="{{$request->subcentro_id}}" data-fecha="{{$request->fecha}}" data-user="{{$request->first_name.' '.$request->last_name}}" data-fecha-solicitud="{{$request->fecha_solicitud}}" id-solicitud="{{$request->id}}" style="float: right;" type="button" class="btn btn-primary save">PROGRAMAR RUTAS <i class="fa fa-floppy-o" aria-hidden="true"></i></button>

              <i style="float: right;" class="fa fa-spinner fa-spin charging hidden" aria-hidden="true"></i>
              <i style="float: right;" class="fa fa-check done hidden" aria-hidden="true"></i>

              <button style="float: right;" type="button" class="btn btn-danger cerrarr" data-dismiss="modal">Cerrar</button>

            </div>
            
          </div>                    
        </div>
    </div>
  </div>
</div>

<div class="documentacion_conductor hidden">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>DOCUMENTACION DEL CONDUCTOR</strong>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fvencimiento" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
            </li>
          </ul>
          <button type="button" class="btn btn-primary btn-block ok">
            OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="documentacion_vehiculo hidden">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>DOCUMENTACION DEL VEHICULO</strong>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
            </li>
          </ul>
          <button type="button" class="btn btn-primary btn-block ok">
            OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
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

function sortTable(){

  var rows = $('#example tbody tr').get();

  rows.sort(function(a, b) {

    var A = $(a).children('td').eq(11).find('select option:selected').attr('data-nombre');
    var B = $(b).children('td').eq(11).find('select option:selected').attr('data-nombre');

    if(A < B) {
        return -1;
    }

    if(A > B) {
        return 1;
    }

    return 0;

  });

  $.each(rows, function(index, row) {
    $('#example').children('tbody').append(row);
  });

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

    $('.save').click(function(e){

        var rt_detalleArray = [];
        var rt_rutaIdArray = [];
        var rt_proveedorArray = [];
        var rt_conductorArray = [];
        var rt_vehiculoArray = [];
        var rt_recogerenArray = [];
        var rt_dejarenArray = [];
        var rt_horaArray = [];

        var data_centro_id = $(this).attr('data-centro-id');
        var data_subcentro_id = $(this).attr('data-subcentro-id');
        var data_fecha = $(this).attr('data-fecha');
        var data_user = $(this).attr('data-user');
        var data_fecha_solicitud = $(this).attr('data-fecha-solicitud');
        var id_solicitud = $(this).attr('id-solicitud');

        var rt_conductorArray = [];
        var rt_vehiculoplacaArray = [];
        var swConductor = 0;
        var swVehiculo = 0;
        var swVencidoC = 0;
        var swVencidoV = 0;

        $('#ruta_a_programar tbody tr').each(function(index){

            $(this).children("td").each(function (index2){

                switch (index2){
                    case 0:
                        rt_detalleArray.push($(this).html());
                        rt_rutaIdArray.push($(this).attr('data-nombre-ruta-id'));
                        break;
                    case 1:
                        //rt_proveedorArray.push($(this).find('option:selected').val());
                        break;
                    case 2:
                        if($(this).find('option:selected').val()=='0') {
                          swConductor = 1;
                        }
                        if(! ($(this).find('.conductor_alert').hasClass('hidden')) ) {
                          swVencidoC = 1;
                        }
                        rt_conductorArray.push($(this).find('option:selected').val());
                        break;
                    case 3:
                        if($(this).find('option:selected').val()=='0') {
                          swVehiculo = 1;
                        }
                        if(! ($(this).find('.vehiculo_alert').hasClass('hidden')) ) {
                          swVencidoV = 1;
                        }
                        rt_vehiculoArray.push($(this).find('option:selected').val());
                        break;
                    case 4:
                        rt_recogerenArray.push($(this).find('option:selected').val());
                        break;
                    case 5:
                        rt_dejarenArray.push($(this).find('option:selected').val());
                        break;
                    case 6:
                        rt_horaArray.push($(this).find('input').val());
                    break;
                }
            });
        });
        
        console.log(swConductor);
        console.log(swVehiculo);
        console.log(swVencidoC)
        console.log(swVencidoV)

        if(swConductor==1 || swVehiculo==1) {

          var text = '';

          if(swConductor==1) {
            text += 'Faltan conductores por asignar<br>';
          }

          if(swVehiculo==1) {
            text += 'Faltan vehiculos por asignar';
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

          if(swVencidoC==1 || swVencidoV==1) {

            var text = '';

            if(swVencidoC==1) {
              text += 'Hay conductores con documentos vencidos<br>';
            }

            if(swVencidoV==1) {
              text += 'Hay vehiculos con documentos vencidos';
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

            $(this).addClass('hidden');
            $('.cerrarr').addClass('hidden');
            $('.charging').removeClass('hidden');

            rt_fecha_servicio = data_fecha;
            rt_centrodecosto = data_centro_id;
            rt_subcentrodecosto = data_subcentro_id;
            rt_departamento = 'ATLÁNTICO'; //revisar
            rt_ciudad = 'BARRANQUILLA'; //revisar
            rt_firma = 1;
            rt_mensajes = 0;
            rt_solicitado_por = data_user;
            //rt_email_solicitante = 'sdgm2207@gmail.com';
            var rt_fecha_solicitud = data_fecha_solicitud;
            var rt_tipo_traslado = 1; //revisar

            console.log(rt_fecha_servicio)
            console.log(rt_centrodecosto)
            console.log(rt_subcentrodecosto)
            console.log(rt_departamento)
            console.log(rt_ciudad)
            console.log(rtArrayPax)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)

            var formData = new FormData();
            formData.append('fecha_servicio',rt_fecha_servicio);
            formData.append('centrodecosto',rt_centrodecosto);
            formData.append('subcentrodecosto',rt_subcentrodecosto);
            formData.append('departamento',rt_departamento);
            formData.append('ciudad', rt_ciudad);
            formData.append('firma', rt_firma);
            formData.append('mensajesqr', rt_mensajes);
            formData.append('pasajeros', JSON.stringify(rtArrayPax));

            formData.append('solicitado_por',rt_solicitado_por);
            formData.append('email_solicitante', rt_email_solicitante);

            formData.append('fecha_solicitud', rt_fecha_solicitud);
            formData.append('tipo_traslado', rt_tipo_traslado);
            formData.append('detalleArray',rt_detalleArray);
            formData.append('rutaIdArray',rt_rutaIdArray);
           // formData.append('proveedorArray', rt_proveedorArray);
            formData.append('conductorArray', rt_conductorArray);
            formData.append('vehiculoArray', rt_vehiculoArray);
            //formData.append('vehiculoplacaArray',rt_vehiculoplacaArray);
            formData.append('id_solicitud', id_solicitud); //id de solicitud
            formData.append('recoger_enArray', rt_recogerenArray);
            formData.append('dejar_enArray', rt_dejarenArray);
            formData.append('horaArray', rt_horaArray);

            console.log(rt_fecha_servicio)
            console.log(rt_centrodecosto)
            console.log(rt_subcentrodecosto)
            console.log(rt_departamento)
            console.log(rt_ciudad)
            console.log(rtArrayPax)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)
            console.log(rt_fecha_servicio)


            $.ajax({
                url: '../../transportesrutasbog/nuevaruta2',
                data: formData,
                method: 'post',
                contentType: false,
                processData: false,
                success: function(data){

                  if (data.respuesta===true) {
                      if(data.contador!=0){

                        $('#guardando').addClass('hidden');
                        $('#guardar_rutasqr').removeClass('hidden');

                        $.confirm({
                            title: 'Atención! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
                            content: 'No se pudieron crear ' + data.contador + ' rutas ya que el corte para este centro de costo ha sido cerrado!',
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                              tryAgain: {
                                text: 'Cerrar',
                                btnClass: 'btn-danger',
                                action: function(){
                                  location.reload();
                                }
                              }
                            }
                        });

                      }else{

                        var rutas = data.contadora;
                        var cliente = data.cliente;

                        $('.charging').addClass('hidden');
                        $('.done').removeClass('hidden');

                        $('#guardando').addClass('hidden');
                        $('#guardado').removeClass('hidden');

                        $.confirm({
                            title: 'REALIZADO! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
                            content: '¡Rutas Programadas!', //'Se han programado '+rutas+' rutas para el cliente '+cliente,
                            type: 'green',
                            typeAnimated: true,
                            buttons: {
                              tryAgain: {
                                text: 'Cerrar',
                                btnClass: 'btn-success',
                                action: function(){
                                  location.reload();
                                  location.href = "../rutasporprogramar";
                                }
                              }
                            }
                        });

                      }
                  }

                }
            })

          }
          
        }

    });

    $('.actualizar').click(function () { //subir rutas old

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
      //alert('test')

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

    $('.ordenar').click(function() {
      sortTable();
    });

    $('.ok').click(function(e){
      $(this).closest('.documentacion_conductor, .documentacion_vehiculo').addClass('hidden');
    });

    $('#ruta_a_programar').on('change', '.conductor_ruta', function () {

      var conductor_id = $(this).val();
      $objeto = $(this);

      if (parseInt(conductor_id)===0 || isNaN(conductor_id)) {
        $objeto.closest('tr').find('.conductor_alert').addClass('hidden').html('');
        $('.documentacion_conductor').addClass('hidden');
        //$objeto.closest('.col-xs-4').addClass('has-error').find('.conductor_alert').html('Seleccione un conductor!').removeClass('hidden');
      }else{

      var conductor_id = parseInt(conductor_id);

        $.ajax({
          url: '../documentacionconductor',
          method: 'post',
          data: {
            id: conductor_id
          },
          success: function(data){

            if (data.respuesta===true) {
              var count = 0;
              $('.documentacion_conductor').removeClass('hidden');
              $('.documentacion_conductor').css('z-index','9999');

              if (data.seguridad_social===null) {
                $('#conductor_fssocial').removeAttr('class').addClass('text-danger bolder').html('NO EXISTE UN PAGO REGISTRADO PARA ESTE MES');
                $('#conductor_fssocial').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
                count++;
              }else if(parseInt(data.seguridad_social)===1){
                $('#conductor_fssocial').removeAttr('class').addClass('text-success bolder').html('HAY UN PAGO REGISTRADO PARA ESTE MES');
                $('#conductor_fssocial').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');
              }

              if (parseInt(data.licencia_conduccion)>=0) {
                if ($('#conductor_fvencimiento').hasClass('text-danger')) {
                  $('#conductor_fvencimiento').removeClass('text-danger');
                }
                $('#conductor_fvencimiento').addClass('text-success').html('FECHA DE VENCIMIENTO: '+data.conductor.fecha_licencia_vigencia);
                $('#conductor_fvencimiento').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');

              }else if(parseInt(data.licencia_conduccion)<0){
                $('#conductor_fvencimiento').addClass('text-danger').html('FECHA DE VENCIMIENTO: '+data.conductor.fecha_licencia_vigencia);
                $('#conductor_fvencimiento').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
                count++;
              }

              //alert('Dias examenes: '+data.dias_examen_ultimo);
              if (parseInt(data.dias_examen_ultimo)>= -365){
                if ($('#conductor_examenes').hasClass('text-danger')) { // esta dentro del rango de fecha de 6 meses
                  $('#conductor_examenes').removeClass('text-danger');
                }
                $('#conductor_examenes').addClass('text-success').html('EXAMENES REALIZADOS: '+data.fecha_examen_ultimo);
                $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');

              }else if(data.dias_examen_ultimo ===null){ // no han registrado fecha de realizacion de examen
                if ($('#conductor_examenes').hasClass('text-success')) {
                  $('#conductor_examenes').removeClass('text-success');
                }
                $('#conductor_examenes').addClass('text-danger').html('NO SE HA REALIZADO LOS EXAMENES <br>PSICOSENSOMETRICOS.');
                $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
                count++;

              }else if(parseInt(data.dias_examen_ultimo)<= -365){ // ya cumplio los 6 meses de vigencia del examen

                if ($('#conductor_examenes').hasClass('text-success')) {
                  $('#conductor_examenes').removeClass('text-success');
                }

                $('#conductor_examenes').addClass('text-danger').html('EXAMENES VENCIDOS: '+data.fecha_examen_ultimo);
                $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
                count++;

              }

              if (count>0) {
                $objeto.closest('tr').find('.conductor_alert').removeClass('hidden').html('No Tiene los documentos al dia!');
//                $('.conductor_alert').
                //$objeto.closest('.col-xs-4').addClass('has-error').find('.conductor_alert').removeClass('hidden').html('Este conductor no tiene los documentos al dia!');
                $objeto.attr('estado',false);
              }else if (count<=0) {
                $objeto.closest('tr').find('.conductor_alert').addClass('hidden');
                //$('.conductor_alert').addClass('hidden');
                //$objeto.closest('.col-xs-4').removeClass('has-error').find('.conductor_alert').addClass('hidden').html('');
                $objeto.attr('estado',true);
              }

            }else if (data.respuesta==='relogin') {
              location.reload();
            }
          }
        });
      }
    });
    //SG

    //SG control de bloqueos de vehiculos en la programación tradicional de rutas
    $('#ruta_a_programar').on('change', '.vehiculo_ruta', function () {

      var id = $(this).val();
      $objeto = $(this);

      if (parseInt(id)==='-') {
        $('.vehiculo_alert').addClass('hidden').html('');
        $('.documentacion_vehiculo').addClass('hidden');


      }else{
        var id = parseInt(id);


        $.ajax({
        url: '../documentacionvehiculo',
        data: {
          'id': id
        },
        method: 'post',
        dataType: 'json',
        success: function(data){
          if (data.respuesta===true) {

          var j = 0;
          $('.documentacion_vehiculo').removeClass('hidden');
          $('.documentacion_vehiculo').css('z-index','9999');

          if (data.administracion===null) {
            $('#vadministracion').removeAttr('class').addClass('text-danger bolder').html('NO HAY UN PAGO REGISTRADO PARA ESTE MES');
            $('#vadministracion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }else{
            $('#vadministracion').removeAttr('class').addClass('text-success bolder').html('HAY UN PAGO REGISTRADO PARA ESTE MES');
            $('#vadministracion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }

          if (parseInt(data.fecha_vigencia_operacion)>=0) {
            if ($('#vtarjeta_operacion').hasClass('text-danger')) {
            $('#vtarjeta_operacion').removeClass('text-danger');
            }
            $('#vtarjeta_operacion').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_operacion);
            $('#vtarjeta_operacion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.fecha_vigencia_operacion)<0){
            if ($('#vtarjeta_operacion').hasClass('text-success')) {
            $('#vtarjeta_operacion').removeClass('text-success');
            }
            $('#vtarjeta_operacion').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_operacion);
            $('#vtarjeta_operacion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }

          if (parseInt(data.fecha_vigencia_soat)>=0) {
            if ($('#vsoat').hasClass('text-danger')) {
            $('#vsoat').removeClass('text-danger');
            }
            $('#vsoat').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_soat);
            $('#vsoat').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.fecha_vigencia_soat)<0){
            if ($('#vsoat').hasClass('text-success')) {
            $('#vsoat').removeClass('text-success');
            }
            $('#vsoat').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_soat);
            $('#vsoat').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }

          if (parseInt(data.fecha_vigencia_tecnomecanica)>=0) {
            if ($('#vtecnomecanica').hasClass('text-danger')) {
            $('#vtecnomecanica').removeClass('text-danger');
            }
            $('#vtecnomecanica').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_tecnomecanica);
            $('#vtecnomecanica').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.fecha_vigencia_tecnomecanica)<0){
            if ($('#vtecnomecanica').hasClass('text-success')) {
            $('#vtecnomecanica').removeClass('text-success');
            }
            $('#vtecnomecanica').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.fecha_vigencia_tecnomecanica);
            $('#vtecnomecanica').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }

          if (parseInt(data.mantenimiento_preventivo)>=0) {
            if ($('#vmantenimiento_preventivo').hasClass('text-danger')) {
            $('#vmantenimiento_preventivo').removeClass('text-danger');
            }
            $('#vmantenimiento_preventivo').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.mantenimiento_preventivo);
            $('#vmantenimiento_preventivo').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.mantenimiento_preventivo)<0){
            if ($('#vmantenimiento_preventivo').hasClass('text-success')) {
            $('#vmantenimiento_preventivo').removeClass('text-success');
            }
            $('#vmantenimiento_preventivo').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.mantenimiento_preventivo);
            $('#vmantenimiento_preventivo').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }

          if (parseInt(data.poliza_contractual)>=0) {
            if ($('#vpoliza_contractual').hasClass('text-danger')) {
            $('#vpoliza_contractual').removeClass('text-danger');
            }
            $('#vpoliza_contractual').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.poliza_contractual);
            $('#vpoliza_contractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.poliza_contractual)<0){
            if ($('#vpoliza_contractual').hasClass('text-success')) {
            $('#vpoliza_contractual').removeClass('text-success');
            }
            $('#vpoliza_contractual').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.poliza_contractual);
            $('#vpoliza_contractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }

          if (parseInt(data.poliza_extracontractual)>=0) {
            if ($('#vpoliza_extracontractual').hasClass('text-danger')) {
            $('#vpoliza_extracontractual').removeClass('text-danger');
            }
            $('#vpoliza_extracontractual').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.poliza_extracontractual);
            $('#vpoliza_extracontractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
          }else if(parseInt(data.poliza_extracontractual)<0){
            if ($('#vpoliza_extracontractual').hasClass('text-success')) {
            $('#vpoliza_extracontractual').removeClass('text-success');
            }
            $('#vpoliza_extracontractual').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+data.vehiculo.poliza_extracontractual);
            $('#vpoliza_extracontractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
            j++;
          }
          if (j!=0) {
            //$objeto.closest('tr').find('.conductor_alert').removeClass('hidden').html('No Tiene los documentos al dia!');
            $objeto.closest('tr').find('.vehiculo_alert').removeClass('hidden').html('Tiene vencido '+j+' documentos!');
            $('#vehiculo').attr('estado',false);
            $objeto.closest('.col-xs-3').addClass('has-error');
            $objeto.attr('estado',false);
          }else if (j===0) {

            $objeto.closest('tr').find('.vehiculo_alert').html(' ');
            $('.vehiculo_alert').addClass('hidden');
            if ($('.vehiculo_alert').closest('.col-xs-3').hasClass('has-error')) {
            $('.vehiculo_alert').closest('.col-xs-3').removeClass('has-error');
            }
            $('#vehiculo').attr('estado',true);
            $objeto.attr('estado',true);
          }
          }
        }
        });
      }
    });

    $('.ruta').change(function(){

       var color = $(this).find('option:selected').attr('data-value');
       var id = $(this).attr('data-id');

      $('#example tbody tr').each(function () {
        
        if($(this).attr('data-id')==id){
          
          $(this).attr('style','background:#'+color+'');
          sortTable();
        }

      });

    });

    $('.horario').change(function() {

      var id = $(this).val();

      $('#example tbody tr').each(function () {
        
        if(id==0) {
          
          $(this).removeClass('hidden');
          $('#siguiente').removeClass('hidden');

        }else{

          $('#siguiente').addClass('hidden');

          if( $(this).attr('data-hora')==id ){
          
            $(this).removeClass('hidden');

          }else{

            $(this).addClass('hidden');

          }

        }

      });

    });

    var rt_fecha_servicio = '';
    var rt_centrodecosto = '';
    var rt_subcentrodecosto ='';
    var rt_departamento = '';
    var rt_ciudad = '';
    var rt_solicitado_por = '';

    var rt_email_solicitante = '';

    var rtArrayPax = [];

    $('#siguiente').click(function(e){

      var id_solicitud = $(this).attr('data-id');
      var tipo = null;
      var descp = null;

      $('#modal_programar').modal('show');

        //Array de texto de rutas
        var rt_rutaArray = [];
        var rt_rutaLoc = [];
        //Array de nombres de rutas
        var rt_rutaNombreId = [];
        var rt_rutaHora = [];
        var rt_hora = [];
        var loc = [];

        //Declaracion de json vacio
        var stringJson = '';

        //Limpiar tabla de listado de conductores a asignar a la ruta
        $('#ruta_a_programar tbody').html('');

        //Recorrer la tabla de listado de pasajeros
        $('#example tbody tr').each(function(index){
            //Recorrer cada td de la tabla
            $(this).children("td").each(function (index2){
                //Si el td de la tabla es el 10
                switch (index2){
                    case 11:
                        //Asignar valor del nombre texto de la ruta
                        rt_rutaArray.push($(this).find('select option:selected').html().trim());
                        rt_rutaLoc.push($(this).find('select option:selected').attr('data-loc'));
                        //Asignar valor del id del nombre de la ruta
                        rt_rutaNombreId.push($(this).find('select option:selected').val());
                        break;
                    case 6:
                      //Asignar valor del horario de la ruta
                      rt_rutaHora.push($(this).text());
                      break;
                }
            });

        });

        console.log('uno: '+rt_rutaArray)
        //Limpiar ambos arrays y dejar los valores que no se repiten
        var rutas = $.unique(rt_rutaArray);
        console.log('dos: '+rutas)
        //var loc = $.unique(rt_rutaLoc);
        var nombreRutaId = $.unique(rt_rutaNombreId);
        var horas = rt_rutaHora;

        var conductores = '';
        var vehiculos = '';
        var localidades = '';

        var localidades2 = '';

        //Ordenar ambos arrays
        rutas = rutas.sort();
        console.log('tres: '+rutas)
        //loc = loc.sort();
        nombreRutaId = nombreRutaId.sort();

        var rt_pasajeros = [];

        //Recorrer las rutas para asignar los pasajeros
        for (var i = 0; i < rutas.length; i++) {

            rt_pasajeros = [];

            //Recorrer cada tr de la tabla para de acuerdo a esto guardar los pasajeros
            $('#example tbody tr').each(function(index){

                //Tomar la columna 10 de la fila que contiene el nombre de la ruta
                var $objeto = $(this).find('td').eq(11);

                var $td = $(this).find('td');

                if ($objeto.find('select option:selected').html().trim()==rutas[i]) {

                  rt_pasajeros.push({
                    "nombres": $td.eq(4).html().trim(),
                    "apellidos": $td.eq(3).html().trim(),
                    "cedula": $td.eq(10).html().trim(), //employ ID
                    "direccion": $td.eq(7).html().trim(),
                    "barrio": $td.eq(2).html().trim(),
                    "cargo": $td.eq(1).html().trim(),
                    "area": '',
                    "sub_area": $td.eq(5).html().trim(),
                    "hora": $td.eq(6).html(),
                    "lat": $td.eq(0).find('.lat').val(),
                    "lng": $td.eq(0).find('.lng').val()
                  });
                  console.log(rt_pasajeros)
                  $objeto3 = $(this).find('td').eq(6).html();

                  $objeto4 = $(this).find('td').eq(11).find('select option:selected').attr('data-loc');

                }

            });

            rt_hora.push($objeto3);

            loc.push($objeto4);

            console.log(rt_pasajeros)

            rtArrayPax.push(rt_pasajeros);

        }

        $.ajax({
            url: '../conductoresyvehiculos',
            method: 'post',
            dataType: 'json',
            async: false,
            success: function(data){

                if (data.respuesta===true) {

                    for(i in data.conductores){
                        conductores += '<option value="'+data.conductores[i].id+'">'+data.conductores[i].nombre_completo+'</option>';
                    }

                }else if (data.respuesta==='relogin') {
                    location.reload();
                }

            },

        });

        $.ajax({
            url: '../localidades',
            method: 'post',
            data: {'id':id_solicitud},
            dataType: 'json',
            async: false,
            success: function(data){

                if (data.response===true) {
                  if(data.tipo==1) {
                    tipo = 'E';
                  }else{
                    tipo = 'S';
                  }
                  descp = data.descp;
                  var selected = '';
                  var selected2 = '';

                  for(i in data.localidades){
                    
                    if(data.localidades[i].site==1 && data.tipo==null) {

                      selected = 'selected';

                    }else{
                      selected = '';
                    }
                    localidades += '<option '+selected+' value="'+data.localidades[i].nombre+'">'+data.localidades[i].nombre+'</option>';
                  }

                  for(i in data.localidades){

                    if(data.localidades[i].site==1 && data.tipo==1) {

                      selected2 = 'selected';

                    }else{
                      selected2 = '';
                    }
                    localidades2 += '<option '+selected2+' value="'+data.localidades[i].nombre+'">'+data.localidades[i].nombre+'</option>';
                  }

                }else if (data.response==='relogin') {
                    location.reload();
                }

            },

        });

        var rowsRutas = '';

        for (var i = 0; i < rutas.length; i++) {

          var directions = '';

          var cont = rtArrayPax[i].length;

          console.log(cont)

          for(var u = 0; u < rtArrayPax[i].length; u++ ) {
            directions += rtArrayPax[i][u].barrio+'\n';
          }

          var horaTxt = '<div class="input-group">'+
                      '<div class="input-group date datetimepickerall">'+
                        '<input disabled type="text" class="form-control input-font" id="hora_servicio" autocomplete="off" value="'+rt_hora[i]+'">'+
                        '<span class="input-group-addon">'+
                          '<span class="fa fa-calendar">'+
                          '</span>'+
                          '</span>'+
                      '</div>'+
                    '</div>';

                    if(tipo=='S') {
                      if(cont<=4) {
                        var aut = 'AUTO ';
                      }else{
                        var aut = 'VAN ';
                      }

                      localidades = localidades;
                      localidades2 = '<option value="'+aut+loc[i]+'">'+aut+loc[i]+'</option>';
                    }else{
                      if(cont<=4) {
                        var aut = 'AUTO ';
                      }else{
                        var aut = 'VAN ';
                      }
                      localidades = '<option value="'+aut+loc[i]+'">'+aut+loc[i]+'</option>';
                      localidades2 = localidades2;
                    }

          $('#ruta_a_programar tbody').append(
            '<tr>'+
              '<td data-nombre-ruta-id="'+nombreRutaId[i]+'">'+tipo+descp+rutas[i]+'</td>'+
              '<td>'+
                  '<b title="'+directions+'">'+cont+' Pax</b>'+
              '</td>'+
              '<td>'+
                '<small role="alert" class="text-danger conductor_alert hidden"></small>'+
                '<select data-live-searh="true" name="conductor" style="width: 200px;" class="form-control input-font conductor_ruta">'+
                  '<option value="0">-</option>'+conductores+
                  '</select>'+
              '</td>'+
              '<td>'+
                '<small role="alert" class="text-danger vehiculo_alert hidden"></small>'+
                '<select disabled name="vehiculo" style="width: 90px;" class="form-control input-font vehiculo_ruta">'+
                  '<option value="0">-</option>'+
                '</select>'+
              '</td>'+
              '<td>'+
                '<select disabled name="recoger_en" style="width: 170px;" class="form-control input-font recoger_en">'+
                localidades+
                '</select>'+
                '</td>'+
              '<td>'+
                '<select disabled name="dejar_en" style="width: 170px;" class="form-control input-font dejar_en">'+
                  localidades2+
                '</select>'+
              '</td>'+
              '<td>'+horaTxt+'</td>'+
          '<tr>');

        }

        /*$('#ordenar_rutas').addClass('disabled');
        $('#exx_programar').closest('li').removeClass('disabled').addClass('active');
        $('#exx_ruta').closest('li').removeClass('active').addClass('disabled');
        $('#ex_ruta').removeAttr('data-toggle');
        $('#ex_ruta').removeClass('in active');
        $('#ex_programar').addClass('active in');
        $('#siguiente').addClass('disabled');
        $('#guardar_rutas').removeClass('disabled');*/

        //console.log(rtArrayPax);

    });

$('#ruta_a_programar').on('change', '.conductor_ruta', function () {

        var $objeto = $(this);

        var proveedor_id = $objeto.val();

        if(proveedor_id===0){

            $objeto.closest('tr').find('.vehiculo_ruta').attr('disabled','disabled').remove().append('<option value="0">-</option>');

        }else{

            $.ajax({
                method: 'post',
                url: '../mostrarconductoresyvehiculos',
                data: {'proveedores_id':proveedor_id},
                dataType: 'json',
                success: function (data) {

                    if(data.mensaje===true){
                        //$objeto.closest('tr').find('.conductor_ruta').append('<option value="0">-</option>'); //SG
                        //$objeto.closest('tr').find('.conductor_ruta').removeAttr('disabled');
                        //$objeto.closest('tr').find('.vehiculo_ruta').append('<option value="0">-</option>'); //SG
                        $objeto.closest('tr').find('.vehiculo_ruta').removeAttr('disabled');
                        //$objeto.closest('tr').find('.conductor_ruta option').remove().append('<option value="0">-</option>');
                        $objeto.closest('tr').find('.vehiculo_ruta option').remove().append('<option value="0">-</option>');

                        //$objeto.closest('tr').find('.conductor_ruta').append('<option value="0">-</option>'); //SG
                        $objeto.closest('tr').find('.vehiculo_ruta').append('<option value="0">-</option>'); //SG

                        /*for(i in data.conductores) {
                            $objeto.closest('tr').find('.conductor_ruta').append('<option value="'+data.conductores[i].id+'">'+data.conductores[i].nombre_completo+'</option>');
                        }*/

                        $objeto.closest('tr').find('.conductor_alert').addClass('hidden');

                        for(i in data.vehiculos) {
                            $objeto.closest('tr').find('.vehiculo_ruta').append(
                                '<option value="'+data.vehiculos[i].id+'">'+
                                data.vehiculos[i].placa+' / '
                                +data.vehiculos[i].clase+' / '
                                +data.vehiculos[i].marca+' / '
                                +data.vehiculos[i].modelo+
                                '</option>');
                        }

                        $objeto.closest('tr').find('.vehiculo_alert').addClass('hidden');

                    }else if(data.mensaje===false){
                         //$objeto.closest('tr').find('.conductor_ruta').attr('disabled','disabled');
                         $objeto.closest('tr').find('.vehiculo_ruta').attr('disabled','disabled');
                    }
                    for(i in data.recoger) {
                      $objeto.closest('tr').find('.dejar_en').append('<option value="'+data.recoger[i].id+'">'+data.recoger[i].nombre_lugar+'</option>');
                    }
                    for(i in data.dejar) {
                      $objeto.closest('tr').find('.recoger_en').append('<option value="'+data.dejar[i].id+'">'+data.dejar[i].nombre_lugar+'</option>');
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
        paging: false,
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
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
        'aoColumns': [
            {'sWidth': '1%'},
            {'sWidth': '2%'},
            {'sWidth': '2%'},
            {'sWidth': '1%'},
            {'sWidth': '6%'},
            {'sWidth': '2%'},
            {'sWidth': '1%'},
            {'sWidth': '3%'},
            {'sWidth': '1%'},
            {'sWidth': '2%'},
            {'sWidth': '1%'},
            {'sWidth': '2%'},
        ],
        "order": [[1, 'asc']]
    });

</script>
</body>
</html>
