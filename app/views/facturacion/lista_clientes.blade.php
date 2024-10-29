<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Novedades</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">



</head>
<body>

@include('admin.menu')

  <?php
    $mess = date('m');
    $ano = date('Y');
    $dia = date('d');

  ?>

<div class="col-xs-12">
    <div class="col-lg-12">
      @include('facturacion.menu_facturacion')
    </div>
    <div class="col-lg-12">
      <div class="row">
        
        <div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">
          <h3 class="h_titulo">Lista de Clientes</h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <table class="table table-striped table-bordered hover">
        <thead>
          <th>#</th>
          <th>Razonsocial</th>
          <th>Ver</th>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @foreach($clientes as $cliente)
            <tr>
              <td>{{$i}}</td>
              <td>{{$cliente->razonsocial}}</td>
              <td>
                <center><a class="btn btn-primary paste_tarifas" href="{{url('facturacion/lista/'.$cliente->id)}}" target="_blank">ver <i class="fa fa-link"></i></a>
                </center></td>
            </tr>
          <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>


</div>

<!--Modal QR-->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_qr'>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Codigo QR</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12" align="center">
              <img id="imagen_qr">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $pass = $('#passss').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
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
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '1%' },
          { 'sWidth': '1%' },
          { 'sWidth': '4%' },
          { 'sWidth': '3%' },
        ],
      });

</script>
</body>
</html>
