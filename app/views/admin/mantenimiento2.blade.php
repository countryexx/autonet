<!doctype html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Autonet | Mantenimiento</title>
</head>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-toggle-master\css\bootstrap-toggle.min.css')}}">
<body style="background-color: #F32003">
    <div class="container">
        <img style="margin-top: 230px;" src="{{url('img/logo_aotour.png')}}"><br>
        <h1 style="color: white">SECCIÓN EN MANTENIMIENTO <i class="fa fa-cog" aria-hidden="true"></i></h1>
        <h4 style="color: white">Disculpa las molestias, estamos realizando cambios en esta sección.</h4>        
    </div>  
    <form action="downloadpdf" method="get">
    <div>
    <div class="col-md-2">
        <label class="obligatorio" for="nombrep">Nombre Proveedor</label>
        <input type="text" name="nombrep" id="nombrep" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="nombrec">Nombre Conductor</label>
        <input type="text" name="nombrec" id="nombrec" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="ciudadpdf">Ciudad</label>
        <input type="text" name="ciudadpdf" id="ciudadpdf" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="fechapdf">Fecha</label>
        <input type="text" name="fechapdf" id="fechapdf" class="form-control input-font">
    </div>    
    <div class="col-md-2">
        <label class="obligatorio" for="placapdf">Placa</label>
        <input type="text" name="placapdf" id="placapdf" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="tipovehiculopdf">Tipo Vehiculo</label>
        <input type="text" name="tipovehiculopdf" id="tipovehiculopdf" class="form-control input-font">
    </div>
    <div class="col-md-2">
        <label class="obligatorio" for="telefonopdf">Telefono</label>
        <input type="text" name="telefonopdf" id="telefonopdf" class="form-control input-font">
    </div>

    <button type="submit" id="pdf1" style="background: #FF1700; color: white; margin: 25px 0 50px 50px;" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn pdf1"></i></button>
  </div>
</form>      
@include('scripts.scripts')
<script>
    function goBack(){
        window.history.back();
    }
</script>
</body>
</html>
