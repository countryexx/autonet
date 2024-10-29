<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Servicios por Eliminar</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body onload="nobackbutton();">
@include('admin.menu')

<div class="col-lg-12">
    <h3 class="h_titulo">SERVICIOS PENDIENTES POR ELIMINAR</h3>

    @if(isset($servicios))
        <table id="servicios_eliminacion" class="table table-bordered hover tabla" cellspacing="0" width="100%">
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
                        @if($permisos->barranquilla->poreliminarbq->rechazar==='on')
                            <a id="{{$servicio->id}}" style="padding: 5px 6px; margin-bottom: 3px" class="btn btn-success rechazar_eliminacion"><i class="fa fa-arrow-right" aria-hidden="true" title="Rechazar Eliminacion"></i></a>
                        @else
                            <a style="padding: 5px 6px; margin-bottom: 3px" class="btn btn-success rechazar_eliminacion disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        @endif

                        @if($permisos->barranquilla->poreliminarbq->eliminar==='on')
                            <a id="{{$servicio->id}}" style="padding: 5px 7px;" class="btn btn-danger eliminar_servicio" title="Eliminar Servicio"><i class="fa fa-close"></i></a>
                        @else
                            <a style="padding: 5px 7px;" class="btn btn-danger eliminar_servicio disabled"><i class="fa fa-close"></i></a>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 10px" class="text-info">MOTIVO ELIMINACION:</span><br><span style="font-size: 10px" class="bolder text-info">{{$servicio->motivo_eliminacion}}</span><br>
                        <span style="font-size: 10px" class="text-success">FECHA DE SOLICITUD:</span><br><span style="font-size: 10px" class="bolder text-success">{{$servicio->fecha_solicitud_eliminacion}}</span><br>
                        <span style="font-size: 10px" class="text-warning">USUARIO:</span><br><span style="font-size: 10px" class="bolder text-warning">{{$servicio->first_name_elim.' '.$servicio->last_name_elim}}</span><br>

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
                        </a>
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

<div id="alert_eliminar" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar <i id="cerrar_alerta_sino" style="float: right; cursor: pointer" class="fa fa-close"></i></div>
            <div class="panel-body">
                <label></label><br>
                <a id="respuesta_si" class="btn-default btn">Si</a>
                <a id="respuesta_no" class="btn-default btn">No</a>
            </div>
        </div>
    </div>
</div>

<div id="motivo_eliminacion" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Escriba las razones por las cuales no va a ser eliminado este servicio.</label>
                    <textarea id="descripcion_eliminacion" cols="30" rows="10" class="form-control input-font"></textarea>
                </div>
                <a id="realizar" class="btn btn-primary btn-icon">Realizar<i class="fa fa-trash icon-btn"></i></a>
                <a id="cancelar" class="btn btn-danger btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
            </div>
        </div>

    </div>
</div>


