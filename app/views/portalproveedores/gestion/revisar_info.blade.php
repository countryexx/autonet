<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Revisar Información</title>
        @include('scripts.styles')
        <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
        <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
        <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
        <link rel="stylesheet" href="css/normalize.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/main.css">
        <style type="text/css">
            *, *:before, *:after {
              -moz-box-sizing: border-box;
              -webkit-box-sizing: border-box;
              box-sizing: border-box;
            }

            body {
              font-family: 'Nunito', sans-serif;
              color: #384047;
            }

            form {
              max-width: 300px;
              margin: 10px auto;
              padding: 15px 20px;
              background: #f4f7f8;
              border-radius: 8px;
            }

            h1 {
              margin: 0 0 30px 0;
              text-align: center;
            }

            input[type="text"],
            input[type="password"],
            input[type="date"],
            input[type="datetime"],
            input[type="email"],
            input[type="number"],
            input[type="search"],
            input[type="tel"],
            input[type="time"],
            input[type="url"],
            textarea,
            select {
              background: orange;
              border: none;
              font-size: 16px;
              height: auto;
              margin: 0;
              outline: 0;
              padding: 15px;
              width: 100%;
              background-color: white;
              color: #8a97a0;
              box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
              margin-bottom: 30px;
            }

            input[type="radio"],
            input[type="checkbox"] {
              margin: 0 4px 8px 0;
            }

            select {
              padding: 6px;
              height: 32px;
              border-radius: 2px;
            }

            button {
              padding: 19px 39px 18px 39px;
              color: #FFF;
              background-color: #4bc970;
              font-size: 18px;
              text-align: center;
              font-style: normal;
              border-radius: 5px;
              width: 100%;
              border: 1px solid #3ac162;
              border-width: 1px 1px 3px;
              box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
              margin-bottom: 10px;
            }

            fieldset {
              margin-bottom: 30px;
              border: none;
            }

            legend {
              font-size: 2.4em;
              margin-bottom: 10px;
            }

            label {
              display: block;
              margin-bottom: 8px;
            }

            label.light {
              font-weight: 300;
              display: inline;
            }

            .number {
              background-color: #5fcf80;
              color: #fff;
              height: 30px;
              width: 30px;
              display: inline-block;
              font-size: 0.8em;
              margin-right: 4px;
              line-height: 30px;
              text-align: center;
              text-shadow: 0 1px 0 rgba(255,255,255,0.2);
              border-radius: 100%;
            }

            @media screen and (min-width: 480px) {

              form {
                max-width: 880px;
              }

            }
        </style>
    </head>
    <body style="background-color: orange;">

      <form class="formulario" style="background-color: #C0BFC0">

        <h1>Documentos Rechazados</h1>
        <?php $cont = 1; ?>
        <h4>Por favor, adjunte los archivos nuevamente y verifique que sean los documentos solicitados y actualizados. <br><br>Lamentablemente no fueron aprobados los siguientes documentos:</h4>
        @if($vehiculo->autorizado_tecnomecanica===2)
          <fieldset class="cuatro">
            <legend><span class="number">{{$cont}}</span>TECNOMECÁNICA</legend>
            <input data-enabled="1" id="tecnomecanica" accept="application/pdf" class="tecnomecanica" type="file" value="Subir" name="tecnomecanica" >
            <!--<a class="btn btn-success btn-list-table" target="_blank" href="conductores/{{strtolower($proveedor->id)}}">VER</a>-->
          </fieldset>
          <?php $cont++; ?>
        @endif

        @if($vehiculo->autorizado_soat===2)
          <fieldset class="cuatro">
            <legend><span class="number">{{$cont}}</span>SOAT</legend>
            <input data-enabled="1" id="soat" accept="application/pdf" class="soat" type="file" value="Subir" name="soat" >
          </fieldset>
          <?php $cont++; ?>
        @endif
        @if($vehiculo->autorizado_to===2)
          <fieldset class="cuatro">
            <legend><span class="number">{{$cont}}</span>TARJETA DE OPERACIÓN</legend>
            <input data-enabled="1" id="to" accept="application/pdf" class="to" type="file" value="Subir" name="to" >
          </fieldset>
          <?php $cont++; ?>
        @endif
        @if($vehiculo->autorizado_tp===2)
          <fieldset class="cuatro">
            <legend><span class="number">{{$cont}}</span>TARJETA DE PROPIEDAD</legend>
            <input data-enabled="1" id="tp" accept="application/pdf" class="tp" type="file" value="Subir" name="tp" >
          </fieldset>
          <?php $cont++; ?>
        @endif
        @if($conductor->autorizado_cc===2)
          <fieldset class="cuatro">
            <legend><span class="number">{{$cont}}</span>DOCUMENTO DE IDENTIFICACIÓN</legend>
            <input data-enabled="1" id="cedula" accept="application/pdf" class="cedula" type="file" value="Subir" name="cedula" >
          </fieldset>
          <?php $cont++; ?>
        @endif
        @if($conductor->autorizado_licencia===2)
        <fieldset class="cuatro">
          <legend><span class="number">{{$cont}}</span>LICENCIA DE CONDUCCIÓN</legend>
          <input data-enabled="1" id="licencia" accept="application/pdf" class="licencia" type="file" value="Subir" name="licencia" >
        </fieldset>
        <?php $cont++; ?>
      @endif
      @if($conductor->autorizado_seguridad_social===2)
        <fieldset class="cuatro">
          <legend><span class="number">{{$cont}}</span>SEGURIDAD SOCIAL</legend>
          <input data-enabled="1" id="seg_social" accept="application/pdf" class="seg_social" type="file" value="Subir" name="seg_social" >
        </fieldset>
        <?php $cont++; ?>
      @endif


      <div class="row">
          <div class="col-xs-6">
              <button type="button" data-number="1" class="back_form hidden" disabled="true" style="background: red"><i class="fa fa-arrow-left" aria-hidden="true"></i> Atrás</button>
          </div>
          <div class="col-xs-6">
              <button data-id="{{$proveedor->id}}" type="button" data-number="1" class="enviar_documentos">Enviar Documentos <i class="fa fa-arrow-right" aria-hidden="true"></i></button>

              <button type="button" data-number="1" class="enviar2 hidden">Enviar Datos <i class="fa fa-arrow-right" aria-hidden="true"></i></button>

          </div>
      </div>

        <!-- TEST -->

    <!-- COLOCAR MODALES DINÁMICOS PARA LA CREACIÓN DE LOS VEHÍCULOS -->
    <!-- COLOCAR MODALES DINÁMICOS PARA LA CREACIÓN DE LOS CONDUCTORES -->
    <!-- COLOCAR MODAL DINÁMICO PARA LOS PROVEEDORES QUE TENGAN PAGO A TERCERO -->
  </form>

    <script>
        Dropzone.options.myDropzone = {
            acceptedFiles: ".png, .jpg",
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 1,
            maxFiles: 6,
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: '../../proveedores/subirimagenes',
            init: function() {
                var submitBtn = document.querySelector("#subir");

                myDropzone = this;
                submitBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });
                this.on("addedfile", function(file) {

                });
                this.on("complete", function(file) {

                });
                myDropzone.on("success", function(file, response) {
                    if(response.mensaje===true){
                        $(file.previewElement).fadeOut({
                            complete: function() {
                                // If you want to keep track internally...
                                myDropzone.removeFile(file);
                            }
                        });
                        alert(response.respuesta);
                    }else if(response.mensaje===false){
                        alert(response.respuesta);
                    }

                });
            }
        };

    </script>
    @include('scripts.scripts')

    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/portalproveedores.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>

    <!--@include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
   <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/hvvehiculos.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
-->
    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

    </body>
</html>
