<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Acta Entrega</title>
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
    @include('admin.menu')
  
    <div class="col-lg-12">

      <h4>{{$acta->categoria}} {{$acta->marca}}</h4>
      
      <div class="row">

        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-2">
              <label style="text-align: center;">Firma de quien entrega</label><br>
              <img src="{{url('biblioteca_imagenes/firma_actas/'.$acta->firma_entrega)}}" style="width: 210px; height: 300px; border: white 6px solid;" id="imagen">
            </div>
            <div class="col-lg-6">
              <label style="text-align: center;">Firma de quien recibe</label><br>
              <img src="{{url('biblioteca_imagenes/firma_actas/'.$acta->firma_recibe)}}" style="width: 210px; height: 300px; border: white 6px solid;" id="imagen">
            </div>
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
    <script src="{{url('jquery/inventario.js')}}"></script>

    <script type="text/javascript">

    </script>

  </body>
</html>
