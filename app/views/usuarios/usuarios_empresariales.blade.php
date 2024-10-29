<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Usuarios empresariales</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-toggle-master\css\bootstrap-toggle.min.css')}}">
  </head>
  <body>
      @include('admin.menu')
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <h3>Listado de Usuarios Empresariales</h3>

            <div class="col-lg-4">
              <div class="row">

              </div>
            </div>
            <div class="col-lg-12">
              <div class="row">
                <table style="margin-top: 15px;" class="table table-bordered" id="tabla_u_empresariales">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Usuario</th>
                      <th>Nombre completo</th>
                      <th>Centro de costo</th>
                      <th>Correo</th>
                      <th>Ultima entrada</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                      <td>{{$usuario->id}}</td>
                      <td>{{$usuario->username}}</td>
                      <td>{{$usuario->first_name.' '.$usuario->last_name}}</td>
                      <td>{{$usuario->razonsocial}}</td>
                      <td>{{$usuario->email}}</td>
                      <td>{{$usuario->last_login}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modal_usu_empresa">AGREGAR</button>-->
                <button class="btn btn-primary" data-toggle="modal" data-target=".mymodal">AGREGAR</button>
              </div>
            </div>
        </div>
      </div>



      <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-usuarios">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <strong>NUEVO USUARIO EMPRESARIAL</strong>
            </div>
            <form id="formulario">
              <div class="modal-body">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label for="nombres">Nombres</label>
                    <input class="form-control input-font" type="text" id='unombres' name="unombres">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                    <label for="apellidos">Apellidos</label>
                    <input class="form-control input-font" type="text" id='uapellidos' name="uapellidos">
                  </div>
                  <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <label for="contrasena">Contraseña</label>
                    <input class="form-control" name="ucontrasena" type="password">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 usuario_contrasena">
                    <div class="has-feedback">
                      <label class="control-label" for="repetir_contrasena">Repetir Contraseña</label>
                      <input name="urepetir_contrasena" type="password" class="form-control" id="inputSuccess2" aria-describedby="inputSuccess2Status">
                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label for="nombres">Correo</label>
                    <input class="form-control input-font" type="text" name="ucorreo">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label for="nombres">Centros de costo</label>
                    <select class="form-control input-font" name="ccosto">
                        <option value="0">-</option>
                        @foreach($centrosdecosto as $ccosto)
                            <option value="{{$ccosto->id}}">{{$ccosto->razonsocial}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>
                    <label for="contrasena">Roles</label>
                    <select class="form-control input-font" name="urol">
                        <option value="0">-</option>
                        @foreach($roles as $rol)
                            <option value="{{$rol->id}}">{{$rol->nombre_rol}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <label for="nombres">Nombre de usuario</label>
                    <input class="form-control input-font" type="text" name="uusuario">
                  </div>
                </div>
              </div>
              <div class="modal-footer">

                <button id="uguardar" type="button" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                <button type="button" class="btn btn-danger btn-icon" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
              </div>
            </form>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->


      @include('scripts.scripts')

      <script src="{{asset('datatables/media/js/jquery.datatables.js')}}"></script>
      <script src="{{asset('bootstrap-toggle-master\js\bootstrap-toggle.min.js')}}"></script>
      <script src="{{asset('jquery/usuarios.js')}}"></script>
      <script>

        $(function(){


          $table = $('#tabla_u_empresariales').DataTable({

              language: {
                  processing:     "Procesando...",
                  search:         "Buscar:",
                  lengthMenu:    "Mostrar _MENU_ Registros",
                  info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
                  infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
                  infoFiltered:   "(Filtrando de _MAX_ registros en total)",
                  infoPostFix:    "",
                  loadingRecords: "Cargando...",
                  zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
                  emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
                  paginate: {
                      first:      "Primer",
                      previous:   "Antes",
                      next:       "Siguiente",
                      last:       "Ultimo"
                  },
                  aria: {
                      sortAscending:  ": activer pour trier la colonne par ordre croissant",
                      sortDescending: ": activer pour trier la colonne par ordre décroissant"
                  }
              },
              'bAutoWidth': false ,
              'aoColumns' : [
                  { 'sWidth': '2%' },
                  { 'sWidth': '3%' },
                  { 'sWidth': '9%' },
                  { 'sWidth': '5%' },
                  { 'sWidth': '25%' },
              ],
              processing: true,
              "bProcessing": true
          });

          $('.dataTables_length label select').addClass('form-control input-font');
          $('th.sorting_asc, th.sorting').css('border-bottom', '1px solid #D6D6D6');
          $('.dataTables_filter label input').addClass('form-control input-font');

        })

      </script>
    </body>
    </html>
