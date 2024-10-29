<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de pasajeros 2</title>
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
      <h3>Listado de pasajero2</h3>
      <div class="col-md-4">
        <div class="row">
          <select style="margin-bottom: 10px;" class="form-control input-font" id="centrodecosto">
            @foreach ($centrosdecosto as $centrodecosto)
              <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-lg-4">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal_pasajeros">AGREGAR</button>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <table style="margin-top: 15px;" class="table table-bordered" id="tabla_pasajeros">
            <thead>
              <tr>
                <th>#</th>
                <th>Centro de costo</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cedula</th>
                <th>Direccion</th>
                <th>Barrio</th>
                <th>Cargo</th>
                <th>Area</th>
                <th>Sub Area</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($pasajeros as $pasajero)
                  <tr data-pasajero-id="{{$pasajero->id}}">
                    <td>{{$i}}</td>
                    <td>{{$pasajero->centrodecosto->razonsocial}}</td>
                    <td>{{$pasajero->nombres}}</td>
                    <td>{{$pasajero->apellidos}}</td>
                    <td>{{$pasajero->cedula}}</td>
                    <td>{{$pasajero->direccion}}</td>
                    <td>{{$pasajero->barrio}}</td>
                    <td>{{$pasajero->cargo}}</td>
                    <td>{{$pasajero->area}}</td>
                    <td>{{$pasajero->subarea}}</td>
                    <td>
                      <button buscar-pasajero-id="{{$pasajero->id}}" class="btn btn-success buscar_pasajero">EDITAR</button>
                      <button data-pasajero-id="{{$pasajero->id}}" class="btn btn-danger eliminar_pasajero">ELIMINAR</button>
                      <button data-pasajero-id="{{$pasajero->id}}" class="btn btn-info mostrar_qr">
                        <i style="font-size: 17px" class="fa fa-qrcode" aria-hidden="true"></i>
                      </button>
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

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
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal Editar-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_pasajeros_editar'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form_editar_pasajero">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Editar Pasajero</h4>
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
<script src="{{url('jquery/pasajeros.js')}}"></script>
<script></script>
