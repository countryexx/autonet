<html>
	<head>
	    <meta charset="UTF-8">
	    <meta name="url" content="{{url('/')}}">
	    <title>Autonet | Respuesta a PQR</title>
	    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	    @include('scripts.styles')
	    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
	    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
      <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
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
          <li><a href="{{url('reportes/pqr')}}">Crear Pqr</a></li>
          <li><a href="{{url('reportes/listadopqr')}}">Listado Pqr</a></li>
        </ol>
      </div>
      <br>
      <div class="col-lg-12">
      <form id="formulariopqr">
        <div style="margin-top: 25px">
          <strong class="h_titulo" >RESPUESTA A PQR</strong>
          <!--<button data-option="1" id="whatsapp" class="btn btn-success btn-icon">Enviar Whatsapp<i class="fa fa-whatsapp icon-btn"></i></button>-->
        </div>

      <div class="row">

          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
              <div class="panel panel-default">
                  <div class="panel-heading" style="background-color: gray; color: white">Datos del Reclamante</div>
                  <div class="panel-body">
                      <div class="row">
                        <div class='col-lg-4 col-md-3 col-sm-3 col-xs-6'>
                          <label for="fecha">Fecha de solicitud</label>
                          <div class="input-group">
                            <div class="input-group date" id='datetimepicker1'>
                                <input type='text' class="form-control input-font" id="fecha_inicial" value="">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                          </div>
                        </div >
                        <div class='col-lg-3 col-md-2 col-sm-2 col-xs-6'>
                          <label for="tiposolicitud" class="obligatorio">Tipo Solicitud</label>
                          <select class="form-control input-font" name="tiposolicitud" id="tiposolicitud">
                              <option value="0">-</option>
                              <option value="1">Queja</option>
                              <option value="2">Novedad</option>
                              <option value="3">Petición</option>
                          </select>
                        </div>
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                          <label for="nombres" class="obligatorio">Nombre / Organización</label>
                          <select class="form-control input-font" name="cliente" id="cliente">
                              <option value="0">Seleccionar Cliente</option>
                              @foreach($centrosdecosto as $centro)
                                <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                              @endforeach
                          </select>
                        </div>

                      </div>
                      <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-6">
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
                        <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 ">
                          <label for="telefono" class="obligatorio">Teléfono</label>
                          <input class="form-control input-font" type="text" name="telefono" id="telefono">
                        </div>
                        <div class="col-lg-4 col-md-2 col-sm-2 col-xs-4 ">
                          <label for="telefono" class="obligatorio">Dirección</label>
                          <input class="form-control input-font" type="text" name="direccion" id="direccion">
                        </div>
                        <div class='col-lg-6 col-md-5 col-sm-5 col-xs-12'>
                          <label for="email" class="obligatorio">Solicitante</label>
                          <input class="form-control" name="solicitante" type="solicitante" id="solicitante">
                        </div>
                        <div class='col-lg-6 col-md-5 col-sm-5 col-xs-12'>
                          <label for="email" class="obligatorio">Correo Electrónico</label>
                          <input class="form-control" name="email" type="email" id="email">
                        </div>
                      </div>
                      <div class="row" >
                        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6" style="margin: 15px 0 0 0">
                          <label for="descriptionserv" class="obligatorio">Descripción de la Ocurrencia</label>
                          <textarea name="info" id="info" rows="20" cols="50" class="form-control"></textarea>
                        </div>


                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-6">
                          <label for="ciudad" class="obligatorio">Tipo de Novedad</label>
                          <select class="form-control input-font" name="novedad" id="novedad">
                            <option value="0">Seleccionar Novedad</option>
                            <option>LLEGADA TARDE</option>
                            <option>RECOGIDA TARDE</option>
                            <option>NO RECOGIDA</option>
                            <option>PRESUNTO ACOSO</option>
                            <option>CALIDAD DE SERVICIO</option>
                            <option>SIN AUTORIZACION</option>
                            <option>MANEJO PELIGROSO</option>
                            <option>USO INADECUADO DEL LENGUAJE</option>
                            <option>FALLAS MECANICAS</option>
                            <option>ACCIDENTE</option>
                            <option>INCIDENTE</option>
                            <option>NO TOMA SERVICIO</option>
                            <option>NO APLICA</option>
                          </select>
                        </div>
                        <div class="col-lg-6 hidden campana">
                          <label for="ciudad" class="obligatorio">Campaña</label>
                          <select class="form-control input-font" name="campana" id="campana">
                            <option value="0">Seleccionar Campaña</option>
                            <option class="19 hidden">AT&T CLG Mobility Spanish - Barranquilla</option>
                            <option class="19 hidden">AT&T DTV Spanish - Barranquill</option>
                            <option class="19 hidden">CreditShop 1stParty Collection</option>
                            <option class="19 hidden">Oportun Inc Support</option>
                            <option class="19 hidden">Opportunity Fund Pre-Funding</option>
                            <option class="19 hidden">Remitly CET IS BAQ</option>
                            <option class="19 hidden">SLB</option>
                            <option class="19 hidden">AT&T LCBB - Barranquilla</option>
                            <option class="19 hidden">Credito Real USA Finance</option>
                            <option class="19 hidden">CreditOne SPA Recovery</option>
                            <option class="19 hidden">GTI</option>
                            <option class="19 hidden">TELCO</option>
                            <option class="287 hidden">T-MOBILE</option>
                            <option class="287 hidden">AIRBNB</option>
                            <option class="287 hidden">GODADDY</option>
                            <option class="287 hidden">CAPITAL ONE</option>
                            <option class="287 hidden">HUMANA</option>
                            <option class="287 hidden">DIRECTV</option>
                            <option class="287 hidden">AUTO FINANCE COLLETIONS</option>
                            <option class="287 hidden">NEXA CUSTOME CARE</option>
                            <option class="287 hidden">SPOTIFY EMAIL SUPPORT</option>

                          </select>
                        </div>
                      </div>

                  </div>
              </div>

          </div>

          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
              <div class="panel panel-default">
                  <div class="panel-heading" style="background-color: gray; color: white">Descripción del Servicio (Si lo conoce)</div>
                  <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-6 ">
                          <label for="servicio" class="obligatorio">N° Servicio</label>
                          <input class="form-control input-font" type="text" name="servicio" id="servicio">
                        </div>
                        <!--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 ">
                          <label for="ruta">Ruta</label>
                          <input class="form-control input-font" type="text" name="ruta" id="ruta">
                        </div>-->
                        <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6 ">
                          <label for="placa">Placa</label>
                          <input class="form-control input-font" type="text" name="placa" id="placa">
                        </div>
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-6">
                          <label for="conductor">Colaborador al Volante</label>
                          <input class="form-control input-font" type="text" name="conductor" id="conductor">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                          <label for="tiposerv" class="obligatorio">Tipo de Servicio</label>
                          <select class="form-control input-font" name="tiposerv" id="tiposerv">
                            <option value="0">-</option>
                            <option value="1">Ejecutivo</option>
                            <option value="2">Ruta Entrada</option>
                            <option value="3">Ruta Salida</option>
                          </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
                          <label for="fecha" class="obligatorio">Fecha de Ocurrencia</label>
                          <div class="input-group">
                            <div class="input-group date" id='datetimepicker1'>
                                <input type='text' class="form-control input-font" id="fecha_ocurrencia" value="">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6" style="margin: 15px 0 0 0">

                          <label for="hora_servicio">Hora de Servicio</label>
                          <div class="input-group">
                              <div class="input-group date" id="datetimepicker8">
                                  <input type="text" class="form-control input-font" id="info2">
                          <span class="input-group-addon">
                              <span class="fa fa-clock-o">
                              </span>
                          </span>
                              </div>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-lg-12 col-md-7 col-sm-7 col-xs-6" style="margin: 15px 0 0 0">

                          <label for="hora_servicio">Soporte de PQR</label>

                          <input type="file" name="soporte_pqr" id="soporte_pqr" accept="image/png, image/gif, image/jpeg" value="Subir" style="margin-top: 25px">

                        </div>
                      </div>

                  </div>
              </div>

          </div>

              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
                  <div class="panel panel-default">
                      <div class="panel-heading" style="background-color: gray; color: white">Evidencias de pqr (Si es aplicable)</div>
                        <div class="panel-body" style="height: 80%">

                            <div class="col-lg-12" style="margin-top: 20px; height: 400px">
                              <input id="input-44" name="archivos[]" type="file" multiple class="file-loading" >
                              <!--<span>Inserta aquí las imágenes del Vehículo 1.<br><hr></span>-->
                            </div>

                      </div>
                  </div>
                  <input type="checkbox" name="aceptar_politicas" style="vertical-align: sub; float: right;">
                  @if ($errors->has('aceptar_politicas'))
                      <br><small class="text-danger">{{$errors->first('aceptar_politicas')}}</small>
                  @endif
                  <label style="margin-right: 5px; float: right; float: right;">Autorizo a que me puedan responder a mi correo electrónico.</label>
              </div>

      </div>
    </div>

        <div class="modal-footer">
          <div class="col-xs-4">
            <div >

                <!--<input id="excel_ruta" type="file" value="Subir" name="excel">-->
            </div>
          </div>
          <button id="enviarpqr" type="button" class="btn btn-success btn-icon">Enviar PQR<i class="fa fa-send icon-btn"></i></button>
        </div>

      </form>
      </div>

      <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
      </div>
    <div class="guardado bg-success text-success hidden model">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul style="margin: 0;padding: 0;">
        </ul>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script></script>


