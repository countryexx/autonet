<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Usuarios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
  </head>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
  <body>
      @include('admin.menu')
      <div class="col-sm-10">
        <h3 class="h_titulo">LISTADO DE USUARIOS DE LA APLICACION MOVIL DE CLIENTES</h3>
        <ol class="breadcrumb">
          <li><a href="{{url('usuarios/clientesparticulares')}}">Particulares</a></li>
          <li><a href="{{url('usuarios/clientesempresariales')}}">Empresariales</a></li>
        </ol>
        @if (count($usuarios))
          <table id="listado_clientes_movil_particulares" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Primer Nombre</th>
              <th>Segundo Nombre</th>
              <th>Correo Electrónico</th>
              <th>Telefono</th>
              <th></th>
            </thead>
            <tbody>
              @foreach ($usuarios as $usuario)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$usuario->first_name}}</td>
                  <td>{{$usuario->last_name}}</td>
                  <td>{{$usuario->email}}</td>
                  <td>{{$usuario->telefono}}</td>
                  <td>
                    @if ($usuario->activated==1)
                      <a class="btn btn-list-table btn-success activar_cuenta" data-id-user="{{$usuario->id}}">ACTIVADO</a>
                    @else
                      <a class="btn btn-list-table btn-info activar_cuenta" data-id-user="{{$usuario->id}}">ACTIVAR</a>
                    @endif
                    <a class="btn btn-list-table btn-danger banear_cuenta">BLOQUEAR</a>
                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        @else
          <table id="listado_clientes_movil_particulares" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Primer Nombre</th>
              <th>Segundo Nombre</th>
              <th>Correo Electrónico</th>
              <th>Telefono</th>
              <th></th>
            </thead>
            <tbody>
                <tr class="odd" role="row"><td valign="top" colspan="9" class="dataTables_empty sorting_1">NINGUN REGISTRO DISPONIBLE EN LA TABLA</td></tr>
            </tbody>
          </table>
        @endif

      </div>

      @include('scripts.scripts')

      <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
      <script src="{{url('jquery/usuarios.js')}}"></script>
      <script type="text/javascript">

        $(function(){
          $('.dataTables_length label select').addClass('form-control input-font');
          $('th.sorting_asc, th.sorting').css('border-bottom', '1px solid #D6D6D6');
          $('.dataTables_filter label input').addClass('form-control input-font');
        });

      </script>
  </body>
</html>
