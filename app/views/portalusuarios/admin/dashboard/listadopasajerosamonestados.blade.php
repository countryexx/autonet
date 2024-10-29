<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Exportar Pasajeros</title>
   <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">

  <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
  <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{url('animate.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="manifest" href="{{url('manifest.json')}}">
  @include('scripts.styles')
  
  <link rel="stylesheet" href="{{url('distdash/css/AdminLTE.min.css')}}">
  
  <link rel="stylesheet" href="{{url('distdash/css/skins/_all-skins.min.css')}}">
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
    <div class="row" style="margin-left: 1px; margin-top: 20px">
      <div class="col-lg-6" style="float: left;">
        <a href="{{URL::previous()}}" class="btn btn-primary">
         <i class="fa fa-arrow-left" aria-hidden="true"></i>    REGRESAR 
        </a>
      </div>            
    </div>
    <section class="content">      
      <div class="row">

        <!--vista 2 -->
        <div class="col-lg-6">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>
              <h3 class="box-title">USUARIOS AMONESTADOS</h3>                            
            </div>
              
        <div class="row" style="width: 100%; margin-left: 0px;">
          <table  class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>NOMBRE COMPLETO</th>               
                <th>CANTIDAD DE AMONESTACIONES</th>
              </tr>
            </thead>
            <tbody>                      
                  <tr>                        
                      <td>1</td> 
                      <td> 
                    
                       </td>
                      <td> 
                        <i class="fa fa-flag" aria-hidden="true"></i>                        
                     </td>                                
                  </tr>
                  
            </tbody>
          </table>
        </div>
        
      </div>
        <!-- fin vista 2 -->
      </div>
      
      
    </section>

    @include('portalusuarios.admin.modales.modalserviciosrealizados')
    @include('scripts.scripts')
    
</body>

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
