<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Reconfirmacion</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')
  
<div class="col-lg-12">
  <div class="row">
  @if(isset($servicios))
  <div class="col-lg-12">
    <h3 class="h_titulo">HISTÓRICO DEL SERVICIO</h3>
    <!--@if($permisos->barranquilla->encuestabq->ver==='on')
      <a data-toggle="modal" data-target=".mymodale" style="margin-bottom: 15px;" href="#" class="btn btn-success btn-icon input-font">
        ENCUESTA<i class="fa fa-file-text-o icon-btn" aria-hidden="true"></i>
      </a>
      
      <br>
    @endif-->

    <!-- new -->
    <hr style="border: 1px solid #DEDDDD">
<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="row">

    @if($service->ruta==1)

      <?php 
      $users = DB::table('qr_rutas')
      ->where('servicio_id',$service->id)
      ->get();

      ?>
      
      <div class="col-lg-12" >

        <h3 class="h_titulo" style="text-align: center;">SERVICIO</h3>
        <table style="margin-bottom: 10px; margin-top: -10px; border: 2px solid gray;" class="table table-hover table-bordered">
          <thead>
            <tr>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321">Conductor <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321">Fecha <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321; ">Hora <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321; ">Desde <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321; ">Hasta <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321; ">Detalle <b></b></h4></td>
              <td width="14%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321; ">Usuario <b></b></h4></td>
            </tr>
          </thead>
          <tbody>
            <tr style="border: 2px solid gray;">
              <th style="text-align: center; border: 2px solid gray;"> {{$service->nombre_completo}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->fecha_servicio}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->hora_servicio}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->recoger_en}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->dejar_en}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->detalle_recorrido}} </th>
              <th style="text-align: center; border: 2px solid gray;"> {{$service->first_name.' '.$service->last_name}} </th>
            </tr>
          </tbody>
        </table>

        <h3 class="h_titulo" style="text-align: center;">TELEMETRÍA</h3>
        <table style="border: 2px solid gray;" class="table table-hover table-bordered">
          <thead>
            <tr>
              <td width="50%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321">Hora de Inicio: @if($service->estado_servicio_app==2)<b>{{date("H:i", strtotime(explode(' ',$service->hora_inicio)[1]))}}</b>@endif</h4></td>
              <td width="50%" style="text-align: center; border: 2px solid gray;"><h4 style="color: #f47321">Hora de Finalización: @if($service->estado_servicio_app==2)<b>{{date("H:i", strtotime(explode(' ',$service->hora_finalizado)[1]))}}</b>@endif</h4></td>
            </tr>
          </thead>
        </table>
        <table style="margin-bottom: 10px; border: 2px solid gray;" class="table table-hover table-bordered">
          <thead>
            <tr style="border: 2px solid gray;">
              <td style="border: 2px solid gray;">#</td>
              <td width="41%" style="color: #f47321; border: 2px solid gray;">Nombre del Pasajero</td>
              <td style="text-align: center; color: #f47321; border: 2px solid gray;">Estado</td>
              <td style="text-align: center; color: #f47321; border: 2px solid gray;">Calificación</td>
            </tr>
          </thead>
          <tbody>
          <?php $cont = 1; ?>
          @foreach($users as $user)
            <tr>
              <td style="border: 2px solid gray;">{{$cont}}</td>
              <td style="border: 2px solid gray;"><i class="fa fa-user" aria-hidden="true"></i> {{$user->fullname}}<br><i class="fa fa-location-arrow" aria-hidden="true"></i> {{$user->address}}</td>
              <td style="border: 2px solid gray;">
                <center>
                @if($user->status==1)
                  
                    <i style="color: green; font-size: 18px" class="fa fa-check" aria-hidden="true"></i>
                    @if($user->novedad!=null)
                      <br>{{$user->novedad}}
                    @endif

                    @if($user->location!=null)
                      <?php

                        $data = explode(',', $user->location);
                        
                        echo '<br>'.$data[2];

                      ?>
                    @endif
                  
                @else
                  <i style="color: red; font-size: 18px" class="fa fa-times" aria-hidden="true"></i>
                @endif
                </center>
              </td>
              <td style="text-align: center; border: 2px solid gray;">
                @if($user->rate!=null)
                  {{$user->rate}} <i style="color: green; font-size: 15px" class="fa fa-star" aria-hidden="true"></i>
                @else
                  @if($user->status==1)
                    <center><div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 70px; border-radius: 2px;">SIN CALIFICAR</div></center>
                  @else
                    <center><div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 70px; border-radius: 2px;">N/A</div></center>
                  @endif
                @endif
              </td>
            </tr>
            <?php $cont++; ?>
          @endforeach
          </tbody>
        </table>
      </div>
      
    @endif

  </div>
</div>

<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="row">

    @if($service->ruta==1)

      <?php 
      $users = DB::table('qr_rutas')
      ->where('servicio_id',$service->id)
      ->get();

      ?>
      
      <div class="col-lg-12" style="margin-top: -10px;">
        <h3 class="h_titulo" style="text-align: center;">TRACKING GPS</h3>
        <table style="margin-bottom: 10px" class="table table-hover table-bordered">
          <div style="height: 457px; border: 2px solid gray;" id="map"></div>
        </table>
      </div>
      
    @endif

  </div>
</div>

<!--<hr style="border: 1px solid #DEDDDD;">-->

