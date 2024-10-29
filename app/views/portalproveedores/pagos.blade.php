<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Datos Financieros</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('dropzonejs/dist/dropzone.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')
<div class="col-xs-12">
	@include('portalproveedores.menu_proveedores')
	
	<table id="examplecontabilidad" class="table table-bordered hover" cellspacing="0" width="100%">
		<thead>
			<th>ID</th>
			<th>PROVEEDOR</th>
			<th>TIPO DE CUENTA</th>
			<th>ENTIDAD BANCARIA</th>
			<th>NÚMERO DE CUENTA</th>
			<th>ACCIONES</th>
		</thead>
		<tfoot>
			<th>ID</th>
			<th>PROVEEDOR</th>
			<th>TIPO DE CUENTA</th>
			<th>ENTIDAD BANCARIA</th>
			<th>NÚMERO DE CUENTA</th>
			<th>ACCIONES</th>
		</tfoot>
		<tbody>
		@foreach($proveedores as $proveedor)
		<tr class="@if(intval($proveedor->estado_tercero)===1){{'success'}}@endif">
			<td>{{$proveedor->id}}</td>
			<td>{{$proveedor->razonsocial.' | '.$proveedor->tipo_empresa}} @if($proveedor->estado_tercero===1) <br><br> {{$proveedor->razonsocial_t}} @else @endif</td>
			<td>
				@if($proveedor->estado_tercero===1)
					{{$proveedor->tipo_cuenta_t}} 
				@else 
					{{$proveedor->tipo_cuenta}}
				@endif
			</td>
			<td>
				@if($proveedor->estado_tercero===1)
					{{$proveedor->entidad_bancaria_t}} 
				@else 
					{{$proveedor->entidad_bancaria}} 
				@endif
			</td>
			<td>
				@if($proveedor->estado_tercero===1)
					{{$proveedor->numero_cuenta_t}} 
				@else 
					{{$proveedor->numero_cuenta}} 
				@endif
			</td>
			<td>

				<!-- SI TIENE ACTIVO EL PAGO A TERCERO -->
				@if($proveedor->estado_tercero===1)

					<a class="btn btn-success" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/certificaciones/'.$proveedor->certificacion_bancaria_t)}}">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a>

					<a class="btn btn-warning" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/certificaciones/'.$proveedor->poder_t)}}">PODER <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a>

				@else

					@if($proveedor->certificacion_proveedor!=null)

					<a class="btn btn-success" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/certificaciones/'.$proveedor->certificacion_proveedor)}}">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a>

					@else
						<button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->certificacion_proveedor}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">CERTIFICACIÓN <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
					@endif

					<button data-value="{{$proveedor->id}}" disabled data-url="{{$proveedor->poder_t}}" data-razon="{{$proveedor->razonsocial}}" class="btn btn-info ver_pdf">PODER <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>

				@endif
				<!-- <a data-value="{{$proveedor->id}}" class="btn btn-warning" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/certificaciones/'.$proveedor->certificacion_proveedor)}}">VER DOCUMENTO <i class="fa fa-eye" aria-hidden="true"></i></a> -->
					
				<button data-value="{{$proveedor->id}}" class="btn btn-primary aprobar_certificacion">APROBAR <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
				
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>
@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
</div>
</body>
</html>