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
            <th>EMPLOY ID</th>
            <th>CAMPAÑA</th>
            <th>RUTA</th>            
            <th>FECHA</th>
            <th>HORA</th>
            <th>TIPO SERVICIO</th>
            <th>SUBCENTRO DE COSTO</th>
            <th>SERVICIO</th>
            <th>NUMERO DE PLANILLA</th>
            <th>DIRECCION</th>
            <th>BARRIO</th>
            <th>DESDE</th>
            <th>HASTA</th>

          </tr>
        </thead>
        <tbody>
          <?php
               $contador = 1;
               for ($i=0; $i <count($servicios) ; $i++) {
                   $json = json_decode($servicios[$i]->pasajeros_ruta);
                   if(is_array($json)){
                     foreach ($json as $key => $value) {

                        $tipo_servicio = null;

                        if($servicios[$i]->email_solicitante==1){ //si es transporte de pc
                          $tipo_servicio = 'PC';
                        }else if($servicios[$i]->email_solicitante==2){ //si es transporte de eventos
                          $tipo_servicio = 'EVENTO';
                        }else if($servicios[$i]->ruta==null){ //si es ejecutivo
                          $tipo_servicio = 'EJECUTIVO';
                        }else if($servicios[$i]->hora_servicio>='06:00' and $servicios[$i]->hora_servicio<='20:59'){ //ruta diurna
                          $tipo_servicio = 'RUTA EXTRAORDINARIA DIURNA';
                        }else if( ($servicios[$i]->hora_servicio>='21:00' and $servicios[$i]->hora_servicio<='23:59') or ($servicios[$i]->hora_servicio>='00:00' and $servicios[$i]->hora_servicio<='05:59')){
                          $tipo_servicio = 'RUTA ORDINARIA NOCTURNA';
                        }

                        $campana = str_replace('AMP;', '', $value->sub_area);
                        $direccion = str_replace('&nbsp;', '', $value->direccion);
                        $barrio = str_replace('&nbsp;', '', $value->barrio);
                        //$localidad = str_replace('&nbsp;', '', $value->cargo);

                        $nombre = str_replace('&nbsp;', ' ', $value->nombres);
                        $nombre = str_replace('&NBSP;', ' ', $nombre);

                        $valor1 = null;
                        $valor2 = null;

                        if(is_numeric($nombre) or $nombre == ''){
                          $valor1 = strtoupper($value->apellidos);
                          $valor2 = strtoupper($nombre);
                        }else{
                          $valor1 = strtoupper($nombre);
                          $valor2 = strtoupper($value->apellidos);
                        }

                        //$valor1 = ;
                        //$valor2 = ;

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$valor1.'</td>'.
                              '<td>'.$valor2.'</td>'.
                              '<td>'.$campana.'</td>'.
                              '<td>'.$servicios[$i]->detalle_recorrido.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.$servicios[$i]->tipo_servicio.'</td>'.
                              '<td>'.$servicios[$i]->nombresubcentro.'</td>'.
                              '<td>'.$tipo_servicio.'</td>'.
                              '<td>'.$servicios[$i]->numero_planilla.'</td>'.
                              '<td>'.strtoupper(trim($direccion)).'</td>'.
                              '<td>'.strtoupper(trim($barrio)).'</td>'.                           
                              '<td>'.$servicios[$i]->recoger_en.'</td>'. 
                              '<td>'.$servicios[$i]->dejar_en.'</td>'. 
                              '</tr>';
                              $contador++;
                     }
                   }
               }

               //EJECUTIVOS

                foreach ($servicios as $servicio) {

                  if($servicio->ruta==null){

                    $tipo_servicio = 'EJECUTIVO';

                  $pax = explode('/',$servicio->pasajeros);
                  $sw = count($pax);
                  $count = 0;
                  for ($i=0; $i < count($pax); $i++) {
                      $pasajeros[$i] = explode(',', $pax[$i]);
                  }

                  for ($i=0; $i < count($pax)-1; $i++) {

                      for ($j=0; $j < count($pasajeros[$i]); $j++) {

                        if ($j===0) {
                          $nombre = $pasajeros[$i][$j];
                        }

                      }
                      $count++;
                      if($sw===$count){
                        echo $nombre;
                      }else{
                        echo $nombre.' / ';
                      }
                      

                  }

                  echo '<tr>'.
                    '<td>'.$contador.'</td>'.
                    '<td>'.$nombre.'</td>'.
                    '<td></td>'.
                    '<td>'.$servicio->email_solicitante.'</td>'.
                    '<td>'.$servicio->detalle_recorrido.'</td>'.
                    '<td>'.$servicio->fecha_servicio.'</td>'.
                    '<td>'.$servicio->hora_servicio.'</td>'.
                    '<td>'.$servicio->tipo_servicio.'</td>'.
                    '<td>'.$servicio->nombresubcentro.'</td>'.
                    '<td>'.$tipo_servicio.'</td>'.
                    '<td>'.$servicio->numero_planilla.'</td>'.
                    '<td></td>'.
                    '<td></td>'.
                    '</tr>';
                    $contador++;
                        
                  }
                }

          ?>
        </tbody>
      </table>
  </body>
</html>
