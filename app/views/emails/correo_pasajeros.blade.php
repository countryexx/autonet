<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head></head>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Pine Email Framework</title>
    <!--[if mso]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

    <style type="text/css">

      @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');
      @media only screen {
        .serif {font-family: 'Merriweather', Georgia, serif!important;}
        .sans-serif {font-family: 'Open Sans', Arial, sans-serif!important;}
      }

      #outlook a {padding: 0;}
      table {border-collapse: collapse;}
      .col, td, th {font-size: 13px; line-height: 26px; vertical-align: top;}
      .col, td, th, div, p, h1, h2, h3, h4, h5, h6 {font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;}
      img {border: 0; display: block; line-height: 100%;}

      .container {margin: 0 auto;}
      .nav-item {display: inline-block;}
      .spacer, .divider {mso-line-height-rule:exactly; overflow: hidden; vertical-align: middle;}

      .padding_table{
        padding: 0 10px;
      }

      .align-sm-center {
        display: table!important;
        float: none;
        margin-left: auto!important;
        margin-right: auto!important;
      }
      .align-sm-left {float: left;}
      .align-sm-right {float: right;}

      @media only screen and (max-width: 699px) {

        u ~ div .wrapper {min-width: 100vw;}
        .container {-webkit-text-size-adjust: 100%; width: 100%!important;}

        .col {
          box-sizing: border-box;
          display: inline-block!important;
          line-height: 23px;
          width: 100%!important;
        }

        .padding_table{
          padding: 0px;
        }

        .col-sm-1  {max-width: 8.33333%;}
        .col-sm-2  {max-width: 16.66667%;}
        .col-sm-3  {max-width: 25%;}
        .col-sm-4  {max-width: 33.33333%;}
        .col-sm-5  {max-width: 41.66667%;}
        .col-sm-6  {max-width: 50%;}
        .col-sm-7  {max-width: 58.33333%;}
        .col-sm-8  {max-width: 66.66667%;}
        .col-sm-9  {max-width: 75%;}
        .col-sm-10 {max-width: 83.33333%;}
        .col-sm-11 {max-width: 91.66667%;}

        .col-sm-push-1  {margin-left: 8.33333%;}
        .col-sm-push-2  {margin-left: 16.66667%;}
        .col-sm-push-3  {margin-left: 25%;}
        .col-sm-push-4  {margin-left: 33.33333%;}
        .col-sm-push-5  {margin-left: 41.66667%;}
        .col-sm-push-6  {margin-left: 50%;}
        .col-sm-push-7  {margin-left: 58.33333%;}
        .col-sm-push-8  {margin-left: 66.66667%;}
        .col-sm-push-9  {margin-left: 75%;}
        .col-sm-push-10 {margin-left: 83.33333%;}
        .col-sm-push-11 {margin-left: 91.66667%;}

        img {
          width: 100%!important;
          height: auto!important;
        }

        .toggle-content {
          max-height: 0;
          overflow: auto;
          transition: max-height .4s linear;
            -webkit-transition: max-height .4s linear;
        }
        .toggle-trigger:hover + .toggle-content,
        .toggle-content:hover {
          max-height: 999px!important;
        }

        .show-sm {
          display: inherit!important;
          font-size: inherit!important;
          line-height: inherit!important;
          max-height: none!important;
        }
        .hide-sm {display: none!important;}

        .align-sm-center {
          display: table!important;
          float: none;
          margin-left: auto!important;
          margin-right: auto!important;
        }
        .align-sm-left {float: left;}
        .align-sm-right {float: right;}

        .text-sm-center {text-align: center!important;}
        .text-sm-left   {text-align: left!important;}
        .text-sm-right  {text-align: right!important;}

        .full-width-sm {display: table!important; width: 100%!important;}
        .stack-sm-top {display: table-caption!important; max-width: 100%; padding-left: 0!important;}
        .stack-sm-first {display: table-header-group!important;}
        .stack-sm-last {display: table-footer-group!important;}

        .borderless-sm {border: none!important;}
        .spacer, .divider {height: 30px; line-height: 100%!important;}

        .nav-item {padding: 0 10px 0!important;}
        .nav-sm-vertical .nav-item {display: block;}
        .nav-sm-vertical .nav-item a {display:inline-block; padding: 5px 0!important;}

        .p-sm-0   {padding: 0!important;}
        .p-sm-1   {padding: 10px!important;}
        .p-sm-2   {padding: 30px!important;}
        .pt-sm-0  {padding-top: 0!important;}
        .pt-sm-1  {padding-top: 10px!important;}
        .pt-sm-2  {padding-top: 30px!important;}
        .pr-sm-0  {padding-right: 0!important;}
        .pr-sm-1  {padding-right: 10px!important;}
        .pr-sm-2  {padding-right: 30px!important;}
        .pb-sm-0  {padding-bottom: 0!important;}
        .pb-sm-1  {padding-bottom: 10px!important;}
        .pb-sm-2  {padding-bottom: 30px!important;}
        .pl-sm-0  {padding-left: 0!important;}
        .pl-sm-1  {padding-left: 10px!important;}
        .pl-sm-2  {padding-left: 30px!important;}
        .px-sm-0  {padding-right: 0!important; padding-left: 0!important;}
        .px-sm-1  {padding-right: 10px!important; padding-left: 10px!important;}
        .px-sm-2  {padding-right: 30px!important; padding-left: 30px!important;}
        .py-sm-0  {padding-top: 0!important; padding-bottom: 0!important;}
        .py-sm-1  {padding-top: 10px!important; padding-bottom: 10px!important;}
        .py-sm-2  {padding-top: 30px!important; padding-bottom: 30px!important;}
      }
    </style>
  </head>

