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

<h3 class="h_titulo">LISTADO CLIENTES - TARIFAS</h3>

    @if(isset($clientes))

        <table id="examples" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                                                          
                    <th>Cliente</th>
                    <th>Clientes</th> 
					<th style="text-align: center;">Ver</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                                                          
                    <th>Cliente</th>
                    <th>Clientes</th> 
                    <th style="text-align: center;">Ver</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($clientes as $ruta)
                <tr>
                    <td>{{$i++}}</td>
                    
                    <td>{{$ruta->razonsocial}}</td>
                    
                    <td>$ </td>
                    
                    <td style="text-align: center">
                        <a id="{{$ruta->id}}" href="{{url('tarifastraslados/tarifascliente/'.$ruta->id)}}" target="_blank" style="padding: 5px 6px; margin-bottom: 3px;" class="btn btn-primary">TARIFAS <i class="fa fa-share-square-o"></i></a>
                    </td>                     
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
     <a data-toggle="modal" href="#shortModal" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></a><br><br>
   
</div>

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

        $('#nombre_editar').val($(this).attr('data-nombre'))
        $('#shortModal2').modal('show');

    });

    $('#actualizar_trayecto').click(function(){

        var id_trayecto = $(this).attr('data-id');

        var clientes = $('#clientes_editar').val();
        var cliente_auto = $('#cliente_auto').val();
        var cliente_van = $('#cliente_van').val();
        var proveedor_auto = $('#proveedor_auto').val();
        var proveedor_van = $('#proveedor_van').val();

        console.log(id_trayecto)

        console.log(clientes)
        console.log(cliente_auto)
        console.log(cliente_van)
        console.log(proveedor_auto)
        console.log(proveedor_van)

        $.ajax({
          url: '../tarifastraslados/actualizartrayecto',
          method: 'post',
          data: {id_trayecto: id_trayecto, clientes: clientes, cliente_auto: cliente_auto, cliente_van: cliente_van, proveedor_auto: proveedor_auto, proveedor_van: proveedor_van}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

    });

    $('#examples').DataTable( {
        paging: false,
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
            { 'sWidth': '10%' },
            { 'sWidth': '8%' },
            { 'sWidth': '3%' },
        ]
    } );

</script>
</body>
</html>