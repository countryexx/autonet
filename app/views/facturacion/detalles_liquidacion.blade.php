<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Detalles </title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
      <h3 class="h_titulo">DETALLE DE ORDEN DE FACTURACION GENERADA</h3>

      <div class="col-lg-4">
    		<div class="row">
    			<table class="table tabla" style="margin-bottom:0px">
    				<tbody>
    					<tr>
    						<td>NUMERO CONSECUTIVO</td>
      						<td><span style="color: #F47321;">{{$liquidacion_servicios->consecutivo}}</span></td>
    					</tr>
    					<tr>
    						<td>FECHA INICIAL</td>
                <!-- <td>2016-09-20</td> -->
                <td>{{$liquidacion_servicios->fecha_inicial}}</td>
    					</tr>
    					<tr style="border-bottom: 1px solid #dddddd;">
    						<td>CENTRO DE COSTO</td>
    						<td class="bolder">@if($liquidacion_servicios->razonsocial!=$liquidacion_servicios->nombresubcentro){{$liquidacion_servicios->razonsocial.' / '.$liquidacion_servicios->nombresubcentro}}@else{{$liquidacion_servicios->razonsocial}}@endif</td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
	    </div>
      <div class="col-lg-4">
    		<div class="row">
    			<table class="table tabla" style="margin-bottom:0px">
    				<tbody>
    					<tr>
    						<td>FECHA DE REGISTRO</td>
    						<td><span style="color: #F47321;">{{$liquidacion_servicios->fecha_registro}}</span></td>
    					</tr>
    					<tr>
    						<td>FECHA FINAL</td>
    						<td>{{$liquidacion_servicios->fecha_final}}</td>
    					</tr>
    					<tr style="border-bottom: 1px solid #dddddd;">
    						<td>CIUDAD</td>
    						<td>{{$liquidacion_servicios->ciudad}}</td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
	    </div>
      <div class="col-lg-4">
    		<div class="row">
    			<table class="table tabla" style="margin-bottom:0px">
    				<tbody>
                        <?php

                            $total_facturadoa = 0;
                            $total_costoa = 0;
                            $total_utilidada = 0;
                            $rentabilidad_suma = 0;

                        ?>
                        @foreach($facturacion as $factura)
                            <?php

                            $total_facturadoa = $total_facturadoa + floatval($factura->total_cobrado);
                            $total_costoa = $total_costoa + floatval($factura->total_pagado);
                            $total_utilidada = $total_utilidada + floatval($factura->utilidad);
                            $rentabilidada = (floatval($factura->utilidad)/floatval($factura->total_cobrado))*100;
                            $rentabilidad_suma = $rentabilidad_suma + $rentabilidada;

                            ?>

                        @endforeach
    					<tr>
    						<td>TOTAL FACTURADO INICIAL</td>
    						<td><span style="color: #F47321;">$ {{number_format($total_facturadoa+$liquidacion_servicios->otros_ingresos)}}</span></td>
    					</tr>
    					<tr>
    						<td>TOTAL COSTO INICIAL</td>
    						<td>$ {{number_format($total_costoa)}}</td>
    					</tr>
    					<tr style="border-bottom: 1px solid #dddddd;">
    						<td>TOTAL UTILIDAD INICIAL</td>
    						<td>$ {{number_format($total_utilidada)}}</td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
	    </div>
      <div class="col-lg-12">
        <p style="text-align: center; margin-top:10px" class="subtitulo">CRONOGRAMA DE FACTURACION DE SERVICIOS DEL {{$liquidacion_servicios->fecha_inicial.' AL '.$liquidacion_servicios->fecha_final}}</p>
         <div style="text-align: right;" class="form-check">
            <input class="form-check-input" style="background-color: orange; color: black;" type="checkbox" value="" id="verdeButon">
            <label class="form-check-label" for="flexCheckDefault" style="font-size: 15px; color: #2ab52c;">
              Verde
            </label>

            <input class="form-check-input" type="checkbox" value="" id="azulButon">
            <label class="form-check-label" for="flexCheckDefault" style="font-size: 15px; color: #29bbde;">
              Azul
            </label>

            <input class="form-check-input" type="checkbox" value="" id="rojoButon">
            <label class="form-check-label" for="flexCheckDefault" style="font-size: 15px; color: #ec3939;">
              Rojo
            </label>
          </div>
      </div>
      <table id="tb_autorizar" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th style="width: 3%">#</th>
            <th style="width: 10%">FECHA</th>
            <th style="width: 7%">NUMERO DE ORDEN</th>
            <th style="width: 14%">PASAJEROS</th>
            <th style="width: 14%">PROVEEDOR</th>
            <th style="width: 14%">RECOGER EN</th>
            <th style="width: 14%">DEJAR EN</th>
            <th style="width: 14%">DETALLE RECORRIDO</th>
            <th style="width: 14%">OBSERVACION</th>
            <th style="width: 14%">TOTAL COBRADO</th>
            <th style="width: 14%">TOTAL PAGADO</th>
            <th style="width: 14%">UTILIDAD</th>
            <th style="width: 14%">RENTABILIDAD</th>
            <th style="width: 14%">NOVEDAD</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $total_facturado = 0;
            $total_costo = 0;
            $total_utilidad = 0;
            $contar_facturados = 0;
            $contar = 1;
            $block = '';
            $rentabilidad_sum = 0;
          ?>
          @foreach($facturacion as $facturac)
            <?php

              $rentabilidad = 0;
              $total_facturado = $total_facturado + floatval($facturac->total_cobrado);
              $total_costo = $total_costo + floatval($facturac->total_pagado);
              $total_utilidad = $total_utilidad + floatval($facturac->utilidad);
              $color = '';
              $estado = '';

              $rentability_sum = 0;

              $rentability = (floatval($facturac->utilidad)/floatval($facturac->total_cobrado))*100;
              $rentability_sum = $rentability_sum + $rentability;
              if ($rentability>=30) {
                $class = 'green';
              }else if ($rentability<30 && $rentability>20) {
                $class = 'blue';
              }else if ($rentability<=20) {
                $class = 'red';
              }

            ?>
            <tr class="{{$class}}">
              <td>{{$contar}}</td>
              <td>{{$facturac->fecha_servicio}}</td>
              <td>{{$facturac->numero_planilla}}</td>
              <td>
                <?php

      						$pax = explode('/',$facturac->pasajeros);

      						for ($i=0; $i < count($pax); $i++) {

      							$pasajeros[$i] = explode(',', $pax[$i]);

      						}

      						for ($i=0; $i < count($pax)-1; $i++) {

      							for ($j=0; $j < count($pasajeros[$i]); $j++) {

      								if ($j===0) {
										$nombre = $pasajeros[$i][$j];
									}

									if ($j===1) {
										$celular = $pasajeros[$i][$j];
									}

									if ($j===2) {
										$email = $pasajeros[$i][$j];
									}

									if ($j===3) {
										$nivel = $pasajeros[$i][$j];
									}

      							}

								if (!isset($celular)){
									$celular = "";
								}

								if (!isset($nombre)){
									$nombre = "";
								}

								if (!isset($email)){
									$email = "";
								}

								if (!isset($nivel)){
									$nivel = "";
								}

      							echo '<a href title="'.$celular.'">'.$nombre.'</a><br><a href title="'.$email.'">'.$nivel.'</a>';

      						}
      					?>
              </td>
              <td><a href="#">{{$facturac->prazonsocial.'</a><br><a href="#">'.$facturac->nombre_completo}}</a></td>
              <td>{{$facturac->recoger_en}}</td>
              <td>{{$facturac->dejar_en}}</td>
              <td>{{$facturac->detalle_recorrido}}</td>
              <td>{{$facturac->observacion}}</td>
              <td>$ {{number_format($facturac->total_cobrado)}}</td>
              <td>$ {{number_format($facturac->total_pagado)}}</td>
              <td>$ {{number_format($facturac->utilidad)}}</td>
              <td>
                <?php

                  $rentabilidad = (floatval($facturac->utilidad)/floatval($facturac->total_cobrado))*100;
                  $rentabilidad_sum = $rentabilidad_sum + $rentabilidad;
                  if ($rentabilidad>=30) {
                    $color = '#2ab52c';
                  }else if ($rentabilidad<30 && $rentabilidad>20) {
                    $color = '#29bbde';
                  }else if ($rentabilidad<=20) {
                    $color = '#ec3939';
                  }

                  if ($facturac->facturado==1) {
                    $estado = 'disabled';
                    $contar_facturados++;
                  }

                ?>
                <a style="color: {{$color}}" data-id="{{$facturac->id}}" class="btn btn-default input-font bolder @if(intval($facturac->liquidado_autorizado)===1){{'disabled'}}@endif{{ $estado}}">
                  <span style="display: inline-block; vertical-align: top; margin-top: 3px; width: 30px">
                    {{round((floatval($facturac->utilidad)/floatval($facturac->total_cobrado))*100,1)}}%
                  </span>
                  <span style="display: inline-block; vertical-align: top; width: 30px">
                    <input style="float: right" data-id="{{$facturac->id}}" type="checkbox" class="chk_autorizar" @if(intval($facturac->liquidado_autorizado)===1){{'checked check="true"'}}@else{{'check="false"'}}@endif>
                  </span>
                </a>
            </td>
            <td>
              @if($facturac->id_reconfirmacion!=null)
              <a data-id="{{$facturac->id}}" href="#" class="ver_novedad btn"><small>NOVEDAD</small></a>
              @else
              <a class="ver_novedad btn-list-table btn btn-default disabled" style="background: gray;"><small>NOVEDAD</small></a>
              @endif
            </td>
            </tr>
            <?php $contar++ ;?>
          @endforeach
        </tbody>
      </table>
      <?php
        if (intval($contar)===intval($contar_facturados)) {
          $block = 'disabled';
        }
      ?>
      <div class="col-lg-4">
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>TOTALES</strong>
            </div>
            <div class="panel-body">
              <table class="table table-bordered" style="margin-bottom: 10px">
                <tbody>
                  <tr>
                    <td><b>TOTAL FACTURADO AUTORIZADO</b></td>
                    <td><b>$ {{number_format($total_facturado)}}</b></td>
                  </tr>
                  <tr>
                    <td>TOTAL COSTO AUTORIZADO</td>
                    <td>$ {{number_format($total_costo)}}</td>
                  </tr>
                  <tr>
                    <td>TOTAL UTILIDAD AUTORIZADO</td>
                    <td>$ {{number_format($total_utilidad)}}</td>
                  </tr>
                  <tr>
                    <td>TOTAL OTROS INGRESOS</td>
                    <td>$ {{number_format($liquidacion_servicios->otros_ingresos)}}</td>
                  </tr>
                  <tr>
                    <td>TOTAL OTROS COSTOS</td>
                    <td>$ {{number_format($liquidacion_servicios->otros_costos)}}</td>
                  </tr>
                  <tr>
                    <td>PROMEDIO DE RENTABILIDAD</td>


                    <td>{{round(($liquidacion_servicios->total_utilidad/$liquidacion_servicios->total_facturado_cliente)*100,2)}} %</td>
                  </tr>
                  <tr>
                    <td>OBSERVACIONES</td>
                    <td>
                      <textarea rows="5" class="form-control input-font" disabled="disabled">{{$liquidacion_servicios->observaciones}}</textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
              @if($permisos->facturacion->autorizar->autorizar==='on')
                  <a check="false" id="seleccionar_todo" class="btn btn-info input-font btn-icon {{$block}}">SELECCIONAR TODO<i class="fa fa-square-o icon-btn"></i></a>
                  <a data-divide="false" data-id="{{$liquidacion_servicios->id}}" id="autorizar_servicios" class="btn btn-primary input-font btn-icon {{$block}}">AUTORIZAR<i class="fa fa-sign-in icon-btn"></i></a>
              @endif

              @if($permisos->facturacion->autorizar->anular==='on')
                  <a data-id="{{$liquidacion_servicios->id}}" id="anular_preliquidacion" class="btn btn-danger input-font btn-icon {{$block}}">ANULAR<i class="fa fa-close icon-btn"></i></a>
              @endif
            </div>
          </div>
          <a onClick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="fa fa-reply icon-btn"></i></a>
        </div>
      </div>
    </div>

    <div class="novedad_container hidden">
      <div class="col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <strong>NOVEDAD</strong><i id="cerrar_alerta" style="float: right; font-weight:100" class="fa fa-close"></i>
          </div>
          <div class="panel-body">
                <h4 class="list-group-item-heading" id="seleccion_opcion"></h4>
                <small style="font-size: 12px" class="text-success" id="created_at"></small><br>
                <small style="font-size: 12px" class="text-info" id="usuario_novedad"></small><br>
                <span class="input-font" id="descripcion"></span><br>
          </div>
          <div class="panel-footer">
            <a id="exportarpdf" class="btn btn-danger btn-icon">PDF<i class="fa fa-file-pdf-o icon-btn"></i></a>
          </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/facturacion.js')}}"></script>
    <script>
      function goBack(){
          window.history.back();
      }

      $('#verdeButon').click(function(){

        if ($(this).prop("checked")) {

          $('.green').removeClass('hidden');
          //$('.green').addClass('hidden');
          //$('.blue').addClass('hidden');

          if ($('#azulButon').prop("checked")) {
            $('.blue').removeClass('hidden');
          }else{
            $('.blue').addClass('hidden');
          }

          if ($('#rojoButon').prop("checked")) {
            $('.red').removeClass('hidden');
          }else{
            $('.red').addClass('hidden');
          }

        }else{

          $('.green').addClass('hidden');

          if ($('#azulButon').prop("checked")) {
            $('.blue').removeClass('hidden');
            console.log('estooooo')
          }

          if ($('#rojoButon').prop("checked")) {
            $('.rojo').removeClass('hidden');
          }

          if( !($('#azulButon').prop("checked")) && !($('#rojoButon').prop("checked")) && !($('#verdeButon').prop("checked")) ){

            $('.green').removeClass('hidden');
            $('.blue').removeClass('hidden');
            $('.red').removeClass('hidden');
          }


          //$('.blue').addClass('hidden');

        }

      });

      $('#azulButon').click(function(){

        if ($(this).prop("checked")) {

          $('.blue').removeClass('hidden');
          //$('.green').addClass('hidden');
          //$('.blue').addClass('hidden');

          if ($('#verdeButon').prop("checked")) {
            $('.green').removeClass('hidden');
          }else{
            $('.green').addClass('hidden');
          }

          if ($('#rojoButon').prop("checked")) {
            $('.red').removeClass('hidden');
          }else{
            $('.red').addClass('hidden');
          }

        }else{

          $('.blue').addClass('hidden');

          if ($('#verdeButon').prop("checked")) {
            $('.green').removeClass('hidden');
            console.log('estooooo')
          }

          if ($('#rojoButon').prop("checked")) {
            $('.rojo').removeClass('hidden');
          }

          if( !($('#azulButon').prop("checked")) && !($('#rojoButon').prop("checked")) && !($('#verdeButon').prop("checked")) ){
            console.log('ninguno check')
            $('.green').removeClass('hidden');
            $('.blue').removeClass('hidden');
            $('.red').removeClass('hidden');
          }

          //$('.blue').addClass('hidden');

        }

      });

      $('#rojoButon').change(function () {

        if ($(this).prop("checked")) {

          $('.red').removeClass('hidden');
          //$('.green').addClass('hidden');
          //$('.blue').addClass('hidden');

          if ($('#verdeButon').prop("checked")) {
            $('.green').removeClass('hidden');
          }else{
            $('.green').addClass('hidden');
          }

          if ($('#azulButon').prop("checked")) {
            $('.blue').removeClass('hidden');
          }else{
            $('.blue').addClass('hidden');
          }

        }else{

          $('.red').addClass('hidden');

          if ($('#verdeButon').prop("checked")) {
            $('.green').removeClass('hidden');
            console.log('estooooo')
          }

          if ($('#azulButon').prop("checked")) {
            $('.blue').removeClass('hidden');
          }

          if( !($('#azulButon').prop("checked")) && !($('#rojoButon').prop("checked")) && !($('#verdeButon').prop("checked")) ){
            console.log('ninguno check')
            $('.green').removeClass('hidden');
            $('.blue').removeClass('hidden');
            $('.red').removeClass('hidden');
          }

          //$('.blue').addClass('hidden');

        }

        //console.log('test');

      });


    </script>
  </body>
</html>
