<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
	<title>Autonet | Cuentas de Cobro</title>
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
</head>
<body>
@include('admin.menu')
	<div class="container">
			
		<div class="btn-group" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Clientes <span class="caret"></span>		  
			</button>
			<ul class="dropdown-menu">
			<?php for ($i=0; $i < count($objArray); $i++) { ?>
		      	<li>
	        		<a href="{{url('portalproveedores/cliente/'.$objArray[$i])}}" id="open_modal_plan_rodamiento"><?php echo $objArray2[$i]; ?></a>
		      	</li>
		    <?php } ?>
		    <!--<li>
        		<a href="{{url('portalproveedores/cliente')}}" id="open_modal_plan_rodamiento">ENVIAR CUENTA DE COBRO A CONTABILIDAD <i class="fa fa-money" aria-hidden="true"></i></a>
	      	</li>-->
			</ul>
		</div>
		<br><br>
		<div class="btn-group" style="margin-bottom: 10px;">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  Todos los servicios <span class="caret"></span>		  
			</button>
			<ul class="dropdown-menu">			
		    <li>
        		<a href="{{url('portalproveedores/misservicios')}}" id="open_modal_plan_rodamiento">MIS SERVICIOS <i class="fa fa-money" aria-hidden="true"></i></a>
	      	</li>
			</ul>
		</div>
	</div>

@include('scripts.scripts')
</body>
</html>