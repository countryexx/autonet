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
      <div class="col-sm-12">
        <h3 class="h_titulo">LISTADO DE USUARIOS DE LA APLICACION MOVIL DE CLIENTES</h3>
        <ol class="breadcrumb">
          <li><a href="{{url('usuarios/clientesparticulares')}}">Particulares</a></li>
          <li><a href="{{url('usuarios/clientesempresariales')}}">Empresariales</a></li>
        </ol>
        @if (count($usuarios))
          <table id="listado_clientes_movil_empresariales" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Empresa</th>
              <th>Centro de costo (Empresa)</th>
              <th>Cargo</th>
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
                  <td>{{$usuario->empresa}}</td>
                  <td>{{$usuario->centro_de_costo}}</td>
                  <td>{{$usuario->cargo}}</td>
                  <td>{{$usuario->first_name}}</td>
                  <td>{{$usuario->last_name}}</td>
                  <td>{{$usuario->email}}</td>
                  <td>{{$usuario->telefono}}</td>
                  <td>
                    @if($usuario->activated==1)
                      <a data-id="{{$usuario->id}}" class="btn btn-list-table btn-success activado">
                        ACTIVADO
                      </a>
                    @else
                      <a data-id="{{$usuario->id}}" class="btn btn-list-table btn-info activacion" data-toggle="modal" data-target="#activacion_centrodecosto">
                        ACTIVACION
                      </a>
                    @endif
                    @if ($usuario->baneado==1)
                      <a data-id="{{$usuario->id}}" class="btn btn-list-table btn-danger bloquear">DESBLOQUEAR</a>
                    @else
                      <a data-id="{{$usuario->id}}" class="btn btn-list-table btn-warning bloquear">BLOQUEAR</a>
                    @endif
                    <a data-toggle="modal" data-target="#modal_password" data-id="{{$usuario->id}}" class="btn btn-list-table btn-info cambiarcontrasena">CONTRASEÑA</a>
                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        @else
          <table id="listado_clientes_movil_empresariales" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Empresa</th>
              <th>Centro de costo</th>
              <th>Cargo</th>
              <th>Primer Nombre</th>
              <th>Segundo Nombre</th>
              <th>Correo Electrónico</th>
              <th>Telefono</th>
              <th></th>
            </thead>
            <tbody>
              <tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">NINGUN REGISTRO DISPONIBLE EN LA TABLA</td></tr>
            </tbody>
          </table>
        @endif
      </div>

      <div class="modal fade" id="activacion_centrodecosto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <form id="enlazar_centrodecosto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>ACTIVAR CUENTA DE USUARIO</strong>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Centro de costo</label>
                  <select class="form-control input-font" name="centrodecosto">
                    <option value="0">-</option>
                    @foreach ($centrosdecosto as $centrodecosto)
                      <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger hidden"></small>
                </div>
                <div class="form-group">
                  <label for="">Subcentro de costo</label>
                  <select class="form-control input-font disabled" name="subcentrodecosto" disabled>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary">ACTIVAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="activado_centrodecosto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <form id="actualizar_centrodecosto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>ACTUALIZAR CUENTA DE USUARIO</strong>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="">Centro de costo</label>
                  <select class="form-control input-font" name="centrodecosto">
                    <option value="0">-</option>
                    @foreach ($centrosdecosto as $centrodecosto)
                      <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger hidden"></small>
                </div>
                <div class="form-group">
                  <label for="">Subcentro de costo</label>
                  <select class="form-control input-font disabled" name="subcentrodecosto" disabled></select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary">ACTIVAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <form id="form_cambiar_contrasena">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>CAMBIAR CONTRASEÑA</strong>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <input class="form-control input-font" type="password" name="password" id="password" autocomplete="off" placeholder="Digite la nueva contraseña">
                  <small class="text-danger hidden"></small>
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirmar Contraseña</label>
                  <input class="form-control input-font" type="password" name="confirm_password"
                         id="confirm_password" autocomplete="off" placeholder="Repetir contraseña">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                <button type="submit" class="btn btn-primary">GUARDAR</button>
              </div>
            </form>
          </div>
        </div>
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
