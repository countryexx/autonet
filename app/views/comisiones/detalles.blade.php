<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Detalles Comision</title>
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')

    <?php

      $consulta = "SELECT ordenes_facturacion.id, ordenes_facturacion.numero_factura, centrosdecosto.razonsocial, subcentrosdecosto.nombresubcentro, ".
                  "ordenes_facturacion.tipo_orden, otros_servicios_detalles.id as otrosid, ordenes_facturacion.total_facturado_cliente, ".
                  "ordenes_facturacion.total_costo, ordenes_facturacion.total_utilidad FROM ".
                      "ordenes_facturacion ".
                  "left join centrosdecosto on ordenes_facturacion.centrodecosto_id = centrosdecosto.id ".
                  "left join subcentrosdecosto on ordenes_facturacion.subcentrodecosto_id = subcentrosdecosto.id ".
                  "left join otros_servicios_detalles on ordenes_facturacion.id = otros_servicios_detalles.id_factura ".
                  "WHERE ".
                      "ordenes_facturacion.id IN (".$pagos_comisiones->arrayidordenesfactura.")";

      $facturas = DB::select($consulta);
      $totales_asesor = 0;
      $totales_tercero = 0;
      $totales_coordinador = 0;
      $totales_aotour = 0;

    ?>

    <div class="col-lg-12">
      @if(intval($pagos_comisiones->tipo_facturas)===1)
        @if(intval($pagos_comisiones->tipo_comision)===1)
          <?php $nombre_completo = DB::table('asesor_comercial')->where('id',$pagos_comisiones->idpersona)->pluck('nombre_completo'); ?>
          <h3 class="h_titulo">TRANSPORTE - ASESOR COMERCIAL: {{$nombre_completo}}</h3>
        @elseif(intval($pagos_comisiones->tipo_comision)===2)
          <?php $nombre_completo = DB::table('terceros')->where('id',$pagos_comisiones->idpersona)->pluck('nombre_completo'); ?>
          <h3 class="h_titulo">TRANSPORTE - ASESOR EXTERNO: {{$nombre_completo}}</h3>
        @endif
      @elseif(intval($pagos_comisiones->tipo_facturas)===2)
        @if(intval($pagos_comisiones->tipo_comision)===1)
          <?php $nombre_completo = DB::table('asesor_comercial')->where('id',$pagos_comisiones->idpersona)->pluck('nombre_completo'); ?>
          <h3 class="h_titulo">TURISMO - ASESOR COMERCIAL: {{$nombre_completo}}</h3>
        @elseif(intval($pagos_comisiones->tipo_comision)===2)
          <?php $nombre_completo = DB::table('terceros')->where('id',$pagos_comisiones->idpersona)->pluck('nombre_completo'); ?>
          <h3 class="h_titulo">TURISMO - ASESOR EXTERNO: {{$nombre_completo}}</h3>
        @elseif(intval($pagos_comisiones->tipo_comision)===3)
          <h3 class="h_titulo">TURISMO - COORDINADOR</h3>
        @endif
      @endif
      <table style="margin-bottom: 0px" id="example3" class="table table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>#FACT</th>
            <th>CENTRO DE COSTO</th>
            <th>PRODUCTO</th>
            <th>VALOR</th>
            <th>DERIVADOS</th>
            <th>IMPUESTO</th>
            <th>OTRAS TASAS</th>
            <th>TASA AERO</th>
            <th>COSTO</th>
            <th>T.A</th>
            <th>IVA T.A</th>
            <th>OTROS</th>
            <th>FACTURADO</th>
            <th>GASTOS BANCARIOS</th>
            <th>T.A REAL</th>
            @if(intval($pagos_comisiones->tipo_comision)===2)<th>TERCERO</th>@endif
            @if(intval($pagos_comisiones->tipo_comision)===1)<th>ASESOR</th>@endif
            @if(intval($pagos_comisiones->tipo_comision)===3)<th>COORDINADOR</th>@endif
            <th>AOTOUR</th>
            <th>DETALLES</th>
          </tr>
        </thead>
        <tbody>

          @foreach($facturas as $factura)

            <?php

              //INICIALIZAR VALORES EN 0
              $producto = '';
              $valor = 0;
              $iva = 0;
              $impuesto = 0;
              $otras_tasas = 0;
              $tasa_aero = 0;
              $costo = 0;
              $ta = 0;
              $ivata = 0;
              $otros = 0;
              $facturado = 0;
              $gastos_bancarios = 0;
              $tareal = 0;
              $asesor = 0;
              $tercero = 0;
              $coordinador = 0;
              $aotour = 0;
              $productoAll = '';

              //SI LA FACTURA ES DE TRANSPORTE ENTONCES
              if (intval($factura->tipo_orden)===1) {

                $producto = 'TRANSPORTE';
                $facturado = $factura->total_facturado_cliente;
                $costo = $factura->total_costo;
                $tareal = $factura->total_utilidad;
                if (intval($pagos_comisiones->tipo_comision)===1) {
                  $asesor = $tareal*0.2;
                  $aotour = $tareal - $asesor;
                }else if (intval($pagos_comisiones->tipo_comision)===2) {
                  $tercero = $tareal*0.2;
                  $aotour = $tareal - $tercero;
                }
              //SI EL TIPO DE FACTURA ES OTROS ENTONCES
              }else if(intval($factura->tipo_orden)===2){
                //BUSQUE EL SERVICIO CON ESE NUMERO DE FACTURA
                $otros_servicios_detalles = DB::table('otros_servicios_detalles')->where('id',$factura->otrosid)->first();
                //BUSQUE LOS PRODUCTOS QUE ESTAN EN ESE SERVICIO
                $otros_servicios = DB::table('otros_servicios')->where('id_servicios_detalles',$otros_servicios_detalles->id)->get();
                //CALCULE EL VALOR POR CADA SERVICIO QUE ESTE DENTRO DEL MISMO
                foreach ($otros_servicios as $value) {
                  //ASIGNACION DE VALORES TRAIDOS DE LA CONSULTA A LA BD
                  $producto = $value->producto;
                  $productoAll .= $value->producto;
                  $valor = $valor + floatval($value->valor);
                  $iva = $iva + floatval($value->iva_servicio);
                  $impuesto = $impuesto + floatval($value->impuesto);
                  $otras_tasas = $otras_tasas + floatval($value->otras_tasas);
                  $tasa_aero = $tasa_aero + floatval($value->tasa_aero);
                  $costo = $valor+$iva+$impuesto+$otras_tasas+$tasa_aero;
                  $ta = $ta+floatval($value->valor_comision);
                  $ivata = $ivata+floatval($value->iva_comision);
                  $otros = $otros+floatval($value->otros);
                  if (intval($otros_servicios_detalles->pagado_proveedor)===2) {
                    $gastos_bancarios = ($costo*2.29)/100;
                  }else{
                    $gastos_bancarios = 0;
                  }

                  $tareal = $ta+$otros-$gastos_bancarios;

                  //SI EL PRODUCTO SON TIQUETES AEREOS ENTONCES
                  if ($producto==='TIQUETES AEREOS') {
                    //SI EL PRODUCTO TIENE TERCERO ENTONCES
                    if (intval($otros_servicios_detalles->tercero)===1) {
                      $tercero = ($ta-$gastos_bancarios)*0.7;
                    //SI NO TIENE TERCERO ENTONCES ES IGUAL A CERO
                    }else{
                      $tercero = 0;
                    }
                    //VALOR CALCULADO PARA EL ASESOR COMERCIAL
                    $asesor = ($ta+$otros-$gastos_bancarios-$tercero)*0.2;
                  //SI NO SON TIQUETES AEREOS SE HACEN DE LA SIGUIENTE FORMA
                  }else{
                    //SI EL PRODUCTO TIENE TERCERO
                    if (intval($otros_servicios_detalles->tercero)===1) {
                      //$tercero = ((floatval($factura->total_facturado_cliente)-$gastos_bancarios)*0.1)*0.7;
                      $tercero = ((floatval($factura->total_facturado_cliente)*0.1)-$gastos_bancarios)*0.7;
                    }else{
                      //SI NO TIENE TERCERO ENTONCES ES IGUAL A CER0
                      $tercero = 0;
                    }
                    //VALOR DEL ASESOR
                    $asesor = ($tareal-$tercero)*0.2;
                  }
                  //VALOR DEL COORDINADOR
                  $coordinador = ($ta+$otros-$gastos_bancarios-$tercero-$asesor)*0.025;

                }

                $aotour = $tareal-$tercero-$asesor-$coordinador;
              }


            ?>

            <tr>
              <td>{{$factura->numero_factura}}</td>
              <td>
                @if($factura->razonsocial===$factura->nombresubcentro)
                  {{$factura->razonsocial}}
                @elseif($factura->razonsocial==='PERSONA_NATURAL')
                  {{$factura->nombresubcentro}}
                @elseif($factura->razonsocial!=$factura->nombresubcentro)
                  {{$factura->razonsocial.' / '.$factura->nombresubcentro}}
                @endif
              </td>
              <td>{{$productoAll}}</td>
              <td>$ {{number_format($valor,0,',','.')}}</td>
              <td>$ {{number_format($iva,0,',','.')}}</td>
              <td>$ {{number_format($impuesto,0,',','.')}}</td>
              <td>$ {{number_format($otras_tasas,0,',','.')}}</td>
              <td>$ {{number_format($tasa_aero,0,',','.')}}</td>
              <td>$ {{number_format($costo,0,',','.')}}</td>
              <td>$ {{number_format($ta,0,',','.')}}</td>
              <td>$ {{number_format($ivata,0,',','.')}}</td>
              <td>$ {{number_format($otros,0,',','.')}}</td>
              <td>$ {{number_format($factura->total_facturado_cliente,0,',','.')}}</td>
              <td>$ {{number_format($gastos_bancarios,0,',','.')}}</td>
              <td>$ {{number_format($tareal,0,',','.')}}</td>
              @if(intval($pagos_comisiones->tipo_comision)===2)<td class="success"><span class="bolder text-success">$ {{number_format($tercero,0,',','.')}}</span></td>@endif
              @if(intval($pagos_comisiones->tipo_comision)===1)<td class="danger"><span class="bolder text-danger">$ {{number_format($asesor,0,',','.')}}</span></td>@endif
              @if(intval($pagos_comisiones->tipo_comision)===3)<td class="info"><span class="bolder text-info">$ {{number_format($coordinador,0,',','.')}}</span></td>@endif
              <td class="warning"><span class="text-warning bolder">$ {{number_format($aotour,0,',','.')}}</span></td>
              <td><a href="../../facturacion/verdetalle/{{$factura->id}}" class="btn btn-primary btn-list-table">DETALLES</a></td>
            </tr>
            <?php
              $totales_asesor = $totales_asesor + $asesor;
              $totales_aotour = $totales_aotour + $aotour;
              $totales_tercero = $totales_tercero + $tercero;
              $totales_coordinador = $totales_coordinador + $coordinador;
            ?>
          @endforeach

          <?php echo '<tr>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>'.
                     '<td></td>';

                     if (intval($pagos_comisiones->tipo_comision)===1) {
                       echo '<td class="danger text-danger bolder">$'.number_format($totales_asesor,0,',','.').'</td>';
                     }

                     if (intval($pagos_comisiones->tipo_comision)===2) {
                       echo '<td class="success text-success bolder">$'.number_format($totales_tercero,0,',','.').'</td>';
                     }

                     if (intval($pagos_comisiones->tipo_comision)===3) {
                       echo '<td class="info text-info bolder">$'.number_format($totales_coordinador,0,',','.').'</td>';
                     }

                     echo '<td class="warning text-warning bolder">$'.number_format($totales_aotour,0,',','.').'</td>';
                     echo '<td></td>';
                     '</tr>';
        ?>
        </tbody>
        <tfoot>
          <th>#FACT</th>
          <th>CENTRO DE COSTO</th>
          <th>PRODUCTO</th>
          <th>VALOR</th>
          <th>IVA</th>
          <th>IMPUESTO</th>
          <th>OTRAS TASAS</th>
          <th>TASA AERO</th>
          <th>COSTO</th>
          <th>T.A</th>
          <th>IVA T.A</th>
          <th>OTROS</th>
          <th>FACTURADO</th>
          <th>GASTOS BANCARIOS</th>
          <th>T.A REAL</th>
          @if(intval($pagos_comisiones->tipo_comision)===2)<th>TERCERO</th>@endif
          @if(intval($pagos_comisiones->tipo_comision)===1)<th>ASESOR</th>@endif
          @if(intval($pagos_comisiones->tipo_comision)===3)<th>COORDINADOR</th>@endif
          <th>AOTOUR</th>
          <th>DETALLES</th>
        </tfoot>
      </table>

      <div style="margin-top: 15px;" class="col-lg-4" id="pago_comisiones">
        <div class="row">
          <div class="panel panel-default ui-draggable" style="position: relative;">
  					<div class="panel-heading ui-draggable-handle">
              <strong>TOTALES</strong>
            </div>
  					<div class="panel-body">
  						<table style="margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);" class="table table-bordered hover">
  						    <tbody><tr>
  						    	<td>TOTAL COMISIONES</td>
  						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_comisiones">$ {{number_format($pagos_comisiones->total_comision)}}</label></td>
  						    </tr>
  						    <tr>
  						    	<td>DESCUENTO RETEFUENTE</td>
  						    	<td><input class="form-control input-font" id="descuento_retefuente" value="{{$pagos_comisiones->descuento_retefuente}}" disabled></td>
  						    </tr>
  						    <tr id="valor_retefuente">
  						    	<td>VALOR RETEFUENTE</td>
  						    	<td><input disabled="" class="form-control input-font valor_retefuente" value="$ {{number_format($pagos_comisiones->valor_retefuente)}}" disabled></td>
  						    </tr>
  						</tbody></table>
  						<table class="table table-bordered hover descuentos hidden" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                @if($pagos_comisiones->detalles_descuentos!='[]')
                <table class="table table-bordered hover descuentos" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                  <tbody>
                    <?php
                      $array = json_decode($pagos_comisiones->detalles_descuentos);

                      foreach ($array as $key => $value) {
                        echo '<tr><td>';
                        echo '<textarea disabled rows="2" class="form-control input-font detalle_text" style="text-transform: uppercase;">';
                        echo $value->detalle.'</textarea></td><td>';
                        echo '<div class="input-group">';
                        echo '<input type="text" class="form-control input-font valor_descuento" placeholder="DIGITE EL VALOR" value="$ '.number_format($value->valor).'" disabled><div class="input-group-addon">';
                        echo '<i class="fa fa-usd"></i></div></div></td></tr>';
                      }

                    ?>
                  </tbody>
                </table>
                @endif
  						</table>
  						<table class="table table-bordered hover" style="margin-bottom: 0px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
  						    <tbody><tr>
  						    	<td style="width: 270px;">TOTAL OTROS DESCUENTOS</td>
  						    	<td><input class="form-control input-font" id="otros_descuentos" value="$ {{number_format($pagos_comisiones->otros_descuentos)}}" disabled></td>
  						    </tr>
  								<tr class="norealizado">
  						    	<td>TOTAL PAGADO</td>
  						    	<td><input class="form-control input-font" id="totales_pagado" disabled="" value="$ {{number_format($pagos_comisiones->total_a_pagar)}}"></td>
  						    </tr>
  								<tr class="realizado hidden">
  						    	<td>TOTAL PAGADO</td>
  						    	<td><label style="margin-bottom: 0px" class="span-total" id="totales_todo">$ 0</label></td>
  						    </tr>
                  <tr>
  						    	<td>FECHA PAGO</td>
  						    	<td>
                      <div class="input-group">
                          <div class="input-group date" id="datetimepicker1">
                              <input name="fecha_pago" style="width: 89px;" type="text" class="form-control input-font" value="{{$pagos_comisiones->fecha_pago}}" disabled>
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
                          </div>
                      </div>
                    </td>
  						    </tr>
  						</tbody>
            </table>
  					</div>
  				</div>
        </div>
		  </div>

      <div class="col-lg-12" style="margin-bottom: 20px">
        <div class="row">
          <a class="btn btn-success btn-icon" type="button" onclick="tableToExcel('example3', 'TabladeComisiones')">EXCEL<i class="fa fa-file-excel-o icon-btn" aria-hidden="true"></i></a>
          <a onclick="goBack()" class="btn btn-info btn-icon">VOLVER<i class="fa fa-reply icon-btn"></i></a>
        </div>
      </div>
    </div>

    @include('scripts.scripts')
    <script>
      function goBack(){
          window.history.back();
      }
    </script>
    <script src="{{url('jquery/comisiones.js')}}"></script>
    <script>
    var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
        window.location.href = uri + base64(format(template, ctx))
      }
    })()


</script>
  </body>
</html>
