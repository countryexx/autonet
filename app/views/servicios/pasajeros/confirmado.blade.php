<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Conductas dentro del vehículo</title>
  @include('scripts.styles')
  <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <style media="screen">
      div.textarea{
        overflow-y: scroll;
        min-height: 300px;
        font-size: 14px;
      }
    </style>
</head>
<body >
<center>
	
		<div class="text-center">
      <img style="margin-top: 10px;" src="{{url('img/logo_aotour.png')}}" width="200px;">
  		</div>
  		<h2 style="color: black">Estás a un paso de completar tu registro!</h2>  		
      <br>
      <h4 style="color: black"> Por favor, acepta los términos de conducta.</h4>
  		
  		<h1 style="color: orange;">#AOTOURTEMUEVE</h1>
      
      <div class="row">
          <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2 col-xs-12">              
              <h5 class="text-center">
                <strong>RECOMENDACIONES PREVIAS</strong><br><br>
                <p>Tómate el tiempo de leer</p>
              </h5>
              <div class="form-group">
                <label for="">
                </label>
                <div class="form-control textarea">
                  @include('portalusuarios.politicas')
                </div>
              </div>
              <!--<form id="formulariosave">-->
                <div class="col-xs-12">
                  <div class="row">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 @if($errors->has('cc')) {{'has-error'}} @endif">                      
                    </div>
                  </div>
                </div>
                <div class="form-group">                  
                  <label style="margin-right: 5px; display: inline;">Notifico que he leido y he entendido la recomendaciones que me han sido suministradas.</label>
                  <input type="checkbox" name="aceptar_politicas" class="aceptar_politicas" style="vertical-align: sub;">                  
                  @if ($errors->has('aceptar_politicas'))
                      <br><small class="text-danger">{{$errors->first('aceptar_politicas')}}</small>
                  @endif
                </div>
                <button type="button" id="guardar2" class="btn btn-primary" name="button" style="margin-bottom: 30px">ENVIAR</button>
              <!--</form>-->
          </div>
        </div>

	
</center>
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
</body>
</html>
