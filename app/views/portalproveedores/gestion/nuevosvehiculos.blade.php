<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Nuevos Vehículos</title>
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
    <h1 class="h_titulo">Listado de Nuevos Vehículos</h1>
    <div class="col-lg-8">
      <div class="row">
          @include('portalproveedores.menu_proveedores')
      </div>
    </div>  


    @if(isset($proveedores))
      <table id="examplenews" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr>
                <th>Nit</th>
                <th>Info del Vehículo</th>
                <th>Placa / Capacidad</th>
                <th>Ciudad</th>
                <th>Nombre del Proveedor</th>
                <th>Acciones</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Nit</th>
            <th>Info del Vehículo</th>
            <th>Placa / Capacidad</th>
            <th>Ciudad</th>
            <th>Nombre del Proveedor</th>
            <th>Acciones</th>
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
            $sw = 1;
          }

          ?>
            <tr data-id="{{$proveedor->id_vehiculo}}">
              <td>{{$proveedor->nit}}-{{$proveedor->digito_verificacion}}</td>
              <td>{{$proveedor->marca}} | {{$proveedor->linea}} | {{$proveedor->color}} | {{$proveedor->modelo}}</td>
              <td>{{$proveedor->placa}} | {{$proveedor->capacidad}}</td>
              <td>{{$proveedor->ciudad}}</td>
              <td>{{$proveedor->razonsocial}} | {{$proveedor->tipo_empresa}}</td>
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

                if($proveedor->autorizado_tp===1){ //ESTADO SEGURIDAD SOCIAL
                  $iconsv .= '<i class="fa fa-check" aria-hidden="true" style="font-size: 12px; color: yellow"></i>';
                  $sw3 = 1;
                }else if($proveedor->autorizado_tp===2){
                  $iconsv .= '<i class="fa fa-times" aria-hidden="true" style="font-size: 12px; color: red"></i>';
                  $sw2 = 1;
                }else{
                  $iconsv .= '<i class="fa fa-clock-o juridica_up" aria-hidden="true" style="font-size: 12px; color: white"></i>';
                  $sw = 1;
                }

                if($proveedor->autorizado_to===1){ //ESTADO SEGURIDAD SOCIAL
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

                <!-- BUTON PROVEEDORES START -->

                <!-- BUTON PROVEEDORES END -->

                <!--<button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_proveedor}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-{{$class_proveedor}} btn-list-table ver_detalles">VER VEHÍCULO <i class="fa fa-eye" aria-hidden="true"></i></button>-->

                <a class="btn btn-success btn-list-table" target="_blank" href="vehiculosdetalles/{{strtolower($proveedor->id_vehiculo)}}">VER VEHICULO <i class="fa fa-eye" aria-hidden="true"></i></a>

                <a class="btn btn-{{$class_conductor}} btn-list-table" target="_blank" href="conductores/{{strtolower($proveedor->id)}}">CONDUCTORES </a>

              </td>
              <td>
                  <a title="ENVIARLO A REVISIÓN" id="send_legal" data-id="{{$proveedor->id_vehiculo}}" class="btn btn-primary send_legal"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                  <!--<a title="ENVIAR DOCUMENTOS INCORRECTOS DE VUELTA AL PROVEEDOR" id="send_proveedor" data-id="{{$proveedor->id}}" class="btn btn-warning send_proveedor @if($sw3!=1){{'disabled'}}@endif"><i class="fa fa-reply-all" aria-hidden="true"></i></a>-->
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

</script>
</body>
</html>
