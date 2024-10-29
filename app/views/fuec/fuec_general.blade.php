<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Autonet | Contratos</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')


    @include('scripts.scripts')
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script>
        $table = $('#example').DataTable({
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
                      sortDescending: ": activer pour trier la colonne par ordre d�croissant"
                  }
              },
              'bAutoWidth': false ,
              'aoColumns' : [
                  { 'sWidth': '3%' },
                  { 'sWidth': '4%' },
                  { 'sWidth': '5%' },
                  { 'sWidth': '20%' },
                  { 'sWidth': '3%' },
                  { 'sWidth': '2%' }
              ]
          });

          window.onload=function(){
            var pos=window.name || 0;
            window.scrollTo(0,pos);

              }
              window.onunload=function(){
              window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
              }

          function nobackbutton(){

             window.location.hash="no-back-button";

             window.location.hash="Again-No-back-button" //chrome

             window.onhashchange=function(){
               window.location.hash="no-back-button";
             }
          }

    </script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/fuec.js')}}"></script>
  </body>
</html>
