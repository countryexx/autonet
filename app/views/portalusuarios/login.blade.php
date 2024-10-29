<html>
<head>
    <meta charset="UTF-8">
    <title>Portal de usuarios | AO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
</head>
<body class="login1">
    <div class="container" style="margin-top:50px">
        <div class="img-logo" style="margin-bottom:20px">
            <img class="img-responsive center-block" src="{{url('img/marker3.png')}}">
        </div>
        
        <div class="login-container">
            <div class="col-lg-12">
                <div class="row">
                    <form id="formulario">
                        <div style="margin-bottom: 10px" class="form-group usuario">
                            <label class="login-font" for="usuario">Usuario</label>
                            <input class="form-control input-shadow input-font" type="text" id="usuario" name="usuario">
                        </div>
                        <div style="margin-bottom: 5px;" class="form-group contrasena">
                            <label class="login-font" for="contrase�a">Contrase&ntildea</label>
                            <input class="form-control input-shadow" type="password" id="contrase�a" name="password">
                        </div>
                        <div style="margin-bottom: 5px;" class="form-group recordarme">
                          <input name="recordarme" id="recordarme" style="position: absolute" type="checkbox">
                          <label for="recordarme" style="margin-left: 20px" class="login-font">No cerrar sesion</labeL>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block boton" id="login">ENTRAR <i class="fa fa-sign-in"></i></button>
                    </form>
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
@include('scripts.scripts')
<script src="{{url('jquery\loginportal.js')}}"></script>
</body>
</html>
