<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Gestión del Personal Operativo</title>
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

      #guardar_empleado {
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

      #guardar_empleado:hover {
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
      @include('talentohumano.menu_empleados')
    </div>
     <div class="col-lg-12">
          <h3 class="h_titulo">PERSONAL OPERATIVO</h3>
          <br>
          @if($permisos->talentohumano->empleados->crear==='on')
            <div class="row">
              <div class="col-lg-5">
                <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-secondary btn-icon" data-toggle="modal" data-target=".mymodal2">
                AGREGAR<i class="fa fa-user icon-btn" aria-hidden="true"></i>
                </a>
              </div>
              <div class="col-lg-5">
                
              </div>
              <div class="col-lg-2">
                <input type="radio" id="baq" name="sede" value="d">
                <label for="baq">BAQ</label>
                <input type="radio" id="bog" name="sede" value="d">
                <label for="bog">BOG</label>
                <input type="radio" checked id="todos" name="sede" value="d">
                <label for="todos">TODOS</label>
              </div>
            </div>            
          @else
            <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-secondary btn-icon disabled" data-toggle="modal" data-target=".mymodal2">
            AGREGAR<i class="fa fa-user icon-btn" aria-hidden="true"></i>
            </a>
          @endif

          @if($empleados) 
          <div class="row todos">
            @foreach($empleados as $empleado)
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background: gray; color: white"><h3>{{$empleado->nombres}} {{$empleado->apellidos}}</h3><span>@if($empleado->tipo_contrato==='PRESTACION DE SERVICIOS'){{'CONTRATISTA'}}@elseif($empleado->tipo_contrato==='INDEFINIDO'){{'EMPLEADO'}}@elseif($empleado->tipo_contrato==='PASANTE'){{'PASANTE'}}@elseif($empleado->tipo_contrato==='DEFINIDO'){{'EMPLEADO'}}@endif</span> <span style="float: right; margin-top: -60px; background: orange; padding: 3px">{{$empleado->sede}}</span> </div>
                    <div class="panel-body" style="height: 100%">
                      <div class="row">
                          <!-- Fin división de datos -->
                          <div class="col-md-8">                            
                            <p style="font-family: cursive;"><b>CÉDULA: </b>{{$empleado->cedula}}</p>
                            <p style="font-family: cursive;"><b>TELÉFONO: </b>{{$empleado->telefono}}</p>
                            <p style="font-family: cursive;"><b>EMAIL: </b>{{$empleado->correo}}</p>
                            <p style="font-family: cursive;"><b>DIRECCIÓN: </b>{{$empleado->direccion}}</p>
                            <p style="font-family: cursive;"><b>BARRIO: </b>{{$empleado->barrio}}</p>
                            <p style="font-family: cursive;"><b>ÁREA: </b>{{$empleado->area}}</p>
                            <p style="font-family: cursive;"><b>CARGO: </b>{{$empleado->cargo}}</p>
                            <p style="font-family: cursive;"><b>TIPO CONTRATO: </b>{{$empleado->tipo_contrato}}</p>
                            <p style="font-family: cursive;"><b>FECHA DE INGRESO: </b>{{$empleado->fecha_ingreso}}</p>
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
                                  <!--<a href="../biblioteca_imagenes/mantenimiento_fact/{{$empleado->hoja_de_vida}}" style="" class="btn btn-info btn-icon" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}">DESCARGAR HOJA DE VIDA<i class="fa fa-download icon-btn" aria-hidden="true"></i></a>-->
                                  @if($empleado->hoja_de_vida==1)                    
                                    <a type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}" disabled>Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @else
                                    
                                    <a href="../biblioteca_imagenes/talentohumano/hojas/{{$empleado->hoja_de_vida}}" type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}">Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @endif
                                  
                                </div>                                
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="editar" type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @else
                                    <button id="editar" disabled type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @endif
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->retirar==='on')
                                    <button id="retirar" type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @else
                                    <button id="retirar" disabled type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @endif
                                </div>  
                                <div class="col-md-2">
                                  @if($empleado->historial!=null)
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning">HISTORIAL</a>
                                  @else
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning disabled">HISTORIAL</a>
                                  @endif                                
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="foto" type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
                                  @else
                                    <button id="foto" disabled type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
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
          <h1 style="text-align: center;">No hay empleados operativos creados.</h1>
          @endif

          <!-- FIN VISTA DE TODOS LOS EMPLEADOS -->

          <!-- VISTA DE EMPLEADOS DE BAQ -->
          @if($empleadosbaq) 
          <div class="row barranquilla hidden">
            @foreach($empleadosbaq as $empleado)
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background: gray; color: white"><h3>{{$empleado->nombres}} {{$empleado->apellidos}}</h3><span>@if($empleado->tipo_contrato==='PRESTACION DE SERVICIOS'){{'CONTRATISTA'}}@elseif($empleado->tipo_contrato==='INDEFINIDO'){{'EMPLEADO'}}@elseif($empleado->tipo_contrato==='PASANTE'){{'PASANTE'}}@elseif($empleado->tipo_contrato==='DEFINIDO'){{'EMPLEADO'}}@endif</span><span style="float: right; margin-top: -60px; background: orange; padding: 3px">{{$empleado->sede}}</span></div>
                    <div class="panel-body" style="height: 100%">
                      <div class="row">
                          <!-- Fin división de datos -->
                          <div class="col-md-8">                            
                            <p style="font-family: cursive;"><b>CÉDULA: </b>{{$empleado->cedula}}</p>
                            <p style="font-family: cursive;"><b>TELÉFONO: </b>{{$empleado->telefono}}</p>
                            <p style="font-family: cursive;"><b>EMAIL: </b>{{$empleado->correo}}</p>
                            <p style="font-family: cursive;"><b>DIRECCIÓN: </b>{{$empleado->direccion}}</p>
                            <p style="font-family: cursive;"><b>BARRIO: </b>{{$empleado->barrio}}</p>
                            <p style="font-family: cursive;"><b>ÁREA: </b>{{$empleado->area}}</p>
                            <p style="font-family: cursive;"><b>CARGO: </b>{{$empleado->cargo}}</p>
                            <p style="font-family: cursive;"><b>TIPO CONTRATO: </b>{{$empleado->tipo_contrato}}</p>
                            <p style="font-family: cursive;"><b>FECHA DE INGRESO: </b>{{$empleado->fecha_ingreso}}</p>
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
                                  @if($empleado->hoja_de_vida==1)
                                    <a type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}" disabled>Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @else
                                    <a href="../biblioteca_imagenes/talentohumano/hojas/{{$empleado->hoja_de_vida}}" type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}">Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @endif
                                  
                                </div>                                
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="editar" type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @else
                                    <button id="editar" disabled type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @endif
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->retirar==='on')
                                    <button id="retirar" type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @else
                                    <button id="retirar" disabled type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @endif
                                </div>  
                                <div class="col-md-2">
                                  @if($empleado->historial!=null)
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning">HISTORIAL</a>
                                  @else
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning disabled">HISTORIAL</a>
                                  @endif                                
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="foto" type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
                                  @else
                                    <button id="foto" disabled type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
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
          <h1 style="text-align: center;">No hay empleados operativos creados.</h1>
          @endif    

        <!-- FIN VISTA DE EMPLEADOS BAQ -->

        <!-- INICIO VISTA DE EMPLEADOS BOG -->
        @if($empleadosbog) 
          <div class="row bogota hidden">
            @foreach($empleadosbog as $empleado)
              <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background: gray; color: white"><h3>{{$empleado->nombres}} {{$empleado->apellidos}}</h3><span>@if($empleado->tipo_contrato==='PRESTACION DE SERVICIOS'){{'CONTRATISTA'}}@elseif($empleado->tipo_contrato==='INDEFINIDO'){{'EMPLEADO'}}@elseif($empleado->tipo_contrato==='PASANTE'){{'PASANTE'}}@elseif($empleado->tipo_contrato==='DEFINIDO'){{'EMPLEADO'}}@endif</span> <span style="float: right; margin-top: -60px; background: orange; padding: 3px">{{$empleado->sede}}</span> </div>
                    <div class="panel-body" style="height: 100%">
                      <div class="row">
                          <!-- Fin división de datos -->
                          <div class="col-md-8">                            
                            <p style="font-family: cursive;"><b>CÉDULA: </b>{{$empleado->cedula}}</p>
                            <p style="font-family: cursive;"><b>TELÉFONO: </b>{{$empleado->telefono}}</p>
                            <p style="font-family: cursive;"><b>EMAIL: </b>{{$empleado->correo}}</p>
                            <p style="font-family: cursive;"><b>DIRECCIÓN: </b>{{$empleado->direccion}}</p>
                            <p style="font-family: cursive;"><b>BARRIO: </b>{{$empleado->barrio}}</p>
                            <p style="font-family: cursive;"><b>ÁREA: </b>{{$empleado->area}}</p>
                            <p style="font-family: cursive;"><b>CARGO: </b>{{$empleado->cargo}}</p>
                            <p style="font-family: cursive;"><b>TIPO CONTRATO: </b>{{$empleado->tipo_contrato}}</p>
                            <p style="font-family: cursive;"><b>FECHA DE INGRESO: </b>{{$empleado->fecha_ingreso}}</p>
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
                                  @if($empleado->hoja_de_vida==1)
                                    <a type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}" disabled>Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @else
                                    <a href="../biblioteca_imagenes/talentohumano/hojas/{{$empleado->hoja_de_vida}}" type="button" name="button" data-toggle="modal" class="btn btn-primary" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" target="_blank" title="Descargar: {{$empleado->hoja_de_vida}}">Descargar Hoja de Vida <i class="fa fa-download" aria-hidden="true"></i></a>
                                  @endif
                                  
                                </div>                                
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="editar" type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @else
                                    <button id="editar" disabled type="button" name="button" data-toggle="modal" class="btn btn-success editar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Editar <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                  @endif
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->retirar==='on')
                                    <button id="retirar" type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @else
                                    <button id="retirar" disabled type="button" name="button" data-toggle="modal" class="btn btn-danger retirar" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Retirar <i class="fa fa-times" aria-hidden="true"></i></button>
                                  @endif
                                </div>  
                                <div class="col-md-2">
                                  @if($empleado->historial!=null)
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning">HISTORIAL</a>
                                  @else
                                    <a href="{{url('talentohumano/historial/'.$empleado->id)}}" target="_blank" class="btn btn-warning disabled">HISTORIAL</a>
                                  @endif                                
                                </div>
                                <div class="col-md-2">
                                  @if($permisos->talentohumano->empleados->editar==='on')
                                    <button id="foto" type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
                                  @else
                                    <button id="foto" disabled type="button" name="button" data-toggle="modal" class="btn btn-info foto" data-empleado-id="{{$empleado->id}}" data-nombre="{{$empleado->nombres}}" >Foto <i class="fa fa-photo" aria-hidden="true"></i></button>
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
          <h1 style="text-align: center;">No hay empleados operativos creados.</h1>
          @endif    

        <!-- FIN VISTA EMPLEADOS BOG -->

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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            <button type="button" class="btn btn-primary guardar_retiro">RETIRAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN MODAL DE RETIRO -->

  <!-- MODAL DE FECHA DE FOTO -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_foto'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">FOTO DE USUARIO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
              <input type="text" name="empleado" class=" hidden empleado" id="empleado">
              <!-- foto user -->
              <form id="upload_imagen_conductor">
              <div class="contenedor_imagen_perfil" style="margin: -50px">
                  <input id="foto_perfil" type="file" value="Subir" name="foto_perfil" class="perfil">
                  <center>
                  <img id="imagen_perfil"style="width: 200px; height: 240px; border-radius: 40%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" class="img-thumbnail" src="http://placehold.it/250x316">
                  </center>
                  <div class="icon_spin hidden">
                    <i class="fa fa-spin fa-spinner"></i>
                  </div>
              </div>
            </form>
              <!-- fin foto user -->
            
          </div>
          <div class="modal-footer">            
            <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN MODAL DE FOTO -->

  <!-- MODAL DE EDICIÓN -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_editar'>
      <div class="modal-lg" role="document">
        <div class="modal-content" style="margin-left: 240px; width: 100%; margin-top: 20px">
          <div class="modal-header">
            <h3 class="modal-title" style="text-align: center;">MODIFICACIÓN DE EMPLEADO</h3>
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
                  <label class="obligatorio" for="tipo_personaledit" >Personal</label>
                  <select class="form-control input-font" name="tipo_personaledit" id="tipo_personaledit">
                      <option >-</option>
                      <option >ADMINISTRATIVO</option> 
                      <option >OPERATIVO</option>    
                      <option >RETIRADO</option>    
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label for="sedeedit"> SEDE</label>
                  <select class="form-control input-font" name="sedeedit" id="sedeedit">
                      <option >-</option>
                      <option >BARRANQUILLA</option> 
                      <option >CARTAGENA</option>    
                      <option >BOGOTA</option>    
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="areaedit" >Área</label>
                  <select class="form-control input-font" name="areaedit" id="areaedit">
                      <option >-</option>
                      <option >COMERCIAL</option>
                      <option >CONTABILIDAD</option>
                      <option >GESTION INTEGRAL</option>
                      <option >JURIDICA</option>
                      <option >MANTENIMIENTO</option>         
                      <option >SISTEMAS</option>
                      <option >TALENTO HUMANO</option>
                      <option >OPERACIONES</option>
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label for="cargoedit">Cargo</label>
                  <input class="form-control input-font" type="text" id="cargoedit" name="cargoedit" placeholder="cargo">
              </div>              
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="fecha_ingresoedit">Ingreso</label>
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
                  <label class="obligatorio" for="tipo_contratoedit" >Contrato</label>
                  <select class="form-control input-font" name="tipo_contratoedit" id="tipo_contratoedit">
                      <option >-</option>
                      <option >PASANTE</option> 
                      <option >PRESTACION DE SERVICIOS</option>    
                      <option >DEFINIDO</option>
                      <option >INDEFINIDO</option>
                  </select>
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="salarioedit">Salario</label>
                  <input class="form-control input-font" type="number" id="salarioedit" placeholder="SALARIO" value="">
              </div>
              <div class="col-lg-3 col-sm-12 col-xs-12">
                  <label class="obligatorio" for="correoedit">Correo</label>
                  <input class="form-control input-font" type="text" id="correoedit" placeholder="CORREO ELECTRÓNICO">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3">
                  <label class="obligatorio" for="ciudadedit" >Ciudad</label>
                  <input class="form-control input-font" type="text" id="ciudadedit" placeholder="CIUDAD">
              </div>
              <div class="col-lg-3">
                  <label class="obligatorio" for="direccionedit" >Dirección</label>
                  <input class="form-control input-font" type="text" id="direccionedit" name="direccionedit" placeholder="DIRECCIÓN">
              </div>
              <div class="col-lg-3">
                  <label class="obligatorio" for="barrioedit" >Barrio</label>
                  <input class="form-control input-font" type="text" id="barrioedit" placeholder="BARRIO">
              </div>
              <div class="col-lg-2">
                <label class="obligatorio" style="margin-top: 5px" for="hojadevidaedit" >Hoja de Vida</label>

                <!-- BOTÓN PARA MOSTRAR LA HOJA DE VIDA ANTERIORMENTE GUARDADA-->
                <a type="button" name="button" data-toggle="modal" class="btn btn-secondary boton_hoja hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Vista Previa Hoja de Vida   <i class="fa fa-eye" aria-hidden="true"></i></a>

                <!-- BOTÓN PARA INSERTAR HOJA DE VIDA ESCONDIDO-->
                <input type="file" class="form-control hoja hidden" name="hoja_de_vida" id="hoja_de_vida" accept="application/pdf" data-filename-placement="inside">

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
   <div class="modal fade mymodal2" tabindex="-1" role="dialog" id='modal'>
      <div class="modal-lg" role="document">
        <div class="modal-content" style="margin-left: 230px; width: 100%; margin-top: 20px">
          <div class="modal-header" style="background: orange">
            <h3 class="modal-title" style="text-align: center;">REGISTRO DE EMPLEADO</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id="container-fluid" style="margin-top: -80px">
                
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
                                        <option disabled>-</option>
                                        <option disabled="">ADMINISTRATIVO</option> 
                                        <option >OPERATIVO</option>    
                                        <option disabled>RETIRADO</option>    
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label for="sede"> SEDE</label>
                                    <select class="form-control input-font" name="sede" id="sede">
                                        <option >-</option>
                                        <option >BARRANQUILLA</option>
                                        <option >CARTAGENA</option>
                                        <option >BOGOTA</option>
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
                                        <option >OPERACIONES</option>
                                    </select>
                                </div>
                                
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label for="cargo">CARGO</label>
                                    <input class="form-control input-font" type="text" id="cargo" name="cargo" placeholder="cargo">
                                </div>                                
                                <div class="col-lg-3 col-sm-12 col-xs-12">
                                    <label class="obligatorio" for="fecha_ingreso">FECHA DE INGRESO</label>
                                   <div class="form-group">
                                      <div class="input-group">
                                          <div class='input-group date' id='datetimepicker1'>
                                              <input id="fecha_ingreso" name="fecha_ingreso" style="width: 150px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                                    <input class="form-control input-font" type="number" id="salario" placeholder="SALARIO" value="">
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
                          <!--<div class="row">
                            <div class="col-xs-4">            
                              <div class="contenedor_imagen_perfil">
                                  <input id="foto_perfil" type="file" value="Subir" name="foto_perfil" class="image_perfil">
                                  <img id="imagen_perfil"style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" class="img-thumbnail" src="http://placehold.it/250x316">
                                  <div class="icon_spin hidden">
                                    <i class="fa fa-spin fa-spinner"></i>
                                  </div>
                              </div>
                              </div>
                          </div>-->
                          
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
    <script src="{{url('jquery/talentohumano.js')}}"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    
    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

  </body>
</html>
