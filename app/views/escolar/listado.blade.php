<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Listado Escolar</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>

      *{margin: 0; padding: 0;}
.doc{
  display: flex;
  flex-flow: column wrap;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  background: #333944;
}
.box{
  width: 300px;
  height: 300px;
  background: #CCC;
  overflow: hidden;
}

.box img{
  width: 100%;
  height: auto;
}
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}


      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">LISTADO: USUARIOS SERVICIO ESCOLAR</h3>
        <form class="form-inline">

            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">

                  <div class="form-group">
                  	<select data-option="1" name="cliente_search" style="width: 130px;" class="form-control input-font" id="estado_search">
                        <option>ESTADO</option>
                        <option>ACTIVOS</option>
                        <option>INACTIVOS</option>
                    </select>
	                </div>
                  <div class="form-group">
                    <span style="padding: 8px 8px 7px 8px" class="icon-btn loading hidden">
                        <i style="padding: 10px 0px 9px 0px;" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                     </span>
                  </div>

                  <!--<button data-option="1" id="buscar2" class="btn btn-default btn-icon">Filtrar<i class="fa fa-filter icon-btn"></i></button>-->

                </div>
            </div>
        </form>

        <div class="form-group">
          <button title="Reenviar SMS a los usuarios que no han ingresado nunca a la plataforma" class="btn btn-primary usuarios">Reenvíar Usuarios</button>
        </div>

        @if(isset($usuarios))
          <table id="example_listado" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>#</th>
                  <th>Contrato</th>
                  <th>Tipo de Ruta</th>
                  <th>Nombre Estudiante</th>
                  <th>Curso</th>
                  <th>Teléfono</th>
                  <th>Dirección</th>
                  <th>Barrio</th>
                  <th>Nombre Padre</th>
                  <th>Valor</th>
                  <th>Acciones</th>

              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Contrato</th>
                    <th>Tipo de Ruta</th>
                    <th>Nombre Estudiante</th>
                    <th>Curso</th>
                    <th>Teléfono</th>
                  	<th>Dirección</th>
                    <th>Barrio</th>
                    <th>Nombre Padre</th>
                    <th>Valor</th>
                    <th>Acciones</th>

                </tr>
            </tfoot>
            <tbody>
                @foreach($usuarios as $usuario)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$usuario->id}}" class="@if(intval($usuario->estado)===1){{'danger'}}@endif fila_foto">
                        <td>{{$o++}}</td>
                        <td>{{$usuario->contrato}}</td>
                        <td>{{$usuario->tipo_ruta}}</td>
                        <td>{{$usuario->nombre_estudiante}}</td>
                        <td>{{$usuario->curso}}</td>
                        <td>{{$usuario->telefono}}</td>
                        <td>{{$usuario->direccion}}</td>
                        <td>{{$usuario->barrio}}</td>
                        <td>{{$usuario->nombre_padre}}</td>
                        <td>$ {{number_format($usuario->valor)}}</td>

                        <td>

                          <button title="@if($usuario->estado===1){{'Activar Usuario'}}@else{{'Desactivar Usuario'}}@endif" data-id="{{$usuario->id}}" class="@if($usuario->estado===1){{'btn btn-primary activar'}}@else{{'btn btn-danger desactivar'}}@endif">@if($usuario->estado===1){{'<i class="fa fa-check" aria-hidden="true"></i>'}}@else{{'<i class="fa fa-ban" aria-hidden="true"></i>'}}@endif</button>

                          <button title="Reenviar usuario vía SMS" data-id="{{$usuario->id}}" @if($usuario->estado===1){{'disabled'}}@endif class="btn btn-success reenviar_codigo"><i class="fa fa-share-square-o" aria-hidden="true"></i></button>

                          <button title="Cambiar número de teléfono (Se actualizará también la contraseña del usuario)" data-id="{{$usuario->id}}" data-contrato="{{$usuario->contrato}}" @if($usuario->estado===1){{'disabled'}}@endif class="btn btn-warning cambiar_numero">#</button>

                          <!--<button data-id="{{$usuario->id}}" data-contrato="{{$usuario->contrato}}" @if($usuario->estado===1){{'disabled'}}@endif class="btn btn-primary modificar">#</button>-->

                        </td>

                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/escolar.js')}}"></script>

  </body>
</html>
