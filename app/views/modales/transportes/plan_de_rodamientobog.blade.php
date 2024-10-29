<div class="modal fade" id="modal_plan_rodamiento" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="get" action="{{url('transportes/planderodamientobog')}}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <strong>PLAN DE RODAMIENTO BOG </strong>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-6">
                  <label for="">Fecha Inicial</label>
                  <div class="input-group date fechas_datetimepicker">
                    <input type="text" class="form-control input-font" name="fecha_inicial" autocomplete="off">
                    <span class="input-group-addon">
                        <span class="fa fa-calendar">
                        </span>
                    </span>
                  </div>
                </div>
                <div class="col-xs-6">
                  <label for="">Fecha Final</label>
                  <div class="input-group date fechas_datetimepicker">
                    <input type="text" class="form-control input-font" name="fecha_final" autocomplete="off">
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
