<div class="modal open" id="open_modal_envio_mails_servicios" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <strong>PLANTILLA DE SERVICIOS PROGRAMADOS</strong>
      </div>
      <div class="modal-body">
        <div class="row">

          <table class="wrapper" bgcolor="#EEEEEE" cellpadding="15" cellspacing="0" role="presentation" width="100%">
            <tr>
              <td>
                <table align="center" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="border: 2px solid gray">
                  <tr>
                    <td>

                      <table align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                        <tr>
                          <td style="padding: 0 20px;">
                            <!--<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000; width: 560px; margin: 0 auto;" width="560">
                                <tbody>
                                  <tr class="reverse">
                                    <td class="column column-1 first" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 10px; padding-left: 30px; padding-right: 30px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
                                      <div class="border">

                                      </div>
                                    </td>
                                    <td class="column column-2 last" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-left: 30px; padding-right: 10px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" >
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
                              </table>-->
                            <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                              <tr>
                                <td class="col">
                                  <h4 class="title_uno hidden" style="font-weight: 400; color: gray; text-align: left;">A continuación te compartimos la información de tus servicios programados.</h4>
                                  <h4 class="title_dos hidden" style="font-weight: 400; color: gray; text-align: left;">A continuación te compartimos la información de tu servicio programado.</h4>
                                </td>
                              </tr>
                              <tr>
                                <td class="col">
                                  <h4 class="subtitle_uno hidden" style="font-weight: 400; color: gray; text-align: left;">Servicio Múltiple / Múltiple Service.</h4>
                                  <h4 class="subtitle_dos hidden" style="font-weight: 400; color: gray; text-align: left;">Servicio Único / Single Service.</h4>
                                </td>
                              </tr>

                            </table>

                            <table cellpadding="0" cellspacing="0" role="presentation" width="100%">

                              <tr>
                                <td class="col" >
                                  <h4 style="font-weight: 400; color: #5f6062; text-align: left;"><b style="color: #f47321;">Pasajeros / Passengers</b> <br>
                                    <h5 id="paxs" style="font-weight: 400; color: #929292; text-align: left;"></h5>
                                  </h4>
                                </td>
                              </tr>
                            </table>

                            <table cellpadding="0" cellspacing="0" role="presentation" width="100%" id="table_detalle_solicitud">
                              <tbody>
                              </tbody>
                              <!--@foreach($servicios as $servicio)
                                <tr>
                                  <td style="width: 20%;">
                                    <p style="color: #929292; text-align:left">
                                      <b style="color: #f47321;">Fecha / Date:</b> <br> <span ></span>
                                    </p>
                                  </td>

                                  <td style="width: 20%;">
                                    <p style="color: #929292; text-align:left">
                                      <b style="color: #f47321;">Hora / Time:</b> <br> {{$servicio->hora_servicio}}
                                    </p>
                                  </td>

                                  <td style="width: 20%;">
                                    <p style="color: #929292; text-align:left">
                                      <b style="color: #f47321;">Desde / Pickup:</b> <br> {{$servicio->recoger_en}}
                                    </p>
                                  </td>

                                  <td style="width: 20%;">
                                    <p style="color: #929292; text-align:left">
                                      <b style="color: #f47321;">Hasta / Carry:</b> <br> {{$servicio->dejar_en}}
                                    </p>
                                  </td>

                                  <td style="width: 20%;">
                                    <p style="color: #929292; text-align:left">
                                      <b style="color: #f47321;">Tracking</b> <br> <a target="_blank" href="{{url('maps/trackingservice/'.$servicio->id)}}">GPS/Info</a>
                                    </p>
                                  </td>
                                </tr>
                              @endforeach-->

                            </table>

                            <!--<table cellpadding="0" cellspacing="0" role="presentation" width="100%" style="margin-top: 25px;">

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

                            </table>-->

                          </td>
                        </tr>
                      </table>

                    </td>
                  </tr>
                </table>

              </td>
            </tr>
          </table>
          <!--<div class="col-xs-12">
            <div class="contenido_email">
              <h5 style="color: #f37320;">
                A continuación te compartimos la información de tu(s) servicio(s) programado(s).
              </h5>
              <br>

              <table class="table table-bordered" id="table_detalle_solicitud_principal">
                <thead>
                  <tr>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">PASAJERO(S)</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">FECHA DE SOLICITUD</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">EMPRESA SOLICITANTE</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

              <table class="table table-bordered" id="table_detalle_solicitud">
                <thead>
                  <tr>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">FECHA</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">HORA DE RECOGIDA</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">RECOGER EN</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">LLEVAR A</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">CONDUCTOR | VEHICULO</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">OBSERVACIONES</th>
                    <th class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">TRACKING</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

              <br>
              <table>
                <tbody>
                  <tr>
                    <td><span style="color: #f37320">Gestionado por</span></td>
                    <td style="padding: 0 10px;">ADMINISTRADOR SISTEMA</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>-->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger esconder_modal_envio">CANCELAR</button>
        <!--<button type="button" class="btn btn-primary" id="enviar_mail">ENVIAR</button>-->
      </div>
    </div>
  </div>
