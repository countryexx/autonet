@if(isset($welcome))
<div class="container-fluid intermitente label-estado" style="background: gray; height: 80%; width: 75%; margin-top: 35px">



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
			$saludo = 'BUENAS NOCHES';
		}elseif ($hora<'19:00' && $hora>='12:00') {
			$saludo = 'BUENAS TARDES';
		}elseif ($hora>='05:00' && $hora<'12:00') {
			$saludo = 'BUENOS DÍAS';
		}
	?>
	<div class="row">
		<div class="col-md-10">
			<h5 style="color: white"><?php echo $day.' '.$fecha[2].' de '.$mes; ?></h5>
			<h2 style="font-family: cursive; color: orange"><?php echo $saludo; ?>, {{Sentry::getUser()->first_name}}. &#128075;</h2>
		</div>x
		<div class="col-md-2 col-xs-12 hidden col-sm-12 hidden">
			<button style="margin-top: 25px; float: right;" title="Abrir Ventana" type="button" class="btn btn-secondary btn-icon" data-toggle="modal" data-target=".mymodal2">Blog<i class="fa fa-newspaper-o icon-btn" aria-hidden="true"></i></button>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 hidden-xs hidden-sm">
			<center>
				<h2 style="margin-top: 10%;font-family: cursive; font-size: 60px; color: white" class="parpadea">¡BIENVENIDO!</h2>
			</center>
		</div>
		<div class="col-sm-4 col-xs-4 hidden-md hidden-lg">
			<center>
				<h2 style="margin-top: 10%;font-family: cursive; font-size: 30px; color: white" class="parpadea">¡BIENVENIDO!</h2>
			</center>
		</div>
	</div>
	<div class="row">
		@if($welcome->mensaje!=null)
		<div class="col-md-6" style="margin-top: 80px; background: orange">
			<?php

				//FIN CÓDIGO PARA CAPTURAR EL DÍA ACTUAL

				$mes = date('m');
				$dia = date('d');
				$querys = $mes.$dia;

				$consulta = DB::table('empleados')->where('cumpleanos',$querys)->where('estado',1)->get();

				//SI EN EL DIA Y MES ACTUAL HAY UNO O MÁS CUMPLIMENTADOS
				if($consulta!=null){
					$valores = '';
					foreach ($consulta as $employ) {

						$fecha = explode('-', $employ->fecha_nacimiento);
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

						if($valores!=null){
							$valores .= ', <br> '.$employ->nombres.' '.$employ->apellidos.'';
						}else{
							$valores .=$employ->nombres.' '.$employ->apellidos.'';
						}

					}


					/*if(Sentry::getUser()->id_empleado===$consulta->id){
						$frase = 'AOTOUR te Felicita a tí, ';
						$tu = 'tu';
					}else{
						$frase = 'AOTOUR Felicita &#128079; a: ';
						$tu = 'su';
					}*/
					$frase = 'AOTOUR Felicita a :';

					$datos = $frase.' <p style="color: gray"> '.$valores.'  &#x270b;</p> Por la celebración de su cumpleaños hoy '.$day.' '.$fecha[2].' de '.$mes.' del 2024. &#x1f973; &#x1f389;';
				}elseif($welcome->mensaje!=null){
					$datos = $welcome->mensaje;
				}else{
					$datos = null;
				}

			?>

			<span style="font-size: 25px; color: white"><?php if($datos!=null){ echo $datos;} ?></span>

		</div>
		<div class="col-md-6" style="margin-top: 80px; background: orange">
			<?php

				//FIN CÓDIGO PARA CAPTURAR EL DÍA ACTUAL

				$mes = date('m');
				$dia = date('d');
				$querys = $mes.$dia;

				$querys = '2023'.$mes.$dia;

				if(Sentry::getUser()->id_rol==1 or Sentry::getUser()->id_rol==3 or Sentry::getUser()->id_rol==5 or Sentry::getUser()->id_rol==10 or Sentry::getUser()->id_rol==17 or Sentry::getUser()->id_rol==50 or Sentry::getUser()->id_rol==45 or Sentry::getUser()->id_rol==47 or Sentry::getUser()->id_rol==33 or Sentry::getUser()->id_rol==32){

					//conductores
					$consulta = DB::table('conductores')
					->where('fecha_nacimiento',$querys)
					->whereNull('bloqueado_total')
					->whereNull('bloqueado')
					->get();

					//SI EN EL DIA Y MES ACTUAL HAY UNO O MÁS CUMPLIMENTADOS
					if($consulta!=null){
						$valors = '';
						foreach ($consulta as $employs) {

							$fecha = explode('-', $employs->fecha_nacimiento);
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

							if($valors!=null){
								$valors .= ', <br> '.$employs->nombre_completo.'';
							}else{
								$valors .=$employs->nombre_completo.'';
							}

						}

						if(count($consulta)>1){
							$t = 'a los colaboradores al volante ';
						}else{
							$t = 'al colaborador al volante ';
						}

						$frase = 'AOTOUR Felicita '.$t.' :';
						//$day = 'LUNES ';
						$dato = $frase.' <p style="color: gray"> '.$valors.'  &#x270b;</p> Por la celebración de su cumpleaños hoy '.$day.' '.$fecha[2].' de '.$mes.' del 2024. &#x1f973; &#x1f389;';
					}elseif($welcome->mensaje!=null){
						$dato = $welcome->mensaje;
					}else{
						$dato = null;
					}

				}

			?>

			@if(Sentry::getUser()->id_rol==1 or Sentry::getUser()->id_rol==3 or Sentry::getUser()->id_rol==5 or Sentry::getUser()->id_rol==10 or Sentry::getUser()->id_rol==17 or Sentry::getUser()->id_rol==50 or Sentry::getUser()->id_rol==45 or Sentry::getUser()->id_rol==47 or Sentry::getUser()->id_rol==33 or Sentry::getUser()->id_rol==32)
				<span style="font-size: 25px; color: white"><?php if($dato!=null){ echo $dato;} ?></span>
			@endif

		</div>
		@endif
	</div>

    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header" style="background-color: #3CAEDF">
	        	<div class="row">
	        		<div class="col-md-7">
	        			<h5 class="modal-title" style="text-align: left; font-size: 20px">BLOG <i class="fa fa-newspaper-o" aria-hidden="true"></i></h5>
	        		</div>

	        	</div>
	        </div>
	        <div class="modal-body">
	          <div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
					@if($welcome->pdf!=null)
						<span style="font-size: 20px; font-family: monospace; background: orange;">{{$welcome->sub1}} &#x2b07;</span>
			            <div class="panel-body" style="height: 60%; border: 1px solid">
			            	<center>

							@if($welcome->estado1===1)
								<!-- PDF -->
								<iframe width="500px" height="350px"
								src="{{url('biblioteca_imagenes/talentohumano/bienvenida/' . $welcome->pdf)}}" style="margin: 20px; ">
								</iframe>
							@elseif($welcome->estado1===2)
								{{$welcome->pdf}}
							@elseif($welcome->estado1===3)
								<img width="500px" height="350px" src="{{url('biblioteca_imagenes/talentohumano/bienvenida/' . $welcome->pdf)}}">
							@endif
			               </center>
			            </div>
			        @endif
		          	</div>
				</div>
				<div class="col-lg-12">
					<div class="panel panel-default">
					@if($welcome->pdf2!=null)
						<span style="font-size: 20px; font-family: monospace; background: orange;">{{$welcome->sub2}} &#x2b07;</span>
			            <div class="panel-body" style="height: 60%; border: 1px solid;">
			            	<center>

							@if($welcome->estado2===1)
								<!-- PDF -->
								<iframe width="500px" height="350px"
								src="{{url('biblioteca_imagenes/talentohumano/bienvenida/' . $welcome->pdf2)}}" style="margin: 20px; ">
								</iframe>
							@elseif($welcome->estado2===2)
								{{$welcome->pdf2}}
							@elseif($welcome->estado2===3)
							<span>{{$welcome->sub2}}</span>
								<img width="500px" height="350px" src="{{url('biblioteca_imagenes/talentohumano/bienvenida/' . $welcome->pdf2)}}">
							@endif

			               	</center>
			            </div>
			        @endif
		          	</div>
				</div>
			</div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger" data-dismiss="modal" style="color: white">Cerrar esta Ventana</button>
	        </div>
	      </div>
	    </div>
	  </div>
</div>
@endif
