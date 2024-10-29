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
  <style>
        .btn-file{
          padding: 8px 7px 9px !important;
        }
        .fileinput-upload{
          display: none;
          padding: 8px 8px 7px;
        }
        .fileinput-remove{
          padding: 8px 7px 7px;
        }
        .kv-file-upload{
          display: none;
        }
  </style>

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
              <form id="formulario">
                <div class="col-xs-2">
                    <label for="fecha">Fecha</label>
                    <input disabled class="form-control input-font" type="text" value="{{date('Y-m-d')}}">
                </div>
                <div class="col-xs-2">
                    <label for="fecha">Fecha Vencimiento</label>
                    <div class="input-group">
                      <div class="input-group date" id="datetimepicker1">
                          <input id="fecha_vencimiento" value="{{date('Y-m-d')}}" name="fecha_vencimiento" style="width: 115;" type="text" class="form-control input-font">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="obligatorio" for="nombre_completo">Nombre Completo o Razon social</label>
                    <input id="nombre_completo" class="form-control input-font"></label>
                </div>
                <div class="col-lg-2">
                  <label class="obligatorio" for="identificacion">Nit o Identificacion</label>
                  <input id="identificacion" class="form-control input-font"></label>
                </div>
                <div class="col-lg-2">
                  <label class="obligatorio" for="direccion">Direccion</label>
                  <input id="direccion" class="form-control input-font"></label>
                </div>
                <div class="col-lg-2">
                  <label class="obligatorio" for="telefono">Celular o Telefono</label>
                  <input id="telefono" class="form-control input-font"></label>
                </div>
                <div class="col-lg-3">
                  <label for="contacto">Contacto</label>
                  <input type="text" id="contacto" class="form-control input-font">
                </div>
                <div class="col-lg-3">
                  <label for="email">Email</label>
                  <input id="email" class="form-control input-font"></label>
                </div>
                <div class="col-lg-4">
                  <label class="obligatorio" for="asunto">Asunto</label>
                  <input id="asunto" class="form-control input-font"></label>
                </div>
                <div class="col-lg-2">
                  <label class="obligatorio" for="tipo">Tipo</label>
                  <select  id="tipo" class="form-control input-font">
                    <option value="0">-</option>
                    <option value="1">TRANSPORTE</option>
                    <option value="2">PLAN TURISTICO</option>
                    <option value="3">AMBAS</option>
                  </select>
                </div>
                <div class="col-lg-3">
                  <label class="obligatorio" for="vendedor">Vendedor</label>
                  <input id="vendedor" class="form-control input-font" type="text">
                </div>
                <div class="col-lg-2">
                  <label for="enviar">Enviar Mail</label>
                  <select id="enviar" class="form-control input-font">
                      <option value="0">-</option>
                      <option value="1">SI</option>
                      <option value="2">NO</option>
                  </select>
                </div>
                <div class="col-lg-12" style="margin-top: 5px;">
                    <input id="input-44" name="archivos[]" type="file" multiple class="file-loading">
                </div>
                <div style="margin-top: 15px" class="col-lg-12">
                  <textarea>
                  </textarea>
                </div>
                <div class="col-lg-12" style="margin-top: 15px">
                  <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <input id="observaciones" class="form-control input-font" name="observaciones" cols="40" rows="5">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(isset($permisos->comercial->cotizaciones->crear))
                        @if($permisos->comercial->cotizaciones->crear==='on')
                            <button type="button" class="btn btn-primary btn-icon" id="nueva_cotizacion">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                        @else
                            <button type="button" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                    @endif

                    <button type="button" class="btn btn-info btn-icon" id="sumar">SUMAR<i class="fa fa-plus icon-btn"></i></button>
                    <button type="button" class="btn btn-info btn-icon" id="multiplicar">MULTIPLICA<i class="fa fa-close icon-btn"></i></button>
                </div>
            </form>
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

  <!--<script type="text/javascript">
  editor_config.selector = "textarea";
  tinymce.init(editor_config);
  </script>-->
  <script type="text/javascript">

  $("#nombre_completo").autocomplete({
      source: 'cotizaciones/clientes',
      select: function(event, ui) {
        $.ajax({
          url: 'cotizaciones/tomarcliente',
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
    $("#input-44").fileinput({
        uploadUrl: '/file-upload-batch/2',
        maxFilePreviewSize: 10240
    });
  });
  </script>
  </body>
</html>
