<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title>PDF</title>
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
    </style>
  </head><body background="biblioteca_imagenes/fondo_pdf.png" style="background-repeat: no-repeat;">

  <?php
    /*$consecutivo = 1234;
    $asunto = 'PRUEBA';
    $nombre_completo = 'AGENCIA DE VIAJES Y TURISMO AVIATUR';
    $fecha = '2023-06-13';*/

  ?>

  <center>
    <table style="width: 100%" >
      <thead>
        <tr>
          <th style="color: white; padding: 5px; width: 49%; text-align: center; float: right;">
            <img src="img/logo_aotour.png" width="230px" height="60px" style="margin-top: 50px; ">
          </th>
          <th style="color: white; padding: 5px; text-align: center; vertical-align: middle;"><img src="img/raya.PNG" width="15px" height="120px" style="margin-top: 25px"></th>
          <th style="padding: 5px; width: 49%; text-align: left;">
            <span style="font-family: sans-serif;">Contacto: Jhonnys Ojeda Soto</span><br>
            <span style="font-family: sans-serif;">Tel: (+57) 3013869946</span><br>
            <span style="font-family: sans-serif;">Email: comercial@aotour.com.co</span>
          </th>
        </tr>
      </thead>

    </table>
    
    <br><br>
    <span style="font-family: sans-serif; font-size: 18px;">Cotización N° 1234</span>
  </center>






    <br><br><br><br><br><br><br>
    <center><strong style="font-size: 35px; font-family: sans-serif">ASUNTO<br>
    </strong><br><strong style="font-size: 18px; font-family: sans-serif">NOMBRE - FECHA</strong></center>
    <br>
    <center><p style="font-family: sans-serif; font-size: 18px;">TOTAL COTIZACIÓN: <b>$ {{number_format(1000000)}}</b></p></center>
    <br><br><br>

    <center>

      <table style="width: 100%">

          <tr align="center">
            <!--<th>Fecha</th>-->
            <th style="font-family: sans-serif">Traslado</th>
            <th style="font-family: sans-serif">Ciudad</th>
            <th style="font-family: sans-serif">Vehículo</th>
            <th style="font-family: sans-serif">No. Pax</th>
            <th style="font-family: sans-serif">Valor/u</th>
            <th style="font-family: sans-serif">Valor total</th>
          </tr>

          
            <tr style="border: 1px solid">
      				
      				<td align="center" style="font-size: 11px; font-family: sans-serif">EJECUTIVO</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif">CIUDAD</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif">TIPO VEHICULO</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif">CANTIDAD</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif">$ {{number_format(10000)}}</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif">$ {{number_format(20000)}}</td>
      			</tr>
          
      </table>

    </center>



    <br>

    <footer>

      <center>
        <br><br>
        <div style="padding-top: 3px; margin-top: 2px !important; !important;">
            <div style="font-family: arial; text-align: center">
              <div style="display: inline-block; width: 100% !important; font-family: sans-serif; font-size: 11px; text-align: justify">
                <p><b>Esta cotización tiene vigencia de 30 días.</b></p>
                <br>
                <p><b>ESPECIFICACIONES TÉCNICAS.</b> Conformidad con la ley 769 del 2002 y código nacional de tránsito en todo concerniente a especificaciones técnicos mecánicas,
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
            <br>
            <p  style="font-family: sans-serif; font-size: 12px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p><br>
            <span style="font-family: sans-serif">www.aotour.com.co</span>
        </div>
      </center>

    </footer>

    <div style="page-break-after: always; margin-bottom: 30px"></div>
    <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo</strong></center>
<center>

  <table style="width: 100%" >
    <thead>
      <tr>
        <th style="color: white; padding: 5px; width: 30%; text-align: center; float: right;">
          
        </th>
        <th style="width: 40%; color: black; padding: 5px; text-align: center; vertical-align: middle;">
          <div style="background: #FBF9F9; border-radius: 20px;">
            <p style="font-family: sans-serif; color: black;">RENAULT MASTER</p>
            <img style="margin-top: 1px; margin-bottom: 5px; border-radius: 70px" src="img/imgs/microbus2.jpeg" width="80%" height="260px" ><br>
            <span style="font-family: sans-serif; color: black;">Características del Vehículo1</span><br>
              
                <li>1</li>
                <li>2</li>
                <li>3</li>
              
          </div>
        </th>
        <th style="padding: 5px; width: 30%; text-align: left;">

        </th>
      </tr>
    </thead>

  </table>

    
    <!--<img style="margin-top: 5px; margin-bottom: 20px" src="img/microbus2.jpeg" width="80%" height="460px" >
    center>-->
</body></html>
