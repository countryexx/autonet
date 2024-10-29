<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>
</head>
<style media="screen">
  body{
    font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
    font-size: 14px;
  }

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
    line-height: 1;
  }

  table {
    border-collapse: collapse;
    border-spacing: 0;
    border: 1px solid black !important;
  }
  table tbody tr td{
    border: 1px solid black !important;
    padding: 5px;
  }
  ul li{
    list-style: disc;
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

  .table_sum{
    width: 100% !important;
  }

  .contenido > .table_sum{
    width: 100% !important;
  }

  .contenido table{
    width: 100% !important;
  }

</style>
<body>
   @if(intval($tipo)===1)
   De acuerdo a su amable solicitud le envio la siguiente cotizacion.<br><br>
   <small style="margin-top: 10px">ESTE MENSAJE HA SIDO ENVIADO MEDIANTE NUESTRA APLICACION, POR FAVOR DESCARGAR EL PDF, DENTRO DE ESTE ENCONTRARA TODA LA INFORMACION CORRESPONDIENTE A SU COTIZACION.</small><br><br>
   @endif
</p>
<div class="contenido">
  @if(isset($cotizaciones))
    {{$cotizaciones->contenido_html}}
  @endif
</div>
@if(intval($tipo)===2)
<div style="padding: 10px 0px 0px 0px; font-size: 10px;">ESTE MENSAJE HA SIDO ENVIADO MEDIANTE NUESTRA APLICACION</div><br><br>
<div class="">
    &bull;<i style="font-size: 11px"> Tarifas sujetas a cambio sin previo aviso, la tarifa final de su reserva será garantizada una vez AOTOUR confirme
    dicha reserva vía correo electrónico habiéndose realizado depósito, de lo contrario queda sujeta a disponibilidad.</i><br>
    <i style="font-size: 11px">&bull; Al realizar depósito se entiende que se aceptan las condiciones y políticas.</i><br>
    <i style="font-size: 11px">&bull; AOTOUR no se responsabiliza por solicitudes de modificación de reservas o en caso de que el cliente realice algún
    cambio por cuenta propia.</i><br>
    <i style="font-size: 11px">&bull; Es responsabilidad del cliente verificar que la información relacionada en la confirmación es correcta y por
    ende autoriza a AOTOUR a  realizar las respectivas reservas y reconfirmaciones con estos datos.</i><br>
    <i style="font-size: 11px">&bull; Las políticas de cancelación varían de acuerdo al hotel, época del año o tipo de habitación.</i><br>
    <i style="font-size: 11px">&bull; Se consideran cancelación y no aplica reembolsos el No Show y la salida anticipada de hoteles.</i><br>
    <i style="font-size: 11px">&bull; Las modificaciones o cancelación de servicio, están sujetas a gastos y penalidades.</i><br>
    <i style="font-size: 11px">&bull; Las reservas efectuadas bajo la condición de tarifa No Reembolsable, serán cobradas en su totalidad
      al momento de efectuar la reserva.</i><br>
    <i style="font-size: 11px">&bull; Toda solicitud de reembolso debe ser tramitada por escrito dentro de un plazo no mayor a 15 días posterior
     a la finalización del servicio (Sujeta a verificación).</i><br>
    <i style="font-size: 11px">&bull; Las tarifas no incluyen otros cargos adicionales en los que puede incurrir durante su estadía, estos consumos
    serán cargados a su cuenta y deberán ser pagados al momento de su salida.</i><br><br>
</div>
@endif

<?php
  $iduserd = Sentry::getUser()->id;
?>

@if(intval($iduserd)===46)
<strong>JENNIFER LEMUS</strong><br>
<span>Coordinadora de Turismo</span>
<br><br>
@endif

@if(intval($iduserd)===3)
<strong>JUAN PIMIENTA</strong><br>
<span>Auxiliar de Turismo</span>
<br><br>
@endif

@if(intval($iduserd)===4)
<strong>LINA MARIA ALONSO</strong><br>
<span>Coordinadora Comercial</span>
<br><br>
@endif

@if(intval($iduserd)===2)
<strong>MICHELL JOSE GUTIERREZ RINCON</strong><br>
<span>Sistemas</span>
<br><br>
@endif

<span style="color: #e36c0a"><strong>C:</strong></span> 3045754968 - 3046075211<br>
<span style="color: #e36c0a"><strong>T:</strong></span> (+57) (5) 358 2555 - 358 2003<br>
<span style="color: #e36c0a"><strong>D:</strong></span> Carrera 53 No 68B-87 C.C. Gran Centro Oficina 1-138<br>
<span style="color: #e36c0a"><strong>Linea Nacional:</strong></span> 018000 510 400<br>
Visítenos: www.aotour.com.co<br>
<img src="https://s32.postimg.org/6lbw91a2d/image.png"><br>
<strong><i><u style="font-size:11px; color: rgb(31,73,125)"><span style="font-size: 12px">Nota de interés legal:</span> De acuerdo con el artículo 12 del Decreto 348 de 2015. La única forma de poder prestar servicio de
transporte especial, es decir transporte de estudiantes, de empleados, de turistas, de grupos específicos de usuarios
 (transporte  de  particulares), y de usuarios de servicio de salud, será a través de una empresa legalmente habilitada
 en el servicio  público de transporte terrestre automotor especial, bajo los acuerdos bilaterales de oferta y demanda y
 sin cobros fuera de los consagrados en la norma. Los usuarios del servicio de salud, deberán hacerlo a través de una empresa
 legalmente habilitada. Ahora bien, no pueden existir cobros de comisión por la firma del contrato. En este sentido no se admiten
 contratos con terceros o comisionistas, que busquen hacer la intermediación que no es necesaria y menos con contraprestación
 económica por la realización o consecución de los contratos de prestación de servicios de transporte en para cualquiera de
 los grupos de usuarios antes señalados. No se podrá disfrazar este tipo de cobros o comisiones con donaciones, o cualquier
 otro tipo de forma convencional o comercial.</u></i></strong><br>
<span style="font-size: 11px"><i>Este mensaje y/o sus anexos son para uso exclusivo de su destinatario intencional y puede contener información
  legalmente protegida por ser privilegiada o confidencial. Si usted no es el destinatario del mensaje por favor
  infórmenos de inmediato y elimine el mensaje y sus anexos de su computador. Igualmente, le comunicamos que cualquier
  retención, revisión no autorizada,   distribución,   divulgación, reenvío, copia, impresión, reproducción o uso indebido
   de este mensaje y/o     sus anexos,   está estrictamente prohibida y sancionada legalmente. Este mensaje igualmente,
   puede contener información   de carácter personal que     no necesariamente  refleja la opinión de <span style="color: #e36c0a">AOTOUR</span></i></span><br>
<span style="color: #00b050; font-size: 11px"><strong>Por favor considere su responsabilidad ambiental antes de imprimir este correo electrónico.</strong></span><br>


</table>
</body>
</html>
