<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Pasajeros</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
    <div class="col-lg-5">
      
    </div>
    <div class="col-lg-12">
      <div class="row">
        <h3 class="h_titulo">LISTADO DE USUARIOS REGISTRADOS | {{$cliente}}</h3>
        <div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">
          <div class="row">
                       
          </div>
        </div>
      </div>
    </div>

    @if(isset($pasajeros))

      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>EMPLOY ID</th>
                <th>NOMBRE COMPLETO</th>
                <th>CÉDULA</th>
                <th>DIRECCIÓN</th>
                <th>TELÉFONO</th>
                <th>EMAIL</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>EMPLOY ID</th>
            <th>NOMBRE COMPLETO</th>
            <th>CÉDULA</th>
            <th>DIRECCIÓN</th>
            <th>TELÉFONO</th>
            <th>EMAIL</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>

          @foreach($pasajeros as $pasajero)
            <tr >
              <td>{{$pasajero->id_employer}}</td>
              <td>{{$pasajero->nombres.' '.$pasajero->apellidos}}</td>
              <td>{{$pasajero->cedula}}</td>
              <td>{{$pasajero->direccion}}</td>
              <td>{{$pasajero->telefono}}</td>
              <td>{{$pasajero->correo}}</td>
              <td id="{{$pasajero->id}}">

                <button data-pasajero-id="{{$pasajero->id}}" class="btn btn-info mostrar_qr">Mostrar QR<i style="font-size: 17px" class="fa fa-qrcode" aria-hidden="true"></i>
                </button>

                <a href="{{'listadousuariosqr/descargarcodigoqr/'.$pasajero->id}}" class="btn btn-success ">DESCARGAR<i class="fa fa-download" aria-hidden="true"></i></a>

              </td>              
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif    
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
    
</div>

<!--Modal QR-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_qr'>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Codigo QR</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12" align="center">
              <img id="imagen_qr">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

</script>
</body>
</html>
