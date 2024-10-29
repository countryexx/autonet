<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="url" content="{{url('/')}}">
    
    <title>AOTOUR | Asignación de Ruta</title>
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

    </style>
  </head>
  <body>
    @include('transportederuta.nabvar')
  
    <div class="col-lg-12">

      <h4 class="h_titulo" style="font-size: 25px;"><b style="font-size: 20px;">Asignación de Ruta</b></h4>

      <div class="row">
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                    <h1>NO DISPONIBLE</h1>
                    <p>El código QR al que estás intentando acceder no está disponible.</p>
                    <p><a class="btn btn-primary btn-lg" onclick="goBack()" role="button">Cerrar Ventana</a></p>
                </div>
            </div>


        </div>
    </div>

      </div>
        
    </div>
    @include('scripts.scripts')
    <script>
        function goBack(){
          console.log('test')
           window.close();
        }
    </script>
  </body>
</html>
