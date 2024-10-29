<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Configuracion</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>

@include('admin.menu')
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <h6>DATOS DE USUARIO</h6>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Informacion</th>
        </tr>
        </thead>
        <tbody>
            <td>{{Sentry::getUser()->first_name}}</td>
            <td>{{Sentry::getUser()->last_name}}</td>
            <td><a class="btn-primary btn" id="contrasena">CAMBIAR CONTRASEÑA <i class="fa fa-lock"></i></a></td>
        </tbody>
    </table>
</div>
@if(Sentry::getUser()->id_rol!=35 and Sentry::getUser()->id_rol!=51)
<div class="col-xs-12">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="panel panel-primary">
        <form id="form_firma_usuario">
          <div class="panel-heading">
            <strong>FIRMA DE CORREO</strong>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="">Nombre completo</label>
              <input type="text" name="nombre_completo" class="form-control input-font" placeholder="Nombre que aparecera en la firma" value="@if(count($firma_correo)){{$firma_correo->nombre_completo}}@endif" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="">Nombre del puesto</label>
              <input type="text" name="nombre_puesto" class="form-control input-font" placeholder="Nombre del puesto en la empresa" value="@if(count($firma_correo)){{$firma_correo->nombre_puesto}}@endif" autocomplete="off">
            </div>
          </div>
          <div class="panel-footer">
            <button type="submit" name="button" class="btn btn-primary">GUARDAR</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endif
<div class="contenedor_informacion_usuario hidden">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <strong>EDITAR USUARIO</strong><i id="cerrar_alerta" style="float: right; font-weight:100; margin-top: 2px; cursor: pointer;" class="fa fa-close"></i>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="obligatorio" for="nombres">Contraseña</label>
                        <input class="form-control" type="password" name="editar_contrasena" value="">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 editar_contrasena">
                        <div class="has-feedback">
                            <label class="control-label" for="editar_repetir_contrasena">Repetir Contraseña</label>
                            <input name="editar_repetir_contrasena" type="password" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button id="cambiar_contrasena" class="btn btn-primary btn-icon" type="button" name="button" data-id="{{Sentry::getUser()->id}}">GUARDAR<i class="fa fa-refresh icon-btn"></i></button>
            </div>
        </div>
    </div>
</div>



@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="{{asset('jquery/usuarios.js')}}">

</script>
</body>
</html>
