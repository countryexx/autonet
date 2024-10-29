<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de Vencimientos de Vehículos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')

<div class="col-lg-12">

    <h3 class="h_titulo">DOCUMENTOS DE VEHÍCULOS PRÓXIMOS A VENCERSE - PRÓXIMOS 7 DÍAS</h3>

    <table class="table table-bordered table-hover" id="listado_vehiculos2">
      <thead>
        <tr>
          <th>Nombre del Proveedor</th>
          <th>Placa</th>
          <th>Ciudad</th>
          <th>Vencimiento TO</th>
          <th>Vencimiento SOAT</th>
          <th>Vencimiento Tecnomecanica</th>
          <th>Vencimiento Prenventiva</th>
          <th>Vencimiento Poliza Contractual</th>
          <th>Vencimiento Poliza Extracontractual</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        #CANTIDAD DE VEHICULOS CON DOCUMENTOS VENCIDOS
        $documentos_vehiculos_vencidos = 0;

        ##CANTIDAD DE VEHICULOS CON DOCUMENTOS POR VENCER
        $documentos_vehiculos_por_vencer = 0;

        ##CANTIDAD DE DOCUMENTOS POR VENCER POR VEHICULO
        $cantidad_documentos_por_vencer = 0;

        ##CANTIDAD DE DOCUMENTOS VENCIDOS POR VEHICULO
        $documentos_vencidos_por_vehiculos = 0;

        //Inicializar todas las variables
        $tarjeta_operacion = null;
        $mantenimiento_preventivo = null;
        $soat = null;
        $tecnomecanica = null;
        $poliza_extracontractual = null;
        $poliza_contractual = null;

        $i = 0;

        $total_vehiculos = 0;
        $sw = 0;

        ##CANTIDAD DE DOCUMENTOS
        $documentos_vencidos_por_vehiculos = 0;
        $cantidad_documentos_por_vencer = 0;

        ?>
        @foreach($vehiculos as $vehiculo)
            @if($vehiculo->placa)
              <?php

                $sw = 0;

                $tarjeta_operacion = floor((strtotime($vehiculo->fecha_vigencia_operacion)-strtotime(date('Y-m-d')))/86400);
                $soat = floor((strtotime($vehiculo->fecha_vigencia_soat)-strtotime(date('Y-m-d')))/86400);
                $tecnomecanica = floor((strtotime($vehiculo->fecha_vigencia_tecnomecanica)-strtotime(date('Y-m-d')))/86400);
                $mantenimiento_preventivo = floor((strtotime($vehiculo->mantenimiento_preventivo)-strtotime(date('Y-m-d')))/86400);
                $poliza_contractual = floor((strtotime($vehiculo->poliza_contractual)-strtotime(date('Y-m-d')))/86400);
                $poliza_extracontractual = floor((strtotime($vehiculo->poliza_extracontractual)-strtotime(date('Y-m-d')))/86400);

                ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
                if ($tarjeta_operacion<0 or $soat<0 or $tecnomecanica<0 or $mantenimiento_preventivo<0
                        or $poliza_contractual<0 or $poliza_extracontractual<0){
                    $documentos_vehiculos_vencidos++;
                }

                ##CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
                if (($tarjeta_operacion>=0 && $tarjeta_operacion<=7) or
                        ($soat>=0 && $soat<=7) or
                        ($tecnomecanica>=0 && $tecnomecanica<=7) or
                        ($mantenimiento_preventivo>=0 && $mantenimiento_preventivo<=7) or
                        ($poliza_contractual>=0 && $poliza_contractual<=7) or
                        ($poliza_extracontractual>=0 && $poliza_extracontractual<=7))
                {
                    $documentos_vehiculos_por_vencer++;
                    $sw = 1;
                }

                ##TARJETA DE OPERACION VENCIDA
                if ($tarjeta_operacion<0){
                    $documentos_vencidos_por_vehiculos++;
                }

                if ($tarjeta_operacion<=7){ //TO VENCIDA
                    $cantidad_documentos_por_vencer++;
                    $sw = 1;
                }

                ##SOAT
                if ($soat<=7){ //SOAT VENCIDO
                    $cantidad_documentos_por_vencer++;
                    $sw = 1;
                }

                if ($tecnomecanica<=7){ //TECNO VENCIDO
                    $cantidad_documentos_por_vencer++;
                    $sw = 1;
                }

                ##MANTENIMIENTO PREVENTIVO
                if($mantenimiento_preventivo<=7){ //PREVENTIVA VENCIDA
                  $cantidad_documentos_por_vencer++;
                  $sw = 1;
                }

                if ($poliza_contractual<=7){ //POLIZA CONTRACTUAL
                    $cantidad_documentos_por_vencer++;
                    $sw = 1;
                }

                if ($poliza_contractual<=7){ // POLIZA EXTRACONTRACTUAL
                    $cantidad_documentos_por_vencer++;
                    $sw = 1;
                }

                if($sw==1){
                  $total_vehiculos++;
                }
              ?>
                @if($sw==1)

                <?php
                  $date = date('Y-m-d');
                  $sietedias = strtotime ('+7 day', strtotime($date));
                  $fechaMasSieteDias = date('Y-m-d' , $sietedias);
               ?>
                <tr>
                    <td>{{$vehiculo->proveedor->razonsocial}}</td>
                    <td>{{$vehiculo->placa}}</td>
                    <td>{{$vehiculo->proveedor->localidad}}</td>
                    <td>
                      <center>
                        @if($vehiculo->fecha_vigencia_operacion <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_operacion}}</b></div>
                       @elseif ($vehiculo->fecha_vigencia_operacion <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_operacion}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_operacion}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                      <center>
                        @if($vehiculo->fecha_vigencia_soat <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_soat}}</b></div>
                       @elseif ($vehiculo->fecha_vigencia_soat <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_soat}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_soat}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                      <center>
                        @if($vehiculo->fecha_vigencia_tecnomecanica <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_tecnomecanica}}</b></div>
                       @elseif ($vehiculo->fecha_vigencia_tecnomecanica <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_tecnomecanica}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->fecha_vigencia_tecnomecanica}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                      <center>
                        @if($vehiculo->mantenimiento_preventivo <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->mantenimiento_preventivo}}</b></div>
                       @elseif ($vehiculo->mantenimiento_preventivo <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->mantenimiento_preventivo}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->mantenimiento_preventivo}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                      <center>
                        @if($vehiculo->poliza_contractual <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_contractual}}</b></div>
                       @elseif ($vehiculo->poliza_contractual <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_contractual}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_contractual}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                      <center>
                        @if($vehiculo->poliza_extracontractual <= $date)
                         <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_extracontractual}}</b></div>
                       @elseif ($vehiculo->poliza_extracontractual <= $fechaMasSieteDias)
                         <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_extracontractual}}</b></div>
                       @else
                         <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$vehiculo->poliza_extracontractual}}</b></div>
                       @endif
                     </center>
                    </td>

                    <td>
                        <!--<button data-foto-id="" conductor-id="" class="btn btn-success mostrar_foto">FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>-->
                    </td>
                </tr>
                @endif
            @endif
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>Nombre del Proveedor</th>
          <th>Placa</th>
          <th>Ciudad</th>
          <th>Vencimiento TO</th>
          <th>Vencimiento SOAT</th>
          <th>Vencimiento Tecnomecanica</th>
          <th>Vencimiento Prenventiva</th>
          <th>Vencimiento Poliza Contractual</th>
          <th>Vencimiento Poliza Extracontractual</th>
          <th></th>
        </tr>
      </tfoot>
    </table>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #0FAEF3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;">Foto</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12" align="center">
              <img style="width: 410px; height: 350px" id="imagen">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <!--<button type="button" id="aprobar_foto" class="btn btn-primary" style="float: left;">Aprobar esta foto <i class="fa fa-check" aria-hidden="true"></i></button>
          <button type="button" id="desaprobar_foto" class="btn btn-primary" style="float: left; background: red">Desaprobar esta foto <i class="fa fa-remove" aria-hidden="true"></i></button>-->
          <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
        </div>
    </div>
  </div>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="{{url('jquery/conductores.js')}}"></script>

<script type="text/javascript">

$listado_vehiculos2 = $('#listado_vehiculos2').DataTable( {
      "order": [[ 1, "asc" ]],
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
          { 'sWidth': '4%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '3%' },
          { 'sWidth': '3%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
      ]
  } );

</script>

</body>
</html>
