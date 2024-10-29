<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Vehículos en Revisión</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style type="text/css">
      a.notif {
        position: relative;
        display: block;
        height: 50px;
        width: 50px;
        background: url('http://i.imgur.com/evpC48G.png');
        background-size: contain;
        text-decoration: none;
      }
      .num {
        position: absolute;
        right: 11px;
        top: 6px;
        color: #fff;
      }
    </style>
</head>
<body>

@include('admin.menu')
<div class="col-xs-12">
<h1 class="h_titulo">Vehículos en Revisión</h1>
    <div class="col-lg-8">
      <div class="row">
          @include('portalproveedores.menu_proveedores')
      </div>
    </div>

    @if(isset($proveedores))
      <table id="examplenew" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>Nit</th>
                <th>Razon Social</th>
                <th>Email</th>
                <th>Ciudad</th>
                <th>Estados</th>
                <th>Áreas</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Nit</th>
            <th>Razon Social</th>
            <th>Email</th>
            <th>Ciudad</th>
            <th>Estados</th>
            <th>Áreas</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>
          @foreach($proveedores as $proveedor)
          <?php
          $sw = 0;
          $sw2 = 0;
          $sw3 = 0;

          if($proveedor->autorizacion_th===1){
            $icon_th = 'check';
            $fondo_th = 'green';
          }else{
            $icon_th = 'times';
            $fondo_th = 'red';
          }

          if($proveedor->autorizacion_juridica===1){
            $icon_juridica = 'check';
            $fondo_juridica = 'green';
          }else{
            $icon_juridica = 'times';
            $fondo_juridica = 'red';
          }

          if($proveedor->autorizacion_contabilidad===1){
            $icon_contabilidad = 'check';
            $fondo_contabilidad = 'green';
          }else{
            $icon_contabilidad = 'times';
            $fondo_contabilidad = 'red';
          }

          ?>
            <tr>
              <td>{{$proveedor->nit}}-{{$proveedor->digito_verificacion}}</td>
              <td><a title="{{$proveedor->nombre_completo}} | {{$proveedor->placa}}">{{$proveedor->razonsocial}} {{$proveedor->tipo_empresa}}</a></td>
              <td><a href="mailto:{{$proveedor->email}}">{{$proveedor->email}}</a></td>
              <td>{{$proveedor->ciudad}}</td>
              <td>
                @if($proveedor->estado_global===null)
                  <span style="padding: 4px; background: red; color: white">PENDIENTE REVISIÓN</span>                  
                @elseif($proveedor->estado_global===1)
                  <span style="padding: 4px; background: red; color: white">REVISIÓN DOCUMENTAL</span>
                  <i style="color: orange; float: right; font-size: 23px;" class="fa fa-info-circle info" aria-hidden="true"></i>
                @elseif($proveedor->estado_global===11 and $proveedor->autorizacion_contabilidad===1)
                  <span style="padding: 4px; background: red; color: white">RESPUESTA DATOS BANCARIOS</span>
                @elseif($proveedor->estado_global===2)
                  <span style="padding: 4px; background: red; color: white">CORRECCIÓN DE DOCS ENVIADA</span>
                @elseif($proveedor->estado_global===3)
                  <span style="padding: 4px; background: red; color: white">CORRECCIÓN DE DOCS RESPONDIDA</span>
                @elseif($proveedor->estado_global===4)
                  <span style="padding: 4px; background: green; color: white">EN PROCESO DE CAPACITACIÓN</span>
                @endif
                
              </td>
              <td id="{{$proveedor->id}}">

                <?php
                if($proveedor->autorizado_juridica===1){
                  $class_proveedor = 'success';
                }else{
                  $class_proveedor = 'danger';
                }

                if($proveedor->autorizado_juridica_conductor===1){
                  $class_conductor = 'success';
                }else{
                  $class_conductor = 'danger';
                }

                if($proveedor->autorizado_juridica_vehiculo===1){
                  $class_vehiculo = 'success';
                }else{
                  $class_vehiculo = 'danger';
                }

                /*controles nuevos CONDUCTORES*/
                $icons = '';
                //$sw = 0;

                /*if($sw==0){ //SI NO HAY NINGÚN ÍTEM PENDIENTE
                  if($sw2==0){ // SI ES 0, QUIERE DECIR QUE NO HAY NINGÚN ITEM NO APROBADO (HABILITAR SOLICITUD DE DATOS DE PAGO)
                    CORRECCION : disabled
                    SOLICITUD DE DATOS CONTABLES : enabled
                  }else{ //SI ES 1, QUIERE DECIR QUE HAY POR LO MENOS 1 ITEM NO APROBADO Y SE DEBE ENVIAR AL PROV
                    CORRECCION : enabled
                    SOLICITUD DE DATOS CONTABLES : disabled
                  }
                }else{ //SI HAY POR LO MENOS UN ÍTEM PENDIENTE (NO SE DEBE DEJAR HACER NADA)
                  CORRECCION : disabled
                  SOLICITUD DE DATOS CONTABLES : disabled
                }*/

                if($proveedor->autorizado_cc===1){ //ESTADO CÉDULA
                  $icons = '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_cc===2){
                  $icons = '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $icons = '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_licencia===1){ //ESTADO LICENCIA
                  $icons .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_licencia===2){
                  $icons .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $icons .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_seguridad_social===1){ //ESTADO SEGURIDAD SOCIAL
                  $icons .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_seguridad_social===2){
                  $icons .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $icons .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                $iconsv = '';
                /*controles nuevos VEHÍCULOS*/
                if($proveedor->autorizado_tecnomecanica===1){ //ESTADO SEGURIDAD SOCIAL
                  $iconsv .= '<i class="fa fa-check" aria-hidden="true" style=" font-size: 12px;color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_tecnomecanica===2){
                  $iconsv .= '<i class="fa fa-times" aria-hidden="true" style=" font-size: 12px;color: red"></i>';
                  $sw2 = 1;
                }else{
                  $iconsv .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_soat===1){ //ESTADO SEGURIDAD SOCIAL
                  $iconsv .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_soat===2){
                  $iconsv .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $iconsv .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_tp===1){ //ESTADO TARJETA DE PROPIEDAD
                  $iconsv .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_tp===2){
                  $iconsv .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $iconsv .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_to===1){ //ESTADO TARJETA DE OPERACIÓN
                  $iconsv .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_to===2){
                  $iconsv .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $iconsv .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                ?>

                <!--<button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_proveedor}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-{{$class_proveedor}} btn-list-table ver_detalles">DETALLES <i class="fa fa-eye" aria-hidden="true"></i></button>

                <a class="btn btn-{{$class_conductor}} btn-list-table" target="_blank" href="conductores/{{strtolower($proveedor->id)}}">CONDUCTORES <?php echo $icons ?></a>

                <a class="btn btn-{{$class_vehiculo}} btn-list-table" target="_blank" href="vehiculos/{{strtolower($proveedor->id)}}">VEHICULOS <?php echo $iconsv ?></a>-->

                <?php 

                //$color_contabilidad = 'red';
                $fondo_th = 'red';
                $iconTH = 'times';

                if($proveedor->autorizacion_th===1){
                  $fondo_th = 'green';
                  $iconTH = 'check';
                }

                $fondo_juridica = 'red';
                $iconJuridica = 'times';

                if($proveedor->autorizacion_juridica===1){
                  $fondo_juridica = 'green';
                  $iconJuridica = 'check';
                }

                $fondo_contabilidad = 'red';
                $iconContabilidad = 'times';

                if($proveedor->autorizacion_contabilidad===1){
                  $fondo_contabilidad = 'green';
                  $iconContabilidad = 'check';
                }


                ?>

                <span style="padding: 4px; background: <?php echo $fondo_th ?>; color: white;">TH <i class="fa fa-{{$iconTH}}" aria-hidden="true"></i></span>

                <span style="padding: 4px; background: <?php echo $fondo_juridica ?>; color: white">JURÍDICA <i class="fa fa-{{$iconJuridica}}" aria-hidden="true"></i></span>

                <span style="padding: 4px; background: <?php echo $fondo_contabilidad ?>; color: white">CONTABILIDAD <i class="fa fa-{{$iconContabilidad}}" aria-hidden="true"></i></span>

                <i style="color: orange; float: right; font-size: 23px;" class="fa fa-info-circle info_dos" aria-hidden="true"></i>


              </td>
              <td>
                <!-- DOING -->
                <!-- ESTADO DE SOLICITUD O RESPUESTA DE DATOS BANCARIOS DEL PROVEEDOR -->
                @if( ($proveedor->estado_global===1 and $proveedor->autorizacion_contabilidad===null) or ($proveedor->estado_global===1 and $proveedor->autorizacion_contabilidad===1) or ($proveedor->estado_global===2 and $proveedor->autorizacion_contabilidad===null) )

                  <!--<a title="ENVIAR DOCUMENTOS INCORRECTOS DE VUELTA AL PROVEEDOR" id="send_proveedor" data-id="{{$proveedor->id}}" class="btn btn-warning send_proveedor disabled"><i class="fa fa-reply-all" aria-hidden="true"></i></a>-->

                  @if($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                    <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id}}" class="btn btn-success send_transportes disabled"><i class="fa fa-check" aria-hidden="true"></i></a>
                  @endif

                @elseif($sw===0)
                  @if($sw2===0)
                    <a title="ENVIAR DOCUMENTOS INCORRECTOS DE VUELTA AL PROVEEDOR" id="send_proveedor" data-id="{{$proveedor->id}}" class="btn btn-warning send_proveedor disabled hidden"><i class="fa fa-reply-all" aria-hidden="true"></i></a>
                    @if($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                      <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id}}" class="btn btn-success disabled send_transportes hidden"><i class="fa fa-check" aria-hidden="true"></i></a>
                    @else
                      <a title="Solicitar Datos Financieros" id="send_financy" data-id="{{$proveedor->id}}" class="btn btn-primary disabled send_financy"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                    @endif
                  @else
                    <a title="ENVIAR DOCUMENTOS INCORRECTOS DE VUELTA AL PROVEEDOR" id="send_proveedor" data-id="{{$proveedor->id}}" class="btn btn-warning send_proveedor hidden"><i class="fa fa-reply-all" aria-hidden="true"></i></a>
                    @if($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                      <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id}}" class="btn btn-success send_transportes disabled hidden"><i class="fa fa-check" aria-hidden="true"></i></a>
                    @else
                      <a title="Solicitar Datos Financieros" id="send_financy" data-id="{{$proveedor->id}}" class="btn btn-primary send_financy disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                    @endif
                  @endif
                @else
                  <a title="ENVIAR DOCUMENTOS INCORRECTOS DE VUELTA AL PROVEEDOR" id="send_proveedor" data-id="{{$proveedor->id}}" class="btn btn-warning send_proveedor disabled hidden"><i class="fa fa-reply-all" aria-hidden="true"></i></a>
                  @if($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                    <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id}}" class="btn btn-success send_transportes disabled hidden"><i class="fa fa-check" aria-hidden="true"></i></a>
                  @else
                    <a title="Solicitar Datos Financieros" id="send_financy" data-id="{{$proveedor->id}}" class="btn btn-primary send_financy disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                  @endif
                @endif
                

                <!--@if($proveedor->estado_global===3 and $proveedor->autorizacion_contabilidad===2)
                  <a title="Incorporar proveedor" id="send_transportes" data-id="{{$proveedor->id}}" class="btn btn-success send_transportes @if($proveedor->estado_global===1){{'disabled'}}@endif"><i class="fa fa-check" aria-hidden="true"></i></a>
                @else
                  <a title="Solicitar Datos Financieros" id="send_financy" data-id="{{$proveedor->id}}" class="btn btn-primary send_financy @if($proveedor->estado_global===1){{'disabled'}}@endif"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                @endif-->
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif
    <a class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<!-- MODAL PDF -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #ED7606">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;" id="name"></h4>
        </div>
        <div class="modal-body">
          <div class="documento">
            <center>
              <iframe id="pdf" style="width: 550px; height: 460px;" src="archivo.pdf"></iframe>
            </center>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              <p id="novedades_modal" style="text-align: left;"></p>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<!-- MODAL DETALLES -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_detalles'>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #ED7606">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;" id="name2">DETALLES DEL PROVEEDOR</h4>
        </div>
        <div class="modal-body">
          <fieldset style="margin-bottom: 5px;"><legend class="margin_label">Datos Generales</legend>
            <div class="row">
                <div class="col-xs-2">
                  <label class="obligatorio" for="tipo_afiliado2">Tipo Afiliado</label>
                  <select name="tipo_afiliado2" class="form-control input-font" id="tipo_afiliado2">
                    <option>-</option>
                    <option value="1">AFILIADO INTERNO</option>
                    <option value="2">AFILIADO EXTERNO</option>
                  </select>
                </div>
                <div class="col-xs-2">
                  <label class="obligatorio" for="nit">Nit o C.C</label>
                  <input class="form-control input-font" type="text" id="nit">
                </div>
                <div class="col-xs-2">
                  <label class="obligatorio" for="digitoverificacion">Dígito de Verificación</label>
                  <input class="form-control input-font" type="text" id="digitoverificacion">
                </div>
                <div class="col-xs-4">
                  <label class="obligatorio" for="razonsocial">Nombre completo o Razon social</label>
                  <input class="form-control input-font" type="text" id="razonsocial">
                </div>
                <div class="col-xs-2">
                    <label class="obligatorio" for="tipoempresa">Tipo de empresa</label>
                    <select class="form-control input-font" name="tipoempresa" id="tipoempresa">
                        <option>-</option>
                        <option>S.A.S</option>
                        <option>S.R.L.</option>
                        <option>S.A</option>
                        <option>L.T.D.A</option>
                        <option>P.N</option>
                    </select>
                </div>
                <div class="col-xs-3 representante">
                    <label class="obligatorio" for="representante">Representante Legal</label>
                    <input type="text" class="form-control input-font" id="representante">
                </div>
                <div class="col-xs-3 cedula" style="min-height: 0px;">
                    <label class="obligatorio cedula" for="cedula">C.C</label>
                    <input type="text" id="cedula" class="form-control input-font">
                </div>
                <div class="col-xs-3">
                    <label for="direccion" class="obligatorio">Direccion</label>
                    <input class="form-control input-font" id="direccion" type="text">
                </div>
                <div class="col-xs-3">
                  <label for="departamento">Departamento</label>
                  <input type="text" class="form-control input-font" id="departamento">
                </div>
                <div class="col-xs-3">
                  <label for="ciudad">Ciudad</label>
                  <input type="text" class="form-control input-font" id="ciudad">
                </div>
                <div class="col-xs-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control input-font" id="email">
                </div>
                <div class="col-xs-3">
                    <label class="obligatorio" for="celular">Celular</label>
                    <input type="text" class="form-control input-font" id="celular">
                </div>
                <div class="col-xs-3">
                    <label for="telefono">Telefono</label>
                    <input type="text" class="form-control input-font" id="telefono">
                </div>
                <!--<div class="col-xs-3">
                    <label class="obligatorio tipo_servicio_pn hidden" for="tipo_servicio_pn">Tipo de Servicio</label>
                    <select class="form-control input-font hidden" id="tipo_servicio_pn" name="tipo_servicio_pn">
                        <option>-</option>
                        <option>TRANSPORTE TERRESTRE</option>
                        <option>HOTEL</option>
                        <option>OTROS</option>
                    </select>
                </div>-->
                <div class="col-xs-3">
                    <label class="obligatorio" for="localidad">Localidad</label>
                    <select class="form-control input-font" name="localidad" id="localidad">
                        <option>-</option>
                        <option>BARRANQUILLA</option>
                        <option>BOGOTA</option>
                    </select>
                </div>
            </div>
            <hr style="border: 2px solid">
            <legend class="margin_label">Datos Financieros</legend>
            <div class="row">
              <div class="col-xs-3">
                <label for="tipo_cuenta">Tipo de Cuenta</label>
                <select disabled class="form-control input-font" name="tipo_cuenta" id="tipo_cuenta">
                    <option >-</option>
                    <option >AHORROS</option>
                    <option >CORRIENTE</option>
                </select>
              </div>
              <div class="col-xs-3">
                <label for="entidad_bancaria">Entidad Bancaria</label>
                <select disabled class="form-control input-font" name="entidad_bancaria" id="entidad_bancaria">
                  <option >-</option>
                  <option >BANCO DE BOGOTA</option>
                  <option >BANCO BBVA</option>
                  <option >BANCOLOMBIA</option>
                  <option >BANCO DAVIVIENDA</option>
                  <option >BANCO POPULAR</option>
                  <option >SCOTIABANK COLPATRIA S.A</option>
                  <option >BANCOOMEVA</option>
                  <option >BANCO FALABELLA S.A.</option>
                  <option >ITAÚ</option>
                  <option >BANCO CAJA SOCIAL</option>
                  <option >BANCO DE OCCIDENTE</option>
                  <option >BANCO AV VILLAS</option>
                  <option >BANCO PICHINCHA</option>
                  <option >HELM BANK</option>
                  <option >SUDAMERIS</option>
                  <option >HSBC</option>
                </select>
              </div>
              <div class="col-xs-3">
                <label for="numero_cuenta">Número de cuenta</label>
                <input disabled type="text" class="form-control input-font" id="numero_cuenta">
              </div>
            </div>
        </fieldset>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-8">
              <p id="novedades_modal" style="text-align: left;"></p>
            </div>
            <div class="col-md-4">
              <button class="btn btn-primary aprobar_proveedor" data-value="">APROBAR PROVEEDOR <i class="fa fa-check" aria-hidden="true"></i></button>
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="errores-modal bg-danger text-danger hidden model" style="top: 10%;">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    $('.info').click(function() {

      $.confirm({
        title: 'Atención',
        content: 'Actualmemte el proveedor está en proceso de verificación por las diferentes áreas <b>(JURÍDICA, TH Y CONTABILIDAD)</b> <br><br> En caso de aprobar o no, se emitirán <b>NOTIFICACIONES</b> a todas las áreas implicadas informando el proceso a seguir. <br><br> <b>NOTA:</b> En la columna de al lado encontramos el estado de las aprobaciones por área, siendo <b style="color: green">VERDE <i class="fa fa-check" aria-hidden="true"></i></b> estado aprobado y <b style="color: red">ROJO <i class="fa fa-times" aria-hidden="true"></i></b> no aprobado.',
        buttons: {
            confirm: {
                text: 'CERRAR',
                btnClass: 'btn-danger',
                keys: ['enter', 'shift'],
                action: function(){

                }

            }
        }
      });

    });

    $('.info_dos').click(function() {

      $.confirm({
        title: 'ALERTA',
        content: 'Cuando las áreas hayan aprobado o no aprobado, en la columna siguiente se habilitará la opción dependiendo de lo realizado. <br> Por ejemplo, si hay algún documento no aprobado de sea cual sea el área, se habilitará la opción para solicitar nuevamente esos docs al proveedor <b style="color: orange">OPCIÓN NARANJA <i class="fa fa-times" aria-hidden="true"></i></b>. Se le notificará por correo al proveedor, dicho correo tendrá un link donde se le solicitará que adjunte dichos docs no aprobados. <br><br>En caso de que todo esté aprobado, se habilitará la opción de enviar el conductor a capacitación <b style="color: blue">OPCIÓN AZUL <i class="fa fa-times" aria-hidden="true"></i></b>.',
        buttons: {
            confirm: {
                text: 'CERRAR',
                btnClass: 'btn-danger',
                keys: ['enter', 'shift'],
                action: function(){

                }

            }
        }
      });

    });

</script>
</body>
</html>
