<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title>PDF</title>

    <link rel="stylesheet" type="text/css"href="{{url('css/style.css')}}"/>

    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">

    div.inline { float:center; }


    .headerinfo {
        padding-left: 0px;
        width: 100%;
        margin-left: 20px;
      }

      .contain er-left {
        display: flex;
        margin: 15px 0px;
      }

      .headerinfo-cajas {
        overflow: hidden;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-right: 30px;
        position: relative;
        display: inline-block;
      }

      .headerinfo-cajas__titulo {
        color: black;
        font-size: 18px;
      }

      .headerinfo-cajas__titulo-center {
        color: black;
        font-size: 18px;
        text-align: center;
      }

      .headerinfo-cajas__subtitulo {
        color: #796f6a;
        font-size: 12px;
      }

      .headerinfo-cajas__subtitulo-2 {
        font-size: 15px;
      }

      .iconos {
        display: flex;
        flex-direction: column;
      }

      .headerinfo-cajas__icon {
        width: 15px;
        height: 15px;
        margin-bottom: 10px;
      }

      #container {
        position:relative;
      }

      #img2 {
          position: absolute;
          left: 50px;
          top: 50px;
      }


      body {
        font-family: 'Sansation', sans-serif;
      }

      .container {
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 10px;
  padding-right: 10px;
}

h2 {
  font-size: 26px;
  margin: 20px 0;
  text-align: center;
  small {
    font-size: 0.5em;
  }
}

