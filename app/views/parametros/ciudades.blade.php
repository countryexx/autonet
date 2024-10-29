<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autonet | Ciudades - {{ucwords($departamento)}}</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">

<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>


@include('admin.menu')

<div class="col-lg-8 col-lg-offset-2 centrosdecosto">
    <h3 class="h_titulo">DEPARTAMENTO - <span id="departamento">{{strtoupper($departamento)}}</span></h3>
    @if(isset($ciudades))
        <table id="example" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Ciudad</th>
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
            @foreach($ciudades as $ciudad)
                <tr>
                    <td>{{$ciudad->id}}</td>
                    <td>{{$ciudad->ciudad}}</td>
                    <td>
                      <a data-value="{{$ciudad->ciudad}}" data-toggle="modal" href="#shortModal" id="{{$ciudad->id}}" class="btn-success btn btn-list-table editar_ciudad">Editar</a>
                      <a id="{{$ciudad->id}}" href="{{url('ciudades/verbarrio/'.strtolower($ciudad->ciudad))}}" class="btn-info btn btn-list-table">Barrios</a>                      
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-primary btn-icon" href="{{url('ciudades')}}">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<div id="shortModal" class="modal modal-small fade">
    <div class="modal-dialog">
        <form id="formulario">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Ciudad</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="obligatorio" for="nuevo_departamento">Ciudad</label>
                            <input class="form-control" type="text" id="modificacion_ciudad">
                            <small id="alert-ciudad" class="text-danger hidden" role="alert"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="guardar_ciudad" class="btn btn-primary btn-icon">
                        Guardar<i class="fa fa-floppy-o icon-btn"></i>
                    </button>
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
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script>
    $('#example').DataTable( {
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "Ningun registro encontrado",
            emptyTable:     "Ningun registro disponible en la tabla",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre d�croissant"
            }
        }
    } );

    $('.dataTables_length label select').addClass('form-control');
    $('th.sorting_asc, th.sorting').css('border-bottom', '1px solid #D6D6D6');
    $('.dataTables_filter label input').addClass('form-control');
</script>
<script src="{{url('jquery/ciudades.js')}}"></script>

</body>
</html>
