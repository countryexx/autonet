<html>
<head>
	<title>Autonet | Traslados</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>
@include('admin.menu')

<div class="col-lg-12">

<h3 class="h_titulo">LISTADO DE TRAYECTOS - {{$nombre_cliente}}</h3>

    @if(isset($tarifas))

        <table id="examples" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Cliente AUTO</th> 
					<th>Cliente VAN</th>
                    <th>Proveedor AUTO</th>
                    <th>Proveedor VAN</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                                                          
                    <th>Nombre</th>
                    <th>Cliente AUTO</th> 
                    <th>Cliente VAN</th>
                    <th>Proveedor AUTO</th>
                    <th>Proveedor VAN</th>
                    <th>Opciones</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($tarifas as $tarifa)
                <tr>
                    <td>{{$i++}}</td>
                    
                    <td>{{$tarifa->nombre}}</td>
                    
                    <td> <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">$ {{number_format($tarifa->cliente_auto)}}</p></td>

                    <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">$ {{number_format($tarifa->cliente_van)}}</p></td>

                    <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">$ {{number_format($tarifa->proveedor_auto)}}</p></td>

                    <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">$ {{number_format($tarifa->proveedor_van)}}</p></td>
                    
                    <td style="text-align: center">
                        
                        <a data-auto-c="{{$tarifa->cliente_auto}}" data-van-c="{{$tarifa->cliente_van}}" data-auto-p="{{$tarifa->proveedor_auto}}" data-van-p="{{$tarifa->proveedor_van}}" data-nombre="{{$tarifa->nombre}}" title="Actualizar para todos" id="{{$tarifa->id}}" style="padding: 5px 6px; margin-bottom: 3px;" class="btn btn-primary editar_trayecto"><i class="fa fa-pencil"></i></a>
                        
                    </td>                     
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
     <a data-toggle="modal" href="#shortModal" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></a><br><br>
   
</div>

<div id="shortModal2" class="modal fade">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Actualizar Tarifa Masivo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-6">
                        <label class="obligatorio" for="nombre_editar">Nombre</label>
                        <input class="form-control" type="text" id="nombre_editar">
                    </div>
                    
                    <div class="col-xs-12">
                        <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend>Tarifa</legend>
                            <div class="row">
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="automovil_cliente_editar">Cliente AUTO</label>
                                    <input class="form-control" type="number" id="cliente_auto">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="minivan_cliente_editar">Cliente VAN</label>
                                    <input class="form-control" type="number" id="cliente_van">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="van_cliente_editar">Proveedor AUTO</label>
                                    <input class="form-control" type="number" id="proveedor_auto">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="bus_cliente_editar">Proveedor VAN</label>
                                    <input class="form-control" type="number" id="proveedor_van">
                                </div>
                                

                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="actualizar_trayecto" class="btn btn-success btn-icon">
                    ACTUALIZAR<i class="fa fa-floppy-o icon-btn"></i>
                </button>
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
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
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/tarifastraslados.js')}}"></script>
<script type="text/javascript">

    $('.editar_trayecto').click(function(){

        $('#actualizar_trayecto').attr('data-id',$(this).attr('id'));

        $('#cliente_auto').val($(this).attr('data-auto-c'));
        $('#cliente_van').val($(this).attr('data-van-c'));
        $('#proveedor_auto').val($(this).attr('data-auto-p'));
        $('#proveedor_van').val($(this).attr('data-van-p'));

        $('#nombre_editar').val($(this).attr('data-nombre'))
        $('#shortModal2').modal('show');

    });

    $('#actualizar_trayecto').click(function(){

        var id_tarifa = $(this).attr('data-id');

        var cliente_auto = $('#cliente_auto').val();
        var cliente_van = $('#cliente_van').val();
        var proveedor_auto = $('#proveedor_auto').val();
        var proveedor_van = $('#proveedor_van').val();

        console.log(id_tarifa)

        console.log(cliente_auto)
        console.log(cliente_van)
        console.log(proveedor_auto)
        console.log(proveedor_van)

        $.ajax({
          url: '../../tarifastraslados/actualizartrayectoindividual',
          method: 'post',
          data: {id_tarifa: id_tarifa, cliente_auto: cliente_auto, cliente_van: cliente_van, proveedor_auto: proveedor_auto, proveedor_van: proveedor_van}
        }).done(function(data){

          if(data.respuesta==true){
            alert('¡Tarifa Actualizada!')
            location.reload();
          }else if(data.respuesta==false){

          }

        });

    });

    $('#examples').DataTable( {
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
            { 'sWidth': '1%' },
            { 'sWidth': '7%' },

            { 'sWidth': '4%' },
            { 'sWidth': '4%' },
            { 'sWidth': '4%' },
            { 'sWidth': '4%' },
            { 'sWidth': '1%' },
        ]
    } );

</script>
</body>
</html>