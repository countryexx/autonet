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
            <th>CAMPAÑA</th>
            <th>RUTA</th>            
            <th>FECHA</th>
            <th>HORA</th>
            <th>TIPO SERVICIO</th>
            <th>TIPO DE VEHICULO</th>
            <th>SUBCENTRO DE COSTO</th>
            <th>UNITARIO COBRADO</th>
            <th>NUMERO DE PLANILLA</th>
            <th>DIRECCION</th>
            <th>BARRIO</th>

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
                              '<td>'.$servicios[$i]->detalle_recorrido.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.$servicios[$i]->tipo_servicio.'</td>'.
                              '<td>'.$servicios[$i]->tipo_vehiculo.'</td>'.
                              '<td>'.$servicios[$i]->nombresubcentro.'</td>'.
                              '<td>'.$servicios[$i]->unitario_cobrado.'</td>'.
                              '<td>'.$servicios[$i]->numero_planilla.'</td>'.
                              '<td>'.strtoupper(trim($value->direccion)).'</td>'.
                              '<td>'.strtoupper(trim($value->barrio)).'</td>'.                           
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
