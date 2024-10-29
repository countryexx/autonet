<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Enlace caducado</title>
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
<body>
  
  <div class="text-center">
    <div class="row">
      <div class="col-md-12">
        <img style="margin-top: 20px;" src="{{url('img/logo_aotour.png')}}" width="200px;">
        <h1 style="color: black">Enlace caducado!</h1>
        <br>
      </div>
    </div>		
  </div>
  
</body>
</html>
