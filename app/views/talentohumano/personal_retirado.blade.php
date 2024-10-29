<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    
    <title>Autonet | Gestión del Personal Retirado</title>
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

      input[type=”file”]#nuestroinput {
       width: 0.1px;
       height: 0.1px;
       opacity: 0;
       overflow: hidden;
       position: absolute;
       z-index: -1;
      }
      label[for=" nuestroinput"] {
       font-size: 14px;
       font-weight: 600;
       color: #fff;
       background-color: #106BA0;
       display: inline-block;
       transition: all .5s;
       cursor: pointer;
       padding: 15px 40px !important;
       text-transform: uppercase;
       width: fit-content;
       text-align: center;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
      @include('talentohumano.menu_empleados')
    </div>
     <div class="col-lg-12">
          <h3 class="h_titulo">PERSONAL RETIRADO</h3>
          <br>
          <!--<a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-secondary btn-icon" data-toggle="modal" data-target=".mymodal2">
            AGREGAR<i class="fa fa-user icon-btn" aria-hidden="true"></i>
          </a>   -->
          @if($empleados)
          <div class="row">
            @foreach($empleados as $empleado)
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background: gray; color: white"><h3>{{$empleado->nombres}} {{$empleado->apellidos}}</h3></div>
                    <div class="panel-body" style="height: 100%">
                      <div class="row">
                          <!-- Fin división de datos -->
                          <div class="col-md-8"> 
                            <p style="font-family: cursive;"><b>FECHA DE NACIMIENTO: </b>{{$empleado->fecha_nacimiento}}</p>
                            <p style="font-family: cursive;"><b>CÉDULA: </b>{{$empleado->cedula}}</p>
                            <p style="font-family: cursive;"><b>TELÉFONO: </b>{{$empleado->telefono}}</p>
                            <p style="font-family: cursive;"><b>EMAIL: </b>{{$empleado->correo}}</p>
                            <p style="font-family: cursive;"><b>DIRECCIÓN: </b>{{$empleado->direccion}}</p>
                            <p style="font-family: cursive;"><b>BARRIO: </b>{{$empleado->barrio}}</p>
                            <p style="font-family: cursive;"><b>ÁREA: </b>{{$empleado->area}}</p>
                            <p style="font-family: cursive;"><b>CARGO: </b>{{$empleado->cargo}}</p>
                            <p style="font-family: cursive;"><b>FECHA DE INGRESO: </b>{{$empleado->fecha_ingreso}}</p>
                            <p style="font-family: cursive;"><b>FECHA DE RETIRO: </b>{{$empleado->fecha_retiro}}</p>
                          </div>
                          <!-- Fin división de datos -->    
                          <div class="col-md-4">
                           @if($empleado->foto===null)
                              <div style="float: right; margin-right: 20px" class="contenedor_imagen_perfil">
                                  <img id="imagen_perfil" class="img-thumbnail" src="http://placehold.it/250x316" width="160px" height="200px">                                  
                              </div>
                            @else
                              <img style="float: right; margin-right: 20px" src="{{url('biblioteca_imagenes/talentohumano/fotos/'.$empleado->foto)}}" width="160px" height="200px" class="img-thumbnail">
                            
                            @endif
                          </div>
                           <hr>
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4">
                                
                                  <a href="../biblioteca_imagenes/talentohumano/hojas/{{$empleado->hoja_de_vida}}" type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}">Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                </div>                
                                <div class="col-md-2" style="margin-right: 30px">
                                  @if($permisos->talentohumano->empleados->retirar==='on')
                                    <button id="retintegro" type="button" name="button" data-toggle="modal" class="btn btn-success retintegro" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >REINGRESAR <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                                  @else
                                    <button id="retintegro" disabled type="button" name="button" data-toggle="modal" class="btn btn-success retintegro" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >REINGRESAR <i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                                  @endif
                                </div>
                                <div class="col-md-2">
                                  @if($empleado->historial!=null)
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning">HISTORIAL</a>
                                  @else
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning disabled">HISTORIAL</a>
                                  @endif
                                </div>  
                              </div>                                
                            </div>                              
                      </div>                      
                    </div>
                </div>
              </div>
            @endforeach
          </div>    
          @else
          <h1 style="text-align: center;">No hay empleados retirados.</h1>
          @endif

      </div>

  <!-- MODAL DE FECHA DE RESUCITAR -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_fecha_reintegro'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">REINGRESO DE EMPLEADO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <input type="text" name="empleado" class="empleado" id="empleado" hidden="">
                <span class="nombre hidden"></span>
                <label class="obligatorio">FECHA DE REINGRESO</label>
                <div class='input-group date' id='datetimepicker10'>
                  <input id="fecha_reingreso" name="fecha_reingreso" style="width: 140px;" type='text' class="form-control input-font" placeholder="SELECCIONAR FECHA">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar">
                        </span>
                    </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            <button type="button" class="btn btn-primary reintegrar">REINGRESAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN FECHA DE REINGRESO -->
    
    <br><br>
<!--MODAL PARA SUBIR EXCEL --> 
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <form id="formulario">
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
                                    <input class="form-control input-font" type="number" id="cedula" placeholder="CÉDULA">
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="telefono" >Teléfono</label>
                                    <input class="form-control input-font" type="number" id="telefono" placeholder="TELÉFONO">
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
                                    <input class="form-control input-font" type="number" id="salario" placeholder="SALARIO" value="<?php number_format('0') ?>">
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
                                    <label class="obligatorio" for="celular" >Hoja de Vida</label>          
                                        <!-- ARCHIVO -->
                                        <input type="file" class="form-control" name="hoja" id="hoja" accept="application/pdf" data-filename-placement="inside">
                                </div>                                
                          </div>
                          <div class="row">
                            <div class="col-xs-4">
                                  <form style="margin-bottom: 0px" id="upload_imagen_conductor">
                                    <div class="contenedor_imagen_perfil">
                                        <input id="foto_perfil" type="file" value="Subir" name="foto_perfil" class="image_perfil">
                                        <img id="imagen_perfil"style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" class="img-thumbnail" src="http://placehold.it/250x316">
                                        <div class="icon_spin hidden">
                                          <i class="fa fa-spin fa-spinner"></i>
                                        </div>
                                    </div>
                                  </form>
                              </div>
                          </div>
                          <!--
                          <div class="row">
                            <div class="col-md-12">
                              
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
                                <div class="col-xs-4">
                                  <form style="margin-bottom: 0px" id="upload_imagen_conductor">
                                    <div class="contenedor_imagen_perfil">
                                        <input id="input_imagen" type="file" value="Subir" name="foto_perfil" class="image_perfil">
                                        <img id="imagen_perfil" class="img-thumbnail" src="http://placehold.it/250x316">
                                        <div class="icon_spin hidden">
                                          <i class="fa fa-spin fa-spinner"></i>
                                        </div>
                                    </div>
                                  </form>
                              </div>
                              </div>                              
                            </div>                                
                          </div>-->
                        </div>
                    </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" id="guardar_empleado" style="background: #545859" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>


              <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
              <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
          </div>          
        </div>
        </form>
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
    
    <script>

        $('input[type=file]').bootstrapFileInput();
        $('.file-inputs').bootstrapFileInput();

    </script>

  </body>
</html>
