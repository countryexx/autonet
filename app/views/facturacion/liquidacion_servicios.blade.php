<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <title>Autonet | Autorizacion de Servicios</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
      <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
      <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <style>
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
      <div class="col-lg-9">
          <div class="row">
              @include('facturacion.menu_facturacion')
              <h1 class="h_titulo ">AUTORIZACION DE FACTURAS</h1>
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
                <button data-option="1"  id="buscar_liquidaciones" class="btn btn-default btn-icon input-font">
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
		        @foreach($otros_servicios as $otro_serv)
            <tr @if ($otro_serv->tipo_cliente==2) {{'class="info"'}} @endif>
              <td>{{$otro_serv->consecutivo}}</td>
              <td>{{$otro_serv->fecha_orden}}</td>
              <td>{{$otro_serv->fecha_orden}}</td>
              <td>{{$otro_serv->created_at}}</td>
              <td>{{$otro_serv->razonsocial.' / '.$otro_serv->nombresubcentro}}</td>
              <td>{{$otro_serv->ciudad}}</td>
              <td>$ {{number_format($otro_serv->total_ingresos_propios+$otro_serv->total_costo-$otro_serv->descuento)}}</td>
              <td>$ {{number_format($otro_serv->total_costo)}}</td>
              <td>$ {{number_format($otro_serv->total_utilidad)}}</td>
              <td>
        				<!-- <a href="" class="btn btn-success btn-list-table">VOUCHER</a> -->
        				<a href="{{url('facturacion/verdetalleotros/'.$otro_serv->id)}}" class="btn btn-info btn-list-table">DETALLES</a></br>

                @if(intval($otro_serv->autorizado)===1){{'<small class="text-success bolder">AUTORIZADO</small>'}}@else{{'<small class="text-danger bolder">PENDIENTE POR AUTORIZAR</small>'}}@endif
              </td>
            </tr>
          @endforeach
          @foreach($liquidaciones as $liquidacion)
            <tr @if ($liquidacion->afiliado_externo==1) {{'class="info"'}} @endif>
              <td>{{$liquidacion->consecutivo}}</td>
              <td>{{$liquidacion->fecha_inicial}}</td>
              <td>{{$liquidacion->fecha_final}}</td>
              <td>{{$liquidacion->fecha_registro}}</td>
              <td>{{$liquidacion->razonsocial.' / '.$liquidacion->nombresubcentro}}</td>
              <td>{{$liquidacion->ciudad}}</td>
              <td>$ {{number_format($liquidacion->total_facturado_cliente+$liquidacion->valor_adicional)}}</td>
              <td>$ {{number_format($liquidacion->total_costo)}}</td>
              <td>$ {{number_format($liquidacion->total_utilidad+$liquidacion->valor_adicional)}}</td>
              <td>
                @if(intval($liquidacion->dividida)===1)
                    <a href="detallesautorizaciondividida/{{$liquidacion->id}}" class="btn btn-list-table btn-primary">DETALLES</a><br>
                @else
                      <a href="detallesautorizacion/{{$liquidacion->id}}" class="btn btn-list-table btn-primary">DETALLES</a>
						<a href="exportarof/{{$liquidacion->id}}" class="btn btn-list-table btn-success">EXCEL</a><br>
                @endif

                @if(intval($liquidacion->autorizado)===1){{'<small class="text-success bolder">AUTORIZADO</small>'}}@else{{'<small class="text-danger bolder">PENDIENTE POR AUTORIZAR</small>'}}@endif
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
  @include('otros.firebase_cloud_messaging')
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/facturacion.js')}}"></script>
  <script type="text/javascript">

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);

    }
    window.onunload=function(){
    window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

  </script>
  </body>
</html>
