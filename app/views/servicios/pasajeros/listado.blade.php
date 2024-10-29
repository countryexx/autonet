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
        <h3 class="h_titulo">LISTADO DE USUARIOS REGISTRADOS | SGS COLOMBIA HOLDING BOGOTA</h3>
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

          @foreach($pasajeros as $proveedor)
            <tr >
              <td>{{$proveedor->id_employer}}</td>
              <td>{{$proveedor->nombres.' '.$proveedor->apellidos}}</td>
              <td>{{$proveedor->cedula}}</td>
              <td>{{$proveedor->direccion}}</td>
              <td>{{$proveedor->telefono}}</td>
              <td>{{$proveedor->correo}}</td>
              <td id="{{$proveedor->id}}">
                <form id="form" action="{{url('descargarcodigoqr')}}" method="post">
                <!--<a data-toggle="modal" data-target=".modal_editar" class="btn btn-list-table btn-primary editar_cliente" id="{{$proveedor->id}}">EDITAR</a> 
                
                    <a class="btn btn-warning btn-list-table" href="proveedores/conductores/{{strtolower($proveedor->id)}}">ELIMINAR</a> 
                    <a data-toggle="modal" data-target=".modal_editar" class="btn btn-list-table btn-primary editar_cliente" id="{{$proveedor->id}}">MOSTRAR QR <i class="fa fa-qrcode" aria-hidden="true"></i></a>-->
                    <button data-pasajero-id="{{$proveedor->id}}" class="btn btn-info mostrar_qr">Mostrar QR
                        <i style="font-size: 17px" class="fa fa-qrcode" aria-hidden="true"></i>
                    </button>
                    <input type="text" class="hidden" name="codeinfo" id="codeinfo" value="{{$proveedor->id}}">
                    <button pasajero_id="{{$proveedor->id}}" class="btn btn-success descargarqr">Descargar QR <i class="fa fa-download" aria-hidden="true"></i></button>  

                    </form>
              </td>              
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif    
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
    
</div>
<div class="modal fade modal_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario_subcentro">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <strong>EDITAR PASAJERO</strong>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="nombre_completo_editar">Nombres</label>
                                        <input class="form-control input-font" type="text" id="nombre_completo_editar">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="cc_editar">Apellidos</label>
                                        <input class="form-control input-font" type="text" id="apellidos">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="direccion_editar">Cédula</label>
                                        <input class="form-control input-font" type="text" id="cedula">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="celular_editar">Correo</label>
                                        <input class="form-control input-font" type="text" id="correo">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="telefono_editar">Telefono</label>
                                        <input class="form-control input-font" type="text" id="telefono_editar">
                                    </div>                                    
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="email_editar">Dirección</label>
                                        <input class="form-control input-font" type="text" id="direccion" autocomplete="off">
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="actualizar_cliente" class="btn btn-primary btn-icon">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></button>
                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>


<div class="errores-modal bg-danger text-danger hidden model" style="top: 10%;">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
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
