@if(Sentry::getUser()->id_rol==4 or Sentry::getUser()->id_rol==18 or
    Sentry::getUser()->id_rol==10 or Sentry::getUser()->id_rol==11 or
    Sentry::getUser()->id_rol==3)
    <div id="modal-activar-reconfirmacion">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Reconfirmacion
                    <i id="cerrar_alerta_sino" style="cursor: pointer; float: right; font-weight:100" class="fa fa-close"></i>
                </div>
                <div class="panel-body">
                    <label>Desea activar la reconfirmacion?</label><br>
                    <a id="activar_reconfirmacion" data-option="{{$option_reconfirmacion}}" class="btn-success btn">
                      <div style="vertical-align: super;display: inline-block;">Si</div>
                      <i class="fa fa-2x fa-smile-o"></i>
                    </a>
                    <a id="cerrar_ventana_reconfirmacion" class="btn-danger btn">
                      <div style="vertical-align: super;display: inline-block;">
                        No
                      </div>
                      <i class="fa fa-2x fa-frown-o"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
