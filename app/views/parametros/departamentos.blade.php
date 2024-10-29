<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Departamentos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">

<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>
@include('admin.menu')
<div class="col-lg-8 col-lg-offset-2 centrosdecosto">

    <h3 class="h_titulo">DEPARTAMENTOS</h3>

    @if(isset($departamentos))

        <table id="example" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($departamentos as $departamento)
                <tr>
                    <td>{{$departamento->id}}</td>
                    <td>{{$departamento->departamento}}</td>
                    <td><a class="btn btn-primary btn-list-table" href="ciudades/ver/{{strtolower($departamento->departamento)}}">CIUDADES</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a data-toggle="modal" href="#shortModal" class="btn btn-default btn-icon">Agregar Departamento<i class="fa fa-plus icon-btn"></i></a>
    <a id="ciudades" data-toggle="modal" href="#shortModal2" class="btn btn-default btn-icon">Agregar Ciudad<i class="fa fa-plus icon-btn"></i></a>

</div>
<div id="shortModal" class="modal modal-small fade">

    <div class="modal-dialog">
        <form id="formulario">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nuevo departamento</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="obligatorio" for="nuevo_departamento">Departamento</label>
                            <input class="form-control" type="text" id="nuevo_departamento">
                            <small id="alert-departamento" class="text-danger hidden" role="alert"></small>
                        </div>

                     </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="guardar_departamento" class="btn btn-primary btn-icon">
                        Guardar<i class="fa fa-floppy-o icon-btn"></i>
                    </button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>

            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="shortModal2" class="modal modal-medium fade">

    <div class="modal-dialog">
        <form id="formulario">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nueva Ciudad</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <label class="obligatorio" for="departamento">Departamento</label>
                            <select class="form-control" id="departamento">
                            </select>

                        </div>
                        <div class="col-xs-6">
                            <label class="obligatorio" for="ciudad">Ciudad</label>
                            <input class="form-control" type="text" id="ciudad">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="guardar_ciudad" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>

            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

<div class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>

<script src="{{url('jquery/departamentos.js')}}"></script>


</body>
</html>