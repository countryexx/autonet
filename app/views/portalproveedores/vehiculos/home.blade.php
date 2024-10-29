<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <meta name="url" content="{{url('/')}}">
	<title>Autonet | Gestión de Vehículos</title>
	@include('scripts.styles')
	<style type="text/css">
		.sub{
			font-size: 17px;
			margin-top: 50px;
		}

		.cuadro{
			border-top: 1px solid;
			border-bottom: 1px solid;
			height: 230px;
		}
	</style>
</head>
<body style="font-family: Bahnschrift;">
	@include('admin.menu')
	<div class="col-lg-12">
		<h1 class="h_titulo">MIS VEHÍCULOS ACTIVOS</h1>
		<div class="row">
			<div class="col-lg-12">
				@if($vehiculos!=null)
					@include('portalproveedores.menu_vehiculos')
				@else
					ACTUALMENTE NO CUENTA CON VEHÍCULOS CREADOS O ACTIVOS EN EL SISTEMA
				@endif
			</div>
		</div>
	</div>

	@include('scripts.scripts')

	<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
	<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
	<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
	<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
	<script src="{{url('jquery/portalproveedores.js')}}"></script>
    <!--<script>

      $('input[type=file]').bootstrapFileInput();
      $('.file-inputs').bootstrapFileInput();

    </script>-->
</body>
</html>
