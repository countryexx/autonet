<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Revisión Cuenta de Cobro</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">

    <style type="text/css">
        .usuario1{
            float: left;
        }

        .usuario2{
            float: right;
        }
    </style>
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<h3 class="h_titulo">CUENTA DE COBRO {{$proveedor}}</h3>
		</div>
		<div class="col-md-3 col-md-offset-5">
			<h5 style="float: right; margin-top: 20px; margin-bottom: 20px">ESTADO: @if($estado_cuenta==0){{'<span style="background: red; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px; margin-top: 15px; margin-bottom: 15px"><b>PENDIENTE POR REVISAR</b></span>'}}@elseif($estado_cuenta==1){{'<span style="background: gray; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>CORRECCIÓN ENVIADA AL PROV</b></span>'}}@elseif($estado_cuenta==2){{'<span style="background: orange; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>CORRECCIÓN RESPONDIDA</b></span>'}}@elseif($estado_cuenta==3)<span style="background: green; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px;"><b>RADICADA CON N° <?php echo '0000'.$id ?></b></span>@endif</h5>
		</div>
	</div>
	<div class="row">
		
	</div>
    
    @if(isset($cuenta))
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
                <td>VALOR</td>
                <td>APROBAR</td>
                <td>CORREGIR</td>
                <td>MSJ</td>
            </tr>
            </thead>
            <tbody>
            	<?php $i=1; $total=0; $total2 = 0; $nombre_anterior= ''; $cor = 0; $cor2 = 0; $count_aprobar = 0;?>
            @foreach($cuenta as $ruta)                
                    
                @if($ruta->razoncentro!=$nombre_anterior)
                	<tr class="danger">
                		<td colspan="12"><span>{{$ruta->razoncentro}}</span></td>
                	</tr>
                @endif
                <tr data-id="{{$ruta->servicio_id}}" @if($ruta->total_pagado!=null){{'class="warning"'}}@endif >

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
                        {{$ruta->nombre_completo}}
                    </td>
                    <td>
                    	@if($ruta->total_pagado!=null)
                    		<?php $total = $total+$ruta->total_pagado; ?>

                            @if($ruta->estado_correccion===0 and ($estado_cuenta==0 or $estado_cuenta==1))
                                <span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Corrección: <?php echo number_format($ruta->unitario_pagado_correccion); ?>
                                    </span>
                                <?php $total2 = $total2+$ruta->unitario_pagado_correccion;?>

                    		@elseif($ruta->estado_correccion==1 and ($estado_cuenta==0 or $estado_cuenta==1))
                    			<span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Corrección: <?php echo $ruta->unitario_pagado_correccion; ?></span>
                    			<?php $total2 = $total2+$ruta->unitario_pagado_correccion;?>
                    		@elseif($ruta->estado_correccion==2 and $ruta->aceptado_liquidado==1)
                                <span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Valor Anterior: <?php echo '$ '.number_format($ruta->unitario_pagado_correccion); ?></span>
                                <br>
                                <span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Corrección <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i></span>
                                <?php  $total2 = $total2+$ruta->unitario_pagado_correccion;?>
                            @elseif($ruta->estado_correccion==2 and $ruta->aceptado_liquidado===null)
                    			<span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Valor Corregido: <?php echo '$ '.number_format($ruta->unitario_pagado_correccion); ?></span>
                    			<br>
                    			<span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">Valor Actual <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i></span>
                    			<?php $cor=1;  $total2 = $total2+$ruta->unitario_pagado_correccion;?>
                    		@elseif($ruta->estado_correccion==4)
                    			<span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">El proveedor no aprobó: <i style="color: red" class="fa fa-times" aria-hidden="true"></i> <?php echo '$ '.number_format($ruta->unitario_pagado_correccion); ?></span>
                    			<br>
                    			<span class="last_value" style="text-align: center; font-family: Bahnschrift; font-size: 13px">El proveedor Cobró: <i class="fa fa-arrow-down" style="color: green" aria-hidden="true"></i></span>
                    			<?php $total2 = $total2+$ruta->unitario_pagado_correccion;?>
                    		@else
                    			<span class="last_value"></span>
                    			<?php $total2 = $total2+$ruta->total_pagado; ?>
                    		@endif
                    		
                    		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor" value="{{$ruta->total_pagado}}" data-original="{{$ruta->total_pagado}}" data-id="{{$ruta->servicio_id}}">
                        <div class="alert_planilla"></div>
                    	@else
                    		<input type="text" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor">
                        <div class="alert_planilla"></div>
                    	@endif                        
                    </td>
                    <td style="text-align: center;">
                        @if($ruta->estado_correccion===0)
                    	   <a id="ver_detalles" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$id}}" class="btn btn-success aprob"><i class="fa fa-check" aria-hidden="true"></i></a>
                           <?php $cor2 = 1; ?>
                        @else
                            <a id="ver_detalles" data-id="{{$ruta->servicio_id}}" class="btn btn-danger disabled"><i class="fa fa-check" aria-hidden="true"></i></a>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($ruta->aceptado_liquidado===1)
                            <i class="fa fa-check al" aria-hidden="true" style="font-size: 18px; color: green"></i>                            
                        @else
                            <?php $count_aprobar= 1; ?>
                            <i class="fa fa-check al hidden" aria-hidden="true" style="font-size: 18px; color: green"></i>

                            <input type="checkbox" class="corregir" name="" data-id="{{$ruta->servicio_id}}" @if($estado_cuenta==3){{'disabled="true"'}}@endif>                     

                            <a id="ver_detalles" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$id}}" nombre="{{$ruta->id}}" valor-servicio="{{$ruta->total_pagado}}" class="btn btn-list-table btn-danger back hidden"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

                            <a id="ver_detalles" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$id}}" nombre="{{$ruta->id}}" class="btn btn-list-table btn-success save hidden"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                        @endif                    	

                    </td>
                    <td>
                        @if($ruta->conversacion!=null)
                            <a id="ver_motivo" option="1" data-id="{{$ruta->servicio_id}}" data-cuenta="{{$id}}" class="btn btn-info ver_motivo"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        @endif
                    </td>
                </tr>
                <?php $i++; $nombre_anterior=$ruta->razoncentro; ?>
            @endforeach
            </tbody>
        </table>
        <!-- Acciones de botones -->
        <div class="col-lg-12" style="margin-bottom: 25px">
	    	<div class="row">
	    		<div class="col-lg-4">
				<div class="row">
					<div class="panel panel-default" style="margin-top: 20px; margin-bottom: 0px">
					  <div class="panel-heading">
					    <strong>TOTALES</strong>
					    @if($total!=0)
					    	<i class="fa fa-check icon-btn" style="margin-left: 25px"></i>
					    @else
					    	<i class="fa fa-clock-o icon-btn" style="margin-left: 25px"></i>
					    @endif
					  </div>
					  <div class="panel-body">
							<table style="margin-bottom: 0px;" class="table table-bordered">
								<tbody>
									<tr>
										@if($total!=0)
											<td>TOTAL COBRADO POR EL PROVEEDOR</td>
											<td><span class="span-total" id="valor_total"><?php echo $total?></span></td>
										@else
											<td>TOTAL A COBRAR POR EL PROVEEDOR</td>
											<td><span class="span-total" id="valor_total">$ 0</span></td>
										@endif
										
									</tr>
									@if($estado_cuenta!=3)
                                        <tr style="margin-top: 25px">
                                            @if($total!=0)
                                                <td>TOTAL COBRADO CON LAS CORRECCIONES</td>
                                                <td><span class="span-total" id="valor_total"><?php echo '$ '. number_format($total2)?></span></td>
                                            @endif
                                        </tr>
                                    @endif
								</tbody>
							</table>
							
							<button type="submit" style="margin-bottom: 20px; margin-top: 20px;" class="btn btn-warning btn-icon input-font">DESCARGAR CUENTA DE COBRO<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>
					  </div>
					</div>
				</div>
            </div> 
	    		<div class="col-xs-5 col-xs-offset-3" style="margin-bottom:10px;">
	                <div class="row" style="float: right;">                    
	                     
	                 	<a href="{{url('facturacion/cuentas')}}" class="btn btn-primary btn-icon input-font">Volver<i class="fa fa-reply icon-btn"></i></a>
	                 		
             			<a data-cuenta="{{$id}}" id="enviar_correccion" class="@if($cor===1 and $estado_cuenta!=1 and $cor2===0){{'btn btn-danger btn-icon input-font'}}@else{{'btn btn-danger btn-icon input-font disabled'}}@endif">Enviar Corección<i class="fa fa-times icon-btn"></i></a>

	                 	<!--<a id="habilitar_campos" class="btn btn-danger btn-icon input-font hidden">Habilitar Campos<i class="fa fa-pencil icon-btn"></i></a>-->

	                 	<a data-cuenta="{{$id}}" id="aceptar_cuenta_cobro" centrodecosto="" class="@if($count_aprobar==1 or $estado_cuenta===1 or $estado_cuenta===3){{'btn btn-success btn-icon input-font disabled'}}@else{{'btn btn-success btn-icon input-font'}}@endif">Aprobar<i class="fa fa-check icon-btn" style="margin-left: 25px"></i></a>

	                </div>
	            </div>
	    	</div>
	    </div>
	    <!-- Fin Acciones de botones -->
    @endif
