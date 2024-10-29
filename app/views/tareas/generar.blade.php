<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Proyecto</title>
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

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

    <style>

      body {
        background-color: lightgray;
      }

      table{
          empty-cells:hide;
      }

    #list1 .form-control {
      border-color: transparent;
    }
    #list1 .form-control:focus {
      border-color: transparent;
      box-shadow: none;
    }
    #list1 .select-input.form-control[readonly]:not([disabled]) {
      background-color: #fbfbfb;
    }
    
    .avatar {
      vertical-align: middle;
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="row" style="margin-left: 6px">
      <h1 class="h2 text-left mt-3 mb-4 pb-3" style="margin-left: 18px">Generar Informe</h1>
      <div class="col-lg-1">

          <div class="input-group" id="datetime_fecha">
              <label class="h5 text-center mt-3 mb-4 pb-3">Fecha Inicial</label>
              <div class='input-group date' id='datetime_fecha'>
                  <input id="fecha_filtro" name="fecha_pago" style="width: 80px;" type='text' class="form-control input-font" placeholder="Fecha" value="">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
          </div>
        
      </div>
      <div class="col-lg-1">
        <div class="input-group" id="datetime_fecha">
            <label class="h5 text-center mt-3 mb-4 pb-3">Fecha Final</label>
            <div class='input-group date' id='datetime_fecha'>
                <input id="fecha_filtro2" name="fecha_pago" style="width: 80px;" type='text' class="form-control input-font" placeholder="Fecha" value="">
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
        </div>
      </div>

      <div class="col-lg-1">
        <div class="input-group" id="datetime_fecha">
            <label class="h5 text-center mt-3 mb-4 pb-3">Filtro</label>
            <button title="" data-option="1" id="compartido_con" disabled class="btn btn-warning btn-icon buscar_fecha ">Descargar<i class="fa fa-cloud-download icon-btn"></i></button>
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
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestiondocumental.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">

    $('#datetime_fecha, .datetime_fecha').datetimepicker({
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


    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