</div>


<!-- MODAL DE SELECCIÓN -->
<div class="modal open" id="modal_confirmacion_servicios" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <strong>CONFIRMACIÓN DE SERVICIOS</strong>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-xs-4">
            <a id="plantilla" target="_blank" style="background-color: #f47321; float: left; border: 0 solid #f47321; color: white; display: inline-block; font-size: 13px; padding: 8px 50px; text-decoration: none;">Plantilla <i class="fa fa-mail" aria-hidden="true"></i></a>
          </div>

          <div class="col-xs-4">
            <a id="new_ema" target="_blank" style="background-color: gray; float: right; border: 0 solid #f47321; color: white; display: inline-block; font-size: 13px; padding: 8px 50px; text-decoration: none; ; width: 100%; font-family: Arial, Helvetica, sans-serif;">Agregar Correo <i class="fa fa-envelope" aria-hidden="true"></i></a>
            <div class="hidden new_emails">
              <textarea id="nuevos_correos" class="form-control input-font" placeholder="Sepera los correos con punto y coma (;)"></textarea>
              <a id="enviar_nuevos_emails" target="_blank" style="background-color: blue; float: right; border: 0 solid #f47321; color: white; display: inline-block; font-size: 13px; padding: 8px 50px; text-decoration: none; ; width: 100%">Enviar Confirmación <i class="fa fa-send" aria-hidden="true"></i></a>
            </div>
          </div>

          <div class="col-xs-4">
            <a id="new_num" target="_blank" style="background-color: #15FA2B; float: right; border: 0 solid #f47321; color: white; display: inline-block; font-size: 13px; padding: 8px 50px; text-decoration: none; width: 100%; font-family: Arial, Helvetica, sans-serif;">Agregar WhatsApp <i class="fa fa-phone" aria-hidden="true"></i></a>
            <div class="hidden new_numbers">
              <textarea id="nuevos_numeros" class="form-control input-font" placeholder="Sepera los números con punto y coma (;)"></textarea>
              <a id="enviar_nuevos_numbs" target="_blank" style="background-color: orange; float: right; border: 0 solid #f47321; color: white; display: inline-block; font-size: 13px; padding: 8px 50px; text-decoration: none; ; width: 100%">Enviar Confirmación <i class="fa fa-send" aria-hidden="true"></i></a>
            </div>
          </div>

        </div>
        <hr>
        <div class="row">
          <div class="col-xs-6">
            <p style="color: #929292; text-align:left; font-size: 18px; font-family: Arial, Helvetica, sans-serif;" id="lista_correos"></p>
          </div>
          <div class="col-xs-6">
            <p style="color: #929292; text-align:left; font-size: 18px; font-family: Arial, Helvetica, sans-serif;" id="lista_numeros"></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger esconder_modal_confirmacion">CANCELAR</button>
        <!--<button type="button" class="btn btn-primary" id="enviar_mail">ENVIAR</button>-->
      </div>
    </div>
  </div>
</div>
