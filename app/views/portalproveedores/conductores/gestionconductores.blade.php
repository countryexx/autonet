<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<title>Autonet | Conductor {{$conductor->nombre_completo}}</title>
	@include('scripts.styles')
	<style type="text/css">
		.sub{
			font-size: 17px;
			margin-top: 50px;

		}

		.cuadro{
			border-top: 1px solid;
			border-bottom: 1px solid;
			height: 230px;
		}
	</style>
</head>
<body style="font-family: Bahnschrift">
	@include('admin.menu')
	<div class="col-lg-12">
		@include('portalproveedores.conductores.menu_conductores')

		<?php
			$fecha_actual = date('Y-m-d');
			$diaanterior_seguridadsocial = strtotime ('-7 day', strtotime($condu));
			$diaanterior_seguridadsocial = date ('Y-m-d' , $diaanterior_seguridadsocial);
		 ?>
		<div class="row">
			<div class="col-lg-12">

			</div>
		</div>
		<div class="col-lg-12">

			<div class="row" style="margin-top: 5px">
					
				<?php

					if($conductor->usuario_id!=null){
						echo '<h3>'.explode(' ', $conductor->nombre_completo)[0].' ya dispone de usuario de UP DRIVER<br></h3>';
						echo '<h2>Presiona <a data-id="'.$conductor->usuario_id.'" data-nombre="'.explode(' ', $conductor->nombre_completo)[0].'" class="enviar_conductor">aquí</a> para enviar los datos de acceso de UP DRIVER a '.explode(' ', $conductor->nombre_completo)[0].'</h2><br>';
					}else{
						echo '<h3>'.explode(' ', $conductor->nombre_completo)[0].' <b style="color: red">NO</b> tiene usuario en UP DRIVER<br></h3>';
						echo '<h2>Presiona <a data-id="'.$conductor->id.'" data-nombre="'.explode(' ', $conductor->nombre_completo)[0].'" class="send_driver">aquí</a> para notificar a '.explode(' ', $conductor->nombre_completo)[0].' con la información para poder realizar el registro en UP DRIVER</h2><br>';
					}

				?>
				
			</div>

			<form id="formulario_conductores">
			<div class="row">
				<!-- VISTA PARA SEGURIDAD SOCIAL -->
				<div class="col-md-4 cuadro" style="border-right: 1px solid; border-left: 1px solid">

					<u style="font-size: 25px">SEGURIDAD SOCIAL</u><br>
					<br>

					@if($condu<$fecha_actual)

						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$condu}} </span>

						<br><br>

						<?php
							$fecha1= new DateTime($fecha_actual);
							$fecha2= new DateTime($condu);
							$diff = $fecha1->diff($fecha2);
						 ?>

						<u>Recuerde que no será programado hasta que envíe el documento actualizado.<br></u>
						<?php echo "<u>Tiene ".$diff->days." día(s) vencido...</u>"; ?>
						@if($conductor->seguridad_social_pdf===null)
						<br><br>
							<input type="file" name="seguridad_social" id="seguridad_social" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación... {{$conductor->seguridad_social_pdf===null}}</span>
						@endif

					@elseif($fecha_actual>=$diaanterior_seguridadsocial and $fecha_actual<=$condu)

						<?php
							$fecha1= new DateTime($fecha_actual);
							$fecha2= new DateTime($condu);
							$diff = $fecha1->diff($fecha2);
						 ?>
						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$condu}} <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>

						<br><br>

						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".$diff->days." días para el vencimiento...</u>"; ?>

						<br>

						@if($conductor->seguridad_social_pdf===null)
						<br><br>
							<input type="file" name="seguridad_social" id="seguridad_social" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de aprobación...</span>
						@endif

					@elseif($fecha_actual<$diaanterior_seguridadsocial)

						<span class="sub" style="padding: 4px; background-color: green; color: white; font-family: Bahnschrift">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$condu}} <i class="fa fa-check" aria-hidden="true"></i></span class="sub">

					@endif

				</div>

				<!-- VISTA PARA LA LICENCIA DE CONDUCCIÓN -->
				<div class="col-md-4 cuadro" style="border-right: 1px solid">
					<u style="font-size: 25px">LICENCIA DE CONDUCCIÓN</u><br>
					<br>
					@if($licencia_conduccion<0)

						<span class="sub" style="padding: 4px; background-color: red; color: white">Documento vencido <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> </span>

						<br><br>

						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Tiene ".abs($licencia_conduccion)." día(s) vencido...</u>"; ?>
						@if($conductor->licencia_conduccion_pdf===null)
						<br><br>
							<input type="file" name="licencia" id="licencia" accept="application/pdf" value="Adjuntar" style="margin-top: 25px">
						@else
							<br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de verificación...</span>
						@endif

					@elseif($licencia_conduccion>=0 and $licencia_conduccion<=7)

						<span class="sub" style="padding: 4px; background-color: orange; color: white">Documento próximo a vencer <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{$licencia_conduccion}} días <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
						<br><br>
						<?php

						?>
						<u>Recuerde que no será programado hasta que envíe el documento actualizado. <br></u>
						<?php echo "<u>Quedan ".abs($licencia_conduccion)." días para el vencimiento...</u>"; ?>

						@if($conductor->licencia_conduccion_pdf===null)
						<br><br>
							<input type="file" name="licencia" id="licencia" accept="application/pdf" value="Subir" style="margin-top: 25px">
						@else
							<br><br><br>
							<span style="padding: 6px; background-color: gray; color: white">Documento enviado, pendiente de aprobación...</span>
						@endif

					@elseif($licencia_conduccion>7)

						<span class="sub" style="padding: 4px; background-color: green; color: white">Documento actualizado <i class="fa fa-check" aria-hidden="true"></i> {{$licencia_conduccion}} días restantes<i class="fa fa-check" aria-hidden="true"></i></span>

					@endif

				</div>
			</div>

			<button data-id="{{$conductor->id}}" style="margin-bottom: 7px; float: right; margin-top: 10px" type="button" data-number="1" class="btn btn-primary btn-icon guardarc">Enviar Documentos <i class="fa fa-arrow-right icon-btn" aria-hidden="true"></i></button>
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

		<div id="alert_eliminar2" class="hidden">
		    <div class="col-lg-12">
		        <div class="panel panel-default">
		            <div class="panel-heading" style="background-color: green; color: white">REALIZADO <i class="fa fa-check" aria-hidden="true"></i><i id="cerrar_notificacion" style="float: right" class="fa fa-close"></i></div>
		            <div class="panel-body">
		                <div id="contenido_alerta2">
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
	<script src="{{url('jquery/portalproveedores.js')}}"></script>

	<script type="text/javascript">
		
		$('.enviar_conductor').click(function(){

			var name = $(this).attr('data-nombre');
			var id = $(this).attr('data-id');

			$.confirm({
	              title: 'Atención',
	              content: 'Estás seguro de enviar esta información a '+name+'?',
	              buttons: {
	                  confirm: {
	                      text: '¡Enviar!',
	                      btnClass: 'btn-success',
	                      keys: ['enter', 'shift'],
	                      action: function(){

	                        $.ajax({
	                          url: '../enviarsms',
	                          method: 'post',
	                          data: {cantidad: 1, nombre: name, id: id}
	                        }).done(function(data){

	                          if(data.respuesta==true){
	                            
	                            $.confirm({
						              title: 'Realizado',
						              content: '¡Se enviaron los datos de acceso a '+name+'!',
						              buttons: {
						                  confirm: {
						                      text: 'OK',
						                      btnClass: 'btn-success',
						                      keys: ['enter', 'shift'],
						                      action: function(){

						                        location.reload();

						                      }

						                  }
						              }        
					          	});

	                          }else if(data.respuesta==false){

	                          }

	                        });

	                      }

	                  },
	                  cancel: {
	                    text: 'Volver',
	                  }
	              }        
          	});
		});

		$('.send_driver').click(function(){

			var name = $(this).attr('data-nombre');
			var id = $(this).attr('data-id');

			$.confirm({
	              title: 'Atención',
	              content: 'Estás seguro de notificar a '+name+'?',
	              buttons: {
	                  confirm: {
	                      text: '¡Enviar!',
	                      btnClass: 'btn-success',
	                      keys: ['enter', 'shift'],
	                      action: function(){

	                        $.ajax({
	                          url: '../enviarsmss',
	                          method: 'post',
	                          data: {cantidad: 1, nombre: name, id: id}
	                        }).done(function(data){

	                          if(data.respuesta==true){
	                            
	                            $.confirm({
						              title: 'Realizado',
						              content: '¡Se enviaron los datos de acceso a '+name+'!',
						              buttons: {
						                  confirm: {
						                      text: 'OK',
						                      btnClass: 'btn-success',
						                      keys: ['enter', 'shift'],
						                      action: function(){

						                        location.reload();

						                      }

						                  }
						              }        
					          	});

	                          }else if(data.respuesta==false){

	                          }

	                        });

	                      }

	                  },
	                  cancel: {
	                    text: 'Volver',
	                  }
	              }        
          	});
		});


	</script>
</body>
</html>
