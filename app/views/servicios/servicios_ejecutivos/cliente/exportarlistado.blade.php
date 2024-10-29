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
      <td valign="middle" align="center">ORDENES DE SERVICIOS</td>
      <td valign="middle" align="center">DESCARGADO: {{date('Y-m-d')}}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td valign="middle" align="center">GESTION OPERATIVA</td>
    </tr>
    <br>
    <table class="excel">
      <thead>
        <tr>
          <th style="color: white" width="7" valign="middle" align="center">No</th>
          <th width="12" valign="middle" align="center">FECHA DE SERVICIO</th>
          <th width="17" valign="middle" align="center">HORA DE SERVICIO</th>
          <th width="16" valign="middle" align="center">SOLICITADO POR</th>
          <th width="16" valign="middle" align="center">CIUDAD</th>
          <th width="16" valign="middle" align="center">RECOGER EN</th>
          <th width="16" valign="middle" align="center">DEJAR EN</th>
          <th width="16" valign="middle" align="center">DETALLES</th>
          <th width="16" valign="middle" align="center">CENTRO DE COSTO</th>
          <th width="16" valign="middle" align="center">SUCURSAL</th>
          <th width="16" valign="middle" align="center">PASAJERO(S)</th>

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
        <?php
          $pax = explode('/', $servicio->pasajeros);
        ?>
          <tr>
            <td valign="middle" align="center">{{$k++}}</td>
            <td valign="middle" align="center">{{$servicio->fecha_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->hora_servicio}}</td>
            <td valign="middle" align="center">{{$servicio->solicitado_por}}</td>
            <td valign="middle" align="center">{{$servicio->ciudad}}</td>
            <td valign="middle" align="center">{{$servicio->recoger_en}}</td>
            <td valign="middle" align="center">{{$servicio->dejar_en}}</td>
            <td valign="middle" align="center">{{$servicio->detalle_recorrido}}</td>
            <td valign="middle" align="center">{{$servicio->centrodecosto}}</td>
            <td valign="middle" align="center">{{$servicio->sucursal}}</td>
            <td valign="middle" align="center">
              @for ($j = 0; $j < count($pax); $j++) {{$pax[$j]}} @endfor
            </td>
          </tr>

          <?php
            $total = 200000000;
          ?>
        @endforeach

      </tbody>
    </table>

  </body>
</html>
