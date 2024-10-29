<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Gestión de Usuarios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
   <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{$_ENV['API_KEY_GOOGLE_MAPS']}}" async defer></script>-->
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

<body onload="nobackbutton();">
@include('admin.menu')

<h1 style="margin: 0 10px 10px 16px" class="h_titulo">INGRESO DE USUARIOS DE FORMA MASIVA</h1>

<!--<img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/1140835204.png" />-->

 <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 470px;">
    <form style="display: inline" id="form_ruta">
        <div class="row">
          <div class="col-md-3" style="margin: 0 0 10px 0">
                <select id="centrodecosto_select" style="width: 100%;" class="form-control input-font" name="centrodecosto">
                    <option value="0">CENTROS DE COSTO</option>
                    @foreach($centrosdecosto as $centro)
                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                    @endforeach
                </select>
          </div>
           <div class="col-md-3">
             <input id="importar" type="file" value="Subir" name="excel" >
           </div>
           <!--<div class="col-md-4">
             <a style="float: right;" id="wompi" class="btn btn-success btn-icon">Crear Links de Pago<i class="fa fa-money icon-btn" aria-hidden="true"></i></a>
           </div>-->
        </div>
    </form>

   <table name="mytable" id="pasajeros_import" class="table table-hover table-bordered tablesorter">
      <thead>
        <tr>
         <td>#</td>
          <td>CONTRATO</td>
          <td>TIPO RUTA</td>
          <td>NOMBRE ESTUDIANTE</td>
          <td>CURSO</td>
          <td>TELEFONO</td>
          <td>DIRECCION</td>
          <td>BARRIO</td>
          <td>LOCALIDAD</td>
          <td>ZONA</td>
          <td>NOMBRE DEL PADRE</td>
          <td>VALOR</td>
          <td>RUTA</td>
          <!--<td>EPS</td>
          <td>ARL</td>
          <td>CENTRO DE COSTO</td>-->
         <!-- <td>ELIMIANR</td>
          <td>MODIFICAR</td>
          <td>QR code</td> -->
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>


     <!-- <a class="btn btn-info btn-icon" id="add_pax_ruta">AGREGAR<i class="fa fa-plus icon-btn"></i></a> -->

  </div>
  <div >
      <a style="float: right; margin: 10px 20px 0 30px;" id="guardar_usuarios" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
      <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
      <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
    <!--  <a style="float: right; background: orange;" id="cambiar_centrodecosto" class="btn btn-primary btn-icon ">CAMBIAR CENTRO DE COSTO<i class="fa fa-edit icon-btn" aria-hidden="true"></i></a> -->
  </div>


<!--MODAL PARA EDITAR PASAJEROS DE RUTAS-->




@include('scripts.scripts')

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/escolar.js')}}"></script>


<script>
  //inicializar variables

  $('input[type=file]').bootstrapFileInput();
  $('.file-inputs').bootstrapFileInput();


</script>

<script type="text/javascript">

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);

    }
    window.onunload=function(){
    window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

    function nobackbutton(){

       window.location.hash="no-back-button";

       window.location.hash="Again-No-back-button" //chrome

       window.onhashchange=function(){
         window.location.hash="no-back-button";
       }
    }

</script>
</body>
</html>
