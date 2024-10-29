<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AOTOUR | Datos Financieros</title>
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

        <h1>Registro de Proveedores</h1>
        <?php $cont = 1; ?>

        <!-- INICIO INFORMACIÓN DE PAGOS -->
        <fieldset class="cuatro">
          <legend><span class="number">4</span>Información para Pagos</legend>

            <div class="row">
                <div class="col-lg-8">
                    <label for="pago">A quién se le realizarán los pagos?</label>
                    <select id="pago" name="pago">
                        <option value="0">Seleccionar</option>
                        <option value="1">A MÍ</option>
                        <option value="2">A OTRA PERSONA (ESPOSO(A), HERMANO(A), ETC.)</option>
                    </select>
                </div>
                <div class="col-lg-6">

                </div>
            </div>
            <div class="row tercero hidden">
                <div class="col-lg-12" style="margin-bottom: 15px">
                    <h4>A continuación ingrese los datos financieros de esa persona</h4>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="razonsocialt" >Nombre o Razon social</label>
                    <input class="form-control input-font" type="text" id="razonsocialt" placeholder="Ingresar nombre">
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="numero_documentot" >Número de Documento de Identidad</label>
                    <input class="form-control input-font" type="number" id="numero_documentot" placeholder="Ingresar Número">
                </div>
                
            </div>
            <div class="row tercero hidden">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="tipo_cuentat" >Tipo de Cuenta</label>
                    <select class="form-control input-font" name="tipo_cuentat" id="tipo_cuentat">
                        <option >-</option>
                        <option >AHORROS</option> 
                        <option >CORRIENTE</option>
                    </select>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="entidad_bancariat" >Entidad Bancaria</label>
                    <select class="form-control input-font" name="entidad_bancariat" id="entidad_bancariat">
                        <option >-</option>
                        <option >BANCO DE BOGOTA</option> 
                        <option >BANCO BBVA</option>
                        <option >BANCOLOMBIA</option>
                        <option >BANCO DAVIVIENDA</option>
                        <option >BANCO POPULAR</option>
                        <option >SCOTIABANK COLPATRIA S.A</option>
                        <option >BANCOOMEVA</option>
                        <option >BANCO FALABELLA S.A.</option>
                        <option >ITAÚ</option>
                        <option >BANCO CAJA SOCIAL</option>
                        <option >BANCO DE OCCIDENTE</option>
                        <option >BANCO AV VILLAS</option>
                        <option >BANCO PICHINCHA</option>
                        <option >HELM BANK</option>
                        <option >SUDAMERIS</option>
                        <option >HSBC</option>
                    </select>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <label class="obligatorio" for="numero_cuentat" >Número de Cuenta</label>
                    <input class="form-control input-font" type="number" id="numero_cuentat" placeholder="NÚMERO DE CUENTA TERCERO">
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12 col-md-12">
                    <label class="obligatorio" for="certificacion_tercero">Adjunte Certificación Bancaria</label>
                    <input id="certificacion_tercero" accept="application/pdf" class="certificacion_tercero" type="file" value="Subir" name="certificacion_tercero" class="perfil">

                    <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_certificacion_t hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver Cerficicación <i class="fa fa-external-link" aria-hidden="true"></i></a>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">

                    <label class="obligatorio" for="certificacion">Adjunte el Poder</label>
                <input id="poder_tercero" accept="application/pdf" class="poder_tercero" type="file" value="Subir" name="poder_tercero" class="perfil">

                <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_poder hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver PODER  <i class="fa fa-external-link" aria-hidden="true"></i></a>

                </div>
            </div>
            <div class="row proveedor hidden">
                <div class="col-lg-12" style="margin-bottom: 15px">
                    <h4>A continuación ingrese sus datos financieros</h4>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <label for="tipo_cuenta">Tipo de Cuenta:</label>
                    <select id="tipo_cuenta" name="tipo_cuenta">
                        <option >-</option>
                        <option>AHORROS</option>
                        <option>CORRIENTE</option>
                    </select>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <label for="entidad_bancaria">Entidad Bancaria:</label>
                    <select id="entidad_bancaria" name="entidad_bancaria">
                        <option >-</option>
                        <option >BANCO DE BOGOTA</option>
                        <option >BANCO BBVA</option>
                        <option >BANCOLOMBIA</option>
                        <option >BANCO DAVIVIENDA</option>
                        <option >BANCO POPULAR</option>
                        <option >SCOTIABANK COLPATRIA S.A</option>
                        <option >BANCOOMEVA</option>
                        <option >BANCO FALABELLA S.A.</option>
                        <option >ITAÚ</option>
                        <option >BANCO CAJA SOCIAL</option>
                        <option >BANCO DE OCCIDENTE</option>
                        <option >BANCO AV VILLAS</option>
                        <option >BANCO PICHINCHA</option>
                        <option >HELM BANK</option>
                        <option >SUDAMERIS</option>
                        <option >HSBC</option>
                    </select>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <label for="numero_cuenta">Número de la cuenta:</label>
                    <input type="number" id="numero_cuenta" name="numero_cuenta">
                </div>
            </div>
            <div class="row proveedor hidden">
                
                <div class="col-lg-12 col-xs-12">
                    <label for="certificacion_proveedor">Adjunte Certificación Bancaria:</label>
                    <input id="certificacion_proveedor" accept="application/pdf" class="certificacion_proveedor" type="file" value="Subir" name="certificacion_proveedor" >
                </div>
            </div>
        </fieldset>
        <!-- INICIO INFORMACIÓN DE PAGOS -->

        <div class="row">
            
            <div class="col-lg-12">
                <button data-id="{{$proveedor->id}}" type="button" data-number="1" class="enviar_datos_f">Enviar Documentos <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
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
