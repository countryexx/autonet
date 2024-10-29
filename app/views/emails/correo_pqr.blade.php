<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="x-apple-disable-message-reformatting">
    <title>Pine Email Framework</title>

    <style type="text/css">

      @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');
      @media only screen {
        .col, td, th, div, p {font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;}
        .serif {font-family: 'Merriweather', Georgia, serif!important;}
        .sans-serif {font-family: 'Open Sans', Arial, sans-serif!important;}
      }

      #outlook a {padding: 0;}
      img {border: 0; line-height: 100%; vertical-align: middle;}
      .col {font-size: 12px; line-height: 20px; vertical-align: top;}

      .p-general{
        padding: 10px;
      }

      @media only screen and (max-width: 730px) {
        .wrapper img {max-width: 100%;}
        u ~ div .wrapper {min-width: 100vw;}
        .container {width: 100%!important; -webkit-text-size-adjust: 100%;}
      }

      @media only screen and (max-width: 699px) {
        .col {
          box-sizing: border-box;
          display: inline-block!important;
          line-height: 23px;
          //width: 100%!important;
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

        .full-width-sm {display: table!important; width: 100%!important;}
        .stack-sm-first {display: table-header-group!important;}
        .stack-sm-last {display: table-footer-group!important;}
        .stack-sm-top {display: table-caption!important; max-width: 100%; padding-left: 0!important;}

        .toggle-content {
          max-height: 0;
          overflow: auto;
          transition: max-height .4s linear;
            -webkit-transition: max-height .4s linear;
        }
        .toggle-trigger:hover + .toggle-content,
        .toggle-content:hover {max-height: 999px!important;}

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

        .borderless-sm {border: none!important;}
        .nav-sm-vertical .nav-item {display: block;}
        .nav-sm-vertical .nav-item a {display: inline-block; padding: 4px 0!important;}

        .spacer {height: 0;}

        .p-sm-0 {padding: 0!important;}
        .p-sm-10 {padding: 10px!important;}
        .p-sm-20 {padding: 20px!important;}
        .p-sm-30 {padding: 30px!important;}
        .pt-sm-0 {padding-top: 0!important;}
        .pt-sm-10 {padding-top: 10px!important;}
        .pt-sm-20 {padding-top: 20px!important;}
        .pt-sm-30 {padding-top: 30px!important;}
        .pr-sm-0 {padding-right: 0!important;}
        .pr-sm-10 {padding-right: 10px!important;}
        .pr-sm-20 {padding-right: 20px!important;}
        .pr-sm-30 {padding-right: 30px!important;}
        .pb-sm-0 {padding-bottom: 0!important;}
        .pb-sm-10 {padding-bottom: 10px!important;}
        .pb-sm-20 {padding-bottom: 20px!important;}
        .pb-sm-30 {padding-bottom: 30px!important;}
        .pl-sm-0 {padding-left: 0!important;}
        .pl-sm-10 {padding-left: 10px!important;}
        .pl-sm-20 {padding-left: 20px!important;}
        .pl-sm-30 {padding-left: 30px!important;}
        .px-sm-0 {padding-right: 0!important; padding-left: 0!important;}
        .px-sm-10 {padding-right: 10px!important; padding-left: 10px!important;}
        .px-sm-20 {padding-right: 20px!important; padding-left: 20px!important;}
        .px-sm-30 {padding-right: 30px!important; padding-left: 30px!important;}
        .py-sm-0 {padding-top: 0!important; padding-bottom: 0!important;}
        .py-sm-10 {padding-top: 10px!important; padding-bottom: 10px!important;}
        .py-sm-20 {padding-top: 20px!important; padding-bottom: 20px!important;}
        .py-sm-30 {padding-top: 30px!important; padding-bottom: 30px!important;}
      }
    </style>
  </head>
  <body style="box-sizing:border-box;margin:0;padding:0;width:100%;word-break:break-word;-webkit-font-smoothing:antialiased;">

    <div style="display:none;font-size:0;line-height:0;">PQR</div>

    <hr style="margin-top: 5px; margin-bottom: 2px; border-top: 1px dotted black;">
    <!--container-->
    <table class="wrapper" cellpadding="15" cellspacing="0" role="presentation" width="100%">
      <tr>
        <td align="center">
          <table class="container" cellpadding="0" cellspacing="0" role="presentation" width="850">
            <tr>
              <td align="left" bgcolor="#FFFFFF">

                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">
                      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                        <tr>
                          <td class="col" width="850" style="padding: 0;">

                            <p style="font-family: futura bold; font-size: 25px;">INFORMACIÓN DEL RECLAMANTE</p><br>
                            
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                <!--Row-->
                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">
                      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                        <tr>
                          <td class="col" width="850" style="padding: 0;">
                            <table>
                              <tbody>
                                <tr>
                                  <td><span style="color: #f37320">Nombre / Organización:</span></td>
                                  <td style="padding: 0 10px;">{{$nombres}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Tipo de Solicitud / Request Type:</span></td>
                                  <td style="padding: 0 10px;">{{$tipo_solicitud}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Teléfono / Phone: </span></td>
                                  <td style="padding: 0 10px;">{{$telefono}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Ciudad / City: </span></td>
                                  <td style="padding: 0 10px;">{{$ciudad}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Dirección / Adress: </span></td>
                                  <td style="padding: 0 10px;">{{$direccion}}</td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                <!--Spacer-->
                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td class="spacer py-sm-10" height="20"></td>
                  </tr>
                </table>
                
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <table class="wrapper" cellpadding="15" cellspacing="0" role="presentation" width="100%">
      <tr>
        <td align="center">
          <table class="container" cellpadding="0" cellspacing="0" role="presentation" width="850">
            <tr>
              <td align="left">
                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">

                   <h6 style="font-family: futura bold; font-size: 25px;">QUEJA/RECLAMO</h6>                   
                      <table>
                        <tr>
                          <td class="col" width="850" style="padding: 0">
                            <div style="font-family: Arial;">
                              <p style="font-family: Arial">{{$info}}</p>
                            </div>
                          </td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
    <hr style="margin-top: 5px; margin-bottom: 2px; border-top: 1px dotted black;">
    <br>
    <table class="wrapper" cellpadding="15" cellspacing="0" role="presentation" width="100%">
      <tr>
        <td align="center">
          <table class="container" cellpadding="0" cellspacing="0" role="presentation" width="850">
            <tr>
              <td align="left" bgcolor="#FFFFFF">

                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">
                      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                        <tr>
                          <td class="col" width="850" style="padding: 0;">

                            <p style="font-family: futura bold; font-size: 25px;">INFORMACIÓN DEL SERVICIO</p><br>
                            
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                  <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">
                      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                        <tr>
                          <td class="col" width="850" style="padding: 0;">
                            <table>
                              <tbody>
                                <tr>
                                  <td><span style="color: #f37320">N° Servicio:</span></td>
                                  <td style="padding: 0 10px;">{{$servicio}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Fecha del Servicio:</span></td>
                                  <td style="padding: 0 10px;">{{$fecha}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Ruta:</span></td>
                                  <td style="padding: 0 10px;">{{$ruta}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Placa Vehículo: </span></td>
                                  <td style="padding: 0 10px;">{{$placa}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Conductor: </span></td>
                                  <td style="padding: 0 10px;">{{$conductor}}</td>
                                </tr>
                                <tr>
                                  <td><span style="color: #f37320">Tipo de Servicio: </span></td>
                                  <td style="padding: 0 10px;">{{$tiposerv}}</td>
                                </tr>                                
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>

                <table class="wrapper" cellpadding="15" cellspacing="0" role="presentation" width="100%">
      <tr>
        <td align="center">
          <table class="container" cellpadding="0" cellspacing="0" role="presentation" width="850">
            <tr>
              <td align="left">
                <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
                  <tr>
                    <td style="padding: 0;">
                    <br>
                   <h6 style="font-family: futura bold; font-size: 25px;">QUEJA DEL SERVICIO</h6>                   
                      <table>
                        <tr>
                          <td class="col" width="850" style="padding: 0">
                            <div style="font-family: Arial;">
                              <p style="font-family: Arial">{{$info2}}</p>
                            </div>
                          </td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </body>
</html>