<!--<div class="col-lg-3 col-md-3 col-sm-3">
  <div class="row">

    <table class="table table-striped table-bordered hover">
      <thead>
      <tr>
          <th>FECHA</th>
          <th>HORA</th>
          <th>PASAJEROS</th>
          <th>PROVEEDOR</th>
          <th>CLIENTE</th>
          <th>USUARIO</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <?php
          #FUNCION PARA CALCULAR LA CANTIDAD DE MINUTOS ENTRE DOS RANGO DE HORAS
          function calcularMinutos($horacita){
              $to_time = strtotime($horacita);
              $from_time = strtotime(date('H:i'));
              return round(($to_time - $from_time) / 60,2). " minutos";
          }
        ?>

      @foreach($servicios as $servicio)

          <td>{{$servicio->fecha_servicio}}</td>
          <td>{{$hora_cita = date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}</td>
              <?php
                  $minutos = calcularMinutos($hora_cita);
              ?>
          <td>
              <?php
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

            if (!isset($email)){
              $email = "";
            }

            if (!isset($nivel)){
              $nivel = "";
            }
                        echo '<a href="#" title="'.$celular.'">'.$nombre.'</a><br><a href title="'.$email.'">'.$nivel.'</a><br>';

                  }
                ?>
          </td>
          <td>{{$servicio->razonsocial.' / '.$servicio->nombre_completo}}</td>

          <td><strong>{{$servicio->razon.' / '.$servicio->nombresubcentro}}</strong></td>
          <td>@if(isset($reconfirmacion)){{$reconfirmacion->first_name.'<br>'.$reconfirmacion->last_name}}@endif</td>
          
      @endforeach

      </tr>

      
      </tbody>
    </table>

  </div>
</div>-->

<!-- new -->

    
  </div>
  @endif

  @if(isset($servicios))
  <!--<a style="margin-top: 20px" title="Ver Listado" data-id="{{$servicio->id}}" class="btn btn-danger pax_ruta" data-toggle="modal" data-target=".mymodal3"><i class="fa fa-search"></i></a>-->
    <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 20px">
      <div style="border: 1px dashed #CCCCCC;padding: 10px; margin-bottom:10px">
        <h3 class="h_titulo">NOVEDADES</h3>
        <div class="form-group">
            <label>Tipo de novedad</label>
            <select class="form-control input-font" id="tipo_novedad">
                <option>-</option>
                <option value="1">INFORMACION ERRADA</option>
                <option value="2">NO SHOW</option>
                <option value="3">TIEMPO DE ESPERA</option>
                <option value="4">PARADA ADICIONAL</option>
                <option value="5">TIEMPO DE ESPERA Y NO SHOW</option>
                <option value="6">TIEMPO DE ESPERA Y PARADA ADICIONAL</option>
                <option value="7">OTRO</option>
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control input-font" id="descripcion" placeholder="ESCRIBA AQUI SU DESCRIPCION"></textarea>
        </div>
              <a data-id="{{$servicio->id}}" id="guardar_novedad" class="btn btn-default btn-icon">Guardar<i class="fa fa-save icon-btn"></i></a>               
      </div>
    </div>
  @endif
  <div class="col-lg-5 col-md-5 col-sm-12" style="margin-top: 20px; margin-left: 20px">
    <div style="border: 1px dashed #CCCCCC;padding: 10px; margin-bottom:10px">
      <h3 class="h_titulo">REPORTES</h3>
        <div class="form-group">
            <textarea rows="5" class="form-control input-font" id="descripcion_reporte" placeholder="ESCRIBA AQUI LA DESCRIPCION DEL REPORTE"></textarea>
        </div>
        <a data-id="{{$servicio->id}}" id="guardar_reporte" class="btn btn-default btn-icon input-font">Guardar<i class="fa fa-save icon-btn"></i></a>
    </div>
  </div>

