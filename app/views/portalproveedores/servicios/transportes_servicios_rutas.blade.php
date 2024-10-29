<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Histórico de Servicios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .bootstrap-select>.dropdown-toggle{
        padding: 8px;
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

      .parpadea {

        animation-name: parpadeo;
        animation-duration: 6s;
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
<body onload="nobackbutton();">

  @include('admin.menu')

  <div class="col-lg-12">
      <h3 class="h_titulo">Histórico de Servicios: {{Sentry::getUser()->first_name}}</h3>

      @if (isset($permisos->transportes->plan_rodamiento->ver))
        @if ($permisos->transportes->plan_rodamiento->ver="on")
          <!-- Single button -->
          <div class="btn-group" style="margin-bottom: 10px;">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Herramientas <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li>
                <a href="#" id="open_modal_plan_rodamiento">PLAN DE RODAMIENTO RUTAS</a>
              </li>
            </ul>
          </div>
        @endif
      @endif

      <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">
                      <div class="input-group">
                          <div class='input-group date' id='datetimepicker1'>
                              <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                              <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                          </div>
                      </div>
                  </div>
                  <button data-option="3" id="buscar" class="btn btn-default btn-icon">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </button>
              </div>
          </div>
      </form>

      @if(isset($servicios))
        <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th></th>
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
                <th>Estado</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
              <tr>
                  <th></th>
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
                  <th>Estado</th>
                  <th></th>
              </tr>
          </tfoot>
          <tbody>

              @foreach($servicios as $servicio)
                  <?php
                      $btnEditaractivado = null;
                      $btnEditardesactivado = null;
                      $btnProgactivado = null;
                      $btnProgdesactivado = null;
                  ?>
                  <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
                      <td>{{$o++}}</td>
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
                      <td>{{$servicio->detalle_recorrido}}</td>
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

                                      echo $nombre;


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
                                        echo '<a href >'.$nombre.'</a><br>';
                                    }else{
                                        echo '<a>'.$nombre.'</a><br>';
                                    }

                                }

                            }

                          ?>
                      </td>
                      <td>
                          <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">
                          <a href>{{$servicio->nombre_completo}}</a>
                      </td>
                      <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                      <td><span class="bolder">@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}} @else {{$servicio->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}@endif</span></td>
                      <td>
                        <?php

                            $novedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion',$servicio->id)->get();
                            $novedadapp = DB::table('novedades_app')->where('servicio_id', $servicio->id)->get();

                            if ($novedades!=null) {
                                echo '<br><small class="text-danger">NOVEDAD</small>';
                            }

                            if ($novedadapp!=null) {
                                echo '<div class="text-novedad-app"><small>NOVEDAD APP</small></div>';
                            }

                            if (intval($servicio->estado_servicio_app)===1) {
                                echo '<center><div class="estado_servicio_app" id="'.$servicio->id.$servicio->id.'" style="background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">EN SERVICIO</div></center>';
                            }else if(intval($servicio->estado_servicio_app)===2){
                                echo '<center><div class="estado_servicio_app" style="background: #eaeaea; color: black; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">FINALIZADO</div></center>';
                            }else{
                                echo '<center><div class="estado_servicio_app" id="'.$servicio->id.$servicio->id.'" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">NO INICIADO</div></center>';
                                if (intval($servicio->aceptado_app)===0) {
                                    echo '<center><div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">NO ACEPTADO</div></center>';
                                }else if(intval($servicio->aceptado_app)===3){
                                    echo '<center><div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">RECHAZADO</div></center>';
                                }else if(intval($servicio->aceptado_app)===1){
                                    echo '<center><div class="estado_servicio_app acepted'.$servicio->id.'" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">ACEPTADO</div></center>';
                                }
                            }

                        ?>
                      </td>
                      <td class="opciones text-center">
                          <?php

                            $rutaMapa = intval($servicio->estado_servicio_app);
                            $recorrido_gps = $servicio->recorrido_gps;

                          ?>
                          

                          @if($servicio->estado_servicio_app==2)
                            <a data-toggle="modal" data-target=".mymodal4" data-ruta="{{$servicio->ruta}}" data-id="{{$servicio->id}}" data- style="margin-bottom: 5px; padding: 5px 8px; background: #eaeaea; color: black" class="btn btn-success ruta_mapa {{$servicio->id}}" title="Mapa GPS">
                              <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </a>
                          @elseif($servicio->estado_servicio_app==1)
                          <a data-toggle="modal" data-target=".mymodal4" data-ruta="{{$servicio->ruta}}" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px; background: green" class="btn btn-success ruta_mapa {{$servicio->id}} parpadea" title="Mapa GPS">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                          </a>
                          @else
                          <a disabled data-toggle="modal" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px; background: gray" class="btn btn-success disabled ruta_mapa {{$servicio->id}}" title="Mapa GPS">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                          </a>
                          @endif

                          
                      </td>
                      
                  </tr>
              @endforeach
          </tbody>
      </table>
      @endif
  </div>

  @include('modales.editar_servicio')

  <!---MODAL PARA NUEVA RUTA-->
  <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">AGREGAR RUTA</h4>
            </div>
              <div class="modal-body tabbable">
                  <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                      <li role="presentation" class="active">
                          <a href="#prog_ex" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab">Programacion de Ruta</a>
                      </li>
                      <li role="presentation" class="disabled">
                          <a href="#ex_ruta" aria-controls="exx_ruta" id="exx_ruta" role="tab">Importar Listado</a>
                      </li>
                      <li role="presentation" class="disabled">
                          <a href="#ex_programar" aria-controls="e" id="exx_programar" role="tab">Ruta</a>
                      </li>
                      <li role="presentation">
                          <a href="#export_exce_ruta" aria-controls="e" id="export_ruta" role="tab" data-toggle="tab">Exportar</a>
                      </li>
                      <li role="presentation">
                          <a href="#export_exce_ruta2" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab">Exportar Dia</a>
                      </li>
                  </ul>
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade in active" id="prog_ex">
                          <div class="row" style="margin-top: 15px">
                                  <div class="col-xs-12">
                                      <div class="col-xs-2">
                                          <label>Fecha de servicio</label>
                                          <div class="input-group">
                                              <div class="input-group date" id='datetimepicker1'>
                                                  <input type='text' class="form-control input-font" id="ruta_fecha_servicio" value="{{date('Y-m-d')}}">
                                                  <span class="input-group-addon">
                                                      <span class="fa fa-calendar">
                                                      </span>
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-4" id="centro_alerta">
                                          <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                          <select class="form-control input-font" id="ruta_centro_de_costo">
                                              <option>-</option>
                                              @foreach($centrosdecosto as $centrodecosto)
                                                  @if($centrodecosto->inactivo==1)
                                                      <option disabled value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                                  @else
                                                      <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                          <small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
                                      </div>
                                      <div class="ruta_subcentros hidden">
                                          <div class="col-xs-2">
                                              <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                              <select class="form-control input-font" id="ruta_subcentros">
                                                  <option>-</option>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-xs-2" style="min-height: 67px;">
                                          <label class="obligatorio" for="departamento">Departamento</label>
                                          <select class="form-control input-font" id="ruta_departamento">
                                              <option>-</option>
                                              @foreach($departamentos as $departamento)
                                                  <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="col-xs-2">
                                          <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                          <select disabled class="form-control input-font" id="ruta_ciudad">
                                              <option>-</option>
                                          </select>
                                      </div>
                                      <div class="col-xs-12">
                                          <div class="row">

                                              <div class="col-xs-3">
                                                  <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                                  <input id="ruta_solicitado_por" type="text" class="form-control input-font">
                                              </div>
                                              <div class="col-xs-2">
                                                  <label>Fecha de Solicitud</label>
                                                  <div class="input-group">
                                                      <div class='input-group date' id='datetimepicker1'>
                                                          <input type='text' class="form-control input-font" id="ruta_fecha_solicitud" value="">
                                                          <span class="input-group-addon">
                                                              <span class="fa fa-calendar">
                                                              </span>
                                                          </span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>

                                      </div>
                                  </div>
                              </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 500px;">
                          <form style="display: inline" id="form_ruta">
                              <div style="display: inline-block; margin-bottom: 15px;">
                                  <input id="excel_ruta" type="file" value="Subir" name="excel">
                              </div>
                          </form>
                          <table name="mytable" id="ruta_import" class="table table-hover table-bordered tablesorter">
                              <thead>
                                  <tr>
                                      <td>#</td>
                                      <td>NOMBRES</td>
                                      <td>APELLIDOS</td>
                                      <td>CEDULA</td>
                                      <td>DIRECCION</td>
                                      <td>BARRIO</td>
                                      <td>CARGO</td>
                                      <td>AREA</td>
                                      <td>SUB AREA</td>
                                      <td>HORARIO</td>
                                      <td>RUTA</td>
                                  </tr>
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="ex_programar" style="padding-top: 0; overflow-y: auto; height: 500px;">
                          <table id="ruta_a_programar" class="table table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <td>RUTA</td>
                                      <td>PROVEEDOR</td>
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
                      <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta">
                          <div class="row" style="margin-top: 15px">
                              <div class="col-xs-12">
                                  <div class="col-xs-12">
                                      <div class="row">
                                          <form id="form" action="{{url('transportes/exportarrutasfechas')}}" method="post">
                                            <div class="col-xs-12">
                                                <h6>EXPORTAR RELACION DE LISTADO ENTRE FECHAS</h6>
                                            </div>
                                              <div class="col-xs-2">
                                                  <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                  <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker1">
                                                        <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_final">Fecha Final</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115px;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-xs-3">
                                                  <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                  <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                      <option>-</option>
                                                      @foreach($centrosdecosto as $centro)
                                                          <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                              <div class="col-xs-3">
                                                <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                                <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                  <option>-</option>
                                                </select>
                                              </div>
                                              <div class="col-xs-1">
                                                <label class="obligatorio">Exportar</label>
                                                <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                                  <div class="col-xs-12">
                                      <div class="row">
                                          <form id="form" action="{{url('transportes/exportarlistadodia')}}" method="post">
                                              <div class="col-xs-12">
                                                  <h6>EXPORTAR LISTADO DEL DIA</h6>
                                              </div>
                                              <div class="col-xs-2">
                                                  <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                  <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker1">
                                                        <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-xs-3">
                                                  <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                  <select name="md_centrodecosto" id="centrodecosto_ex_excel" class="form-control input-font centrodecosto_ex_excel">
                                                      <option>-</option>
                                                      @foreach($centrosdecosto as $centro)
                                                          <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                              <div class="col-xs-3">
                                                <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                                <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                  <option>-</option>
                                                </select>
                                              </div>
                                              <div class="col-xs-1">
                                                <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                                <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta2">
                          <div class="row" style="margin-top: 15px">
                              <div class="col-xs-12">
                                  <div class="col-xs-12">
                                      <div class="row">
                                          <form id="form" action="{{url('transportes/exportarrutasdia')}}" method="post">
                                              <div class="col-xs-12">
                                                  <h6>Exportar Rutas Del Dia</h6>
                                              </div>
                                              <div class="col-xs-2">
                                                  <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                  <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker1">
                                                        <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115px;" type="text" class="form-control input-font">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-calendar">
                                                            </span>
                                                        </span>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="col-xs-3">
                                                  <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                  <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                      <option>-</option>
                                                      @foreach($centrosdecosto as $centro)
                                                          <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                              <div class="col-xs-3">
                                                <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                                <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                  <option>-</option>
                                                </select>
                                              </div>
                                              <div class="col-xs-1">
                                                <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                                <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                              </div>
                                              <div class="col-xs-12">
                                                <div class="row">
                                                  <div class="col-xs-12">
                                                      <h6>Campos a Exportar</h6>
                                                      <ul class="list-group">
                                                        <div class="row">
                                                          <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Nombres
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_nombre" name="ch_nombre" type="checkbox" checked="true">
                                                                    <label for="ch_nombre" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Apellidos
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_apellido" name="ch_apellido" type="checkbox" checked="true">
                                                                    <label for="ch_apellido" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Cedula
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_cedula" name="ch_cedula" type="checkbox"/>
                                                                    <label for="ch_cedula" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                          </div>
                                                          <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Direccion
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_direccion" name="ch_direccion" type="checkbox"/>
                                                                    <label for="ch_direccion" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Barrio
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_barrio" name="ch_barrio" type="checkbox"/>
                                                                    <label for="ch_barrio" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Cargo
                                                                <div class="material-switch pull-right">
                                                                      <input id="ch_cargo" name="ch_cargo" type="checkbox"/>
                                                                    <label for="ch_cargo" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                          </div>
                                                          <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Area
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_area" name="ch_area" type="checkbox" checked="true">
                                                                    <label for="ch_area" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Sub area
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_subarea" name="ch_subarea" type="checkbox" checked="true">
                                                                    <label for="ch_subarea" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Horario
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_horario" name="ch_horario" type="checkbox"/>
                                                                    <label for="ch_horario" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                          </div>
                                                          <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Embarcado
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_embarcado" name="ch_embarcado" type="checkbox" checked="true">
                                                                    <label for="ch_embarcado" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                No Embarcado
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_no_embarcado" name="ch_no_embarcado" type="checkbox" checked="true">
                                                                    <label for="ch_no_embarcado" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                            <li class="list-group-item">
                                                                Autorizado
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_autorizado" name="ch_autorizado" type="checkbox" checked="true">
                                                                    <label for="ch_autorizado" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                          </div>
                                                          <div class="col-xs-2">
                                                              <li class="list-group-item">
                                                                  Firma
                                                                  <div class="material-switch pull-right">
                                                                      <input id="ch_firma" name="ch_firma" type="checkbox" checked="true">
                                                                      <label for="ch_firma" class="label-default"></label>
                                                                  </div>
                                                              </li>
                                                          </div>
                                                        </div>
                                                      </ul>
                                                  </div>
                                                </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <a id="continuar_ruta" class="btn btn-success btn-icon">CONTINUAR <i class="fa fa-arrow-right icon-btn"></i></a>
                  <a id="ordenar_rutas" class="btn btn-info btn-icon disabled">ORDENAR<i class="fa fa-bars icon-btn" aria-hidden="true"></i></a>
                  <a id="siguiente" class="btn btn-redu btn-icon disabled">PROGRAMAR<i class="fa fa-play icon-btn" aria-hidden="true"></i></a>
                  <a id="guardar_rutas" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
              </div>
          </div>
      </div>
  </div>

  <!---MODAL PARA EDITAR PASAJEROS DE RUTAS-->
  <div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-rutas" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">DATOS DE PASAJEROS</h4>
              </div>
              <div class="modal-body tabbable">
                  <table style="margin-bottom: 15px;" id="pax_info" class="table table-bordered table-hover">
                      <thead>
                          <tr>
                              <td>#</td>
                              <td>NOMBRES</td>
                              <td>APELLIDO</td>
                              <td>CEDULA</td>
                              <td>DIRECCION</td>
                              <td>BARRIO</td>
                              <td>CARGO</td>
                              <td>AREA</td>
                              <td>SUB AREA</td>
                              <td>HORARIO</td>
                              <td></td>
                          </tr>
                      </thead>
                      <tbody></tbody>
                  </table>
                  <a class="btn btn-info btn-icon" id="agregar_pax_ruta">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
              </div>
              <div class="modal-footer">
                  <a class="btn btn-success btn-icon boton_excel_exportar">EXPORTAR<i class="fa fa-file-excel-o icon-btn"></i></a>
                  <a class="btn btn-primary btn-icon boton_pax_guardar">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                  <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
              </div>
          </div>
      </div>
  </div>

  <div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
      <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
      <ul>
      </ul>
  </div>

  <div class="guardado bg-success text-success hidden model">
      <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
      <ul style="margin: 0;padding: 0;">
      </ul>
  </div>

  @include('modales.eliminar_servicio')

  @include('modales.motivo_eliminacion')

  <div id="motivo_rechazo" class="hidden">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">Motivo de Rechazo<i id="cerrar_alerta_sino" style="float: right; cursor: pointer" class="fa fa-close"></i></div>
              <div class="panel-body">
                  <div class="form-group">
                      <textarea disabled id="input_motivo_rechazo" cols="30" rows="10" class="form-control input-font"></textarea>
                  </div>
              </div>
          </div>

      </div>
  </div>

  <!--<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 style="display: inline-block" class="modal-title" id="myModalLabel">TRACKING GPS</h4>
                  <div class="hidden" id="estado_servicio_modal"></div>
              </div>
              <div class="modal-body tabbable">
                <div id="map" style="overflow-y: auto; height: 500px;"></div>

              </div>
              <div class="modal-footer">
                  <label id="label_hora_inicio" class="hidden" style="float: left; margin-top: 5px; font-size: 12px; margin-right: 20px;">HORA INICIAL<div class="label_timestamp" id="hora_estado_inicio"></div></label>
                  <label id="label_hora_final" class="hidden" style="float: left; margin-top: 5px; font-size: 12px;">HORA FINAL<div class="label_timestamp" id="hora_estado_final"></div></label>
                  <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
              </div>
          </div>
      </div>
  </div>-->

  <div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%">
          <div class="modal-content">
              <div class="modal-header" style="background-color: white">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <!--<center><h4 style="display: inline-block" class="modal-title" id="myModalLabel">TRACKING GPS</h4></center>-->
                  <center><div class="hidden" id="estado_servicio_modal" style="background: #4CAF50; color: white; margin: 2px 0px; font-size: 20px; padding: 3px 5px; width: 140px; border-radius: 2px"></div></center>
                  <label id="label_hora_inicio" class="hidden" style="color: black; float: left; margin-top: 5px; font-size: 12px; margin-right: 20px;">HORA INICIAL<div class="label_timestamp" id="hora_estado_inicio"></div></label>
                  <label id="label_hora_final" class="hidden" style="color: black; float: right; margin-top: 5px; font-size: 12px;">HORA FINAL<div class="label_timestamp" id="hora_estado_final"></div></label>
              </div>
              <div class="modal-body tabbable">
                <div id="map" style="overflow-y: auto; height: 650px;"></div>

              </div>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-lg-3">


                  </div>
                  <div class="col-lg-6">
                    <center><div class="hidden" id="estado_servicio_modal" style="background: gray; color: white; margin: 2px 0px; font-size: 20px; padding: 3px 5px; width: 140px; border-radius: 2px"></div></center>
                    <center><div class="estado_servicio_app letrero" style="background: #f47321; color: white; margin: 2px 0px; font-size: 25px; padding: 3px 5px; width: 95%; border-radius: 6px;"><b class="estado_mensaje parpadea">...</b></div></center>
                  </div>
                  <div class="col-lg-3">
                    <!--<a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>-->
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Opcion de reconfirmacion, variable obligatoria -->
  <?php $option_reconfirmacion = 2; ?>
  @include('modales.activacion_reconfirmacion')
  <!-- -->

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
                <span>RESTRICCIONES<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vrestriccion" style="font-size: 10px" class="text-warning bolder">
                  <ul style="padding-left: 15px; padding-top: 6px;">
                  </ul>
                </small>
              </li>
              <li class="list-group-item">
                <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vadministracion" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder"></small>
              </li>
              <li class="list-group-item">
                <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                <small id="vsoat" style="font-size: 10px" class="text-success bolder"></small>
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

  <div class="modal fade mdl_alertas" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-medium">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                  <strong>LISTADO DE COTIZACIONES</strong>
              </div>
              <div class="modal-body">
                  <div id="alertas_vigencia" style="overflow-y: auto; height: 400px;">

  					<table id="tabla_cotizaciones" class="table table-bordered hover tabla">
  						<thead>
  						  <tr>

  							<th>Fecha</th>
  							<th>Nombre completo</th>
  							<th>Tipo</th>
  							<th>Estado</th>
  							<th></th>
  						  </tr>
  						</thead>
  						<tbody>
  						  @if(isset($cotizaciones))
  							@foreach($cotizaciones as $cotizacion)
  							  <tr>
  								<td><label title="Vence: {{$cotizacion->fecha_vencimiento}}">{{$cotizacion->fecha}}</label></td>
  								<td><label title="Vendedor: {{$cotizacion->vendedor}} Contacto: {{$cotizacion->contacto}}">{{$cotizacion->nombre_completo}}</label></td>

  								<?php
  								  $tipo = '';
  								  if(intval($cotizacion->tipo)===1){
  									$tipo = 'TRANSPORTE';
  								  }elseif(intval($cotizacion->tipo)===2){
  									$tipo = 'TURISMO';
  								  }elseif(intval($cotizacion->tipo)===3){
  									$tipo = 'AMBAS';
  								  }
  								?>
  								<td>{{$tipo}}</td>
  								<td>
  									@if(intval($cotizacion->estado)===1)
  									APROBADO
  										@if($cotizacion->contenido_html === null || $cotizacion->contenido_html==='')
  										<a class="btn btn-list-table btn-default prog_serv" style="float: right;" title="Programar Servicio" data-toggle="modal" data-target=".mymodal"><i class="fa fa-car" aria-hidden="true"></i></a>
  										@endif
  									@endif

  									@if(intval($cotizacion->estado)===2)
  									EN NEGOCIACION
  									@endif

  									@if(intval($cotizacion->estado)===3)
  									RECHAZADO
  									@endif

  									@if(intval($cotizacion->estado)===4)
  									VENCIDO
  									@endif

  									@if(intval($cotizacion->estado)===5)
  									SIN GESTION
  									@endif
  								</td>
  								<td>
  								@if($cotizacion->contenido_html != null || $cotizacion->contenido_html !='')
  								  <a href="{{url('cotizaciones/exportarcotizacion/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger" title="Exportar">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
  								@else
  									<a href="{{url('cotizaciones/exportarcot/'.$cotizacion->id)}}" class="btn btn-list-table btn-danger" title="Exportar">PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
  								@endif

  								</td>
  							  </tr>
  							@endforeach
  						  @endif
  						</tbody>
  					</table>
                  </div>
              </div>
              <div class="modal-footer">
                  <!-- <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a> -->
              </div>
          </div>
      </div>
  </div>

  <audio id="audio">
      <source id="avisos" src="{{url('notify_start.mp3')}}" type="audio/mpeg">
  </audio>

  <audio id="audio2">
      <source id="avisos" src="{{url('notify_end.mp3')}}" type="audio/mpeg">
  </audio>

  @if (isset($permisos->transportes->plan_rodamiento->ver))
    @if ($permisos->transportes->plan_rodamiento->ver="on")
      @include('modales.transportes.plan_de_rodamiento')
    @endif
  @endif

  @include('scripts.scripts')

  @include('otros.firebase_cloud_messaging')

  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>-->
  <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!--<script src="{{url('jquery/servicios.js')}}"></script>-->

  @include('otros.pusher.servicios_cancelados')
  @include('otros.pusher.notify_baq')
  @include('otros.pusher.notify_bog')

  @if(Sentry::getUser()->coordinador===1)
    <script>
      $('#modal-activar-reconfirmacion')
          .animate({
            opacity: 1,
      },2000);
    </script>
  @endif

  @include('otros.google_maps_init')

  <script type="text/javascript">

      window.onload=function(){
        var pos=window.name || 0;
        window.scrollTo(0,pos);

      }
      window.onunload=function(){
      window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
      }

      function nobackbutton(){

         window.location.hash="no-back-button";

         window.location.hash="Again-No-back-button" //chrome

         window.onhashchange=function(){
           window.location.hash="no-back-button";
         }
      }

      //BUSQUEDA Y FILTROS
      $('#buscar').click(function (e) {

          var url = $('meta[name="url"]').attr('content');
          var $objeto = $(this);

          $objeto.attr('disabled','disabled');
          $('#buscar_icon').removeClass('fa-search').addClass('fa-cog fa-spin');
          $table.clear().draw();
          e.preventDefault();

          var formData = new FormData($('#form_buscar')[0]);

          /**opciones para el buscador

              1. vista de servicios principal
              2. vista de afiliados que no hacen servicios con Aotour
              3. servicios y rutas

          */

          var option = parseInt($objeto.attr('data-option'));
          buscarServicios(url, option);

      });

      function buscarServicios(url, optionSearch){

        var formData = new FormData($('#form_buscar')[0]);
        var url = $('meta[name="url"]').attr('content');
        formData.append('option', optionSearch);

        var spin = 'BUSCAR<span style="padding: 8px 8px 7px 8px" class="icon-btn">'+
                      '<i style="padding: 10px 0px 9px 0px;" class="fa fa-spinner fa-spin" aria-hidden="true"></i>'+
                   '</span>';

        $('#buscar').html('').append(spin);

        $table.clear().draw();

        $.ajax({
            type: 'post',
            url: url+'/portalproveedores/buscarservicios',
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

                        //ESTADO QR
                        //var rutaqr = parseInt(data.servicios[i].ruta_qr);

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
                            var btnEditaractivado = '<a id="' + data.servicios[i].id + '" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio" data-toggle="modal" data-target=".mymodal1"><i class="fa fa-pencil"></i></a>';
                        }else{
                            var btnEditaractivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio disabled"><i class="fa fa-pencil"></i></a>';
                        }

                        var btnEditardesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="disabled btn btn-primary"><i class="fa fa-pencil"></i></a>';

                        //PERMISO PARA ELIMINAR SERVICIOS
                        if(data.permisos.barranquilla.serviciosbq.eliminacion==='on'){
                            //BOTON PARA PROGRAMAR ELIMINACION ACTIVADO HTML
                            var btnProgactivado = '<a id="' + data.servicios[i].id + '" style="padding: 5px 6px;" class="btn btn-warning programar_eliminacion"><i class="fa fa-ban"></i></a>';
                        }else{
                            var btnProgactivado = '<a style="padding: 5px 6px;" class="btn btn-warning programar_eliminacion disabled"><i class="fa fa-ban"></i></a>';
                        }

                        var btnProgdesactivado = '<a style="padding: 5px 6px;" class="btn btn-warning disabled"><i class="fa fa-ban"></i></a>';

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

                            pasajero_completo = pasajero_completo + '<a>' + nombre + '</a><br>';

                        }

                        if (parseInt(data.servicios[i].ruta)===1) {
                            pasajero_completo += '<a data-id="'+data.servicios[i].id+'" class="btn btn-default pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>';
                        }

                        //HORA CITA RESTAR 15 MINUTOS
                        horareal = data.servicios[i].hora_servicio;

                        //HORA ACTUAL DEL SISTEMA
                        horaactual = moment(horareal, 'HH:mm');

                        //HORA DE CITA
                        hora_cita = horaactual.subtract(15, 'minutes').format('HH:mm');

                        //ESTADOS PARA LOS SERVICIOS

                        if (estado_servicio_app===1) {
                            estado = estado + '<center><div class="estado_servicio_app" style="background: #409641; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">EN SERVICIO</div></center>';
                        }else if(estado_servicio_app===2){
                            estado = estado + '<center><div class="estado_servicio_app" style="background: #eaeaea; color: black; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">FINALIZADO</div></center>';
                        }else{
                            estado = estado + '<center><div class="estado_servicio_app" id="'+data.servicios[i].id+data.servicios[i].id+'" style="background: gray; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">NO INICIADO</div></center>';

                            if (aceptado_app===0) {
                                estado = estado + '<center><div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 72px; border-radius: 2px;">NO ACEPTADO</div></center>';
                            }else if(aceptado_app===3){
                                estado = estado + '<center><div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">RECHAZADO</div></center>';
                            }else if(aceptado_app===1){
                                estado = estado + '<center><div class="estado_servicio_app acepted'+data.servicios[i].id+'" style="background: #f47321; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 72px; border-radius: 2px;">ACEPTADO</div></center>';
                            }
                            
                        }

                        var $resaltar = parseInt(data.servicios[i].resaltar);
                        var $programado_app = parseInt(data.servicios[i].programado_app);
                        var $pago_directo = data.servicios[i].pago_directo;

                        var colorBackgr = '';
                          //RESULTADOS PARA LAS ENCUESTAS

                        if ($resaltar===1) {
                          colorBackgr = 'resaltar';
                        }else if($programado_app==1){
                          colorBackgr = 'success';
                        }else {
                          colorBackgr = '';
                        }

                        if (data.permisos.barranquilla.reconfirmacionbq.ver==='on'){
                            reconfirmacionHtml = '<a class="btn btn-default" href="'+url+'/transportes/reconfirmacion/' + data.servicios[i].id + '">' + numero_reconfirmacion + '</a>';
                        }else{
                            reconfirmacionHtml = '<a class="btn btn-default disabled">' + numero_reconfirmacion + '</a>';
                        }

                        //Si existe calificacion por parte del app de conductores
                        (cali_co_ca!=null)? reconfirmacionHtml += '<div title="Calificacion desde aplicacion de conductores" class="calificacion_listado_servicios_conductor"><span>'+cali_co_ca+'</span><i class="fa fa-star"></i></div>' : false;
                        (cali_cl_ca!=null)? reconfirmacionHtml += '<div title="Calificacion desde aplicacion de clientes" class="calificacion_listado_servicios_cliente"><span>'+cali_cl_ca+'</span><i class="fa fa-star"></i></div>' : false;

                        if(data.servicios[i].estado_servicio_app==2){
                          modificaciones += '<a data-toggle="modal" data-target=".mymodal4" data-ruta="'+data.servicios[i].ruta+'" data-id="'+data.servicios[i].id+'" style="margin-bottom: 5px; padding: 5px 8px; background: #eaeaea; color: black; margin-top: 5px" class="btn btn-success ruta_mapa" title="Mapa GPS">'+
                                  '<i class="fa fa-map-marker" aria-hidden="true"></i></a>';
                        }else if(data.servicios[i].estado_servicio_app==1){
                          modificaciones += '<a data-toggle="modal" data-target=".mymodal4" data-ruta="'+data.servicios[i].ruta+'" data-id="'+data.servicios[i].id+'" style="margin-bottom: 5px; padding: 5px 8px; background: green; margin-top: 5px" class="btn btn-success ruta_mapa parpadea" title="Mapa GPS">'+
                                  '<i class="fa fa-map-marker" aria-hidden="true"></i></a>';
                        }else{
                          modificaciones += '<a disabled data-id="'+data.servicios[i].id+'" style="margin-bottom: 5px; padding: 5px 8px; background: gray; margin-top: 5px" class="btn btn-success ruta_mapa disabled" title="Mapa GPS">'+
                                  '<i class="fa fa-map-marker" aria-hidden="true"></i></a>';
                        }

                        $table.row.add([
                          j,
                          data.servicios[i].ciudad,
                          data.servicios[i].fecha_servicio,
                          origen_data + destino_data + aerolinea_data + vuelo_data + hora_salida_data + hora_llegada_data,
                          data.servicios[i].recoger_en,
                          data.servicios[i].dejar_en,
                          data.servicios[i].detalle_recorrido,
                          pasajero_completo,
                          '<a href title="' + data.servicios[i].placa + '/' + data.servicios[i].clase + '/' + data.servicios[i].marca + '/' + data.servicios[i].modelo + '">' + data.servicios[i].razonproveedor + '</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">' +
                          '<a href title="' + data.servicios[i].celular + '-' + data.servicios[i].telefono + '">' + data.servicios[i].nombre_completo + '</a>',
                          'Hora cita:<br>' + hora_cita + '<br>Hora real:<br>' + data.servicios[i].hora_servicio,
                          cliente,
                          estado,
                          modificaciones,
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

      }

      $(document).on("keydown", function (event) {
        if (event.which === 8 && !$(event.target).is("input, textarea")) {
         event.preventDefault();
        }
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
            { 'sWidth': '2%' },
            { 'sWidth': '1%' },
        ],
        processing: true,
        "bProcessing": true
    });

  </script>
</body>
</html>
