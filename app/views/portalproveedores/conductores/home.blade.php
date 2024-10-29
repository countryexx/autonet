<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<title>Autonet | Gestión de Conductores</title>
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
<body>
	@include('admin.menu')
	<div class="col-lg-12">
		<h1 class="h_titulo">MIS CONDUCTORES 
			
				<a style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-primary btn-list-table nuevo_conductor" aria-haspopup="true" title="Agregar un Nuevo Conductor" aria-expanded="true"><i class="fa fa-plus" aria-hidden="true" style="font-size: 16px;"></i></a>
			
		</h1>
		<div class="row">
			<div class="col-lg-12">
				@if($conductores!=null)
					@include('portalproveedores.conductores.menu_conductores')
				@else
					ACTUALMENTE NO CUENTA CON CONDUCTORES CREADOS O ACTIVOS EN EL SISTEMA
				@endif
			</div>
		</div>
		<div class="row">
			
				<div class="col-lg-12">
					<p style="font-size: 17px;">Asígnale aquí los vehículos a tus conductores.</p>
					<p style="font-size: 17px;"><span style="color: red">IMPORTANTE:</span> Si tus conductores no tienen vehículos asignados, no podrán ser programados.</p>
				</div>
			
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-3">
						<hr>
						<h5>-CONDUCTORES-</h5>
						<hr>
						<?php

							$vehiculos = DB::table('vehiculos')
							->leftJoin('conductores', 'conductores.id', '=', 'vehiculos.conductores_id')
							->select('vehiculos.*', 'conductores.nombre_completo', 'conductores.celular')
							->where('vehiculos.proveedores_id',Sentry::getUser()->proveedor_id)
							//->whereNull('conductores_id') //Si el conductor no está con provisional, ponerlo con provisional
							->get(); //Fin de consulta
						?>
						@if(isset($conductores))
							@foreach($conductores as $cond)
								
								<span style="text-align: right;">{{$cond->nombre_completo}}</span>

								<?php
									$know = DB::table('vehiculos')
									->where('conductores_id',$cond->id)
									->first();

									$know2 = DB::table('vehiculos')
									->where('estado_conductor',$cond->id)
									->first();
								?>
								
								<select @if($know!=null or $know2){{'disabled'}}@endif data-option="1" name="proveedores" id="vehicles" class="form-control input-font selectpicker vehicles {{$cond->id}}">
									<option data-driver="{{$cond->id}}" value="0">Seleccionar Placa</option>
		              @foreach($vehiculos as $veh)
		              	@if($veh->estado_conductor!=null)
		              		<?php 
		              		$name = DB::table('conductores')->where('id',$veh->estado_conductor)->pluck('nombre_completo');
		              		?>
		                	<option data-driver="{{$cond->id}}" data-vehiculo="{{$veh->id}}" @if($veh->estado_conductor==$cond->id){{'selected'}}@endif value="{{$veh->id}}" @if($veh->estado_conductor!=null){{'disabled'}}@endif @if($veh->estado_conductor!=null){{'style="color: red"'}}@endif value="{{$veh->id}}">{{$veh->placa}} @if($veh->estado_conductor!=null) ({{$name}}) PENDING...@endif</option>
		                @else
		                	<option data-driver="{{$cond->id}}" data-vehiculo="{{$veh->id}}" @if($veh->conductores_id==$cond->id){{'selected'}}@endif value="{{$veh->id}}" @if($veh->conductores_id!=null){{'disabled'}}@endif @if($veh->conductores_id!=null){{'style="color: red"'}}@endif value="{{$veh->id}}">{{$veh->placa}} @if($veh->conductores_id!=null) ({{$veh->nombre_completo}})@endif</option>
		                @endif

		              @endforeach
		            </select>

		            <button disabled style="float: right; margin-top: 5px" data-conductor="{{$cond->id}}" id="{{$cond->id}}" class="btn btn-success btn-icon asignar_vehiculo {{$cond->id}}">Asignar<i class="fa fa-check icon-btn"></i></button>

		            <button @if($know==null){{'disabled'}}@endif style="float: right; margin-top: 5px; margin-right: 5px" data-conductor="{{$cond->id}}" id="{{$cond->id}}" class="btn btn-danger btn-icon desasignar_vehiculo ">Desaginar<i class="fa fa-retweet icon-btn"></i></button>

								<hr style="margin-top: 50px">
							@endforeach
						@endif
					</div>
					<!--<div class="col-lg-3">
						<hr>
						Vehículos
						<hr>
					</div>-->
				</div>
			</div>
			
		</div>

		<div class="modal fade" tabindex="-1" role="dialog" id='modal_conductor'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Agregar un Nuevo Conductor</b></h4>
            </div>
            <div class="modal-body">
							<div class="row query">

								<div class="col-xs-4">
              		<label class="obligatorio" for="cc">Cédula del conductor</label>
                  <input type="number" class="form-control input-font" id="cedula_consulta">
                </div>

                <div class="col-xs-12">
                	<span style="color: red"><br>*Realizaremos una búsqueda para saber si el conductor trabajó antes con nosotros.</span>
                </div>

							</div>
							<form class="formulario" id="formulario">
							<div class="row datos hidden">
                  
                  <div class="col-xs-2">
                      <label>Fecha de Nacimiento</label>
                      <div class="input-group">
                          <div class='input-group date' id='datetimepicker'>
                              <input type='text' class="form-control input-font" id="fecha_nacimiento">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-2">
                      <label class="obligatorio" for="departamentos">Departamento</label>
                      <select class="form-control input-font" id="departamentos">
                          <option>-</option>
                          @foreach($departamentos as $departamento)
                              <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-xs-2">
                      <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                      <select disabled class="form-control input-font" id="ciudad">
                          <option>-</option>
                      </select>
                  </div>
                  <div class="col-xs-6">
                      <label class="obligatorio" for="nombre_completo">Nombre Completo</label>
                      <input type="text" class="form-control input-font" id="nombre_completo">
                  </div>
                  <div class="col-xs-3">
                      <label class="obligatorio" for="cc">Número de Identificación</label>
                      <input type="number" class="form-control input-font" id="cc">
                  </div>
                  <div class="col-xs-2">
                      <label class="obligatorio" for="celular">Celular</label>
                      <input type="number" class="form-control input-font" id="celular">
                  </div>
                  
                  <div class="col-xs-7">
                      <label class="obligatorio" for="direccion">Direccion</label>
                      <input type="text" class="form-control input-font" id="direccion">
                  </div>
                  <div class="col-xs-2">
                      <label class="obligatorio" for="tipodelicencia">Tipo de licencia</label>
                      <select class="form-control input-font" id="tipodelicencia">
                          <option>-</option>
                          <option>A1</option>
                          <option>A2</option>
                          <option>B1</option>
                          <option>B2</option>
                          <option>B3</option>
                          <option>C1</option>
                          <option>C2</option>
                          <option>C3</option>
                      </select>
                  </div>
                  <div class="col-xs-3">
                      <label>Fecha de Expedicion</label>
                      <div class="input-group">
                          <div class='input-group date' id='datetimepicker'>
                              <input type='text' class="form-control input-font" id="fecha_licencia_expedicion">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-3">
                      <label>Fecha de Vigencia</label>
                      <div class="input-group">
                          <div class="input-group date" id="datetimepicker">
                              <input type="text" class="form-control input-font" id="fecha_licencia_vigencia">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                  </div>
                  <div class="col-xs-1">
                      <label class="obligatorio" for="edad">Edad</label>
                      <input type="number" class="form-control input-font" id="edad">
                  </div>
                  <div class="col-xs-3">
                      <label class="obligatorio" for="genero">Genero</label>
                      <select class="form-control input-font" id="genero">
                          <option>-</option>
                          <option>MASCULINO</option>
                          <option>FEMENINO</option>
                      </select>
                  </div>
                  
									<div class="col-xs-2">
											<label class="obligatorio" for="experiencia">Experiencia (años)</label>
											<input type="number" class="form-control input-font" id="experiencia">
									</div>
                  <div class="col-xs-5">
                      <label class="obligatorio" for="accidentes">¿Tu conductor a tenido accidentes en los últimos 5 a&ntildeos?</label>
                      <select class="form-control input-font" id="accidentes">
                          <option value="0">-</option>
                          <option value="1">SI</option>
                          <option value="2">NO</option>
                      </select>
                  </div>
									<div class="col-xs-5 descripcion_accidente hidden">
                      <label for="descripcion_accidente">Describe aquí el Accidente</label>
                      <textarea rows="1" class="form-control input-font" id="descripcion_accidente"></textarea>
                  </div>

              </div>

							<div class="row adjuntos hidden">
								<div class="col-xs-6">
										<b>Adjunta aquí la cédula de tu conductor</b><br>
										<label for="pdf_cc_conductor">Cédula de Ciudadanía (PDF):</label>
										<input id="pdf_cc_conductor" accept="application/pdf" class="pdf_cc_conductor" type="file" value="Subir" name="pdf_cc_conductor" style="float: right">
								</div>

								<div class="col-xs-6">
										<b>Adjunta aquí la Licencia de tu conductor</b><br>
										<label for="pdf_licencia_conductor">Licencia de Conducción (PDF):</label>
										<input id="pdf_licencia_conductor" accept="application/pdf" class="pdf_licencia_conductor" type="file" value="Subir" name="pdf_licencia_conductor" style="float: right">
								</div>
							</div>
							<div class="row adjuntos hidden" style="margin-top: 30px">
								<br>
								<div class="col-xs-6">
										<b>Adjunta aquí la Seguridad Social de tu conductor</b><br>
										<label for="pdf_ss">Planilla de Seguridad Social Vigente:</label>
										<input id="pdf_ss" accept="application/pdf" class="pdf_ss" type="file" value="Subir" name="pdf_ss" style="float: right">
								</div>
								<br>
								<div class="col-xs-6">
										<b>Adjunta aquí la Foto de tu conductor</b><br>
										<label for="fotoc">Foto del Conductor</label>
										<input id="fotoc" accept="image/x-png,image/gif,image/jpeg" class="fotoc" type="file" name="fotoc" style="float: right">
								</div>
							</div>
							<br>
							</form>
            </div>

            <div class="modal-footer">

							<a id="continuar_cedula" data-sw="0" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">CONTINUAR<i class="fa fa-arrow-right icon-btn"></i></a>

							<a id="continuar" data-sw="0" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-success btn-icon hidden">CONTINUAR<i class="fa fa-arrow-right icon-btn"></i></a>

              <a id="guardars" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon hidden">GUARDAR<i class="fa fa-check icon-btn"></i></a>

							<a id="volver" data-sw="0" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-danger btn-icon hidden">VOLVER<i class="fa fa-arrow-left icon-btn"></i></a>

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
    <script>

			$('#accidentes').change(function() {

				var value = $(this).val();

				if(value=='1'){
					$('.descripcion_accidente').removeClass('hidden');
				}else{
					$('.descripcion_accidente').addClass('hidden');
				}

			});

			$('#departamentos').change(function(){

      var departamento_id = $('#departamentos').val();
			//alert(departamento_id)
      var valor = $('#departamentos option:selected').html();
      if(valor==='-'){
        $('#ciudad').attr('disabled','disabled');
      }
      $.ajax({
        type: "post",
        url: "../ciudades/mostrarciudades",
        dataType: 'json',
        data: {'id': departamento_id},
        success: function(data) {
            if(data.mensaje===true){
                $('#ciudad').removeAttr('disabled');

                $('#ciudad').find('option').remove().end().append('<option>-</option>');
                for(i in data.respuesta) {
                    $('#ciudad').append('<option value="'+data.respuesta[i].id+'">'+data.respuesta[i].ciudad+'</option>');
                }
            }else if(data.mensaje===false){
                $('#ciudad').find('option').remove().end().append('<option>-</option>');
                $('#ciudad').attr('disabled','disabled');
            }
        }
      });

    });

		$('#continuar_cedula').click(function() {

			var valor_cedula = $('#cedula_consulta').val();

			if(valor_cedula=='') {

				$.confirm({
          title: 'Oops!',
          content: 'Parece que no has dijitado la cédula.',
          buttons: {
            confirm: {
              text: 'Ok',
              btnClass: 'btn-danger',
              keys: ['enter', 'shift'],
              action: function(){

              	

              }
            }
          }
        });

			}else{

				$.ajax({
	        url: 'validarcedula',
	        method: 'post',
	        data: {cedula: valor_cedula}
	      }).done(function(data){

	        if(data.respuesta=='ocupado'){
	          
	          $.confirm({
	            title: 'Oops!',
	            content: 'Parece que el conductor se encuentra actualmente con otro proveedor.<br><br>Para poder agregar a tu conductor, el proveedor con el que está actualmente debe eliminarlo de su portal.',
	            buttons: {
	              confirm: {
	                text: 'Ok',
	                btnClass: 'btn-danger',
	                keys: ['enter', 'shift'],
	                action: function(){

	                	location.reload();

	                }
	              }
	            }
	          });

	        }else if(data.respuesta==true){
	          
	          var id_conductor = data.conductor.id;

	          $.confirm({
	            title: 'Conductor existente...',
	            content: '¡El conductor se encuentra en nuestra base de datos!<br><br>Confirmas que quieres agregarlo?<br><br><b>Es muy probable que debas actualizar la documentación de este conductor.</b>',
	            buttons: {
	              confirm: {
	                text: 'Si, confirmo',
	                btnClass: 'btn-success',
	                keys: ['enter', 'shift'],
	                action: function(){

	                	//función para enlazarlo con este proveedor
	                	$.ajax({
                      url: 'enlazarusuario',
                      method: 'post',
                      data: {id: id_conductor}
                    }).done(function(data){

                      if(data.respuesta==true){

                        $.confirm({
							            title: 'Realizado!',
							            content: 'El conductor fue vinculado con éxito.<br><br>Te aparecerá en el listado de tus conductores. Seleccionalo y verifica si tiene documentos por actualizar.',
							            buttons: {
							              confirm: {
							                text: 'Si, confirmo',
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
	              }
	            }
	          });

	        }else if(data.respuesta==false){

	        	$.confirm({
	            title: 'Continuemos!',
	            content: 'El conductor nunca ha trabajado con nosotros.<br><br>Deberás ingresar toda la información para poder agregarlo.',
	            buttons: {
	              confirm: {
	                text: 'Ok',
	                btnClass: 'btn-danger',
	                keys: ['enter', 'shift'],
	                action: function(){
	                	
	                	$('.datos').removeClass('hidden');
	                	$('.query').addClass('hidden');
	                	$('#cc').val(valor_cedula)
	                	$('#cc').attr('disabled','disabled')
	                	$('#cc').addClass('disabled')
	                	$('#continuar_cedula').addClass('hidden')
	                	$('#continuar').removeClass('hidden')

	                }
	              }
	            }
	          });

	        }

	      });

			}

		});

		$('#continuar').click(function() {

			var fecha_nacimiento = $('#fecha_nacimiento').val();
			var departamento = $('#departamentos option:selected').html().trim();
			var ciudad = $('#ciudad option:selected').html();
			var nombre_completo = $('#nombre_completo').val();
			var cc = $('#cc').val();
			var celular = $('#celular').val();
			var direccion = $('#direccion').val();
			var tipo_licencia = $('#tipodelicencia').val();
			var fecha_expedicion = $('#fecha_licencia_expedicion').val();
			var fecha_vigencia = $('#fecha_licencia_vigencia').val();
			var edad = $('#edad').val();
			var genero = $('#genero').val();
			var accidentes = $('#accidentes option:selected').html();
			var descripcion_accidentes = $('#descripcion_accidente').val();
			var experiencia = $('#experiencia').val();

			/*console.log('fecha_nacimiento : '+fecha_nacimiento)
			console.log('departamento : '+departamento)
			console.log('ciudad : '+ciudad)
			console.log('nombre_completo : '+nombre_completo)
			console.log('cc : '+cc)
			console.log('celular : '+celular)
			console.log('direccion : '+direccion)
			console.log('tipo_licencia : '+tipo_licencia)
			console.log('fecha_expedicion : '+fecha_expedicion)
			console.log('fecha_vigencia : '+fecha_vigencia)
			console.log('edad : '+edad)
			console.log('genero : '+genero)
			console.log('accidentes : '+accidentes)
			console.log('descripcion_accidentes : '+descripcion_accidentes)
			console.log('experiencia : '+experiencia)*/

			if(fecha_nacimiento=='' || departamento=='-' || ciudad=='-' || nombre_completo=='' || cc==''|| celular==''|| direccion=='' || tipo_licencia=='-' || fecha_expedicion=='' || fecha_vigencia=='' || edad=='' || genero=='-' || accidentes=='0' || (accidentes=='1' && descripcion_accidentes=='') || experiencia=='' ){
			//if(1>2){
				var text = '<b style="color: red">Los siguientes campos no pueden estar vacíos...</b><br><br>';

				if(fecha_nacimiento==''){
					text += 'Fecha de Nacimiento<br>';
				}

				if(departamento=='-'){
					text += 'Departamento<br>';
				}

				if(ciudad==''){
					text += 'Ciudad<br>';
				}

				if(nombre_completo==''){
					text += 'Nombre Completo<br>';
				}

				if(cc==''){
					text += 'Cédula de Ciudadanía<br>';
				}

				if(celular==''){
					text += 'Celular<br>';
				}

				if(direccion==''){
					text += 'Dirección<br>';
				}

				if(tipo_licencia=='-'){
					text += 'Tipo de Licencia<br>';
				}

				if(fecha_expedicion==''){
					text += 'Fecha de Expedición<br>';
				}

				if(fecha_vigencia==''){
					text += 'Fecha de Vencimiento<br>';
				}

				if(edad==''){
					text += 'Edad<br>';
				}

				if(genero=='-'){
					text += 'Género<br>';
				}

				if(accidentes=='0'){
					text += 'Accidentes en los últimos 5 años<br>';
				}

				if(accidentes=='1' && descripcion_accidentes==''){
					text += 'Descripción de Accidente<br>';
				}

				if(experiencia==''){
					text += 'Experiencia';
				}

				$.confirm({
            title: 'Atención',
            content: text,
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){



                    }

                }
            }
        });

			}else{

				$('.datos').addClass('hidden');
				$('.adjuntos').removeClass('hidden');
				$('#continuar').addClass('hidden');
				$('#guardars').removeClass('hidden');
				$('#volver').removeClass('hidden');

			}

		});

		$('#volver').click(function() {

			$('.datos').removeClass('hidden');
    	$('.query').addClass('hidden');
    	$('.adjuntos').addClass('hidden');

    	$(this).addClass('hidden');
    	$('#guardars').addClass('hidden');
    	$('#continuar').removeClass('hidden')
    	$('#continuar').removeClass('hidden')

		});

			$('#guardars').click(function() {
				//alert('testtttt')
					var cc = $('#pdf_cc_conductor').val();
					var licencia = $('#pdf_licencia_conductor').val();
					var ss = $('#pdf_ss').val();
					var foto = $('#fotoc').val();

					//if(fecha_nacimiento=='' || departamento=='-' || ciudad=='-' || nombre_completo=='' || cc==''|| celular==''|| direccion=='' || tipo_licencia=='-' || fecha_expedicion=='' || fecha_vigencia=='' || edad=='' || genero=='-' || accidentes=='0' || (accidentes=='1' && descripcion_accidentes=='') || experiencia=='' ){

					console.log(cc)
					console.log(licencia)
					console.log(ss)
					console.log(foto)

					if(cc=='' || licencia=='' || ss=='' || foto==''){

						var text = '<b style="color: red">Los siguientes campos no pueden estar vacíos...</b><br><br>';

						if(cc==''){
							text += 'PDF Cédula<br>'
						}

						if(licencia==''){
							text += 'PDF Licencia<br>'
						}

						if(ss==''){
							text += 'PDF Seguridad Social<br>'
						}

						if(foto==''){
							text += 'IMG Foto Conductor'
						}

						$.confirm({
		            title: 'Atención',
		            content: text,
		            buttons: {
		                confirm: {
		                    text: 'Ok',
		                    btnClass: 'btn-danger',
		                    keys: ['enter', 'shift'],
		                    action: function(){



		                    }

		                }
		            }
		        });

					}else{

						var fecha_nacimiento = $('#fecha_nacimiento').val();
						var departamento = $('#departamentos option:selected').html().trim();
						var ciudad = $('#ciudad').val();
						var nombre_completo = $('#nombre_completo').val();
						var cc = $('#cc').val();
						var celular = $('#celular').val();
						var direccion = $('#direccion').val();
						var tipo_licencia = $('#tipodelicencia').val();
						var fecha_expedicion = $('#fecha_licencia_expedicion').val();
						var fecha_vigencia = $('#fecha_licencia_vigencia').val();
						var edad = $('#edad').val();
						var genero = $('#genero').val();
						var accidentes = $('#accidentes').val();
						var descripcion_accidentes = $('#descripcion_accidente').val();
						var experiencia = $('#experiencia').val();

						/*console.log('fecha_nacimiento : '+fecha_nacimiento)
						console.log('departamento : '+departamento)
						console.log('ciudad : '+ciudad)
						console.log('nombre_completo : '+nombre_completo)
						console.log('cc : '+cc)
						console.log('celular : '+celular)
						console.log('direccion : '+direccion)
						console.log('tipo_licencia : '+tipo_licencia)
						console.log('fecha_expedicion : '+fecha_expedicion)
						console.log('fecha_vigencia : '+fecha_vigencia)
						console.log('edad : '+edad)
						console.log('genero : '+genero)
						console.log('accidentes : '+accidentes)
						console.log('descripcion_accidentes : '+descripcion_accidentes)
						console.log('experiencia : '+experiencia)*/

						formData = new FormData($('.formulario')[0]);
			      formData.append('fecha_nacimiento',fecha_nacimiento);
			      formData.append('departamento',departamento);
			      formData.append('ciudad',ciudad);
			      formData.append('nombre_completo',nombre_completo);
			      formData.append('cc',cc);
			      formData.append('celular',celular);
			      formData.append('direccion',direccion);
			      formData.append('tipo_licencia',tipo_licencia);
			      formData.append('fecha_expedicion',fecha_expedicion);
			      formData.append('fecha_vigencia',fecha_vigencia);
			      formData.append('edad',edad);
			      formData.append('genero',genero);
			      formData.append('accidentes',accidentes);
			      formData.append('descripcion_accidentes',descripcion_accidentes);
			      formData.append('experiencia',experiencia);

						$.ajax({
							 url: "agregarconductor",
							 type: 'post',
							 dataType: 'json',
							 data: formData,
							 processData: false,  // tell jQuery not to process the data
							 contentType: false   // tell jQuery not to set contentType
						 }).done(function(data){

							 if(data.respuesta==true){

								 $.confirm({
		 		            title: '¡Realizado!',
		 		            content: 'Conductor agregado satisfactoriamente.<br><br>Después de la revisión, se le notificará por correo si es aprobado o no.',
		 		            buttons: {
		 		                confirm: {
		 		                    text: 'Ok',
		 		                    btnClass: 'btn-success',
		 		                    keys: ['enter', 'shift'],
		 		                    action: function(){

															location.reload();

		 		                    }

		 		                }
		 		            }
		 		        });

							 }else if(data.respuesta==false){
								 alert('Error en la ejecución.');
							 }

						 });

						/*$.ajax({
		          url: 'agregarconductor',
		          method: 'post',
		          data: {fecha_nacimiento: fecha_nacimiento, departamento: departamento, ciudad: ciudad, nombre_completo: nombre_completo, cc: cc, celular: celular, direccion: direccion, tipo_licencia: tipo_licencia, fecha_expedicion: fecha_expedicion, fecha_vigencia: fecha_vigencia, edad: edad, genero: genero, accidentes: accidentes, descripcion_accidentes: descripcion_accidentes, experiencia: experiencia}
		        }).done(function(data){

		          if(data.respuesta==true){
		            alert('¡Realizado!')
								location.reload();
		          }else if(data.respuesta==false){

		          }

		        });*/

					}

			});

			$('.nuevo_conductor').click(function() {

				var id = $(this).attr('data-id');
	      $('#guardar_conductor').attr('data-id',id);
	      $('#modal_conductor').modal('show');

			});

			$('.desvincular').click(function(){
				
				var id = $(this).attr('data-conductor');

				$.confirm({
            title: 'Atención',
            content: 'Estás seguro de desvincular a este conductor de tu plataforma?<br><br>Se desactivará el usuario de UP DRIVER de este conductor.',
            buttons: {
                confirm: {
                    text: 'Desvincular',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
								        url: 'desvincularconductor',
								        method: 'post',
								        data: {id: id}
								      }).done(function(data){

								        if(data.respuesta==true){
								          
								          $.confirm({
								            title: 'Realizado!',
								            content: 'El conductor fue desvinculado de su plataforma.<br><br>El usuario ha quedado desactivado.<br>Se cerrará la sesión en UP DRIVER.',
								            buttons: {
								              confirm: {
								                text: 'Ok',
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

			$('.vehicles').change(function() {

				var id = $(this).val();

				var idConductor = $(this).find('option:selected').attr('data-driver');

				if(id!='0'){
					$('.'+idConductor+'').removeAttr('disabled');
				}else{
					$('.'+idConductor+'').attr('disabled', 'disabled');
				}

			});

			$('.asignar_vehiculo').click(function() {
					
					var id_conductor = $(this).attr('data-conductor');
					var id_vehiculo = $('.'+id_conductor+' option:selected').attr('data-vehiculo');

					$.ajax({
		        url: 'asignarvehiculo',
		        method: 'post',
		        data: {id_conductor: id_conductor, id_vehiculo: id_vehiculo}
		      }).done(function(data){

		        if(data.respuesta==true){
		          
		          $.confirm({
		            title: 'Cambio por aprobar...',
		            content: 'Se ha asignado el vehículo al conductor, pero es necesario que sea aprobado por Transportes.<br><br>Cuando se apruebe, te notificaremos por correo.',
		            buttons: {
		              confirm: {
		                text: 'Ok',
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

			});

			$('.desasignar_vehiculo').click(function() {
					
					var id_conductor = $(this).attr('data-conductor');
					var id_vehiculo = $('.'+id_conductor+' option:selected').attr('data-vehiculo');

					$.ajax({
		        url: 'desasignarvehiculo',
		        method: 'post',
		        data: {id_conductor: id_conductor, id_vehiculo: id_vehiculo}
		      }).done(function(data){

		        if(data.respuesta==true){
		          
		          $.confirm({
		            title: 'Vehículo desasignado!',
		            content: 'Se ha desasignado el vehículo al conductor!',
		            buttons: {
		              confirm: {
		                text: 'Ok',
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

			});

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>
</body>
</html>
