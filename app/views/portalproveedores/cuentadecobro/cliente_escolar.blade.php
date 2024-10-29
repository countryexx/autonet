<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Rutas escolares por cobrar</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <style type="text/css">
        button {
              padding: 10px;
              color: #FFF;
              background-color: red;
              font-size: 15px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;

              border: 1px solid #3ac162;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
              float: right;
            }
    </style>
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
    @if($cuenta_enviada!=0)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                        <h1>NO DISPONIBLE</h1>
                        <?php $class = '' ?>
                        @if($cuenta_enviada===0)

                            <p>Actualmente usted tiene una cuenta de cobro en proceso de aprobación</p>

                        @elseif($cuenta_enviada===1)

                            <p>Actualmente usted tiene una cuenta de cobro en proceso de corrección</p>

                        @elseif($cuenta_enviada===2)

                            <p>Actualmente usted tiene una cuenta de cobro en proceso corrección respondida</p>

                        @elseif($cuenta_enviada===3)

                            <p>Su cuenta de cobro correspondiente al periodo actual ya fue aprobada. <i class="fa fa-check" style="color: green" aria-hidden="true"></i></p>
                            <?php $class = 'hidden' ?>
                        @endif
                        <p><a href="{{url('portalproveedores/solicitudactual')}}" title="Ir a la cuenta de cobro en proceso." id="go" data-id="" data-cuenta="" nombre="" class="btn btn-primary <?php echo $class ?>">VER CUENTA... <i class="fa fa-eye" aria-hidden="true"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
    @elseif($cuenta_activa!=0)
      @if($rutas_programadas!=null)
        <h3 class="h_titulo">RUTAS ESCOLARES REALIZADAS EN {{$mes_actual}} AL {{$mes_atras}}</h3>
            <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
                <thead>
                <tr style="background: gray; color: white">
                    <td>#</td>
                    <td>PASAJERO / RUTA</td>
                    <td>DESDE</td>
                    <td>HASTA</td>
                    <td>FECHA</td>
                    <td>HORA</td>
                    <td>CONDUCTOR</td>
                    <td>VALOR</td>
                    <td>OPCIONES</td>

                </tr>
                </thead>
                <tbody>
                	<?php $i=1; $total=0; $nombre_anterior = '';?>
                @foreach($rutas_programadas as $ruta)

                    @if($nombre_anterior!=$ruta->razoncentro)
                        <tr>
                            <td colspan="11">{{$ruta->razoncentro}}</td>
                        </tr>
                    @endif

                    <tr data-id="{{$ruta->id}}" @if($ruta->valor_proveedor!=null){{'class="success"'}}@else{{'class="danger"'}}@endif >
                        <td data-id="{{$ruta->id}}">
                            <?php echo $i ?>
                        </td>

                        <td>
                        <a><span>{{$ruta->detalle_recorrido}}</span>
                        </td>
                        <td style="width: 17%">
                        	<span>{{$ruta->recoger_en}}</span>
                        </td>
                        <td style="width: 17%">
                        	<span>{{$ruta->dejar_en}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->fecha_servicio}}</span>
                        </td>
                        <td>
                        	<span>{{$ruta->hora_servicio}}</span>
                        </td>
                        <td>
                            <a>{{$ruta->nombre_completo}}</a>
                        </td>
                        <td>

                        		<?php $total = $total+$ruta->total_pagado; ?>
                        		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor a cobrar" value="{{$ruta->total_pagado}}">
                            <div class="alert_planilla"></div>

                        </td>
                        <td>

                        </td>
                    </tr>
                    <?php $i++; $nombre_anterior = $ruta->razoncentro;?>
                @endforeach
                </tbody>
            </table>

        <div class="col-lg-12">

        	<div class="row">
        		<div class="col-xs-4" style="margin-bottom:10px;">
                    <div class="row">

                     	<a href="{{url('facturacion/revision')}}" class="btn btn-secondary btn-icon input-font">Volver<i class="fa fa-reply icon-btn"></i></a>

                     		<a id="calcular22" class="btn btn-primary btn-icon input-font">Sumar<i class="fa fa-money icon-btn"></i></a>

                     	<!--<a id="habilitar_campos22" class="btn btn-danger btn-icon input-font hidden">Habilitar Campos<i class="fa fa-pencil icon-btn"></i></a>-->

                     	<!--<a id="guardartotal" class="btn btn-success btn-icon input-font disabled">ENVIAR CUENTA DE COBRO <i class="fa fa-share-square icon-btn" aria-hidden="true"></i></a>-->

                    </div>
                </div>
                <div class="col-xs-2">
                    <!--<form class="formulario_ss">
                        <span class="number">Seguridad Social</span>
                        <input id="seguridad_soc" accept="application/pdf" class="seguridad_soc" type="file" value="Subir" name="seguridad_soc" >
                    </form>-->
                </div>
                <div class="col-xs-2 col-xs-offset-4">

                <button type="button" data-number="1" id="guardartotalE" disabled class="guardartotalE disabled">Enviar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
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
    											<td>TOTAL CUENTA</td>
    											<td><span class="span-total" id="valor_total"><?php echo '$ 0'?></span></td>
    										@else
    											<td>TOTAL CUENTA</td>
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
        @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                        <h1>NO DISPONIBLE</h1>
                        <p>No tiene servicios disponibles para cobrar.</p>

                    </div>
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                        <h1>NO DISPONIBLE</h1>
                        <p>Actualmente usted tiene una cuenta de cobro en proceso</p>
                        <p><a href="{{url('portalproveedores/solicitudactual')}}" title="Ir a la cuenta de cobro en proceso." id="go" data-id="" data-cuenta="" nombre="" class="btn btn-primary">VER CUENTA... <i class="fa fa-eye" aria-hidden="true"></i></a></p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div id="alert_eliminar" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: red; color: white">Atención <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><i id="cerrar_alerta_sino" style="float: right" class="fa fa-close"></i></div>
            <div class="panel-body">
                <div id="contenido_alerta">
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
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
<script>
    $('table a').click(function (e) {
        e.preventDefault();
    });
</script>

<script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>
</body>
</html>
