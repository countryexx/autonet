<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Pagos Escolar</title>
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
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}


      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">GESTIÓN DE PAGOS: SERVICIO ESCOLAR</h3>
        <div class="form-inline">
          <form id="form_buscar">

            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">

                  <div class="form-group">
                  	<select data-option="1" name="option_mes" style="width: 130px;" class="form-control input-font" id="option_mes">
                        <option>MES</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
	                </div>
                  <div class="form-group">
                  	<select data-option="1" name="option_ano" style="width: 130px;" class="form-control input-font" id="option_ano">
                        <option>AÑO</option>
                        <option>2022</option>
                        <option>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                        <option>2026</option>
                    </select>
	                </div>

                  <button data-option="1" id="filtrar" class="btn btn-default btn-icon">Filtrar<i class="fa fa-filter icon-btn"></i></button>

                  <div class="form-group">
                    <?php
                    $fecha = explode('-', date('Y-m-d'));
                		$mes = $fecha[1];
                    ?>
                    <!--<a style="float: right;" id="wompi" class="@if($pagos!=null){{'btn btn-primary btn-icon disabled'}}@else{{'btn btn-success btn-icon'}}@endif">@if($pagos!=null){{'Links Generados'}}@else{{'Crear Links de Pago Para el Mes Actual'}}@endif<i class="@if($pagos!=null){{'fa fa-check icon-btn'}}@else{{'fa fa-money icon-btn'}}@endif" aria-hidden="true"></i></a>-->
                    <a style="float: right;" id="wompi" class="btn btn-primary btn-icon">Generar Links de Pago<i class="@if($pagos!=null){{'fa fa-money icon-btn'}}@else{{'fa fa-money icon-btn'}}@endif" aria-hidden="true"></i></a>
	                </div>

                </div>
            </div>
            </form>
        </div>

        @if(isset($pagos))
          <table id="examples" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>#</th>
                  <th>Contrato</th>
                  <th>Nombre Estudiante</th>
                  <th>Mes</th>
                  <th>Nombre Padre</th>
                  <th>Tipo de Ruta</th>
                  <th>Valor Ordinario</th>
                  <th>Valor con Recargo</th>
                  <th>Estado</th>
                  <th>Acciones</th>

              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Contrato</th>
                    <th>Nombre Estudiante</th>
                    <th>Mes</th>
                  	<th>Nombre Padre</th>
                    <th>Tipo de Ruta</th>
                    <th>Valor Ordinario</th>
                    <th>Valor con Recargo</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>
            </tfoot>
            <tbody>
              <?php
              $fecha = explode('-', date('Y-m-d'));
              $dia = $fecha[2];
              ?>
                @foreach($pagos as $pago)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$pago->id}}" class="@if($pago->estado_pago===1){{'success'}}@elseif(intval($pago->mora)===1){{'danger'}}@endif fila_foto">
                        <td>{{$o++}}</td>
                        <td>{{$pago->contrato}}</td>
                        <td>{{$pago->nombre_estudiante}}</td>
                        <td>{{$pago->mes}}</td>
                        <td>{{$pago->nombre_padre}}</td>
                        <td>{{$pago->tipo_ruta}}</td>
                        <td>$ {{number_format($pago->valor_ordinario)}}</td>
                        <td>$ {{number_format($pago->valor_mora)}}</td>
                        <td><!-- ESTADO DEL PAGO Y MÉTODO DE PAGO -->
                          @if($pago->estado_pago!=0)
                            <div class="estado_servicio_app" style="background: #015BC7; color: white; margin: 2px 0px; font-size: 12px; padding: 5px 5px; width: 100%; border-radius: 2px;">PAGO <i title="{{$pago->id_transaccion}}" class="fa fa-check" aria-hidden="true"></i>@if($pago->metodo_pago==='CONSIGNACIÓN')<a target="_blank" style="color: white" href="{{url('biblioteca_imagenes/escolar/soporte_pagos/'.$pago->soporte_pdf)}}"> {{$pago->metodo_pago}}</a>@else {{$pago->metodo_pago}} @endif
                            </div>
                          @endif
                        </td>
                        <td>

                          @if($pago->estado_pago!=1)
                            <!--<button data-id="{{$pago->id}}" data-valor="{{$pago->id}}" data-nombre="{{$pago->nombre_estudiante}}" class="btn btn-danger reenviar_link">Reenviar Link SMS <i class="fa fa-share" aria-hidden="true"></i></button>-->
                            @if($pago->mora!=1)
                              <button @if($dia<'06'){{'disabled'}}@endif data-id="{{$pago->id}}" data-valor="{{$pago->valor_ordinario}}" data-nombre="{{$pago->nombre_estudiante}}" class="btn btn-success link_mora">Recargo <i class="fa fa-share-square-o" aria-hidden="true"></i></button>
                            @else
                              <button disabled data-id="{{$pago->id}}" data-valor="{{$pago->valor_ordinario}}" data-nombre="{{$pago->nombre_estudiante}}" class="btn btn-success">Recargo <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
                            @endif
                            <button data-id="{{$pago->id}}" data-id="{{$pago->id}}" class="btn btn-warning adjuntar">Adjuntar <i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                          @else
                            <!-- BOTÓN FACTURAR -->
                            @if($pago->facturado===1)
                              <button disabled class="btn btn-success facturar">Facturado <i class="fa fa-file-o" aria-hidden="true"></i></button>
                            @else
                              @if(Sentry::getUser()->id === 2 || Sentry::getUser()->id === 37)
                                <button data-id="{{$pago->id}}" data-contrato="{{$pago->contrato}}" data-valor="{{$pago->valor_ordinario}}" data-mes="{{$pago->mes}}" data-ano="{{$pago->ano}}" class="btn btn-success facturar">Facturar <i class="fa fa-file-o" aria-hidden="true"></i></button>
                              @else
                                <button disabled data-id="{{$pago->id}}" data-contrato="{{$pago->contrato}}" data-valor="{{$pago->valor_ordinario}}" data-mes="{{$pago->mes}}" data-ano="{{$pago->ano}}" class="btn btn-success facturar">Facturar <i class="fa fa-file-o" aria-hidden="true"></i></button>
                              @endif
                            @endif

                          @endif
<!-- LINK DE WOMPI
                          <a style="float: right;" href="@if($pago->mora!=1){{$pago->link}}@else{{$pago->link_mora}}@endif" target="_blank" id="enlace" class="@if($pago->mora===1){{'btn btn-danger btn-icon'}}@else{{'btn btn-warning btn-icon'}}@endif">@if($pago->mora!=1){{'Link 1'}}@else{{'Link 2'}}@endif<i class="@if($pago->mora!=1){{'fa fa-check icon-btn'}}@else{{'fa fa-exclamation-triangle icon-btn'}}@endif" aria-hidden="true"></i></a>
-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_adjunto'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #0FAEF3">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name">SOPORTE DE PAGO</h4>
            </div>
            <div class="modal-body">
              <form class="formulario">
                <div class="row">
                  <div class="col-xs-12">
                    <label for="pdf_soporte">Adjuntar Soporte de Pago:</label>
                    <input id="pdf_soporte" accept="application/pdf,image/x-png,image/gif,image/jpeg" class="pdf_soporte" type="file" value="Subir" name="pdf_soporte">
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success guardar_pdf">Guardar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/escolar.js')}}"></script>

    <script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>

  </body>
</html>
