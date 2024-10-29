<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    <title>Aprobación de Cambios</title>
</head>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-toggle-master\css\bootstrap-toggle.min.css')}}">
<body>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                    <h1>No hay nada por aprobar por aquí... <i class="fa fa-check" aria-hidden="true"></i></h1>
                    <p>Posiblemente lo hayas aceptado antes!</p>
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
