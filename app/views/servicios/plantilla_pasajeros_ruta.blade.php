<html>
<head>
	<title></title>
	<link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
</head>

<body>
	<br>
	<br>
		<br>
		<tr>
			<td width="5"></td>
			<td><strong>EMPRESA SOLICITANTE:</strong></td>
			<td>{{$servicio->razonsocial}}</td>
			<td></td>
			<td><strong># CONSTANCIA</strong></td>
			<td>{{$servicio->numero_planilla}}</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><strong>FECHA INICIAL:</strong></td>
			<td>{{$servicio->fecha_servicio}}</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><strong>HORARIO RUTA:</strong></td>
			<td>{{$servicio->hora_servicio}}</td>
			<td></td>
			<td><strong>RUTA:</strong></td>
			<td>{{$servicio->detalle_recorrido}}</td>
			<td></td>
			<td></td>
		</tr>
		<br>
<table class="excel_table_pax">
	<thead>
		<tr>
			<th style="border: 1px solid #000000" valign="middle" align="center">No</td>
			@if($ch_nombre!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>NOMBRES</strong></th>
			@endif
			@if($ch_apellido!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>APELLIDOS</strong></th>
			@endif
			@if($ch_cedula!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>CEDULA</strong></th>
			@endif
			@if($ch_direccion!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>DIRECCION</strong></th>
			@endif
			@if($ch_barrio!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>BARRIO</strong></th>
			@endif
			@if($ch_cargo!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>CARGO</strong></th>
			@endif
			@if($ch_area!=null)
			<th width="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>AREA</strong></th>
			@endif
			@if($ch_subarea!=null)
			<th width="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>SUB AREA</strong></th>
			@endif
			<th width="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>FECHA</strong></th>
			<th width="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>RUTA</strong></th>
			@if($ch_horario!=null)
			<th style="border: 1px solid #000000" valign="middle" align="center"><strong>HORARIO</strong></th>
			@endif
			@if($ch_embarcado!=null)
				<th style="border: 1px solid #000000" valign="middle" align="center"><strong>RS</strong></th>
			@endif
			@if($ch_no_embarcado!=null)
				<th style="border: 1px solid #000000" valign="middle" align="center"><strong>RN</strong></th>
			@endif
			@if($ch_autorizado!=null)
				<th style="border: 1px solid #000000" valign="middle" align="center"><strong>AU</strong></th>
			@endif
			@if($ch_firma!=null)
			<th style="border: 1px solid #000000" width="30" valign="middle" align="center"><strong>FIRMA</strong></th>
			@endif
		</tr>
	</thead>
	<tbody>

		<?php
			$json = json_decode($servicio->pasajeros_ruta);
			$i=1;
		?>
		<?php if(is_array($json)){ ?>
		@foreach($json as $value)
		<tr>
			<td height="30" style="border: 1px solid #000000; font-size: 16px" valign="middle" align="center"><strong>{{$i++}}</strong></td>
			@if($ch_nombre!=null)
			<td height="30" style="border: 1px solid #000000; font-size: 16px" valign="middle" align="center"><strong><?php $nombre_ex = str_replace('&nbsp;','',$value->nombres);?>{{ strtoupper($nombre_ex) }}</strong></td>
			@endif
			@if($ch_apellido!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper(str_replace('&nbsp;','',$value->apellidos)) }}</strong></td>
			@endif
			@if($ch_cedula!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper($value->cedula)}}</strong></td>
			@endif
			@if($ch_direccion!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper(str_replace('&nbsp;','',$value->direccion))}}</strong></td>
			@endif
			@if($ch_barrio!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper(str_replace('&nbsp;','',$value->barrio))}}</strong></td>
			@endif
			@if($ch_cargo!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper(str_replace('&nbsp;','',$value->cargo))}}</strong></td>
			@endif
			@if($ch_area!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper(str_replace('&nbsp;','',$value->area))}}</strong></td>
			@endif
			@if($ch_subarea!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper($value->sub_area)}}</strong></td>
			@endif
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{$servicio->fecha_servicio}}</strong></td>
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{$servicio->detalle_recorrido}}</strong></td>
			@if($ch_horario!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>{{strtoupper($value->hora)}}</strong></td>
			@endif
            @if($ch_embarcado!=null)
                <td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong></strong></td>
            @endif
            @if($ch_no_embarcado!=null)
                <td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong></strong></td>
            @endif
            @if($ch_autorizado!=null)
                <td height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong></strong></td>
            @endif
			@if($ch_firma!=null)
			<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>
			@endif
		</tr>

		@endforeach
		<?php } ?>
		<?php
			$j = count($json)+1;
			if(is_array($json)){
			for ($i=0; $i <-count($json)+16 ; $i++) {
					echo '<tr>';
					echo '<td  height="30" style="border: 1px solid #000000" valign="middle" align="center"><strong>'.$j.'<strong></td>';
					if ($ch_nombre!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_apellido!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_cedula!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_direccion!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_barrio!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_cargo!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_area!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_subarea!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					if ($ch_horario!=null) {
							echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
                    if ($ch_embarcado!=null) {
                        echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
                    }
                    if ($ch_no_embarcado!=null) {
                        echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
                    }
                    if ($ch_autorizado!=null) {
                        echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
                    }
					if($ch_firma!=null){
						echo '<td height="30" style="border: 1px solid #000000" valign="middle" align="center"></td>';
					}
					echo '</tr>';

					$j++;
			}
		}
		  ?>
	</tbody>
</table>
<tr>
	<td></td>
	<td><strong>NOMBRE DEL CONDUCTOR:</strong></td>
	<td>{{$servicio->nombre_completo}}</td>
	<td></td>
</tr>
<tr>
		<td></td>
		<td><strong>OBSERVACION:</strong></td>
		<td></td>
</tr>


</body>
</html>
