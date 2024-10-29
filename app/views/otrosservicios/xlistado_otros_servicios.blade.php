<html>
<head>
	<title>Autonet | Listado Otros Servicios</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
		<div class="col-lg-2">
			<div class="row">
				<ol style="margin-bottom: 5px" class="breadcrumb">
					<!--<li><a href="#">Proveedores</a></li>-->
					<li><a href="{{url('otrosservicios')}}"><i class="fa fa-home"></i></a></li>
					<li class="active">Listado</a></li>
				</ol>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<h3 class="h_titulo">LISTADO DE OTROS SERVICIOS</h3>
			</div>
		</div>

    <form class="form-inline" id="form_buscar">
        <div class="col-lg-12" style="margin-bottom: 5px">
            <div class="row">
                <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select id="centrodecosto_search" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                        <option value="0">CENTROS DE COSTO</option>
                        @foreach($centrosdecosto as $centro)
                            <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                    	<select id="subcentrodecosto_search" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                        <option value="0">-</option>
                    	</select>
                		</div>
                </div>
								<div class="form-group">
								  <select name="opcion" class="form-control input-font" id="" placeholder="">
										<option value="0">-</option>
										<option value="1">NUMERO CONSECUTIVO</option>
										<option value="2">NUMERO DE FACTURA</option>
										<option value="3">NUMERO DE NEGOCIO</option>
									</select>
								</div>
								<div class="form-group">
								  <input name="numero" type="text" class="form-control input-font" id="" placeholder="INGRESE NUMERO A CONSULTAR">
								</div>
                <button id="buscar" class="btn btn-default btn-icon">
                    Buscar<i class="fa fa-search icon-btn"></i>
                </button>
            </div>
        </div>
    </form>
   	<table id="example1" class="table table-bordered hover tabla" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th># Consecutivo</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Factura</th>
            <th>Negocio</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Informacion</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>#</th>
            <th># Consecutivo</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Factura</th>
            <th>Negocio</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Informacion</th>
        </tr>
        </tfoot>
        <tbody>
      	@foreach($otros_servicios as $otros)
      		<tr class="@if(intval($otros->anulado)===1) {{'resaltar'}} @endif">
      			<td>{{$i++}}</td>
      			<td>{{$otros->consecutivo}} @if(intval($otros->anulado)===1){{'<br><small class="text-danger">ANULADO</small>'}}@endif</td>
      			<td>{{$otros->fecha}}</td>
      			<td>
								<?php
									$prod = DB::table('otros_servicios')->where('id_servicios_detalles', $otros->id)->get();
									foreach ($prod as $key => $value) {
											echo $value->producto.'<br>';
									}
								?>
      			</td>
      			<td>
							{{$otros->numero_factura}}
      			</td>
						<td>
							{{$otros->negocio}}
      			</td>
      			<td>
							@if($otros->razonsocial===$otros->nombresubcentro)
									{{$otros->razonsocial}}
							@else
									{{$otros->razonsocial.'<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #484848;">'.$otros->nombresubcentro}}
							@endif

            </td>
						<td>
							@if($otros->revision_ingreso===null){{'<small class="text-danger">NO TIENE INGRESO</small>'}}@else{{'<small class="text-success">TIENE INGRESO</small>'}}@endif
							@if($otros->revisado_por===null){{'<br><small class="text-danger bolder">NO REVISADO</small>'}}@else{{'<br><small class="text-success bolder">REVISADO</small>'}}@endif
						</td>
  					<td>
                <a href="" class="btn btn-success btn-list-table">VOUCHER</a>
                <a href="{{url('facturacion/verorden/'.$otros->id_factura)}}" class="btn btn-primary btn-list-table">ORDEN</a>
                <a href="{{url('facturacion/verdetalle/'.$otros->id_factura)}}" class="btn btn-info btn-list-table">DETALLES</a>
            </td>
      		</tr>
      	@endforeach
        </tbody>
    </table>
</div>
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/otrosservicios.js')}}"></script>
</body>
</html>
