<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Usuarios de Proveedores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">

    <div class="col-lg-12">
      <!--<div class="row">
        <h3 class="h_titulo">LISTADO DE PROVEEDORES</h3>
        <div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">
          <div class="row">
            <label>Tipo de afiliado</label>
            <select class="form-control input-font" id="tipo_afiliado">
              <option value="0">-</option>
              <option value="1">TODOS</option>
              <option value="5">BARRANQUILLA</option>
              <option value="4">BOGOTA</option>
              <option value="2">AFILIADOS INTERNO</option>
              <option value="3">AFILIADOS EXTERNO</option>
            </select>
          </div>
        </div>
      </div>-->
    </div>

    @if(isset($proveedores))
      <table id="usuarios" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>Nit</th>
                <th>Razon Social</th>
                <th>Usuario</th>
                <th>Último ingreso</th>
                <th>Email</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Nit</th>
            <th>Razon Social</th>
            <th>Usuario</th>
            <th>Último ingreso</th>
            <th>Email</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>
          @foreach($proveedores as $proveedor)
            <tr class="@if(intval($proveedor->inactivo)===1 && intval($proveedor->inactivo_total)===1){{'danger'}}@elseif(intval($proveedor->inactivo)===1){{'warning'}}@endif">
              <td>{{$proveedor->nit}}</td>
              <td>{{$proveedor->razonsocial.' '.$proveedor->tipoempresa}}</td>
              <td>{{$proveedor->username}}</td>
              <td>{{$proveedor->last_login}}</td>
              <td>{{$proveedor->email}}</td>
              <td id="{{$proveedor->id}}">
                <!--<a class="btn btn-primary btn-list-table" href="proveedores/ver/{{strtolower($proveedor->razonsocial)}}">DETALLES</a>-->
                <!--<a class="btn btn-danger btn-list-table disabled" data-id="{{$proveedor->id}}">Bloquear</a>
                <a class="btn btn-success btn-list-table disabled" data-id="{{$proveedor->id}}">Desbloquear</a>-->

                @if($proveedor->email!=null and $proveedor->username===null)

                    <a class="btn btn-warning btn-list-table crear_usuario" data-id="{{$proveedor->id}}">Crear Usuario</a>
                    <!--<a class="btn btn-success btn-list-table" href="proveedores/vehiculos/{{strtolower($proveedor->id)}}">VEHICULOS</a>-->
                @elseif($proveedor->username!=null)

                  <a data-id="{{$proveedor->id_usuario}}" data-option="0" class="btn btn-danger btn-list-table bolder bloquear_usuario">BLOQUEAR <i class="fa fa-lock" aria-hidden="true"></i></a>
                  <a data-id="{{$proveedor->id_usuario}}" data-option="1" class="btn btn-primary btn-list-table bolder bloquear_usuario">DESBLOQUEAR <i class="fa fa-unlock-alt" aria-hidden="true"></i></a>

                  <a class="btn btn-warning btn-list-table disabled" data-id="{{$proveedor->id}}">Usuario Creado</a>
                @endif
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif
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

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/proveedores.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

</script>
</body>
</html>