<script language="JavaScript" type="text/JavaScript">

  $(document).on('ready', function() {

    $("#input-44").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240
    });

  });

  function selODessel(obj){
    if(obj.checked){
        console.log("chulado")
    }else{
        //desSeleccionarTodos();
        console.log("DesChulado")
    }
  }

  function seleccionarTodos(){
    alert("Selecciono todos")
  }
  function desSeleccionarTodos(){
    alert("Desselecciono todos")
  }

  $('#whatsapp').click(function(){

    $.ajax({
      url: 'sendemail',
      method: 'post',
      data: {cantidad: 0}
    }).done(function(data){

      if(data.respuesta==true){
        alert('Success!!!')
      }else if(data.respuesta==false){

      }

    });

  });

  $('#cliente').change(function() {

    var id = $(this).val();
    console.log(id);

    if(id==='19' || id ==='287') {
      $('.campana').removeClass('hidden');
      if(id==='19'){
        $('.19').removeClass('hidden');
        $('.287').addClass('hidden');
      }else{
        $('.19').addClass('hidden');
        $('.287').removeClass('hidden');
      }
    }else{
      $('.campana').addClass('hidden');
    }

    $.ajax({
      url: 'consultarcliente',
      method: 'post',
      data: {id: id}
    }).done(function(data){

      if(data.respuesta==true){

        $('#email').val(data.cliente.email)
        $('#direccion').val(data.cliente.direccion)
        $('#telefono').val(data.cliente.telefono)
        $('#ciudad').val(data.cliente.ciudad)

      }else if(data.respuesta==false){

      }

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


  //Enviar PQR Email
  $('#enviarpqr').click(function(e){
        e.preventDefault();
        if(!($('.errores-modal').hasClass('hidden'))){
            $('.errores-modal').addClass('hidden');
        }

        var fecha_solicitud = $('#fecha_inicial').val();
        var tipo_solicitud = $('#tiposolicitud option:selected').html();
        var nombre = $('#cliente option:selected').html();
        var ciudad = $('#ciudad option:selected').html();
        var telefono = $('#telefono').val();
        var direccion = $('#direccion').val();
        var correo = $('#email').val();
        var solicitante = $('#solicitante').val();
        var descripcionOcurrencia = $('#info').val();
        var tipoNovedad = $('#novedad').val();

        var tiposerv = $('#tiposerv option:selected').html();
        var fecha_solicitud = $('#fecha_inicial').val();
        var fecha_ocurrencia = $('#fecha_ocurrencia').val();

        console.log(fecha_solicitud)

        formData = new FormData($('#formulariopqr')[0]);
        formData.append('nombres',$('#cliente option:selected').html().trim().toUpperCase());
        formData.append('cliente_id',$('#cliente option:selected').val().trim().toUpperCase());
        formData.append('telefono',$('#telefono').val().trim().toUpperCase());
        formData.append('fecha_inicial',$('#fecha_inicial').val());
        formData.append('fecha_ocurrencia',$('#fecha_ocurrencia').val());
        formData.append('tiposolicitud',$('#tiposolicitud option:selected').html().trim().toUpperCase());
        formData.append('email',$('#email').val().trim().toUpperCase());
        formData.append('solicitante',$('#solicitante').val().trim().toUpperCase());
        formData.append('ciudad',$('#ciudad option:selected').html().trim().toUpperCase());
        formData.append('direccion',$('#direccion').val().trim().toUpperCase());
        formData.append('info',$('#info').val().trim().toUpperCase());

        formData.append('info2',$('#info2').val().trim().toUpperCase());
        formData.append('tiposerv',$('#tiposerv option:selected').html().trim().toUpperCase());
        formData.append('conductor',$('#conductor').val().trim().toUpperCase());
        formData.append('placa',$('#placa').val().trim().toUpperCase());
        //formData.append('ruta',$('#ruta').val().trim().toUpperCase());
        formData.append('servicio',$('#servicio').val().trim().toUpperCase());

        formData.append('campana',$('#campana').val().trim().toUpperCase());
        formData.append('novedad',$('#novedad').val().trim().toUpperCase());

        /*formData.append('nombres_r',$('#nombres_r').val().trim().toUpperCase());
        formData.append('apellidos_r',$('#apellidos_r').val().trim().toUpperCase());
        formData.append('direccion_r',$('#direccion_r').val().trim().toUpperCase());
        formData.append('telefono_r',$('#telefono_r').val().trim().toUpperCase());
        formData.append('correo_r',$('#correo_r').val().trim().toUpperCase());*/


        $.ajax({
            method: "post",
            url: "pqr/pqr",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {

                if(data.mensaje===false){

                    if(!($('.guardado').hasClass('hidden'))){
                        $('.guardado').addClass('hidden');
                    }

                    $('.errores-modal ul li').remove();
                    for(i in data.errores){
                        var string = JSON.stringify(data.errores[i]);
                        var clean = string.split('"').join('')
                            .split('.').join('<br>')
                            .split(',').join('<li>')
                            .split('[').join('')
                            .split(']').join('');

                        $('.errores-modal').removeClass('hidden');
                        $('.errores-modal ul').append('<li>'+clean+'</li>');
                    }
                }else if(data.mensaje===true){

                  $.confirm({
                    title: 'Atención',
                    content: 'PQR generada y enviada al cliente',
                    buttons: {
                        confirm: {
                            text: 'Ok',
                            btnClass: 'btn-success',
                            keys: ['enter', 'shift'],
                            action: function(){

                              //location.reload();

                            }

                        }
                    }
                });

                }else if(data.respuesta==='relogin'){
                    location.reload();
                }else{
                    $('.errores-modal ul li').remove();
                    $('.errores-modal').addClass('hidden');
                }
            }
        });

    });


</script>
</html>
