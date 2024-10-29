<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Papelera</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
		<link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>

	@include('admin.menu')

	<div class="col-lg-12">
		<h3 class="h_titulo">PAPELERA DE RECICLAJE</h3>
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
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_eliminacion" style="width: 89px;" type='text' class="form-control input-font" placeholder="ELIMINADO">
		                        <span class="input-group-addon">
		                            <span class="fa fa-calendar">
		                            </span>
		                        </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor">
                        <option value="0">PROVEEDORES</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select id="conductor" style="width: 80px;" class="form-control input-font" name="conductores">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="centro_de_costo" style="width: 164px;" class="form-control input-font" name="centrodecosto">
                        <option value="0">CENTROS DE COSTO</option>
                        @foreach($centrosdecosto as $centro)
                            @if($centro->inactivo==1)
                                <option disabled value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                            @else
                                <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select id="subcentros" style="width: 80px;" class="form-control input-font" name="subcentrodecosto">
                        <option value="0">-</option>
                    </select>
                </div>
                <div class="form-group">
                    <select style="width: 107px;" name="ciudades" class="form-control input-font">
                        <option>CIUDADES</option>
                        @foreach($ciudades as $ciudad)
                            <option>{{$ciudad->ciudad}}</option>
                        @endforeach
                    </select>
                </div>                
                <button id="buscar_papelera" class="btn btn-default btn-icon">
                    Buscar<i class="fa fa-search icon-btn"></i>
                </button>
            </div>
        </div>
    </form>

		@if(isset($papelera))
		<table id="example2" class="table table-hover table-bordered tabla">
		<thead>
			<tr>
				<th>Codigo</th>
				<th>Solicitante/Fecha</th>
				<th>Ruta</th>
				<th>Ciudad</th>
				<th>Fecha: Orden / Servicio</th>
				<th>Itinerario</th>
				<th>Recoger en</th>
				<th>Dejar en</th>
				<th>Detalle</th>
				<th>Pax</th>
				<th>Proveedor / Conductor</th>
				<th>Horario</th>
				<th>Cliente</th>
				<th>Usuario</th>
				<th>Historial</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
					<th>Codigo</th>
					<th>Solicitante/Fecha</th>
					<th>Ruta</th>
					<th>Ciudad</th>
					<th>Fecha: Orden / Servicio</th>
					<th>Itinerario</th>
					<th>Recoger en</th>
					<th>Dejar en</th>
					<th>Detalle</th>
					<th>Pax</th>
					<th>Proveedor / Conductor</th>
					<th>Horario</th>
					<th>Cliente</th>
					<th>Usuario</th>
					<th>Historial</th>
			</tr>
		</tfoot>
		<tbody>
		</tbody>
		</table>
		@endif
	</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/papelera.js')}}"></script>
</body>
</html>
