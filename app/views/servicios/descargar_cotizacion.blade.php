<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AOTOUR | Descargar Cotización</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link href="https://assets.codepen.io/344846/style.css" rel="stylesheet"><link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

</head>
<body>

<?php
  $mess = date('m');
  $ano = date('Y');
?>
<div class="app-container">

  <div class="row">

    <div class="col-lg-12">
      <center>
        <img style="width: 190px; height: 50px; margin-top: 60px" src="{{url('img/logo_aotour.png')}}" alt="">
      </center>
    </div>

    <div class="col-lg-12" style="margin-top: 40px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="jumbotron" style="padding-left: 48px; padding-right: 48px">
                  <center>
                    <h1>Cotización N° {{$consecutivo}}</h1><br>
                    <br><br>
                    <a data-id="{{$consecutivo}}" class="btn btn-list-table btn-info down">Descargar Archivo<i class="fa fa-download" aria-hidden="true"></i></a>
                    
                    <!-- Notificación a comercial -->

                  </center>
                </div>
            </div>


        </div>
    </div>
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
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script>
    const setup = () => {
      const getTheme = () => {
        if (window.localStorage.getItem('dark')) {
          return JSON.parse(window.localStorage.getItem('dark'))
        }
        return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
      }

      const setTheme = (value) => {
        window.localStorage.setItem('dark', value)
      }

      return {
        loading: true,
        isDark: getTheme(),
        toggleTheme() {
          this.isDark = !this.isDark
          setTheme(this.isDark)
        },
      }
    }
  </script>
<script type="text/javascript">

    function goBack(){
        window.history.back();
    }

    $('.down').click(function(){

      var id = $(this).attr('data-id');

      $.ajax({
        url: '../../cotizaciones/descargararchivo',
        method: 'post',
        data: {id: id}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    })

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
