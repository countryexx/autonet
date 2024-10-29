<!DOCTYPE html>
<html>
  <head>
    <meta charset="iso-8859-1">
    <title></title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">
      html, body, div, span, applet, object, iframe,
      h1, h2, h3, h4, h5, h6, p, blockquote, pre,
      a, abbr, acronym, address, big, cite, code,
      del, dfn, em, img, ins, kbd, q, s, samp,
      small, strike, strong, sub, sup, tt, var,
      b, u, i, center,
      dl, dt, dd, ol, ul, li,
      fieldset, form, label, legend,
      table, caption, tbody, tfoot, thead, tr, th, td,
      article, aside, canvas, details, embed,
      figure, figcaption, footer, header, hgroup,
      menu, nav, output, ruby, section, summary,
      time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font: inherit;
        font-size: 100%;
        vertical-align: baseline;
      }

      html {
        line-height: 0;
      }

      ol, ul {
        list-style: none;
      }

      table {
        border-collapse: collapse;
        border-spacing: 0;
      }

      caption, th, td {
        text-align: left;
        font-weight: normal;
        vertical-align: middle;
      }

      q, blockquote {
        quotes: none;
      }
      q:before, q:after, blockquote:before, blockquote:after {
        content: "";
        content: none;
      }

      a img {
        border: none;
      }

      article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
        display: block;
      }

      body {
        font-family: 'Arimo', sans-serif !important;
        font-weight: 400;
        font-size: 12px !important;
        margin: 5px 20px 60px 20px;
        padding: 5px 0px;
        height: 1020px;
      }
      .content-header{
        text-align: center;
        margin-bottom: 3px;
      }

      .tableh{
        border: 1px solid black;
        width: 100%;
      }
      .table-content{
        width: 100%;
      }
      .tableh tr td{
        text-align: center;
      }
      .tablej{
        border: 1px solid black;
        width: 100%;
      }
      .table-content table tbody tr td{
        border: 1px solid black !important;
        padding: 2px;
      }

      .table-titles table tbody tr td{
        border: 1px solid black !important;
        padding: 2px;
      }

      ul{
        padding: 5px 20px;
      }
      ul li{
        margin-bottom: 5px;
        list-style: armenian;
        vertical-align: center;
      }
    </style>
  </head>
  <body>
    <div class="content-header">
      <img width="150px" style="margin-bottom: 0px" src="biblioteca_imagenes/logos.png">
      <h4 class="bolder">AUTO OCASIONAL TOUR LTDA</h4>
      <small>NIT. 819.003.684-2</small><br>
      <small>Cra 53 # 68B - 87 C.C Gran Centro Oficina 1-138</small><br>
      <small>Tel: (57)(5) 358 2555 - 358 2003 - Linea Nacional: 018000 510 400</small>
    </div>
    <table class="table-titles" style="text-align:center; padding:5px 0px 0px 0px; border: 1px solid black; margin-bottom: 5px; width: 100%">
      <tr>
        <td style="padding: 2px !important;" align="center">
          COTIZACION # {{$cotizaciones->consecutivo}}
        </td>
      </tr>
  </table>
    <table class="table-titles" style="border-top: 0px !important; width: 100%;">
      <tr>
        <td style="width: 20px !important; padding: 5px !important; border: 1px solid black">Fecha:</td>
        <td style="width: 90px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->fecha}}</td>
        <td style="width: 185px !important; padding: 5px !important; border: 1px solid black">Cliente:</td>
        <td style="padding: 2px !important; border: 1px solid black">{{$cotizaciones->nombre_completo}}</td>
      </tr>
    </table>
    <table class="table-titles" style="border-top: 0px !important; width: 100%;">
      <tr>
        @if($cotizaciones->nit!=null or $cotizaciones->nit!='')
        <td style="width: 70px !important; padding: 5px !important; border: 1px solid black">Nit o CC:</td>
        <td style="width: 90px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->nit}}</td>
        @endif
        @if($cotizaciones->direccion!=null or $cotizaciones->direccion!='')
        <td style="width: 30px !important; padding: 5px !important; border: 1px solid black">Direccion:</td>
        <td style="width: 220px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->direccion}}</td>
        @endif
        @if($cotizaciones->contacto!=null or $cotizaciones->contacto!='')
        <td style="width: 30px !important; padding: 5px !important; border: 1px solid black">Contacto:</td>
        <td style="width: 100px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->contacto }}</td>
        @endif
      </tr>
    </table>
    <table class="table-titles" style="margin-bottom: 0px; border-top: 0px !important; width: 100%;">
      <tr>
        @if($cotizaciones->celular!=null or $cotizaciones->celular!='')
        <td style="width: 20px !important; padding: 5px !important; border: 1px solid black">Telefono:</td>
        <td style="width: 50px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->celular}}</td>
        @endif
        @if($cotizaciones->email!=null or $cotizaciones->email!='')
        <td style="width: 40px !important; padding: 5px !important; border: 1px solid black">Email:</td>
        <td style="width: 90px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->email}}</td>
        @endif

        @if($cotizaciones->vendedor!=null or $cotizaciones->vendedor!='')
        <td style="width: 50px !important; padding: 5px !important; border: 1px solid black">Vendedor:</td>
        <td style="width: 190px !important; padding: 5px !important; border: 1px solid black">{{$cotizaciones->vendedor}}</td>
        @endif
      </tr>
    </table>
    <div class="table-content">
      {{$cotizaciones->contenido_html}}
    </div>
    <div>
        Notas: {{$cotizaciones->observacion}}
    </div>

    @if(intval($cotizaciones->tipo)===1)
    <div style="padding-top: 3px; border-top: 1px solid black; border-bottom: 1px solid black; margin-top: 7px !important; !important; position: absolute; bottom: -31">
        <div style="font-size: 10px !important; padding-left: 10px !important;">
          <div style="display: inline-block; width: 45% !important; float: left !important;">
            ESPECIFICACIONES TECNICAS<br>
            <ul style="padding: 5px 10px 0 5px; margin-bottom:0px">
              <li style="text-align: justify;">De conformidad con la Ley 769 de 2002 y C&oacute;digo Nacional de Tr&aacute;nsito en todo lo concerniente a especificaciones t&eacute;cnico mec&aacute;nicas, ambientales, de pesos, dimensiones, comodidad y seguridad</li>
              <li>Modelo de veh&iacute;culos recientes / Full equipo</li>
              <li>Vehiculos Climatizados</li>
              <li>Seguros Obligatorios</li>
            </ul>
            POLITICAS DEL SERVICIO:<br>
            <ul style="padding: 5px 10px 0 5px; margin-bottom: 5px">
              <li>Disponibilidad 24 horas.</li>
              <li>Aplica tarifa m&iacute;nima equivalente a dos horas.</li>
              <li style="text-align: justify;">Aplica tarifa de tiempo de espera a partir de 15 minutos de acuerdo a la hora programada para dar inicio al servicio.</li>
              <li style="text-align: justify;">Estas tarifas no aplican para evento de Partido de la selección Colombia y Eventos del Carnaval de Barranquilla.</li>
            </ul>
          </div>
          <div style="display: inline-block; width: 55% !important; float: right !important;"><br/>
            <ul style="padding: 5px 10px 0 5px; margin-bottom: 5px">
              <li>Aplica recargo nocturno del 20% sobre la tarifa a partir de las 18:00 horas.</li>
              <li>La tarifa correspondiente a d&iacute;a a disposici&oacute;n no incluye traslado al aeropuerto.</li>
              <li style="text-align: justify;">Las tarifas de traslado intermunicipales corresponde exclusivamente a trayecto comprendido entre punto de recogida y punto de destino.</li>
              <li style="text-align: justify;">La cancelaci&oacute;n de servicios locales deben efectuarse por escrito con tiempo previo m&iacute;nimo igual a 2 horas de  la  establecida para recogida
                en el punto de origen, en caso de tratarse de un servicio intermunicipal el tiempo previo m&iacute;nimo es de 6 horas.</li>
              <li style="text-align: justify;">La no cancelaci&oacute;n oportuna de servicios genera facturaci&oacute;n y cobro del 100% del valor acordado.</li>
              <li>Las tarifas de servicio de aeropuerto no incluye protocolo de recepci&oacute;n.</li>
              <li style="text-align: justify;">Las tarifas son objeto de revisi&oacute;n y modificaci&oacute;n de acuerdo a temporadas especiales.</li>
              <li>Vigencia de tarifas: 31 de Diciembre de 2.017.</li>
            </ul>
          </div>
        </div>
    </div>
    @endif
  </body>
</html>
