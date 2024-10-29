<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Listado de Pqr</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style media="screen">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');

      * { box-sizing: border-box; }

      .label-estado {
        right: 10px;
        font-size: 12px;
        top: 65px;
        padding: 6px 7px 5px;
        z-index: 10;
        color: white;
        border-radius: 4px;

        animation-name: parpadeo;
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 1s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;
      }

      @-moz-keyframes parpadeo{
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      @-webkit-keyframes parpadeo {
        0% { opacity: 1.0; }
        50% { opacity: 0.0; }
         100% { opacity: 1.0; }
      }

      @keyframes parpadeo {
        0% { opacity: 1.0; }
         50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }

      :root {
      --app-bg: #101827;
      --sidebar: rgba(21, 30, 47,1);
      --sidebar-main-color: #fff;
      --table-border: #1a2131;
      --table-header: #1a2131;
      --app-content-main-color: #fff;
      --sidebar-link: #fff;
      --sidebar-active-link: #1d283c;
      --sidebar-hover-link: #1a2539;
      --action-color: #2869ff;
      --action-color-hover: #6291fd;
      --app-content-secondary-color: #1d283c;
      --filter-reset: #2c394f;
      --filter-shadow: rgba(16, 24, 39, 0.8) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
      }

      .light:root {
      --app-bg: #fff;
      --sidebar: #f3f6fd;
      --app-content-secondary-color: #f3f6fd;
      --app-content-main-color: #1f1c2e;
      --sidebar-link: #1f1c2e;
      --sidebar-hover-link: rgba(195, 207, 244, 0.5);
      --sidebar-active-link: rgba(195, 207, 244, 1);
      --sidebar-main-color: #1f1c2e;
      --filter-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
      }

      $font-small: 14px;
      $font-medium: 16px;
      $font-large: 24px;

      body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      }

      body {

      font-family: 'Poppins', sans-serif;

      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      }


      .action-button {
        border-radius: 2px;
        height: 32px;
        width: 65px;
        background-color: white;
        border: 1px solid gray;
        display: flex;
        align-items: center;
        color:  var(--app-content-secondary-color);
        font-size: $font-small;
        margin-left: 8px;
        cursor: pointer;

        span { margin-right: 4px; }

         &:hover {
          border-color: var(--action-color-hover);
        }

        &:focus, &.active {
          outline: none;
          color: var(--action-color);
          border-color: var(--action-color);
        }
      }

      .action-button-t {
        border-radius: 2px;
        height: 32px;
        background-color: white;
        border: 1px solid gray;
        display: flex;
        align-items: center;
        color: black;
        font-size: $font-small;
        margin-left: 8px;
        cursor: pointer;

        span { margin-right: 4px; }

        &:hover {
          border-color: var(--action-color-hover);
        }

        &:focus, &.active {
          outline: none;
          color: var(--action-color);
          border-color: var(--action-color);
        }

      }

      .filter-button-wrapper {
      position: relative;
      }

      @mixin arrowDown($color) {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23#{$color}' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-chevron-down'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      }

      .filter-menu-buttons {
        display: inline;
        align-items: center;
        justify-content: space-between;
      }

      .filter-button {

        /*border-radius: 4px;
        height: 32px;
        background-color: white;
        border: 2px solid var(--app-content-secondary-color);
        display: flex;
        align-items: center;
        color: black;
        font-size: $font-small;
        margin-left: 8px;
        cursor: pointer;*/

      height: 32px;
      border-radius: 2px;
      font-size: 12px;
      padding: 4px 8px;
      cursor: pointer;
      border: none;
      color: #fff;

      &.apply {
        /*background-color: #BEBEBE;*/
        background-color: white;
        border: 3px solid;
        color: black;
      }

      &.reset {
        background-color: var(--filter-reset);
      }
      }

      .products-area-wrapper {
      width: 100%;
      max-height: 100%;
      overflow: auto;
      padding: 0 4px;
      }

      .tableView {
      .products-header {
        display: flex;
        align-items: center;
        border-radius: 4px;
        background-color: gray;
        position: sticky;
        top: 0;
      }

      .products-row {
        display: flex;
        align-items: center;
        border-radius: 4px;

        &:hover {
          box-shadow: var(--filter-shadow);
          background-color: #BEBEBE;
        }

        .cell-more-button {
          display: none;
        }
      }

      .product-cell {
        flex: 1;
        padding: 8px 16px;
        color: var(--app-content-main-color);
        font-size: $font-small;
        display: flex;
        align-items: center;

        img {
          width: 32px;
          height: 32px;
          border-radius: 6px;
          margin-right: 6px;
        }

        @media screen and (max-width: 780px) {&{
          font-size: 12px;
          &.image span { display: none; }
          &.image { flex: 0.2; }
        }}

        @media screen and (max-width: 520px) {&{
          &.category, &.sales {
            display: none;
          }
          &.status-cell { flex: 0.4; }
          &.stock, &.price { flex: 0.2; }
        }}

        @media screen and (max-width: 480px) {&{
          &.stock { display: none; }
          &.price { flex: 0.4; }
        }}
      }

      .sort-button {
        padding: 0;
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: var(--app-content-main-color);
        margin-left: 4px;
        display: flex;
        align-items: center;

        &:hover { color: var(--action-color); }
        svg { width: 12px; }
      }

      .cell-label {
        display: none;
      }
      }

      .status {
      border-radius: 4px;
      display: flex;
      align-items: center;
      padding: 4px 8px;
      font-size: 12px;

      &:before {
        content: '';
        width: 4px;
        height: 4px;
        border-radius: 50%;
        margin-right: 4px;
      }

      .cell-label { opacity: 1.6; }
      }

      div.inline { float:left; }
    </style>

</head>
<body>

@include('admin.menu')

  <?php
    $mess = date('m');
    $ano = date('Y');
    $dia = date('d');

  ?>

    <div class="container-fluid">

      <ol style="margin-bottom: 5px" class="breadcrumb">
        <li><a href="{{url('reportes/listadopqr')}}">Listado Pqr</a></li>
        <li><a href="{{url('reportes/pqr')}}">Crear Pqr</a></li>
      </ol>

    <div class="app-content-header">
      <center>
        <div class="product-cell status-cell">
          <span style="width: 380px" class="status inactive hidden" id="sin_datos" style="font-size: 17px"></span>
        </div>
      </center>

    </div>

    <div class="app-content-actions">

      <div class="app-content-actions-wrapper">
        <div class="filter-button-wrapper">
          <div class="row">
            <div class="col-lg-12">

              <div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Inicial </p></label>
                    <div class='input-group date' id='datetime_fecha'>
                        <input id="fecha_inicial" name="fecha_pago" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon" style="height: 15px">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
              </div>

              <div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> F. Final </p></label>
                    <div class='input-group date' id='datetime_fecha2'>
                        <input id="fecha_final" name="fecha_pago" style="width: 80px; height: 30px" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon" style="height: 15px">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
              </div>

              <div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Cliente </p></label>
                    <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="cliente">
                      <option value="0">Seleccionar Cliente</option>
                      @foreach($centrosdecosto as $centro)
                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                      @endforeach
                    </select>
                  </div>
              </div>

              <div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4pxmargin-right: 5px; border-right: 1px solid gray; padding: 12px 2px -3px 0; line-height: 8px; margin-left: 4px; margin-top: 3px"><p style="margin-right: 5px; margin-top: 12px"> Estado </p></label>
                    <select style="float: right; width: 100%; margin-right: 6px; height: 70%; margin-left: 6px" id="estado">
                      <option value="0">Seleccionar</option>
                      <option value="3">Enviada</option>
                      <option value="1">Leída</option>
                      <option value="2">Cerrada</option>
                    </select>
                  </div>
              </div>

              <div class="inline">
                <div class="action-button-t">
                    <label style="color: var(--app-content-secondary-color); margin-top: 4px; border-right: 1px solid gray; line-height: 11px; margin-left: 5px"><p style="margin-right: 5px; margin-top: 10px"> Novedad </p></label>
                    <select style="float: right; width: 100%; margin-right: 3px; height: 70%; margin-left: 5px" id="novedad">
                      <option value="0">Todas</option>
                      <option>LLEGADA TARDE</option>
                      <option>RECOGIDA TARDE</option>
                      <option>NO RECOGIDA</option>
                      <option>PRESUNTO ACOSO</option>
                      <option>CALIDAD DE SERVICIO</option>
                      <option>SIN AUTORIZACION</option>
                      <option>MANEJO PELIGROSO</option>
                      <option>USO INADECUADO DEL LENGUAJE</option>
                      <option>FALLAS MECANICAS</option>
                      <option>ACCIDENTE</option>
                      <option>INCIDENTE</option>
                      <option>NO TOMA SERVICIO</option>
                      <option>NO APLICA</option>
                    </select>
                  </div>
              </div>
              <div class="inline">
                <button class="action-button apply" style="width: 100%">
                  <span style="margin-left: 6px"> <p style="margin-top: 10px"> Buscar <span style="border-right: 1px solid gray; padding: 5px 4px 6px 0; margin-right: 5px"></span> <i style="margin-left: 6px;" class="fa fa-search" aria-hidden="true"></i></p> </span>
                </button>
              </div>
            </div>

          </div>

        </div>
        <br>
        <button class="action-button list active hidden" title="List View">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </button>
        <button class="action-button grid hidden" title="Grid View">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        </button>
      </div>
    </div>


      <!-- Datatables -->
      <table id="example_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
          <tr>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Consecutivo</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre Cliente</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Tipo de Servicio</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Ciudad</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha Solicitud</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Fecha Creación</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Descripción </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Novedad </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Ver PQR </td>
          </tr>
        </thead>
        <tbody>
          <?php $o = 1; ?>
          @foreach($pqr as $pq)
            <tr>
              <th style="font-weight: normal; color: black">
                <center>
                    {{$o}}
                </center>
              </th>
              <th style="font-weight: normal; color: black">
                <center>
                    00{{$pq->id}}
                </center>
              </th>
              <th style="font-weight: normal; color: black"> <center>@if($pq->razonsocial=='SGS COLOMBIA HOLDING BARRANQUILLA' or $pq->razonsocial=='SGS COLOMBIA HOLDING BOGOTA')
                      SGS COLOMBIA HOLDING
                    @else
                      {{$pq->razonsocial}}
                    @endif</center> </th>
              <th style="text-align: center; font-weight: normal; color: black">
                {{$pq->tipo_serv}}
            </th>
              <th style="font-weight: normal; color: black">
                <center>
                {{$pq->ciudad}}
                </center>
              </th>
              <th style="text-align: center; font-weight: normal; color: black">
                {{$pq->fecha_solicitud}}
              </th>

              <th style="text-align: center; font-weight: normal; color: black">
                {{$pq->fecha}}
              </th>

              <th style="text-align: center; font-weight: normal; color: black">
                {{$pq->descripcion}}
              </th>

              <th style="text-align: center; font-weight: normal; color: black">
                {{$pq->novedad}}
              </th>

              <th style="font-weight: normal; color: black">
                <center>
                @if($pq->estado==null)
                    <div>
                      <span style="background: orange; color: black; width: 80px" class="status active">Enviada</span>
                    </div>
                  @elseif($pq->estado==1)
                    <div>
                      <span style="background: gray; color: white; width: 80px" class="status active">Leída</span>
                    </div>
                  @else
                  <div>
                    <span style="background: green; color: white; width: 80px" class="status active">Cerrada</span>
                  </div>
                  @endif
                </center>
              </th>
              <th>
                <a style="margin-right: 10px; float: left" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/Respuesta_pqr_'.$pq->id.'.pdf')}}" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-o" aria-hidden="true"></i></i></a>
                @if($pq->estado==2)
                  <a style="margin-right: 10px" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/cierre/'.$pq->soporte_cierre)}}" class="btn btn-list-table btn-warning">Ver Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>
                @else
                  <a class="btn btn-list-table btn-danger cerrar_pqr @if($pq->estado==2){{'disabled'}}@endif" data-id="{{$pq->id}}">Cerrar pqr <i class="fa fa-check" aria-hidden="true"></i></i></a>
                @endif
              </th>
            </tr>
            <?php $o++; ?>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
          <tr>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Consecutivo</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre Cliente</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Tipo de Servicio</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Ciudad</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha de Solicitud</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Fecha Creación</td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Descripción </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Novedad </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estado </td>
            <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Ver PQR </td>
          </tr>
        </tfoot>
      </table>
      <!-- Datatables -->
    </div>

    <!--Modal QR-->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_qr'>
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Codigo QR</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12" align="center">
                  <img id="imagen_qr">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  <div class="modal fade" tabindex="-1" role="dialog" id='modal_asignar'>
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header" style="background: #E53935">
            <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Adjunta el formato de cierre</b></h4>
          </div>
          <div class="modal-body">
            <center>
              <form id="cierre">

                <center>
                  <input class="soporte_cierre" type="file" value="Subir" name="soporte_cierre" id="soporte_cierre">
                </center>

              </form>
            </center>
          </div>

          <div class="modal-footer">

            <a id="guardar_cierre" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>

          </div>
      </div>
    </div>
  </div>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script><script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajerosv2.js')}}"></script>
<script>
  $(function(){

    $table = $('#tabla_cotizaciones').DataTable({
        "aaSorting": [],
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
            }
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '1%' },
            { 'sWidth': '7%' },
            { 'sWidth': '8%' },
            { 'sWidth': '3%' },
    { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },
            { 'sWidth': '3%' },

        ],
        processing: true,
        "bProcessing": true
    });
    $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });

    $('#example_table').on('click', '.cerrar_pqr', function () {

      var id = $(this).attr('data-id');

      $('#modal_asignar').modal('show');
      $('#guardar_cierre').attr('data-id',id);

    });

    $('#guardar_cierre').click(function(){

      var id = $(this).attr('data-id');
      var file = $('#soporte_cierre').val();

      if(file===''){

        $.confirm({
          title: '¡Atención!',
          content: 'No has adjuntado el documento!',
          buttons: {
              confirm: {
                  text: 'Ok',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                  }

              }
          }

        });

      }else{

        $.confirm({
          title: '¡Atención!',
          content: '¿Estás seguro de cerrar la <b>PQR N° '+id+'</b>? ',
          buttons: {
              confirm: {
                  text: 'Confirmar',
                  btnClass: 'btn-danger',
                  keys: ['enter', 'shift'],
                  action: function(){

                    formData = new FormData($('#cierre')[0]);
                    formData.append('id',id);

                    $.ajax({
                        method: "post",
                        url: "../reportes/cerrarpqr",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {

                            if(data.respuesta===false){

                              $.confirm({
                                title: '¡Atención!',
                                content: 'No se pudo ejecutar la acción. ¡Intentalo de nuevo!',
                                buttons: {
                                    confirm: {
                                        text: 'Ok',
                                        btnClass: 'btn-danger',
                                        keys: ['enter', 'shift'],
                                        action: function(){

                                        }

                                    }
                                }

                              });

                            }else if(data.respuesta===true){

                              $.confirm({
                                title: '¡PQR cerrada!',
                                content: 'Se ha cerrado la pqr seleccionada y el cliente fue notificado vía email.',
                                buttons: {
                                    confirm: {
                                        text: 'Ok',
                                        btnClass: 'btn-primary',
                                        keys: ['enter', 'shift'],
                                        action: function(){
                                          location.reload();
                                        }

                                    }
                                }

                              });

                            }else if(data.respuesta==='relogin'){
                                location.reload();
                            }else{
                                $('.errores-modal ul li').remove();
                                $('.errores-modal').addClass('hidden');
                            }
                        }
                    });

                  }

              },
              cancel: {
                text: 'Cancelar',
              }
          }

        });

      }

    });

    $('.apply').click(function() {

      var novedad = $('#novedad option:selected').val();
      var estado = $('#estado').val();
      var cliente = $('#cliente').val();
      var fecha_inicial = $('#fecha_inicial').val();
      var fecha_final = $('#fecha_final').val();

      $tablecuentas.clear().draw();

      $.ajax({
        url: '../reportes/filtrar',
        method: 'post',
        data: {novedad: novedad, estado: estado, fecha_inicial: fecha_inicial, fecha_final: fecha_final, cliente: cliente}
      }).done(function(data){

        if(data.respuesta=='sesion_caducada'){

          $.confirm({
            title: '¡Atención!',
            content: 'La sesión ha caducado...<br><br>Serás redirigido al login para volver a iniciar sesión!',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-danger',
                    keys: ['enter', 'shift'],
                    action: function(){
                      location.href = "/autonet";
                    }

                }
            }

          });

        }else if(data.respuesta==true){

          var cont = 1;

          for(var i in data.reportes) {

            if(data.reportes[i].razonsocial=='SGS COLOMBIA HOLDING BARRANQUILLA' || data.reportes[i].razonsocial=='SGS COLOMBIA HOLDING BOGOTA'){
              var client = 'SGS COLOMBIA HOLDING';
            }else{
              var client = data.reportes[i].razonsocial;
            }

            /*filtro datatable*/
            var part1 = '';
            var btn_cerrar = '';
            if(data.reportes[i].estado==null){
              part1 +='<div>'+
                '<span style="background: orange; color: black; width: 80px" class="status active">Enviada</span>'+
              '</div>';
              btn_cerrar += '<a style="margin-left: 10px" class="btn btn-list-table btn-danger cerrar_pqr" data-id="'+data.reportes[i].id+'">Cerrar pqr <i class="fa fa-check" aria-hidden="true"></i></i></a>';
            }else if(data.reportes[i].estado==1){
              part1 +='<div>'+
                '<span style="background: gray; color: white; width: 80px" class="status active">Leída</span>'+
              '</div>';
              btn_cerrar += '<a style="margin-left: 10px" class="btn btn-list-table btn-danger cerrar_pqr" data-id="'+data.reportes[i].id+'">Cerrar pqr <i class="fa fa-check" aria-hidden="true"></i></i></a>';
            }else{
              var urlss = 'https://app.aotour.com.co/autonet/biblioteca_imagenes/reportes/pqr/cierre/'+data.reportes[i].soporte_cierre;
              part1 +='<div>'+
                '<span style="background: green; color: white; width: 80px" class="status active">Cerrada</span>'+
              '</div>';
              btn_cerrar += '<a style="margin-left: 10px" target="_blank" href="'+urlss+'" class="btn btn-list-table btn-warning">Ver Cierre <i class="fa fa-file-o" aria-hidden="true"></i></i></a>';
            }

            var estado = '';

            estado +='<center><div class="product-cell image"><span style="color: black">'+
                part1+
              '</span>'+
            '</div></center>';

            $tablecuentas.row.add([
              '<center>'+(parseInt(i)+1)+'</center>',
              '<center>00'+data.reportes[i].id+'</center>',
              '<center>'+client+'</center>',
              '<center>'+data.reportes[i].tipo_serv+'</center>',
              '<center>'+data.reportes[i].ciudad+'</center>',
              '<center>'+data.reportes[i].fecha_solicitud+'</center>',
              '<center>'+data.reportes[i].fecha+'</center>',
              '<center>'+data.reportes[i].descripcion+'</center>',
              '<center>'+data.reportes[i].novedad+'</center>',
              estado,
              '<a target="_blank" href="../biblioteca_imagenes/reportes/pqr/Respuesta_pqr_'+data.reportes[i].id+'.pdf" class="btn btn-list-table btn-primary">PDF <i class="fa fa-file-o" aria-hidden="true"></i></i></a>'+btn_cerrar
            ]).draw();
            cont++;
            /*filtro datatable*/

            var htmlCode = '';

          }

        }else if(data.respuesta==false){

          $('.products-row').html('').removeAttr('style');

          $.confirm({
              title: 'Atención',
              content: 'No se encontraron registros',
              buttons: {
                  confirm: {
                      text: 'Ok',
                      btnClass: 'btn-danger',
                      keys: ['enter', 'shift'],
                      action: function(){



                      }

                  }
              }
          });

        }

      });

    });

    $('#datetime_fecha, #datetime_fecha2, .datetime_fecha').datetimepicker({
      locale: 'es',
      format: 'YYYY-MM-DD',
      icons: {
          time: 'glyphicon glyphicon-time',
          date: 'glyphicon glyphicon-calendar',
          up: 'glyphicon glyphicon-chevron-up',
          down: 'glyphicon glyphicon-chevron-down',
          previous: 'glyphicon glyphicon-chevron-left',
          next: 'glyphicon glyphicon-chevron-right',
          today: 'glyphicon glyphicon-screenshot',
          clear: 'glyphicon glyphicon-trash',
          close: 'glyphicon glyphicon-remove'
      }
  });

  $tablecuentas = $('#example_table').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
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
          }
        },
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' }
        ],
      });

  });


</script>
</body>
</html>
