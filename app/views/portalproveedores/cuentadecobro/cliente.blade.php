<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Servicios por Cobrar</title>
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
        <h3 class="h_titulo">RUTAS REALIZADAS DEL {{$mes_actual}} AL {{$mes_atras}}</h3>
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
                        <a>{{$ruta->nombresubcentro}}</a><br><span>{{$ruta->detalle_recorrido}}</span>
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
                        	@if($ruta->valor_proveedor!=null)
                        		<?php $total = $total+$ruta->total_pagado; ?>
                        		<input type="text" disabled="true" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor a cobrar" value="{{$ruta->valor_proveedor}}">
                            <div class="alert_planilla"></div>
                        	@else
                                @if($ruta->liquidado!=null)
                        		    <input type="text" class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Ingresar valor a cobrar">
                                    <div class="alert_planilla"></div>
                                @else
                                    <input type="text" disabled class="form-control input-font valor_cobrado1" id="valor_cobrado" placeholder="Servicio no revisado">
                                    <div class="alert_planilla"></div>
                                @endif
                        	@endif
                        </td>
                        <td>
                            @if($ruta->valor_proveedor!=null)
                                <!-- TEST BOTÓN GUARDAR -->
                                <a title="GUARDAR VALOR" id="registrar_valor" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-primary registrar_valor disabled"><i class="fa fa-save" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN GUARDAR -->

                                <!-- TEST BOTÓN EDITAR -->
                                  <a title="EDITAR VALOR" id="editar_valor" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-warning editar_valor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN EDITAR -->
                            @else

                            @if($ruta->numero_planilla!=null)
                                <!-- TEST BOTÓN GUARDAR -->
                                <a title="GUARDAR VALOR" id="registrar_valor" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-primary registrar_valor"><i class="fa fa-save" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN GUARDAR -->
                            @else
                                <!-- TEST BOTÓN GUARDAR -->
                                <a title="GUARDAR VALOR" id="registrar_valor" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-danger disabled registrar_valor"><i class="fa fa-save" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN GUARDAR -->
                            @endif

                                <!-- TEST BOTÓN EDITAR -->
                                  <a title="EDITAR VALOR" id="editar_valor" data-id="{{$ruta->id}}" data-cuenta="{{$ruta->id}}" nombre="" class="btn btn-warning disabled editar_valor"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <!-- TEST BOTÓN EDITAR -->
                            @endif
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

                     		<a id="calcular12" class="btn btn-primary btn-icon input-font">Sumar<i class="fa fa-money icon-btn"></i></a>

                     	<a id="habilitarcampos1122" class="btn btn-danger btn-icon input-font hidden">Habilitar Campos<i class="fa fa-pencil icon-btn"></i></a>
                         
                     	<!--<a id="guardartotal1" class="btn btn-success btn-icon input-font disabled">ENVIAR CUENTA DE COBRO <i class="fa fa-share-square icon-btn" aria-hidden="true"></i></a>-->

                    </div>
                </div>
                <div class="col-xs-2">
                    <form class="formulario_ss">
                        <span class="number">Seguridad Social</span>
                        <input id="seguridad_soc" accept="application/pdf" class="seguridad_soc" type="file" value="Subir" name="seguridad_soc" >
                    </form>
                </div>
                <div class="col-xs-2 col-xs-offset-4">
                    
                <button type="button" data-number="1" id="guardartotal1" disabled class="guardartotal1">Enviar <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
        	</div>
            <div class="row" style="margin-bottom: 50px">
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

    function number_formato(number, decimals, dec_point, thousands_sep) {

        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
          var k = Math.pow(10, prec);
          return '' + (Math.round(n * k) / k)
            .toFixed(prec);
        };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
             s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    $('#guardartotal1').click(function(e){

      var idArrays = $(this).attr('idArray');
      var valor_cuenta = $(this).attr('valor_cuenta');
      var centrodecosto = $(this).attr('centrodecosto');
      var valores_cobro = $(this).attr('valores_cobro');
      var seguridad_soc = $('#seguridad_soc').val();

      if(seguridad_soc=='' || seguridad_soc==null){
        
        $.confirm({
          title: 'Atención!!!',
          content: 'Adjuntar la seguridad social es obligatorio. <br><br> Por favor, adjunte el documento PDF para poder continuar',
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

        //$(this).attr('disabled','disabled');

        //formData = new FormData($('#formulario_ss')[0]);
        formData = new FormData($('.formulario_ss')[0]);

        formData.append('dataidArray', idArrays);
        formData.append('valor_cuenta', valor_cuenta);
        formData.append('centrodecosto',centrodecosto);
        formData.append('valores_cobro',valores_cobro);
        formData.append('seguridad_soc', seguridad_soc);

        $.confirm({
          title: 'ENVÍO DE CUENTA DE COBRO',
          content: 'Está seguro de enviar los datos?<br><br>Valor: '+number_formato(valor_cuenta)+'',
          buttons: {
              confirm: {
                  text: 'SÍ',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $('#guardartotal1').html('').append('Cargando... <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>').attr('disabled','disabled');

                    $.ajax({
                        url: 'guardarcuentatotal',
                        type: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {

                          if(data.respuesta===true){

                            $('#guardartotal1').html('').append('¡Realizado! <i class="fa fa-check" aria-hidden="true"></i>');
                            $.alert('<span style="font-size: 16px;">¡Cuenta de Cobro enviada con éxito! <br><br>Le avisaremos por correo en cuanto haya novedades o sea aprobada.</span>');
                            //location.reload();
                            setTimeout(function(){
                              location.href = "solicitudactual";
                            }, 6000);
                          }else if(data.respuesta===false){
                            $(this).removeAttr('disabled','disabled');
                            alert('Hubo un error en la ejecución del proceso. Comunícate con el administrador del sistema.');
                            //location.reload();

                          }

                        },
                        error: function (request, status, error) {

                            console.log('Hubo un error, llame al administrador del sistema'+request+status+error);
                            console.log(request.responseText);
                            console.log(status.responseText);
                            console.log(error.responseText);

                        }
                    });
                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }
        });
      }
    });

    $('#calcular12').click(function(e){

      var sw = 0;
      var total = 0;
      var contador = 0;
      e.preventDefault();
      dataidArray = [];
      checkArray = [];

      planillaArray = [];

      $('#rutas_ejecutadas tbody tr').each(function(index){

            $(this).children("td").each(function (index2){

                switch (index2){

                  case 0:
                    if($(this).attr('data-id')!=undefined){
                      dataidArray.push($(this).attr('data-id'));
                    }

                  break;

                  case 7:
                    if($(this).find('input[type="text"]').val()!=undefined){
                      planillaArray.push($(this).find('input[type="text"]').val().trim().replace(',','').replace(',','').replace(',',''));
                    }

                  break;
                }
            });

            //SI LA FILA NO ES DE NOMBRE DE CLIENTE
            if($(this).find('input[type="text"]').val()!=undefined){
              var num = $(this).find('input[type="text"]').val().trim().replace(',','').replace(',','').replace(',','');

              //SI EL CAMPO VALOR ESTÁ VACÍO Ó ES 0
              if(num==0 || num==''){
                sw = 1;
              }
              total = parseInt(total)+parseInt(num);
            }
        });

        if(sw==0){
          $('#valor_total').text('$ '+number_formato(total));
          $('#habilitarcampos1122').removeClass('hidden');

          $(this).addClass('hidden');
          $('.valor_cobrado1').attr('disabled','disabled');
          $('.editar_valor').addClass('disabled')
          $('#guardar, #guardartotal1').removeAttr('disabled').attr('style', 'background: #4bc970');

        }else{
          $('#alert_eliminar').removeClass('hidden');
          $('#contenido_alerta').html('').html('<span style="font-size: 18px">Digite todos los datos...</span>');
        }

        $('#guardar, #guardartotal1').attr('idArray',dataidArray);
        $('#guardar, #guardartotal1').attr('valor_cuenta',total);
        $('#guardar, #guardartotal1').attr('valores_cobro',planillaArray);

    });

    $('#habilitarcampos1122').click(function(e){

      $(this).addClass('hidden');
      $('#calcular12').removeClass('hidden');

      $('#rutas_ejecutadas tbody tr').each(function (index) {//RECORRIDO POR TODA LA TABLA PARA BUSCAR LA FILA SELECCIONADA
        if(!$(this).find('td').eq(8).find('.registrar_valor').hasClass('disabled')){
          $(this).find('td').eq(7).find('.valor_cobrado1').removeAttr('disabled','disabled');
        }else{
          $(this).find('td').eq(8).find('.editar_valor').removeClass('disabled');
        }
      });

      $('#guardartotal1').attr('disabled', 'disabled').attr('style', 'background: red');
      $('#valor_total').text('$ 0');

    });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
</script>

</body>
</html>
