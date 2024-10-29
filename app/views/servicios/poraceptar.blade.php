<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Servicios no aceptados y rechazados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <meta name="url" content="{{url('/')}}">
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
        <h3 class="h_titulo">SERVICIOS NO ACEPTADOS Y RECHAZADOS</h3>

        @if(isset($servicios))
        <table id="tabla_servicios_poraceptar" class="table table-bordered hover tabla" cellspacing="0">
            <thead>
              <tr>
                  <th></th>
                  <th>Codigo</th>
                  <th>Solicitante/Fecha</th>
                  <th>Ciudad</th>
                  <th>Fecha: Orden / Servicio</th>
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
                    <th>Solicitante/Fecha</th>
                    <th>Ciudad</th>
                    <th>Fecha: Orden / Servicio</th>
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
                      @if($servicio->mostrar_30_min_despues())
                      <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@endif">
                          <td>{{$a}}</td>
                          <td>{{$servicio->id}}</td>
                          <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>
                          <td>{{$servicio->ciudad}}</td>
                          <td>{{$servicio->fecha_orden.'<br>'.$servicio->fecha_servicio}}</td>
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
                              <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->proveedor->razonsocial}}</a>
                              <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                              <a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->conductor->nombre_completo}}</a>
                          </td>
                          <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                          <td>
                            <span class="bolder">
                              @if(($servicio->centrodecosto->razonsocial===$servicio->subcentrodecosto->nombresubcentro))
                              {{$servicio->centrodecosto->razonsocial}}
                              @else
                              {{$servicio->centrodecosto->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->subcentrodecosto->nombresubcentro}}
                              @endif
                            </span>
                          </td>
                          <td>{{$servicio->creado_por()->first_name.' '.$servicio->creado_por()->last_name}}</td>
                          <td>
                            <?php

                                if(intval($servicio->aceptado_app)===0){
                                  echo '<div class="bolder btn-rechazado">NO ACEPTADO</div>';
                                }

                                if(intval($servicio->aceptado_app)===3){
                                  echo '<div class="estado_servicio_app" style="background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;">RECHAZADO</div>';
                                }

                            ?>
                          </td>
                          <td class="opciones text-center">
                            <a data-id-servicio="{{$servicio->id}}" class="btn btn-primary btn-list-table cambios_proveedor" data-toggle="modal" data-target="#modal_cambio_proveedor">CAMBIAR PROVEEDOR</a>
                          </td>
                          <td>
                            {{-- PERMISO PARA VER RECONFIRMACION --}}
                            @if($permisos->transportes->reconfirmacion->ver==='on')
                                <a style="margin-bottom:5px" class="@if($servicio->cancelado===1)disabled @endif btn btn-default" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}">

                                  <?php

                                  //ESTE CODIGO SE PUEDE OPTIMIZAR HACIENDO LA BUSQUEDA POR LEFT JOIN EN LA CONSULTA ORIGINAL
                                  $i=0;

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
                                </a><BR>
                                <a style="color: white !important" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}" class="hora_reconfirmacion hidden"></a>
                            @else
                                <a style="margin-bottom:5px" class="disabled btn btn-default">

                                    <?php

                                    //ESTE CODIGO SE PUEDE OPTIMIZAR HACIENDO LA BUSQUEDA POR LEFT JOIN EN LA CONSULTA ORIGINAL
                                    $i=0;

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

                                </a><BR>
                                <a style="color: white !important" class="hora_reconfirmacion hidden"></a>
                            @endif
                          </td>
                      </tr>
                      <?php $a++; ?>
                      @endif
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-rutas" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">DATOS DE PASAJEROS</h4>
                </div>
                <div class="modal-body tabbable">
                    <table style="margin-bottom: 0px;" id="pax_info" class="table table-bordered table-hover">
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
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_cambio_proveedor" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><strong>CAMBIO DE PROVEEDOR</strong></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="proveedor">Proveedor</label>
                  <select class="form-control input-font" name="proveedor" id="proveedor">
                    @foreach($proveedores as $proveedor)
                      <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger hidden"></small>
                </div>
                <div class="form-group">
                  <label for="conductor">Conductor</label>
                  <select class="form-control input-font" name="conductor" id="conductor" disabled>
                  </select>
                  <small class="text-danger hidden"></small>
                </div>
                <div class="form-group">
                  <label for="vehiculo">Vehiculo</label>
                  <select class="form-control input-font" name="vehiculo" id="vehiculo" disabled>
                  </select>
                  <small class="text-danger hidden"></small>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="cambiar_conductor" class="btn btn-primary">CAMBIAR</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/servicios_poraceptar.js')}}"></script>
    <script type="text/javascript">

        $table = $('#tabla_servicios_poraceptar').DataTable({
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
                { 'sWidth': '2%' },
                { 'sWidth': '3%' },
                { 'sWidth': '3%' },
                { 'sWidth': '2%' },
                { 'sWidth': '3%' },
                { 'sWidth': '5%' },
                { 'sWidth': '3%' },
                { 'sWidth': '3%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '2%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '2%' }
            ],
            processing: true,
            "bProcessing": true
        });
        $('#tabla_servicios_poraceptar_filter input').addClass('form-control');

    </script>
  </body>
</html>
