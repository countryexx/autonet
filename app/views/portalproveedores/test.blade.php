<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Mis Servicios</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
    <h3 class="h_titulo">MIS SERVICIOS</h3>
    @if(isset($rutas_programadas))
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

            </tr>
            </thead>
            <tbody>
            	<?php $i=1; $total=0;?>
            @foreach($rutas_programadas as $ruta)
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
                    		<?php $total = $total+$ruta->total_pagado; ?>
                    		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor" value="{{$ruta->total_pagado}}">
                        <div class="alert_planilla"></div>
                    	@else
                    		<input type="text" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor">
                        <div class="alert_planilla"></div>
                    	@endif                        
                    </td>
                </tr>
                <?php $i++;?>
            @endforeach
            </tbody>
        </table>
    @endif
    <div class="col-lg-12">
    	<div class="row">
    		<div class="col-xs-4" style="margin-bottom:10px;">
                <div class="row">                    
                     
                 	<a href="{{url('facturacion/revision')}}" class="btn btn-primary btn-icon input-font">Volver<i class="fa fa-reply icon-btn"></i></a>
                 	@if($total!=0)
                 		<a id="calcular" class="btn btn-warning btn-icon input-font disabled">Sumar<i class="fa fa-money icon-btn"></i></a>
                 	@else
                 		<a id="calcular" class="btn btn-warning btn-icon input-font">Sumar<i class="fa fa-money icon-btn"></i></a>
                 	@endif
                 	<a id="habilitar_campos" class="btn btn-danger btn-icon input-font hidden">Habilitar Campos<i class="fa fa-pencil icon-btn"></i></a>

                 	<a id="guardartotal" centrodecosto="{{$centrodecosto}}" class="btn btn-info btn-icon input-font disabled">Enviar<i class="fa fa-save icon-btn" style="margin-left: 25px"></i></a>

                </div>
            </div>
    	</div>
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
											<td>TOTAL COBRADO CON ESTE CLIENTE</td>
											<td><span class="span-total" id="valor_total"><?php echo '$ '. number_format($total)?></span></td>
										@else
											<td>TOTAL A COBRAR CON ESTE CLIENTE</td>
											<td><span class="span-total" id="valor_total">$ 0</span></td>
										@endif
										
									</tr>
								</tbody>
							</table>
					  </div>
					</div>
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
