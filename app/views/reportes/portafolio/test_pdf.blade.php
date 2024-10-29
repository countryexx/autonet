<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>Propuesta Economica</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">
    	body {
			font-family: 'Trebuchet MS', sans-serif;
			font-size: 14px !important;
      margin: -20px;
      background-repeat: no-repeat;
		}
    </style>
  </head><body background="biblioteca_imagenes/plantilla_tarifas.png">

  	<table border="1" cellspacing="1" width="100%" style="margin-top: 600px; border: 1px solid #DBD9D9">

        <tr>
          <td colspan="1" style="color: #706F6F; font-size: 48px; text-align: center; background-color: #DBD9D9"><b>#</b></td>
          <td colspan="3" style="color: #706F6F; font-size: 48px; text-align: center; background-color: #DBD9D9"><b>TRASLADO</b></td>
          <td colspan="2" style="color: #706F6F; font-size: 48px; text-align: center; background-color: #DBD9D9"><b>VALOR SUV</b></td>
          <td colspan="2" style="color: #706F6F; font-size: 48px; text-align: center; background-color: #DBD9D9"><b>VALOR VAN</b></td>
        </tr>

        <?php
        $contador = 1;
        $json = $tarifas;
        if(is_array($json)){
          foreach ($json as $key => $value) {

             echo '<tr style="background-color: #DBD9D9">'.
                   '<td colspan="1" style="text-align: center; color: #706F6F; background-color: #DBD9D9"><b>'.$contador.'</b></td>'.
                   '<td colspan="3" style="text-align: center; color: #706F6F; background-color: #DBD9D9"><b>'.strtoupper($value['traslado']).'</b></td>'.
                   '<td colspan="2" style="text-align: center; color: #706F6F; background-color: #DBD9D9"><b>$ '.number_format($value['valor_auto']).'</b></td>'.
                   '<td colspan="2" style="text-align: center; color: #706F6F; background-color: #DBD9D9"><b>$ '.number_format($value['valor_van']).'</b></td>'.
                   '</tr>';
                   $contador++;

          }
        }
        ?>

  	</table>
    </br></br>
    <div>


    </div>

</body></html>
