<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios Empresariales</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="manifest" href="{{url('manifest.json')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style media="screen">

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

      .bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover{
        color: black;
        padding: 9px;
      }

      .proveedor_content{
        z-index: 5;
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .input-group .bootstrap-select.form-control .dropdown-toggle{
        padding: 8px;
      }

      .edit_select{
        position: absolute;
        top: 10px;
        right: 5px;
        padding: 3px 6px 3px 6px;
        border-radius: 50%;
        background: green;
      }

      .edit_select i{
        font-size: 12px;
      }

      .popover-title {
          font-size: 12px;
      }

      .bootstrap-select .dropdown-menu li{
        font-size: 12px;
      }

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="col-sm-12">
            <div class="row">
              @include('facturacion.menu_facturacion')
            </div>
            <h3 class="h_titulo">SERVICIOS CON PAGO DIRECTO: WOMPI</h3>
          </div>
          <table id="tabla_servicios" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Solicitud / Code Wompi</th>
                <th>Cliente</th>
                <th>Recoger</th>
                <th>Destino</th>
                <th>Detalles</th>
                <th>Fecha / Hora</th>
                <th>Subido Por</th>
                <th>Estado</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Solicitud / Code Wompi</th>
                <th>Cliente</th>
                <th>Recoger</th>
                <th>Destino</th>
                <th>Estado</th>
                <th>Fecha / Hora</th>
                <th>Subido Por</th>
                <th>Detalles</th>
                <th>Estado</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($pago_servicios as $servicio)
                <tr class="@if($servicio->id==1){{'success'}}@endif">
                  <td>{{$i}}</td>
                  <td>
                    {{$servicio->id}}
                    @if ($servicio->id!=null)
                      <hr style="margin: 5px 0px; border: 1px dotted #868686;">
                      <a href="#" class="ver_estado_pago" data-pago-servicio-id="{{$servicio->id}}" title="VER ESTADO DEL PAGO">
                        {{$servicio->reference_code}}
                      </a>
                    @endif
                  </td>

                  <td>{{$servicio->razonsocial}}</td>
                  <td>{{$servicio->recoger_en}}</td>
                  <td>{{$servicio->dejar_en}}</td>
                  <!--<td><a class="btn btn-default"><i class="fa fa-map-marker" aria-hidden="true"></i></a></td>-->
                  <td>{{$servicio->detalle_recorrido}}</td>
                  <td>{{$servicio->fecha_servicio.' / '.$servicio->hora_servicio}}</td>
                  <td>
                    {{$servicio->first_name.' '.$servicio->last_name}}
                  </td>
                  <td>
                    @if($servicio->link==1)
                      <div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 100px; border-radius: 2px;">LINK POR GENERAR</div>
                    @elseif($servicio->link!=1)
                      @if($servicio->estado == null)
                        PENDIENTE DE PAGO
                      @elseif($servicio->estado == 'APROVED')
                        PAGADO
                      @endif
                    @endif
                  </td>
                  <td class="text-center">
                    <button data-id="{{$servicio->id}}" style="width: 50%;" type="submit" class="btn btn-primary generar_pago">Generar Link <i class="fa fa-usd" aria-hidden="true"></i></button>
                    <!--include('mobile.button')-->
                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!--include('modales.mobile.programar_servicio')

    include('modales.mobile.revisar_servicio')

    include('modales.mobile.ver_liquidacion')

    include('modales.mobile.ver_estado_pago')-->

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_share'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="h4 text-center mt-3 mb-4 pb-3">Generación de link WOMPI</b></h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="col-lg-10">
                  Desde: Lugar X
                </div>
                <div class="col-lg-10">
                  Hasta: Lugar Y
                </div>
                <div class="col-lg-10">
                  Fecha: Fecha Y
                </div>
                <div class="col-lg-10">
                  Hora: Hora Y
                </div>
                <div class="col-lg-4">
                  <input class="form-control input-font detalle_text" id="valor_servicio" style="text-transform: uppercase;" placeholder="Valor a Cobrar" id="nombre_tarea">
                </div>
                <!--<div class="col-lg-8 col-lg-push-2">

                  <label class="h4 text-center mt-3 mb-4 pb-3">A quién quieres añadir como participante?</label>
                  <select data-option="1" name="proveedores" id="participantes3" class="form-control input-font selectpicker" multiple data-live-search="true" style="width: 50%">
                    <option value="0">1</option>
                  </select>

                </div>-->

              </div>

            </div>

            <div class="modal-footer">

              <a id="generar" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon h4 text-center mt-3 mb-4 pb-3">GENERAR<i class="fa fa-share icon-btn"></i></a>

            </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')

    @include('otros.firebase_cloud_messaging')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    @include('scripts.momentjs')
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/servicios_mobile.js')}}"></script>
    @include('otros.pusher.servicios_cancelados')

    <script type="text/javascript">

      $('#generar').click(function(){

        var id = $(this).attr('data-id');
        var valor = $('#valor_servicio').val();

        $.ajax({
          url: 'generarlink',
          method: 'post',
          data: {id: id, valor: valor}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!');
          }else if(data.respuesta==false){

          }

        });

      });

      $('#tabla_servicios').on('click', '.generar_pago', function(event) {

        var id = $(this).attr('data-id');

        $('#generar').attr('data-id',id);

        $('#guardar_share').attr('data-id',id);
        $('#modal_share').modal('show');

      });

    </script>
  </body>
</html>
