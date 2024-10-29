<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Listado de Cuentas de Cobro</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
    <h3 class="h_titulo">CUENTAS DE COBRO PENDIENTES</h3>
    @if(isset($rutas_programadas))
        <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
            <thead>
            <tr>
                <td>#</td>
                <td>PROVEEDOR</td>
                <td>FECHA DE EXPEDICIÓN</td>
                <td>FECHA DE PAGO</td>
                <td>VALOR COBRADO</td>
                <td>ACCIONES</td>
            </tr>
            </thead>
            <tbody>
            	<?php $i=1; $total=0;?>
            @foreach($rutas_programadas as $ruta)
                <tr @if($ruta->id!=null){{'class="success"'}}@endif >
                    <td data-id="{{$ruta->id}}">
                        <?php echo $i ?>
                    </td>
                   
                    <td>
                    	<span>{{$ruta->razonsocial}}</span>
                    </td>
                    <td>
                    	<span>{{$ruta->fecha_expedicion}}</span>
                    </td>
                    <td>
                        <span>{{$ruta->fecha}}</span>
                    </td>
                    <td>
                    	<span><?php echo '$ '.number_format($ruta->valor); ?></span>
                    </td>                    
                   
                    <td>
                        <a href="{{url('portalproveedores/detalles/'.$ruta->id)}}" target="_blank" id="ver_detalles" class="btn btn-info btn-icon input-font">Ver Detalles<i class="fa fa-info icon-btn"></i></a>

                    	<a id="habilitar_campos" class="btn btn-success btn-icon input-font">Aprobarla<i class="fa fa-check icon-btn"></i></a>    

                        <a id="habilitar_campos" class="btn btn-danger btn-icon input-font">Desaprobarla<i class="fa fa-times icon-btn"></i></a>
                    </td>
                </tr>
                <?php $i++;?>
            @endforeach
            </tbody>
        </table>
    @endif
    
</div>

<div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    	<li>
    		test
    	</li>
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
<script>
    $('table a').click(function (e) {
        e.preventDefault();
    });
</script>
</body>
</html>
