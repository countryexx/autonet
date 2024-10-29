<div class="modal fade" id="modal_programar_servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong>PROGRAMACION DE SERVICIO EJECUTIVO</strong>
      </div>
      <div class="modal-body tabbable">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active">
                  <a href="#programacion_tab" aria-controls="programacion" id="programacion" role="tab" data-toggle="tab">Programacion de Servicio</a>
              </li>
              <li role="presentation" class="disabled">
                  <a href="#ruta_tab" aria-controls="rutas" id="rutas" aria-expanded="true" role="tab" data-toggle="tab">Ruta</a>
              </li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
              <div role="tabpanel" class="edicion tab-pane fade in active" id="programacion_tab">
                  <div class="row" style="margin-top: 15px">
                      <div class="col-xs-12">
                          <div class="col-xs-4" id="centro_alerta">
                              <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                              <select class="form-control input-font" id="centro_de_costo" name="centrodecosto">
                                <option value="0">-</option>
                                @foreach ($centrosdecosto as $centrodecosto)
                                  <option value="{{$centrodecosto->id}}">{{$centrodecosto->razonsocial}}</option>
                                @endforeach
                              </select>
                              <small id="subcentro_alerta" class="help-block hidden">No tiene subcentro de costo, agregue uno!</small>
                          </div>
                          <div class="subcentros">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                  <select class="form-control input-font disabled" name="subcentrodecosto" id="subcentros_select" disabled>
                                      <option>-</option>
                                      @foreach ($subcentrosdecosto as $subcentrodecosto)
                                        <option value="{{$subcentrodecosto->id}}">{{$subcentrodecosto->nombresubcentro}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <!--<div class="numero_pax">
                              <div class="col-xs-1">
                                  <label class="obligatorio" for="numero_pax"># pax</label>
                                  <select class="form-control input-font" id="numero_pax">
                                      <option value="1" selected="">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="GRUPO">GRUPO</option>
                                  </select>
                              </div>
                              <div class="col-xs-1 grupo_numero hidden">
                                  <label for="grupo_numero">Cantidad</label>
                                  <select class="form-control input-font" id="grupo_numero">
                                    @for ($i=1; $i < 41; $i++)
                                      <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                  </select>
                              </div>
                          </div>-->
                          <div class="col-xs-3" style="min-height: 67px;">
                              <label class="obligatorio" for="departamento">Departamento</label>
                              <select class="form-control input-font" name="departamento" id="departamento">
                                @foreach ($departamentos as $departamento)
                                  <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="col-xs-3">
                              <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                              <select disabled="" class="form-control input-font" name="ciudad">
                                  <option>-</option>
                              </select>
                          </div>

                          <div class="col-xs-12">
                              <div class="row pasajeros">
                                  
                              </div>
                          </div>
                          <div class="col-xs-2">
                              <label>Fecha de Solicitud</label>
                              <div class="input-group">
                                  <div class="input-group date" id="datetimepicker1">
                                      <input type="text" class="form-control input-font" id="fecha_solicitud" name="fecha_solicitud" disabled="true" value="">
                                      <span class="input-group-addon">
                                          <span class="fa fa-calendar">
                                          </span>
                                      </span>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-3">
                              <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                              <input id="solicitado_por" type="text" class="form-control input-font">
                          </div>                          
                          <div class="col-xs-3">
                              <label for="email_solicitante">Email del solicitante</label>
                              <input id="email_solicitante" name="email_solicitante" type="text" class="form-control input-font">
                          </div>  
                          <div class="col-xs-4 ciudad_excel hidden">
                              <label for="site">CIUDAD</label>
                              <input id="ciudad" name="ciudad" type="text" class="form-control input-font" disabled="true">
                          </div>
                      </div>
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane fade" id="ruta_tab">
                  <div class="row" style="margin-top: 15px">
                      <div class="col-xs-12">
                          <div class="col-lg-12">
                              <div class="row">
                                  <div class="col-xs-4" style="z-index: 11">
                                      <label class="obligatorio" for="ruta">Ruta</label>
                                      <select class="form-control input-font selectpicker" name="ruta" data-live-search="true" data-size="10" data-header="Selecciona una ruta">
                                          <option value="0">RUTAS</option>
                                          @foreach ($tarifas_grupo as $tarifa_grupo)
                                            <optgroup label="{{$tarifa_grupo->tarifa_ciudad}}">
                                              @foreach ($tarifas as $tarifa)
                                                @if ($tarifa_grupo->tarifa_ciudad==$tarifa->tarifa_ciudad)
                                                  <option value="{{$tarifa->id}}">{{$tarifa->tarifa_nombre}}</option>
                                                @endif
                                              @endforeach
                                            </optgroup>
                                          @endforeach
                                      </select>
                                      <!--<small id="agregar_ruta" class="help-block hidden"><a data-toggle="modal" class="shmodal_agregar" href="#shortModal" href="">Agregar ruta!</a></small>-->
                                      <small id="ruta_alerta" class="help-block hidden">
                                          <a class="shmodal_noruta" style="color: #a94442">Centro de costo sin rutas solicite una!</a>
                                      </small>
                                  </div>
                                  <div class="col-xs-4">
                                    <div class="row">
                                      <div class="col-xs-6">
                                          <label class="obligatorio" for="recoger_en">Recoger en</label>
                                          <select class="form-control input-font" name="recoger_en">
                                          </select>
                                      </div>
                                      <div class="col-xs-6">
                                          <label class="obligatorio" for="dejar_en">Dejar en</label>
                                          <select class="form-control input-font" name="dejar_en">
                                          </select>
                                      </div>
                                      <a href="#" class="btn btn-primary edit_select">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                      </a>
                                    </div>
                                  </div>
                                  <div class="col-xs-4">
                                      <label class="obligatorio" for="detalle_recorrido">Detalle del recorrido</label>
                                      <textarea class="form-control input-font" name="detalle_recorrido">TRASLADO APP MOVIL</textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-4 proveedor_content">
                              <label class="obligatorio">Proveedor</label>
                              <div class="input-group">
                                  <select data-option="1" type="text" class="form-control input-font selectpicker" name="proveedor" data-live-search="true" data-size="10" data-header="Selecciona un proveedor">
                                    <option value="0">PROVEEDORES</option>
                                    @foreach ($proveedores as $proveedor)
                                      <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                                    @endforeach
                                  </select>
                                  <div class="input-group-addon proveedor_eventual" style="cursor: pointer"><i class="fa fa-car"></i></div>
                              </div>
                          </div>
                          <div class="col-xs-4">
                              <label class="obligatorio" for="conductor">Conductor</label>
                              <small role="alert" class="text-danger conductor_alert hidden"></small>
                              <select class="form-control input-font selectpicker" name="conductor" estado="false">
                                  <option>-</option>
                              </select>
                          </div>
                          <div class="col-xs-4">
                              <label class="obligatorio" for="vehiculo">Vehiculo</label>
                              <small role="alert" class="text-danger vehiculo_alert hidden"></small>
                              <select class="form-control input-font selectpicker" name="vehiculo" estado="false">
                                  <option>-</option>
                              </select>
                          </div>
                          <div class="col-xs-12 unico">
                              <div class="row">
                                  <div class="col-xs-2 container_fecha_multiple">
                                      <label for="fecha_servicio">Fecha de los servicios</label>
                                      <div class="input-group">
                                          <div class="input-group date" id="datetimepicker2">
                                              <input type="text" class="form-control input-font" name="fecha_servicio_multiple" readonly autocomplete="off">
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar">
                                                  </span>
                                              </span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xs-2 container_fecha">
                                      <label for="fecha_servicio">Fecha de servicio</label>
                                      <div class="input-group">
                                          <div class="input-group date" id="datetimepicker2">
                                              <input type="text" class="form-control input-font" name="fecha_servicio" autocomplete="off">
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
                                              <input type="text" class="form-control input-font" name="hora_servicio">
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar">
                                                  </span>
                                              </span>
                                          </div>
                                      </div>
                                  </div>                                 
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="notificacion">Notificacion Conductor</label>
                                      <select class="form-control input-font" id="notificacion_conductor">
                                          <option>-</option>
                                          <option value="1">SI</option>
                                          <option value="0">NO</option>
                                      </select>
                                  </div>
                                  <div class="col-xs-3">
                                      <label class="obligatorio" for="notificacion">Enviar Email al solicitante</label>
                                      <select class="form-control input-font" id="email_cliente" name="email_cliente">
                                          <option>-</option>
                                          <option value="1">SI</option>
                                          <option value="0">NO</option>
                                      </select>
                                  </div>
                                  
                                  <div class="col-xs-2 container_viaje hidden">
                                      <label class="obligatorio" for="pax">Número de Viaje</label>
                                      <input id="viaje" type="text" class="form-control input-font viaje">
                                  </div>
                                      
                                  <div class="col-xs-12">
                                      <h5 style="border-bottom: 1px dashed #CCCCCC;;">ITINERARIO</h5>
                                      <div class="row">
                                          <div class="col-xs-2">
                                              <label for="origen">Origen</label>
                                              <input type="text" class="form-control input-font" name="origen" id="origen">
                                          </div>
                                          <div class="col-xs-2">
                                              <label for="origen">Destino</label>
                                              <input type="text" class="form-control input-font" name="destino" id="destino">
                                          </div>
                                          <div class="col-xs-2">
                                              <label for="origen">Aerolinea</label>
                                              <input type="text" class="form-control input-font" name="aerolinea" id="aerolinea">
                                          </div>
                                          <div class="col-xs-2">
                                              <label for="origen">Vuelo</label>
                                              <input type="text" class="form-control input-font" name="vuelo" id="vuelo">
                                          </div>
                                          <div class="col-xs-2">
                                              <label for="hora_servicio">Hora de salida</label>
                                              <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker7">
                                                      <input type="text" class="form-control input-font" name="hora_salida" id="hora_salida">
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
                                                      <input type="text" class="form-control input-font" name="hora_llegada" id="hora_llegada">
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
        <!--<button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
        <button type="button" class="btn btn-primary" data-multiple="0" id="">GUARDAR</button>-->

        <button type="button" class="button" style="background: red; margin-right: 15px; border: 1px solid red;" data-dismiss="modal">Cerrar <i class="fa fa-close" aria-hidden="true"></i></button>
        <button type="button" style="float: right" class="button" id="programar_servicio">Guardar <i class="fa fa-save" aria-hidden="true"></i></button>
      </div>
    </div>
  </div>
</div>
