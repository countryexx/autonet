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
            <th>FECHA</th>
            <th>EMPLOY ID</th>
            <th>NOMBRE COMPLETO</th>
            <th>TELÉFONO</th>
            <th>DIRECCIÓN</th>

            <th>BARRIO</th>
            <th>LOCALIDAD</th>
            <th>PROGRAMA</th>
            <th>ENTRADA/SALIDA</th>
            <th>HORA</th>
            <th>NOVEDAD</th>
            <th>CENTRO DE COSTOS</th>
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
                        $campana = str_replace('AT&AMP;T', 'AT&T', $campana);
                        $direccion = str_replace('&nbsp;', '', $value->direccion);
                        $barrio = str_replace('&nbsp;', '', $value->barrio);
                        $barrio = str_replace('&NBSP;', '', $barrio);
                        $localidad = str_replace('&nbsp;', '', $value->cargo);

                        $celp = str_replace('&NBSP;', '', $value->cedula);
                        $celp = str_replace('&nbsp;', '', $celp);

                        $nombre = str_replace('&nbsp;', ' ', $value->nombres);
                        $nombre = str_replace('&NBSP;', ' ', $nombre);

                        $capacidad = '';
                        $valor = '';

                        if($idViejo!=$servicios[$i]->id){
                          $capacidad = $servicios[$i]->capacidad;
                          $valor = $servicios[$i]->id;
                        }

                        //if (strpos($servicios[$i]->detalle_recorrido, 'E') !== false) {
                        $posicionCoincidencia = strpos("SUTHERLAND", $servicios[$i]->recoger_en);

                        if ($posicionCoincidencia !== false){
                          $tipo = 'SALIDA';
                        }else{
                          $tipo = 'ENTRADA';
                        }

                        $posicionCoincidencia = strpos("BURÓ 25", $servicios[$i]->recoger_en);

                        if ($posicionCoincidencia !== false){
                          $tipo = 'SALIDA';
                        }

                        $posicionCoincidencia = strpos("BURÓ25", $servicios[$i]->recoger_en);

                        if ($posicionCoincidencia !== false){
                          $tipo = 'SALIDA';
                        }

                        $posicionCoincidencia = strpos("CONECTA", $servicios[$i]->recoger_en);

                        if ($posicionCoincidencia !== false){
                          $tipo = 'SALIDA';
                        }

                        if($campana=='AT&AMP;T CLG MOBILITY SPANISH - BARRANQUILLA'){
                          $cam = 'AT&T CLG MOBILITY SPANISH - BARRANQUILLA';
                        }else if($campana=='AT&AMP;T LCBB - BARRANQUILLA'){
                          $cam = 'AT&T LCBB - BARRANQUILLA';
                        }else if($campana=='AT&AMP;T DTV SPANISH - BARRANQUILLA'){
                          $cam = 'AT&T DTV SPANISH - BARRANQUILLA';
                        }else{
                          $cam = $campana;
                        }

                        if(trim($value->area)=='RUTA EJECUTADA CON EXITO'){
                          $novedad = 'RUTA EJECUTADA CON ÉXITO';
                        }else if(trim($value->area)=='NO SE PRESENTO'){
                          $novedad = 'NO SE PRESENTÓ';
                        }else if(trim($value->area)=='AGENTE TOMA RUTA EN HORARIO NO PROGRAMADO'){
                          $novedad = 'CONSULTOR TOMA RUTA EN HORARIO NO PROGRAMADO';
                        }else{
                          if($value->area==''){
                            $novedad = 'RUTA EJECUTADA CON ÉXITO';
                          }else{
                            $novedad = $value->area;
                          }
                        }

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.strtoupper($value->apellidos).'</td>'.
                              '<td>'.strtoupper($nombre).'</td>'.
                              '<td>'.strtoupper(trim($celp)).'</td>'.
                              '<td>'.strtoupper($direccion).'</td>'.
                              '<td>'.strtoupper(trim($barrio)).'</td>'.
                              '<td>'.strtoupper(trim($value->cargo)).'</td>'.
                              '<td>'.trim($cam).'</td>'.



                              '<td>'.$tipo.'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.strtoupper(trim($novedad)).'</td>'.
                              '<td>'.$servicios[$i]->nombresubcentro.'</td>'.
                              '</tr>';
                              $contador++;

                        $idViejo = $servicios[$i]->id;
                     }
                   }
               }

               for ($i=0; $i <count($servicios2) ; $i++) {
                   $json = json_decode($servicios2[$i]->pasajeros_ruta);
                   if(is_array($json)){
                     foreach ($json as $key => $value) {

                        $tipo_servicio = null;

                        if($servicios2[$i]->email_solicitante==1){ //si es transporte de pc
                          $tipo_servicio = 'PC';
                        }else if($servicios2[$i]->email_solicitante==2){ //si es transporte de eventos
                          $tipo_servicio = 'EVENTO';
                        }else if($servicios2[$i]->ruta==null){ //si es ejecutivo
                          $tipo_servicio = 'EJECUTIVO';
                        }else if($servicios2[$i]->hora_servicio>='06:00' and $servicios2[$i]->hora_servicio<='20:59'){ //ruta diurna
                          $tipo_servicio = 'RUTA EXTRAORDINARIA DIURNA';
                        }else if( ($servicios2[$i]->hora_servicio>='21:00' and $servicios2[$i]->hora_servicio<='23:59') or ($servicios2[$i]->hora_servicio>='00:00' and $servicios2[$i]->hora_servicio<='05:59')){
                          $tipo_servicio = 'RUTA ORDINARIA NOCTURNA';
                        }

                        $campana = str_replace('AMP;', '', $value->sub_area);
                        $campana = str_replace('AT&AMP;T', 'AT&T', $campana);
                        $direccion = str_replace('&nbsp;', '', $value->direccion);
                        $barrio = str_replace('&nbsp;', '', $value->barrio);
                        $barrio = str_replace('&NBSP;', '', $barrio);
                        $localidad = str_replace('&nbsp;', '', $value->cargo);

                        $nombre = str_replace('&nbsp;', ' ', $value->nombres);
                        $nombre = str_replace('&NBSP;', ' ', $nombre);

                        $capacidad = '';
                        $valor = '';

                        if($idViejo!=$servicios2[$i]->id){
                          $capacidad = $servicios2[$i]->capacidad;
                          $valor = $servicios2[$i]->id;
                        }

                        if (strpos($servicios2[$i]->detalle_recorrido, 'E') !== false) {
                          $tipo = 'ENTRADA';
                        }else{
                          $tipo = 'SALIDA';
                        }

                        if($campana=='AT&AMP;T CLG MOBILITY SPANISH - BARRANQUILLA'){
                          $cam = 'AT&T CLG MOBILITY SPANISH - BARRANQUILLA';
                        }else if($campana=='AT&AMP;T LCBB - BARRANQUILLA'){
                          $cam = 'AT&T LCBB - BARRANQUILLA';
                        }else if($campana=='AT&AMP;T DTV SPANISH - BARRANQUILLA'){
                          $cam = 'AT&T DTV SPANISH - BARRANQUILLA';
                        }else{
                          $cam = $campana;
                        }

                        if(trim($value->area)=='RUTA EJECUTADA CON EXITO'){
                          $novedad = 'RUTA EJECUTADA CON ÉXITO';
                        }else if(trim($value->area)=='NO SE PRESENTO'){
                          $novedad = 'NO SE PRESENTÓ';
                        }else if(trim($value->area)=='AGENTE TOMA RUTA EN HORARIO NO PROGRAMADO'){
                          $novedad = 'CONSULTOR TOMA RUTA EN HORARIO NO PROGRAMADO';
                        }else{
                          $novedad = $value->area;
                        }

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios2[$i]->fecha_servicio.'</td>'.
                              '<td>'.strtoupper($value->apellidos).'</td>'.
                              '<td>'.strtoupper($nombre).'</td>'.
                              '<td>'.strtoupper(trim($value->cedula)).'</td>'.
                              '<td>'.strtoupper($direccion).'</td>'.
                              '<td>'.strtoupper(trim($barrio)).'</td>'.
                              '<td>'.strtoupper(trim($value->cargo)).'</td>'.
                              '<td>'.trim($cam).'</td>'.



                              '<td>'.$tipo.'</td>'.
                              '<td>'.$servicios2[$i]->hora_servicio.'</td>'.
                              '<td>'.strtoupper(trim($novedad)).'</td>'.
                              '<td>'.$servicios2[$i]->nombresubcentro.'</td>'.
                              '</tr>';
                              $contador++;

                        $idViejo = $servicios2[$i]->id;
                     }
                   }
               }
          ?>
        </tbody>
      </table>
  </body>
</html>
