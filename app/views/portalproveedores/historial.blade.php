<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Historial de mis Cuentas de Cobro</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-8">
    <h3 class="h_titulo">MIS CUENTAS DE COBRO</h3>
    @if(isset($cuentas))
        <table class="table table-bordered hover tabla" id="example" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>ESTADO</th>
                <th>DESDE</th>
                <th>HASTA</th>
                <th>VALOR</th>
                <th>ACCIONES</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>ESTADO</th>
                    <th>DESDE</th>                    
                    <th>HASTA</th>
                    <th>VALOR</th>
                    <th>ACCIONES</th>
                </tr>
            </tfoot>
            <tbody>
            	<?php $i=1; $total=0;?>
            @foreach($cuentas as $cuenta)
                <tr>
                    <td data-id="{{$cuenta->id}}">
                        <?php echo $i ?>
                    </td>
                   
                    <td>
                    	<span>RADICADA</span>
                    </td>
                    <td>
                    	<span>{{$cuenta->fecha_inicial}}</span>
                    </td>
                    <td>
                        <span>{{$cuenta->fecha_final}}</span>
                    </td>
                    <td>
                    	<span><?php echo '$ '.number_format($cuenta->valor); ?></span>
                    </td>                    
                   
                    <td>

                        <a href="{{url('portalproveedores/details/'.$cuenta->id)}}"  class="btn btn-success btn-icon input-font">Ver<i class="fa fa-info icon-btn"></i></a>

                    	<!--<a id="habilitar_campos" class="btn btn-success btn-icon input-font">Aprobarla<i class="fa fa-check icon-btn"></i></a>    

                        <a id="habilitar_campos" class="btn btn-danger btn-icon input-font">Desaprobarla<i class="fa fa-times icon-btn"></i></a> -->
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
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
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
