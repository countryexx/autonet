<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8">
    <title>CUENTA DE COBRO</title>
    
    <style>

      body{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
      }

      #header{
        font-size: 12px;
      }

      .title-table{
        padding: 5px;
        background: #dadada;
        text-align: center;
        font-size: 10px;
        font-weight: 500;
      }

      #servicios tbody td{
        background: #efefef;
        padding: 10px;
        text-align: center;
        font-size: 12px;
      }

      #pasajeros tbody td{
        background: #efefef;
        padding: 10px;
        text-align: center;
        font-size: 12px;
      }

      .number_table{
        width: 10px;
        background: #dadada !important;
        border-right: 1px solid white;
        border-bottom: 1px solid white;
      }

      .pax_name_table{
        border-bottom: 1px solid white;
      }

      #client {
        padding-left: 6px;
        border-left: 6px solid #F47321;
        float: left;
        margin-bottom: 30px;
      }

      h3.name {
        font-weight: 500;
        font-size: 20px;
        margin: 0;
      }

      #informacion{
        table-layout: auto;
        empty-cells: show;
        border-collapse: collapse;
        margin-bottom: 15px;
        margin-top: 5px;
        width: 100%;
      }

      #informacion_conductor{
        table-layout: auto;
        empty-cells: show;
        border-collapse: collapse;
        margin-bottom: 10px;
        margin-top: 15px;
        width: 100%;
      }

      #informacion tr td, #informacion_conductor tr td{
        padding: 5px;
        font-size: 12px;
      }

      .div_info{
        padding: 5px;
        
      }

      .columna{
        text-align: center; 
        border-bottom: 1px solid black;
      }

    </style>
  </head><body>
      

      <div class="div_info" align="center">
        
        <!-- CÁLCULO DE FECHAS -->
        <?php 
        $fecha = explode('-', $pago_proveedores->fecha_inicial);
        $fecha_final = explode('-', $pago_proveedores->fecha_final);
        $dia = $fecha[2];
        $mes = $fecha[1];
        $ano = $fecha[0];

        $mes_actual = $mes;
        $mes_atras = $mes_actual-1;
        if($mes==='01'){
          $mes = '0';
          $last = '31';
          $nombre_mes = 'ENERO';
        }else if($mes==='02'){
          $mes = '0';
          $last = '28';
          $nombre_mes = 'FEBRERO';
        }else if($mes==='03'){
          $mes = '0';
          $last = '31';
          $nombre_mes = 'MARZO';
        }else if($mes==='04'){
          $mes = '0';
          $last = '30';
          $nombre_mes = 'ABRIL';
        }else if($mes==='05'){
          $mes = '0';
          $last = '30';
          $nombre_mes = 'MAYO';
        }else if($mes==='06'){
          $mes = '0';
          $last = '30';
          $nombre_mes = 'JUNIO';
        }else if($mes==='07'){
          $mes = '0';
          $last = '30';
          $nombre_mes = 'JULIO';
        }else if($mes==='08'){
          $mes = '0';
          $last = '31';
          $nombre_mes = 'AGOSTO';
        }else if($mes==='09'){
          $mes = '0';
          $last = '30';
          $nombre_mes = 'SEPTIEMBRE';
        }else if($mes==='10'){
          $mes = '';
          $last = '31';
          $nombre_mes = 'OCTUBRE';
        }else if($mes==='11'){
          $mes = '';
          $last = '30';
          $nombre_mes = 'NOVIEMBRE';
        }else if($mes==='12'){
          $mes = '';
          $last = '31';
          $nombre_mes = 'DICIEMBRE';
        }

        $mes_atras = $mes.$mes_atras;

        $fecha = explode('-', date('Y-m-d'));
        $ano = $fecha[0];

        $start_date = $ano.'-'.$mes_atras.'-01';
        $end_date = $ano.'-'.$mes_atras.'-'.$last;
         ?>

         <span style="text-align: center; font-size: 16px; margin-top: 22px;">
        <b>AUTO OCASIONAL TOUR SAS <br>
        NIT 819003684-2</b>
        <br><br><br>
        CUENTA DE COBRO No. {{$radicado}}
        <br><br><br>
        DEBE POR CONCEPTO DE:<br>
        <b>PRESTACIÓN DE SERVICIO DE TRANSPORTE ESPECIAL AL SUSCRITO FIRMANTE <br>DEL DÍA {{$dia}} AL {{$fecha_final[2]}} DE {{$nombre_mes}} DEL {{$ano}}</b><br><br><br>
        
        LA PRESENTE CUENTA DE COBRO POR VALOR DE <b style="color: green">$ {{number_format($pago_proveedores->valor_cuenta)}}</b> DE ACUERDO A COMO SE DESCRIBE:
       </span>

       @if($pago_proveedores_detalles!=null)
        
          <div class="col-lg-12">
            <div class="row">
                <p style="text-align: center; margin-top:10px; font-size: 15px">RELACIÓN DE SERVICIOS</p>
            </div>
          </div>
          <table class="table table-bordered hover tabla" cellspacing="0" width="100%">
              
                <tr>
                  <td>#</td>
                  <td># CONSTANCIA</td>
                  <td>PASAJEROS</td>
                  <td>FECHA</td>
                  <td>HORA</td>
                  <!--<td>Detalle</td>-->
                  <!-- INGRESAR DETALLES -->
                  <!-- DESCRIBIR TODOS LOS DETALLES -->
                  <!-- PENDIENTE DE REVISIÓN -->
                  <!-- TEST -->
                  <td>Valor</td>
                </tr>
              
                <?php $nombre_anterior = ''; $i = 1;?>

                @foreach($pago_proveedores_detalles as $pago)
                  @if($nombre_anterior!=$pago->razoncentro)
                                <tr class="">
                                    <td colspan="9"><b>{{$pago->razoncentro}}</b></td>
                                </tr>
                            @endif
                <tr>
                  <td class="columna">{{$i++}}</td>
                  <td class="columna">{{$pago->numero_planilla}}</td>
                  <td class="columna">{{$pago->nombresubcentro}}</td>
                  <td class="columna">{{$pago->fecha_servicio}}</td>
                  <td class="columna">{{$pago->hora_servicio}}</td>
                  <!--<td>{{$pago->detalle_recorrido}}</td>-->
                  <td class="columna">$ {{number_format($pago->total_pagado)}}</td>
                </tr>
                <?php $nombre_anterior = $pago->razoncentro?>
              @endforeach
            </table>
            <br><br><br>
            <!-- TEST FIRMA -->
            <table cellpadding="0" cellspacing="0" role="presentation" width="35%" style="float: left;">
              <tr>
                <td class="col" width="150" style="padding: 0;">
                  <div class="sans-serif">
                      <strong style="font-size: 13px;">{{strtoupper($pago_proveedores->proveedornombre)}}
                        <br>
                      <hr style="border-bottom: 1px solid">
                      <span>{{ $pago_proveedores->nit }}</span><br>
                      <span>FIRMA</span>
                      </strong>
                      
                  </div>
                </td>
              </tr>
              <br>
              <tr>
                <td>
                  <span style="float: left; padding: 5px; background-color: green; color: white; margin-top: 15px;">RADICADO N° 0000{{$radicado}}</span>
                </td>
              </tr>
            </table>
            <br><br><br><br>
            <!-- FIN TEST FIRMA -->
            <table cellpadding="0" cellspacing="0"  width="100%" style="float: left; margin-top: 25px;">
              <tr>
                <td>
                  <span style="color: black; font-size: 13px; font-size: 16px; text-align: center;">
                    Este documento tiene validez jurídica, presta mérito ejecutivo y está plenamente identificado por el firmante, quien manifiesta conocer los derechos y obligaciones estipulados y asume la veracidad de los datos que aquí se registran.
                  </span>
                </td>
              </tr>
            </table>
                
      @endif
        
      </div>

</body></html>
