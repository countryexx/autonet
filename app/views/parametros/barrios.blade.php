<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Barrios - {{ucwords($ciudad)}}</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">

<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>

@include('admin.menu')

<div class="col-lg-8 col-lg-offset-2 centrosdecosto">
    <h3 class="h_titulo">CIUDAD - <span id="departamento">{{strtoupper($ciudad->ciudad)}}</span></h3>
    @if(isset($barrios))
        <table id="listado_barrios" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Ciudad</th>
                <th>Sector</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($barrios as $barrio)
              <tr>
                <td>{{$i}}</td>
                <td>{{$barrio->nombre}}</td>
                <td>{{$barrio->sector}}</td>
                <td>
                  <a data-value="{{$barrio->ciudad}}" data-toggle="modal" id="{{$barrio->id}}" class="btn-success btn btn-list-table">Editar</a>
                  <a data-value="{{$barrio->ciudad}}" id="{{$barrio->id}}" class="btn-danger btn-list-table btn eliminar_barrio">Eliminar</a>
                </td>
              </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-default btn-icon" data-toggle="modal" data-id="{{$ciudad->id}}" href="#modal_nuevo_barrio">
      Agregar
      <i class="fa fa-plus icon-btn"></i>
    </a>
    <a class="btn btn-primary btn-icon" href="{{url('ciudades')}}">
      Volver
      <i class="fa fa-reply icon-btn"></i>
    </a>
</div>

<div id="modal_nuevo_barrio" class="modal modal-small fade">
    <div class="modal-dialog">
        <form id="form_nuevo_barrio">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nuevo Barrio</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <label class="obligatorio" for="nuevo_departamento">Barrio</label>
                            <input class="form-control input-font" type="text" name="nombre" placeholder="DIGITE EL NOMBRE DEL BARRIO" autocomplete="off">
                            <small class="text-danger hidden"></small>
                        </div>
                        <div class="col-xs-12">
                            <label class="obligatorio" for="nuevo_departamento">Sector</label>
                            <select class="form-control input-font" name="sector">
                              <option value="0">SELECCIONE EL SECTOR</option>
                              <option value="CENTRO">CENTRO</option>
                              <option value="NORTE">NORTE</option>
                              <option value="SUR">SUR</option>
                            </select>
                            <small class="text-danger hidden"></small>
                        </div>
                        <input type="text" class="hidden" name="ciudad_id" value="{{$ciudad->id}}">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-icon">
                      Guardar<i class="fa fa-floppy-o icon-btn"></i>
                  </button>
                  <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">
                    Cerrar
                    <i class="fa fa-times icon-btn"></i>
                  </a>
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

    $('#listado_barrios').DataTable( {
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
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
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
