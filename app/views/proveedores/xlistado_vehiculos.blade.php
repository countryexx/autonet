<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Vehiculos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')

<div class="col-lg-12">

    <h3 class="h_titulo">LISTADO DE VEHICULOS</h3>
    <table class="table table-bordered table-hover" id="listado_vehiculos">
        <thead>
        <tr>
            <th>Proveedor</th>
            <th>Placa</th>
            <th>Clase</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Año</th>
            <th>Capacidad</th>
            <th>Propietario</th>
            <th>Empresa</th>
            <th>Tarjeta de Operacion</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php

           #CANTIDAD DE VEHICULOS CON DOCUMENTOS VENCIDOS
           $documentos_vehiculos_vencidos = 0;

           ##CANTIDAD DE VEHICULOS CON DOCUMENTOS POR VENCER
           $documentos_vehiculos_por_vencer = 0;

           ##CANTIDAD DE DOCUMENTOS POR VENCER POR VEHICULO
           $cantidad_documentos_por_vencer = 0;

           ##CANTIDAD DE DOCUMENTOS VECIDOS POR VEHICULO
           $documentos_vencidos_por_vehiculos = 0;

        ?>
        @foreach($vehiculos as $vehiculo)

            <?php

                $i = 0;

                ##CANTIDAD DE DOCUMENTOS
                $documentos_vencidos_por_vehiculos = 0;
                $cantidad_documentos_por_vencer = 0;

                $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
                $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
                $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
                $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
                $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
                $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

                ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
                if ($tarjeta_operacion<0 or $soat<0 or $tecnomecanica<0 or $mantenimiento_preventivo<0
                        or $poliza_contractual<0 or $poliza_extracontractual<0){
                    $documentos_vehiculos_vencidos++;
                }

                ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
                if (($tarjeta_operacion>=0 && $tarjeta_operacion<=30) or
                        ($soat>=0 && $soat<=30) or
                        ($tecnomecanica>=0 && $tecnomecanica<=30) or
                        ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=30) or
                        ($poliza_contractual>=0 && $poliza_contractual<=30) or
                        ($poliza_extracontractual>=0 && $poliza_extracontractual<=30))
                {
                    $documentos_vehiculos_por_vencer++;
                }

                ##TARJETA DE OPERACION VENCIDA
                if ($tarjeta_operacion<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($tarjeta_operacion>=0 && $tarjeta_operacion<=30){
                    $cantidad_documentos_por_vencer++;
                }

                ##SOAT
                if ($soat<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($soat>=0 && $soat<=30){
                    $cantidad_documentos_por_vencer++;
                }

                ##TECNOMECANICA
                if($tecnomecanica<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($tecnomecanica>=0 && $tecnomecanica<=30){
                    $cantidad_documentos_por_vencer++;
                }

                ##MANTENIMIENTO PREVENTIVO
                if($mantenimiento_preventivo<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=30){
                    $cantidad_documentos_por_vencer++;
                }

                ##POLIZA CONTRACTUAL
                if($poliza_contractual<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($poliza_contractual>=0 && $poliza_contractual<=30){
                    $cantidad_documentos_por_vencer++;
                }

                ##POLIZA EXTRACONTRACTUAL
                if($poliza_extracontractual<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($poliza_contractual>=0 && $poliza_contractual<=30){
                    $cantidad_documentos_por_vencer++;
                }

            ?>

            <tr data-vencido="<?php if($documentos_vencidos_por_vehiculos>0): echo '1'; else: echo '0'; endif; ?>"
                data-por-vencer="<?php if($cantidad_documentos_por_vencer>0): echo '1'; else: echo '0'; endif; ?>"
                class="<?php if($documentos_vencidos_por_vehiculos>0): echo 'danger'; else: echo 'default'; endif; ?>">
                <td>{{$vehiculo->razonsocial}}</td>
                <td>{{$vehiculo->placa}}</td>
                <td>{{$vehiculo->clase}}</td>
                <td>{{$vehiculo->marca}}</td>
                <td>{{$vehiculo->modelo}}</td>
                <td>{{$vehiculo->ano}}</td>
                <td>{{$vehiculo->capacidad}}</td>
                <td>{{$vehiculo->propietario}}</td>
                <td>{{$vehiculo->empresa_afiliada}}</td>
                <td>{{$vehiculo->tarjeta_operacion}}</td>
                <td>
                    <a href="{{url('proveedores/vehiculos/'.$vehiculo->proveedor_id)}}" class="btn-list-table btn btn-primary">DOCUMENTACION</a>
                    <a data-id-vehiculo="{{$vehiculo->vehiculo_id}}" data-bloqueo="@if($vehiculo->bloqueado!=null){{1}} @else{{0}} @endif" class="bloqueo_vehiculos btn btn-warning btn-list-table">@if($vehiculo->bloqueado===null or intval($vehiculo->bloqueado)===0){{'BLOQUEAR'}}@else{{'DESBLOQUEAR'}}@endif</a>
                    <a  <?php
                         if($tarjeta_operacion<=30){
                             echo 'data-tarjeta-operacion="'.$tarjeta_operacion.'"';
                         }
                         if($mantenimiento_preventivo<=30){
                             echo 'data-mantenimiento-preventivo="'.$mantenimiento_preventivo.'"';
                         }
                         if($soat<=30){
                             echo 'data-soat="'.$soat.'"';
                         }
                         if($tecnomecanica<=30){
                             echo 'data-tecnomecanica="'.$tecnomecanica.'"';
                         }
                         if($poliza_extracontractual<=30){
                             echo 'data-poliza-extracontractual="'.$poliza_extracontractual.'"';
                         }
                         if($poliza_contractual<=30){
                             echo 'data-poliza-contractual="'.$poliza_contractual.'"';
                         }

                       ?>
                        class="btn btn-<?php if($documentos_vencidos_por_vehiculos>0): echo 'danger'; else: echo 'default'; endif ?> btn-list-table mostrar_alertas" style="padding: 6px 6px;" data-toggle="modal" data-target=".mdl_alertas" data-vehiculo-id="{{$vehiculo->vehiculo_id}}">
                        <i class="fa fa-envelope-o">
                            <span style="padding: 0 4px;" class="badge"><?php echo $documentos_vencidos_por_vehiculos; ?></span>
                        </i>
                    </a>
                    <a href="{{url('hvvehiculos/hvvehiculos/'.$vehiculo->vehiculo_id)}}" class="btn btn-default btn-icon">HOJA DE VIDA <i class="fa fa-car icon-btn"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a id="mostrar_por_vencer" style="margin-top: 5px" class="btn btn-default btn-icon">POR VENCER <i class="fa fa-filter icon-btn"></i></a>
    <a id="mostrar_vencidos" style="margin-top: 5px" class="btn btn-default btn-icon">VENCIDOS <i class="fa fa-ban icon-btn"></i></a>
    <a id="mostrar_todos" style="margin-top: 5px" class="btn btn-default btn-icon">TODOS <i class="fa fa-car icon-btn" aria-hidden="true"></i></a>

</div>

<div class="ventana_modal">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>ALERTAS DE DOCUMENTACION</strong>
                <i style="cursor: pointer; float: right; font-weight:100" class="fa fa-close cerrar_ventana"></i>
            </div>
            <div class="panel-body">
                Hay un total de <strong><?php echo $documentos_vehiculos_vencidos; ?></strong> vehiculos con documentos vencidos!<br>
                Hay un total de <strong><?php echo $documentos_vehiculos_por_vencer; ?></strong> vehiculos con documentos prontos a vencer!<br>

                <br>Hay un total de <strong>{{$cont_vehiculos_sin_prog_mtn}}</strong> Vehiculos sin hacer la Programacion de Mantenimiento!
				<br>Hay un total de <strong>{{$cont_vehiculo_sin_1rev}}</strong> Vehiculos Sin hacer la primera Programacion de Mantenimiento!
            </div>
        </div>
    </div>
</div>

<div class="ventana_modal hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Documentos vencidos
                <i id="cerrar_alerta_sino" style="cursor: pointer; float: right; font-weight:100" class="fa fa-close"></i>
            </div>
            <div class="panel-body">
                <label>Desea activar la reconfirmacion?</label><br>

            </div>
        </div>
    </div>
</div>

<div class="modal fade mdl_alertas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-medium">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>ALERTAS</strong>
            </div>
            <div class="modal-body">
                <div id="alertas_vigencia">

                </div>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
            </div>
        </div>
    </div>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/vehiculos.js')}}"></script>
<script>
    $('.ventana_modal')
        .animate({
            opacity: 1,
        },1500);
</script>

</body>
</html>
