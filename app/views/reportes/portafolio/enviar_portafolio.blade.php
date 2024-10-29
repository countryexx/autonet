<html>
	<head>
	    <meta charset="UTF-8">
	    <meta name="url" content="{{url('/')}}">
	    <title>Autonet | Enviar Portafolio</title>
	    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	    @include('scripts.styles')
	    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
	    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
      <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
			<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
      <link rel="manifest" href="{{url('manifest.json')}}">	</head>
      <style media="screen">
      div.textarea{
        overflow-y: scroll;
        min-height: 230px;
        min-width: 450px;
        font-size: 14px;
      }
    </style>
	<body background="{{url('biblioteca_imagenes/fondo_pdf.png')}}" >
		@include('admin.menu')

		<div class="container-fluid" >
      <div class="col-lg-2">
        <ol style="margin-bottom: 5px" class="breadcrumb">
          <li><a href="{{url('reportes/pqr')}}">Enviar Portafolio</a></li>
          <li><a href="{{url('reportes/portafoliosenviados')}}">Portafolios enviados</a></li>
        </ol>
      </div>
      <br>
      <div class="col-lg-12">

		        <div style="margin-top: 25px">
		          <center><strong class="h_titulo" >Formulario de envío de Portafolio</strong></center>
		        </div>
			      <div class="row">
			          <div class="col-lg-4 col-lg-push-4" style="margin-top: 10px">
			              <div class="panel panel-default">
			                  <div class="panel-heading" style="background-color: gray; color: white">Datos de la empresa a la que será enviado el portafolio</div>
			                  <div class="panel-body">
													<form id="formularioportafolio">
			                      <div class="row">
			                        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
			                          <label for="nombre_empresa" class="obligatorio">Nombre de la Organización</label>
			                          <input status="0" class="form-control input-font" type="text" name="nombre_empresa" id="nombre_empresa">
			                        </div>
															<div class="col-lg-6 col-md-2 col-sm-2 col-xs-4 ">
			                          <label for="telefono" class="obligatorio">Dirección</label>
			                          <input status="0" class="form-control input-font" type="text" name="direccion" id="direccion">
			                        </div>
			                      </div>
			                      <div class="row">
			                        <div class="col-lg-6 col-md-3 col-sm-3 col-xs-6">
			                          <label for="ciudad" class="obligatorio">Ciudad</label>
			                          <select class="form-control input-font" name="ciudad" id="ciudad">
			                            <option value="0">-</option>
			                            <option>BARRANQUILLA</option>
			                            <option>BOGOTA</option>
			                            <option>CARTAGENA</option>
			                            <option>CALI</option>
			                            <option>MEDELLIN</option>
			                          </select>
			                        </div>
			                        <div class="col-lg-6 col-md-2 col-sm-2 col-xs-4 ">
			                          <label for="telefono" class="obligatorio">Teléfono</label>
			                          <input class="form-control input-font" type="number" name="telefono" id="telefono">
			                        </div>

			                        <div class='col-lg-6 col-md-5 col-sm-5 col-xs-12'>
			                          <label for="email" class="obligatorio">Solicitante</label>
			                          <input class="form-control" name="solicitante" type="solicitante" id="solicitante">
			                        </div>
			                        <div class='col-lg-6 col-md-5 col-sm-5 col-xs-12'>
			                          <label for="email" class="obligatorio">Correo Electrónico</label>
			                          <input class="form-control" name="email" type="email" id="email" required>
			                        </div>

															<div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
			                          <label for="portafolios_enviar" class="obligatorio">Portafolios a enviar</label>

																<select data-option="1" name="proveedores" data-done-button="true" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">
																	<option value="0">-</option>
			                            <option value="1">GENERAL</option>
			                            <option value="2">RUTAS</option>
			                            <option value="3">TARIFAS</option>
				                        </select>

			                        </div>
			                      </div>
													</form>
			                  </div>
			              </div>
										<button id="enviar_portafolio" style="width: 100%" type="button" disabled class="btn btn-success btn-icon">Continuar<i class="fa fa-send icon-btn"></i></button>
										<button id="enviado" style="width: 100%" type="button" class="btn btn-primary btn-icon hidden">¡Enviado!<i class="fa fa-check icon-btn"></i></button>
			          </div>
			      </div>
		    </div>

				<!-- Modal de tarifas -->
				<div class="modal fade" tabindex="-1" role="dialog" id='shortModal33' data-backdrop="static">

			    <div class="modal-dialog modal-lg">
			        <div class="modal-content">

			            <div class="modal-header">
			                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>-->
			                <h4 class="modal-title" style="text-align: center">Selección de Tarifas a Enviar</h4>
			            </div>
			            <div class="modal-body">
			                <div class="row">

			                    <div class="col-xs-12">

														<table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
															 <thead>
																 <tr>
																	<td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_all" type="checkbox" check="false"></center></td>
																	 <td style="text-align: center;">Trayecto</td>
																	 <td style="text-align: center;">Valor SUV</td>
																	 <td style="text-align: center;">Valor VAN</td>
																 </tr>
															 </thead>
															 <tbody>
																 @if(isset($centrosdecosto))
																	@foreach($centrosdecosto as $ruta)

																			<?php
																			$tarifa = DB::table('tarifas')
																			->leftJoin('traslados', 'traslados.id', '=', 'tarifas.trayecto_id')
																			->select('tarifas.id', 'tarifas.trayecto_id', 'tarifas.proveedor_auto', 'tarifas.proveedor_van', 'tarifas.cliente_auto', 'tarifas.cliente_van', 'tarifas.centrodecosto_id', 'traslados.nombre')
																			->whereIn('tarifas.centrodecosto_id', [97,292])
																			//->whereNotNull('tarifas.localidad')
																			->where('tarifas.trayecto_id',$ruta->id)
																			->first();
																			?>
																			@if($tarifa!=null)
																				<tr>
																						<td><center><input class="clients" data-id="{{$ruta->id}}" data-traslado="{{$ruta->nombre}}" data-auto="{{$tarifa->cliente_auto}}" data-van="{{$tarifa->cliente_van}}" style="width: 15px; height: 15px;" type="checkbox" check="false"></center></td>
																						<td>{{$ruta->nombre}}</td>
																						<td>
																							@if($tarifa!=null)
																									<p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; text-align: center">$ {{number_format($tarifa->cliente_auto)}} </p>
																							@else
																									<p class="bolder text-danger" style="margin: 0 !important; font-size: 13px; text-align: center"> Sin Tarifa </p>
																							@endif
																						</td>
																						<td>
																							@if($tarifa!=null)
																									<p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; text-align: center">$ {{number_format($tarifa->cliente_van)}} </p>
																							@else
																									<p class="bolder text-danger" style="margin: 0 !important; font-size: 13px; text-align: center"> Sin Tarifa </p>
																							@endif
																						</td>
																				</tr>
																			@endif

																	@endforeach
																@endif
															 </tbody>
														 </table>

			                    </div>

			                </div>
			            </div>
			            <div class="modal-footer">
			                <button id="enviar_todo" class="btn btn-success btn-icon">
			                    Enviar<i class="fa fa-floppy-o icon-btn"></i>
			                </button>
			                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
			            </div>

			        </div><!-- /.modal-content -->
			    </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

    </div>

	</body>

	@include('scripts.scripts')

	<script src="{{url('bootstrap-fileinput-master\js\plugins\canvas-to-blob.min.js')}}" type="text/javascript"></script>

	<script src="{{url('bootstrap-fileinput-master\js\plugins\sortable.min.js')}}" type="text/javascript"></script>

	<script src="{{url('bootstrap-fileinput-master\js\plugins\purify.min.js')}}" type="text/javascript"></script>
	<script src="{{url('bootstrap-fileinput-master\js\fileinput.min.js')}}"></script>
	<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
	<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
	<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script>
	function IsEmail(email) {
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!regex.test(email)) {
				console.log('false')
				 return false;
			}else{
				console.log('true')
				 return true;
			}
		}
	</script>
