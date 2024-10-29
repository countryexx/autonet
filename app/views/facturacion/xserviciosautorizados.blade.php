<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <title>Autonet | Servicios Autorizados</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
      <div class="col-lg-6">
        <div class="row">
            @include('facturacion.menu_facturacion')
        </div>
      </div>
      <div class="col-lg-12">
    		<div class="row">
    		  <h3 class="h_titulo">FACTURAS AUTORIZADAS</h3>
    		</div>
    	</div>
      <form class="form-inline" id="form_buscar" method="post">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">
                      <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                          <option value="0">CENTROS DE COSTO</option>
                          @if(isset($centrosdecosto))
  	                        @foreach($centrosdecosto as $centrodecosto)
  	                            <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
  	                        @endforeach
  	                    @endif
                      </select>
                  </div>
                  <div class="form-group">
                      <select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                          <option value="0">-</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <select id="ciudades" style="width: 107px;" name="ciudades" class="form-control input-font">
                          <option>CIUDADES</option>
                          @if(isset($ciudades))
  	                        @foreach($ciudades as $ciudad)
  	                            <option>{{$ciudad->ciudad}}</option>
  	                        @endforeach
  	                    @endif
                      </select>
                  </div>
                  <button data-option="2" id="buscar_liquidaciones" class="btn btn-default btn-icon input-font">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </button>
              </div>
          </div>
      </form>
      <table id="example7" class="table table-hover table-bordered">
          <thead>
            <th>Consecutivo</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Fecha Registro</th>
            <th>Cliente</th>
            <th>Ciudad</th>
            <th>Total Facturado</th>
            <th>Total Costo</th>
            <th>Total Utilidad</th>
            <th>Detalles</th>
          </thead>
          <tbody>
            @foreach($liquidaciones as $liquidacion)
              <tr>
                <td>{{$liquidacion->consecutivo}}</td>
                <td>{{$liquidacion->fecha_inicial}}</td>
                <td>{{$liquidacion->fecha_final}}</td>
                <td>{{$liquidacion->fecha_registro}}</td>
                <td>{{$liquidacion->razonsocial.' / '.$liquidacion->nombresubcentro}}</td>
                <td>{{$liquidacion->ciudad}}</td>
                <td>$ {{number_format($liquidacion->total_facturado_cliente)}}</td>
                <td>$ {{number_format($liquidacion->total_costo)}}</td>
                <td>$ {{number_format($liquidacion->total_utilidad)}}</td>
                <td>
                  @if($liquidacion->dividida===1)
                    @if($permisos->facturacion->autorizar->generar_factura==='on')
                        <a data-id="{{$liquidacion->id_detalle}}" class="btn btn-list-table btn-primary generar_factura_dividida">GENERAR FACTURA</a>
                    @else
                        <a class="btn btn-list-table btn-primary disabled">GENERAR FACTURA</a>
                    @endif
                    <a href="detallesautorizaciondividida/{{$liquidacion->id}}" class="btn btn-list-table btn-info">DETALLES</a>
                    <a href="exportarof/{{$liquidacion->id}}" class="btn btn-list-table btn-success">EXCEL</a><br>
                  @else
                    @if($permisos->facturacion->autorizar->generar_factura==='on')
                        <a data-id="{{$liquidacion->id}}" class="btn btn-list-table btn-primary generar_factura">GENERAR FACTURA</a>
                    @else
                        <a class="btn btn-list-table btn-primary disabled">GENERAR FACTURA</a>
                    @endif
                    <a href="detallesautorizacion/{{$liquidacion->id}}" class="btn btn-list-table btn-info">DETALLES</a>
                    <a href="exportarof/{{$liquidacion->id}}" class="btn btn-list-table btn-success">EXCEL</a><br>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>

          <tfoot>
            <th>Consecutivo</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Fecha Registro</th>
            <th>Cliente</th>
            <th>Ciudad</th>
            <th>Total Facturado</th>
            <th>Total Costo</th>
            <th>Total Utilidad</th>
            <th>Detalles</th>
          </tfoot>
        </table>
    </div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/facturacion.js')}}"></script>
  </body>
</html>
