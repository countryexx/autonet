<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <td>

          </td>
        </tr>
        <tr>
          <td>CORTE DE PROVEEDORES DESDE EL {{$fecha_inicial.' HASTA EL '.$fecha_final}}</td>
        </tr>
        <tr>
          <td>

          </td>
        </tr>
        <tr>          
          <th valign="middle" align="center" style="border: 2px solid gray">PROVEEDOR</th>
          <th valign="middle" align="center" style="border: 2px solid gray">CENTRO DE COSTO</th>
          <th valign="middle" align="center" style="border: 2px solid gray">SUBCENTRO DE COSTO</th>
          <th valign="middle" align="center" style="border: 2px solid gray">FECHA DE SERVICIO</th>
          <th valign="middle" align="center" style="border: 2px solid gray">TOTAL PAGADO</th>
        </tr>
      </thead>
      <tbody>
        @foreach($servicios as $servicio)
          <tr>
            <td valign="middle" align="center" style="border: 2px solid gray">{{$servicio->nombre_proveedor}}</td>
            <td valign="middle" align="center" style="border: 2px solid gray">{{$servicio->razonsocial}}</td>
            <td valign="middle" align="center" style="border: 2px solid gray">{{$servicio->nombresubcentro}}</td>
            <td valign="middle" align="center" style="border: 2px solid gray">{{$servicio->fecha_servicio}}</td>
            <td valign="middle" align="center" style="border: 2px solid gray">{{$servicio->total_pagado}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