<script type="text/javascript">



	/*$('#proveedor_search').change(function() {

		var value = $(this).val();

		if(value=='3' || value=='1,3' || value=='2,3' || value=='1,2,3'){

			//Habilitar tarifas
			//alert('Tiene tarifa seleccionado');
			//$('#shortModal33').modal('show')


		}else{

		}

	});*/

	$('#proveedor_search').change(function() {

		var value = $(this).val();

		var nombre = $(this).val();
		var direccion = $('#direccion').val();
		var solicitante = $('#solicitante').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var ciudad = $('#ciudad').val();

		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}



	});

	$('.select_all').change(function(e){

      if ($(this).is(':checked')) {
          $('#clientes_fuec tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 0:

                          $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);

                      break;
                  }
              });
          });
      }else if(!$(this).is(':checked')){
          $('#clientes_fuec tbody tr').each(function(index){
              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 0:

                          $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);

                      break;
                  }
              });
          });
      }
  });

	//$('#nombre_empresa').
	$('#nombre_empresa').keyup(function(e){

    var nombre = $(this).val();
		var direccion = $('#direccion').val();
		var solicitante = $('#solicitante').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var ciudad = $('#ciudad').val();
		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	$('#direccion').keyup(function(e){

    var direccion = $(this).val();
		var nombre = $('#nombre_empresa').val();
		var solicitante = $('#solicitante').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var ciudad = $('#ciudad').val();

		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	$('#solicitante').keyup(function(e){

    var solicitante = $(this).val();
		var nombre = $('#nombre_empresa').val();
		var direccion = $('#direccion').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();
		var ciudad = $('#ciudad').val();

		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	$('#email').keyup(function(e){

    var email = $(this).val();
		var nombre = $('#nombre_empresa').val();
		var solicitante = $('#solicitante').val();
		var direccion = $('#direccion').val();
		var telefono = $('#telefono').val();
		var ciudad = $('#ciudad').val();

		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	$('#telefono').keyup(function(e){

    var telefono = $(this).val();
		var nombre = $('#nombre_empresa').val();
		var solicitante = $('#solicitante').val();
		var direccion = $('#direccion').val();
		var email = $('#email').val();
		var ciudad = $('#ciudad').val();

		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		console.log(ciudad)

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	$('#ciudad').change(function(e){

    var ciudad = $(this).val();
		var nombre = $('#nombre_empresa').val();
		var solicitante = $('#solicitante').val();
		var direccion = $('#direccion').val();
		var email = $('#email').val();
		var telefono = $('#telefono').val();

		var value = $('#proveedor_search').val();
		if(value=='1' || value=='2' || value=='1,2' || value=='1,3' || value=='1,2,3' || value=='2,3'){
			value = 1;
		}else{
			value = 0;
		}

		if(nombre!='' && direccion!='' && solicitante!='' && email!='' && direccion!='' && telefono!='' && ciudad!=0 && IsEmail(email)==true && value==1){
			$('#enviar_portafolio').removeAttr('disabled', 'disabled');
		}else{
			$('#enviar_portafolio').attr('disabled', 'disabled');
		}

  });

	//Enviar Portafolio Email
	$('#enviar_portafolio').click(function(e){
		e.preventDefault();

		var nombre_empresa = $('#nombre_empresa').val().trim().toUpperCase();
		var ciudad = $('#ciudad option:selected').html();
		var telefono = $('#telefono').val();
		var direccion = $('#direccion').val().trim().toUpperCase();
		var solicitante = $('#solicitante').val().trim().toUpperCase();
		var email = $('#email').val().trim().toUpperCase();
		var value = $('#proveedor_search').val();
		//alert(value)
		if(value=='3' || value=='1,3' || value=='2,3' || value=='1,2,3'){

			if(value=='1,2' || value=='1,2,3'){
				value = 3;
			}else if(value=='2'){
				value = 2;
			}else if(value=='1'){
				value = 1;
			}

			//alert(value)

			$('#enviar_todo').attr('nombre_empresa',nombre_empresa);
			$('#enviar_todo').attr('ciudad',ciudad);
			$('#enviar_todo').attr('telefono',telefono);
			$('#enviar_todo').attr('direccion',direccion);
			$('#enviar_todo').attr('solicitante',solicitante);
			$('#enviar_todo').attr('email',email);
			$('#enviar_todo').attr('portafolios_enviar',value);

			$('#shortModal33').modal('show');

		}else{

			if(value==null){

				$.confirm({
	          title: 'Atención',
	          content: 'No has seleccionado ningún portafolio',
	          buttons: {
	              confirm: {
	                  text: 'Cerrar',
	                  btnClass: 'btn-danger',
	                  keys: ['enter', 'shift'],
	                  action: function(){



	                  }

	              },
	              cancel: {
	                text: 'Volver',
	              }
	          }

	        });

			}else{

				//alert(value)

				if(value=='1'){//solo ejecutivos
					value = 1;
				}else if(value=='2'){ //solo rutas
					value = 2;
				}else if(value=='1,2'){ //ejecutivos y rutas
					value = 3;
				}

				/*if(value=='1,2' || value=='1,2,3'){
					value = 3;
				}else if(value=='2'){
					value = 2;
				}else if(value=='1'){
					value = 1;
				}*/

				$.confirm({
	          title: 'Atención',
	          content: 'Estás intentando enviar un portafolio sin tarifas.<br>¿Quieres continuar?',
	          buttons: {
	              confirm: {
	                  text: 'Si',
	                  btnClass: 'btn-danger',
	                  keys: ['enter', 'shift'],
	                  action: function(){

											//sin tarifas
											formData = new FormData($('#formularioportafolio')[0]);
											formData.append('nombre_empresa',nombre_empresa);
											formData.append('ciudad',ciudad);
											formData.append('telefono',telefono);
											formData.append('solicitante',solicitante);
											formData.append('email',email);
											formData.append('direccion',direccion);
											formData.append('portafolios_enviar',value);
											formData.append('sw_tarifas',0);

											//formData.append('idArray',idArray);
											//formData.append('traslado',traslado);
											//formData.append('valorAuto',valorAuto);
											//formData.append('valorVan',valorVan);

											$.ajax({
													method: "post",
													url: "../reportes/enviarportafolio",
													data: formData,
													processData: false,
													contentType: false,
													success: function(data) {

														if(data.respuesta===false){

															$('#enviar_portafolio').removeClass('hidden');
															$('#loading').addClass('hidden');
															$('#enviado').addClass('hidden');

														}else if(data.respuesta===true){

															$('#enviar_portafolio').addClass('hidden');
															$('#loading').addClass('hidden');
															$('#enviado').removeClass('hidden');

															$.confirm({
																	title: 'Atención',
																	content: '¡Portafolio enviado al correo '+email+' satisfactoriamente!',
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

														}else if(data.respuesta==='relogin'){
																location.reload();
														}else{
																$('#enviar_portafolio').removeClass('hidden');
																$('#loading').addClass('hidden');
																$('#enviado').addClass('hidden');

																$('.errores-modal ul li').remove();
																$('.errores-modal').addClass('hidden');
														}

													}
											});
											//sin tarifas

	                  }

	              },
	              cancel: {
	                text: 'Volver',
	              }
	          }

	        });

			}

		}


		//console.log(portafolios_enviar)
		/*if(portafolios_enviar=='0'){

			$.confirm({
					title: 'Atención!',
					content: 'Es obligatorio seleccionar los portafolios a enviar...',
					buttons: {
							confirm: {
									text: 'Cerrar',
									btnClass: 'btn-danger',
									keys: ['enter', 'shift'],
									action: function(){

									}

							}
					}
			});

		}else{

			$('#enviar_portafolio').addClass('hidden');
			$('#loading').removeClass('hidden');
			$('#enviado').addClass('hidden');



		}*/

	});

	$('#enviar_todo').click(function(e) {

		var idArray = [];
		var traslado = [];
		var valorAuto = [];
		var valorVan = [];

    e.preventDefault();

		$('#clientes_fuec tbody tr').each(function(index){

			var valorCheckbox = $(this).find('td input[type="checkbox"]').attr('check');

      $(this).children("td").each(function (index2){
					var valorCheckbox2 = $(this).find('input[type="checkbox"]').attr('check');

          switch (index2){
              case 0:
                  var $objeto = $(this).find('.clients');

                  if ($objeto.is(':checked')) {
                      idArray.push($objeto.attr('data-id'));
											traslado.push($objeto.attr('data-traslado'));
											valorAuto.push($objeto.attr('data-auto'));
											valorVan.push($objeto.attr('data-van'));
                  }

              break;
          }
      });

    });
		var text = '';
		for (var i = 0; i < traslado.length; i++) {
			text+='<b>'+traslado[i]+'</b><br>'
		}

		var nombre_empresa = $('#enviar_todo').attr('nombre_empresa');
		var ciudad = $('#enviar_todo').attr('ciudad');
		var telefono = $('#enviar_todo').attr('telefono');
		var direccion = $('#enviar_todo').attr('direccion');
		var solicitante = $('#enviar_todo').attr('solicitante');
		var email = $('#enviar_todo').attr('email');
		var portafolios_enviar = $('#enviar_todo').attr('portafolios_enviar');

		$.confirm({
				title: 'Atención',
				content: '¡Estás seguro de enviar estas tarifas?<br><br>'+text,
				buttons: {
						confirm: {
								text: '¡Estoy seguro!',
								btnClass: 'btn-success',
								keys: ['enter', 'shift'],
								action: function(){

									formData = new FormData($('#formularioportafolio')[0]);
									formData.append('nombre_empresa',nombre_empresa);
									formData.append('ciudad',ciudad);
									formData.append('telefono',telefono);
									formData.append('solicitante',solicitante);
									formData.append('email',email);
									formData.append('direccion',direccion);
									formData.append('portafolios_enviar',portafolios_enviar);
									formData.append('sw_tarifas',1);

									formData.append('idArray',idArray);
									formData.append('traslado',traslado);
									formData.append('valorAuto',valorAuto);
									formData.append('valorVan',valorVan);

									$.ajax({
											method: "post",
											url: "../reportes/enviarportafolio",
											data: formData,
											processData: false,
											contentType: false,
											success: function(data) {

												if(data.respuesta===false){

													$('#enviar_portafolio').removeClass('hidden');
													$('#loading').addClass('hidden');
													$('#enviado').addClass('hidden');

												}else if(data.respuesta===true){

													$('#enviar_portafolio').addClass('hidden');
													$('#loading').addClass('hidden');
													$('#enviado').removeClass('hidden');

													$.confirm({
															title: 'Atención',
															content: '¡Portafolio enviado al correo '+email+' satisfactoriamente!',
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

												}else if(data.respuesta==='relogin'){
														location.reload();
												}else{
														$('#enviar_portafolio').removeClass('hidden');
														$('#loading').addClass('hidden');
														$('#enviado').addClass('hidden');

														$('.errores-modal ul li').remove();
														$('.errores-modal').addClass('hidden');
												}

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

<script language="JavaScript" type="text/JavaScript">

  $(document).on('ready', function() {
    $("#input-44").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240
    });
  });

  $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6, #datetimepicker3').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });

    $('#datetimepicker8').datetimepicker({
        format: 'HH:mm',
        locale: 'es',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });


</script>
</html>
