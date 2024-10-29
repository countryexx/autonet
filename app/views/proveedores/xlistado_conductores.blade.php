<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de conductores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')

<div class="col-lg-12">

    <h3 class="h_titulo">LISTADO DE CONDUCTORES</h3>
    <table class="table table-bordered table-hover" id="listado_conductores">
    	<thead>
    		<tr>
    			<th>Proveedor</th>
    			<th>Nombre Completo</th>
    			<th>Edad</th>
    			<th>Cedula</th>
    			<th>Fecha Vinculacion</th>
    			<th>Tipo Licencia</th>
    			<th>Fecha Expedicion</th>
    			<th>Fecha Vigencia</th>
    			<th>S. Social</th>
    			<th>Informacion</th>
    		</tr>
    	</thead>
    	<tbody>

        <?php
          ##CANTIDAD DE DOCUMENTOS POR VENCER POR TODOS LOS CONDUCTORES
          $documentos_por_vencer = 0;

          $documentos_vencidos = 0;

          #CANTIDAD DE CONDUCTORES QUE NO TIENEN SEGURIDAD SOCIAL
          $contar_seguridad = 0;
        ?>

        @foreach($conductores as $conductor)

            @if($conductor->nombre_completo)

                <?php

                $i = 0;
                $seguridad_social = null;
                $estado_ssocial = null;

                ##CANTIDAD DE DOCUMENTOS VENCIDOS POR CONDUCTOR
                $documentos_vencidos_por_conductor = 0;

                ##CANTIDAD DE DOCUMENTOS POR VENCER POR CONDUCTOR
                $documentos_por_vencer_por_conductor = 0;

                $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);

                //SEGURIDAD SOCIAL POR CONDUCTOR POR AÑO Y MES
                $seguridad_social = DB::table('seguridad_social')
                        ->where('conductor_id',$conductor->conductor_id)
                        ->where('ano',intval(date('Y')))
                        ->where('mes',intval(date('m')))
                        ->pluck('mes');

                //DIA ACTUAL
                $fecha_actual = intval(date('d'));

                if ($seguridad_social===null && $fecha_actual>10){
                    $estado_ssocial = null;
                    $contar_seguridad++;
                }else{
                    $estado_ssocial = 1;
                }

                ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS VENCIDOS
                if ($licencia_conduccion<0){
                    $documentos_vencidos_por_conductor++;
                    $documentos_vencidos++;
                }

                ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS POR VENCER
                if (($licencia_conduccion>=0 && $licencia_conduccion<=30))
                {
                    $documentos_por_vencer++;
                    $documentos_por_vencer_por_conductor++;
                }

                ?>

                <tr data-seguridad="<?php if($estado_ssocial===null): echo '0'; else: echo '1'; endif; ?>"
                    data-vencido="<?php if($documentos_vencidos_por_conductor>0): echo '1'; else: echo '0'; endif; ?>"
                    data-por-vencer="<?php if($documentos_por_vencer_por_conductor>0): echo '1'; else: echo '0'; endif; ?>"
                    class="<?php if($documentos_vencidos_por_conductor>0): echo 'danger'; else: echo 'default'; endif; ?>">
                    <td>{{$conductor->razonsocial}}</td>
                    <td>{{$conductor->nombre_completo}}</td>
                    <td>{{$conductor->edad}}</td>
                    <td>{{$conductor->cc}}</td>
                    <td>{{$conductor->fecha_vinculacion}}</td>
                    <td>{{$conductor->tipodelicencia}}/{{$conductor->conductor_id}}</td>
                    <td>{{$conductor->fecha_licencia_expedicion}}</td>
                    <td>{{$conductor->fecha_licencia_vigencia}}</td>
                    <td style="text-align: center">
                        @if($estado_ssocial===1)
                            <i style="color: green; font-size: 15px" class="fa fa-check"></i>
                        @else
                            <i style="color: #d9534f; font-size: 15px" class="fa fa-close"></i>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-list-table btn-primary" href="{{url('proveedores/conductores/'.$conductor->proveedor_id)}}">DOCUMENTACION</a>
                        <a data-id-conductor="{{$conductor->conductor_id}}" data-bloqueo="@if($conductor->bloqueado!=null){{1}} @else{{0}} @endif" class="bloqueo_conductores btn btn-warning btn-list-table">@if($conductor->bloqueado===null or intval($conductor->bloqueado)===0){{'BLOQUEAR'}}@else{{'DESBLOQUEAR'}}@endif</a>
                        <a <?php

                           if($licencia_conduccion<=30){
                               echo 'data-licencia-conduccion="'.$licencia_conduccion.'"';
                           }

                        ?>
                           data-toggle="modal" data-target=".mdl_alertas" data-var="" class="btn btn-list-table btn-<?php if($documentos_vencidos_por_conductor>0): echo 'danger'; else: echo 'default'; endif ?> mostrar_alertas"><i class="fa fa-envelope-o">
                                <span style="padding: 0 4px;" class="badge"><?php echo $documentos_vencidos_por_conductor; ?></span>
                            </i></a>
                        <a data-id-conductor="{{$conductor->conductor_id}}" data-toggle="modal" data-target=".mdl_app_aotour" class="btn btn-list-table app_aotour" style="background: #f47321; color: white;">APP MOBILE</a>
                    </td>
                </tr>

            @endif

        @endforeach
    	</tbody>
    </table>
    <a id="mostrar_por_vencer" style="margin-top: 5px" class="btn btn-default btn-icon">POR VENCER <i class="fa fa-filter icon-btn"></i></a>
    <a id="mostrar_vencidos" style="margin-top: 5px" class="btn btn-default btn-icon">VENCIDOS <i class="fa fa-ban icon-btn"></i></a>
    <a id="mostrar_todos" style="margin-top: 5px" class="btn btn-default btn-icon">TODOS <i class="fa fa-car icon-btn" aria-hidden="true"></i></a>
    <a id="mostrar_seguridad" style="margin-top: 5px" class="btn btn-default btn-icon">SEGURIDAD SOCIAL <i class="fa fa-heart icon-btn" aria-hidden="true"></i></a>

</div>

<div class="ventana_modal">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>ALERTAS DE DOCUMENTACION</strong>
                <i style="cursor: pointer; float: right; font-weight:100" class="fa fa-close cerrar_ventana"></i>
            </div>
            <div class="panel-body">
                Hay un total de <strong><?php echo $documentos_vencidos; ?></strong> conductores con documentos vencidos!<br>
                Hay un total de <strong><?php echo $contar_seguridad; ?></strong> conductores que no cuentan con seguridad social este mes!<br>
                Hay un total de <strong><?php echo $documentos_por_vencer; ?></strong> conductores con documentos prontos a vencer!<br>
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

<div class="modal fade mdl_app_aotour" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-medium">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <strong>USUARIO AOTOUR MOBILE</strong>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary btn-icon hidden" id="actualizar_datos_app">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></a>
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
<script src="{{url('jquery/conductores.js')}}"></script>

</body>
</html>
