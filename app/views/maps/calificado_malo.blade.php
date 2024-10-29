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
        <div class="col-xs-3 col-xs-offset-2">
            <img src="{{url('img/logo_aotour_peq.png')}}" style="margin-top: 10px; margin-left: 40px">
        </div>        
    </div>
    <br><br>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px; background-color: #f47321">
                    <center> <h2 style="color: white; text-align: justify;">¡Wow, al parecer tu experiencia no fue la que esperábamos!</h2>
                    <p style="color: white; text-align: justify;">Para nosotros es muy importante que quedes con ganas de volver a encontrarnos, por lo cual nuestro equipo del servicio al cliente se comunicara con usted para que puedas vivir la verdadera experiencia <span style="color: gray">AOTOUR</span>.</p>                    
                </div></center>
            </div>


        </div>
    </div>
@include('scripts.scripts')
</body>
</html>
