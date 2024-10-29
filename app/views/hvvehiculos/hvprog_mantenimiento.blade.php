<div style="overflow-y: auto; height: 420px;">

	<table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
	  <thead>
		  <tr>
			  <th colspan="2"> </th>
			  @foreach($mantenimiento_kilometraje as $mtm_kilometraje)
				  <th>{{$mtm_kilometraje->kilometraje}}</th>
			  @endforeach

		  </tr>

	  </thead>

	  <tbody>


		@foreach($mantenimiento_operacion as $key => $mtm_operacion)
		<tr>
			<th>{{$mtm_operacion->id}}</th>
			<th>{{$mtm_operacion->item}}</th>

		<?php
		if(count($mtn_revision)>0){
			foreach($mantenimiento_kilometraje as $key2 => $mtm_kilometraje2){

				$consulta_cheked = "SELECT rev.* FROM mantenimiento_revision AS rev LEFT JOIN mantenimiento_operacion_kilometraje AS op_km ON op_km.id = rev.mantenimiento_operacion_id  WHERE rev.mantenimiento_kilometraje_id = '".$mtm_kilometraje2->id."' and op_km.mantenimiento_operacion_id = '".$mtm_operacion->id."' and op_km.anulado is null";
				$resul_cheked = DB::select($consulta_cheked);
					if(count($resul_cheked)>0){
						foreach($resul_cheked as $revision){
							echo '<th align><i class="fa fa-check list-check" title="Fecha:'.$revision->fecha_mantenimiento.' Kilometraje:'.$revision->kilometraje_real.'"></i></th>';
						}
					}else{
						echo"<th> </th>";
					}
			}
		}else{
			foreach($mantenimiento_kilometraje as $key2 => $mtm_kilometraje2){
				echo '<th> </th>';
			}
		}

		?>
		</tr>
		@endforeach


	  </tbody>

	</table>
</div>
<div style="margin-bottom: 20px;" class="btn-group dropup"><br/>
	<button style="padding: 8px" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		ver <span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a class="tamaño-dropdownmayus" data-toggle="modal" data-target=".mymodaladkm">Kilometraje <i class="fa fa-plus"></i></a></li>
		<li><a class="tamaño-dropdownmayus" data-toggle="modal" data-target=".mymodaladop">Operacion <i class="fa fa-plus"></i></a></li>
		<li><a class="tamaño-dropdownmayus" data-toggle="modal" data-target=".mymodaladenlazar">Enlazar <i class="fa fa-plus"></i></a></li>
	</ul>
</div>
<button type="button" class="btn btn-default btn-icon agregar_revision" data-toggle="modal" data-target=".mymodaladmatm" >REVISION<i class="fa fa-plus icon-btn"></i></button>


