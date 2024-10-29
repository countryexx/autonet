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

    
  a.button {
      -webkit-appearance: button;
      -moz-appearance: button;
      appearance: button;

      text-decoration: none;
      
      color: white;
      
    
    padding: 10px;
        color: #FFF;
        background-color: #F85B07;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border-radius: 25px;
        width: 50%;
        border-width: 1px 1px 3px;
        box-shadow: 0 -1px 0 rgba(255,255,255,0.1) inset;
        margin-bottom: 10px;

    }
      @import url('https://fonts.googleapis.com/css?family=Merriweather|Open+Sans');
      @media only screen {
        .serif {font-family: 'Merriweather', Georgia, serif!important;}
        .sans-serif {font-family: 'Open Sans', Arial, sans-serif!important;}
      }

      #outlook a {padding: 0;}
      table {border-collapse: collapse;}
      .col, td, th {font-size: 16px; line-height: 26px; vertical-align: top;}
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

  <table class="wrapper" bgcolor="#EEEEEE" cellpadding="15" cellspacing="0" role="presentation" width="100%" >
    <tr>
      <td>
        <table class="container" align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation" width="1000" style="border: 2px solid gray">
          <tr>
            <td>

              <table align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                <tr>
                  <td style="padding: 0 20px;">

                    <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000; width: 560px; margin: 0 auto;" width="560">
                      <tbody>
                      <tr class="reverse">
                      <td class="column column-1 first" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 10px; padding-left: 30px; padding-right: 30px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
                      <div class="border">
                      <table border="0" cellpadding="0" cellspacing="0" class="heading_block block-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                      <tr>
                      <td class="pad" style="text-align:center;width:30%;">

                      </td>

                      </tr>
                      </table>
                      </div>
                      </td>
                      <td class="column column-2 last" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" >
                      <div class="border">
                        <img src="{{url('img/logo_aotour_peq.png')}}" width="235px">

                      </div>
                      </td>
                      <td class="column column-2 last" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 30px; padding-right: 30px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
                      <div class="border">
                        

                      </div>
                      </td>
                      </tr>

                      </tbody>
                      </table>
                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                      <tr>
                        <td class="col">
                          <h4 style="font-weight: 400; color: gray; text-align: left;">A continuación te compartimos la información de @if($cantidad>1){{'tus servicios programados'}}@else{{'tu servicio programado'}}@endif.</h4>
                        </td>
                      </tr>
                      <tr>
                        <td class="col">
                          @if($cantidad>1)
                            <h4 style="font-weight: 400; color: gray; text-align: left;">Servicio Múltiple / Múltiple Service.</h4>
                          @else
                            <h4 style="font-weight: 400; color: gray; text-align: left;">Servicio Único / Single Service.</h4>
                          @endif
                        </td>
                      </tr>
                      
                    </table>

                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                      <tr>
                        <td class="col" >
                          <h4 style="font-weight: 400; color: #5f6062; text-align: left;"><b style="color: #f47321;">Pasajeros / Passengers</b> <br> 

                          <?php

                            $paxes = '';
                            for ($i=0; $i < count($nombre_pasajeros); $i++) { 
                              $paxes .= $nombre_pasajeros[$i].' / ';
                            }
                            echo $paxes;

                          ?>
                      </h4>
                        </td>
                      </tr>
                      
                    </table>

                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                     
                      @foreach($servicios as $servicio)
                        <tr>
                          <td style="width: 20%;">
                            <p style="color: #929292; text-align:left">
                              <b style="color: #f47321;">Conductor / Vehículo:</b> <br> {{$servicio->nombre_completo}} / {{$servicio->celular}} | {{$servicio->clase}} / {{$servicio->placa}} / {{$servicio->marca}} / {{$servicio->modelo}}
                            </p>
                          </td>

                          <td style="width: 20%;">
                            <p style="color: #929292; text-align:left">
                              <b style="color: #f47321;">Hora / Time:</b> <br> {{$servicio->fecha_servicio}} / {{$servicio->hora_servicio}}
                            </p>
                          </td>

                          <td style="width: 25%;">
                            <p style="color: #929292; text-align:left">
                              <b style="color: #f47321;">Desde / Pickup:</b> <br> {{$servicio->recoger_en}}
                            </p>
                          </td>

                          <td style="width: 25%;">
                            <p style="color: #929292; text-align:left">
                              <b style="color: #f47321;">Hasta / Carry:</b> <br> {{$servicio->dejar_en}}
                            </p>
                          </td>

                          <td style="width: 10%;">
                            <p style="color: #929292; text-align:left">
                              <b style="color: #f47321;">Tracking</b> <br> <a target="_blank" href="{{url('maps/trackingservice/'.$servicio->id)}}">GPS/Driver</a>
                            </p>
                          </td>
                        </tr>
                      @endforeach

                    </table>

                    <table cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-top: 25px;">

                      <tr>
                        <td class="col" style="padding: 0 10px;">  
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000; width: 560px; margin: 0 auto;" width="560">
                              <tbody>
                                <tr class="reverse">
                                    <div class="border">
                                      
                                      <p style="color: #929292; text-align:left; font-size: 12px">
                                        2 horas antes de tu servicio te estaremos reconfirmando para que puedas hacer tracking a tu conductor.
                                      </p>
                                      <span></span>

                                    </div>

                                </tr>
                              
                              </tbody>
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
        <!--<table cellpadding="0" cellspacing="0" role="presentation" width="100%">
          <tr>
            <td class="col" style="padding: 0 10px;">
              <p style="color: black; text-align:left; font-size: 10px;">
                <b style="color: #f47321;">Descarga nuestra APP.</b>
              </p>
            </td>
          </tr>
          <tr>
            <td class="col" style="padding: 0 10px;">
              <div class="row">
                <a style="float: left;" href="https://apps.apple.com/co/app/aotour-client-app/id1496087652"> <img width="110px" height="50px" src="{{url('img/app_store.png')}}"> </a>

                <a style="float: left; margin-left: 15px;" href="https://play.google.com/store/apps/details?id=com.aotour.cliente"> <img width="110px" height="50px" src="{{url('img/google_play.png')}}"> </a>
              </div>
            </td>
            <td class="col" style="padding: 0 10px;">
              
            </td>
          </tr>

          
        </table>-->
      </td>
    </tr>
  </table>

</body>
</html>