<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios Temporales</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">

      <h4 class="h_titulo" style="font-size: 25px;"><b style="font-size: 20px;">Generación de Links temporales</b></h4>

      <div class="row">

        <div class="col-lg-4 col-md-4 col-sm-4">
          <div class="panel panel-default">
              <div class="panel-heading"><span style="font-size: 15px;"><b style="font-size: 20px;">Ingreso de Datos</b></span></div>
              <div class="panel-body">
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b>Fecha:</b></span>
                      <div class='input-group date' id='datetimepicker1'>
                          <input name="fecha" id="fecha" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                      </div>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b>Desde:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="desde">
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b>Hasta:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="hasta">
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b>Ciudad:</b></span>
                      <select style="width: 200px;" class="form-control input-font" name="servicios" id="ciudad">
                        <option value="0">Seleccionar</option>
                        <option value="1">BARRANQUILLA</option>
                        <option value="2">BOGOTA</option>
                    </select>
                  </div>
                  <div class="input-group margin_input">
                      <span class="input-group-addon" id="basic-addon1"><b>Correo:</b></span>
                      <input class="form-control input-font" aria-describedby="basic-addon1" id="correo">
                  </div>

                  <button style="float: right;" id="save" class="btn btn-default btn-icon">
                    Enviar<i class="fa fa-send icon-btn"></i>
                </button>
              </div>
          </div>
        </div>

      </div>
        
    </div>

    @include('scripts.scripts')
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

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

      $('#save').click(function() {

        var fecha = $('#fecha').val();
        var desde = $('#desde').val();
        var hasta = $('#hasta').val();
        var ciudad = $('#ciudad option:selected').html();
        var correo = $('#correo').val();

        console.log('test save '+fecha+' , '+desde+ ' , '+hasta+ ' , '+ciudad+ ' , '+correo)

        $.ajax({
            url: '../reportes/guardarlink',
            method: 'post',
            data: {'fecha': fecha, 'hasta': hasta, 'ciudad': ciudad, 'correo': correo},
            success: function(data){

                if (data.respuesta===true) {

                    

                }
            }
        });

      });

    </script>
  </body>
</html>
