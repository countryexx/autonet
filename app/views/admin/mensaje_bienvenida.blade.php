@if(isset($welcome))
<div class="container-fluid intermitente label-estado" style="background: white; height: 80%; width: 75%; margin-top: 35px">



	<?php

		//CÓDIGO PARA CAPTURAR EL DÍA ACTUAL
		$day = date("l");

		if($day=='Monday'){
			$day = 'LUNES';
		}else if($day=='Tuesday'){
			$day = 'MARTES';
		}else if($day=='Wednesday'){
			$day = 'MIÉRCOLES';
		}else if($day=='Thursday'){
			$day = 'JUEVES';
		}else if($day=='Friday'){
			$day = 'VIERNES';
		}else if($day=='Saturday'){
			$day = 'SÁBADO';
		}else if($day=='Sunday'){
			$day = 'DOMINGO';
		}

		$fecha = explode('-', date('Y-m-d'));
		$mes = $fecha[1];
		if($mes==='01'){
			$mes = 'ENERO';
		}else if($mes==='02'){
			$mes = 'FEBRERO';
		}else if($mes==='03'){
			$mes = 'MARZO';
		}else if($mes==='04'){
			$mes = 'ABRIL';
		}else if($mes==='05'){
			$mes = 'MAYO';
		}else if($mes==='06'){
			$mes = 'JUNIO';
		}else if($mes==='07'){
			$mes = 'JULIO';
		}else if($mes==='08'){
			$mes = 'AGOSTO';
		}else if($mes==='09'){
			$mes = 'SEPTIEMBRE';
		}else if($mes==='10'){
			$mes = 'OCTUBRE';
		}else if($mes==='11'){
			$mes = 'NOVIEMBRE';
		}else if($mes==='12'){
			$mes = 'DICIEMBRE';
		}

		//FIN CÓDIGO PARA CAPTURAR EL DÍA ACTUAL

		$hora = date('H:i');
		//echo $hora;
		if( ($hora>='19:00' && $hora<='23:59') || ($hora>='00:00' && $hora<='04:59')){
			$saludo = '¡BUENAS NOCHES';
		}elseif ($hora<'19:00' && $hora>='12:00') {
			$saludo = '¡BUENAS TARDES';
		}elseif ($hora>='05:00' && $hora<'12:00') {
			$saludo = '¡BUENOS DÍAS';
		}
	?>
	<div class="row">
		<div class="col-md-10">
			<h3 style="font-family: calibri; color: black"><?php echo $day.' '.$fecha[2].' de '.$mes; ?></h3>
			<h2 style="font-family: calibri; color: #f47321"><?php echo $saludo; ?>! </h2>
		</div>
		
	</div>
	<div class="row" style="margin-top: 80px">
		<div class="col-lg-12 col-md-12 hidden-xs hidden-sm">
			<center>
				<div>
                	<img class="img-icon" src="{{url('img/suth.png')}}" alt="">
              	</div>
			</center>
		</div>
		<div class="col-sm-4 col-xs-4 hidden-md hidden-lg">
			<center>
				<div>
                	<img class="img-icon" src="{{url('img/suth.png')}}" alt="">
              	</div>
			</center>
		</div>
	</div>

</div>
<footer>
        <p style="text-align: center; margin-right: 10px; font-family: calibri">Usted está ingresando a una plataforma propiedad de AOTOUR.
		El ingreso a esta plataforma es netamente informativo.
		Sustraer datos que se muestran en nuestra plataforma sin nuestra autorización incurre en un delito penal.</p>
    </footer>
@endif