<div class="col-lg-12 col-md-12 col-sm-12">
  <div class="row">

    @if(isset($ediciones))
      @if($ediciones!=null)
      <div class="col-lg-10">
        <h3 class="h_titulo">HISTORIAL DE EDICION</h3>
        <table style="margin-bottom: 10px" class="table table-hover table-bordered">
          <thead>
            <tr>
              <td>#</td>
              <td>CAMBIOS</td>
              <td>REALIZADO POR</td>
              <td>FECHA Y HORA</td>
            </tr>
          </thead>
          <tbody>
          @foreach($ediciones as $edicion)
            <tr>
              <td>{{$i++}}</td>
              <td>{{strtoupper($edicion->cambios)}}</td>
              <td>{{$edicion->first_name.' '.$edicion->last_name}}</td>
              <td>{{$edicion->created_at}}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      @endif
    @endif

    @if($permisos->barranquilla->novedadbq->ver==='on' or $permisos->bogota->novedad->ver==='on')
        @if(isset($novedades))
          @if($novedades!=null)
          <div class="col-lg-4 col-md-4 col-sm-4">
            <h3 class="h_titulo">LISTADO DE NOVEDADES</h3>
            @foreach($novedades as $nove)
              <li class="list-group-item" style="background: #f7f7f7;">
                @if(intval($nove->seleccion_opcion)===1)
                  <h4 class="list-group-item-heading">{{'INFORMACION ERRADA'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===2)
                  <h4 class="list-group-item-heading">{{'NO SHOW'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===3)
                  <h4 class="list-group-item-heading">{{'TIEMPO DE ESPERA'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===4)
                  <h4 class="list-group-item-heading">{{'PARADA ADICIONAL'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===5)
                  <h4 class="list-group-item-heading">{{'TIEMPO DE ESPERA Y NO SHOW'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===6)
                  <h4 class="list-group-item-heading">{{'TIEMPO DE ESPERA Y PARADA ADICIONAL'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                @if(intval($nove->seleccion_opcion)===7)
                  <h4 class="list-group-item-heading">{{'OTROS'}}</h4>
                  <small style="font-size: 12px" class="text-success">{{$nove->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$nove->first_name.' '.$nove->last_name}}</small><br>
                  <span class="input-font">{{$nove->descripcion}}</span>
                @endif
                <br>
                <a id="exportarpdf" href="../exportarnovedad/{{$servicio->id}}" style="margin-top: 5px;" class="btn btn-danger btn-icon input-font">PDF<i class="fa fa-file-pdf-o icon-btn"></i></a>
              </li>
            @endforeach
          </div>
          @endif
        @endif
    @endif

    @if($permisos->barranquilla->novedadbq->ver==='on')
        @if(isset($novedades_app))
          @if($novedades_app!=null)
          <div class="col-lg-4 col-md-4 col-sm-12" style="margin-bottom: 15px;">
            <h3 class="h_titulo">LISTADO DE NOVEDADES APP</h3>
            @foreach($novedades_app as $noveapp)

              @if ($noveapp->tipo_novedad==1)
                <?php
                  $tipo_novedad = 'PARADA ADICIONAL';
                  $detalles = $noveapp->detalles;
                ?>

              @endif

              @if ($noveapp->tipo_novedad==2)
                <?php
                  $tipo_novedad = 'TIEMPO DE ESPERA';
                  $detalles = explode(',', $noveapp->detalles);
                  $detalles = '<span>Dias:</span> '.$detalles[0].' <span>Horas:</span> '.$detalles[1].' <span>Minutos:</span> '.$detalles[2];
                ?>
              @endif

              @if ($noveapp->tipo_novedad==3)
                <?php
                  $tipo_novedad = 'TIEMPO DE ESPERA Y PARADA ADICIONAL';
                  $detalles = explode('&/()', $noveapp->detalles);
                  $detalles_tiempo = explode(',', $detalles[1]);
                  $detalles_tiempo = '<span>Horas:</span> '.$detalles_tiempo[0].' <span>Minutos:</span> '.$detalles_tiempo[1];
                  $detalles = $detalles_tiempo.'<br> '.$detalles[0];
                ?>
              @endif

              @if ($noveapp->tipo_novedad==4)
                <?php
                  $tipo_novedad = 'NO SHOW';
                  $detalles = $noveapp->detalles;
                ?>
              @endif

              @if ($noveapp->tipo_novedad==5)
                <?php
                  $tipo_novedad = 'OTROS';
                  $detalles = $noveapp->detalles;
                ?>
              @endif

              <li class="list-group-item" style="background: #f7f7f7;">
               <span class="titulo_novedad">{{$tipo_novedad}}</span><br>
               <span>{{$detalles}}</span>
               <br>
                @if($noveapp->estado===null)
                  <a style="margin-top: 10px; margin-bottom:10px" data-value="{{$noveapp->id}}" data-value="{{$noveapp->servicio_id}}" class="btn btn-success btn-icon input-font aceptar">Aceptar<i class="fa fa-check icon-btn"></i></a>
                  <a style="margin-top: 10px; margin-bottom:10px" data-value="{{$noveapp->id}}" data-servicio="{{$noveapp->servicio_id}}" class="btn btn-danger btn-icon input-font rechazar">Rechazar<i class="fa fa-times icon-btn"></i></a>
                @endif

                @if($noveapp->estado===1)
                  <span style="color: green">Aprobada por {{$noveapp->usuario_rechazo}}</span>
                @elseif($noveapp->estado===2)
                  <span style="color: red">Rechazada por {{$noveapp->usuario_rechazo}}</span>
                @endif
              </li>

            @endforeach
          </div>
          @endif
        @endif
    @endif

    @if(isset($reportes))
        @if($permisos->barranquilla->reportesbq->ver==='on')
          <div class="col-lg-4 col-md-4 col-sm-12">
            <h3 class="h_titulo">LISTADO DE REPORTES</h3>
            @foreach($reportes as $reporte)
              <li class="list-group-item" style="background: #f7f7f7;">
                  <small style="font-size: 12px" class="text-success">{{$reporte->created_at}}</small><br>
                  <small style="font-size: 12px" class="text-info">{{$reporte->first_name.' '.$reporte->last_name}}</small><br>
                  <span class="input-font">{{$reporte->descripcion}}</span>
              </li>
            @endforeach
          </div>
        @endif
    @endif

    @if(Sentry::getUser()->id_rol===2 || Sentry::getUser()->id_rol===1 || Sentry::getUser()->id_rol===5 || Sentry::getUser()->id_rol===52 || Sentry::getUser()->id_rol===8)
      @if(isset($cambiosFacturacion))
        @if($cambiosFacturacion!=null)
          <div class="col-lg-8 col-md-8 col-sm-12">
          <h3 class="h_titulo">PROCESO Y CAMBIOS DE FACTURACION</h3>
          <table style="margin-bottom: 5px" class="table table-hover table-bordered">
            <thead>
              <tr>
                <td>#</td>
                <td>FECHA</td>
                <td>ACCION</td>
                <td>REALIZADO POR</td>
              </tr>
            </thead>
            <tbody>
            <?php
              $cambiosFacturacion = json_decode($cambiosFacturacion);
            ?>
            @foreach($cambiosFacturacion as $cambios)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$cambios->fecha}}</td>
                <td>{{$cambios->accion}}</td>
                <td>{{$cambios->realizado_por}}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        @endif
      @endif
    @endif

  </div>
</div>

</div>
<div class="col-lg-12">
    <div class="row">
        <a style="margin-top: 10px; margin-bottom:10px" class="btn btn-primary btn-icon input-font" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
    </div>
</div>

{{-- si la variable $encuesta es diferente de null quiere decir que este servicio ya tiene encuesta --}}
@if($encuesta!=null)
  <div class="modal fade mymodale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <form id="formulario" style="margin:0">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">ENCUESTA DE SATISFACCION</h4>
              </div>
              <div class="modal-body">
                @foreach($encuesta as $enc)
                <div class="row">
                  <div class="col-xs-12">
                    <div class="col-xs-2">
                      <labeL for="encuestado">Hora</label>
                      <div class="input-group">
                          <div class="input-group hora">
                              <input type='text' class="form-control input-font" name="hora" disabled value="{{$enc->hora}}">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                    </div>
                    <div class="col-xs-2">
                      <label for="encuestado">Fecha</label>
                      <div class="input-group">
                          <div class="input-group date">
                              <input type='text' class="form-control input-font" name="fecha" value="{{$enc->fecha}}" disabled>
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                    </div>
                    <div class="col-xs-4">
                      <label class="obligatorio" for="encuestado">Nombre de La Persona Encuestada</label>
                      <input type="text" class="form-control input-font" name="encuestado" value="{{$enc->nombre_encuestado}}" disabled>
                    </div>
                    <div class="col-xs-4">
                      <label class="obligatorio" for="area">Area</label>
                      <input type="text" class="form-control input-font" name="area" value="{{$enc->area}}" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="col-xs-12">
                      <ul class="list-group grupo-lista" style="margin-top: 15px;">
                        <li class="list-group-item list-group-item-info"><strong>1.</strong> ¿Recibio usted de manera clara y comprensible toda información relativa al servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_1" value="1" disabled @if(intval($enc->pregunta_1)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_1" value="2" disabled @if(intval($enc->pregunta_1)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>2.</strong> ¿El vehiculo estuvo disponible a la hora y lugar señalados?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_2" value="1" disabled @if(intval($enc->pregunta_2)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_2" value="2" disabled @if(intval($enc->pregunta_2)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>3.</strong> ¿Califica nuestro servicio como confiable y seguro?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_3" value="1" disabled @if(intval($enc->pregunta_3)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_3" value="2" disabled @if(intval($enc->pregunta_3)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>4.</strong> ¿Nuestro conductor le brindó la atención adecuada?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_4" value="1" disabled @if(intval($enc->pregunta_4)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_4" value="2" disabled @if(intval($enc->pregunta_4)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>5.</strong> ¿Reportaría usted alguna no conformidad en su servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_5" value="1" disabled @if(intval($enc->pregunta_5)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_5" value="2" disabled @if(intval($enc->pregunta_5)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                          <div class="form-group @if(intval($enc->pregunta_5)===2) {{'hidden'}} @endif" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input disabled name="cual10" type="text" class="form-control input-font" id="" placeholder="CUAL?" value="{{$enc->cual5}}">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>6.</strong> ¿Plantearía alguna sugerencia en este momento?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_6" value="1" disabled @if(intval($enc->pregunta_6)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_6" value="2" disabled @if(intval($enc->pregunta_6)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                          <div class="form-group @if(intval($enc->pregunta_6)===2) {{'hidden'}} @endif" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input disabled name="cual10" type="text" class="form-control input-font" id="" placeholder="CUAL?" value="{{$enc->cual6}}">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>7.</strong> ¿Recomendaría nuestros servicios?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input disabled class="sn" type="radio" name="pregunta_7" value="1" disabled @if(intval($enc->pregunta_7)===1) {{'checked'}} @endif>
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input disabled type="radio" name="pregunta_7" value="2" disabled @if(intval($enc->pregunta_7)===2) {{'checked'}} @endif>
                              2. No
                            </label>
                          </div>
                          <div class="form-group" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input disabled name="cual10" type="text" class="form-control input-font" id="" placeholder="PORQUE?" value="{{$enc->cual7}}">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>8.</strong> ¿Cómo califica el tiempo en que fue contactado por nuestros funcionarios para el servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="1" disabled @if(intval($enc->pregunta_8)===1) {{'checked'}} @endif>
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="2" disabled @if(intval($enc->pregunta_8)===2) {{'checked'}} @endif>
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="3" disabled @if(intval($enc->pregunta_8)===3) {{'checked'}} @endif>
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="4" disabled @if(intval($enc->pregunta_8)===4) {{'checked'}} @endif>
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="5" disabled @if(intval($enc->pregunta_8)===5) {{'checked'}} @endif>
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>9.</strong> ¿Cómo califica el confort e higiene del vehiculo asignado a su servicio?</li>
                        <li class="list-group-item">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="1" disabled @if(intval($enc->pregunta_9)===1) {{'checked'}} @endif>
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="2" disabled @if(intval($enc->pregunta_9)===2) {{'checked'}} @endif>
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="3" disabled @if(intval($enc->pregunta_9)===3) {{'checked'}} @endif>
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="4" disabled @if(intval($enc->pregunta_9)===4) {{'checked'}} @endif>
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="5" disabled @if(intval($enc->pregunta_9)===5) {{'checked'}} @endif>
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>10.</strong> ¿En terminos generales como califica nuestros servicios?</li>
                        <li class="list-group-item ">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="1" disabled @if(intval($enc->pregunta_10)===1) {{'checked'}} @endif>
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="2" disabled @if(intval($enc->pregunta_10)===2) {{'checked'}} @endif>
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="3" disabled @if(intval($enc->pregunta_10)===3) {{'checked'}} @endif>
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="4" disabled @if(intval($enc->pregunta_10)===4) {{'checked'}} @endif>
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="5" disabled @if(intval($enc->pregunta_10)===5) {{'checked'}} @endif>
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info">
                          <div class="form-group">
                            <label for="">Anotar percepciones del encuestado durante la aplicacion de la encuesta</label>
                            <textarea disabled name="percepcion" type="text" class="form-control input-font" id="" placeholder="">{{$enc->percepcion}}</textarea>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="modal-footer">
                  <div class="calificacion">
                    <?php

                      $totalCalificacion = 0;

                      foreach ($encuesta as $enc => $value) {

                        if (intval($value->pregunta_1)===1) {
                          $totalCalificacion = $totalCalificacion + 4.5;
                        }else if (intval($value->pregunta_1)===2) {
                          $totalCalificacion = $totalCalificacion +1.5;
                        }

                        if (intval($value->pregunta_2)===1) {
                          $totalCalificacion = $totalCalificacion + 4.5;
                        }else if (intval($value->pregunta_2)===2) {
                          $totalCalificacion = $totalCalificacion +1.5;
                        }

                        if (intval($value->pregunta_3)===1) {
                          $totalCalificacion = $totalCalificacion + 4.5;
                        }else if (intval($value->pregunta_3)===2) {
                          $totalCalificacion = $totalCalificacion +1.5;
                        }

                        if (intval($value->pregunta_4)===1) {
                          $totalCalificacion = $totalCalificacion + 4.5;
                        }else if (intval($value->pregunta_4)===2) {
                          $totalCalificacion = $totalCalificacion +1.5;
                        }

                        $totalCalificacion = $totalCalificacion + $value->pregunta_8;
                        $totalCalificacion = $totalCalificacion + $value->pregunta_9;
                        $totalCalificacion = $totalCalificacion + $value->pregunta_10;
                      }

                      if ($totalCalificacion<=10) {
                        echo '<label style="color: red">CALIFICACION FINAL: </label>';
                        echo '<strong style="color: red">   '.round($totalCalificacion).'</strong>';
                      }elseif ($totalCalificacion>=11 and $totalCalificacion<=20) {
                        echo '<label style="color: orange">CALIFICACION FINAL: </label>';
                        echo '<strong style="color: orange"> '.round($totalCalificacion).'</strong>';
                      }elseif ($totalCalificacion>=21 and $totalCalificacion<=27) {
                        echo '<label style="color: #E0E000">CALIFICACION FINAL: </label>';
                        echo '<strong style="color: #E0E000"> '.round($totalCalificacion).'</strong>';
                      }elseif ($totalCalificacion>=28 and $totalCalificacion<=32) {
                        echo '<label style="color: green">CALIFICACION FINAL: </label>';
                        echo '<strong style="color: green"> '.round($totalCalificacion).'</strong>';
                      }elseif ($totalCalificacion>=33 and $totalCalificacion<=35) {
                        echo '<label style="color: teal">CALIFICACION FINAL: </label>';
                        echo '<strong style="color: teal"> '.round($totalCalificacion).'</strong>';
                      }

                    ?>
                  </div>
                  <a data-dismiss="modal" class="btn btn-danger btn-icon input-font">CERRAR<i class="fa fa-times icon-btn"></i></a>
              </div>
              </form>
          </div>
      </div>
  </div>
@else
  <div class="modal fade mymodale" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formulario" style="margin:0">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>ENCUESTA DE SATISFACCION</strong>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12">
                  <div class="col-xs-2">
                    <labeL for="hora">Hora</label>
                    <div class="input-group">
                        <div class="input-group hora">
                            <input type="text" class="form-control input-font" name="hora">
                            <span style="cursor: pointer;" class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-xs-2">
                    <label for="fecha">Fecha</label>
                    <div class="input-group">
                        <div class="input-group date">
                            <input type="text" class="form-control input-font" name="fecha">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <label class="obligatorio" for="encuestado">Nombre de La Persona Encuestada</label>
                    <input type="text" class="form-control input-font" name="encuestado">
                  </div>
                  <div class="col-xs-4">
                    <label class="obligatorio" for="area">Area</label>
                    <input type="text" class="form-control input-font" name="area">
                  </div>
                </div>
                <div class="col-xs-12">
                  <div class="col-xs-12">
                      <ul class="list-group grupo-lista" style="margin-top: 15px;">
                        <li class="list-group-item list-group-item-info"><strong>1.</strong> ¿Recibio usted de manera clara y comprensible toda información relativa al servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_1" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_1" value="2">
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>2.</strong> ¿El vehiculo estuvo disponible a la hora y lugar señalados?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_2" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_2" value="2">
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>3.</strong> ¿Califica nuestro servicio como confiable y seguro?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_3" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_3" value="2">
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>4.</strong> ¿Nuestro conductor le brindó la atención adecuada?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_4" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_4" value="2">
                              2. No
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>5.</strong> ¿Reportaría usted alguna no conformidad en su servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_5" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_5" value="2">
                              2. No
                            </label>
                          </div>
                          <div class="form-group hidden" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input disabled name="cual5" type="text" class="form-control input-font" id="" placeholder="CUAL?">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>6.</strong> ¿Plantearía alguna sugerencia en este momento?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_6" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input class="sn" type="radio" name="pregunta_6" value="2">
                              2. No
                            </label>
                          </div>
                          <div class="form-group hidden" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input disabled name="cual6" type="text" class="form-control input-font" id="" placeholder="CUAL?">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>7.</strong> ¿Recomendaría nuestros servicios?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_7" value="1">
                              1. Si
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_7" value="2">
                              2. No
                            </label>
                          </div>
                          <div class="form-group" style="display:inline-block; margin-bottom: 0px; width: 600px">
                            <input name="cual7" type="text" class="form-control input-font" id="" placeholder="PORQUE?">
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>8.</strong> ¿Cómo califica el tiempo en que fue contactado por nuestros funcionarios para el servicio?</li>
                        <li class="list-group-item val">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="1">
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="2">
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="3">
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="4">
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_8" value="5">
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>9.</strong> ¿Cómo califica el confort e higiene del vehiculo asignado a su servicio?</li>
                        <li class="list-group-item">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="1">
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="2">
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="3">
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="4">
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_9" value="5">
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info"><strong>10.</strong> ¿En terminos generales como califica nuestros servicios?</li>
                        <li class="list-group-item ">
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="1">
                              1. Malo
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="2">
                              2. Regular
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="3">
                              3. Aceptable
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="4">
                              4. Bueno
                            </label>
                          </div>
                          <div class="radio inline_block_margin">
                            <label>
                              <input type="radio" name="pregunta_10" value="5">
                              5.Excelente
                            </label>
                          </div>
                        </li>
                        <li class="list-group-item list-group-item-info">
                          <div class="form-group">
                            <label for="">Anotar percepciones del encuestado durante la aplicacion de la encuesta</label>
                            <textarea name="percepcion" type="text" class="form-control input-font" id="" placeholder=""></textarea>
                          </div>
                        </li>
                      </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
                @if($permisos->barranquilla->encuestabq->crear==='on')
                    <a id="guardar_encuesta" data-id="{{$servicio->id}}" data-centrodecosto="{{$servicio->centrodecosto_id}}" class="btn btn-primary btn-icon boton_pax_guardar input-font">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                    <a data-dismiss="modal" class="btn btn-danger btn-icon input-font">CERRAR<i class="fa fa-times icon-btn"></i></a>
                @else
                    <a class="btn btn-primary disabled btn-icon boton_pax_guardar input-font">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                    <a data-dismiss="modal" class="btn btn-danger btn-icon input-font">CERRAR<i class="fa fa-times icon-btn"></i></a>
                @endif
            </div>
            </form>
        </div>
    </div>
</div>
@endif

<div class="modal fade mymodale2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-small" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">TERMINAR SERVICIO</h4>
      </div>
      <div class="modal-body">
        <div class="form-group" style="margin-bottom: 0px">
          <label for="">Digite el numero de constancia</label>
          <input type="text" class="form-control input-font" name="numero_constancia">
          <small id="numero_constancia" role="alert" class="text-danger hidden">Debe digitar un numero de constancia!</small>
          <small id="numero_repetido" role="alert" class="text-danger hidden">Este numero de constancia ya ha sido tomado!</small>
        </div>
      </div>
      <div class="modal-footer">
        <button data-id="{{$servicio->id}}" type="button" class="btn btn-primary btn-icon input-font" id="guardar_numero_constancia">GUARDAR<i class="fa fa-save icon-btn"></i></button>
        <button type="button" class="btn btn-danger btn-icon input-font" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade mymodale3" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-small" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">EDITAR NUMERO DE CONSTANCIA</h4>
      </div>
      <div class="modal-body">
        <div class="form-group" style="margin-bottom: 0px">
          <label for="">Digite el numero de constancia</label>
          <input type="text" id="input_editar_numero" class="form-control input-font">
          <small id="numero_constancia" role="alert" class="text-danger hidden">Debe digitar un numero de constancia!</small>
          <small id="numero_repetido" role="alert" class="text-danger hidden">Este numero de constancia ya ha sido tomado!</small>
        </div>
      </div>
      <div class="modal-footer">
        <button data-id="{{$servicio->id}}" type="button" class="btn btn-primary btn-icon input-font" id="editar_guardar_numero_constancia">GUARDAR<i class="fa fa-save icon-btn"></i></button>
        <button type="button" class="btn btn-danger btn-icon input-font" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
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
                            <td>NOMBRE COMPLETO</td>
                            <td>EMPLOY ID / CÉDULA</td>
                            <td>TELÉFONO</td>
                            <td>DIRECCION</td>
                            <td>BARRIO</td>
                            <td>CARGO</td>
                            <td>AREA</td>
                            <td>CAMPAÑA</td>
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

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('jquery/reconfirmacion.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACJEoM8HDxDoXlixFQdZnNxVf2XiSXJM0&callback=initMap&libraries=places&v=weekly"
      defer
    ></script>
<script type="text/javascript">

  
  //visualización del mapa
  function initMap(){
      //usamos la API para geolocalizar el usuario
      var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: position.coords.longitude,
              lat: position.coords.latitude
            };

            

            setMapa(coords);
            
           
          },function(error){console.log(error);});
    }

    function setMapa(coords) {

        var polylineOptionsActual = new google.maps.Polyline({
          strokeColor: '#5F6062',
          strokeOpacity: 0.6,
          strokeWeight: 4
        });

        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true, polylineOptions: polylineOptionsActual});  

        // Start/Finish icons
         var icons = {
          start: new google.maps.MarkerImage(
           // URL
           'start.png',
           // (width,height)
           new google.maps.Size( 44, 32 ),
           // The origin point (x,y)
           new google.maps.Point( 0, 0 ),
           // The anchor point (x,y)
           new google.maps.Point( 22, 32 )
          ),
          end: new google.maps.MarkerImage(
           // URL
           'end.png',
           // (width,height)
           new google.maps.Size( 44, 32 ),
           // The origin point (x,y)
           new google.maps.Point( 0, 0 ),
           // The anchor point (x,y)
           new google.maps.Point( 22, 32 )
          )
         };     

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          mapTypeControl: false,
          center: new google.maps.LatLng(coords.lat,coords.lng),
          
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
        directionsRenderer.setMap(map);
              
              

        var id = '{{$service->id}}';

        var boundsv = new google.maps.LatLngBounds();
        var boundsv2 = new google.maps.LatLngBounds();

        const marcador = new google.maps.Marker({
          position: null,
          map: map,
          title: 'Pick-Up',
          animation: google.maps.Animation.DROP,
          icon: {
            url: "{{url('img/partida.png')}}",
            scaledSize: new google.maps.Size(45, 45)
          },
          zIndex: 5000
        });

        //INFO WINDOW
        var contentStringg = '<div id="content">'+
        '<h4 style="color: orange">Punto de recogida</h4>'
        '</div>';

        var infowindoww = new google.maps.InfoWindow({
          content: contentStringg
        });

        marcador.addListener('click', function() {
          infowindoww.open(map, marcador);
        });
              
        $.ajax({
            url: '../../maps/serviciofinalizado',
            data: {
              id: id
            },
            method: 'post',
            dataType: 'json',
            success: function(data){                
                //INSTANCIA DEL MARCADOR DEL CONDUCTOR

                //USANDO
                //Marcador del conductor
                var conductor = new google.maps.Marker({
                  position: null,
                  map: map,
                  title: 'Driver',
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: "{{url('img/car.png')}}",
                    scaledSize: new google.maps.Size(70, 50)
                  },
                  zIndex: 5000
                });

                var destinations = new google.maps.Marker({
                  position: null,
                  map: map,
                  title: 'Destino',
                  animation: google.maps.Animation.DROP,
                  icon: {
                    url: "{{url('img/marker_bandera.png')}}",
                    scaledSize: new google.maps.Size(45, 45)
                  },
                  zIndex: 5000
                });

                //INFO WINDOW
                var contentStringd = '<div id="content">'+
                '<h4 style="color: orange">Punto de Destino: '+data.servicio.dejar_en+'</h4>'
                '</div>';

                var infowindowd = new google.maps.InfoWindow({
                  content: contentStringd
                });

                destinations.addListener('click', function() {
                  infowindowd.open(map, destinations);
                });

                //INFO WINDOW
                var contentString = '<div id="content">'+
                '<h4 style="color: orange">Conductor: '+data.conductor+' <i class="fa fa-car" aria-hidden="true"></i></h4>'
                '</div>';

                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                conductor.addListener('click', function() {
                  infowindow.open(map, conductor);
                });

                //USANDO


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
                      url: "{{url('img/marker_auto.png')}}",
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
                  

                if (data.respuesta===true) {  

                  var bounds = new google.maps.LatLngBounds(); 

                  var location_pass = null;
                  var coor = null;

                  var disposicion = 0;
                  var sw = 0;

                  var contadorPosicion = 0;
                  
                  $('.calificado').addClass('hidden');
                  $('.por_calificar').addClass('hidden');

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
                              zoom: 18,
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
                              url: "{{url('img/partida.png')}}",
                              scaledSize: new google.maps.Size(45, 45)
                            },
                            zIndex: 5000
                          });

                          //INFO WINDOW
                          var contenido = '<div id="content">'+
                          '<h4>Aquí inició la aplicación el conductor</h4>'
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
                                scaledSize: new google.maps.Size(45, 45)
                              },
                              zIndex: 5000
                            });

                            //INFO WINDOW
                            var contenidofinal = '<div id="content">'+
                            '<h4>Aquí finalizó la aplicación el conductor </h4>'
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
                                scaledSize: new google.maps.Size(45, 45)
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

                          for(var j in data.users){

                            if(data.users[j].status==1){

                              var lati = JSON.parse(data.users[j].location)['latitude'];
                              var longi = JSON.parse(data.users[j].location)['longitude'];
                              var nombre = data.users[j].fullname;

                              var latLong = new google.maps.LatLng(lati, longi);
                              var text = data.users[j].fullname;

                              text = new google.maps.Marker({
                                position: latLong,
                                title: nombre,
                                map: map,                        
                                animation: google.maps.Animation.DROP,
                                icon: {
                                  url: "{{url('img/marker_pasajero_recogido.png')}}",
                                  scaledSize: new google.maps.Size(45, 45)
                                },
                                zIndex: 4000
                              });

                              //INFO WINDOW
                              var texts = '<div id="content">'+
                              '<h4 style="color: orange">'+nombre+'</h4>'
                              '</div>';
                              console.log(texts)
                              var textss = new google.maps.InfoWindow({
                                content: texts
                              });

                              text.addListener('click', function() {
                                textss.open(map, text);
                              });

                              text.setPosition(latLong);

                              //markers.push(text);

                            }

                          }

                        }, 1500);    


                }

                }else if (data.respuesta==='relogin') {
                  location.reload();
                }
            }
        });        
    }

    var trazadoRuta = null;
    var markers = [];
  //visualización del mapa

  function goBack(){
      window.history.back();
  }

  $('.aceptar').click(function() {

    var id = $(this).attr('data-value');

    console.log('aceptar precionado!!! '+id)

    $.ajax({
      url: '../aceptarnovedad',
      method: 'post',
      data: {
        id: id
      },
      dataType: 'json',
    }).done(function(data){

      if (data.respuesta===true) {

        $.confirm({
          title: '¡Realizado! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
          content: 'Novedad confirmada!',
          type: 'green',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'Ok',
              btnClass: 'btn-success',
              action: function(){
                location.reload();
              }
            }
          }
        });

      }else if (data.respuesta===false) {

          $.confirm({
              title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
              content: 'No se pudo realizar la acción!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                tryAgain: {
                  text: 'Entendido',
                  btnClass: 'btn-danger',
                  action: function(){
                    location.reload();
                  }
                }
              }
          });

      }
    });

  });

  $('.rechazar').click(function() {

    var id = $(this).attr('data-value');
    var servicio_id = $(this).attr('data-servicio');

    console.log('rechazar precionado!!! '+id)

    $.ajax({
      url: '../rechazarnovedad',
      method: 'post',
      data: {
        id: id,
        servicio_id: servicio_id
      },
      dataType: 'json',
    }).done(function(data){

      if (data.respuesta===true) {

        $.confirm({
          title: '¡Realizado! <i style="color: green" class="fa fa-check" aria-hidden="true"></i> ',
          content: 'Novedad Rechazada!',
          type: 'green',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'Ok',
              btnClass: 'btn-success',
              action: function(){
                location.reload();
              }
            }
          }
        });

      }else if (data.respuesta===false) {

          $.confirm({
              title: '¡Error! <i style="color: red" class="fa fa-times" aria-hidden="true"></i> ',
              content: 'No se pudo realizar la acción!',
              type: 'red',
              typeAnimated: true,
              buttons: {
                tryAgain: {
                  text: 'Entendido',
                  btnClass: 'btn-danger',
                  action: function(){
                    location.reload();
                  }
                }
              }
          });

      }
    });

  });

  $('.pax_ruta').click(function(e){

        e.preventDefault();
        var id = $(this).attr('data-id');
        
        $json = '';

        $('.boton_pax_guardar').attr('data-id',id);

        $('.boton_excel_exportar').attr('href','transportesrutas/exportarpasajerosrutas/'+id)

        $('#pax_info tbody').html('');

        $.ajax({
            url: '../../transportesrutas/verrutapax',
            method: 'post',
            data: {'id': id},
            success: function(data){

                if (data.respuesta===true) {

                    var $json = JSON.parse(data.pasajeros);
                    var htmlPax = '';

                    for(i in $json){

                      htmlPax += '<tr>'+
                          '<td>'+(parseInt(i)+1)+'</td>'+
                          '<td>'+$json[i].nombres+'</td>'+
                          '<td>'+$json[i].apellidos+'</td>'+
                          '<td>'+$json[i].cedula+'</td>'+
                          '<td>'+$json[i].direccion+'</td>'+
                          '<td>'+$json[i].barrio+'</td>'+
                          '<td>'+$json[i].cargo+'</td>'+
                          '<td>'+$json[i].area+'</td>'+
                          '<td>'+$json[i].sub_area+'</td>'+
                          '<td>'+$json[i].hora+'</td>'+
                          '<td><a style="margin-right:3px; padding: 5px 6px;" class="btn btn-primary editar_pax_ruta"><i class="fa fa-pencil"></i></a><a style="margin-right:3px; padding: 5px 6px;" class="btn btn-success guardar_pax_ruta disabled"><i class="fa fa-save"></i></a><a style="padding: 5px 6px;" class="btn btn-danger eliminar_pax_ruta"><i class="fa fa-close"></i></a></td>'+
                      '</tr>'

                    }

                    $('#pax_info tbody').append(htmlPax);

                }
            }
        });
    });

</script>
</body>
</html>
