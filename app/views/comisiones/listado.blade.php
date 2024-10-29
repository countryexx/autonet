<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Autonet | Comisiones</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-4">
        <div class="row">
          <ol style="margin-bottom: 10px" class="breadcrumb">
            <li class="active">Listado</a></li>
            <li><a href="{{url('comisiones/pagos')}}">Pago de Comisiones</a></li>
            <li><a href="{{url('comisiones/pagosporautorizar')}}">Pagos por Autorizar</a></li>
            <li><a href="{{url('comisiones/pagosporpagar')}}">Pagos por Pagar</a></li>
          </ol>
        </div>
      </div>
      <div class="col-lg-12">
  			<div class="row">
  			  <h3 class="h_titulo">LISTADO DE FACTURAS</h3>
          <form class="form-inline">
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
              <select type="text" class="form-control input-font" id="tipo_servicio" placeholder="TIPO DE SERVICIO">
                <option value="0">TIPO DE SERVICIO</option>
                <option value="1">TRANSPORTE</option>
                <option value="2">TURISMO</option>
              </select>
            </div>
            <div class="form-group">
              <select type="text" class="form-control input-font" id="asesor_comercial">
                <option value="0">ASESOR COMERCIAL</option>
                @foreach ($comercial as $value)
                    <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select type="text" class="form-control input-font" id="tercero">
                <option value="0">ASESOR EXTERNO</option>
                @foreach ($terceros as $value)
                    <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select type="text" class="form-control input-font" id="coordinador_turismo">
                <option value="0">COORDINADOR COMERCIAL</option>
                @foreach ($users as $value)
                    @if($value->coordinador_turismo===1)<option value="{{$value->id}}">{{$value->first_name.' '.$value->last_name}}</option>@endif
                @endforeach
              </select>
            </div>
            <button id="buscar" type="button" class="btn btn-lg btn-default btn-icon">BUSCAR <i class="fa fa-search icon-btn"></i></button>
  			</div>
  		</div>
      <table id="example" class="table table-bordered table-hover table-condensed ">
        <thead>
          <tr>
            <th>#Fact</th>
            <th>Centro Costo</th>
            <th>Producto</th>
            <th>Valor</th>
            <th>IVA</th>
            <th>Impuesto</th>
            <th>Otras Tasas</th>
            <th>Tasa Aero</th>
            <th>Costo</th>
            <th>T.A</th>
            <th>Iva T.A</th>
            <th>Otros</th>
            <th>Facturado</th>
            <th>Gastos Bancarios</th>
            <th>T.A Real</th>
            <th>Tercero</th>
            <th>Asesor</th>
            <th>Coordinador</th>
            <th>Aotour</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <th>#Fact</th>
          <th>Centro Costo</th>
          <th>Producto</th>
          <th>Valor</th>
          <th>IVA</th>
          <th>Impuesto</th>
          <th>Otras Tasas</th>
          <th>Tasa Aero</th>
          <th>Costo</th>
          <th>T.A</th>
          <th>Iva T.A</th>
          <th>Otros</th>
          <th>Facturado</th>
          <th>Gastos Bancarios</th>
          <th>T.A Real</th>
          <th>Tercero</th>
          <th>Asesor</th>
          <th>Coordinador</th>
          <th>Aotour</th>
        </tfoot>
      </table>

    </div>
    <div style="margin-top: 15px;" class="col-lg-4 hidden" id="pago_comisiones">
				<div class="panel panel-default ui-draggable" style="position: relative;">
					<div class="panel-heading ui-draggable-handle">
            <strong>TOTALES</strong>
          </div>
					<div class="panel-body">
						<table style="margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);" class="table table-bordered hover">
						    <tbody><tr>
						    	<td>TOTAL COMISIONES</td>
						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_comisiones">$ 0</label></td>
						    </tr>
						    <!--<tr>
						    	<td>IVA</td>
						    	<td>
						    		<select class="form-control input-font" id="iva">
						    			<option value="0">-</option>
						    			<option value="1">SI</option>
						    			<option value="2">NO</option>
						    		</select>
						    	</td>
						    </tr>
						    <tr id="valor_iva" class="hidden">
						    	<td>VALOR IVA</td>
						    	<td><input disabled class="form-control input-font valor_iva"></td>
						    </tr>-->
						    <tr>
						    	<td>DESCUENTO RETEFUENTE</td>
						    	<td><input class="form-control input-font" id="descuento_retefuente" value="0"></td>
						    </tr>
						    <tr id="valor_retefuente" class="hidden">
						    	<td>VALOR RETEFUENTE</td>
						    	<td><input disabled="" class="form-control input-font valor_retefuente"></td>
						    </tr>
								<tr class="table_botones">
									<td>DESCUENTOS</td>
									<td>
										<a id="agregar_descuento" style="margin-right: 3px;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
										<a id="eliminar_descuento" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>
									</td>
								</tr>
						</tbody></table>
						<table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
						</table>
						<table class="table table-bordered hover" style="margin-bottom: 0px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
						    <tbody><tr>
						    	<td style="width: 270px;">TOTAL OTROS DESCUENTOS</td>
						    	<td><input class="form-control input-font" id="otros_descuentos" value="0"></td>
						    </tr>
								<tr class="norealizado">
						    	<td>TOTAL PAGADO</td>
						    	<td><input class="form-control input-font" id="totales_pagado" disabled=""></td>
						    </tr>
								<tr class="realizado hidden">
						    	<td>TOTAL PAGADO</td>
						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_todo">$ 0</label></td>
						    </tr>
                <tr>
						    	<td>FECHA PAGO</td>
						    	<td>
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_pago" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                  </td>
						    </tr>
								<tr class="info_pago hidden">
									<td style="width: 291px;"></td>
								</tr>
								<tr class="guardar_pago">
						    	<td></td>
						    	<td>
                                    @if(isset($permisos->contabilidad->comisiones->generar_pago))
                                        @if($permisos->contabilidad->comisiones->generar_pago==='on')
                                            <a id="guardar_pago" class="btn btn-default btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                                        @else
                                            <a class="btn btn-default btn-icon disabled">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                                        @endif
                                    @else
                                        <a class="btn btn-default btn-icon disabled">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                                    @endif
                                </td>
						    </tr>
						</tbody></table>
					</div>
				</div>
		</div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script>

        $('#datetimepicker1, #datetimepicker2, #datetimepicker5, #datetimepicker6').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            icons: {
                time: 'glyphicon glyphicon-time',
                date: 'glyphicon glyphicon-calendar',
                up: 'glyphicon glyphicon-chevron-up',
                down: 'glyphicon glyphicon-chevron-down',
                previous: 'glyphicon glyphicon-chevron-left',
                next: 'glyphicon glyphicon-chevron-right',
                today: 'glyphicon glyphicon-screenshot',
                clear: 'glyphicon glyphicon-trash',
                close: 'glyphicon glyphicon-remove'
            }
        });

        $table = $('#example').DataTable({

            paging: false,
            language: {
                processing:     "Procesando...",
                search:         "Buscar:",
                lengthMenu:    "Mostrar _MENU_ Registros",
                info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
                infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
                infoFiltered:   "(Filtrando de _MAX_ registros en total)",
                infoPostFix:    "",
                loadingRecords: "Cargando...",
                zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
                emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
                paginate: {
                    first:      "Primer",
                    previous:   "Antes",
                    next:       "Siguiente",
                    last:       "Ultimo"
                },
                aria: {
                    sortAscending:  ": activer pour trier la colonne par ordre croissant",
                    sortDescending: ": activer pour trier la colonne par ordre décroissant"
                },
                "aoColumnDefs": [
                    { "sClass": "column-2", "aTargets": [ 1 ] }
                ]
            },
            'bAutoWidth': false,
            'aoColumns' : [
                { 'sWidth': '1%' },
                { 'sWidth': '2%' },
                { 'sWidth': '2%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' },
                { 'sWidth': '1%' }
            ],
            processing: true,
            "bProcessing": true
        });

    </script>
    <script src="{{url('jquery/comisiones.js')}}"></script>

  </body>
</html>
