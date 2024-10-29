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
    <br>
    <br>
    <br>
    
    <tr>
      <td></td>
      <td valign="middle" align="center" style="background: #E7D6C6"><b>INFORMACIÓN DE LOS PAGOS</b></td>
    </tr>
    <br>
        <table class="excel">
          <thead>
            <tr style="color: #040404;">
              <th valign="middle" align="center"><strong style="text-align: center;">NOMBRE DEL BENEFICIARIO</strong></th>
              <th valign="middle" align="center"><strong>NÚMERO DE DOCUMENTO</strong></th>
              <th valign="middle" align="center"><strong>ENTIDAD BANCARIA</strong></th>
              <th valign="middle" align="center"><strong>NÚMERO DE CUENTA</strong></th>
              <th valign="middle" align="center"><strong>TIPO DE CUENTA</strong></th>
              <th valign="middle" align="center"><strong>VALOR TOTAL</strong></th>
              <th valign="middle" align="center"><strong>RETEFUENTE</strong></th>
              <th valign="middle" align="center"><strong>PRESTAMOS</strong></th>
              <th valign="middle" align="center"><strong>VALOR NETO</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php
                 $contador = 1;
                 for ($i=0; $i <count($servicios) ; $i++) {
                     
                       if($servicios[$i]->autorizado==1){
                          $ruta = '<td>AUTORIZADO</td>';
                        }else{
                          $ruta = '<td>POR AUTORIZAR</td>';
                        }

                        if($servicios[$i]->estado_tercero==1){
                          $razonsocial = $servicios[$i]->razonsocial_t;
                          $nit = $servicios[$i]->nit_t;
                          $entidad_bancaria = $servicios[$i]->entidad_bancaria_t;
                          $numero_cuenta = $servicios[$i]->numero_cuenta_t;
                          $tipo_cuenta = $servicios[$i]->tipo_cuenta_t;
                        }else{
                          $razonsocial = $servicios[$i]->razonsocial;
                          $nit = $servicios[$i]->nit;
                          $entidad_bancaria = $servicios[$i]->entidad_bancaria;
                          $numero_cuenta = $servicios[$i]->numero_cuenta;
                          $tipo_cuenta = $servicios[$i]->tipo_cuenta;
                        }
                        echo '<tr>'.
                              '<td>'.$razonsocial.'</td>'.
                              '<td style="text-align: right">'.$nit.'</td>'.
                              '<td style="text-align: right">'.$entidad_bancaria.'</td>'.
                              '<td style="text-align: right">'.$numero_cuenta.'</td>'.
                              '<td style="text-align: right">'.$tipo_cuenta.'</td>'.
                              '<td style="text-align: right">'.number_format($servicios[$i]->total_pagado).'</td>'.
                              '<td style="text-align: right">'.number_format($servicios[$i]->descuento_retefuente).'</td>'.
                              '<td style="text-align: right">'.number_format($servicios[$i]->descuento_prestamo).'</td>'.
                              '<td style="text-align: right">'.number_format($servicios[$i]->total_neto).'</td>'.
                              '</tr>';
                              $contador++;
                     
                 }
            ?>
            
          </tbody>
        </table>
    </div>
  </body>
</html>


