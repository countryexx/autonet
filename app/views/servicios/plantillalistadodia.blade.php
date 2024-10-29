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
    <br>
      <table class="excel">
        <thead>
          <tr>
            <th></th>
            <th>NOMBRE COMPLETO</th>
            <th>SUB AREA</th>
            <th>HORA</th>
            <th>CONDUCTOR</th>
            <th>PLACA</th>
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
                              '<td>'.strtoupper($value->nombres).' '.strtoupper($value->apellidos).'</td>'.
                              '<td>'.strtoupper($value->sub_area).'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.$servicios[$i]->nombre_completo.'</td>'.
                              '<td>'.$servicios[$i]->placa.'</td>'.
                              '</tr>';
                              $contador++;
                     }
                   }
               }
          ?>
        </tbody>
      </table>
  </body>
</html>
