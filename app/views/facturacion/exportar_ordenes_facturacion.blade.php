<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <table class="excel">
      <thead>
        <tr>
          <th valign="middle" align="center">CONSECUTIVO</th>
          <th valign="middle" align="center" width="47">CENTRO DE COSTO</th>
          <th valign="middle" align="center" width="17">CIUDAD</th>
          <th valign="middle" align="center" width="22">FECHA DE EXPEDICION</th>
          <th valign="middle" align="center" width="14">FECHA INICIAL</th>
          <th valign="middle" align="center" width="14">FECHA FINAL</th>
          <th valign="middle" align="center" width="19">NUMERO FACTURA</th>
          <th valign="middle" align="center" width="13">TIPO</th>
          <th valign="middle" align="center" width="15">TOTAL CLIENTE</th>
          <th valign="middle" align="center" width="14">TOTAL COSTO</th>
          <th valign="middle" align="center" width="13">UTILIDAD</th>
          <th valign="middle" align="center" width="19">% RENTANBILIDAD</th>
        </tr>
      </thead>
      <tbody>
          <?php

            $totales_facturado_cliente = 0;
            $totales_costo = 0;
            $totales_utilidad = 0;

            foreach($ordenes_facturacion as $orden){
              $costo = 0;
              echo '<tr>';
              echo '<td valign="middle" align="center">'.$orden->consecutivo.'</td>';
              echo '<td valign="middle" align="center">'.$orden->razonsocial.'</td>';
              echo '<td style="text-align: center">'.$orden->ciudad.'</td>';
              echo '<td style="text-align: center">'.$orden->fecha_expedicion.'</td>';
              echo '<td style="text-align: center">'.$orden->fecha_inicial.'</td>';
              echo '<td style="text-align: center">'.$orden->fecha_final.'</td>';
              echo '<td style="text-align: center">'.$orden->numero_factura.'</td>';

              if (intval($orden->tipo_orden)===1) {
                $tipo = 'TRANSPORTE';
              }else if (intval($orden->tipo_orden)===2) {
                $tipo = 'TURISMO';
              }

              $costo = intval($orden->total_facturado_cliente)-intval($orden->total_utilidad);

              $totales_facturado_cliente = $totales_facturado_cliente + intval($orden->total_facturado_cliente);
              $totales_costo = $totales_costo + $costo;
              $totales_utilidad = $totales_utilidad+intval($orden->total_utilidad);

              echo '<td style="text-align: center">'.$tipo.'</td>';
              echo '<td style="text-align: center">'.intval($orden->total_facturado_cliente).'</td>';
              echo '<td style="text-align: center">'.intval($costo).'</td>';
              echo '<td style="text-align: center">'.intval($orden->total_utilidad).'</td>';

              $rentabilidad = round((intval($orden->total_utilidad)/intval($orden->total_facturado_cliente))*100);

              echo '<td style="text-align: center">%'.$rentabilidad.'</td>';
              echo '</tr>';
            }

            ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="text-align: center">{{$totales_facturado_cliente}}</td>
              <td style="text-align: center">{{$totales_costo}}</td>
              <td style="text-align: center">{{$totales_utilidad}}</td>
            </tr>
      </tbody>
    </table>
  </body>
</html>
