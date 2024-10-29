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
<div class="col-xs-12">
    <div class="col-lg-5">

    </div>
    <div class="col-lg-12">
      <div class="row">
        <h3 class="h_titulo">NOVEDADES del {{$fecha}} | {{$cliente}}</h3>
        <div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">
          <div class="row">
            <div class="col-xs-12">
                  <form id="form" action="{{url('portalusu/exportarlistadonovedades')}}" method="post">
                  <div class="row">

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">
                          <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                          <div class="input-group">
                            <div class="input-group date" id="datetimepicker1">
                                <input value="{{$fecha}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                          </div>
                      </div>
                      <input type="text" name="cc" value="{{$cc}}" class="hidden">

                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                        <div class="input-group">
                            <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">DESCARGAR ARCHIVO EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                        </div>
                      </div>
                  </div>
                  <br>

                </form>

          </div>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped table-bordered hover" id="pass">
        <thead>
          <tr>
            <th></th>
            <th>FECHA</th>
            <th>EMPLOY ID</th>
            <th>NOMBRE COMPLETO</th>
            <th>TELÉFONO</th>
            <th>DIRECCIÓN</th>

            <th>BARRIO</th>
            <th>LOCALIDAD</th>
            <th>PROGRAMA</th>
            <th>ENTRADA/SALIDA</th>
            <th>HORA</th>
            <th>NOVEDAD</th>
            <th>CENTRO DE COSTOS</th>
          </tr>
        </thead>
        <tbody>
          <?php
               $contador = 1;
               $idViejo = '';
               for ($i=0; $i <count($servicios) ; $i++) {
                   $json = json_decode($servicios[$i]->pasajeros_ruta);
                   if(is_array($json)){
                     foreach ($json as $key => $value) {

                        $tipo_servicio = null;

                        if($servicios[$i]->email_solicitante==1){ //si es transporte de pc
                          $tipo_servicio = 'PC';
                        }else if($servicios[$i]->email_solicitante==2){ //si es transporte de eventos
                          $tipo_servicio = 'EVENTO';
                        }else if($servicios[$i]->ruta==null){ //si es ejecutivo
                          $tipo_servicio = 'EJECUTIVO';
                        }else if($servicios[$i]->hora_servicio>='06:00' and $servicios[$i]->hora_servicio<='20:59'){ //ruta diurna
                          $tipo_servicio = 'RUTA EXTRAORDINARIA DIURNA';
                        }else if( ($servicios[$i]->hora_servicio>='21:00' and $servicios[$i]->hora_servicio<='23:59') or ($servicios[$i]->hora_servicio>='00:00' and $servicios[$i]->hora_servicio<='05:59')){
                          $tipo_servicio = 'RUTA ORDINARIA NOCTURNA';
                        }

                        $campana = str_replace('AMP;', '', $value->sub_area);
                        $direccion = str_replace('&nbsp;', '', $value->direccion);
                        $barrio = str_replace('&nbsp;', '', $value->barrio);
                        $localidad = str_replace('&nbsp;', '', $value->cargo);

                        $nombre = str_replace('&nbsp;', ' ', $value->nombres);
                        $nombre = str_replace('&NBSP;', ' ', $nombre);

                        $capacidad = '';
                        $valor = '';

                        if($idViejo!=$servicios[$i]->id){
                          $capacidad = $servicios[$i]->capacidad;
                          $valor = $servicios[$i]->id;
                        }

                        if (strpos($servicios[$i]->detalle_recorrido, 'E') !== false) {
                          $tipo = 'ENTRADA';
                        }else{
                          $tipo = 'SALIDA';
                        }

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.strtoupper($value->apellidos).'</td>'.
                              '<td>'.strtoupper($nombre).'</td>'.
                              '<td>'.strtoupper($value->cedula).'</td>'.
                              '<td>'.strtoupper($value->direccion).'</td>'.
                              '<td>'.strtoupper(trim($value->barrio)).'</td>'.
                              '<td>'.strtoupper(trim($value->cargo)).'</td>'.
                              '<td>'.strtoupper(trim($campana)).'</td>'.



                              '<td>'.$tipo.'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.strtoupper(trim($value->area)).'</td>'.
                              '<td>'.$servicios[$i]->nombresubcentro.'</td>'.
                              '</tr>';
                              $contador++;

                        $idViejo = $servicios[$i]->id;
                     }
                   }
               }
          ?>
        </tbody>
      </table>


    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>

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

    $pass = $('#pass').DataTable( {
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
