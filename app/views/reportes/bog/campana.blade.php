<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Control de Campañas</title>
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

    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">

        <h3 class="h_titulo">CONTROL DE CAMPAÑAS</h3>
        <ol style="margin-bottom: 10px" class="breadcrumb">

            <li><a href="{{url('reportes/campanasbog')}}">Campañas</a></li>
            
            <li><a href="{{url('reportes/barriosbog')}}">Barrios</a></li>
            
            <li><a href="{{url('reportes/hoybog')}}">Programación</a></li>
            
        </ol>

        @if(isset($consulta))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>FECHA</th>
                <th>CAMPAÑA</th>
                <th>SERVICIOS</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th>FECHA</th>
                <th>CAMPAÑA</th>
                <th>SERVICIOS</th>
              </tr>
            </tfoot>
            <tbody>

              <?php
                $btnEditaractivado = null;
                $btnEditardesactivado = null;
                $btnProgactivado = null;
                $btnProgdesactivado = null;
                $conductor = '';
                $sw = 0;
              ?>
              @foreach($consulta as $documento)
                <tr>
                  <td>{{$o++}}</td>                        
                  <td>{{$documento->fecha_servicio}}</td>
                  <td>
                    {{$documento->employ}}
                  </td>
                  <td>
                    <?php
                    if($documento->employ!=null){
                      $servicios = "SELECT distinct qr_rutas.servicio_id FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE qr_rutas.employ = '".$documento->employ."' AND servicios.fecha_servicio = '".$documento->fecha_servicio."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.ruta AND servicios.centrodecosto_id = 287";
                      $search = DB::select($servicios);
                    }else{
                      $servicios = "SELECT distinct qr_rutas.servicio_id FROM qr_rutas LEFT JOIN servicios ON servicios.id = qr_rutas.servicio_id WHERE qr_rutas.employ is null AND servicios.fecha_servicio = '".$documento->fecha_servicio."' AND servicios.pendiente_autori_eliminacion IS NULL AND servicios.ruta AND servicios.centrodecosto_id = 287";
                      $search = DB::select($servicios);
                    }
                    
                    foreach ($search as $servicio) {
                      echo '<a data-id="'.$servicio->servicio_id.'" class="pax_ruta" data-toggle="modal" data-target=".mymodal3">'.$servicio->servicio_id.'</a><br>';
                    }
                    ?>
                  </td>
                </tr>
                  
              @endforeach
            </tbody>
          </table>
        @endif

        <div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-rutas" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">DATOS DE PASAJEROS</h4>
                  </div>
                  <div class="modal-body tabbable">
                      <table style="margin-bottom: 15px;" id="pax_info" class="table table-bordered table-hover">
                          <thead>
                              <tr>
                                  <td>#</td>
                                  <td>NOMBRE COMPLETO</td>
                                  <td>EMPLOY ID / CÉDULA</td>
                                  <td>TELÉFONO</td>
                                  <td>DIRECCION</td>
                                  <td>BARRIO</td>
                                  <td>CARGO</td>
                                  <td>AREA</td>
                                  <td>CAMPAÑA</td>
                                  <td>HORARIO</td>
                                  <td></td>
                              </tr>
                          </thead>
                          <tbody></tbody>
                      </table>
                      <!--<a class="btn btn-info btn-icon" id="agregar_pax_ruta">AGREGAR<i class="fa fa-plus icon-btn"></i></a>-->
                  </div>
                  <div class="modal-footer">
                      <!--<a class="btn btn-success btn-icon boton_excel_exportar">EXPORTAR<i class="fa fa-file-excel-o icon-btn"></i></a>-->
                      <a class="btn btn-primary btn-icon boton_pax_guardar">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                      <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                  </div>
              </div>
          </div>
      </div>
    </div>  

    <hr style="border: 10px">

    <!-- AGREGAR MÁS COSAS -->
    @include('portalusuarios.admin.listado.pusher')

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!--<script src="{{url('jquery/reportes.js')}}"></script>-->

    <script type="text/javascript">

        $('#example').on('click', '.pax_ruta', function(e){

          e.preventDefault();
          var id = $(this).attr('data-id');
          $json = '';

          $('.boton_pax_guardar').attr('data-id',id);

          $('.boton_excel_exportar').attr('href','transportesrutas/exportarpasajerosrutas/'+id)

          $('#pax_info tbody').html('');

          $.ajax({
              url: '../../transportesrutas/verrutapax',
              method: 'post',
              data: {'id': id},
              success: function(data){

                  if (data.respuesta===true) {

                      var $json = JSON.parse(data.pasajeros);
                      var htmlPax = '';

                      for(i in $json){

                        htmlPax += '<tr>'+
                            '<td>'+(parseInt(i)+1)+'</td>'+
                            '<td>'+$json[i].nombres+'</td>'+
                            '<td>'+$json[i].apellidos+'</td>'+
                            '<td>'+$json[i].cedula+'</td>'+
                            '<td>'+$json[i].direccion+'</td>'+
                            '<td>'+$json[i].barrio+'</td>'+
                            '<td>'+$json[i].cargo+'</td>'+
                            '<td>'+$json[i].area+'</td>'+
                            '<td>'+$json[i].sub_area+'</td>'+
                            '<td>'+$json[i].hora+'</td>'+
                            '<td><a style="margin-right:3px; padding: 5px 6px;" class="btn btn-primary editar_pax_ruta"><i class="fa fa-pencil"></i></a><br><a style="margin-right:3px; padding: 5px 6px;" class="btn btn-success guardar_pax_ruta disabled"><i class="fa fa-save"></i></a><br><a style="padding: 5px 6px;" class="btn btn-danger eliminar_pax_ruta"><i class="fa fa-close"></i></a></td>'+
                        '</tr>'

                      }

                      $('#pax_info tbody').append(htmlPax);

                  }
              }
          });
      });

      $('#pax_info').on('click','.eliminar_pax_ruta', function(e){

          if ($('#pax_info tr').length-1<=1) {
              alert('Debe haber al menos un pasajero en la ruta');

          }else{
              var $objeto = $(this);
              $objeto.closest('tr').fadeOut(function(){$(this.remove())});

          }
      });

      $('#pax_info').on('click','.editar_pax_ruta', function(e){

          var $objeto = $(this);
          $objeto.addClass('disabled');
          var val_numero = $objeto.closest('tr').find('td').eq(0).html();
          var val_nombres = $objeto.closest('tr').find('td').eq(1).html();
          var val_apellidos = $objeto.closest('tr').find('td').eq(2).html();
          var val_cedula = $objeto.closest('tr').find('td').eq(3).html();
          var val_direccion = $objeto.closest('tr').find('td').eq(4).html();
          var val_barrio = $objeto.closest('tr').find('td').eq(5).html();
          var val_cargo = $objeto.closest('tr').find('td').eq(6).html();
          var val_area = $objeto.closest('tr').find('td').eq(7).html();
          var val_sub_area = $objeto.closest('tr').find('td').eq(8).html();
          var val_horario = $objeto.closest('tr').find('td').eq(9).html();
          $objeto.closest('tr').find('td').eq(0).html('').append('<input class="form-control input-font" value="'+val_numero+'">');
          $objeto.closest('tr').find('td').eq(1).html('').append('<input class="form-control input-font" value="'+val_nombres+'">');
          $objeto.closest('tr').find('td').eq(2).html('').append('<input class="form-control input-font" value="'+val_apellidos+'">');
          $objeto.closest('tr').find('td').eq(3).html('').append('<input class="form-control input-font" value="'+val_cedula+'">');
          $objeto.closest('tr').find('td').eq(4).html('').append('<input class="form-control input-font" value="'+val_direccion+'">');
          $objeto.closest('tr').find('td').eq(5).html('').append('<input class="form-control input-font" value="'+val_barrio+'">');
          $objeto.closest('tr').find('td').eq(6).html('').append('<input class="form-control input-font" value="'+val_cargo+'">');
          $objeto.closest('tr').find('td').eq(7).html('').append('<input class="form-control input-font" value="'+val_area+'">');
          $objeto.closest('tr').find('td').eq(8).html('').append('<input class="form-control input-font" value="'+val_sub_area+'">');
          $objeto.closest('tr').find('td').eq(9).html('').append('<input class="form-control input-font" value="'+val_horario+'">');
          $objeto.closest('tr').find('.guardar_pax_ruta').removeClass('disabled');

      });

      $('#pax_info').on('click','.guardar_pax_ruta', function(e){

          var $objeto = $(this);
          var $input = $objeto.closest('tr').find('td input');
          var $td = $objeto.closest('tr').find('td');

          $objeto.addClass('disabled');
          $objeto.closest('tr').find('.editar_pax_ruta').removeClass('disabled');

          var val_numero = $input.eq(0).val();
          var val_nombres = $input.eq(1).val();
          var val_apellidos = $input.eq(2).val();
          var val_cedula = $input.eq(3).val();
          var val_direccion = $input.eq(4).val();
          var val_barrio = $input.eq(5).val();
          var val_cargo = $input.eq(6).val();
          var val_area = $input.eq(7).val();
          var val_sub_area = $input.eq(8).val();
          var val_horario = $input.eq(9).val();

          $td.eq(0).html('').append(val_numero.toLowerCase().toUpperCase());
          $td.eq(1).html('').append(val_nombres.toLowerCase().toUpperCase());
          $td.eq(2).html('').append(val_apellidos.toLowerCase().toUpperCase());
          $td.eq(3).html('').append(val_cedula);
          $td.eq(4).html('').append(val_direccion.toLowerCase().toUpperCase());
          $td.eq(5).html('').append(val_barrio.toLowerCase().toUpperCase());
          $td.eq(6).html('').append(val_cargo.toLowerCase().toUpperCase());
          $td.eq(7).html('').append(val_area.toLowerCase().toUpperCase());
          $td.eq(8).html('').append(val_sub_area.toLowerCase().toUpperCase());
          $td.eq(9).html('').append(val_horario);
          $objeto.closest('tr').find('.guardar_pax_ruta').addClass('disabled');

      });

      $('.boton_pax_guardar').click(function(e){

          var id = $(this).attr('data-id');
          var nombres = '';
          var apellidos = '';
          var cedula = '';
          var direccion = '';
          var barrio = '';
          var cargo = '';
          var area = '';
          var sub_area = '';
          var hora = '';
          var pasajeros = '';
          var contador = 0;

          var paxArray = [];

          $('#pax_info tbody tr').each(function(index){

              nombres = '';
              apellidos = '';
              cedula = '';
              direccion = '';
              barrio = '';
              cargo = '';
              area = '';
              sub_area = '';
              hora = '';

              $(this).children("td").each(function (index2){

                  switch (index2){
                      case 1:
                          nombres = $(this).html();
                          break;
                      case 2:
                          apellidos = $(this).html();
                          break;
                      case 3:
                          cedula = $(this).html();
                          break;
                      case 4:
                          direccion = $(this).html();
                          break;
                      case 5:
                          barrio = $(this).html();
                          break;
                      case 6:
                          cargo = $(this).html();
                          break;
                      case 7:
                          area = $(this).html();
                      break;
                      case 8:
                          sub_area = $(this).html();
                      break;
                      case 9:
                          hora = $(this).html();
                      break;
                      case 10:
                          if ($(this).find('.editar_pax_ruta').hasClass('disabled')) {
                              contador++;
                          }
                      break;
                  }
                  console.log(nombres)
              });

              $json = {
                  'nombres': nombres,
                  'apellidos': apellidos,
                  'cedula': cedula,
                  'direccion': direccion,
                  'barrio': barrio,
                  'cargo': cargo,
                  'area': area,
                  'sub_area': sub_area,
                  'hora': hora
              };
              paxArray.push($json);
          });

          pasajeros = JSON.stringify(paxArray);

          if (contador!=0) {

              alert('Asegurese de haber guardado todos los datos, faltan '+contador);

          }else{

              $.ajax({
                  url: '../../transportesrutas/editarrutapax',
                  method: 'post',
                  dataType: 'json',
                  data: {
                      'id': id,
                      'pasajeros': pasajeros
                  },
                  success: function(data){
                      if (data.respuesta===true) {
                          $('.mymodal3').modal('hide');
                          alert('Realizado');
                      }
                  }
              });
          }

      });

      var $table = $('#example').DataTable({
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
              },
              responsive: true
          },
          'bAutoWidth': false ,
          'aoColumns' : [
              { 'sWidth': '1%' }, //count
              { 'sWidth': '1%' }, //id servicio
              { 'sWidth': '3%' }, //conductor
              { 'sWidth': '3%' }, //placa
          ],
          processing: true,
          "bProcessing": true
      });
    </script>
  </body>
</html>
