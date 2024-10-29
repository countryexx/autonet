<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Servicios Editados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body onload="nobackbutton();">
@include('admin.menu')

<div class="col-lg-12">

    <h3 class="h_titulo">SERVICIOS EDITADOS SAMUEL</h3>

    @if(isset($servicios))
        <table id="servicios_editados" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>ID de pago</th>
                <th>ID de Servicio</th>
                <th>Unitario Cobrado</th>
                <th>Unitario Pagado</th>
                <th>Total Cobrado</th>
                <th>Total Pagado</th>
                <th>Utilidad</th>
                <th>Id de Factura</th>                
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th></th>
                <th>ID de pago</th>
                <th>ID de Servicio</th>
                <th>Unitario Cobrado</th>
                <th>Unitario Pagado</th>
                <th>Total Cobrado</th>
                <th>Total Pagado</th>
                <th>Utilidad</th>
                <th>Id de Factura</th> 
            </tr>
            </tfoot>
            <tbody>

            @foreach($servicios as $servicio)
                <tr id="{{$servicio->id}}" >
                    <td>{{$o++}}</td>
                    <td>{{$servicio->id}}</td>
                    <td>{{$servicio->servicio_id}}</td>
                    <td>{{$servicio->unitario_cobrado}}</td>
                    <td>{{$servicio->unitario_pagado}}</td>
                    <td>{{$servicio->total_cobrado}}</td>                    
                    <td>{{$servicio->total_pagado}}</td>                                        
                    <td>{{$servicio->utilidad}}</td>                   
                    <td>{{$servicio->factura_id}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>


<div class="modal fade mymodaladcambios" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h5 class="modal-title">Cambios Solicitados</h5>
			</div>
			<div class="modal-body" >
				<div id="info_cambios">




				</div>
			</div>
			<div class="modal-footer" >

			</div>
		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/servicios_eliminacion.js')}}"></script>

<script type="text/javascript">

    window.onload=function(){
      var pos=window.name || 0;
      window.scrollTo(0,pos);

    }
    window.onunload=function(){
    window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
    }

function nobackbutton(){

   window.location.hash="no-back-button";

   window.location.hash="Again-No-back-button" //chrome

   window.onhashchange=function(){
     window.location.hash="no-back-button";
   }
}
</script>
</body>
</html>
