<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <title>AOTOUR</title>
</head>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-toggle-master\css\bootstrap-toggle.min.css')}}">
<body>    
    <div class="row">
        <div class="col-md-4 col-md-offset-5">
            <img src="{{url('img/logo_aotour.png')}}" style="margin: 10px 0 0 15px">
        </div>        
    </div>
    <br><br>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px; background-color: #f47321">
                    <center> <h1 style="color: white;">¡Gracias!</h1>
                    <p style="color: white">Este servicio ya fue calificado!</p>                    
                </div></center>
            </div>


        </div>
    </div>
@include('scripts.scripts')
</body>
</html>