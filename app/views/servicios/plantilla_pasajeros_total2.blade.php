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
            <tr>
              <th align="center"><strong>NO</strong></th>
              <th align="center"><strong>FECHA</strong></th>
              <th align="center"><strong>NOMBRES</strong></th>
              <th align="center"><strong>EMPLOY ID</strong></th>
              <th align="center"><strong>TELEFONO</strong></th>
              <th align="center"><strong>RUTA</strong></th>
              <th align="center"><strong>DIRECCION</strong></th>
              <th align="center"><strong>BARRIO</strong></th>
              <th align="center"><strong>CARGO</strong></th>
              <th align="center"><strong>AREA</strong></th>
              <th align="center"><strong>SUB AREA</strong></th>
              <th align="center"><strong>HORARIO</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php
                 $contador = 1;
                 for ($i=0; $i <count($servicios) ; $i++) {
                     $json = json_decode($servicios[$i]->pasajeros_ruta);
                     if(is_array($json)){
                     foreach ($json as $key => $value) {
                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->nombres)).'</td>'.
                              '<td>'.$value->apellidos.'</td>'.
                              '<td>'.$value->cedula.'</td>'.
                              '<td>'.$servicios[$i]->detalle_recorrido.'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->direccion)).'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->barrio)).'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->cargo)).'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->area)).'</td>'.
                              '<td>'.strtoupper(str_replace('&nbsp;','',$value->sub_area)).'</td>'.
                              '<td>'.strtoupper($value->hora).'</td>'.
                              '</tr>';
                              $contador++;
                     }
                     }
                 }
            ?>
          </tbody>
        </table>
    </div>
  </body>
</html>
