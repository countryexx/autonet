<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Servicios Editados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body onload="nobackbutton();">
@include('admin.menu')

<div class="col-lg-12">

    <h3 class="h_titulo">SERVICIOS EDITADOS</h3>

    @if(isset($servicios))
        <table id="servicios_editados" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>Codigo</th>
                <th>Solicitante/Fecha</th>
                <th>Ruta</th>
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
                <th>Ruta</th>
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
                <th>Estado</th>
                <th></th>
                <th>Historial</th>
            </tr>
            </tfoot>
            <tbody>

            @foreach($servicios as $servicio)
                <tr id="{{$servicio->id}}" class="@if(intval($servicio->resaltar)===1){{'resaltar'}}@endif">
                    <td>{{$o++}}</td>
                    <td>{{$servicio->id}}</td>
                    <td>{{$servicio->solicitado_por.'<br>'.$servicio->fecha_solicitud}}</td>
                    <td><a title="{{$servicio->nombre_ruta}}" href>{{$servicio->codigo_ruta}}</a></td>
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

                                    if ($j===2) {
                                        $nivel = $pasajeros[$i][$j];

                                    }

                                    if ($j===3) {
                                        $email = $pasajeros[$i][$j];
                                    }

                                }
                                echo '<a>'.$nombre.'</a><br>';

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

                                    if ($j===2) {
                                        $nivel = $pasajeros[$i][$j];

                                    }

                                    if ($j===3) {
                                        $email = $pasajeros[$i][$j];
                                    }

                                }
                                echo '<a>'.$nombre.'</a><br>';

                            }

                        }

                        ?>
                    </td>
                    <td>
                        <a href title="{{$servicio->placa.'/'.$servicio->clase.'/'.$servicio->marca.'/'.$servicio->modelo}}">{{$servicio->razonproveedor}}</a><hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
                        <a href title="{{$servicio->celular.'-'.$servicio->telefono}}">{{$servicio->nombre_completo}}</a>
                    </td>
                    <td>Hora cita:<br> {{date('H:i',strtotime('-15 minute',strtotime($servicio->hora_servicio)))}}<br> Hora real:<br> {{$servicio->hora_servicio}}</td>
                    <td>@if(($servicio->razonsocial===$servicio->nombresubcentro)){{$servicio->razonsocial}} @else {{$servicio->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$servicio->nombresubcentro}}@endif</td>
                    <td>{{$servicio->first_name.' '.$servicio->last_name}}</td>
                    <td>
                        <?php

                        $novedades = DB::table('novedades_reconfirmacion')->where('id_reconfirmacion',$servicio->id)->get();

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
                                echo '<small style="color: #EC0000">SIN FACTURAR</small><br>';
                            }
                        }

                        if ($servicio->id_pivote!=null) {
                            echo '<small class="text-primary">EDITADO</small><br>';
                        }

                        if ($novedades!=null) {
                            echo '<small class="text-danger">NOVEDAD</small><br>';
                        }

                        if ($servicio->id_reporte!=null) {
                            echo '<small class="text-warning">REPORTE</small><br>';
                        }

                        if (intval($servicio->pago_directo)===1) {
                            echo '<small class="bolder">PAGO DIRECTO</small>';
                        }

                        if (intval($servicio->finalizado)===1) {
                            echo '<small class="text-success bolder">FINALIZADO</small>';
                        }
                        ?>
                    </td>
                    <td class="opciones text-center">

                        @if($permisos->bogota->poreliminar->rechazar==='on')
                            <a id="{{$servicio->id}}" id-edit="{{$servicio->id_edit}}" style="padding: 5px 6px; margin-bottom: 3px" class="btn btn-success autorizar_cambios" title="Autorizar Cambios"><i class="glyphicon glyphicon-transfer" aria-hidden="true"></i></a>
                        @else
                            <a style="padding: 5px 6px; margin-bottom: 3px" class="btn btn-success disabled" title="Autorizar Cambios"><i class="glyphicon glyphicon-transfer" aria-hidden="true"></i></a>
                        @endif

                        @if($permisos->bogota->poreliminar->eliminar==='on')
                            <a id="{{$servicio->id}}" id-edit="{{$servicio->id_edit}}" style="padding: 5px 7px;" class="btn btn-danger anular_cambios" title="Rechazar Cambios"><i class="fa fa-close"></i></a>
                        @else
                            <a style="padding: 5px 7px;" class="btn btn-danger disabled" title="Rechazar Cambios"><i class="fa fa-close"></i></a>
                        @endif
                    </td>
                    <td>
						<a class="btn btn-default @if($servicio->cancelado===1)disabled @endif input-font" href="{{url('transportes/reconfirmacion/'.$servicio->id)}}">
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
                        </a><br>
						<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">
						<br><span style="font-size: 10px; cursor: pointer" class="bolder text-info" data-toggle="modal" data-target=".mymodaladcambios" info-det="{{$servicio->cambios}}" title="{{$servicio->cambios}}" id="modal_cambios">CAMBIOS:</span><br>
						<!--<span style="font-size: 10px" class="text-info">{{$servicio->cambios}}</span><br>-->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>


<div class="modal fade mymodaladcambios" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h5 class="modal-title">Cambios Solicitados</h5>
			</div>
			<div class="modal-body" >
				<div id="info_cambios">




				</div>
			</div>
			<div class="modal-footer" >

			</div>
		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/servicios_eliminacion.js')}}"></script>

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
</script>
</body>
</html>
