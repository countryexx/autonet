<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Gestión Financiera de Proveedores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <style type="text/css">
      /* Styling Checkbox Starts */
      .checkbox-label {
        display: block;
        position: relative;
        margin: auto;
        cursor: pointer;
        font-size: 22px;
        line-height: 24px;
        height: 24px;
        width: 24px;
        clear: both;
      }
      .checkbox-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
      }
      .checkbox-label .checkbox-custom {
        position: absolute;
        top: 0px;
        left: 0px;
        height: 24px;
        width: 24px;
        background-color: transparent;
        border-radius: 5px;
        transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        border: 2px solid #FFFFFF;
      }
      .checkbox-label input:checked ~ .checkbox-custom {
        background-color: #FF1700;
        border-radius: 5px;
        -webkit-transform: rotate(0deg) scale(1);
        -ms-transform: rotate(0deg) scale(1);
        transform: rotate(0deg) scale(1);
        opacity:1;
        border: 2px solid #FFFFFF;
      }
      .checkbox-label .checkbox-custom::after {
        position: absolute;
        content: "";
        left: 12px;
        top: 12px;
        height: 0px;
        width: 0px;
        border-radius: 5px;
        border: solid #009BFF;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(0deg) scale(0);
        -ms-transform: rotate(0deg) scale(0);
        transform: rotate(0deg) scale(0);
        opacity:1;
        transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
      }
      .checkbox-label input:checked ~ .checkbox-custom::after {
        -webkit-transform: rotate(45deg) scale(1);
        -ms-transform: rotate(45deg) scale(1);
        transform: rotate(45deg) scale(1);
        opacity:1;
        left: 8px;
        top: 3px;
        width: 6px;
        height: 12px;
        border: solid #009BFF;
        border-width: 0 2px 2px 0;
        background-color: transparent;
        border-radius: 0;
      }
      /* For Ripple Effect */
      .checkbox-label .checkbox-custom::before {
        position: absolute;
        content: "";
        left: 10px;
        top: 10px;
        width: 0px;
        height: 0px;
        border-radius: 5px;
        border: 2px solid #FFFFFF;
        -webkit-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
      }
      .checkbox-label input:checked ~ .checkbox-custom::before {
        left: -3px;
        top: -3px;
        width: 24px;
        height: 24px;
        border-radius: 5px;
        -webkit-transform: scale(3);
        -ms-transform: scale(3);
        transform: scale(3);
        opacity:0;
        z-index: 999;
        transition: all 0.3s ease-out;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
      }
      /* Style for Circular Checkbox */
      .checkbox-label .checkbox-custom.circular {
        border-radius: 50%;
        border: 2px solid #FFFFFF;
      }
      .checkbox-label input:checked ~ .checkbox-custom.circular {
        background-color: #FFFFFF;
        border-radius: 50%;
        border: 2px solid #FFFFFF;
      }
      .checkbox-label input:checked ~ .checkbox-custom.circular::after {
        border: solid #0067FF;
        border-width: 0 2px 2px 0;
      }
      .checkbox-label .checkbox-custom.circular::after {
        border-radius: 50%;
      }
      .checkbox-label .checkbox-custom.circular::before {
        border-radius: 50%;
        border: 2px solid #FFFFFF;
      }
      .checkbox-label input:checked ~ .checkbox-custom.circular::before {
        border-radius: 50%;
      }
    </style>
