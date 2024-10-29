<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title></title>
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="h_titulo">SOLICITUDES DE SERVICIO</h3>
          <div class="col-sm-8">
            <div class="row">
              @include('breadcrumbs.servicios_mobile')
            </div>
          </div>
          @if(isset($servicios))
            <table id="servicios_cancelados" class="table table-bordered hover tabla" cellspacing="0" width="100%">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Solicitante/Fecha</th>
                    <th>Ciudad</th>
                    <th>Fecha: Orden / Servicio</th>
                    <th>Itinerario</th>
                    <th>Recoger en</th>
                    <th>Dejar en</th>
                    <th>Detalle</th>
                    <th>Pax</th>
                    <th>Proveedor / Conductor</th>
                    <th>Horario</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th></th>
                </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th>#</th>
                      <th>Codigo</th>
                      <th>Solicitante/Fecha</th>
                      <th>Ciudad</th>
                      <th>Fecha: Orden / Servicio</th>
                      <th>Itinerario</th>
                      <th>Recoger en</th>
                      <th>Dejar en</th>
                      <th>Detalle</th>
                      <th>Pax</th>
                      <th>Proveedor / Conductor</th>
                      <th>Horario</th>
                      <th>Cliente</th>
                      <th>Usuario</th>
                      <th></th>
                  </tr>
              </tfoot>
              <tbody>
                  @if(count($servicios))
                    @foreach($servicios as $servicio)
                        <?php
                            $btnEditaractivado = null;
                            $btnEditardesactivado = null;
                            $btnProgactivado = null;
                            $btnProgdesactivado = null;
                        ?>
                        <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@elseif($servicio->programado_app==1) {{'success'}} @endif">
                            <td>{{$o++}}</td>
                            <td>{{$servicio->id}}</td>
                            <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>
                            <td>{{$servicio->ciudad}}</td>
                            <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
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
                                          }else{
                                              echo '<a>'.$nombre.'</a><br>';
                                          }

                                      }

                                  }

                                ?>
                                      </td>
                            <td>
                                <a href title="{{$servicio->vehiculo->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">
                                  {{$servicio->proveedor->razonsocial}}
                                </a>
                                <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                                <a href title="{{$servicio->conductor->celular.'-'.$servicio->conductor->telefono}}">{{$servicio->conductor->nombre_completo}}</a>
                            </td>
                            <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                            <td>
                              <span class="bolder">
                                @if(($servicio->centrodecosto->razonsocial===$servicio->centrodecosto->nombresubcentro))
                                  {{$servicio->razonsocial}}
                                @else{{$servicio->centrodecosto->razonsocial.
                                  '<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->subcentrodecosto->nombresubcentro}}
                                @endif
                              </span>
                            </td>
                            <td>{{$servicio->user->first_name.' '.$servicio->user->last_name}}</td>
                            <td class="text-center">
                              <a id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion">
                                <i class="fa fa-ban" aria-hidden="true"></i>
                              </a>
                            </td>
                        </tr>
                    @endforeach
                  @else
                    <td class="text-center" colspan="15">NINGUN REGISTRO DISPONIBLE EN LA TABLA</td>
                  @endif
              </tbody>
          </table>
          @endif
        </div>
      </div>

    </div>

    @include('modales.eliminar_servicio')
    @include('modales.motivo_eliminacion')

    @include('scripts.scripts')
    <script src="{{asset('jquery/servicios_mobile.js')}}"></script>
    @include('otros.pusher.servicios_cancelados')
  </body>
</html>
