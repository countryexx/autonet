<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AUTONET | Aprobar Cambios</title>
        @include('scripts.styles')
        <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
        <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
        <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
        <link rel="stylesheet" href="css/normalize.css">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
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
    <body>

      <form class="formulario" style="background-color: #C0BFC0">

        <h1>Asignación de Vehículo</h1>
        <?php $cont = 1; ?>
        
        
          <fieldset class="cuatro">
            <legend><span class="number">-</span>PROVEEDOR</legend>
            <span style="font-size: 25px; color: red;">{{$vehiculo->razonsocial}}</span>
          </fieldset>
          <?php $cont++; ?>
        

        
          <fieldset class="cuatro">
            <legend><span class="number">-</span>CONDUCTOR</legend>
            <span style="font-size: 25px; color: red;">{{$vehiculo->nombre_completo}}</span>
          </fieldset>
          <?php $cont++; ?>
        
        
          <fieldset class="cuatro">
            <legend><span class="number">-</span>VEHÍCULO</legend>
            <span style="font-size: 25px; color: red;">{{$vehiculo->placa}}</span>
          </fieldset>
          <?php $cont++; ?>
        

      <div class="row">
          <div class="col-xs-6">
            <button type="button" data-id="{{$id}}" data-placa="{{$vehiculo->placa}}" data-number="1" class="no_aprobar" style="background: red; border: 1px solid red;"><i class="fa fa-times" aria-hidden="true"></i> No Aprobar</button>
          </div>
          <div class="col-xs-6">
            <button type="button" data-id="{{$id}}" data-placa="{{$vehiculo->placa}}" data-number="1" class="aprobar">Aprobar <i class="fa fa-check" aria-hidden="true"></i></button>
          </div>
      </div>

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

    <script>

      $('.aprobar').click(function() {

        var id = $(this).attr('data-id');
        var placa = $(this).attr('data-placa');

        $.confirm({
            title: 'Atención',
            content: '¿Estás seguro de <b style="color: #3ac162">Aprobar</b> este cambio?',
            buttons: {
                confirm: {
                    text: 'Si!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
                        url: 'aprobar',
                        method: 'post',
                        data: {id: id, placa: placa}
                      }).done(function(data){

                        if(data.respuesta==true){
                          
                          $.confirm({
                              title: '¡Realizado!',
                              content: 'Se ha efectuado el cambio. <br><br>El proveedor fue notificado por correo electrónico.',
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

      $('.no_aprobar').click(function() {

        var id = $(this).attr('data-id');
        var placa = $(this).attr('data-placa');

        $.confirm({
            title: 'Atención',
            content: '¿Estás seguro de <b style="color: red">NO</b> Aprobar este cambio?',
            buttons: {
                confirm: {
                    text: 'Si!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
                        url: '../noaprobar',
                        method: 'post',
                        data: {id: id, placa: placa}
                      }).done(function(data){

                        if(data.respuesta==true){
                          
                          $.confirm({
                              title: '¡Realizado!',
                              content: 'Se ha efectuado el cambio. <br><br>El proveedor fue notificado por correo electrónico.',
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

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

    </body>
</html>
