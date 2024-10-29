<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de conductores</title>
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

    <h3 class="h_titulo">LISTADO DE CONDUCTORES</h3>
    <div class="col-sm-3">
      <div class="row">
        <div class="form-group">
          <select class="form-control input-font" name="listado_conductores_fotoss">
            <option value="1">TODOS</option>
            <option value="2">FOTOS AUTORIZADAS</option>
            <option value="3">FOTOS POR AUTORIZAR</option>
            <option value="4">SIN FOTO</option>
          </select>
        </div>
        <h3 class="hidden cargando">CARGANDO CONDUCTORES...</h3>
      </div>
    </div>
    <table class="table table-bordered table-hover" id="listado_conductores">
      <thead>
        <tr>
          <th>Nombre del Proveedor</th>
          <th>Nombre del Conductor</th>
          <th>Celular</th>
          <th>Cedula</th>
          <th>Fecha Vinculacion</th>
          <th>Tipo Licencia</th>
          <th>Fecha Expedicion</th>
          <th>Fecha Vigencia</th>
          <th>Informacion</th>
        </tr>
      </thead>
      <tbody>
        <?php
          ##CANTIDAD DE DOCUMENTOS POR VENCER POR TODOS LOS CONDUCTORES
          $documentos_por_vencer = 0;

          $documentos_vencidos = 0;

          #CANTIDAD DE CONDUCTORES QUE NO TIENEN SEGURIDAD SOCIAL
          $contar_seguridad = 0;
        ?>

        @foreach($conductores as $conductor)
            @if($conductor->nombre_completo)
                <?php

                  $i = 0;
                  $seguridad_social = null;
                  $estado_ssocial = null;

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
                  if (($licencia_conduccion>=0 && $licencia_conduccion<=30))
                  {
                      $documentos_por_vencer++;
                      $documentos_por_vencer_por_conductor++;
                  }
                ?>
                <tr
                    data-conductor-id="{{$conductor->id}}"
                    data-seguridad="<?php if($estado_ssocial===null): echo '0'; else: echo '1'; endif; ?>"
                    data-vencido="<?php if($documentos_vencidos_por_conductor>0): echo '1'; else: echo '0'; endif; ?>"
                    data-por-vencer="<?php if($documentos_por_vencer_por_conductor>0): echo '1'; else: echo '0'; endif; ?>"
                    class="@if($conductor->bloqueado_total==1 and $conductor->bloqueado==1){{'danger warning'}}@elseif($conductor->bloqueado_total==1){{'danger'}}@elseif($conductor->bloqueado==1){{'warning'}}@endif">
                    <td>{{$conductor->proveedor->razonsocial}}</td>
                    <td>{{$conductor->nombre_completo}}</td>
                    <td>{{$conductor->celular}}</td>
                    <td>{{$conductor->cc}}</td>
                    <td>{{$conductor->fecha_vinculacion}}</td>
                    <td>{{$conductor->tipodelicencia}}</td>
                    <td>{{$conductor->fecha_licencia_expedicion}}</td>
                    <td>{{$conductor->fecha_licencia_vigencia}}</td>
                    <td>
                      @if($conductor->foto_app!=null)

                        <button data-foto-id="{{$conductor->foto_app}}" conductor-id="{{$conductor->foto_app}}" class="btn btn-success mostrar_foto">FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>

                      @else

                        <button disabled="true" data-foto-id="{{$conductor->foto_app}}" conductor-id="{{$conductor->foto_app}}" class="btn btn-danger mostrar_foto">SIN FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>

                      @endif


                    </td>
                </tr>
            @endif
        @endforeach
      </tbody>
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
//FOTO NUEVO
  $('select[name="listado_conductores_fotoss"]').change(function(event) {

    var option = $(this).val();
    var url = $('meta[name="url"]').attr('content');
    $('.cargando').removeClass('hidden');
    $listado_conductores.clear().draw();

    $.ajax({
      url: url+'/proveedores/fotosconductores',
      type: 'post',
      dataType: 'json',
      data: {
        option: option
      }
    })
    .done(function(response, responseStatus, data) {

      if (data.status==200) {

        $('.cargando').addClass('hidden');

        var $conductores = data.responseJSON.conductores;
        //var documentos_conductores_vencidos = 0;
        //var documentos_conductores_por_vencer = 0;

        for (var i in $conductores) {

          var licencia_conduccion = null;
          var classEstado = '';
          var buttons = '';
          var badge = '';
          var documentos_vencidos = 0;
          var documentos_vehiculos_por_vencer = 0;
          var btnClassBadge = 'btn-default';

          licencia_conduccion = diffDate($conductores[i].fecha_licencia_vigencia);

          if (licencia_conduccion<0) documentos_vencidos++;

          if (documentos_vencidos>0) btnClassBadge = 'btn-danger';

          //CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS VENCIDOS
          if (licencia_conduccion<0){
              documentos_vencidos = 1;
          }

          //CANTIDAD DE VEHICULOS QUE TIENEN DOCUMENTOS POR VENCER
          if (licencia_conduccion>=0 && licencia_conduccion<=30)
          {
              documentos_vehiculos_por_vencer = 1;
          }

          bloqueado = $conductores[i].bloqueado_total==1 ? 'danger' : ($conductores[i].bloqueado) ? 'warning' : 'default';

          badge = '<a data-tarjeta-operacion="'+licencia_conduccion+'" class="btn '+btnClassBadge+' btn-list-table mostrar_alertas" style="padding: 6px 6px; display: inline-block" data-toggle="modal" data-target=".mdl_alertas" data-conductor-id="'+$conductores[i].id+'">'+
              '<i class="fa fa-envelope-o">'+
                  '<span style="padding: 0 4px; margin-left: 4px;" class="badge">'+documentos_vencidos+'</span>'+
              '</i>'+
          '</a>';

          buttons = '<div class="btn-group dropdown" style="display: inline-block">'+
                      '<button style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success dropdown-toggle btn-list-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
                          'ver <span class="caret"></span>'+
                      '</button>'+
                      '<ul class="dropdown-menu dropdown-menu-right">'+
                        '<li>'+
                          '<a href="'+url+'/proveedores/conductores/'+$conductores[i].proveedores_id+'">DOCUMENTACION</a>'+
                        '</li>'+
                        '<li>'+
                          '<a href="#" class="bloqueo_conductores" data-conductor-id="'+$conductores[i].id+'" data-toggle="modal" data-target="#open_modal_bloqueo_conductores">BLOQUEOS</a>'+
                        '</li>'+
                        '<li>'+
                          '<a href="#" data-id-conductor="'+$conductores[i].id+'" data-toggle="modal" data-target=".mdl_app_aotour" class="app_aotour">APP MOBILE</a>'+
                        '</li>'+
                        '<li>'+
                          '<a data-archivar="'+$conductores[i].archivado+'" data-conductor-id="'+$conductores[i].id+'" href="#" class="archivar">'+
                            (($conductores[i].archivado==1) ? 'DESARCHIVAR' : 'ARCHIVAR' )+
                          '</a>'+
                        '</li>'+
                      '</ul>'+
                  '</div>'+
                  badge;


           if($conductores[i].foto_app!=null && $conductores[i].foto_autorizacion==1){
              var value = '<button data-foto-id="'+$conductores[i].foto_app+'" conductor-id="'+$conductores[i].id+'" class="btn btn-success mostrar_foto">FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>';
            }else if (($conductores[i].foto_app!=null || $conductores[i].foto_sin_autorizar!=null) && $conductores[i].foto_autorizacion==0){
                if($conductores[i].foto_sin_autorizar!=null){
                  var img_data = $conductores[i].foto_sin_autorizar;
                }else{
                  var img_data = $conductores[i].foto_app;
                }
              var value = '<button data-foto-id="'+img_data+'" conductor-id="'+$conductores[i].id+'" class="btn btn-warning mostrar_foto">FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>';
            }else{
              var value = '<button disabled="true" data-foto-id="'+$conductores[i].foto_app+'" conductor-id="'+$conductores[i].id+'" class="btn btn-danger mostrar_foto">SIN FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>';
            }

          $listado_conductores.row.add([
            $conductores[i].proveedor.razonsocial,
            $conductores[i].nombre_completo,
            $conductores[i].celular,
            $conductores[i].cc,
            $conductores[i].fecha_vinculacion,
            $conductores[i].tipodelicencia,
            $conductores[i].fecha_licencia_expedicion,
            $conductores[i].fecha_licencia_vigencia,
            value,
          ]).nodes().to$().addClass(bloqueado).attr({
            'data-conductor-id': $conductores[i].id,
            'data-vencido': documentos_vencidos,
            'data-por-vencer': documentos_vehiculos_por_vencer
          });

        }

        $listado_conductores.draw();

      }
      if(data.response===false){
        $listado_conductores.clear().draw();
        alert('No se encontraron datos')
      }

    }).fail(function(data) {

      if (data.status==404) {

        $('.container_restricciones').addClass('hidden');
        $('.container_restricciones ul').html('');

        $('#form_restriccion_vehiculo').attr('data-vehiculo-id', vehiculo_id);
        $('#open_modal_bloqueo_vehiculos').modal('hide');
        $('#open_modal_restriccion').modal('show');

      }else if(data.status==401){
        location.reload();
      }

    });

  });
  //FOTOS NUEVO
</script>

</body>
</html>
