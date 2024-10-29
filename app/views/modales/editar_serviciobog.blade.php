<div class="modal mymodal1" id="myModal1" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-servicios" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>EDITAR SERVICIO</strong>
        </div>
        <div class="modal-body tabbable">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#programacion_tab_editar" aria-controls="programacion_editar" id="programacion_editar" role="tab" data-toggle="tab">Programacion de Servicio</a>
                </li>
                <li role="presentation">
                    <a href="#ruta_tab_editar" aria-controls="rutas_editar" id="rutas_editar" role="tab" data-toggle="tab">Ruta</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="programacion_tab_editar">
                    <div class="row" style="margin-top: 15px">
                        <div class="col-xs-12">
                            <div class="col-xs-2">
                                <label>Fecha de orden</label>
                                <div class="input-group">
                                    <div class="input-group date" id='datetimepicker1'>
                                        <input type='text' class="form-control input-font fecha_orden" disabled>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                <select class="form-control input-font centro_de_costo" data-live-search="true">
                                    <option>-</option>
                                    @foreach($centrosdecosto as $centrodecosto)
                                        @if($centrodecosto->inactivo==1)
                                            <option disabled value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                        @else
                                            <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
                            </div>

                            <div class="col-xs-2">
                                <label class="obligatorio" for="subcentro">Subcentro de costo</label>
                                <select class="form-control input-font subcentro">
                                    <option>-</option>
                                </select>
                            </div>

                            <div class="col-xs-2 usuario_app hidden">
                                <label class="obligatorio" for="usuario_app">Usuario App</label>
                                <select class="form-control input-font" id="usuario_app">
                                    <option>-</option>
                                </select>
                            </div>

                            <div class="col-xs-1">
                                <label class="obligatorio" for="numero_pax"># pax</label>
                                <select class="form-control input-font" id="numero_pax_editar">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>GRUPO</option>
                                </select>
                            </div>
                            <div class="col-xs-1 grupo_numero_editar hidden">
                                <label for="grupo_numero">Cantidad</label>
                                <select class="form-control input-font" id="grupo_numero_editar">
                                    @for ($i = 1; $i < 201; $i++)
                                        <option>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-xs-2">
                                <label class="obligatorio" for="departamento">Departamento</label>
                                <select class="form-control input-font departamento">
                                    <option>-</option>
                                    @foreach($departamentos as $departamento)
                                        <option>{{$departamento->departamento}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                <select disabled class="form-control input-font ciudad">
                                    <option>-</option>
                                </select>
                            </div>
                            <div class="col-xs-12">
                                <div class="row grupo_de_pasajeros">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="pax">Pax</label>
                                        <input type="text" class="form-control input-font nombres">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="celular">Celular</label>
                                        <input type="text" class="form-control input-font celular">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="nivel">Nivel</label>
                                        <input type="text" class="form-control input-font nivel">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="email">Email</label>
                                        <input type="text" class="form-control input-font email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <label>Fecha de Solicitud</label>
                                <div class="input-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control input-font fecha_solicitud" disabled>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                <input id="solicitado_por" type="text" class="form-control input-font solicitado_por" autocomplete="off">
                            </div>
                            <div class="col-xs-2">
                                <label for="email_solicitante">Email solicitante</label>
                                <input type="text" class="form-control input-font email_solicitante" autocomplete="off">
                            </div>
                            <div class="col-xs-2">
                                <label for="firma">Firma y Calificacion</label>
                                <select class="form-control input-font firma">
                                    <option>-</option>
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="ruta_tab_editar">
                    <div class="row" style="margin-top: 15px">
                        <div class="col-xs-12">
                            <div class="col-lg-12">
                                <div class="row">
                                  <div class="col-xs-3" style="z-index: 11;">
                                      <label class="obligatorio" for="ruta">Ruta</label>
                                      <select class="form-control input-font ruta" data-live-search="true">
                                          <option>-</option>
                                      </select>
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="recoger_en">Recoger en</label>
                                      <input type="text" id="recoger_en_editar" class="form-control input-font recoger_en" autocomplete="off">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="dejar_en">Dejar en</label>
                                      <input type="text" id="dejar_en_editar" class="form-control input-font dejar_en" autocomplete="off">
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="detalle_recorrido">Detalle del recorrido</label>
                                      <textarea class="form-control input-font detalle_recorrido"></textarea>
                                  </div>
                                </div>
                            </div>
                            <div class="col-xs-3 proveedor_content">
                                <label class="obligatorio">Proveedor</label>
                                <select data-option="1" type="text" class="form-control input-font proveedor" name="proveedor" data-live-search="true">
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <small role="alert" class="text-danger conductor_alert hidden"></small>
                                <label class="obligatorio" for="conductor">Conductor</label>
                                <select class="form-control conductor input-font" name="conductor">
                                    <option>-</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label class="obligatorio" for="vehiculo">Vehiculo</label>
                                <small role="alert" class="text-danger vehiculo_alert hidden"></small>
                                <select class="form-control input-font vehiculo" name="vehiculo">
                                    <option>-</option>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                      <label class="obligatorio" for="nombre_ruta">Nombres de ruta</label>
                                      <select class="form-control input-font select_nombre_ruta_editar"></select>
                                  </div>
                            <div class="col-xs-12 unico">

                                <div class="row">
                                    <div class="col-xs-2">
                                        <label for="fecha_servicio">Fecha de servicio</label>
                                        <div class="input-group">
                                            <div class="input-group date" id="datetimepicker2">
                                                <input type="text" class="form-control input-font fecha_servicio" value="{{date('Y-m-d')}}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="hora_servicio">Hora de servicio</label>
                                        <div class="input-group">
                                            <div class="input-group date" id="datetimepicker3">
                                                <input type="text" class="form-control input-font hora_servicio_editar">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-1">
                                        <label class="obligatorio" for="resaltar">Resaltar</label>
                                        <select class="form-control input-font resaltarr">
                                            <option>-</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="resaltar">Pago Directo</label>
                                        <select class="form-control input-font pago_directo_editar">
                                            <option>-</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="resaltar">Notificacion</label>
                                        <select class="form-control input-font notificacion_editar">
                                          <option>-</option>
                                          <option value="1">SI</option>
                                          <option value="0">NO</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12">
                                        <h5 style="border-bottom: 1px dashed #CCCCCC;">ITINERARIO</h5>
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label for="origen">Origen</label>
                                                <input type="text" class="form-control input-font origen">
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="origen">Destino</label>
                                                <input type="text" class="form-control input-font destino">
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="origen">Aerolinea</label>
                                                <input type="text" class="form-control input-font aerolinea">
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="origen">Vuelo</label>
                                                <input type="text" class="form-control input-font vuelo">
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="hora_servicio">Hora de salida</label>
                                                <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker7">
                                                        <input type="text" class="form-control input-font hora_salida">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                                <label for="hora_servicio">Hora de llegada</label>
                                                <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker8">
                                                        <input type="text" class="form-control input-font hora_llegada">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal-footer">
        @if(Sentry::getUser()->id_rol==16 or Sentry::getUser()->id_rol==1 or Sentry::getUser()->id_rol==2 or Sentry::getUser()->id_rol==8 or Sentry::getUser()->id_rol==10 or Sentry::getUser()->id_rol==11 or Sentry::getuser()->id_rol==32 or Sentry::getuser()->id_rol==33)

          <a id="actualizar_servicio" class="btn btn-info btn-icon">Actualizar<i class="fa fa-refresh icon-btn"></i></a>

        @else

          <a id="autorizar_editar_servicio" class="btn btn-info btn-icon">Actualizar<i class="fa fa-refresh icon-btn"></i></a>

        @endif

        <a data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
    </div>
    </div>
  </div>
</div>
