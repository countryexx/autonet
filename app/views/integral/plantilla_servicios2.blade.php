<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="{{url('bootstrap/css/custom.css')}}" media="screen" title="no title" charset="utf-8">
    @include('scripts.styles')

    <style type="text/css">
      
      .color-azul{
        background: blue;
      }

      .color-verde{
        background: green;
      }
    </style>
  </head>
  <body>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 '>
        <table class="excel">
          <thead>
            <tr style="color: #fff; background: orange;">
              <th align="center"><strong>#</strong></th>
              <th align="center"><strong>ID SERVICIO</strong></th>
              <th align="center"><strong>NOMBRE CONDUCTOR</strong></th>
              <th align="center"><strong>FECHA SERVICIO</strong></th>
              <th align="center"><strong>HORA SERVICIO</strong></th>
              <th align="center"><strong>DETALLE RECORRIDO</strong></th>
              <th align="center"><strong>NOMBRE USUARIO</strong></th>
              <th align="center"><strong>ID USUARIO</strong></th>
              <th align="center"><strong>DIRECCIÓN</strong></th>
              <th align="center"><strong>BARRIO</strong></th>
              <th align="center"><strong>ESTADO QR</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php
                 $contador = 1;
                 $ultimo_servicio = '';
                 $sw = 0;
                 for ($i=0; $i <count($servicios) ; $i++) {
                     //$json = json_decode($servicios[$i]->pasajeros_ruta);
                       if($servicios[$i]->status==null){
                          $ruta = 'NO LEÍDO';
                        }else if($servicios[$i]->status==1){
                          $ruta = 'LEIDO';
                        }else if($servicios[$i]->status==2){
                          $ruta = 'AUTORIZADO';
                        }else if($servicios[$i]->status==3){
                          $ruta = 'SIN REGISTRARSE';
                        }

                        if($servicios[$i]->servicio_id!=$ultimo_servicio and $contador!=1){
                          if($contador>1){
                            if($sw==1){
                              $sw=0;
                            }else if($sw==0){
                              $sw=1;
                            }
                          }
                        }

                        if($contador==1 and $sw=0){
                          $class = 'color-azul';
                        }else if($servicios[$i]->servicio_id!=$ultimo_servicio and $sw===0){
                          $class = 'color-azul';
                        }else if($servicios[$i]->servicio_id===$ultimo_servicio and $sw===0){
                          $class = 'color-verde';
                        }else if($servicios[$i]->servicio_id!=$ultimo_servicio and $sw===1){
                          $class = 'color-verde';
                        }else if($servicios[$i]->servicio_id===$ultimo_servicio and $sw===1){
                          $class = 'color-verde';
                        }

                        echo '<tr>'.
                              '<td>'.$contador.'</td>'.
                              '<td>'.$servicios[$i]->servicio_id.'</td>'.
                              '<td>'.$servicios[$i]->nombre_completo.'</td>'.
                              '<td>'.$servicios[$i]->fecha_servicio.'</td>'.
                              '<td>'.$servicios[$i]->hora_servicio.'</td>'.
                              '<td>'.$servicios[$i]->detalle_recorrido.'</td>'.
                              '<td>'.$servicios[$i]->fullname.'</td>'.
                              '<td>'.$servicios[$i]->id_usuario.'</td>'.
                              '<td>'.$servicios[$i]->address.'</td>'.
                              '<td>'.$servicios[$i]->neighborhood.'</td>'.
                              '<td>'.$ruta.'</td>'.
                              '</tr>';
                              $contador++;
                     $ultimo_servicio = $servicios[$i]->servicio_id;
                 }
            ?>
          </tbody>
        </table>
    </div>
  </body>
</html>