.responsive-table {
  li 
    border-radius: 3px;
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
  }
  .table-header {
    background-color: #95A5A6;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }
  .table-row {
    background-color: #ffffff;
    box-shadow: 0px 0px 9px 0px rgba(0,0,0,0.1);
  }
  .col-1 {
    flex-basis: 10%;
  }
  .col-2 {
    flex-basis: 40%;
  }
  .col-3 {
    flex-basis: 25%;
  }
  .col-4 {
    flex-basis: 25%;
  }
  
  @media all and (max-width: 767px) {
    .table-header {
      display: none;
    }
    .table-row{
      
    }
    li {
      display: block;
    }
    .col {
      
      flex-basis: 100%;
      
    }
    .col {
      display: flex;
      padding: 10px 0;
      
    }
  }
}
    </style>
  </head><body>

  <?php
    /*$consecutivo = 1234;
    $asunto = 'PRUEBA';
    $nombre_completo = 'AGENCIA DE VIAJES Y TURISMO AVIATUR';
    $fecha = '2023-06-13';*/

  ?>
  <!--@if($cantidad==3)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 50px">
  @elseif($cantidad<=2)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 60px">
  @elseif($cantidad>=5)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 100px">
  @endif-->
  <div class="container-fluid">
    <center>

      <table style="width: 100%">
        <tr>
          <th style="color: white; padding: 2px; width: 49%; text-align: center; float: right;">
            <img src="img/logo_principal.png" width="280px" height="70px" style="margin-top: 10px;">
          </th>
          <th style="color: white; padding: 1px; text-align: center;"><!--<img src="img/raya.png" width="15px" height="110px" style="margin-top: 10px">--></th>
          <th style="padding: 2px; width: 49%; text-align: left;">
            <p><b style="font-size: 13px; color: #DC4405; font-family: 'Sansation', sans-serif;">Contacto:</b> <span style="font-size: 11px; font-family: 'Sansation', sans-serif;">{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}</span></p>
            <p style="margin-top: -14px;"><b style="font-size: 13px;  color: #DC4405; font-family: 'Sansation', sans-serif;;">Tel:</b> <span style="font-size: 11px; font-family: 'Sansation', sans-serif;">(+57) {{$telefono}}</span></p>
            <p style="margin-top: -14px;"><b style="font-size: 13px;  color: #DC4405; font-family: 'Sansation', sans-serif;;">Email:</b> <span style="font-size: 11px; font-family: 'Sansation', sans-serif;">{{$email}}</span></p>
          </th>
        </tr>
      </table>
      
    </center>
    <p style="font-family: 'Sansation', sans-serif; font-size: 18px; color: #DC4405; font-weight: bold; margin-left: 45px;">Cotización N° {{$consecutivo}}</p>

    <p style="font-size: 15px; font-family: 'Sansation', sans-serif; margin-left: 45px;">{{ucwords(strtolower($nombre_completo))}}</p>

    <p style="font-size: 17px; font-family: 'Sansation', sans-serif; font-weight: normal; margin-left: 45px;">{{strtoupper($asunto)}}</p>

    <center>

      <table style="width: 98%; margin-left: 30px; ">

          <tr style="background-color: #DC4405;">
            
            <th style="width: 12%; text-align: center; color: white; font-family: 'Sansation', sans-serif;">Ciudad</th>
            <th style="width: 12%; text-align: center; color: white; font-family: 'Sansation', sans-serif;">Fecha</th>
            <th style="width: 12%; text-align: center; color: white; font-family: 'Sansation', sans-serif;">Traslado</th>
            <th style="width: 12%; color: white; font-family: 'Sansation', sans-serif;">Vehículo</th>
            <th style="width: 12; color: white; font-family: 'Sansation', sans-serif;">Cant</th>
            <th style="width: 12%; color: white; font-family: 'Sansation', sans-serif;">Pax</th>
            <th style="width: 12%; color: white; font-family: 'Sansation', sans-serif;">Valor/u</th>
            <th style="width: 16%; color: white; font-family: 'Sansation', sans-serif;">Total</th>
          </tr>

          @foreach($detalles as $detalle)
            <?php
              $fech = explode('-', $detalle->fecha_servicio);
              $mes = $fech[1];
              if($mes==='01'){
                $mes = 'ENE';
              }else if($mes==='02'){
                $mes = 'FEB';
              }else if($mes==='03'){
                $mes = 'MAR';
              }else if($mes==='04'){
                $mes = 'ABR';
              }else if($mes==='05'){
                $mes = 'MAY';
              }else if($mes==='06'){
                $mes = 'JUN';
              }else if($mes==='07'){
                $mes = 'JUL';
              }else if($mes==='08'){
                $mes = 'AGO';
              }else if($mes==='09'){
                $mes = 'SEP';
              }else if($mes==='10'){
                $mes = 'OCT';
              }else if($mes==='11'){
                $mes = 'NOV';
              }else if($mes==='12'){
                $mes = 'DIC';
              }
              $dats =  $fech[2].'-'. $mes.'-'.substr($fech[0], -2);
            ?>
            <tr style="margin-left: 20px; background: #D1CFD1;">
      				<!--<td>{{$detalle->fecha_servicio}}</td>-->
              <td style="font-size: 10px; font-family: 'Sansation';">{{$detalle->ciudad}}</td>
              <td style="font-size: 11px; font-family: 'Sansation'; text-align: center;">{{$dats}}</td>
      				<td style="font-size: 10px; font-family: 'Sansation'; text-align: left">{{$detalle->tipo_servicio}}</td>
      				<td align="center" style="font-size: 11px; font-family: 'Sansation'; text-align: center;">{{$detalle->tipo_vehiculo}}</td>
              <td align="center" style="font-size: 11px; font-family: 'Sansation'; text-align: center;">{{$detalle->vehiculos}}</td>
              <td align="center" style="font-size: 11px; font-family: 'Sansation';">{{$detalle->pax}}</td>
      				<td align="center" style="font-size: 11px; font-family: 'Sansation';">$ {{number_format($detalle->valorxvehiculo)}}</td>
      				<td align="center" style="font-size: 11px; font-family: 'Sansation'; width: 16%">$ {{number_format($detalle->valortotal)}}</td>
      			</tr>

          @endforeach
      </table>
      
    </center>
    <table style="width: 100%">
        <tr>
          <th style="color: white; padding: 5px; width: 33%; text-align: center; float: right;">
            
          </th>
          <th style="color: white; padding: 3px; width: 33%; text-align: center; vertical-align: middle;">
            
          </th>
          <th style="padding: 5px; width: 34%; text-align: left;">
            <p style="font-size: 15px; color: #DC4405; font-weight: bold;">Total Cotización: <span style="color: black; font-family: 'Sansation', sans-serif;">${{number_format($total)}}</span></p>
          </th>
        </tr>
    </table>
    
    <br>

    @if($cantidad <= 10)
      <footer>

        <center>

          <div style="padding-top: 3px; margin-top: 2px !important; !important;">
              <div style="font-family: arial; text-align: center">
                <div style="display: inline-block; width: 100%; !important; font-family: sans-serif; font-size: 11px; text-align: justify">
                  @if(1>2) <!-- observaciones!=null and $observaciones!='' -->
                    <p style="margin-left: 40px;"><b style="text-decoration: underline;">Nota</b>: {{ucfirst(strtolower($observaciones))}}.</p>
                  @endif

                  <p style="margin-left: 40px; font-weight: bold; font-family: 'Sansation', sans-serif; font-size: 11px; color: #DC4405">Nota: <span style="font-weight:normal; color: black;">Notas de la cotización.</span></p>
                  <p style="margin-left: 40px; font-family: 'Sansation', sans-serif; font-size: 11px; margin-top: -11px">Esta cotización tiene vigencia de 30 días.</p>
                  <p style="margin-left: 40px; font-size: 11px; font-family: 'Sansation', sans-serif; margin-top: -11px">Fecha de solicitud: {{$fecha}}, solicitado por <a style="color: black" target="_blank" href="{{url('biblioteca_imagenes/archivos_cotizaciones/'.$soporte)}}"><b>{{$contacto}}</b></a>.</p> <!-- soporte -->
                  

                  <p style="margin-left: 40px; margin-right: 55px; font-family: 'Sansation', sans-serif; font-size: 10px;"><b style="color: #DC4405; font-family: 'Sansation', sans-serif; font-size: 11px;">ESPECIFICACIONES TÉCNICAS.</b> Conformidad con la ley 769 del 2002 y código nacional de tránsito en todo concerniente a especificaciones técnicos mecánicas,
                    ambientales, de peso, dimisiones, de comodidad y seguridad. Modeló de vehículos recientes / full equipo. Vehículos climatizados. Seguros obligatorios.
                    <br><b style="color: #DC4405">POLÍTICAS DE SERVICIOS:</b> Atención al cliente 24 horas. Aplica tarifa mínima equivalente a dos horas en servicio a disposición. Aplica tarifa de tiempo de
                    espera, a partir de 15 minutos de acuerdo a la hora programada para dar inicio al servicio. Estas tarifas no aplican para eventos municipales y nacionales,
                    eventos de alteración de orden público. La tarifa nocturna comienza a aplicarse a partir de las 18 horas. La tarifa correspondiente al día a disposición no
                    incluye traslado al aeropuerto. La tarifa de traslado intermunicipales corresponde exclusivamente a trayectos comprendidos entre punto de recogida y punto
                    de destino. La cancelación de servicio locales, deben efectuarse por escrito y con tiempo previo mínimo-igual a dos horas de la establecida para la recogida
                    en el punto de origen, en caso de tratarse un servicio intermunicipal, el tiempo mínimo es de 6 horas. La no cancelación oportuna del servicio genera
                    facturación y cobro del 100% del valor acordado. Las tarifas de servicio Aeropuerto no incluyen protocolo de recepción. Las tarifas son objetos de revisión y
                    modificación, de acuerdo a las temporadas especiales. La vigencia de tarifas: 31 de diciembre del 2023.</p>
                </div>

              </div>
              <br>
              <p  style="font-family: 'Sansation', sans-serif; font-size: 10px"><b style="color: #DC4405">LÍNEAS DE ATENCIÓN:</b> Línea Fija Nacional: (605) 358 2555 - Línea Móvil Nacional: (+57) 314 780 6060</p>
              @if($cantidad<=8)
                <br><br>
              @endif
              
          </div>
        </center>

      </footer>
    @endif

    @if($cantidad>10)
    <div style="page-break-after: always; margin-bottom: 30px"></div>
      <footer>
        <p style="margin-left: 60px"><b>{{$observaciones}}.</b></p>
        <center>
          <br>
          <div style="padding-top: 3px; margin-top: 2px !important; !important;">
              <div style="font-family: arial; text-align: center">
                <div style="display: inline-block; width: 90%; !important; font-family: sans-serif; font-size: 11px; text-align: justify">
                  <p style="margin-left: 60px"><b>Esta cotización tiene vigencia de 30 días.</b></p>
                  <br>

                  <p style="margin-left: 60px"><b>ESPECIFICACIONES TÉCNICAS.</b> Conformidad con la ley 769 del 2002 y código nacional de tránsito en todo concerniente a especificaciones técnicos mecánicas,
                    ambientales, de peso, dimisiones, de comodidad y seguridad. Modeló de vehículos recientes / full equipo. Vehículos climatizados. Seguros obligatorios.
                    <br><b>POLÍTICAS DE SERVICIOS:</b> Atención al cliente 24 horas. Aplica tarifa mínima equivalente a dos horas en servicio a disposición. Aplica tarifa de tiempo de
                    espera, a partir de 15 minutos de acuerdo a la hora programada para dar inicio al servicio. Estas tarifas no aplican para eventos municipales y nacionales,
                    eventos de alteración de orden público. La tarifa nocturna comienza a aplicarse a partir de las 18 horas. La tarifa correspondiente al día a disposición no
                    incluye traslado al aeropuerto. La tarifa de traslado intermunicipales corresponde exclusivamente a trayectos comprendidos entre punto de recogida y punto
                    de destino. La cancelación de servicio locales, deben efectuarse por escrito y con tiempo previo mínimo-igual a dos horas de la establecida para la recogida
                    en el punto de origen, en caso de tratarse un servicio intermunicipal, el tiempo mínimo es de 6 horas. La no cancelación oportuna del servicio genera
                    facturación y cobro del 100% del valor acordado. Las tarifas de servicio Aeropuerto no incluyen protocolo de recepción. Las tarifas son objetos de revisión y
                    modificación, de acuerdo a las temporadas especiales. La vigencia de tarifas: 31 de diciembre del 2023.</p>
                </div>

              </div>
              <br>
              <p  style="font-family: sans-serif; font-size: 9px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p><br>
              <span style="font-family: sans-serif">www.aotour.com.co</span>
          </div>
        </center>

      </footer>
    @endif
    <?php

    $cotizacion = DB::table('cotizaciones')
    ->where('id',$consecutivo)
    ->first();

    ?>
</div>




    <!--<img style="margin-top: 5px; margin-bottom: 20px" src="img/microbus2.jpeg" width="80%" height="460px" >
    center>-->

</body></html>