</head>
<body>
  @include('admin.menu')
  <div class="col-xs-12">
    @include('proveedores.menu_proveedores')
    <h3 class="h_titulo">LISTA DE PROVEEDORES</h3>
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">

            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">

                  <div class="form-group">
                    <select id="proveedor" style="width: 160px;" class="form-control input-font" name="proveedores">
                        <option value="0">PROVEEDORES</option>
                        @foreach($proveedores as $proveedor)
                          <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <select id="estado_proveedor" style="width: 160px;" class="form-control input-font" name="estado_proveedor">
                        <option >PAGO</option>
                        <option >PAGO A PROVEEDOR</option>
                        <option >PAGO A TERCERO</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <select id="banco" style="width: 180px;" class="form-control input-font" name="banco">
                        <option >BANCO</option>
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

                  <div class="form-group">
                    <select id="tipo_cuentab" style="width: 180px;" class="form-control input-font" name="tipo_cuentab">
                        <option >TIPO DE CUENTA</option>
                        <option >AHORROS</option>
                        <option >CORRIENTE</option>
                    </select>
                  </div>

                  <button data-option="1" id="buscar" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>

                </div>
            </div>
        </form>

    @if(isset($proveedores))
      <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
            <tr style="background: #F4912E; color: white">
                <th>Nit</th>
                <th>Razon Social</th>
                <th>Entidad Bancaria</th>
                <th>Número de Cuenta</th>
                <th>Tipo de Cuenta</th>
                <th></th>
            </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Nit</th>
            <th>Razon Social</th>
            <th>Entidad Bancaria</th>
            <th>Número de Cuenta</th>
            <th>Tipo de Cuenta</th>
            <th></th>
          </tr>
          </tfoot>
          <tbody>
          @foreach($proveedores as $proveedor)
            <tr class="@if(intval($proveedor->estado_tercero)===1){{'success'}}@elseif(intval($proveedor->inactivo)===1){{'warning'}}@endif">
              <td><h6>{{$proveedor->nit.'-'.$proveedor->codigoverificacion}}</h6></td>
              <td><h6>{{$proveedor->razonsocial.' '.$proveedor->tipoempresa}} @if($proveedor->estado_tercero===1) <br><br> {{$proveedor->razonsocial_t}} @else @endif</h6></td>
              <td><h6 class="razonsocial">@if($proveedor->estado_tercero===1) <br><br> {{$proveedor->entidad_bancaria_t}} @else {{$proveedor->entidad_bancaria}} @endif </h6></td>
              <td>
                <span><h6>@if($proveedor->estado_tercero===1) <br><br> {{$proveedor->numero_cuenta_t}} @else {{$proveedor->numero_cuenta}} @endif</h6></span>
              </td>
              <td><span><h6>@if($proveedor->estado_tercero===1) <br> {{$proveedor->tipo_cuenta_t}} @else {{$proveedor->tipo_cuenta}}@endif</h6></span></td>
              <td id="{{$proveedor->id}}">
                <!-- ADMINISTRADOR, GERENCIA, JEFE DE JURIDICA, COORD DE JURIDICA -->
                @if(Sentry::getUser()->id_rol==2 or Sentry::getUser()->id_rol==1 or Sentry::getUser()->id_rol==25 or Sentry::getUser()->id_rol==46 or Sentry::getUser()->id_rol==52)
                  <button data-value="{{$proveedor->id}}" class="btn btn-primary editar">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                    <!-- SI TIENE ACTIVO EL PAGO A TERCERO -->
                  @if($proveedor->estado_tercero===1)
                    <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_bancaria_t}}" data-razon="{{$proveedor->razonsocial_t}}" class="btn btn-success ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>

                    <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->poder_t}}" data-razon="{{$proveedor->razonsocial}}" data-tercero="{{$proveedor->razonsocial_t}}" class="btn btn-warning ver_pdf_poder">PODER <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                  @else
                    @if($proveedor->certificacion_bancaria!=null)
                      <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_bancaria}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-success ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                    @else
                      <button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->certificacion_bancaria}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                    @endif

                    <button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->poder_t}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">PODER<i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>

                  @endif

                  @if($proveedor->historial_cambios!=null)
                    <a href="{{url('proveedores/historial/'.$proveedor->id)}}" target="_blank" class="btn btn-danger">HISTORIAL</a>
                  @else
                    <a href="{{url('proveedores/historial/'.$proveedor->id)}}" target="_blank" class="btn btn-danger disabled">HISTORIAL</a>
                  @endif

                @else
                  <button data-value="{{$proveedor->id}}" disabled class="btn btn-primary editar">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                  <!-- SI TIENE ACTIVO EL PAGO A TERCERO -->
                  @if($proveedor->estado_tercero===1)
                    <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_bancaria_t}}" data-razon="{{$proveedor->razonsocial_t}}" class="btn btn-success ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>

                    <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->poder_t}}" data-razon="{{$proveedor->razonsocial}}" data-tercero="{{$proveedor->razonsocial_t}}" class="btn btn-warning ver_pdf_poder">PODER <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                  @else
                    @if($proveedor->certificacion_bancaria!=null)
                      <button data-value="{{$proveedor->id}}" data-url="{{$proveedor->certificacion_bancaria}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-success ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                    @else
                      <button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->certificacion_bancaria}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                    @endif

                    <button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->poder_t}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">PODER<i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>

                  @endif

                  @if($proveedor->historial_cambios!=null)
                    <a href="{{url('proveedores/historial/'.$proveedor->id)}}" target="_blank" class="btn btn-danger">HISTORIAL</a>
                  @else
                    <a href="{{url('proveedores/historial/'.$proveedor->id)}}" target="_blank" class="btn btn-danger disabled">HISTORIAL</a>
                  @endif
                @endif
              </td>
            </tr>
          @endforeach
          </tbody>
      </table>
    @endif
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

    <!-- MODAL PDF -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf_poder'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #ED7606">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="namep"></h4>
            </div>
            <div class="modal-body">
              <div class="documento">
                <center>
                  <iframe id="pdfp" style="width: 550px; height: 460px;" src="archivo.pdf"></iframe>
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


  <!-- MODAL DE EDICIÓN DE CUENTAS A PROVEEDORES -->
  <div class="modal" tabindex="-1" role="dialog" id='modal_editar'>
    <div class="modal-lg" role="document">
      <div class="modal-content" style="margin-left: 240px; width: 100%; margin-top: 20px">
        <div class="modal-header">
          <h3 class="modal-title" style="text-align: center;">ACTUALIZACIÓN DE INFORMACIÓN FINANCIERA DE PROVEEDOR</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formulario">
          <div class="row principal">
            <div class="col-lg-12" style="margin-bottom: 15px">
              <h4>INFORMACIÓN BANCARIA DEL PROVEEDOR</h4>
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">
                <label class="obligatorio" for="razonsocial" >Razón Social</label>
                <input disabled class="form-control input-font" type="text" id="razonsocial" placeholder="RAZÓN SOCIAL">
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12">
                <label class="obligatorio" for="nit" >Nit</label>
                <input disabled class="form-control input-font" type="text" id="nit" placeholder="NIT">
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 col-md-12">
              <label class="obligatorio" for="certificacion">Certificación Bancaria</label><br>
              <input id="certificacion_proveedor" accept="application/pdf" class="certificacion_proveedor" type="file" value="Subir" name="certificacion_proveedor" >

              <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_certificacion_ hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver Cerficicación <i class="fa fa-eye" aria-hidden="true"></i></a>
              <a type="button" name="button" data-toggle="modal" class="btn btn-warning boton_editar_certificacion_" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Edit <i class="fa fa-eye" aria-hidden="true"></i></a>

            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">

            </div>
          </div>
          <div class="row principal">
            <div class="col-lg-4 col-sm-12 col-xs-12">
                <label class="obligatorio" for="tipo_cuenta" >Tipo de Cuenta</label>
                <select class="form-control input-font" name="tipo_cuenta" id="tipo_cuenta">
                    <option >-</option>
                    <option >AHORROS</option>
                    <option >CORRIENTE</option>
                </select>
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12">
                <label class="obligatorio" for="entidad_bancaria" >Entidad Bancaria</label>
                <select class="form-control input-font" name="entidad_bancaria" id="entidad_bancaria">
                    <option>-</option>
                    <option>BANCO DE BOGOTA</option>
                    <option>BANCO BBVA</option>
                    <option>BANCOLOMBIA</option>
                    <option>BANCO DAVIVIENDA</option>
                    <option >BANCO POPULAR</option>
                    <option>SCOTIABANK COLPATRIA S.A</option>
                    <option>BANCOOMEVA</option>
                    <option>BANCO FALABELLA S.A.</option>
                    <option>ITAÚ</option>
                    <option>BANCO CAJA SOCIAL</option>
                    <option>BANCO DE OCCIDENTE</option>
                    <option>BANCO AV VILLAS</option>
                    <option>BANCO PICHINCHA</option>
                    <option>HELM BANK</option>
                    <option>SUDAMERIS</option>
                    <option>HSBC</option>
                </select>
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12">
                <label class="obligatorio" for="numero_cuenta" >Número de Cuenta</label>
                <input class="form-control input-font" type="number" id="numero_cuenta" placeholder="NÚMERO DE CUENTA">
            </div>
          </div>

          <div class="row hidden tercero">
            <div class="col-lg-12" style="margin-bottom: 15px">
              <h4>INFORMACIÓN BANCARIA PAGO A TERCERO</h4>
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 col-md-12">
              <label class="obligatorio" for="razonsocialt" >Razón Social T</label>
              <input class="form-control input-font" type="text" id="razonsocialt" placeholder="RAZÓN SOCIAL TERCERO">
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 col-md-12">
              <label class="obligatorio" for="numero_documentot" >Número de Documento T</label>
              <input class="form-control input-font" type="number" id="numero_documentot" placeholder="NÚMERO DE DOCUMENTO">
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12 col-md-12">
              <label class="obligatorio" for="certificacion_tercero">Certificación Bancaria T</label>
              <input id="certificacion_tercero" accept="application/pdf" class="certificacion_tercero" type="file" value="Subir" name="certificacion_tercero" class="perfil">

              <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_certificacion_t hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver Cerf <i class="fa fa-external-link" aria-hidden="true"></i></a>

              <a type="button" name="button" data-toggle="modal" class="btn btn-warning boton_editar_certificacion_t" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Edit <i class="fa fa-external-link" aria-hidden="true"></i></a>

            </div>
          </div>
          <div class="row hidden tercero">
            <div class="col-lg-3 col-sm-12 col-xs-12">
                <label class="obligatorio" for="tipo_cuentat" >Tipo de Cuenta T</label>
                <select class="form-control input-font" name="tipo_cuentat" id="tipo_cuentat">
                    <option >-</option>
                    <option >AHORROS</option>
                    <option >CORRIENTE</option>
                </select>
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12">
                <label class="obligatorio" for="entidad_bancariat" >Entidad Bancaria T</label>
                <select class="form-control input-font" name="entidad_bancariat" id="entidad_bancariat">
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
            <div class="col-lg-3 col-sm-12 col-xs-12">
              <label class="obligatorio" for="numero_cuentat" >Número de Cuenta T</label>
              <input class="form-control input-font" type="number" id="numero_cuentat" placeholder="NÚMERO DE CUENTA TERCERO">
            </div>
            <div class="col-lg-3 col-sm-12 col-xs-12">

              <label class="obligatorio" for="certificacion">Poder para pago a Tercero</label>
              <input id="poder_tercero" accept="application/pdf" class="poder_tercero" type="file" value="Subir" name="poder_tercero" class="perfil">

              <a type="button" name="button" data-toggle="modal" class="btn btn-info boton_ver_poder hidden" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Ver PODER  <i class="fa fa-external-link" aria-hidden="true"></i></a>
              <a type="button" name="button" data-toggle="modal" class="btn btn-warning boton_editar_poder" data-empleado-id="" data-nombre="" target="_blank" title="Vista Previa">Edit<i class="fa fa-external-link" aria-hidden="true"></i></a>

            </div>
          </div>
         </form>
        </div>
        <div class="modal-footer">
          <div style="float: left; background: orange; padding: 5px" class="unable">
            <span class="textoa" style="font-family: monospace; font-size: 18px; color: solid">HABILITAR TERCERO</span> <input type="checkbox" class="control_pago">
          </div>
          <button type="button" class="btn btn-primary guardar_edicion">ACTUALIZAR DATOS</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN EDICIÓN -->

  @include('scripts.scripts')

  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('jquery/z.js')}}"></script>

  <script type="text/javascript">
    function goBack(){
      window.history.back();
    }
    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    $('.boton_editar_poder').click(function() {
      $(this).addClass('hidden');
      $('.poder_tercero').attr('sw',0)
      $('.boton_ver_poder').addClass('hidden')
      $('.poder_tercero').removeClass('hidden');
    });

    $('.boton_editar_certificacion_t').click(function() {
      $(this).addClass('hidden');
      $('.certificacion_tercero').attr('sw',0)
      $('.boton_ver_certificacion_t').addClass('hidden')
      $('.certificacion_tercero').removeClass('hidden');
    });

    $('.boton_editar_certificacion_').click(function() {
      $(this).addClass('hidden');
      $('.certificacion_proveedor').attr('sw',0)
      $('.boton_ver_certificacion_').addClass('hidden')
      $('.certificacion_proveedor').removeClass('hidden');
    });

  </script>

</body>
</html>
