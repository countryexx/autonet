<!DOCTYPE html>
<html>
<head>	
	<meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Seguridad Social</title>	
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

	<table id="conductores_seguridad_social" class="table table-bordered hover" cellspacing="0" width="100%">
		<thead>
			<th>ID</th>
			<th>PROVEEDOR</th>
			<th>CONDUCTOR</th>
			<th>CC</th>			
			<th>DOCUMENTOS</th>
			<th>ACCIONES</th>
		</thead>
		<tfoot>
			<th>ID</th>
			<th>PROVEEDOR</th>
			<th>CONDUCTOR</th>
			<th>CC</th>			
			<th>DOCUMENTOS</th>
			<th>ACCIONES</th>
		</tfoot>
		<tbody>
		@foreach($conductores as $conductor)
		<tr>
			<td>
				<button data-value="{{$conductor->id}}" class="btn btn-info btn-list-table seleccionar_fila">{{$conductor->id}}. Seleccionar fila</button>
			</td>
			<td>{{$conductor->razonsocial}} | {{$conductor->tipo_empresa}}</td>
			<td>{{$conductor->nombre_completo}}</td>
			<td>{{$conductor->cc}}</td>
			<td>
				<a data-value="{{$conductor->id}}" class="btn btn-secondary" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/cc/'.$conductor->pdf_cc)}}">DOC IDENTIDAD <i class="fa fa-eye" aria-hidden="true"></i></a>

				<a data-value="{{$conductor->id}}" class="btn btn-success" target="_blank" href="{{url('biblioteca_imagenes/prov_nuevos/documentacion/conductores/seguridadsocial/'.$conductor->seguridad_social)}}">SEGURIDAD SOCIAL <i class="fa fa-eye" aria-hidden="true"></i></a>
			</td>
			<td>
				<button data-value="{{$conductor->id}}" class="btn btn-primary seg_social">APROBAR <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>

				<button data-value="{{$conductor->id}}" class="btn btn-danger seg_social_no">NO APROBAR <i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>

			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

	<!-- MODAL PDF -->
      <div class="modal fade" tabindex="-1" role="dialog" id='modal_pdf'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
              <div class="modal-header" style="background: #079F33">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;" id="name">INGRESO SEGURIDAD SOCIAL</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-5">
                        <input name="numero_planilla" id="numero_planilla" type='text' class="form-control input-font" value="" placeholder="NÚMERO DE PLANILLA" autocomplete="false">
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_inicial" id="fecha_inicial_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha INICIAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class='input-group date' id='datetimepicker2'>
                        <input name="fecha_final" id="fecha_final_t" style="width: 100px;" type='text' class="form-control input-font" value="" placeholder="Fecha FINAL">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="row">
                  <div class="col-md-2 col-md-offset-10">
                    <button type="button" class="btn btn-primary aprobar_conductor" style="float: left;">GUARDAR</button>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/portalproveedores.js')}}"></script>
</div>
</body>
</html>