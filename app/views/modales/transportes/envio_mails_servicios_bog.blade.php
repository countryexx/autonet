<div class="modal open" id="open_modal_envio_mails_servicios" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <strong>ENVIO DE MAIL DE SERVICIOS</strong>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <div class="form-group">
              <label class="obligatorio" style="display: block;">Para:</label>
              <input type="text" class="form-control input-font" name="envio_mail_correo_electronico" data-role="tagsinput">
            </div>
          </div>
          <div class="col-xs-12">
            <div class="form-group">
              <label for="" style="display: block;">CC:</label>
              <input type="text" class="form-control input-font" name="envio_mail_cc_correo_electronico">
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="obligatorio">Asunto:</label>
                  <input type="text" style="text-transform: unset; font-size: 13px !important;" class="form-control input-font" name="envio_asunto" placeholder="Ej: Solicitud de traslados">
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group">
                  <label class="obligatorio">Detalles:</label>
                  <textarea style="margin-bottom: 10px; text-transform: unset; font-size: 13px !important;" name="contenido_mail" rows="4" class="form-control input-font textarea">Cordial Saludo.

De acuerdo a su amable solicitud le confirmo la coordinación de sus traslados, ante cualquier inquietud por favor no dude en contactarnos.</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="contenido_email">
              <!--<img src="http://localhost/autonet/img/logo_aotour.png" alt=""
                  style="width: 150px;"
              />-->
              <h6 style="color: #f37320;">
                SOLICITUD DE TRASLADOS / TRANSFER REQUEST
              </h6>
              <table class="table table-bordered" style="width: 100%;" id="table_datos_traslado">
                <thead>
                  <tr>
                    <th colspan="5" style="text-align: center; color: #333">DATOS DEL TRASLADO / DATA TRANSFER</th>
                  </tr>
                  <tr bgcolor="#DDDDDD">
                    <th colspan="2">PAX</th>
                    <th>FECHA SOLICITUD TRASLADO / <br>
                        TRANSFER REQUEST DATE
                    </th>
                    <th>GESTIONADO POR / <br>
                        MANAGED BY
                    </th>
                    <th>EMPRESA SOLICITANTE / <br>
                        APPLICANT COMPANY
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="2">
                      <input type="text" class="form-control input-font" value="">
                    </td>
                    <td>
                      <input type="text" class="form-control input-font" value="">
                    </td>
                    <td>
                      <input type="text" class="form-control input-font" value="">
                    </td>
                    <td>
                      <input type="text" class="form-control input-font" value="">
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-bordered" id="table_detalle_solicitud">
                <thead>
                  <tr>
                    <th colspan="6" align="center">DETALLE SOLICITUD DE TRASLADOS / TRANSFER DETAILS</th>
                  </tr>
                  <tr bgcolor="#DDDDDD">
                    <th>FECHA / DATE</th>
                    <th>HORA DE RECOGIDA / TIME PICKUP</th>
                    <th>RECOGER EN / PICKUP</th>
                    <th>LLEVAR A / CARRY</th>
                    <th>CONDUCTOR | VEHICULO / DRIVER | VEHICLE</th>
                    <th>OBSERVACIONES / COMMENTS</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-primary" id="enviar_mail">ENVIAR</button>
      </div>
    </div>
  </div>
</div>
