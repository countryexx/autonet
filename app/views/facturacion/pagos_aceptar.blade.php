<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Pagos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="" style="font-family: cursive; font-size: 60px; margin: 20px 0 60px 0;">ACEPTAR CAMBIOS</h3>
     
      <div class="col-lg-4">
      </div>
      <div class="col-lg-12">
        <div class="row">
          <table style="margin-top: 15px;" class="table table-bordered" id="tabla_pasajeros">
            <thead>
              <tr>
                <th>#</th>
                <th>ID de Servicio</th>
                <th>Cobro Unitario</th>
                <th>Pago Unitario</th>
                <th>Cobro total</th>
                <th>Pago total</th>
                <th>Utilidad</th>
                <th>Fecha de actualización</th>                
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($pagos as $pago)
                  <tr data-pago-id="{{$pago->id}}" onClick="selODessel(this)">
                    <td>{{$i}}</td>
                    <td>{{$pago->proveedor}}</td>
                    <td>{{$pago->total_neto}}</td>
                    <td>{{$pago->usuario}}</td>
                    <td>{{$pago->preparado}}</td>
                    <td>{{$pago->preparado_por}}</td>
                    <td>{{$pago->created_at}}</td>
                    <td>{{$pago->updated_at}}</td>
                                        
                    <td>
                      <button buscar-pago-id="{{$pago->id}}" class="btn btn-success aprobar_cambio">ACEPTAR</button>                     
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--
      <div class="col-lg-12">
        <div class="col-lg-4">
          <button class="btn btn-danger eliminar_pasajeros"  data-toggle="modal">ELIMINAR SELECCIONADOS</button>
          <button class="btn btn-success importar" data-toggle="modal">IMPORTAR</button>
          <button class="btn btn-success enviar" data-toggle="modal">ENVIAR CORREO</button>
        </div>
      </div> 
      -->
    </div>
  </div>
</div>

<!--Modal Guardar pasajeros-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_pasajeros'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form_crear_pasajero">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Nuevo Pasajero</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                @include('servicios.pasajeros.inputs')
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal Editar pasajeros-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_pasajeros_editar'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form_editar_pasajeros">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edición de Pago a Proveedor</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                @include('facturacion.inputs')
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!---->

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
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pagos.js')}}"></script>
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

