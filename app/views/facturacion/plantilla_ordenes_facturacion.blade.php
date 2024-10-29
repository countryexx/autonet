<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <br>
    <br>
    <br>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td valign="middle" align="center">LIQUIDACION DE SERVICIO</td>
      <td valign="middle" align="center" style="text-align:center">EMISION: {{date('Y-m-d')}} </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td valign="middle" align="center">GESTION FINANCIERA</td>
    </tr>
    <br>
    <table class="excel">
      <thead>
        <tr>
          <th style="color: white" width="7" valign="middle" align="center">No</th>
          <th width="12" valign="middle" align="center">No. <br> FACTURA</th>
          <th width="12" valign="middle" align="center">FECHA DE SERVICIO</th>
          <th width="17" valign="middle" align="center">No. CONSTANCIA</th>
          <th width="12" valign="middle" align="center">VALOR SERVICIO</th>
          <th width="16" valign="middle" align="center">NOMBRE PASAJERO</th>
          <th width="17" valign="middle" align="center">EMPRESA / FILIAL</th>
          <th width="17" valign="middle" align="center">COD CENTRO DE COSTO</th>
          <th width="17" valign="middle" align="center">RECOGER EN</th>
          <th width="17" valign="middle" align="center">DEJAR EN</th>
          <th width="17" valign="middle" align="center">CIUDAD</th>
          <th width="19" valign="middle" align="center">OBSERVACIONES (NOVEDADES)</th>
          <th width="19" valign="middle" align="center">SOLICITADO POR</th>
        </tr>
      </thead>
      <tbody>
<?php
          $k = 1;
          $total = 0;
         ?>
        @foreach($servicios as $servicio)
          <tr>
            <td valign="middle" align="center">{{$k++}}</td>
            <td valign="middle" align="center">{{$servicio->numero_factura}}</td>
            <td valign="middle" align="center">{{$servicio->fecha_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->numero_planilla}}</td>
            <td valign="middle" align="center">$ {{$servicio->total_cobrado}}</td>
            <td valign="middle" align="center">
              <?php

                    $pax = explode('/',$servicio->pasajeros);

                    for ($i=0; $i < count($pax); $i++) {
                        $pasajeros[$i] = explode(',', $pax[$i]);
                    }

                    for ($i=0; $i < count($pax)-1; $i++) {

                        for ($j=0; $j < count($pasajeros[$i]); $j++) {

                            if ($j===0) {
                                $nombre = $pasajeros[$i][$j].'<br>';
                            }

                        }
                        echo $nombre;

                    }

              ?>
            </td>
            <td valign="middle" align="center">
              @if($servicio->razonsocial===$servicio->nombresubcentro)
                {{$servicio->razonsocial}}
              @elseif($servicio->razonsocial!=$servicio->nombresubcentro)
                {{$servicio->razonsocial.'/'.$servicio->nombresubcentro}}
              @endif
            </td>
            <td valign="middle" align="center">
              {{$servicio->cod_centro_costo}}
            </td>
            <td valign="middle" align="center">
              {{$servicio->recoger_en}}
            </td>
            <td valign="middle" align="center">
              {{$servicio->dejar_en}}
            </td>
            <td valign="middle" align="center">
              {{$servicio->ciudad}}
            </td>
            <td valign="middle" align="center">
              {{$servicio->observacion}}
            </td>
            <td valign="middle" align="center">
                {{$servicio->solicitado_por}}
            </td>
          </tr>

<?php $total = $total+$servicio->total_cobrado; ?>
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="border-table color-table">
            TOTAL COBRADO
          </td>
          <td class="border-table color-table" valign="middle" align="center">$ {{$total}}</td>
        </tr>
      </tbody>
    </table>



  </body>
</html>
