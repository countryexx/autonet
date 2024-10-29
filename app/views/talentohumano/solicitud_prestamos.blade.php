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

      h3 {
        color: #474544;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 7px;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: -30px;
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

      #guardar {
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

      #guardar:hover {
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
      @include('talentohumano.menu_talentohumano')
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

<!-- TES FORM -->
<div id="mensajes">
    <h3 class="mensajes hidden" style="text-align: center; color: red">&bull; &bull; </h3>
  </div>
<div id="container">
  <h1>&bull; Registro de Préstamos &bull;</h1>
  
  <form id="formulario">
    <div class="row">      
        <div class="col-lg-6">
          <label for="name" class="obligatorio">Fecha de Solicitud</label>      
          <div class='input-group date' id='datetimepicker1'>
              <input name="fecha_solicitud" id="fecha_solicitud" style="text-align: center;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
              <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </span>
          </div>
        </div>
     
        <div class="col-lg-6">
          <label for="email" class="obligatorio">Fecha de Aprobación</label>
          <div class='input-group date' id='datetimepicker2'>
              <input name="fecha_aprobacion" id="fecha_aprobacion" style="text-align: center;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
              <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </span>
          </div>
        </div> 
     
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="subject">
          <label for="subject" class="obligatorio"> Empleado</label>
          <select placeholder="SELECCIONAR EMPLEADO" name="empleado" id="empleado">
            <option disabled hidden selected value="0">SELECCIONAR EMPLEADO</option>
            @foreach($empleados as $empleado)
              <option value="{{$empleado->id}}">{{$empleado->nombres}} {{$empleado->apellidos}}</option>
             
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        
      </div>
      <div class="col-lg-6">
        <label for="name" class="obligatorio"> Valor del Préstamo</label>
        <input type="text" placeholder="Valor" name="valor" id="valor" value="{{number_format(0)}}">
      </div>
    </div>    
    
    <div class="submit">
        @if($permisos->talentohumano->prestamos->crear==='on')
          <input type="submit" value="Guardar" id="guardar" />
        @else
          <input type="submit" disabled value="Guardar" id="guardar" />
        @endif
    </div>
  </form><!-- // End form -->
</div><!-- // End #container -->
<!-- -->
 
<hr style="border: 10px">

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

<!-- 
<div class="col-lg-12">
        <h3 class="h_titulo">SOLICITUD DE PRÉSTAMOS</h3>
        <br>
          
        <div>
          <div class="row">
            <div class="col-md-6 col-md-offset-4">
                <div class="panel panel-default">
                  <div class="panel-heading">REGISTRAR NUEVO PRÉSTAMO</div>
                
                    <div class="panel-body">
                      <div class="form-group">
                        <label class="obligatorio" for="nombres" >Fecha de Solicitud</label>
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_solicitud" id="fecha_solicitud" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>

                        <label class="obligatorio" for="nombres" >Fecha de Aprobación</label>
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker2'>
                                <input name="fecha_aprobacion" id="fecha_aprobacion" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>

                        <label class="obligatorio" for="empleado" >Empleado</label>
                        <div class="form-group">
                            <select id="empleado" style="width: 130px;" class="form-control input-font" name="empleado">
                                <option value="0">-</option>
                                @foreach($empleados as $empleado)
                                  <option value="{{$empleado->id}}">{{$empleado->nombres}}</option>
                                @endforeach
                            </select>
                        </div>

                      <label class="obligatorio" for="valor" >Valor</label>
                      <div class="form-group">
                          <input type="text" name="valor" id="valor" class="form-group input-group">
                      </div>

                    </div> 
                    <a id="guardar" style="float: right;" class="btn btn-info btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                  </div>
                    
                </div>

              </div>
            </div>            
            
            <button data-option="1" id="buscar" class="btn btn-default btn-icon">
                Buscar<i class="fa fa-search icon-btn"></i>
            </button>
        </div>
    </div>
    -->