<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Solicitud Actual</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <style type="text/css">
        .last_value{
            text-align: center; 
            font-family: Bahnschrift; 
            font-size: 13px
        }
        .usuario1{
            float: right;
        }

        .usuario2{
            float: left;
        }
    </style>
</head>
<body>
    @include('admin.menu')
    <div class="col-lg-12">
        
        @if($control!=null)
            <h3 class="h_titulo">ESTADO DE LA SOLICITUD ACTUAL</h3>
            <h5 id="{{$cuenta_id}}{{$cuenta_id}}{{$cuenta_id}}" style="float: left; margin-top: 2px; margin-bottom: 15px">@if($estado==0){{'<span style="background: red; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px; margin-top: 15px; margin-bottom: 15px"><b>PENDIENTE DE APROBACIÓN</b></span>'}}@elseif($estado==1){{'<span style="background: gray; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>TIENES UNA CORRECCIÓN POR REVISAR</b></span>'}}@elseif($estado==2){{'<span style="background: orange; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>RESPUESTA DE CORRECCIÓN ENVIADA</b></span>'}}@elseif($estado==3)<span style="background: green; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>RADICADA CON N° <?php echo '0000'.$cuenta_id ?></b></span>@endif</h5>
            <!-- SI NO HAY NINGUNA CUENTA DE COBRO, NO SE EJECUTA ESTE CÓDIGO -->
            <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
                <thead>
                <tr>
                    <td>#</td>
                    <td>RUTA</td>
                    <td>RECOGER EN</td>
                    <td>DEJAR EN</td>
                    <td>FECHA</td>
                    <td>HORA</td>
                    <td>CLIENTE / SITE</td>
                    <td>PROVEEDOR / CONDUCTOR</td>
                    <td>ESTADO</td>
                    <td>VALOR</td>
                    <td>ACCIÓN</td>
                    <td>MSJ</td>
                </tr>
                </thead>
                <tbody>
                	<?php $i=1; $total=0; $total2 = 0; $nombre_anterior = ''; $cor = 0;?>
                @foreach($rutas_programadas as $ruta)
                        @if($nombre_anterior!=$ruta->razoncentro)
                            <tr class="warning">
                                <td colspan="11">{{$ruta->razoncentro}}</td>
                            </tr>
                        @endif
                    <tr @if($ruta->total_pagado!=null){{'class="success"'}}@endif >
                        <td data-id="{{$ruta->id}}">
                            <?php echo $i ?>
                        </td>
                       
                        <td>
                        	<span>{{$ruta->detalle_recorrido}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->recoger_en}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->dejar_en}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->fecha_servicio}}</span>                        
                        </td>
                        <td>
                        	<span>{{$ruta->hora_servicio}}</span>
                        </td>
                        <td>
                            <a href>{{$ruta->razoncentro}}</a><br>
                            <a href>{{$ruta->nombresubcentro}}</a>
                        </td>
                        <td>
                            <a href>{{$ruta->razonsocial}}</a><br>
                            <a href title="{{$ruta->clase.'/'.$ruta->marca.'/'.$ruta->placa}}">{{$ruta->nombre_completo}}</a>
                        </td>
                        <td>
                          <?php
                              $reconfirmacion = DB::table('reconfirmacion')->where('id_servicio',$ruta->id)->pluck('ejecutado');
                              if ($reconfirmacion===1) {
                                  echo '<small class="text-info">EJECUTADO</small>';
                              }else{
                                  echo '<small class="text-success">PROGRAMADO</small>';
                              }
                           ?>
                        </td>
                        <td>
                        	@if($ruta->total_pagado!=null)
                        		<?php $total = $total+$ruta->total_pagado; $t?>

                                <!-- NUEVA -->
                                @if($estado===0)
                                    @if($ruta->unitario_pagado_correccion!=null and $ruta->aceptado_liquidado!=1)
                                        <!-- CUANDO EL PROVEEDOR ACEPTA LA CORRECCIÓN -->
                                        <span class="last_value">Solicitud: <?php echo number_format($ruta->unitario_pagado_correccion) ?></span><br>

                                        <span class="last_value">Valor Liquidado <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i></span>
                                    @elseif($ruta->unitario_pagado_correccion!=null and $ruta->aceptado_liquidado==1)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Valor liquidado: <?php echo number_format($ruta->unitario_pagado_correccion) ?></span><br>

                                        <span class="last_value">Valor Corregido <i class="fa fa-check" style="color: green" aria-hidden="true"></i></span>
                                    @endif
                                   
                                @elseif($estado===1)
                                
                                    
                                    @if($ruta->aceptado_liquidado===null and $estado===1)
                                        <!-- CUANDO EL PROVEEDOR ACEPTA LA CORRECCIÓN -->
                                        <span class="last_value">Valor Corregido: <?php echo number_format($ruta->unitario_pagado_correccion) ?></span><br>

                                        <span class="last_value">Valor que cobré <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i></span>
                                        <?php $cor = 1; ?>
                                    @elseif($ruta->unitario_pagado_correccion!=null and $ruta->aceptado_liquidado==1)
                                        <!-- CUANDO SE APROBÓ UN SERVICIO -->
                                        <span class="last_value" >Valor Anterior: <?php echo number_format($ruta->unitario_pagado_correccion) ?></span><br>

                                        <span class="last_value">Valor Corregido <i class="fa fa-check" style="color: green" aria-hidden="true"></i></span>
                                    @endif

                                @elseif($estado===2)

                                    @if($ruta->aceptado_liquidado===1 and $ruta->unitario_pagado_correccion!=null)
                                        <!-- CUANDO EL PROVEEDOR ACEPTA LA CORRECCIÓN -->
                                        <span class="last_value">Valor Anterior: <?php echo number_format($ruta->unitario_pagado_correccion) ?></span><br>

                                        <span class="last_value">Valor Corregido <i class="fa fa-check" style="color: green" aria-hidden="true"></i></span>
                                    
                                    @endif
                                @endif
                                <!-- NUEVA -->

                               

                        		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor" value="{{$ruta->total_pagado}}">

                                <!--<button type="submit" style="margin-bottom: 5px; margin-top: 5px;" class="btn btn-warning">VER<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>-->

                            <div class="alert_planilla"></div>
                        	@else
                        		<input type="text" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor">
                            <div class="alert_planilla"></div>
                        	@endif                        
                        </td>
                        <td>
                            <!-- BOTÓN OK -->
                            @if($ruta->aceptado_liquidado===null and $estado===1)
                                <a title="Aceptar el nuevo valor." id="aceptar_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-primary aceptar_correccion"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                            @else
                                <a id="aceptar_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-primary aceptar_correccion disabled"><i class="fa fa-check-circle" aria-hidden="true"></i></a>
                            @endif

                            <!-- BOTÓN NO -->
                            @if($ruta->aceptado_liquidado===null and $estado===1)
                                <a title="Mantener el valor cobrado inicialmente." id="no_aceptar_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-danger no_aceptar_correccion"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                            @else
                                <a id="no_aceptar_correccion" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" nombre="" class="btn btn-danger no_aceptar_correccion disabled"><i class="fa fa-times" aria-hidden="true"></i></a>
                            @endif
                        </td>
                        <td>
                            @if($ruta->conversacion!=null)
                                <a id="ver_motivo" option="2" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$cuenta_id}}" class="btn btn-info ver_motivo"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            @endif
                        </td>
                    </tr>
                    <?php $i++; $nombre_anterior = $ruta->razoncentro?>
                @endforeach
                </tbody>
            </table>

            <!-- REALIZAR ENLACES DE AP CON PAGO_PROVEEDORES EN LA APROBACIÓN DE LOS VALORES -->
            <div class="col-lg-12">        
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px;">
                              <div class="panel-heading">
                                <strong>TOTALES</strong>
                                @if($estado!=3)
                                    <i class="fa fa-clock-o icon-btn" style="margin-left: 25px"></i>
                                @else
                                    <i class="fa fa-clock-o icon-btn" style="margin-left: 25px"></i>
                                @endif
                              </div>
                              <div class="panel-body" style="margin-bottom: 40px">
                                    <table style="margin-bottom: 0px;" class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                @if($total!=0)
                                                    <td>TOTAL GENERADO</td>
                                                    <td>
                                                        <span class="span-total" id="valor_total"><?php echo '$ '. number_format($total)?></span>
                                                    </td>
                                                @else
                                                    <td>TOTAL A COBRAR</td>
                                                    <td>
                                                        <span class="span-total" id="valor_total">$ 0</span>
                                                    </td>
                                                @endif
                                            </tr>
                                            @if($estado!=3)
                                                <tr style="margin-top: 25px">
                                                    @if($total!=0)
                                                        <td>TOTAL CON LAS CORRECCIONES</td>
                                                        <td><span class="span-total" id="valor_total"><?php echo '$ '. number_format($total2)?></span></td>
                                                    @endif
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5 col-xs-offset-3" style="margin-bottom:10px;">
                        <div class="row" style="float: right;">
                            
                            <a style="float: right;" data-cuenta="{{$cuenta_id}}" id="enviar_correccion_ok" centrodecosto="" class="@if($estado==1 and $cor==0){{'btn btn-success btn-icon input-font'}}@else{{'btn btn-success btn-icon input-font disabled'}}@endif">Enviar<i class="fa fa-check icon-btn" style="margin-left: 25px"></i></a>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <h1>¡NO TIENES SOLICITUDES EN ESTE MOMENTO!</h1>
        @endif

        <!-- REALIZAR LOS CONTROLES PARA APROBAR LAS CUENTAS DE COBRO Y GENERACIÓN DE LAERTAS -->
    </div>

    <!-- MODAL CONVERSACIÓN -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_conversacion'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: gray">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row conversacion">
                    
                </div>
            </div>
        </div>
      </div>
    </div>
    @include('otros.pushercontabilidad')

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/portalproveedores.js')}}"></script>
    <script>
        $('table a').click(function (e) {
            e.preventDefault();
        });
    </script>
</body>
</html>
