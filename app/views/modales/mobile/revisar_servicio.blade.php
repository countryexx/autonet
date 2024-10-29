<div class="modal" id="open_modal_revisar_servicio" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>REVISAR SERVICIO</strong>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label for="detalle">Valor Tarifa</label>
                <input type="text" class="form-control input-font" id="valor_tarifa" name="valor_tarifa" placeholder="Escriba el valor de la tarifa" autocomplete="off">
              </div>
              <fieldset>
                <legend style="margin-bottom: 10px;" class="input-font">NOVEDADES</legend>
                <form id="form_novedades_servicio">
                  <div class="form-group">
                    <label for="detalle">Detalle</label>
                    <input type="text" class="form-control input-font" id="detalle" name="detalle" placeholder="Escriba el detalle de la novedad" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" class="form-control input-font" id="valor" name="valor" placeholder="Digite el valor de la novedad" autocomplete="off">
                  </div>
                  <button type="submit" class="btn btn-success">AGREGAR <i class="fa fa-plus"></i></a>
                </form>
              </fieldset>
            </div>
            <div class="col-xs-12">
              <div class="container_novedades hidden">
                <h5>Listado de novedades</h5>
                <ul class="list-group" id="listado"></ul>
              </div>
              <div class="container_totales hidden">
                <p><span style="color: #F47321">Valor Tarifa: </span>$ <span class="valor_tarifa" style="font-size: 13px"></span></p>
                <p><span style="color: #F47321">Novedades: </span>$ <span class="total_novedades" style="font-size: 13px"></span></p>
                <p><span style="color: #F47321">Subtotal: </span>$ <span class="subtotal" style="font-size: 13px"></span></p>
                <p><span style="color: #F47321">Comision PayU: </span>$ <span class="comision" style="font-size: 13px"></span></p>
                <p><span style="color: #F47321">Iva Comision PayU: </span>$ <span class="comision_iva" style="font-size: 13px"></span></p>
                <p><span style="color: #F47321">Total: </span>$ <span class="totales" style="font-size: 13px"></span></p>
              </div>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
        <button type="submit" class="btn btn-primary disabled" id="liquidar">LIQUIDAR</button>
        <a class="btn btn-default" id="revisar">REVISAR <i class="fa fa-file-text-o"></i></a>
      </div>
    </div>
  </div>
</div>
