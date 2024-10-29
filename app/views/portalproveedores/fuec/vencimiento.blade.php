<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado de Vencimiento</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
  </head>
  <body >
  @include('admin.menu')
  @include('fuec.breadcrumb')
  <div class="col-lg-12">
      <h3 class="h_titulo">LISTADO DE VENCIMIENTOS</h3>
      <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <!--<div class="row">
                  <div class="form-group">
                    <select id="proveedores" class="form-control input-font">
                      <option value="0">-</option>
                      @foreach ($proveedores as $key => $proveedor)
                      <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                      @endforeach
                    </select>
                  </div>
                  <button id="buscar" class="btn btn-default btn-icon">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </button>
              </div>-->
          </div>
      </form>
      <table id="listado_vencimientos" class="table table-bordered hover" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>Proveedor</th>
            <th>Conductor</th>
            <th>Placa</th>
            <th>F Inicial / F Final</th>
          </tr>
          </thead>
          <tfoot>
          <tr>
            <th>Proveedor</th>
            <th>Conductor</th>
            <th>Placa</th>
            <th>F Inicial / F Final</th>
          </tr>
          </tfoot>
          <tbody>
            @foreach($proveedores as $proveedor)
              <tr>
                <td>{{$proveedor->razonsocial}}</td>
                <td>{{$proveedor->nombre_completo}}</td>
                <td>{{$proveedor->placa}}</td>
                <td>{{$proveedor->fecha_inicial}} | {{$proveedor->fecha_final}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>
  </div>


  @include('scripts.scripts')

  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/fuec.js')}}"></script>

  </body>
  </html>
