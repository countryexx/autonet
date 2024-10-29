<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autonet | Mantenimiento</title>
</head>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-toggle-master\css\bootstrap-toggle.min.css')}}">
<body>
@include('admin.menu')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                    <h1>SECCIÓN EN MANTENIMIENTO <i class="fa fa-cog" aria-hidden="true"></i></h1>
                    <p>Disculpa las molestias, estamos realizando cambios en esta sección.</p>
                    <p><a class="btn btn-primary btn-lg" onclick="goBack()" role="button">VOLVER</a></p>
                </div>
            </div>


        </div>
    </div>
@include('scripts.scripts')
<script>
    function goBack(){
        window.history.back();
    }
</script>
</body>
</html>
