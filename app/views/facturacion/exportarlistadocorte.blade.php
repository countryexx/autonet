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
      <td valign="middle" align="center">LIQUIDACION DE SERVICIO</td>
      <td valign="middle" align="center">EMISION: {{date('Y-m-d')}}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td valign="middle" align="center">GESTION FINANCIERA</td>
    </tr>
    <br>
    <table class="excel">
      <thead>
        <tr>
          <th style="color: white" width="7" valign="middle" align="center">No</th>
          <th width="12" valign="middle" align="center">FECHA DE SERVICIO</th>
          <th width="12" valign="middle" align="center">HORA DE SERVICIO</th>
          <th width="16" valign="middle" align="center">SOLICITADO POR</th>
          <th width="17" valign="middle" align="center">No. CONSTANCIA</th>
          <th width="16" valign="middle" align="center">NOMBRE PASAJERO</th>
          <th width="16" valign="middle" align="center">PROVEEDOR</th>
          <th width="16" valign="middle" align="center">RECOGER EN</th>
          <th width="16" valign="middle" align="center">DEJAR EN</th>
          <th width="16" valign="middle" align="center">CLIENTE</th>
          <th width="16" valign="middle" align="center">COD CENTRO COSTO</th>
          <th width="16" valign="middle" align="center">OBSERVACION</th>
          <th width="16" valign="middle" align="center">UNITARIO COBRADO</th>
          <th width="16" valign="middle" align="center">UNITARIO PAGADO</th>
          <th width="16" valign="middle" align="center">KM</th>
          <!--<th width="16" valign="middle" align="center">UTILIDAD</th>
          <th width="16" valign="middle" align="center">%RENTABILIDAD</th> -->

        </tr>
      </thead>
      <tbody>
        <?php
          $k = 1;
          $total = 0;
          $total2 = 0;
          $a=0;
          $sum = 0;
         ?>
        @foreach($servicios as $servicio)

          <tr>
            <td valign="middle" align="center">{{$k++}}</td>
            <td valign="middle" align="center">{{$servicio->fecha_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->hora_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->solicitado_por}}</td>
            <td valign="middle" align="center">{{$servicio->numero_planilla}}</td>
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
            <td valign="middle" align="center">{{$servicio->prazonproveedor}}</td>
            <!--servicio->prazonproveedor -->
            <!--<td valign="middle" align="center"></td> -->
            <td valign="middle" align="center">
              @if( ($servicio->razonsocial=='SGS COLOMBIA HOLDING BARRANQUILLA' or $servicio->razonsocial=='SGS COLOMBIA HOLDING BOGOTA') and $servicio->ruta==1 and $servicio->desde!=null)
                {{$servicio->desde}}
              @else
                {{$servicio->recoger_en}}
              @endif
            </td>
            <td valign="middle" align="center">
              @if( ($servicio->razonsocial=='SGS COLOMBIA HOLDING BARRANQUILLA' or $servicio->razonsocial=='SGS COLOMBIA HOLDING BOGOTA') and $servicio->ruta==1 and $servicio->hasta!=null)
                {{$servicio->hasta}}
              @else
                {{$servicio->dejar_en}}
              @endif
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
              {{$servicio->observacion}}
            </td>

            <td valign="middle" align="center">
              {{$servicio->total_cobrado}}
            </td>

            <td valign="middle" align="center">
              {{$servicio->total_pagado}}
            </td>

            <td valign="middle" align="center">
              {{trim($servicio->anulado_por)}}
            </td>
            <!--<td valign="middle" align="center">
                {{$servicio->utilidad}}
            </td>
            <td valign="middle" align="center">%  @if($servicio->total_cobrado !=0){{round($servicio->utilidad/$servicio->total_cobrado,3)*100}} @endif</td> -->
          </tr>

          <?php
            $total = $total+$servicio->total_cobrado;
            $total2 = $total2+$servicio->total_pagado;

            $a++;
            if($servicio->total_cobrado != 0){
              $sum = $sum + ($servicio->utilidad/$servicio->total_cobrado)*100;
            }else{
                $sum = 0;
            }
          ?>
        @endforeach

      </tbody>
    </table>

      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="border-table color-table" valign="middle" align="center">
        TOTAL COBRADO
      </td>
      <td class="border-table color-table" valign="middle" align="center">$ {{number_format($total)}}</td>
      <td valign="middle" align="center"></td>
      <!-- <td class="border-table color-table" valign="middle" align="center">
        TOTAL PAGADO
      </td>
      <td class="border-table color-table" valign="middle" align="center">$ {{number_format($total2)}}</td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td valign="middle" align="center"></td>
      <td class="border-table color-table" valign="middle" align="center">PROMEDIO DE RENTABILIDAD</td>
      <td valign="middle" align="center">{{round($sum/$a,2)}}</td>
      -->
  </body>
</html>
