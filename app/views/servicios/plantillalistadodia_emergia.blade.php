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
            <th>#</th>
            <th>FECHA</th>
            <th>ID EMPLEADO</th>
            <th>NOMBRE</th>
            <th>DIRECCION</th>
            <th>BARRIO</th>
            <th>MUNICIPIO</th>
            <th>CELULAR</th>
            <th>HORA</th>
            <th>CONDUCTOR</th>
            <th>PLACA</th>
            <th>RUTA</th>
            <th>ASISTE</th>
            <th>NO ASISTE</th>
            <th>NOVEDADES TRANSPORTADOR</th>

            <th>TIPO DE RUTA</th> <!-- Sólo bogotá -->
            <th>VALOR UNITARIO</th> <!-- Sólo bogotá -->
            <th>RUTA</th> <!-- Sólo bogotá -->
          </tr>
        </thead>
        <tbody>
          <?php
               $contador = 1;
               $idViejo = '';
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
                        $localidad = str_replace('&nbsp;', '', $value->cargo);

                        $nombre = str_replace('&nbsp;', ' ', $value->nombres);
                        $nombre = str_replace('&NBSP;', ' ', $nombre);

                        $capacidad = '';
                        $valor = '';
                        $veh = '';
                        $route = '';


                        if($servicios[$i]->dejar_en=='BAQ'){
                          $lugar = 'BARRANQUILLA';
                        }else if($servicios[$i]->dejar_en=='SOL'){
                          $lugar = 'SOLEDAD';
                        }else{
                          $lugar = $servicios[$i]->dejar_en;
                        }

                        if($idViejo!=$servicios[$i]->numero_planilla){
                          $capacidad = $servicios[$i]->capacidad;
                          $valor = number_format(floatval($servicios[$i]->unitario_cobrado));
                          $veh = $servicios[$i]->clase;
                          $place = $lugar;
                          $route = $servicios[$i]->detalle_recorrido;
                          if($servicios[$i]->clase=='AUTOMOVIL' or $servicios[$i]->clase=='CAMIONETA'){
                            $veh = 'SUV';
                          }else{
                            $veh = 'VAN';
                          }
                        }else{
                          $place = '';
                          $veh = '';
                        }

                        if($value->area!=''){
                          if($value->area=='NO SE PRESENTÓ'){
                            $asiste = '';
                            $no_asiste = 'x';
                          }else if($value->area=='RUTA EJECUTADA CON ÉXITO'){
                            $asiste = 'x';
                            $no_asiste = '';
                          }else{
                            $asiste = '';
                            $no_asiste = '';
                          }
                        }else{
                          $asiste = '';
                          $no_asiste = '';
                        }

                        $fechs = date('d-m-Y', strtotime($servicios[$i]->fecha_servicio));

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td style="text-align: center">'.$fechs.'</td>'.
                              '<td style="text-align: center">'.strtoupper($value->apellidos).'</td>'.
                              '<td style="text-align: center">'.strtoupper($nombre).'</td>'.
                              '<td style="text-align: center">'.strtoupper(trim($direccion)).'</td>'.
                              '<td style="text-align: center">'.strtoupper(trim($barrio)).'</td>'.
                              '<td style="text-align: center">'.$lugar.'</td>'.
                              '<td style="text-align: center">'.$value->cedula.'</td>'.
                              '<td style="text-align: center">'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.$servicios[$i]->nombre_completo.'</td>'.
                              '<td>'.$servicios[$i]->placa.'</td>'.
                              '<td>'.$route.'</td>'.
                              '<td style="text-align: center">'.$asiste.'</td>'.//asiste
                              '<td style="text-align: center">'.$no_asiste.'</td>'.//no asiste
                              '<td></td>'.
                              '<td style="text-align: center">'.$veh.'</td>'.
                              '<td style="text-align: center">'.$valor.'</td>'.
                              '<td style="text-align: center">'.$place.'</td>'.
                              '</tr>';
                              $contador++;

                        $idViejo = $servicios[$i]->id;
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

                  $addrress = null;

                  $addrress = $servicio->recoger_en.' | '.$servicio->dejar_en;

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
                    '<td>'.$addrress.'</td>'.
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
