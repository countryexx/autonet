<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="x-apple-disable-message-reformatting">
    <title>Pine Email Framework</title>

    <!--[if mso]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <style>
      table {border-collapse: collapse;}
      td,th,div,p,a {font-size: 16px; line-height: 26px;}
      .spacer,.divider,div,p,a,h1,h2,h3,h4,h5,h6 {mso-line-height-rule: exactly;}
      td,th,div,p,a,h1,h2,h3,h4,h5,h6 {font-family:"Segoe UI",Helvetica,Arial,sans-serif;}
    </style>
    <![endif]-->

    <style type="text/css">
      /**/
      .button {
          background:#7f8c8d;
          color:#fff;
          display:inline-block;
          font-size:1.25em;
          margin:20px;
          padding:10px 0;
          text-align:center;
          width:200px;
          text-decoration:none;
          box-shadow:0px 3px 0px #373c3c;
      }
       
      .button span {
          margin-right:10px;
      }
       
      /*Colores*/
      .button.blue {
          background:#3498db;
          box-shadow:0px 3px 0px #266792;
      }
       
      .button.yellow {
          background:#e67e22;
          box-shadow:0px 3px 0px #b55704;
      }
       
       
      /*Tamaños*/
      .button.medium {
          width:350px;
      }
       
       
      .button.large {
          width:450px;
      }
       
       
      .button.radius {
          border-radius:50px;
      }
       
      /*Efectos, Hover*/
      .button:hover {
          box-shadow:0px 0px 0px;
          padding-top:7px;
      }
      /**/

      .boton_personalizado{
        text-decoration: none;
        padding: 10px;
        font-weight: 600;
        font-size: 20px;
        color: #ffffff;
        background-color: #1883ba;
        border-radius: 6px;
        border: 2px solid #0016b0;
      }

      @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');
      @media only screen {
        .col, td, th, div, p {font-family: -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif;}
        .serif {font-family: 'Merriweather', Georgia, serif!important;}
        .sans-serif {font-family: 'Open Sans', Arial, sans-serif!important;}
      }

      a.button {
        -webkit-appearance: button;
        -moz-appearance: button;
        appearance: button;

        text-decoration: none;
        padding: 1%;
        color: white;
        background-color: #DC4405;

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

    <div style="display:none;font-size:0;line-height:0;">Confirmation</div>
    @foreach($servicios as $servicio)
    <!--container-->
    <table style="max-width: 900px; padding: 10px; margin:0 auto; border-collapse: collapse;">

  <tr>
    <td style="background-color: #ecf0f1" align="center">
      <div style="color: #34495e; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif">
        <p class="sans-serif" style="font-size: 18px">Cordial Saludo de parte de todo el equipo AOTOUR. <br><br>
        Nos complace confirmarle los detalles de su transporte.<br></p>
        
    <!--Row-->    

    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
  <tr>
    <td style="padding: 0;" align="center">
      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
        <tr>
          <td class="col" width="850" style="padding: 0;">

            <table cellspacing="0" id="table_detalle_solicitud" style="width: 100%;" border="1">
              <thead>
                <tr bgcolor="#74A0F3">
                  <th class="sans-serif p-general" colspan="8" style="color: black; font-size: 12px; padding: 10px"><b>SOLICITUD # {{$id_servicio}} - {{$fecha_solicitud}}</b></th>
                </tr>
                <tr bgcolor="#74A0F3">
                  <th colspan="1" width="70" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">FECHA</th>
                  <th colspan="1" width="70" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">HORA</th>
                  <th colspan="1" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px"><b>EMPRESA</b></th>
                  <th colspan="1" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px"><b>PASAJERO</b></th>
                  <th colspan="1" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px"><b>DESDE</b></th>
                  <th colspan="1" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px"><b>HACIA</b></th>
                  <th colspan="2" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px"><b>CONDUCTOR</b></th>
                </tr>
              </thead>
              <tbody>
                  <!-- inicio foreach-->
                    <tr bgcolor="#EFEFEF">
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                        {{date('d-m-Y', strtotime($servicio->fecha_servicio))}}
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                        {{$servicio->hora_servicio}}
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                        {{$servicio->razonsocial}}
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                          <!--INICIO PASAJEROS-->
                          <?php 
                            $pax = explode('/',$servicio->pasajeros);
                            $sw = count($pax);
                            $count = 0;
                            for ($i=0; $i < count($pax); $i++) {
                                $pasajeros[$i] = explode(',', $pax[$i]);
                            }

                            for ($i=0; $i < count($pax)-1; $i++) {

                                for ($j=0; $j < count($pasajeros[$i]); $j++) {

                                  if ($j===0) {
                                    $nombre = $pasajeros[$i][$j];
                                  }                                           

                                }
                                $count++;
                                if($sw===$count){
                                  echo $nombre;
                                }else{
                                  echo $nombre.' <br> ';
                                }
                                

                            }
                          ?>
                          <!--FIN PASAJEROS-->
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                        {{$servicio->recoger_en}}
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 10px; text-align: center;">
                        {{$servicio->dejar_en}}
                      </td>
                      <td class="sans-serif p-general" style="color: #353535; font-size: 10px; padding: 11px; text-align: center;">
                        {{$servicio->nombre_completo}}<br>
                        {{$servicio->celular}}<br>
                        {{$servicio->marca}} {{$servicio->modelo}}<br>
                        {{$servicio->color}} {{$servicio->placa}}
                      </td>
                    </tr>
                  <!-- fin foreach-->
              </tbody>
            </table>
            <br>

  <div style="width: 100%; text-align: center; margin:20px 0; display: inline-block;">
    <span style="color: black; font-size: 14px;"><b>IMPORTANTE:</b> No responder a este mensaje, ya que fue enviado desde nuestra plataforma de forma automática. Si tienes preguntas o inquietudes, por favor contáctanos al correo transportebogota@aotour.com.co</span>
  </div>

  <p style="color: black; font-size: 12px; text-align: center;margin: 30px 0 0"><b>Todos los derechos reservados</b></p>
    </div>
    </td>
  </tr>
</table>


@endforeach
  </body>
</html>