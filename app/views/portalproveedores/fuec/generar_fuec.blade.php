<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Generar Fuec</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>

    .doc {
      float: right;
    }
    .cond {
      float: right;
    }
    /* Center the loader */
    #loader {
      position: absolute;
      left: 40%;
      bottom: 12%;
      z-index: 1;
      width: 60px;
      height: 60px;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #f47321;
      -webkit-animation: spin 1s linear infinite;
      animation: spin 1s linear infinite;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Add animation to "page content" */
    .animate-bottom {
      position: relative;
      -webkit-animation-name: animatebottom;
      -webkit-animation-duration: 1s;
      animation-name: animatebottom;
      animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
      from { bottom:-100px; opacity:0 }
      to { bottom:0px; opacity:1 }
    }

    @keyframes animatebottom {
      from{ bottom:-100px; opacity:0 }
      to{ bottom:0; opacity:1 }
    }

    #myDiv {
      display: none;
      text-align: center;
    }

    </style>
  </head>
  <body >
  @include('admin.menu')
  
  <div class="col-lg-12">
      <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">

                    <a data-id="{{Sentry::getUser()->proveedor_id}}" style="float: right;" id="ciudadd" class="detalles_centro btn btn-list-table btn-info ">Buscar <i class="fa fa-search-plus" aria-hidden="true"></i></a>
                    <br><br>
                    <!--<select id="ciudadd" class="form-control input-font" style="margin-bottom: 20px">
                        <option value="0">SELECCIONAR CIUDAD</option>
                        <option value="BARRANQUILLA">BARRANQUILLA</option>
                        <option value="BOGOTA">BOGOTA</option>
                    </select>-->
                  </div>
                  <i id="cargando" style="margin-left: 12px; font-size: 20px" class="fa fa-spinner fa-spin hidden"></i>
              </div>
          </div>
      </form>

      <div class="row" style="margin-top: 25px">
        <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="panel panel-default">
                  <div class="panel-heading">Lista de Conductores
                    <a style="float: right;" id="continuar_proceso" class="detalles_centro btn btn-list-table btn-primary ">Continuar</a>
                  </div>
                  <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 500px; margin-top: 20px">

                    <table name="mytableT" id="proveedoress" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                       <thead>
                         <tr>
                          <td>Check</td>
                           <td>Proveedor</td>
                           <td>Conductor</td>
                           <td>Vehículo</td>
                         </tr>
                       </thead>
                       <tbody>

                       </tbody>
                     </table>
                  </div>
              </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id='modal_fuec'>

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;" id="proveedor_nombre"> GENERACIÓN DE FUEC </h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>SELECCIONAR CLIENTES</b> </div>
                        <div class="panel-body" style="padding-top: 0; overflow-y: auto; height: 360px; margin-top: 20px">

                          <table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                             <thead>
                               <tr>
                                <td>Check</td>
                                 <td>Nombre del Cliente</td>
                               </tr>
                             </thead>
                             <tbody>

                             </tbody>
                           </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="panel panel-default">
                          <div class="panel-heading" style="background: #FA8A2C"><b>SELECCIONAR RUTAS</b>
                            <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">NO HAY ARCHIVO! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          </div>
                          <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 360px; margin-top: 20px">
                            <table name="rutasF" id="table_rutas" class="table table-hover table-bordered tablesorter">
                               <thead>
                                 <tr>
                                   <td></td>
                                   <td>Origen</td>
                                   <td>Destino</td>
                                 </tr>
                               </thead>
                               <tbody>
                                 @foreach($rutas_fuec as $rutas)
                                  <tr>
                                    <td data-id="{{$rutas->id}}">
                                      <input style="width: 15px; height: 15px;" type="checkbox" check="false">
                                    </td>
                                    <td>{{$rutas->origen}}</td>
                                    <td>{{$rutas->destino}}</td>
                                  </tr>
                                 @endforeach
                               </tbody>
                             </table>
                          </div>
                      </div>
                </div>
                <!--<div class="col-lg-12 col-md-12 col-sm-12">
                  <select id="objeto_contrato" class="form-control input-font" style="margin-bottom: 25px">
                      <option>OBJETO DE CONTRATO</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL</option>
                      <option>TRANSPORTE TERRESTRE DE TURISTAS</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y AMIGOS</option>
                      <option>TRANSPORTE TERRESTRE DE HUESPEDES</option>
                      <option>TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD</option>
                      <option>TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR</option>
                      <option>TRANSPORTE TERRESTRE GRUPO ESPECÍFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)</option>
                  </select>
                </div>-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary guardar_fuecs"><span class="hecho hidden">Hecho <i class="fa fa-check" aria-hidden="true"></i></span> <span class="generando hidden">Generando <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span> <span class="generar">Generar</span></button>
              </div>
          </div>
        </div>
      </div>

      <!--<div class="modal fade" tabindex="-1" role="dialog" id='modal_documentos'>
        <div class="modal-dialog modal-xs" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;">DOCUMENTACIÓN VEHÍCULO</h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>Documentos</b> </div>
                        <div class="panel-body">
                          <h5 id="soat"></h5>
                          <br>
                          <h5 id="tecnomecanica"></h5>
                          <br>
                          <h5 id="mantenimiento_preventivo"></h5>
                          <br>
                          <h5 id="tarjeta_operacion"></h5>
                          <br>
                          <h5 id="poliza_contractual"></h5>
                          <br>
                          <h5 id="poliza_extracontractual"></h5>
                          <br>
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
        </div>
      </div>-->

      <!--<div class="modal fade" tabindex="-1" role="dialog" id='modal_conductor'>
        <div class="modal-dialog modal-xs" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;">DOCUMENTACIÓN CONDUCTOR</h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>Documentos</b> </div>
                        <div class="panel-body">
                          <h5 id="licencia"></h5>
                          <br>
                          <h5 id="seguridad_social"></h5>
                          <br>
                          <h5 id="examenes"></h5>
                          <br>
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
        </div>
      </div>-->

      <div class="documentacion_conductor hidden">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>DOCUMENTACION DEL CONDUCTOR</strong>
            </div>
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_fvencimiento" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
                </li>
              </ul>
              <button type="button" class="btn btn-primary btn-block ok">
                OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="documentacion_vehiculo hidden">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>DOCUMENTACION DEL VEHICULO</strong>
            </div>
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
                </li>
              </ul>
              <button type="button" class="btn btn-primary btn-block ok">
                OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

  </div>

  @include('scripts.scripts')

  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <!--<script src="{{url('jquery/fuec.js')}}"></script>-->
  <script type="text/javascript">

    $('#ciudadd').click(function () {

    var url = $('meta[name="url"]').attr('content');
    var valor = $('#ciudadd').val();
    var id = $(this).attr('data-id');
    console.log(id)

    $('#cargando').removeClass('hidden');

    $listado_proveedoress.clear().draw();

      $.ajax({
          method: 'post',
          url: url+'/portalproveedores/proveedores',
          data: {'ciudad':valor, 'id': id},
          dataType: 'json',
          success: function (data) {

            if(data.response===true){

              var fecha_actual = data.fecha_actual;

              for(var i in data.proveedores) {

                var administracion = data.administracion[i];
                var soat = data.proveedores[i].fecha_vigencia_soat;
                var tarjeta_operacion = data.proveedores[i].fecha_vigencia_operacion;
                var tecnomecanica = data.proveedores[i].fecha_vigencia_tecnomecanica;
                var mantenimiento_preventivo = data.proveedores[i].mantenimiento_preventivo;
                var poliza_contractual = data.proveedores[i].poliza_contractual;
                var poliza_extracontractual = data.proveedores[i].poliza_extracontractual;

                var licencia = data.proveedores[i].fecha_licencia_vigencia;
                var seguridad_social = data.conductores[i];
                var examenes = data.examenes[i];

                var fecha_maxima = soat;
                var sw = 0;
                if(tarjeta_operacion<fecha_maxima){
                  fecha_maxima = tarjeta_operacion;
                }
                if(tecnomecanica<fecha_maxima){
                  fecha_maxima = tecnomecanica;
                }
                if(mantenimiento_preventivo<fecha_maxima){
                  fecha_maxima = mantenimiento_preventivo;
                }
                if(poliza_contractual<fecha_maxima){
                  fecha_maxima = poliza_contractual;
                }
                if(poliza_extracontractual<fecha_maxima){
                  fecha_maxima = poliza_extracontractual;
                }

                if(licencia<fecha_maxima){
                  fecha_maxima = licencia;
                  sw = 1;
                }
                if(seguridad_social<fecha_maxima){
                  fecha_maxima = seguridad_social;
                  sw = 1;
                }

                if(sw===0){
                  var fecha_maxima_conductor = '';
                  var fecha_maxima_vehiculo = ' | '+fecha_maxima;
                }else{
                  var fecha_maxima_conductor = ' | '+fecha_maxima;
                  var fecha_maxima_vehiculo = '';
                }

                if(fecha_actual>soat || fecha_actual>tarjeta_operacion || fecha_actual>tecnomecanica || fecha_actual>mantenimiento_preventivo || fecha_actual>poliza_contractual || fecha_actual>poliza_extracontractual || administracion === 0){
                  var clase = 'danger';
                }else{
                  var clase = 'success';
                }
                var clase_vehiculo = clase;

                //COLORES CONDUCTOR

                if(data.proveedores[i].nombre_completo === 'ALEJANDRO ACOSTA LEGUIZAMON'){
                  console.log(seguridad_social+ ' , '+examenes)
                }

                if(fecha_actual>licencia || seguridad_social===0 || examenes === null){
                  var clase_conductor = 'danger';
                }else{
                  var clase_conductor = 'success';
                }

                if(clase_conductor === 'success' && clase_vehiculo === 'success'){
                  clase_fila = 'success';
                  var estado = '';
                }else{
                  clase_fila = 'danger';
                  var estado = 'disabled';
                }

                var documentacion_btn_vehiculo = '<a administracion="'+administracion+'" soat="'+soat+'" tecnomecanica="'+tecnomecanica+'" mantenimiento_preventivo="'+mantenimiento_preventivo+'" tarjeta_operacion="'+tarjeta_operacion+'" poliza_contractual="'+poliza_contractual+'" poliza_extracontractual="'+poliza_extracontractual+'" type="button" class="btn btn-list-table btn-'+clase_vehiculo+' doc"> Documentación</a>';

                var documentacion_btn_conductor = '<a licencia="'+licencia+'" seguridad_social="'+seguridad_social+'" examenes="'+examenes+'" type="button" class="btn btn-list-table btn-'+clase_conductor+' cond"> Documentación</a>';

                var conductor = data.proveedores[i].nombre_completo+fecha_maxima_conductor+ ' '+documentacion_btn_conductor;
                var placa = data.proveedores[i].placa+fecha_maxima_vehiculo+ ' '+documentacion_btn_vehiculo;

                var check = '<input data-valores="'+fecha_maxima+'" class="rowss" style="width: 15px; height: 15px;" type="checkbox" '+estado+' check="false">';

                $('#cargando').addClass('hidden');

                $listado_proveedoress.row.add([
                    check,
                    data.proveedores[i].razonsocial,
                    '<b style="font-size: 13px">'+conductor+'</b>',
                    '<b style="font-size: 13px">'+placa+'</b>',
                ]).draw().nodes().to$().addClass(clase_fila).attr('proveedor', data.proveedores[i].id).attr('fecha_v',fecha_maxima).attr('conductor', data.proveedores[i].id_conductor).attr('vehiculo', data.proveedores[i].id_vehiculo);

              }

            }else if(data.mensaje===false){
              $('#cargando').addClass('hidden');

            }
            $('#cargando').addClass('hidden');
          }
      });

  });

  $('.ok').click(function(e){
    $(this).closest('.documentacion_conductor, .documentacion_vehiculo').addClass('hidden');
  });

  $('#proveedoress').on('click', '.doc', function(event) {
    var administracion = $(this).attr('administracion');
    var soat = $(this).attr('soat');
    var tecnomecanica = $(this).attr('tecnomecanica');
    var mantenimiento_preventivo = $(this).attr('mantenimiento_preventivo');
    var tarjeta_operacion = $(this).attr('tarjeta_operacion');
    var poliza_contractual = $(this).attr('poliza_contractual');
    var poliza_extracontractual = $(this).attr('poliza_extracontractual');

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;

    $('.documentacion_vehiculo').removeClass('hidden');

    if (administracion==='0') {
      $('#vadministracion').removeAttr('class').addClass('text-danger bolder').html('NO HAY UN PAGO REGISTRADO PARA ESTE MES');
      $('#vadministracion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }else{
      $('#vadministracion').removeAttr('class').addClass('text-success bolder').html('HAY UN PAGO REGISTRADO PARA ESTE MES');
      $('#vadministracion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }

    if (tarjeta_operacion >= output) {
      if ($('#vtarjeta_operacion').hasClass('text-danger')) {
        $('#vtarjeta_operacion').removeClass('text-danger');
      }
      $('#vtarjeta_operacion').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+tarjeta_operacion);
      $('#vtarjeta_operacion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(tarjeta_operacion < output){
      if ($('#vtarjeta_operacion').hasClass('text-success')) {
        $('#vtarjeta_operacion').removeClass('text-success');
      }
      $('#vtarjeta_operacion').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+tarjeta_operacion);
      $('#vtarjeta_operacion').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

    if ( soat >= output) {
      if ($('#vsoat').hasClass('text-danger')) {
        $('#vsoat').removeClass('text-danger');
      }
      $('#vsoat').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+soat);
      $('#vsoat').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(soat < output){
      if ($('#vsoat').hasClass('text-success')) {
        $('#vsoat').removeClass('text-success');
      }
      $('#vsoat').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+soat);
      $('#vsoat').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

    if (tecnomecanica >= output) {
      if ($('#vtecnomecanica').hasClass('text-danger')) {
        $('#vtecnomecanica').removeClass('text-danger');
      }
      $('#vtecnomecanica').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+tecnomecanica);
      $('#vtecnomecanica').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(tecnomecanica < output){
      if ($('#vtecnomecanica').hasClass('text-success')) {
        $('#vtecnomecanica').removeClass('text-success');
      }
      $('#vtecnomecanica').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+tecnomecanica);
      $('#vtecnomecanica').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

    if (mantenimiento_preventivo >= output) {
      if ($('#vmantenimiento_preventivo').hasClass('text-danger')) {
        $('#vmantenimiento_preventivo').removeClass('text-danger');
      }
      $('#vmantenimiento_preventivo').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+mantenimiento_preventivo);
      $('#vmantenimiento_preventivo').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(mantenimiento_preventivo < output){
      if ($('#vmantenimiento_preventivo').hasClass('text-success')) {
        $('#vmantenimiento_preventivo').removeClass('text-success');
      }
      $('#vmantenimiento_preventivo').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+mantenimiento_preventivo);
      $('#vmantenimiento_preventivo').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

    if (poliza_contractual >= output) {
      if ($('#vpoliza_contractual').hasClass('text-danger')) {
        $('#vpoliza_contractual').removeClass('text-danger');
      }
      $('#vpoliza_contractual').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+poliza_contractual);
      $('#vpoliza_contractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(poliza_contractual < output){
      if ($('#vpoliza_contractual').hasClass('text-success')) {
        $('#vpoliza_contractual').removeClass('text-success');
      }
      $('#vpoliza_contractual').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+poliza_contractual);
      $('#vpoliza_contractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

    if (poliza_extracontractual >= output) {
      if ($('#vpoliza_extracontractual').hasClass('text-danger')) {
        $('#vpoliza_extracontractual').removeClass('text-danger');
      }
      $('#vpoliza_extracontractual').removeAttr('class').addClass('text-success bolder').html('FECHA DE VENCIMIENTO: '+poliza_extracontractual);
      $('#vpoliza_extracontractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-check list-check');
    }else if(poliza_extracontractual < output){
      if ($('#vpoliza_extracontractual').hasClass('text-success')) {
        $('#vpoliza_extracontractual').removeClass('text-success');
      }
      $('#vpoliza_extracontractual').removeAttr('class').addClass('text-danger bolder').html('FECHA DE VENCIMIENTO: '+poliza_extracontractual);
      $('#vpoliza_extracontractual').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('circle_alerta fa fa-close list-close');
    }

  });

  $('#proveedoress').on('click', '.cond', function(event) {
    var licencia = $(this).attr('licencia');
    var seguridad_social = $(this).attr('seguridad_social');
    var examenes = $(this).attr('examenes');

    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();
    var output = d.getFullYear() + '-' + (month<10 ? '0' : '') + month + '-' + (day<10 ? '0' : '') + day;

    $('.documentacion_conductor').removeClass('hidden');

    if (seguridad_social==='0') {
      $('#conductor_fssocial').removeAttr('class').addClass('text-danger bolder').html('NO EXISTE UN PAGO REGISTRADO PARA ESTE MES');
      $('#conductor_fssocial').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
    }else if(seguridad_social != 0){
      $('#conductor_fssocial').removeAttr('class').addClass('text-success bolder').html('HAY UN PAGO REGISTRADO PARA ESTE MES');
      $('#conductor_fssocial').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');
    }

    if (licencia > output) {
      if ($('#conductor_fvencimiento').hasClass('text-danger')) {
        $('#conductor_fvencimiento').removeClass('text-danger');
      }
      $('#conductor_fvencimiento').addClass('text-success').html('FECHA DE VENCIMIENTO: '+licencia);
      $('#conductor_fvencimiento').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');

    }else if(licencia < output){
      $('#conductor_fvencimiento').removeClass('text-success').addClass('text-danger').html('FECHA DE VENCIMIENTO: '+licencia);
      $('#conductor_fvencimiento').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
    }

    if (examenes === 'null'){
      if ($('#conductor_examenes').hasClass('text-success')) {
        $('#conductor_examenes').removeClass('text-success');
      }
      $('#conductor_examenes').addClass('text-danger').html('NO SE HA REALIZADO LOS EXAMENES <br>PSICOSENSOMETRICOS.');
      $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');

    }else if(parseInt(examenes) >= -365){ // no han registrado fecha de realizacion de examen

      if ($('#conductor_examenes').hasClass('text-danger')) { // esta dentro del rango de fecha de 6 meses
        $('#conductor_examenes').removeClass('text-danger');
      }
      $('#conductor_examenes').addClass('text-success').html('EXAMENES REALIZADOS: '+examenes);
      $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-check list-check circle_alerta');

    }else if(examenes <= -365){ // ya cumplio los 6 meses de vigencia del examen
      if ($('#conductor_examenes').hasClass('text-success')) {
        $('#conductor_examenes').removeClass('text-success');
      }
      $('#conductor_examenes').addClass('text-danger').html('EXAMENES VENCIDOS: '+examenes);
      $('#conductor_examenes').closest('.list-group-item').find('.circle_alerta').removeAttr('class').addClass('fa fa-close list-close circle_alerta');
    }

  });

  $('#continuar_proceso').click(function (event) {

    console.log('continuar_proceso')
    var url = $('meta[name="url"]').attr('content');
    rutaArray = [];
    descripcionArray = [];
    recogerenArray = [];
    dejarenArray = [];
    codcentrocostoArray = [];
    fechainicioArray = [];
    horainicioArray = [];
    observacionArray = [];
    planillaArray = [];

    dataProveedorArray = [];
    dataConductorArray = [];
    dataVehiculoArray = [];


    $('#proveedoress tbody tr').each(function(index){

        var observacion='';

        var valorCheckbox = $(this).find('td input[type="checkbox"]').is(':checked');

        if ($(this).find('td input[type="checkbox"]').is(':checked')) {

          console.log($(this).attr('proveedor'));

          console.log($(this).attr('conductor'));

          console.log($(this).attr('vehiculo'));

          dataProveedorArray.push($(this).attr('proveedor'));
          dataConductorArray.push($(this).attr('conductor'));
          dataVehiculoArray.push($(this).attr('vehiculo'));

        }

    });

    //console.log('proveedores : '+dataProveedorArray.length);

    if(dataProveedorArray.length<1){

      $.confirm({
          title: '<i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i> ATENCIÓN!',
          content: 'Debe seleccionar por lo menos una fila...',
          type: 'red',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'CERRAR',
              btnClass: 'btn-danger',
              action: function(){
              }
            }
          }
      });

    }else{

      $('.guardar_fuecs').attr('proveedores',dataProveedorArray);

      $('.guardar_fuecs').attr('conductores',dataConductorArray);

      $('.guardar_fuecs').attr('vehiculos',dataVehiculoArray);

      console.log(dataProveedorArray); //ARRAY CON ID DE PROVEEDORES
      console.log(dataConductorArray); //ARRAY CON ID DE CONDUCTORES
      console.log(dataVehiculoArray); //ARRAY CON ID DE VEHICULOS

      /*Atach de clientes*/

      var valor = $('#ciudad').val();

      $.ajax({
        method: 'post',
        url: url+'/portalproveedores/filtroclientes',
        data: {'ciudad':valor},
        dataType: 'json',
        success: function (data) {

          if(data.response===true){

            $listado_clientes.clear().draw();

            for(var i in data.clientes) {

              var check = '<input style="width: 15px; height: 15px;" type="checkbox" check="false">';

              $listado_clientes.row.add([
                  check,
                  data.clientes[i].razonsocial,
              ]).draw().nodes().to$().attr('razonsocial', data.clientes[i].razonsocial).attr('id', data.clientes[i].id);

            }

          }
        }
      });
      /*Atach de clientes*/

      $('#modal_fuec').modal('show');

    }

  });

  $('#proveedoress').on('click', '.rowss', function(event) {

    var check = $(this).is(':checked');
    var data = '';
    var id_proveedor = $(this).attr('data-proveedor');
    var fecha = $(this).attr('data-valores');
    
    if($(this).is(':checked')){
      data = 'checked';

      $.confirm({
          title: '<i style="color: orange" class="fa fa-exclamation-triangle" aria-hidden="true"></i> ATENCIÓN!',
          content: 'Los fuec de este conductor se generarán hasta el <br>'+fecha,
          type: 'orange',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'OK',
              btnClass: 'btn-warning',
              action: function(){
              }
            }
          }
      });

    }else{
      data = 'no checked';
    }

    console.log(data)

  });

  $('.guardar_fuecs').click(function(e){

    var proveedores = $(this).attr('proveedores');
    var conductores = $(this).attr('conductores');
    var vehiculos = $(this).attr('vehiculos');

    cont_cond = 0;
    cont_estado = 0;
    arrayId = [];

    /*var jc = $.dialog({
      title: '<div id="loader"></div>',
      closeIcon: false,
      //backgroundDismiss: true,
      content: '',
    });*/

    /*$.confirm({
        title: '',
        content: '<div id="loader"></div>',
    });*/

    //console.log('Proveedores: '+ proveedores) //ARRAY CON ID DE CONDUCTORES
    //console.log('Conductores: '+ conductores) //ARRAY CON ID DE CONDUCTORES
    //console.log('Vehículos: '+ vehiculos) //ARRAY CON ID DE CONDUCTORES

    /*Selección de Rutas*/

    //jc.close();

    dataidArray = [];

    $('#table_rutas tbody tr').each(function(index){

        var valorCheckbox = $(this).find('td input[type="checkbox"]').is(':checked');//.attr('check');

        if ($(this).find('td input[type="checkbox"]').is(':checked')) {

            $(this).children("td").each(function (index2){

                switch (index2){

                    case 0: dataidArray.push($(this).attr('data-id'));
                    break;

                }
            });

        }
    });

    //console.log('Rutas : '+dataidArray); //ARRAY CON ID DE RUTAS
    /*Selección de Rutas*/

    /*Selección de Clientes*/

    dataClientesArray = [];

    $('#clientes_fuec tbody tr').each(function(index){

        var valorCheckbox = $(this).find('td input[type="checkbox"]').is(':checked');

        if ($(this).find('td input[type="checkbox"]').is(':checked')) {

          dataClientesArray.push($(this).attr('id'));

        }
    });

    //console.log('Clientes : '+dataClientesArray); //ARRAY CON ID DE RUTAS
    /*Selección de Clientes*/

    if(dataidArray.length < 1 || dataClientesArray.length < 1){
      var texto = '';
      if(dataidArray.length < 1){
        texto +="Debe seleccionar por lo menos una ruta... <br><br>"
      }
      if(dataClientesArray.length < 1){
        texto +="Debe seleccionar por lo menos un cliente..."
      }

      $.confirm({
          title: '<i style="color: red" class="fa fa-exclamation-triangle" aria-hidden="true"></i> ATENCIÓN!',
          content: texto,
          type: 'red',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'CERRAR',
              btnClass: 'btn-danger',
              action: function(){
              }
            }
          }
      });

    }else{

      $.confirm({
          title: '<i style="color: black" class="fa fa-exclamation-triangle primary" aria-hidden="true"></i> CONFIRMACIÓN',
          content: 'Confirma la generación de los fuec con los ítems seleccionados?',
          type: 'white',
          typeAnimated: true,
          buttons: {
            cancel: {
              text: 'CANCELAR',
              btnClass: 'btn-danger',
              action: function(){
              }
            },
            tryAgain: {
              text: 'SÍ, GENERAR!',
              btnClass: 'btn-primary',
              action: function(){

                $('.guardar_fuecs').attr('disabled', 'disabled');

                $('.generando').removeClass('hidden');
                $('.generar').addClass('hidden');

                formData = new FormData();
                formData.append('proveedores', proveedores);
                formData.append('conductores',conductores);
                formData.append('vehiculos',vehiculos);

                formData.append('rutas',dataidArray);
                formData.append('clientes',dataClientesArray);

                $.ajax({
                  type: "post",
                  url: "fuecs",
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function(data) {

                    if(data.response===false){

                      $.confirm({
                          title: '¡REALIZADO! <i style="color: green" class="fa fa-check" aria-hidden="true"></i>',
                          content: 'Fueron generados '+data.contador_fuec+' FUECS.',
                          type: 'green',
                          typeAnimated: true,
                          buttons: {
                            tryAgain: {
                              text: 'OK',
                              btnClass: 'btn-danger',
                              action: function(){
                                location.reload();
                              }
                            }
                          }
                      });

                      $('.generando').addClass('hidden');
                      $('.generar').addClass('hidden');
                      $('.hecho').removeClass('hidden');

                      console.log('Fuecs creados!')
                    }else if(data.response===true){

                      preguntar(data.proveedores, data.conductores, data.vehiculos, data.rutas, data.clientes, data.contador, data.contador_fuec)

                    }else if(data.respuesta==='relogin'){
                      location.reload();
                    }else{

                    }
                  }
                });

              }
            }
          }
      });

    }

  });
  
  function preguntar(proveedores, conductores, vehiculos, dataidArray, dataClientesArray, contador, contador_fuec){

    formData = new FormData();
    formData.append('proveedores', proveedores);
    formData.append('conductores',conductores);
    formData.append('vehiculos',vehiculos);

    formData.append('rutas',dataidArray);
    formData.append('clientes',dataClientesArray);
    formData.append('contador', contador);
    formData.append('contador_fuec', contador_fuec);

    $.ajax({
      type: "post",
      url: "fuecs",
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {

        if(data.response===true){

          preguntar(data.proveedores, data.conductores, data.vehiculos, data.rutas, data.clientes, data.contador, data.contador_fuec)

        }else if(data.response===false){

          $.confirm({
              title: '¡REALIZADO! <i style="color: green" class="fa fa-check" aria-hidden="true"></i>',
              content: 'Fueron generados '+data.contador_fuec+' FUECS.',
              type: 'green',
              typeAnimated: true,
              buttons: {
                tryAgain: {
                  text: 'OK',
                  btnClass: 'btn-danger',
                  action: function(){
                    location.reload();
                  }
                }
              }
          });

          $('.generando').addClass('hidden');
          $('.generar').addClass('hidden');
          $('.hecho').removeClass('hidden');

          console.log('Fuecs creados!')

          //$.alert('PDF no válido!');
        }else if(data.respuesta==='relogin'){
          location.reload();
        }else{

        }
      }
    });

  }

var $listado_proveedoress = $('#proveedoress').DataTable({
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
                sortDescending: ": activer pour trier la colonne par ordre d?croissant"
            }
        },
        'bAutoWidth': false ,
        "paging": false,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '4%' },
            { 'sWidth': '8%' },
            { 'sWidth': '6%' },
        ]
    });

    var $listado_clientes = $('#clientes_fuec').DataTable({
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
                sortDescending: ": activer pour trier la colonne par ordre d?croissant"
            }
        },
        'bAutoWidth': false ,
        "paging": false,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '9%' },
        ]
    });

    var $table_rutas = $('#table_rutas').DataTable({
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
            { 'sWidth': '1%' }, //Origen
            { 'sWidth': '7%' }, //Destino
            { 'sWidth': '7%' }, //checkbox
        ],
        processing: true,
        "bProcessing": true
    });

  </script>
  </body>
  </html>
