<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    
    <title>Autonet | Gestión del Personal Administrativo</title>
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

      /**/
      @import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);

      html {
        font-family: 'Montserrat', Arial, sans-serif;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
      }

      body {
        background: #F2F3EB;
      }

      button {
        overflow: visible;
      }

      button, select {
        text-transform: none;
      }

      button, input, select, textarea {
        color: #5A5A5A;
        font: inherit;
        margin: 0;
      }

      input {
        line-height: normal;
      }

      textarea {
        overflow: auto;
      }

      #container {
        border: solid 3px #474544;
        max-width: 768px;
        margin: 60px auto;
        position: relative;
      }

      form {
        padding: 37.5px;
        margin: 50px 0;
      }

      h1 {
        color: #474544;
        font-size: 25px;
        font-weight: 700;
        letter-spacing: 7px;
        text-align: center;
        text-transform: uppercase;
      }

      .underline {
        border-bottom: solid 2px #474544;
        margin: -0.512em auto;
        width: 80px;
      }

      .icon_wrapper {
        margin: 50px auto 0;
        width: 100%;
      }

      .icon {
        display: block;
        fill: #474544;
        height: 50px;
        margin: 0 auto;
        width: 50px;
      }

      .email {
        float: right;
        width: 45%;
      }

      input[type='text'], [type='email'], select, textarea {
        background: none;
        border: none;
        border-bottom: solid 2px #474544;
        color: #474544;
        font-size: 1.000em;
        font-weight: 400;
        letter-spacing: 1px;
        margin: 0em 0 1.875em 0;
        padding: 0 0 0.875em 0;
        text-transform: uppercase;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
      }

      input[type='text']:focus, [type='email']:focus, textarea:focus {
        outline: none;
        padding: 0 0 0.875em 0;
      }

      .message {
        float: none;
      }

      .name {
        float: left;
        width: 45%;
      }

      select {
        background: url('https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-arrow-down-32.png') no-repeat right;
        outline: none;
        -moz-appearance: none;
        -webkit-appearance: none;
      }

      select::-ms-expand {
        display: none;
      }

      .subject {
        width: 100%;
        margin-top: 15px;
      }

      .telephone {
        width: 100%;
      }

      textarea {
        line-height: 150%;
        height: 150px;
        resize: none;
        width: 100%;
      }

      ::-webkit-input-placeholder {
        color: #474544;
      }

      :-moz-placeholder { 
        color: #474544;
        opacity: 1;
      }

      ::-moz-placeholder {
        color: #474544;
        opacity: 1;
      }

      :-ms-input-placeholder {
        color: #474544;
      }

      #guardar_emoticon {
        background: none;
        border: solid 2px #474544;
        color: #474544;
        cursor: pointer;
        display: inline-block;
        font-family: 'Helvetica', Arial, sans-serif;
        font-size: 0.875em;
        font-weight: bold;
        outline: none;
        padding: 20px 35px;
        text-transform: uppercase;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        float: right;
      }

      #guardar_emoticon:hover {
        background: #474544;
        color: #F2F3EB;
      }

      @media screen and (max-width: 768px) {
        #container {
          margin: 20px auto;
          width: 95%;
        }
      }

      @media screen and (max-width: 480px) {
        h1 {
          font-size: 26px;
        }
        
        .underline {
          width: 68px;
        }
        
        #guardar {
          padding: 15px 25px;
        }
      }

      @media screen and (max-width: 420px) {
        h1 {
          font-size: 18px;
        }
        
        .icon {
          height: 35px;
          width: 35px;
        }
        
        .underline {
          width: 53px;
        }
        
        input[type='text'], [type='email'], select, textarea {
          font-size: 0.875em;
        }
      }
      /**/

    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
    </div>
     <div class="col-lg-12">
          <h3 class="h_titulo">GESTIÓN DE EMOTICONES</h3>
          <br>          
           <div class="row">
              <div class="col-lg-4 col-sm-12 col-xs-12 col-md-12">
                  <label class="obligatorio" for="nombre" >NOMBRE</label>
                  <input class="form-control input-font" type="text" id="nombre" placeholder="INGRESAR NOMBRE">
              </div>
              <div class="col-lg-4 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="codigo" >CÓDIGO</label>
                  <input class="form-control input-font" type="text" id="codigo" placeholder="INGRESAR CÓDIGO">
              </div>                                              
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <input type="submit" value="Guardar" id="guardar_emoticon" />
              </div>
            </div>
            <br><br>
            <h1>EMOTICONES</h1>
            @foreach($emoticones as $emoticon)
              <div class="col-xs-1">
                <p style="font-size: 50px">{{$emoticon->codigo}}</p>
              </div>              
            @endforeach

      </div>      

    <!-- MODAL DE FECHA DE RETIRO -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_fecha_retiro'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">RETIRO DE EMPLEADO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-8 col-sm-12 col-xs-12 col-md-12">
                  <label class="obligatorio" for="observaciones" >Observaciones</label>
                  <textarea class="form-control input-font" type="text" id="observaciones" placeholder="INGRESAR OBSERVACIONES"></textarea>
              </div>
              <div class="col-md-3">
                <input type="text" name="empleado" class="empleado" id="empleado" hidden="">
                <span class="nombre hidden"></span>
                <label class="obligatorio">FECHA DE RETIRO</label>
                <div class='input-group date' id='datetimepicker10'>
                  <input id="fecha_retiro" name="fecha_retiro" style="width: 120px;" type='text' class="form-control input-font" placeholder="FECHA DE RETIRO">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar">
                        </span>
                    </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary guardar_retiro">RETIRAR</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN FECHA DE REGISTRO -->

  <!-- MODAL DE EDICIÓN -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_editar'>
      <div class="modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">MODIFICACIÓN DE EMPLEADO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            <div class="row">
              <div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">
                  <label class="obligatorio" for="nombresedit" >Nombres</label>
                  <input class="form-control input-font" type="text" id="nombresedit" placeholder="NOMBRES">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="apellidosedit" >Apellidos</label>
                  <input class="form-control input-font" type="text" id="apellidosedit" placeholder="APELLIDOS">
              </div>                                
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="cedulaedit" >Cédula</label>
                  <input class="form-control input-font" type="number" id="cedulaedit" placeholder="CÉDULA">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="telefonoedit" >Teléfono</label>
                  <input class="form-control input-font" type="number" id="telefonoedit" placeholder="TELÉFONO">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="tipo_personaledit" >PERSONAL</label>
                  <select class="form-control input-font" name="tipo_personaledit" id="tipo_personaledit">
                      <option >-</option>
                      <option >ADMINISTRATIVO</option> 
                      <option >OPERATIVO</option>    
                      <option >RETIRADO</option>    
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="areaedit" >ÁREA</label>
                  <select class="form-control input-font" name="areaedit" id="areaedit">
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
                  <label for="cargoedit">CARGO</label>
                  <input class="form-control input-font" type="text" id="cargoedit" name="cargoedit" placeholder="cargo">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label for="pendienteedit"> PENDIENTE</label>
                  <input class="form-control input-font" type="text" id="pendienteedit" placeholder="PENDIENTE">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="fecha_ingresoedit">INGRESO</label>
                 <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input id="fecha_ingresoedit" name="fecha_ingresoedit" style="width: 170px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                        </div>
                    </div>
                </div>  
              </div>                                
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="tipo_contratoedit" >CONTRATO</label>
                  <select class="form-control input-font" name="tipo_contratoedit" id="tipo_contratoedit">
                      <option >-</option>
                      <option >PASANTE</option> 
                      <option >PRESTACION DE SERVICIOS</option>    
                      <option >DEFINIDO</option>
                      <option >INDEFINIDO</option>
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="salarioedit">SALARIO</label>
                  <input class="form-control input-font" type="number" id="salarioedit" placeholder="SALARIO" value="<?php //number_format('0') ?>">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="correoedit">CORREO</label>
                  <input class="form-control input-font" type="text" id="correoedit" placeholder="CORREO ELECTRÓNICO">
              </div>
            </div>
            <div class="row">
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="ciudadedit" >CIUDAD</label>
                                    <input class="form-control input-font" type="text" id="ciudadedit" placeholder="CIUDAD">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="direccionedit" >DIRECCIÓN</label>
                                    <input class="form-control input-font" type="text" id="direccionedit" name="direccionedit" placeholder="DIRECCIÓN">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="barrioedit" >BARRIO</label>
                                    <input class="form-control input-font" type="text" id="barrioedit" placeholder="BARRIO">
                                </div>
                                <div class="col-lg-2">
                                    <label class="obligatorio" style="margin-top: 5px" for="hojadevidaedit" >Hoja de Vida</label>          
                                    <a type="button" name="button" data-toggle="modal" class="btn btn-secondary boton_hoja" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Vista Previa Hoja de Vida   <i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <!--
                                        <input type="file" class="form-control" name="hojaedit" id="hojaedit" accept="application/pdf" data-filename-placement="inside">-->
                                </div>                                
                          </div><!--
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
                          </div>-->
                        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary guardar_edicion">ACTUALIZAR DATOS</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN EDICIÓN -->

    
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
          <div class="modal-body">            
              <div id="container-fluid">
                <h1>&bull; Registro de Empleados &bull;</h1>
                
                <form id="formulario">
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
                                    <input class="form-control input-font" type="number" id="salario" placeholder="SALARIO" value="<?php //number_format('0') ?>">
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
                          
                        </div>
                    </div>
                </form><!-- // End form -->
              </div><!-- // End #container -->

          </div>
          <div class="modal-footer">              
            <input type="submit" value="Guardar" id="guardar_empleado" />
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
    <script src="{{url('jquery/control.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    
    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

  </body>
</html>
