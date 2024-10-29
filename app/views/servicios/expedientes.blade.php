<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Modificación de Expedientes</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <link rel="manifest" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
        body{
            background: #EEEEEE;
            font-family: 'Roboto', sans-serif;
        }
        .card{
            width: 300px;
            border: none;
            border-radius: 15px;
        }
        .adiv{
            background: #04CB28;
            border-radius: 15px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            font-size: 12px;
            height: 46px;
        }
        .chat{
            border: none;
            background: #E2FFE8;
            font-size: 10px;
            border-radius: 20px;
        }
        .bg-white{
            border: 1px solid #E7E7E9;
            font-size: 10px;
            border-radius: 20px;
        }
        .myvideo img{
            border-radius: 20px
        }
        .dot{
            font-weight: bold;
        }
        .form-control{
            border-radius: 12px;
            border: 1px solid #F0F0F0;
            font-size: 8px;
        }
        .form-control:focus{
            box-shadow: none;
            }
        .form-control::placeholder{
            font-size: 8px;
            color: #C4C4C4;
        }

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      .pac-container {
        z-index: 100000;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .bootstrap-select>.dropdown-toggle{
        padding: 8px;
      }

      .proveedor, [data-id="proveedor"]{
        z-index: 10 !important;
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
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">MODIFICACIÓN DE SERVICIOS AVIATUR</h3>

        <div class="form-inline" id="form_buscar">
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_inicial" id="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_final" id="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <select style="width: 109px;" class="form-control input-font" name="servicios">
                            <option value="0">SERVICIOS</option>
                            <option value="2">NO REVISADOS</option>
                            <option value="3">NO LIQUIDADOS</option>
                            <option value="4">NO FACTURADOS</option>
                            <option value="5">PAGO DIRECTO</option>
                            <option value="6">ENCUESTADO</option>
                            <option value="7">SERVICIOS NO AUTORIZADOS</option>
                            <option value="8">NO FINALIZADOS</option>
    						            <option value="9">NO SHOW</option>
    						            <option value="10">APP MOVIL</option>
                            <option value="11">CALIFICADOS</option>
                            <option value="12">NO CALIFICADOS</option>
                        </select>
                    </div>
                    <div class="input-group proveedor_content">
                      <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
                        <option value="0">PROVEEDORES</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                        @endforeach
                      </select>
                      <span style="cursor: pointer" class="input-group-addon proveedor_eventual"><i class="fa fa-car"></i></span>
                    </div>
                    <div class="form-group">
                        <select disabled id="conductor_search" style="width: 80px;" class="form-control input-font" name="conductores">
                            <option value="0">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                            <option value="0">-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select style="width: 107px;" class="form-control input-font" name="usuario">
                            <option value="0">USUARIOS</option>
                            @foreach($usuarios as $user)
                                <option value="{{$user->id}}">{{trim($user->first_name).' '.trim($user->last_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="codigo" id="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                    </div>
                    <button data-option="1" id="buscar" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        @if(isset($servicios))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Codigo</th>
                  <th>Solicitante</th>
                  <th>Ruta</th>
                  <th>Ciudad</th>
                  <th>Fecha Servicio</th>
                  <th>Itinerario</th>
                  <th>Recoger en</th>
                  <th>Dejar en</th>
                  <th>Detalle</th>
                  <th>Pax</th>
                  <th>Proveedor / Conductor</th>
                  <th>Horario</th>
                  <th>Cliente</th>
                  <th>Usuario</th>
                  <th>Estado</th>
                  <th></th>
                  <th>Historial</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Codigo</th>
                    <th>Solicitante</th>
                    <th>Ruta</th>
                    <th>Ciudad</th>
                    <th>Fecha Servicio</th>
                    <th>Itinerario</th>
                    <th>Recoger en</th>
                    <th>Dejar en</th>
                    <th>Detalle</th>
                    <th>Pax</th>
                    <th>Proveedor / Conductor</th>
                    <th>Horario</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th></th>
                    <th>Historial</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($servicios as $servicio)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;

                        $novedadap = DB::table('novedades_app')
                        ->where('servicio_id', $servicio->id)
                        ->whereNull('estado')
                        ->get();
                    ?>
                    <tr id="{{$servicio->id}}" class="@if($novedadap!=null){{'danger'}}@elseif(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'resaltar'}} @endif">
                        <td>{{$o++}}</td>
                        <td>{{$servicio->id}}</td>
                        <td>{{$servicio->solicitado_por}}</td>
                        <td>
                          <a title="{{$servicio->nombre_ruta}}" href>
                            {{$servicio->codigo_ruta}}
                          </a>
                        </td>
                        <td>{{$servicio->ciudad}}</td>
                        <td>{{$servicio->fecha_servicio}}</td>
                        <td>
                            @if($servicio->origen==='')@else Origen:<br>{{$servicio->origen}}@endif<br>
                            @if($servicio->destino==='')@else Destino:<br>{{$servicio->destino}}@endif<br>
                            @if($servicio->aerolinea==='')@else Aerolinea:<br>{{$servicio->aerolinea}}@endif<br>
                            @if($servicio->vuelo==='')@else Vuelo:<br>{{$servicio->vuelo}}@endif<br>
                            @if($servicio->hora_salida==='')@else Hora salida:<br>{{$servicio->hora_salida}}@endif<br>
                            @if($servicio->hora_llegada==='')@else Hora llegada:<br>{{$servicio->hora_llegada}}@endif<br>
                        </td>
                        <td>{{$servicio->recoger_en}}</td>
                        <td>{{$servicio->dejar_en}}</td>
                        <td>{{$servicio->detalle_recorrido}} <hr style="border: 1px solid gray;"><b>Expediente:<br></b> {{$servicio->expediente}}</td>
                        <td>
                          <?php

                              if ($servicio->ruta!=null) {

                                  $pax = explode('/',$servicio->pasajeros);

                                  for ($i=0; $i < count($pax); $i++) {
                                      $pasajeros[$i] = explode(',', $pax[$i]);
                                  }

                                  for ($i=0; $i < count($pax)-1; $i++) {

                                      for ($j=0; $j < count($pasajeros[$i]); $j++) {

                    										if ($j===0) {
                    											$nombre = $pasajeros[$i][$j];
                    										}

                    										if ($j===1) {
                    											$celular = $pasajeros[$i][$j];
                    										}

                    										if ($j===2) {
                    											$email = $pasajeros[$i][$j];
                    										}

                    										if ($j===3) {
                    											$nivel = $pasajeros[$i][$j];
                    										}

                    									}

                    									if (!isset($celular)){
                    										$celular = "";
                    									}

                    									if (!isset($nombre)){
                    										$nombre = "";
                    									}

                                      echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';


                                  }
                                  echo '<a data-id="'.$servicio->id.'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';

                              }else{

                                  $pax = explode('/',$servicio->pasajeros);

                                  for ($i=0; $i < count($pax); $i++) {
                                      $pasajeros[$i] = explode(',', $pax[$i]);
                                  }

                                  for ($i=0; $i < count($pax)-1; $i++) {

                                      for ($j=0; $j < count($pasajeros[$i]); $j++) {

                  										if ($j===0) {
                  											$nombre = $pasajeros[$i][$j];
                  										}

                  										if ($j===1) {
                  											$celular = $pasajeros[$i][$j];
                  										}

                  										if ($j===2) {
                  											$email = $pasajeros[$i][$j];
                  										}

                  										if ($j===3) {
                  											$nivel = $pasajeros[$i][$j];
                  										}

                                      }
                                      if (isset($celular)){
                                          echo '<a href title="'.$celular.'">'.$nombre.'</a><br>';
                                          echo '<a>'.$celular.'</a><br>';
                                      }else{
                                          echo '<a>'.$nombre.'</a><br>';
                                      }

                                  }

                              }

                          ?>
                        </td>
                        <td>
                            <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonproveedor}}</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                            <a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
                        </td>
                        <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                        <td><span class="bolder">@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}} @else {{$servicio->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}@endif</span></td>
                        <td>{{$servicio->first_name.' '.$servicio->last_name}}</td>
                        <td>
                          <?php

                              $novedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion',$servicio->id)->get();
                              $novedadapp = DB::table('novedades_app')->where('servicio_id', $servicio->id)->get();

                              if (intval($servicio->facturado)===1) {

                                  echo '<small class="text-info">FACTURADO</small><br>';
                                  $numero_factura = DB::table('ordenes_facturacion')->where('id',$servicio->factura_id)->first();
                                  echo '<small class="text-info bolder">ORDEN:'.$numero_factura->numero_factura.'</small><br>';

                              }else{

                                  $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

                                  if ($servicio->id_reconfirmacion!=null) {

                                      if ($servicio->ejecutado===1) {
                                          echo '<small class="text-info">EJECUTADO</small><br>';
                                      }else{
                                          echo '<small class="text-success">PROGRAMADO</small><br>';
                                      }
                                  }else{
                                      echo '<small class="text-success">PROGRAMADO</small><br>';
                                  }

                                  if (intval($servicio->revisado)===1) {
                                  echo '<small class="text-warning">REVISADO</small><br>';
                                  }
                                  if (intval($servicio->liquidado)===1) {
                                      echo '<small class="text-danger">LIQUIDADO</small><br>';
                                  }
                                  if (intval($servicio->facturado)!=1) {
                                      echo '<small style="color: #EC0000">SIN FACTURAR</small>';
                                  }

                              }

                              if ($servicio->id_pivote!=null) {
                                  echo '<div><small class="text-primary">EDITADO</small></div>';
                              }

                              if ($novedades!=null) {
                                  echo '<small class="text-danger">NOVEDAD</small>';
                              }

                              if ($novedadapp!=null) {
                                  echo '<div><small class="text-danger" style="color: #8a069a;">NOVEDAD APP</small></div>';
                              }

                              if ($servicio->id_reporte!=null) {
                                  echo '<br><small class="text-warning">REPORTE</small>';
                              }


                          ?>
                        </td>
                        <td class="opciones text-center">
                          <a data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td>
                          <?php
                          $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$servicio->id)->first();

                          if(isset($reconfirmacion)){

                              if ($reconfirmacion->numero_reconfirmaciones<=2) {
                                  echo '<span class="text-danger">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }else if($reconfirmacion->numero_reconfirmaciones>=3 and $reconfirmacion->numero_reconfirmaciones<=4){
                                  echo '<span class="text-info">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===5) {
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===6){
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }elseif ($reconfirmacion->numero_reconfirmaciones===7){
                                  echo '<span class="text-success">'.$reconfirmacion->numero_reconfirmaciones.' VER</span>';
                              }

                          }else{
                              echo 'VER';
                          }
                          ?>
                          @if($servicio->calificacion_app_conductor_calidad!=null)
                            <div title="Calificacion desde aplicacion de conductores" class="calificacion_listado_servicios_conductor">
                              <span>{{($servicio->calificacion_app_conductor_calidad+$servicio->calificacion_app_conductor_actitud)/2}}</span>
                              <i class="fa fa-star"></i>
                            </div>
                          @endif
                          @if($servicio->calificacion_app_cliente_calidad!=null)
                            <div title="Calificacion desde aplicacion de clientes" class="calificacion_listado_servicios_cliente">
                              <span>{{($servicio->calificacion_app_cliente_calidad+$servicio->calificacion_app_cliente_actitud)/2}}</span>
                              <i class="fa fa-star"></i>
                            </div>
                          @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    <!-- Modal de Editar -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_editar' data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Actualizar Expediente</b></h4>
            </div>
            <div class="modal-body">
              <table id="otros_servicios" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th></th>
                      <th style="text-align: center;">Codigo</th>
                      <th style="text-align: center;">Exp. Actual</th>
                      <th style="text-align: center;">Sub. Actual</th>
                      <th style="text-align: center;">Nuevo Exp.</th>
                      <th style="text-align: center;">Nuevo Sub. </th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th style="text-align: center;">Codigo</th>
                        <th style="text-align: center;">Exp. Actual</th>
                        <th style="text-align: center;">Sub. Actual</th>
                        <th style="text-align: center;">Nuevo Exp.</th>
                        <th style="text-align: center;">Nuevo Sub.</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
              </table>

              <center><div class="estado_servicio_app" style="text-align: center; background: orange; color: white; font-size: 15px; padding: 3px 5px; width: 300px; border-radius: 2px;"><span class="message"></span></div></center>

            </div>
            <div class="modal-footer">
              <a id="actualizar" style="float: right; margin-right: 6px; margin-left: 5px" class="btn btn-primary btn-icon disabled">Actualizar<i class="fa fa-check icon-btn"></i></a>
              <a style="float: right; margin-right: 6px; margin-left: 20px" data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
            </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script type="text/javascript" src="{{asset('typeahead.js')}}"></script>
    <script type="text/javascript" src="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <script type="text/javascript">

      $('#buscar').click(function(){

        var fecha_inicial = $('#fecha_inicial').val();
        var fecha_final = $('#fecha_final').val();
        var servicios = $('select[name="servicios"] option:selected').val();
        var proveedores = $('#proveedor_search').val();
        var usuario = $('select[name="usuario"] option:selected').val();
        var codigo = $('#codigo').val();

        console.log(codigo)
        //console.log(usuario_id)

        var formData = new FormData();
        var url = $('meta[name="url"]').attr('content');
        formData.append('fecha_inicial', fecha_inicial);
        formData.append('fecha_final', fecha_final);
        formData.append('servicios', servicios);
        formData.append('proveedores', proveedores);
        formData.append('usuario', usuario);
        formData.append('codigo', codigo);
        //formData.append('option', optionSearch);

        var spin = 'BUSCAR<span style="padding: 8px 8px 7px 8px" class="icon-btn">'+
                      '<i style="padding: 10px 0px 9px 0px;" class="fa fa-spinner fa-spin" aria-hidden="true"></i>'+
                   '</span>';

        $('#buscar').html('').append(spin);

        $table.clear().draw();

        $.ajax({
            type: 'post',
            url: url+'/transportesbaq/buscarord',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {

                if(data.mensaje===true){

                    $('#buscar').removeAttr('disabled');

                    var j=1;

                    for(i in data.servicios) {

                        //INICIALIZACION DE VARIABLES
                        var modificaciones = '';
                        var origen = data.servicios[i].origen;
                        var origen_data = '';
                        var destino = data.servicios[i].destino;
                        var destino_data = '';
                        var aerolinea = data.servicios[i].aerolinea;
                        var aerolinea_data = '';
                        var vuelo = data.servicios[i].vuelo;
                        var vuelo_data = '';
                        var hora_salida = data.servicios[i].hora_salida;
                        var hora_salida_data = '';
                        var hora_llegada = data.servicios[i].hora_llegada;
                        var hora_llegada_data = '';
                        var pax = [];
                        var pasajeros = [];
                        var pasajero_completo = '';
                        var numero_reconfirmacion = '';
                        var estado = '';
                        var valorCalificacion = 0;
                        var clasemodificacion = '';
                        var letraCalificacion = '';
                        var id_reconfirmacion = data.servicios[i].id;
                        var btnEditaractivado = null;
                        var btnEditardesactivado = null;
                        var btnProgactivado = null;
                        var btnProgdesactivado = null;
                        var rutaMapa = data.servicios[i].estado_servicio_app;
                        var recorrido_gps = data.servicios[i].recorrido_gps;
                        var aceptado_app = data.servicios[i].aceptado_app;

                        var cali_co_ca = data.servicios[i].calificacion_app_conductor_calidad;
                        var cali_co_ac = data.servicios[i].calificacion_app_conductor_actitud;
                        var cali_cl_ca = data.servicios[i].calificacion_app_cliente_calidad;
                        var cali_cl_ac = data.servicios[i].calificacion_app_cliente_actitud;

                        //ESTADO EJECUTADO
                        var ejecutado = parseInt(data.servicios[i].ejecutado);

                        var estado_servicio_app = parseInt(data.servicios[i].estado_servicio_app);

                        //ESTADO REVISADO
                        var revisado = parseInt(data.servicios[i].revisado);

                        //ESTADO LIQUIDADO
                        var liquidado = parseInt(data.servicios[i].liquidado);

                        //ESTADO PAGO DIRECTO
                        var pago_directo = parseInt(data.servicios[i].pago_directo);

                        //ESTADO NOVEDAD
                        var novedad = data.servicios[i].seleccion_opcion;

                        //ESTADO FACTURADO
                        var facturado = parseInt(data.servicios[i].facturado);

                        var rechazado = parseInt(data.servicios[i].rechazar_eliminacion);

                        //NUMERO DE RECONFIRMACIONES
                        var numero_reconfirmacion = data.servicios[i].numero_reconfirmaciones;

                        //PERMISO PARA EDITAR SERVICIOS
                        if(data.permisos.barranquilla.serviciosbq.edicion==='on') {
                            var btnEditaractivado = '<a data-id="' + data.servicios[i].id + '" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio" data-toggle="modal" data-target=".mymodal1"><i class="fa fa-pencil"></i></a>';
                        }else{
                            var btnEditaractivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio disabled"><i class="fa fa-pencil"></i></a>';
                        }

                        //SI LAS VARIABLE DE ITINERARIO ESTAN VACIOS ENTONCES ASIGNARLE ESPACIO PARA NO MOSTRAR NULL
                        if (origen === '') {
                            origen_data = '';
                        } else {
                            origen_data = 'Origen:<br>' + origen + '<br>';
                        }

                        if (destino === '') {
                            destino_data = '';
                        } else {
                            destino_data = 'Destino:<br>' + destino + '<br>';
                        }

                        if (aerolinea === '') {
                            aerolinea_data = '';
                        } else {
                            aerolinea_data = 'Aerolinea:<br>' + aerolinea + '<br>';
                        }

                        if (vuelo === '') {
                            vuelo_data = '';
                        } else {
                            vuelo_data = 'Vuelo:<br>' + vuelo + '<br>';
                        }

                        if (hora_salida === '') {
                            hora_salida_data = '';
                        } else {
                            hora_salida_data = 'Hora salida:<br>' + hora_salida + '<br>';
                        }

                        if (hora_llegada === '') {
                            hora_llegada_data = '';
                        } else {
                            hora_llegada_data = 'Hora llegada:<br>' + hora_llegada + '<br>';
                        }

                        //SI LA RAZON SOCIAL DEL CLIENTE ES IGUAL AL NOMBRE DEL SUBCENTRO ENTONCES
                        if (data.servicios[i].razonsocial === data.servicios[i].nombresubcentro) {
                            //MOSTRAR SOLO LA RAZON SOCIAL
                            cliente = '<span class="bolder">'+data.servicios[i].razonsocial+'</span>';
                        } else {
                            //SI NO MOSTRAR LA RAZON SOCIAL JUNTO CON EL SUBCENTRO DE COSTO
                            cliente = '<span class="bolder">'+data.servicios[i].razonsocial + '<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">' + data.servicios[i].nombresubcentro+'</span>';
                        }

                        //SEPARAR EL STRING PASAJEROS
                        pax = data.servicios[i].pasajeros.split('/');

                        //MOSTRAR LOS PASAJEROS
                        for (var a = 0; a < pax.length - 1; a++) {
                            pasajeros[a] = pax[a].split(',');
                        }

                        for (var b = 0; b < pax.length - 1; b++) {

                            var nombre = "";
                            var celular = "";
                            var nivel = "";
                            var email = "";

                            for (var c = 0; c < pasajeros[b].length; c++) {

                                /*console.log(pasajeros[b][c]); */

                                if (c === 0) {
                                    nombre = pasajeros[b][c];
                                }

                                if (c === 1) {
                                    celular = pasajeros[b][c];
                                }

                                if (c === 2) {
                                    nivel = pasajeros[b][c];
                                }

                                if (c === 3) {
                                    email = pasajeros[b][c];
                                }

                            }

                            pasajero_completo = pasajero_completo + '<a href>' + nombre + '</a><br>';

                            pasajero_completo = pasajero_completo + '<a>' + celular + '</a><br>';

                        }

                        if (parseInt(data.servicios[i].ruta)===1) {
                            pasajero_completo += '<a data-id="'+data.servicios[i].id+'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';
                        }

                        //SI EL NUMERO DE RECONFIRMACIONES ES NULL ENTONCES
                        if (numero_reconfirmacion === null) {

                            //ASIGNAR HTML VER A VARIABLE
                            numero_reconfirmacion = '<span>VER<span>';

                        } else {

                            //SI NO ASIGNAR EL NUMERO VER MAS LA CANTIDAD DE RECONFIRMACIONES
                            if (numero_reconfirmacion === 1) {
                                numero_reconfirmacion = '<span class="text-danger">1 VER<span>';
                            }
                            if (numero_reconfirmacion === 2) {
                                numero_reconfirmacion = '<span class="text-danger">2 VER<span>';
                            }
                            if (numero_reconfirmacion === 3) {
                                numero_reconfirmacion = '<span class="text-info">3 VER<span>';
                            }
                            if (numero_reconfirmacion === 4) {
                                numero_reconfirmacion = '<span class="text-info">4 VER<span>';
                            }
                            if (numero_reconfirmacion === 5) {
                                numero_reconfirmacion = '<span class="text-success">5 VER<span>';
                            }
                        }

                        //HORA CITA RESTAR 15 MINUTOS
                        horareal = data.servicios[i].hora_servicio;

                        //HORA ACTUAL DEL SISTEMA
                        horaactual = moment(horareal, 'HH:mm');

                        //HORA DE CITA
                        hora_cita = horaactual.subtract(15, 'minutes').format('HH:mm');

                        //ESTADOS PARA LOS SERVICIOS

                        //SI EL SERVICIO ESTA FACTURADO
                        if (facturado === 1) {

                            //MOSTRAR ESTADO FACTURADO
                            estado = estado + '<br><small class="text-primary">FACTURADO</small>';

                            //SI EL USUARIO ES TIPO ADMINISTRADOR ENTONCES MOSTRAR ENLACES DIRECTOS PARA LOS NUMEROS DE FACTURA
                            if (parseInt(data.tipo_usuario)===1 || parseInt(data.tipo_usuario)===3) {
                                if (data.servicios[i].nomostrar===1){
                                    estado = estado + '<br><small class="text-primary bolder"><a target="_blank" href="'+url+'/facturacion/verdetalle/'+data.servicios[i].idordenfactura+'">#:'+data.servicios[i].consecutivo+'</a></small>';
                                }else{
                                    estado = estado + '<br><small class="text-primary bolder"><a target="_blank" href="'+url+'/facturacion/verdetalle/'+data.servicios[i].idordenfactura+'">ORDEN:'+data.servicios[i].numero_factura+'</a></small>';
                                }

                            }else{
                              //SI NO SIMPLEMENTE MOSTRAR EL NUMERO DE FACTURA
                              estado = estado + '<br><small class="text-primary bolder">ORDEN:'+data.servicios[i].numero_factura+'</small>';
                            }

                            //SI LOS SERVICIOS ESTAN AUTORIZADOS ENTONCES
                            if (data.servicios[i].autorizado!=null) {
                              //SI EL USUARIO ES TIPO ADMINISTRADOR ENTONCES MOSTRAR EL PAGO DE PROVEEDORES DONDE ESTA
                              if (parseInt(data.tipo_usuario)===1) {
                                estado = estado + '<small class="text-info bolder"><a target="_blank" href="'+url+'/facturacion/detallepagoproveedores/'+data.servicios[i].pproveedorid+'">PAGADO AP: '+data.servicios[i].pconsecutivo+'</a></small>';
                              }else{
                                //SI NO SIMPLEMENTE MOSTRAR EL NUMERO DE AP A LA QUE PERTENECE
                                estado = estado + '<small  class="text-info bolder">PAGADO AP: '+data.servicios[i].pconsecutivo+'</small><br>';
                              }
                            }

                        //SI NO ESTA FACTURADO O ESTA VACIO EL CAMPO
                        } else if (facturado!=1) {

                    				if (ejecutado === 1) {
                                estado = '<small class="text-info">EJECUTADO</small>';
                    				}else{
                                estado = '<small class="text-success">PROGRAMADO</small>';
                    				}

                            //SI EL SERVICIO ESTA REVISADO ENTONCES
                            if (revisado === 1) {

                                //COLOCAR ESTADO REVISADO
                                estado = estado + '<br><small class="text-warning">REVISADO</small>';

                            }

                            if (liquidado === 1) {
                                estado = estado + '<br><small class="text-danger">LIQUIDADO</small>';
                            }

                            estado = estado + '<div><small style="color: #EC0000">SIN FACTURAR</small></div>'


                        }

                        if (data.servicios[i].servicios_id_pivote!=null) {
                            estado = estado + '<div><small class="text-primary">EDITADO</small></div>';
                        }

                        var $resaltar = parseInt(data.servicios[i].resaltar);
                        var $programado_app = parseInt(data.servicios[i].programado_app);
                        var $pago_directo = data.servicios[i].pago_directo;

                        var colorBackgr = '';

                        if ($resaltar===1) {
                          colorBackgr = 'resaltar';
                        }else if($programado_app==1){
                          colorBackgr = 'success';
                        }else {
                          colorBackgr = '';
                        }

                        /**
                         * FUNCION PARA EL ESTADO DE LOS BOTONES EDITAR O PREPARAR ELIMINACION
                         */
                        if(data.servicios[i].liquidacion_id!=null){

                            if (parseInt(data.id_usuario)===2 || parseInt(data.id_usuario)===12){
                                modificaciones += btnEditaractivado + btnProgdesactivado;
                            }else{
                                modificaciones += btnEditardesactivado + btnProgdesactivado;
                            }

                        }else if(parseInt(data.servicios[i].facturado)===1){

                            if (parseInt(data.id_usuario)===2 || parseInt(data.id_usuario)===12){
                                modificaciones += btnEditaractivado + btnProgdesactivado;
                            }else{
                                modificaciones += btnEditardesactivado + btnProgdesactivado;
                            }

                        }else if(parseInt(data.servicios[i].liquidado)===1){

                            if (parseInt(data.id_usuario)===2 || parseInt(data.id_usuario)===12 || parseInt(data.id_rol)===8){
                                modificaciones += btnEditaractivado + btnProgactivado;
                            }else{
                                modificaciones += btnEditardesactivado + btnProgdesactivado;
                            }

                        }else if(parseInt(data.servicios[i].revisado)===1){

                            if (parseInt(data.id_usuario)===2 || parseInt(data.id_usuario)===12 || parseInt(data.id_rol)===8){
                                modificaciones += btnEditaractivado + btnProgactivado;
                            }else{
                                modificaciones += btnEditardesactivado + btnProgdesactivado;
                            }

                        }else{
                            modificaciones += btnEditaractivado;
                        }

                        if (data.permisos.barranquilla.reconfirmacionbq.ver==='on'){
                            reconfirmacionHtml = '<a class="btn btn-default" href="'+url+'/transportesbaq/reconfirmacion/' + data.servicios[i].id + '">' + numero_reconfirmacion + '</a>';
                        }else{
                            reconfirmacionHtml = '<a class="btn btn-default disabled">' + numero_reconfirmacion + '</a>';
                        }

                        //Si existe calificacion por parte del app de conductores
                        (cali_co_ca!=null)? reconfirmacionHtml += '<div title="Calificacion desde aplicacion de conductores" class="calificacion_listado_servicios_conductor"><span>'+(cali_co_ca+cali_co_ac)/2+'</span><i class="fa fa-star"></i></div>' : false;
                        (cali_cl_ca!=null)? reconfirmacionHtml += '<div title="Calificacion desde aplicacion de clientes" class="calificacion_listado_servicios_cliente"><span>'+(cali_cl_ca+cali_cl_ac)/2+'</span><i class="fa fa-star"></i></div>' : false;


                        var expediente = '';

                        if(data.servicios[i].expediente!=null && data.servicios[i].expediente!=''){
                          expediente += '/ <b>EXP: </b>'+data.servicios[i].expediente;
                        }

                        if(data.servicios[i].email_solicitante!=null && data.servicios[i].email_solicitante!=''){
                          expediente += '<hr style="border: 1px solid"><b>'+ data.servicios[i].email_solicitante+'</b>';
                        }

                        $table.row.add([
                          j,
                          data.servicios[i].id,
                          data.servicios[i].solicitado_por + '<br>' + data.servicios[i].fecha_solicitud,
                          '<a href title="' + data.servicios[i].nombre_ruta + '">' + data.servicios[i].codigo_ruta + '</a>',
                          data.servicios[i].ciudad,
                          data.servicios[i].fecha_orden + '<br>' + data.servicios[i].fecha_servicio,
                          origen_data + destino_data + aerolinea_data + vuelo_data + hora_salida_data + hora_llegada_data,
                          data.servicios[i].recoger_en,
                          data.servicios[i].dejar_en,
                          data.servicios[i].detalle_recorrido + expediente,
                          pasajero_completo,
                          '<a href title="' + data.servicios[i].placa + '/' + data.servicios[i].clase + '/' + data.servicios[i].marca + '/' + data.servicios[i].modelo + '">' + data.servicios[i].razonproveedor + '</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">' +
                          '<a href title="' + data.servicios[i].celular + '-' + data.servicios[i].telefono + '">' + data.servicios[i].nombre_completo + '</a>',
                          'Hora cita:<br>' + hora_cita + '<br>Hora real:<br>' + data.servicios[i].hora_servicio,
                          cliente,
                          data.servicios[i].first_name + ' ' + data.servicios[i].last_name,
                          estado,
                          modificaciones,
                          reconfirmacionHtml
                      ]).draw().nodes().to$().addClass(colorBackgr);

                      j++;
                    }

                }else if(data.mensaje===false){

                  $('#buscar').removeAttr('disabled');
                  alert('No hubo coincidencias para esta busqueda!');

                }

            },
            error: function (request, status, error) {
                alert('Hubo un error, llame al administrador del sistema'+request+status+error);
                alert(request.responseText);
                /*location.reload();*/
            },
            complete: function(){
              var pos = window.name || 0;
              window.scrollTo(0,pos);
              spinf = 'BUSCAR<i class="fa fa-search icon-btn"></i>';
              $('#buscar').html('').append(spinf);

            }
        });

      });

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

      var $table = $('#example').DataTable({
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
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '5%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '2%' },
            { 'sWidth': '1%' },
            { 'sWidth': '3%' },
            { 'sWidth': '2%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' }
        ],
        processing: true,
        "bProcessing": true
    });

      $(document).on('click', '.editar_servicio', function(){

        var id = $(this).attr('data-id');
        //alert(id);

        $.ajax({
          url: 'buscarservicio',
          method: 'post',
          data: {id: id}
        }).done(function(data){

          if(data.respuesta==true){

            var htmlPaxqr = '';
            var y = 1;

            var input = '<input class="form-control input-font nuevo_exp" data-exp="'+data.servicio.expediente+'" style="text-transform: uppercase;" placeholder="Nuevo Expediente" id="nombre_actividad1"></input> <span>Pulsa enter para buscar subcentro <a class="btn btn-list-table btn-warning edit hidden" style="margin-left: 5px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span>';
            var expediente = '<center><div class="estado_servicio_app" style="text-align: center; background: gray; color: white; font-size: 12px; padding: 3px 5px; width: 70px; border-radius: 2px;">'+data.servicio.expediente+'</div></center>';
            var nuevo = '<center><span class="data_nuevo"></span></center';

              htmlPaxqr += '<tr>'+
                    '<td>'+y+'</td>'+
                    '<td style="text-align: center; width: 100px">'+data.servicio.id+'</td>'+
                    '<td style="text-align: center; width: 150px">'+expediente+'</td>'+
                    '<td style="text-align: center; ">'+data.servicio.nombresubcentro+'</td>'+
                    '<td style="text-align: center; width: 250px">'+input+'</td>'+
                    '<td style="text-align: center; width: 200px">'+nuevo+'</td>'+
              '</tr>';
              y++;

            $('table#otros_servicios tbody').html('').append(htmlPaxqr);

            $('#actualizar').attr('servicio_id',data.servicio.id);

            $('#modal_editar').modal('show');

          }else if(data.respuesta==false){

          }

        });

      });

      $(document).on('keypress', '.nuevo_exp', function(e){

        var code = (e.keyCode ? e.keyCode : e.which);

        if(code==13){

          var expediente = $('.nuevo_exp').val();

          if(expediente===$('.nuevo_exp').attr('data-exp')){

            $.confirm({
                title: 'Atención',
                content: 'No has cambiado el expediente...',
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

          }else{

            $(this).attr('disabled','disabled');
            $('.edit').removeClass('hidden');
            $('.message').removeClass('hidden');

            $('#actualizar').attr('expediente',expediente);

            $.ajax({
                url: 'expediente',
                data: {
                    'expediente':expediente, 'sw':1
                },
                method: 'post',
                success: function(data){

                    $('#actualizar').removeClass('disabled');

                    if (data.respuesta==true) {

                      $('#actualizar').attr('subcentro',data.subcentro);

                      if(data.cantidad>0){
                        var last = '';
                        if(data.cantidad>1){
                          last = 's';
                        }
                        $('.message').html('Este expediente tiene '+data.cantidad+' servicio'+last+'.')
                      }else{
                        $('.message').html('Este expediente no tiene ningún servicio.')
                      }
                      $('.data_nuevo').html(data.name);
                      //$('#subcentros').attr('disabled','disabled');

                    }else if (data.respuesta===false) {

                      $('#actualizar').attr('subcentro',data.subcentro);

                      $('.data_nuevo').html(data.name);
                      if(data.cantidad>0){
                        $('.message').html('Este expediente tiene '+data.cantidad+' servicios.')
                      }else{
                        $('.message').html('Este expediente no tiene ningún servicio.')
                      }

                    }
                  }

            });

          }

        }
      });

      $(document).on('click', '.edit', function(e){
        $('.nuevo_exp').removeAttr('disabled','disabled');
        $(this).addClass('hidden');
        $('.message').addClass('hidden');
        $('#actualizar').addClass('disabled');
      })

      $(document).on('click', '#actualizar', function(e){

        var servicio_id = $(this).attr('servicio_id');
        var expediente = $(this).attr('expediente');
        var subcentro = $(this).attr('subcentro');

        $.ajax({
            url: 'actualizar',
            data: {
                'servicio_id': servicio_id, 'expediente': expediente, 'subcentro': subcentro
            },
            method: 'post',
            success: function(data){

                if (data.respuesta==true) {

                  $.confirm({
                      title: '¡Realizado!',
                      content: 'Expediente actualizado.',
                      buttons: {
                          confirm: {
                              text: 'Ok',
                              btnClass: 'btn-primary',
                              keys: ['enter', 'shift'],
                              action: function(){

                                $('#modal_editar').modal('hide');
                                $('.nuevo_exp').val('');
                                $('#actualizar').addClass('disabled');
                                $('.message').addClass('hidden');
                              }

                          }
                      }
                  });

                }else if (data.respuesta===false) {

                  $.confirm({
                      title: 'Atención!',
                      content: 'No se actualizó este expediente. Verifica si ya este cambio se realizó...',
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

                }

              }

        });

      });

      $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6, .fechas_datetimepicker').datetimepicker({
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

    </script>
  </body>
</html>
