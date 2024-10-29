<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Solicitud de Préstamos</title>
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
    <style>

      *{margin: 0; padding: 0;}
.doc{
  display: flex;
  flex-flow: column wrap;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  background: #333944;
}
.box{
  width: 300px;
  height: 300px;
  background: #CCC;
  overflow: hidden;
}

.box img{
  width: 100%;
  height: auto;
}
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}
     

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
        background-color: rgb(255, 255, 255);
        border-color: rgba(149, 149, 149, 0.3);
        border-radius: 3px;
        color: rgb(149, 149, 149);
        padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
        height: 50px;
        margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
        color: rgb(51, 51, 51);
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')
  
     <div class="col-lg-12">
          <h3 class="h_titulo">SOLICITUD DE PRÉSTAMOS</h3>
          <br>
          <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            AGREGAR<i class="fa fa-upload icon-btn" aria-hidden="true"></i>
          </a>
      </div>

    
<div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #0FAEF3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;" id="name"></h4>
        </div>
        <div class="modal-body">
          <center>
            <img style="width: 410px; height: 400px; border: white 6px solid;" id="imagen">
            </center>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              <p id="novedades_modal" style="text-align: left;"></p>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
            </div>
          </div>                    
        </div>
    </div>
  </div>
</div>
<br><br>
<!--MODAL PARA SUBIR EXCEL --> 
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: green">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>AGREGAR EMPLEADO</strong>
          </div>
          <div class="modal-body tabbable">
            <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 430px;">
                <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                  <div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">
                                    <label class="obligatorio" for="nombres" >Nombres</label>
                                    <input class="form-control input-font" type="text" id="nombres" placeholder="NOMBRES">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="apellidos" >Apellidos</label>
                                    <input class="form-control input-font" type="text" id="apellidos" placeholder="APELLIDOS">
                                </div>                                
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="cedula" >Cédula</label>
                                    <input class="form-control input-font" type="text" id="cedula" placeholder="CÉDULA">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="telefono" >Teléfono</label>
                                    <input class="form-control input-font" type="text" id="telefono" placeholder="TELÉFONO">
                                </div>
                          </div>
                          <div class="row">
                            
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="tipo_personal" >PERSONAL</label>
                                    <select class="form-control input-font" name="tipo_personal" id="tipo_personal">
                                        <option >-</option>
                                        <option >ADMINISTRATIVO</option> 
                                        <option >OPERATIVO</option>    
                                        <option >RETIRADO</option>    
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="area" >ÁREA</label>
                                    <select class="form-control input-font" name="area" id="area">
                                        <option >-</option>
                                        <option >COMERCIAL</option>
                                        <option >CONTABILIDAD</option>
                                        <option >GESTION INTEGRAL</option>
                                        <option >JURIDICA</option>
                                        <option >MANTENIMIENTO</option>         
                                        <option >SISTEMAS</option>
                                        <option >TALENTO HUMANO</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label for="cargo">CARGO</label>
                                    <input class="form-control input-font" type="text" id="cargo" name="cargo" placeholder="cargo">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label for="pendiente"> PENDIENTE</label>
                                    <input class="form-control input-font" type="text" id="pendiente" placeholder="PENDIENTE">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="fecha_ingreso">FECHA DE INGRESO</label>
                                   <div class="form-group">
                                      <div class="input-group">
                                          <div class='input-group date' id='datetimepicker1'>
                                              <input id="fecha_ingreso" name="fecha_ingreso" style="width: 210px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                          <span class="input-group-addon">
                                              <span class="fa fa-calendar">
                                              </span>
                                          </span>
                                          </div>
                                      </div>
                                  </div>  
                                </div>                                
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="tipo_contrato" >TIPO DE CONTRATO</label>
                                    <select class="form-control input-font" name="tipo_contrato" id="tipo_contrato">
                                        <option >-</option>
                                        <option >PASANTE</option> 
                                        <option >PRESTACION DE SERVICIOS</option>    
                                        <option >DEFINIDO</option>
                                        <option >INDEFINIDO</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="salario">SALARIO</label>
                                    <input class="form-control input-font" type="text" id="salario" placeholder="SALARIO" value="<?php number_format('0') ?>">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="correo">CORREO</label>
                                    <input class="form-control input-font" type="text" id="correo" placeholder="CORREO ELECTRÓNICO">
                                </div>
                          </div>
                          <div class="row">
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="ciudad" >CIUDAD</label>
                                    <input class="form-control input-font" type="text" id="ciudad" placeholder="CIUDAD">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="direccion" >DIRECCIÓN</label>
                                    <input class="form-control input-font" type="text" id="direccion" name="direccion" placeholder="DIRECCIÓN">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="barrio" >BARRIO</label>
                                    <input class="form-control input-font" type="text" id="barrio" placeholder="BARRIO">
                                </div>
                                <div class="col-lg-2">
                                    <label class="obligatorio" for="celular" >Celular</label>
                                    <div class="row">
                                        
                                    </div>
                                </div>                                
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <!-- IMAGENES VEHICULOS -->
                              <h4 class="h_titulo">Agregar imagen del empleado:</h4>
                              <div class="col-md-4">
                                <div class="panel-body" style="border: 1px">
                                  <div id="lista_imagenes">

                                  </div>

                                    <form class="dropzone" id="my-dropzone">
                                        <input type="hidden" name="id" value="" id="id_vehiculo">
                                        <div class="dz-message" data-dz-message><span>Sube aquí la foto del empleado</span></div>
                                    </form>

                                </div>
                              </div>
                              <div class="col-md-8">
                                
                              </div>                              
                            </div>                                
                          </div>
                        </div>
                    </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" id="guardar_empleado" style="background: #545859" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
              <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
              <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </div>  
<hr style="border: 10px">

    <script>
        Dropzone.options.myDropzone = {
            autoProcessQueue: false,
            uploadMultiple: false,
            maxFilezise: 1,
            maxFiles: 4,
            addRemoveLinks: 'dictCancelUploadConfirmation ',
            url: 'subirimagenes',
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
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/talentohumano.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    

  </body>
</html>