<div class="modal fade mymodaladmatm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<form id="formulario_revision">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">NUEVA REVISION </h4>
				</div>
				<div class="modal-body">
					<div class="col-xs-10">
							<div class="row">
								<div class="col-xs-3">
									<label class="obligatorio" for="tipo_documento">Kilometraje Control</label>
									<select class="form-control input-font" id="km_control">
										<option>-</option>
										  @foreach($mtmt_select2 as $mtm_kilometraje_control)
											  <option value='{{$mtm_kilometraje_control->id}}'>{{$mtm_kilometraje_control->kilometraje}}</option>
										  @endforeach

									</select>

								</div>

								<div class="col-xs-3" id="container_frev">
									<div class="form-group" style="margin-bottom: 0px;">
										<label for="fecha_revision" >Fecha Revision</label>
										<div class='input-group date' id='datetimepickerhv7'>
											<input type='text' class="form-control input-font" id="fecha_revision" value="{{date('Y-m-d')}}">
											<span class="input-group-addon">
												<span class="fa fa-calendar">
												</span>
											</span>
										</div>
									</div>
								</div>

								<div class="col-xs-3">
									<label  for="km_recorrido">Kilometraje Recorrido</label>
									<input type="text" class="form-control input-font" id="km_recorrido">
								</div>

							</div>

							<div class="row" style="overflow-y: auto; height: 350px;">
								<table id="list_revision" class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px; width:95%">
									<thead>
									  <tr>
										<th>#</th>
										<th>OPERACION</th>
										<th style="width: 70px"><input type="checkbox" name="realizado1" id="todos_id" disabled="true" title="Seleccionar Todos"> REALIZADO</th>

										<th style="width: 100px">ESTADO</th>
									  </tr>
									</thead>
									<tbody>

									</tbody>
									<thead>
									  <tr>
										<th>#</th>
										<th>OPERACION</th>
										<th style="width: 70px">REALIZADO</th>

										<th style="width: 100px">ESTADO</th>
									  </tr>
									</thead>

								</table>
							</div>
						</div>
				</div>
				<div class="modal-footer" >
					<div class="col-xs-10" ><br/>
						<textarea class="form-control" rows="4" placeholder="Observaciones..." id="observaciones_rev"></textarea>
					</div>
					<div class="col-xs-12" ><br/>
						<button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarev" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
						<a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodaladkm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-sm">
		<form id="formulario_kilometraje">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">NUEVO KILOMETRAJE</h4>
				</div>
				<div class="modal-body" style="height: 100px;">
					<div class="col-xs-16" >

							<div class="col-xs-8">
								<label  for="km_recorrido">Kilometraje:</label>
								<input type="text" class="form-control input-font" id="new_km">
							</div>
						<div class="col-xs-8" id="container_fechakm" style="margin-bottom: 10px;">

                                <label for="fecha_km" >Dias:</label>

                                <input type='text' class="form-control input-font" id="fecha_km" >
                        </div>
					</div>

				</div>
				<div class="modal-footer" >
					<div class="col-xs-16"><br/>
						<button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarkm" class="btn btn-primary btn-icon">Agregar<i class="fa fa-floppy-o icon-btn"></i></button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodaladop" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-sm">
		<form id="formulario_operacion">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">NUEVA OPERACION</h4>
				</div>
				<div class="modal-body" style="height: 100px;">
					<div class="col-xs-16" >

							<div class="col-xs-14">
								<label  for="km_recorrido">Operacion:</label>
								<input type="text" class="form-control input-font" id="new_op">
							</div>

					</div>
				</div>
				<div class="modal-footer" >
					<div class="col-xs-16"><br/>
						<button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarop" class="btn btn-primary btn-icon">Agregar<i class="fa fa-floppy-o icon-btn"></i></button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodaladenlazar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<form id="formulario_enlaze">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
					<h4 class="modal-title">AGREGAR OPERACION A KILOMETRAJE</h4>

				</div>
				<div class="modal-body">
					<div class="col-xs-10">
							<div class="row" >
								<div class="col-xs-3">
									<label class="obligatorio" for="km_control">Kilometraje Control</label>
									<select class="form-control input-font" id="km_control2">
										<option>-</option>
										  @foreach($mantenimiento_kilometraje as $mtm_kilometraje_control)
											  <option value='{{$mtm_kilometraje_control->id}}'>{{$mtm_kilometraje_control->kilometraje}}</option>
										  @endforeach

									</select>
								</div>

								<div class="col-xs-3">
									<label class="obligatorio" for="op_control">Operacion Control</label>
									<select class="form-control input-font" id="op_control2" name="op_control2">

									</select>
								</div>

								<div class="col-xs-3">
									<button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarenlaze" class="btn btn-primary btn-icon" style="margin-top:23px;">Agregar<i class="icon-btn fa fa-floppy-o"></i></button>
								</div>
							</div>

							<div class="row" style="overflow-y: auto; height: 500px;">
								<table class="table table-bordered table-hover tabla" cellspacing="0" style="margin-top: 20px; width:95%" id="list_operacion_km">
									<thead>
									  <tr>
										<th>#</th>
										<th>OPERACION</th>
										<th style="width: 70px">QUITAR</th>
									  </tr>
									</thead>

									<tbody>
									</tbody>

									<thead>
									  <tr>
										<th>#</th>
										<th>OPERACION</th>
										<th style="width: 70px">QUITAR</th>
									  </tr>
									</thead>
								</table>
							</div>

						</div>


				</div>
				<div class="modal-footer">

				</div>
			</div><!-- /.modal-content -->
		</form>
	</div><!-- /.modal-dialog -->
</div>
