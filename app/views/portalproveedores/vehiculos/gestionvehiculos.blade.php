<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
	<link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <meta name="url" content="{{url('/')}}">
	<title>Autonet | Vehículo {{$placa}}</title>
	@include('scripts.styles')
	<style type="text/css">
		.sub{
			font-size: 14px;
			margin-top: 50px;
		}

		.cuadro{
			border-top: 1px solid;
			border-bottom: 1px solid;
			height: 210px;
		}
	</style>
</head>
<body style="font-family: Bahnschrift;">
	@include('admin.menu')
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				@include('portalproveedores.menu_vehiculos')
				<?php
					$fecha_actual = date('Y-m-d');
					$diaanterior_tarjetaoperacion = strtotime ('-7 day', strtotime($vehiculos->fecha_vigencia_operacion));
					$diaanterior_tarjetaoperacion = date ('Y-m-d' , $diaanterior_tarjetaoperacion);

					$diaanterior_soat = strtotime ('-7 day', strtotime($vehiculos->fecha_vigencia_soat));
					$diaanterior_soat = date ('Y-m-d' , $diaanterior_soat);

					$diaanterior_tecnomecanica = strtotime ('-7 day', strtotime($vehiculos->fecha_vigencia_tecnomecanica));
					$diaanterior_tecnomecanica = date ('Y-m-d' , $diaanterior_tecnomecanica);

					$diaanterior_preventivo = strtotime ('-7 day', strtotime($vehiculos->mantenimiento_preventivo));
					$diaanterior_preventivo = date ('Y-m-d' , $diaanterior_preventivo);

					$diaanterior_contractual = strtotime ('-7 day', strtotime($vehiculos->poliza_contractual));
					$diaanterior_contractual = date ('Y-m-d' , $diaanterior_contractual);

					$diaanterior_extracontractual = strtotime ('-7 day', strtotime($vehiculos->poliza_extracontractual));
					$diaanterior_extracontractual = date ('Y-m-d' , $diaanterior_extracontractual);

				?>
			</div>
		</div>
		<div class="col-lg-12">
			<form id="formulario2">
			<div class="row">

				<!-- VISTA PARA TARJETA DE OPERACIÓN -->
				<!-- VERIFICAR QUE SE ENCUENTREN CORRECTAS LAS VALIDACIONES DE ARCHIVOS PDF (ACCEPT) -->
				<!-- CALCULAR DATOS -->

				<div class="col-md-4 cuadro disabled" style="border-right: 1px solid">
					<u style="font-size: 25px">TARJETA DE OPERACIÓN</u><br>

					<br>
					@if($vehiculos->fecha_vigencia_operacion<$fecha_actual)
						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_operacion}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_operacion);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($vehiculos->tarjeta_operacion_pdf===null)
						<br><br>
							<input type="file" name="tarjeta_operacion" id="tarjeta_operacion" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_tarjetaoperacion and $fecha_actual<=$vehiculos->fecha_vigencia_operacion)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_operacion}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_operacion);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado.<br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->tarjeta_operacion_pdf===null)
						<br><br>
							<input type="file" name="tarjeta_operacion" id="tarjeta_operacion" accept="application/pdf" value="Subir" style="margin-top: 25px">
						@else

							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_tarjetaoperacion)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_operacion}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA TARJETA DE OPERACIÓN -->

				<!-- VISTA SOAT -->
				<div class="col-md-4 cuadro" style="border-right: 1px solid">
					<u style="font-size: 25px">SOAT</u><br>
					<br>
					@if($vehiculos->fecha_vigencia_soat<$fecha_actual)
						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_soat}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_soat);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($vehiculos->soat_pdf===null)
						<br><br>
							<input type="file" name="soat" id="soat" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
							
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_soat and $fecha_actual<=$vehiculos->fecha_vigencia_soat)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_soat}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_soat);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->soat_pdf===null)
						<br><br>
							<input type="file" name="soat" id="soat" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_soat)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_soat}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA SOAT -->

				<!-- VISTA TECNOMECÁNICA -->
				<div class="col-md-4 cuadro">
					<u style="font-size: 25px">TECNOMECÁNICA</u><br>
					<br>
					@if($vehiculos->fecha_vigencia_tecnomecanica<$fecha_actual)
						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_tecnomecanica}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_tecnomecanica);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>

						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>

						@if($vehiculos->tecnomecanica_pdf===null)
						<br><br>
							<input type="file" name="tecnomecanica" id="tecnomecanica" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_tecnomecanica and $fecha_actual<=$vehiculos->fecha_vigencia_tecnomecanica)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_tecnomecanica}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->fecha_vigencia_tecnomecanica);
							$diff = $fecha1->diff($fecha2); //cálculo de diferencia de días
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->tecnomecanica_pdf===null)
						<br><br>
							<input type="file" name="tecnomecanica" id="tecnomecanica" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_tecnomecanica)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->fecha_vigencia_tecnomecanica}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA TECNOMECÁNICA -->
			</div>

			<!-- FILA 2 -->
			<div class="row" style="margin-top: 30px">

				<!-- VISTA MANTENIMIENTO PREVENTIVO -->
				<div class="col-md-4 cuadro" style="border-right: 1px solid">

					<u style="font-size: 25px">MANTENIMIENTO PREVENTIVO</u><br>
					<br>
					@if($vehiculos->mantenimiento_preventivo<$fecha_actual)
						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->mantenimiento_preventivo}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php //apertura de etiqueta php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->mantenimiento_preventivo);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>

						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($vehiculos->preventivo_pdf===null)
						<br><br>
							<input type="file" name="mantenimiento_preventivo" id="mantenimiento_preventivo" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_preventivo and $fecha_actual<=$vehiculos->mantenimiento_preventivo)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->mantenimiento_preventivo}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->mantenimiento_preventivo);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->preventivo_pdf===null)
						<br><br>
							<input type="file" name="mantenimiento_preventivo" id="mantenimiento_preventivo" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación</span>
						@endif

					@elseif($fecha_actual<$diaanterior_preventivo)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->mantenimiento_preventivo}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA MANTENIMIENTO PRECENTIVO -->

				<!-- VISTA POLIZA CONTRACTUAL -->
				<div class="col-md-4 cuadro" style="border-right: 1px solid">
					<u style="font-size: 25px">POLIZA CONTRACTUAL</u><br>
					<br>

					@if($vehiculos->poliza_contractual<$fecha_actual)

						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->poliza_contractual}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->poliza_contractual);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>

						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($vehiculos->poliza_contractual_pdf===null)
						<br><br>
							<input type="file" name="poliza_contractual" id="poliza_contractual" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_contractual and $fecha_actual<=$vehiculos->poliza_contractual)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->poliza_contractual}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><br></span>
						<br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->poliza_contractual);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->poliza_contractual_pdf===null)
						<br><br>
							<input type="file" name="poliza_contractual" id="poliza_contractual" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_contractual)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->poliza_contractual}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA POLIZA CONTRACTUAL -->

				<!-- VISTA POLIZA EXTRACONTRACTUAL -->
				<div class="col-md-4 cuadro">
					<u style="font-size: 25px">POLIZA EXTRACONTRACTUAL</u><br>
					<br>
					@if($vehiculos->poliza_extracontractual<$fecha_actual)

						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->poliza_extracontractual}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->poliza_extracontractual);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>

						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($vehiculos->poliza_extracontractual_pdf===null)
						<br><br>
							<input type="file" name="poliza_extracontractual" id="poliza_extracontractual" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif
					<!-- SI LA FECHA ACTUAL ES MAYOR O IGUAL A LA FECHA DE VENCIMIENTO MENOS 7 DÍAS Y LA FECHA ACTUAL ES MENOR O IGUAL A LA FECHA DE VENCIMIENTO -->

					@elseif($fecha_actual>=$diaanterior_extracontractual and $fecha_actual<=$vehiculos->poliza_extracontractual)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$vehiculos->poliza_extracontractual}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

						<br><br>
						<?php
							$fecha1 = new DateTime($fecha_actual);
							$fecha2 = new DateTime($vehiculos->poliza_extracontractual);
							$diff = $fecha1->diff($fecha2);
						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." día(s) para el vencimiento...</u>"; ?>

						@if($vehiculos->poliza_extracontractual_pdf===null)
						<br><br>
							<input type="file" name="poliza_extracontractual" id="poliza_extracontractual" accept="application/pdf" accept="" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_extracontractual)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$vehiculos->poliza_extracontractual}} <i class="fa fa-check" aria-hidden="true"></i></span>

					@endif
				</div>
				<!-- FIN VISTA POLIZA EXTRACONTRACTUAL -->

            <button data-id="{{$vehiculos->id}}" style="margin-bottom: 7px; float: right; margin-top: 10px" type="button" data-number="1" class="btn btn-primary btn-icon guardars">Enviar Documentos <i class="fa fa-arrow-right icon-btn" aria-hidden="true"></i></button>
			</div>
		</form>
		</div>

		<div id="alert_eliminar" class="hidden">
		    <div class="col-lg-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="background-color: green; color: white">REALIZADO <i class="fa fa-check" aria-hidden="true"></i><i id="cerrar_notificacion" style="float: right" class="fa fa-close"></i></div>
		            <div class="panel-body">
		                <div id="contenido_alerta">
		                </div>
		            </div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
	<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
	<script src="{{url('jquery/portalproveedores.js')}}"></script>
    <!--<script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>-->
</body>
</html>