@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/servicios_eliminacion.js')}}"></script>
<!--@if(Sentry::getUser()->reconfirmador===1)
    <script>
    function reconFirmacion(){

        var h = new Date();
        var hora = h.getHours();
        var minutos = h.getMinutes().toString();
        var tamaño = minutos.length;
        if (tamaño.length===1) {
            minutos = "0"+minutos;
        }

        var horaactuala = hora+':'+minutos;
        $.ajax({
            method: 'post',
            url: 'transportes/reconfirmar',
            data: {'id':1},
            dataType: 'json',
            success: function (data) {
                var contador = 0;
                $('#example tbody tr').each(function(i){
                    $(this).removeClass('table-background-reconfirmacion');
                    $(this).find('.hora_reconfirmacion').addClass('hidden');

                });
                for(i in data.servicios) {
                    id=0;
                    horareal = data.servicios[i].hora_servicio;
                    horaactual = moment(horareal,'H:m');
                    hora_cita = horaactual.subtract(15, 'minutes').format('H:m');
                    var a = new Date("February 12, 2014 "+hora_cita+":00");
                    var b = new Date("February 12, 2014 "+horaactuala+":00");
                    var c = (a-b)/1000;
                    cantidad_minutos = parseInt(c/60);
                    console.log(cantidad_minutos);

                    if (cantidad_minutos>=85 && cantidad_minutos<=105) {
                        if (data.servicios[i].reconfirmacion2hrs===null) {
                            contador++;
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    $(this).addClass('table-background-reconfirmacion');
                                    $(this).find('.hora_reconfirmacion').removeClass('hidden').html('<small>2 HORAS</small>');
                                }
                            });
                        }else if(data.servicios[i].reconfirmacion2hrs!=null){
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    if($(this).hasClass('table-background-reconfirmacion')){
                                        $(this).removeClass('table-background-reconfirmacion');
                                    }
                                    if (!($(this).find('.hora_reconfirmacion').hasClass('hidden'))) {
                                        $(this).find('.hora_reconfirmacion').addClass('hidden');
                                    }
                                }
                            });
                        }
                    }
                    if (cantidad_minutos>=25 && cantidad_minutos<=45) {
                        if (data.servicios[i].reconfirmacion1hrs===null) {
                            contador++;
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    $(this).addClass('table-background-reconfirmacion');
                                    $(this).find('.hora_reconfirmacion').removeClass('hidden').html('<small>1 HORA</small>');
                                }
                            });
                        }else if(data.servicios[i].reconfirmacion1hrs!=null){
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    if($(this).hasClass('table-background-reconfirmacion')){
                                        $(this).removeClass('table-background-reconfirmacion');
                                    }
                                    if (!($(this).find('.hora_reconfirmacion').hasClass('hidden'))) {
                                        $(this).find('.hora_reconfirmacion').addClass('hidden');
                                    }
                                }
                            });
                        }
                    }
                    if (cantidad_minutos>=-5 && cantidad_minutos<=15) {
                        if (data.servicios[i].reconfirmacion30min===null) {
                            contador++;
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    $(this).addClass('table-background-reconfirmacion');
                                    $(this).find('.hora_reconfirmacion').removeClass('hidden').html('<small>30 MIN</small>');
                                }
                            });
                        }else if(data.servicios[i].reconfirmacion30min!=null){
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    if($(this).hasClass('table-background-reconfirmacion')){
                                        $(this).removeClass('table-background-reconfirmacion');
                                    }
                                    if (!($(this).find('.hora_reconfirmacion').hasClass('hidden'))) {
                                        $(this).find('.hora_reconfirmacion').addClass('hidden');
                                    }
                                }
                            });
                        }
                    }
                    if (cantidad_minutos>=-20 && cantidad_minutos<=0) {
                        if (data.servicios[i].reconfirmacion_horacita===null) {
                            contador++;
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    $(this).addClass('table-background-reconfirmacion');
                                    $(this).find('.hora_reconfirmacion').removeClass('hidden').html('<small>HORA CITA</small>');
                                }
                            });
                        }else if(data.servicios[i].reconfirmacion_horacita!=null){
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    if($(this).hasClass('table-background-reconfirmacion')){
                                        $(this).removeClass('table-background-reconfirmacion');
                                    }
                                    if (!($(this).find('.hora_reconfirmacion').hasClass('hidden'))) {
                                        $(this).find('.hora_reconfirmacion').addClass('hidden');
                                    }
                                }
                            });
                        }

                    }
                    if (cantidad_minutos<-35) {
                        if (data.servicios[i].reconfirmacion_ejecucion===null) {
                            contador++;
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    $(this).addClass('table-background-reconfirmacion');
                                    $(this).find('.hora_reconfirmacion').removeClass('hidden').html('<small>HORA EJECUCION</small>');
                                }
                            });
                        }else if(data.servicios[i].reconfirmacion_ejecucion!=null){
                            id = parseInt(data.servicios[i].id);
                            $('#example tbody tr').each(function(i){
                                id_compare = parseInt($(this).attr('id'));
                                if (id_compare===id) {
                                    if($(this).hasClass('table-background-reconfirmacion')){
                                        $(this).removeClass('table-background-reconfirmacion');
                                    }
                                    if (!($(this).find('.hora_reconfirmacion').hasClass('hidden'))) {
                                        $(this).find('.hora_reconfirmacion').addClass('hidden');
                                    }
                                }
                            });
                        }
                    }
                }

                if (contador!=0) {
                    alert('Tienes '+contador+' servicios por reconfirmar');
                }
            }
        });
    }
    function recargar(){
        location.reload();
    }
    setInterval(reconFirmacion,5000);
    setInterval(recargar, 30000);
    </script>
@endif-->
@if(Sentry::getUser()->coordinador===1)
        <script>
            $('#modal-activar-reconfirmacion')
                .animate({
                  opacity: 1,
            },2000);
        </script>
        @endif
            <script>
                $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
</script>
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
