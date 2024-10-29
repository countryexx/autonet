<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Conductores Nuevos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('dropzonejs/dist/dropzone.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">

    <h3 class="h_titulo">CONDUCTORES DE {{$conductor->razonsocial}}</h3>
    <?php $sw = 0; ?>
    <!-- -->
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #f98006;">
        <div class="row">
          <div class="col-md-9">
            <span style="font-size: 40px;">INFORMACIÓN DEL CONDUCTOR</span>
          </div>
          <div class="col-md-2">
            @if($conductor->autorizado_cc===1)<!-- ESTADO CÉDULA -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($conductor->autorizado_cc===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif

            @if($conductor->autorizado_licencia===1)<!-- ESTADO LICENCIA -->
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($conductor->autorizado_licencia===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php $sw = 1; ?>
            @endif

            <!--@if($conductor->autorizado_seguridad_social===1) 
              <i class="fa fa-check" aria-hidden="true" style="font-size: 40px; color: green"></i>
            @elseif($conductor->autorizado_seguridad_social===2)
              <i class="fa fa-times" aria-hidden="true" style="font-size: 40px; color: red"></i>
            @else
              <i class="fa fa-clock-o th_up" aria-hidden="true" style="font-size: 40px; color: white"></i>
              <?php //$sw = 1; ?>
            @endif-->
          </div>
          <div class="col-md-1">
            @if($estado===1)
              <i class="fa fa-check" aria-hidden="true" style="font-size: 70px; color: green"></i>
            @else
              <i class="fa fa-clock-o" aria-hidden="true" style="font-size: 70px; color: white"></i>
            @endif

          </div>
        </div>
        </div>
        <div class="panel-body" style="background: #DADDE7">
          <div class="row">
              <!-- Fin división #1 -->
              <div class="col-md-3" style="border: 2px solid orange; height: 400px">
                <h1 class="h_titulo">{{$conductor->nombre_completo}}</h1>
                <img src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/'.$conductor->foto_conductor)}}" height="300px" width="100%" style="margin-bottom: 20px">

                <a style="margin-bottom: 20px; margin-left: 20px; float: right;" class="btn btn-info" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/'.$conductor->pdf_cc)}}">CC <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

                <a style="margin-left: 20px; margin-bottom: 20px; float: right;" class="btn btn-warning" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/'.$conductor->pdf_licencia)}}">LICENCIA <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

                <a style="margin-left: 20px; margin-bottom: 20px; float: right;" class="btn btn-danger" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial/'.$conductor->seguridad_social)}}">SS <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
              </div>
              <!-- Fin división #2 -->
              <div class="col-md-9" style="border: 2px solid orange; height: 400px">
                <h1 class="h_titulo">Datos</h1>
                <div class="row">
                  <div class="col-md-10">

                    <table cellspacing="0" id="table_detalle_solicitud" style="width: 120%;" border="1">
                    <thead>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">NOMBRE COMPLETO</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->nombre_completo}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">NÚMERO DE IDENTIFICACIÓN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->cc}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">GÉNERO / EDAD</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->genero}} / {{$conductor->edad}} AÑOS</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">UBICACIÓN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->ciudad}} - {{$conductor->departamento}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">DIRECCIÓN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->direccion}}</th>
                      </tr>
                      <tr bgcolor="#EFEFEF">
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">CELULAR</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->celular}}</th>
                      </tr>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>
                      <tr bgcolor="#f98006">
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">LICENCIA</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 5px">{{$conductor->tipo_licencia}} ; EXPEDICIÓN: {{$conductor->fecha_expedicion}} VIGENCIA {{$conductor->fecha_vigencia}}</th>
                      </tr>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 6px; text-align: center;">

                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 5px; text-align: center;">

                        </td>
                      </tr>

                    </thead>

                  </table>
                  </div>
                  <div class="col-md-2">

                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>
    <!-- -->
    <div class="panel panel-default">
      <div class="panel-heading" style="background: #f98006;"><span style="font-size: 40px">DOCUMENTACIÓN PDF</span></div>
        <div class="panel-body" style="background: white; height: 200%">
          <div class="row">
            <div class="col-md-12">
              <span style="font-family: monospace; font-size: 25px">@if($conductor->autorizado_cc===1){{ '<i class="fa fa-check icon_cc" aria-hidden="true" style="font-size: 30px; color: green"></i>' }}@elseif($conductor->autorizado_cc===2){{ '<i class="fa fa-times" aria-hidden="true" style="font-size: 30px; color: red"></i>' }}@else{{ '<i class="fa fa-clock-o icon_cc" aria-hidden="true" style="font-size: 30px; color: orange"></i>' }}@endif DOCUMENTO DE IDENTIFICACIÓN
                <a title="GUARDAR COMO DOCUMENTO INCORRECTO" id="documento_incorrecto_cc" data-option="cedula" data-id="{{$conductor->id}}" class="btn btn-danger documento_incorrecto @if($conductor->autorizado_cc!=null){{'disabled'}}@endif"><i class="fa fa-trash" aria-hidden="true"></i></a>
                <a title="APROBAR DOCUMENTO" id="documento_correcto_cc" data-option="cedula" data-id="{{$conductor->id}}" class="btn btn-primary documento_correcto @if($conductor->autorizado_cc!=null){{'disabled'}}@endif"><i class="fa fa-check" aria-hidden="true"></i></a>
              </span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/'.$conductor->pdf_cc)}}" width="100%" height="40%"></iframe>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <span style="font-family: monospace; font-size: 25px">@if($conductor->autorizado_licencia===1){{ '<i class="fa fa-check" aria-hidden="true" style="font-size: 30px; color: green"></i>' }}@elseif($conductor->autorizado_licencia===2){{ '<i class="fa fa-times" aria-hidden="true" style="font-size: 30px; color: red"></i>' }}@else{{ '<i class="fa fa-clock-o icon_licencia" aria-hidden="true" style="font-size: 30px; color: orange"></i>' }}@endif LICENCIA DE CONDUCCIÓN
                <a title="GUARDAR COMO DOCUMENTO INCORRECTO" id="documento_incorrecto_licencia" data-option="licencia" data-id="{{$conductor->id}}" class="btn btn-danger documento_incorrecto @if($conductor->autorizado_licencia!=null){{'disabled'}}@endif"><i class="fa fa-trash" aria-hidden="true"></i></a>
                <a title="APROBAR DOCUMENTO" id="documento_correcto_licencia" data-option="licencia" data-id="{{$conductor->id}}" class="btn btn-primary documento_correcto @if($conductor->autorizado_licencia!=null){{'disabled'}}@endif"><i class="fa fa-check" aria-hidden="true"></i></a>
              </span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/licencias/'.$conductor->pdf_licencia)}}" width="100%" height="40%"></iframe>
            </div>
          </div>
          <!--<div class="row">
            <div class="col-md-12">
              <span style="font-family: monospace; font-size: 25px">@if($conductor->autorizado_seguridad_social===1){{ '<i class="fa fa-check" aria-hidden="true" style="font-size: 30px; color: green"></i>' }}@elseif($conductor->autorizado_seguridad_social===2){{ '<i class="fa fa-times" aria-hidden="true" style="font-size: 30px; color: red"></i>' }}@else{{ '<i class="fa fa-clock-o icon_ss" aria-hidden="true" style="font-size: 30px; color: orange"></i>' }}@endif SEGURIDAD SOCIAL
                <a title="GUARDAR COMO DOCUMENTO INCORRECTO" id="documento_incorrecto_ss" data-option="ss" data-id="{{$conductor->id}}" class="btn btn-danger documento_incorrecto @if($conductor->autorizado_seguridad_social!=null){{'disabled'}}@endif"><i class="fa fa-trash" aria-hidden="true"></i></a>
                <a title="APROBAR DOCUMENTO" id="documento_correcto_ss" data-option="ss" data-id="{{$conductor->id}}" class="btn btn-primary documento_correcto @if($conductor->autorizado_seguridad_social!=null){{'disabled'}}@endif"><i class="fa fa-check" aria-hidden="true"></i></a>
              </span>
              <iframe src="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial/'.$conductor->seguridad_social)}}" width="100%" height="40%"></iframe>
            </div>
          </div>-->
          <!--<button style="margin-top: 20px; margin-right: 10px; margin-bottom: 30px; float: right;" data-value="{{$id}}" class="btn btn-success aprobar_conductorju">ENVIAR AL PROVEEDOR <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>-->
          @if($estado===1 or $sw===1)
            <button style="margin-top: 30px; margin-right: 10px; margin-bottom: 30px; float: right;" data-value="{{$id}}" class="btn btn-success disabled">GUARDAR DATOS<i class="fa fa-check" aria-hidden="true"></i></button>
          @elseif($sw===0)
            <button style="margin-top: 20px; margin-right: 10px; margin-bottom: 30px; float: right;" data-value="{{$id}}" class="btn btn-success aprobar_conductorju">GUARDAR DATOS <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
          @endif
        </div>
      </div>

      <!-- MODAL PDF -->
      <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background: #079F33">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;" id="name">INGRESO SEGURIDAD SOCIAL</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                        <input name="numero_planilla" id="numero_planilla" type='text' class="form-control input-font" value="" placeholder="NÚMERO DE PLANILLA">
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_inicial" id="fecha_inicial_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha INICIAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker2'>
                        <input name="fecha_final" id="fecha_final_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha FINAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-md-2 col-md-offset-10">
                    <button type="button" class="btn btn-primary confirmar_documento_correcto" style="float: left;">GUARDAR</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>

<script type="text/javascript">
    function goBack(){
        window.history.back();
    }
</script>
</body>
</html>
