<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
    @include('scripts.styles')
  </head>
  <body>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 '>
        <table class="excel">
          <thead>
            <tr style="color: #fff; background: black;">
              <th align="center"><strong>#</strong></th>
              <th align="center"><strong>CONSECUTIVO</strong></th>
              <th align="center"><strong>PROVEEDOR</strong></th>
              <th align="center"><strong>FECHA DEL PAGO</strong></th>
              <th align="center"><strong>TOTAL PAGADO</strong></th>
              <th align="center"><strong>RETEFUENTE</strong></th>
              <th align="center"><strong>PRESTAMOS</strong></th>
              <th align="center"><strong>TOTAL NETO</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php
                 $contador = 1;
                 for ($i=0; $i <count($servicios) ; $i++) {
                     //$json = json_decode($servicios[$i]->pasajeros_ruta);
                       if($servicios[$i]->autorizado==1){
                          $ruta = '<td>AUTORIZADO</td>';
                        }else{
                          $ruta = '<td>POR AUTORIZAR</td>';
                        }
                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios[$i]->id.'</td>'.
                              '<td>'.$servicios[$i]->razonsocial.'</td>'.
                              '<td>'.$servicios[$i]->fecha_pago.'</td>'.
                              '<td>'.$servicios[$i]->total_pagado.'</td>'.
                              '<td>'.$servicios[$i]->descuento_retefuente.'</td>'.
                              '<td>'.$servicios[$i]->descuento_prestamo.'</td>'.
                              '<td>'.$servicios[$i]->total_neto.'</td>'.
                              '</tr>';
                              $contador++;
                     
                 }
            ?>
          </tbody>
        </table>
    </div>
  </body>
</html>
