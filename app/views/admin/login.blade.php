<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Bienvenidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    @include('scripts.styles')
</head>
<body class="login">
    <div class="container" style="margin-top:50px">
        <div class="img-logo" style="margin-bottom:20px">
            <img class="img-responsive center-block" src="{{url('img/logo_blanco.png')}}">
        </div>
        <div class="img-powered" style="margin-bottom:50px">
            <img class="img-responsive center-block" src="{{url('img/powered.png')}}">
        </div>
        <div class="login-container">
            <div class="col-lg-12">
                <div class="row">
                    <form id="formulario">
                        <div style="margin-bottom: 10px" class="form-group usuario">
                            <label class="login-font" for="usuario">Usuario / Correo electrónico</label>
                            <input class="form-control input-shadow input-font" type="text" id="usuario" name="usuario">
                        </div>
                        <div style="margin-bottom: 5px;" class="form-group contrasena">
                            <label class="login-font" for="contrase�a">Clave</label>
                            <input class="form-control input-shadow" type="password" id="contrase�a" name="password">
                        </div>
                        <div style="margin-bottom: 5px;" class="form-group recordarme">
                          <input name="recordarme" id="recordarme" style="position: absolute" type="checkbox">
                          <label for="recordarme" style="margin-left: 20px" class="login-font">No cerrar sesion</labeL>
                        </div>
                        <!--<div style="margin-bottom: 5px;" class="form-group recordarme">
                          <input name="qruser" id="qruser" style="position: absolute" type="checkbox">
                          <label for="qruser" style="margin-left: 20px" class="login-font">QR User</labeL>
                        </div>-->
                        <button type="submit" class="btn btn-primary btn-block boton" id="login">ENTRAR <i class="fa fa-sign-in"></i></button>
                    </form>
                    <div style="margin-top: 25px;" class="form-group recordarme">
                      <center>
                        <a id="forget" style="color: white">Olvidé mi clave</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Session::get('mensaje'))
    <div class="guardado bg-success text-success model">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        {{$mensaje = Session::get('mensaje')}}
    </div>
    @endif
    <div class="errores-modal bg-danger text-danger hidden model">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" id='modal_password'>
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f47321">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name">Recuperación de Clave</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="margin-bottom: 10px" class="form-group usuario">
                            <label for="usuario">Correo electrónico</label>
                            <input class="form-control input-font" type="email" id="correo" name="correo" placeholder="Ingrese aquí su correo">
                        </div>
                        <button id="clave_temporal" class="btn btn-primary btn-block clave_temporal" id="login">Generar nueva Clave <i id="no_spinner" class="fa fa-share-square"></i> <i id="spinner" class="fa fa-spinner fa-spin hidden"></i> <i id="realizado" class="fa fa-check hidden"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>
    </div>

@include('scripts.scripts')
<script src="{{url('jquery\login.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
</body>
</html>