</div>

<div id="motivo_eliminacion" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Confirmar</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Digite el motivo por el cual va a realizar modificación del valor liquidado.</label>
                    <textarea id="descripcion" cols="40" rows="10" class="form-control input-font"></textarea>
                </div>
                <a id="save2" class="btn btn-primary btn-icon">Realizar<i class="fa fa-check icon-btn"></i></a>
                <a id="cancelar2" class="btn btn-warning btn-icon">Cancelar<i class="fa fa-close icon-btn"></i></a>
            </div>
        </div>

    </div>
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

<div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    	<li>
    		test
    	</li>
    </ul>
</div>

@include('scripts.scripts')
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>

	Pusher.logToConsole = true;

  	//INICIO PUSHER APROBACIÓN DE CORRECCIÓN
  	var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    	cluster: 'us2',
	    forceTLS: true
  	});

  	var pusher2 = pusher2.subscribe('contabilidad');

  	pusher2.bind('bcuenta', function(data) {

    var proceso = parseInt(data.proceso);
    var cuenta_id = parseInt(data.cuenta_id);

    //var estado = '<h5 id="'+data.cuenta_id+''+data.cuenta_id+''+data.cuenta_id+'" style="float: left; margin-top: 2px; margin-bottom: 15px"><span style="background: red; color: white; font-size: 14px; padding: 6px 5px; width: 67px; border-radius: 2px; margin-top: 15px; margin-bottom: 15px"><b>PENDIENTE DE APROBACIÓN</b></span></h5>';
    
    location.reload();

    //var servicios_count = cantidad;
    //var ctx = document.getElementById(data.cuenta_id+data.cuenta_id+data.cuenta_id);
    //ctx.html('HOLA MUNDO!');
    //$('#'+data.cuenta_id+''+data.cuenta_id+''+data.cuenta_id+'').html('HOLA MUNDO!');

  });
  //FIN PUSHER SERVICIOS DE BOGOTÁ
</script>

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
