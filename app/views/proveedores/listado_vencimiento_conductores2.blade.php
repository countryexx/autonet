<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de Vencimientos de Conductores</title>
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

    <h3 class="h_titulo">DOCUMENTOS DE CONDUCTORES PRÓXIMOS A VENCERSE - PRÓXIMOS 7 DÍAS</h3>
    <table class="table table-bordered table-hover" id="listado_conductores2">
      <thead>
        <tr>
          <th>Nombre del Proveedor</th>
          <th>Nombre del Conductor</th>
          <th>Ciudad</th>
          <th style="text-aling: center;">Fecha de Vencimiento SS</th>
          <th>Fecha de Vencimiento Licencia</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $documentos_por_vencer = 0;
        $documentos_vencidos = 0;
        $total_conductores = 0;
        $contar_seguridad = 0;
        ?>
        @foreach($conductores as $conductor)
            @if($conductor->nombre_completo)
              <?php
              $date = date('Y-m-d');
              $i = 0;
              $sw = 0;
              $seguridad_social = null;
              $estado_ssocial = null;

              $ss = "select seguridad_social.fecha_inicial, seguridad_social.fecha_final from seguridad_social where conductor_id = ".$conductor->id." and '".$date."' between fecha_inicial and fecha_final ";
              $ss = DB::select($ss);

              if($ss!=null){
                $sietedias = strtotime ('+7 day', strtotime($date));
                $fechaMasSieteDias = date('Y-m-d' , $sietedias);

                $sele = DB::table('seguridad_social')
                ->where('conductor_id',$conductor->id)
                ->where('fecha_final', '<=', $fechaMasSieteDias)
                //->where('fecha_final', '<=', $date)
                ->orderBy('fecha_final', 'DESC')
                ->first();

                if($sele!=null){
                  $documentos_por_vencer++;
                  $total_conductores++;
                  $sw = 1 ;
                }

                //PT2
                $sele2 = DB::table('seguridad_social')
                ->where('conductor_id',$conductor->id)
                ->where('fecha_final', '>=', $fechaMasSieteDias)
                //->where('fecha_final', '<=', $date)
                ->orderBy('fecha_final', 'DESC')
                ->first();

                if($sele2!=null){
                  $sele = $sele2;
                  $sw = 0;
                  $documentos_por_vencer--;
                  $total_conductores--;
                }

              }else{
                $contar_seguridad++;
              }

              ##CANTIDAD DE DOCUMENTOS VENCIDOS POR CONDUCTOR
              $documentos_vencidos_por_conductor = 0;
              ##CANTIDAD DE DOCUMENTOS POR VENCER POR CONDUCTOR
              $documentos_por_vencer_por_conductor = 0;
              $licencia_conduccion = floor((strtotime($conductor->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);
              //DIA ACTUAL
              $fecha_actual = intval(date('d'));
              ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS VENCIDOS
              if ($licencia_conduccion<0){
                  $documentos_vencidos_por_conductor++;
                  $documentos_vencidos++;
              }

              ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS POR VENCER
              if (($licencia_conduccion<=7))
              {
                  $documentos_por_vencer++;
                  $documentos_por_vencer_por_conductor++;
                  if(!$ss!=null){
                    $total_conductores++;
                    $sw = 1 ;
                  }
              }
              ?>
                @if($sw==1)
                <tr
                    data-conductor-id="{{$conductor->id}}"
                    class="@if($conductor->bloqueado_total==1 and $conductor->bloqueado==1){{'danger warning'}}@elseif($conductor->bloqueado_total==1){{'danger'}}@elseif($conductor->bloqueado==1){{'warning'}}@endif">
                    <td>{{$conductor->proveedor->razonsocial}}</td>
                    <td>{{$conductor->nombre_completo}}</td>
                    <td>{{strtoupper($conductor->proveedor->localidad)}}</td>
                    <td>
                      <?php
                        $date = date('Y-m-d');
                        $sietedias = strtotime ('+7 day', strtotime($date));
                        $fechaMasSieteDias = date('Y-m-d' , $sietedias);
                     ?>
                     <center>
                     @if($sele->fecha_final < $date)
                      <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$sele->fecha_final}}</b></div>
                    @elseif($sele->fecha_final <= $fechaMasSieteDias)
                      <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$sele->fecha_final}}</b></div>
                    @else
                      <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$sele->fecha_final}}</b></div>
                    @endif
                    </center>
                    </td>
                    <td>
                      <?php
                        $date = date('Y-m-d');
                        $sietedias = strtotime ('+7 day', strtotime($date));
                        $fechaMasSieteDias = date('Y-m-d' , $sietedias);
                     ?>
                     <center>
                     @if($conductor->fecha_licencia_vigencia <= $date)
                      <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size:13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$conductor->fecha_licencia_vigencia}}</b></div>
                    @elseif($conductor->fecha_licencia_vigencia <= $fechaMasSieteDias)
                      <div class="estado_servicio_app" style="background: orange; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$conductor->fecha_licencia_vigencia}}</b></div>
                    @else
                      <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 13px; padding: 3px 5px; width: 90px; border-radius: 2px;"><b>{{$conductor->fecha_licencia_vigencia}}</b></div>
                    @endif
                    </center>
                  </td>
                    <td>
                        <!--<button data-foto-id="{{$conductor->foto_app}}" conductor-id="{{$conductor->foto_app}}" class="btn btn-success mostrar_foto">FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>-->
                    </td>
                </tr>
                @endif
            @endif
        @endforeach
      </tbody>
      <tfoot>
        <th>Nombre del Proveedor</th>
        <th>Nombre del Conductor</th>
        <th>Ciudad</th>
        <th style="text-aling: center;">Fecha de Vencimiento SS</th>
        <th>Fecha de Vencimiento Licencia</th>
        <th></th>
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

$listado_conductores = $('#listado_conductores2').DataTable( {
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
          { 'sWidth': '4%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
      ]
  } );

</script>

</body>
</html>
