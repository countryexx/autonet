<div class="modal fade modal_cronograma" id="modal_cronograma" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="get" action="{{url('reportes/cronogramaserviciosbogota')}}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>CRONOGRAMA DE SERVICIOS </strong>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-4">
                  <label for="">Fecha</label>
                  <div class="input-group date fechas_datetimepicker">
                    <input type="text" class="form-control input-font" name="fecha" id="fecha" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar">
                        </span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a type="button" class="btn btn-default" data-dismiss="modal">CERRAR</a>
          <button type="submit" class="btn btn-success">VER <i class="fa fa-search"></i></button>
        </div>
      </form>

    </div>
  </div>
</div>
