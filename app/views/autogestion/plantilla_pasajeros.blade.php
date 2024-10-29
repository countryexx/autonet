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
            <th>EMPLOY ID</th>
            <th>NOMBRE COMPLETO</th>
            <th>TELEFONO</th>
            <th>DIRECCIÓN</th>
            <th>BARRIO</th>
            <th>PROGRAMA</th>
            <th>HORARIO</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $contador = 1;
           foreach ($usuarios as $usuario) {

            echo '<tr>'.
              '<td>'.$contador.'</td>'.
              '<td>'.$usuario->id_empleado.'</td>'.
              '<td>'.$usuario->nombres.' '.$usuario->apellidos.'</td>'.
              '<td>'.$usuario->telefono.'</td>'.
              '<td>'.$usuario->direccion.'</td>'.
              '<td>'.$usuario->barrio.'</td>'.
              '<td>'.$usuario->programa.'</td>'.
              '<td>'.$usuario->horario.'</td>'.
            '</tr>';

              $contador++;

           }

          ?>
        </tbody>
      </table>
  </body>
</html>