<body style="box-sizing:border-box;margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;word-break:break-word;">

<br>
<div style="padding: 10px 0px 0px 0px; font-size: 10px;">
  Auto Ocasional Tour SAS, se encuentra complacido, de indicarle a usted {{$nombres}} {{$apellidos}}, que ha sido creado en la plataforma tecnológica AUTONET, para la gestión de transporte ejecutivos y de ruta, de la empresa a la que pertenece {{$razonsocial}}, y se le hace entrega a través de este medio de su Código de referencia para la verificación de acceso a nuestros servicios.
  recuerde mantener este codigo cada vez que usted haya sido programado para hacer uso de nuestros servicios.
</div>
<br>
<img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/facturacion/ingresos/{{$codigo}}.png" />
<div style="padding: 10px 0px 0px 0px; font-size: 10px;">
  ESTE MENSAJE HA SIDO ENVIADO MEDIANTE NUESTRA PLATAFORMA AUTOMATICA
</div><br><br>

<strong><br>
                                                             <p style="font-size: 14px;">
                                <span style="color: #f47321">C: </span><span>3012030290-3046075207</span></span><br>
                                <span style="color: #f47321">Whatssap: </span><span>(+57)-3012030290</span><br>
                                <span style="color: #f47321">T: </span><span>(+57) (5) 358 2555 - 358 2003</span><br>
                                <span style="color: #f47321">D: </span><span>Carrera 53 No 68B-87 C.C. Gran Centro Oficina 1-138</span><br>
                                <span style="color: #f47321">Linea Gratuita: </span><span>01 8000 51 04 00</span><br>
                                <span>Barranquilla - Colombia</span><br>
                                <span>Visítenos: </span><a target="_blank" href="http://www.aotour.com.co">www.aotour.com.co</a>
                              </p>
                            </div>
                          </td>
                        </tr>
                      </table>
<span style="color: #f47321"><strong>AOTOUR</strong></span>
                                <i style="color: #1F4E79">
                                  <strong>
                                    se compromete a identificar, verificar, proteger y salvaguardar los datos personales de nuestros clientes y proveedores recibidos  para la incorporación dentro de la prestación de servicio. En caso de que la información  se pierda AOTOUR informará lo sucedido inmediatamente.
                                  </strong>
                                </i>
                              </span><br>
  <i style="font-size: 11px;">
                                <u style="color: #17365D">
                                  <strong>
                                    <span style="font-size: 12px;">Nota de interés legal:</span> De acuerdo con el artículo 12 del Decreto 348 de 2015. La única forma de poder prestar servicio de transporte especial, es decir transporte de estudiantes, de empleados, de turistas, de grupos específicos de usuarios  (transporte  de  particulares), y de usuarios de servicio de salud, será a través de una empresa legalmente habilitada en el servicio  público de transporte terrestre automotor especial, bajo los acuerdos bilaterales de oferta y demanda y sin cobros fuera de los consagrados en la norma. Los usuarios del servicio de salud, deberán hacerlo a través de una empresa legalmente habilitada. Ahora bien, no pueden existir cobros de comisión por la firma del contrato. En este sentido no se admiten contratos con terceros o comisionistas, que busquen hacer la intermediación que no es necesaria y menos con contraprestación económica por la realización o consecución de los contratos de prestación de servicios de transporte en para cualquiera de los grupos de usuarios antes señalados. No se podrá disfrazar este tipo de cobros o comisiones con donaciones, o cualquier otro tipo de forma convencional o comercial.
                                  </strong>
                                </u><br>
                              </i>
                              <i style="font-size: 11px;">
                                Este mensaje y/o sus anexos son para uso exclusivo de su destinatario intencional y puede contener información legalmente protegida por ser privilegiada o confidencial. Si usted no es el destinatario del mensaje por favor infórmenos de inmediato y elimine el mensaje y sus anexos de su computador. Igualmente, le comunicamos que cualquier retención, revisión no autorizada,   distribución,   divulgación, reenvío, copia, impresión, reproducción o uso indebido de este mensaje y/o sus anexos, está estrictamente prohibida y sancionada legalmente. Este mensaje igualmente, puede contener información de carácter personal que no necesariamente refleja la opinión de <span>AOTOUR</span>
                              </i><br>
                              <span style="color: #00B050; font-size: 12px;">
                                <strong>
                                  Por favor considere su responsabilidad ambiental antes de imprimir este correo electrónico
                                </strong>
                              </span>


</body>
