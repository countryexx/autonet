<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Cotizaciones</title>
  </head>
  @include('scripts.styles')
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link href="{{url('bootstrap-fileinput-master\css\fileinput.min.css')}}" media="all" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <body>
  @include('admin.menu')
  <div class="col-lg-12">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-lg-2">
          <div class="row">
    				<ol style="margin-bottom: 5px" class="breadcrumb">
    					<li><a href="{{url('cotizaciones')}}">Inicio</a></li>
    					<li><a href="{{url('cotizaciones/listado')}}">Listado</a></li>
    				</ol>
    			</div>
        </div>
        <div class="col-lg-12">
        	<div class="row">
        		<h3 class="h_titulo">INGRESO DE COTIZACIONES</h3>
        	</div>
        </div>
      </div>
		</div>
    <div class="col-lg-9">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">Cotizaciones</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-2">
                  <label for="fecha">Fecha</label>
                  <input disabled class="form-control input-font" type="text" value="{{$cotizaciones->fecha}}">
              </div>
              <div class="col-xs-2">
                  <label for="fecha">Fecha Vencimiento</label>
                  <div class="input-group">
                    <div class="input-group date" id="datetimepicker1">
                        <input disabled id="fecha_vencimiento" value="{{$cotizaciones->fecha_vencimiento}}" name="fecha_vencimiento" style="width: 115;" type="text" class="form-control input-font">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
              </div>
              <div class="col-lg-4">
                <label class="obligatorio" for="nombre_completo">Nombre Completo o Razon social</label>
                <input disabled id="nombre_completo" class="form-control input-font" value="{{$cotizaciones->nombre_completo}}">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" for="identificacion">Nit o Identificacion</label>
                <input disabled id="identificacion" class="form-control input-font" value="{{$cotizaciones->nit}}">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" for="direccion">Direccion</label>
                <input disabled id="direccion" class="form-control input-font" value="{{$cotizaciones->direccion}}">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" for="telefono">Celular o Telefono</label>
                <input disabled id="telefono" class="form-control input-font" value="{{$cotizaciones->celular}}">
              </div>
              <div class="col-lg-3">
                <label for="contacto">Contacto</label>
                <input disabled type="text" id="contacto" class="form-control input-font" value="{{$cotizaciones->contacto}}">
              </div>
              <div class="col-lg-3">
                <label class="obligatorio" for="email">Email</label>
                <input disabled id="email" class="form-control input-font" value="{{$cotizaciones->email}}">
              </div>
              <div class="col-lg-4">
                <label class="obligatorio" for="asunto">Asunto</label>
                <input disabled id="asunto" class="form-control input-font" value="{{$cotizaciones->asunto}}">
              </div>
              <div class="col-lg-2 hidden">
                <label class="obligatorio" for="tipo">Tipo</label>
                <select disabled id="tipo" class="form-control input-font">
                  <option value="0">-</option>
                  @if(intval($cotizaciones->tipo)===1)
                    <option selected value="1">TRANSPORTE</option>
                  @else
                    <option value="1">TRANSPORTE</option>
                  @endif
                  @if(intval($cotizaciones->tipo)===2)
                    <option selected value="2">PLAN TURISTICO</option>
                  @else
                    <option value="2">PLAN TURISTICO</option>
                  @endif
                  @if(intval($cotizaciones->tipo)===3)
                    <option selected value="3">AMBAS</option>
                  @else
                    <option value="3">AMBAS</option>
                  @endif
                </select>
              </div>
              <div class="col-lg-3">
                <label class="obligatorio" for="vendedor">Vendedor</label>
                <input disabled id="vendedor" class="form-control input-font" type="text" value="{{$cotizaciones->vendedor}}">
              </div>
              <div class="col-lg-12" style="margin-top: 5px;">
                  <input id="input-44" name="archivos[]" type="file" multiple class="file-loading">
              </div>
              <div style="margin-top: 15px" class="col-lg-12">
                <textarea disabled>
                  {{$cotizaciones->contenido_html}}
                </textarea>
              </div>
              <div class="col-lg-12" style="margin-top: 15px">
                <div class="form-group">
                  <label for="observaciones">Observaciones</label>
                  <input value="{{$cotizaciones->observacion}}" disabled id="observaciones" class="form-control input-font" name="observaciones" rows="8">
                </div>
                <!--<div class="politicas">
                  ESPECIFICACIONES TECNICAS<br><br>
                    <ul style="padding: 0 0 0 25px;">
                      <li>Vehículos Full Equipo modelos recientes</li>
                      <li>Vehículos Climatizados</li>
                      <li>Conductores altamente Calificados y Uniformados</li>
                      <li>Conductores comunicados vía celular</li>
                      <li>Seguros Obligatorios</li>
                    </ul><br>
                  POLITICAS DEL SERVICIO:<br><br>
                  <ul style="padding: 0 0 0 25px;">
                    <li>El servicio de transporte cuenta con disponibilidad de 24 horas al día.</li>
                    <li>Las tarifas por horas se cobrarán con un mínimo de 2 (dos) horas.</li>
                    <li>El tiempo de espera se cobrara despues de 15 minutos de la hora programada.</li>
                    <li>Los servicios nocturnos tienen un recargo del 20% (A partir de las 18:00 Horas).</li>
                    <li>La cancelación de un servicio debe efectuarse por escrito con un mínimo de dos horas de anticipación y para viajes con minimo 06 (seis) horas de
                    anticipacion</li>
                    <li>La no cancelación oportuna de un servicio generará el cobro del 100% del valor de las tarifas del servicio contratado.</li>
                    <li>Las tarifas de servicio de aeropuerto no incluyen protocolo de recepcion.</li>
                    <li>El dia a disposicion no incluye recogida en aeropuerto.</li>
                    <li>Las tarifas de servicio de traslado a otra ciudad no incluye día a disposición en la ciudad de destino.</li>
                    <li>Para el traslado al municipio de PUERTO COLOMBIA y otros municipios del norte de la ciudad desde el aeropuerto de Barranquilla o viceversa se
                    adicionara el valor del traslado de aeropuerto local</li>
                    <li>S/C: Sobre Cotizacion</li>
                    <li>Tarifas no aplican para eventos de Carnaval de Barranquilla</li>
                    <li>Tarifas vigentes hasta el 31 de diciembre de 2016</li>
                  </ul>
                </div>-->
              </div>
            </div>
            @if(isset($permisos->comercial->cotizaciones->editar))
              @if($permisos->comercial->cotizaciones->editar==='on')
                  <button type="button" class="btn btn-success btn-icon" id="editar">EDITAR<i class="fa fa-pencil icon-btn"></i></button>
                  <button type="button" data-id="{{$cotizaciones->id}}" class="btn btn-primary btn-icon" disabled id="actualizar">GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
              @else
                 <button type="button" class="btn btn-success btn-icon" disabled>EDITAR<i class="fa fa-pencil icon-btn"></i></button>
                 <button type="button" class="btn btn-primary btn-icon" disabled>GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
              @endif
            @else
                 <button type="button" class="btn btn-success btn-icon" disabled>EDITAR<i class="fa fa-pencil icon-btn"></i></button>
                 <button type="button" class="btn btn-primary btn-icon" disabled>GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
            @endif
            <button type="button" class="btn btn-info btn-icon" id="sumar">SUMAR<i class="fa fa-plus icon-btn"></i></button>
            <button type="button" class="btn btn-info btn-icon" id="multiplicar">MULTIPLICA<i class="fa fa-close icon-btn"></i></button>
            <a onclick="goBack()" class="btn btn-info btn-icon">VOLVER<i class="fa fa-arrow-left icon-btn"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
      <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
      <ul>
      </ul>
  </div>
  @include('scripts.scripts')
  <script src="{{url('bootstrap-fileinput-master\js\plugins\canvas-to-blob.min.js')}}" type="text/javascript"></script>
  <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
       This must be loaded before fileinput.min.js -->
  <script src="{{url('bootstrap-fileinput-master\js\plugins\sortable.min.js')}}" type="text/javascript"></script>

  <script src="{{url('bootstrap-fileinput-master\js\plugins\purify.min.js')}}" type="text/javascript"></script>
  <!-- the main fileinput plugin file -->
  <script src="{{url('bootstrap-fileinput-master\js\fileinput.min.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/cotizaciones.js')}}" type="text/javascript"></script>
  <script src="{{url('tinymce_4.4.1\tinymce\js\tinymce\tinymce.min.js')}}"></script>
  <script src="{{url('tinymce_4.4.1\tinymce\editor.js')}}"></script>
  <script type="text/javascript">

      $("#nombre_completo").autocomplete({
          source: '../../cotizaciones/clientes',
          select: function(event, ui) {
            $.ajax({
              url: '../../cotizaciones/tomarcliente',
              method: 'post',
              data: {
                'valor' : ui.item.value
              },
              async: false,
              success: function(data){

                if (data.respuesta===true) {
                  $('#identificacion').val(data.datos[0].nit);
                  $('#direccion').val(data.datos[0].direccion);
                  $('#telefono').val(data.datos[0].celular);
                  $('#contacto').val(data.datos[0].contacto);
                  $('#email').val(data.datos[0].email);
                }

              }
            });
          }
      });

    function goBack(){
        window.history.back();
    }
  </script>
  <script type="text/javascript">
    $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6').datetimepicker({
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
  </script>
  <script>
  $(document).on('ready', function() {

    <?php
      $nombres = explode(',',$cotizaciones->archivos);
      $string = '';
     ?>

    $("#input-44").fileinput({

        <?php

        if ($cotizaciones->archivos!=null) {
          echo 'initialPreview: [';

            foreach($nombres as $key => $nombre){
                $string .= "'".url('biblioteca_imagenes/archivos_cotizaciones/').'/'.$nombre."',";
            }

            echo  $string;
            echo  '],';
            echo  'initialPreviewAsData: true,';
            echo  'initialPreviewConfig: [';

            $i=0;

            foreach ($nombres as $key => $nombre) {
              echo '{caption: "'.$nombre.'", key: '.$i.'},';
            }

            echo  '],';
                  'deleteUrl: "/site/file-delete",'.
                  'overwriteInitial: false,'.
                  'maxFileSize: 100,'.
                  'initialCaption: "The Moon and the Earth"';

        }else{
          echo "uploadUrl: '/file-upload-batch/2',";
          echo 'maxFilePreviewSize: 10240';
        }
        ?>
    });
  });
  </script>
  </body>
</html>
