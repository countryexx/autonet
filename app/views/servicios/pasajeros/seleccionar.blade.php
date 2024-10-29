<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Consultar Dashboard</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
   
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      [data-notify="progressbar"] {
          margin-bottom: 0px;
          position: absolute;
          bottom: 0px;
          left: 0px;
          width: 100%;
          height: 5px;
      }

    </style>
</head>
<body>
  @include('admin.menu')
  <div class="container-fluid">
   <!-- <center><iframe src="https://app.aotour.com.co/autonet/dashboard/obtenerdatos" width="100%" height="700"> </iframe></center>    -->
   <h1>
     DASHBOARD
   </h1>

  </div>
  
  @include('scripts.scripts')
    
</body>
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/conductores.js')}}"></script>

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
<script></script>
<script language="JavaScript" type="text/JavaScript">
  function selODessel(obj){
    if(obj.checked){
        console.log("chulado")
    }else{
        //desSeleccionarTodos();
        console.log("DesChulado")
    }
  }

  function seleccionarTodos(){
    alert("Selecciono todos")
  }
  function desSeleccionarTodos(){
    alert("Desselecciono todos")
  }
  

</script>
</html>