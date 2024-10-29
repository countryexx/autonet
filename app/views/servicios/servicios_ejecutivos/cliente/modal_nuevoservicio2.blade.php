<div class="modal mymodal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" class="primary">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              <i class="fa fa-times"></i>
          </button>
          <strong>SOLICITUD DE SERVICIO</strong>
      </div>
      <div class="modal-body tabbable">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active">
              <a href="#programacion_tab" aria-controls="programacion" id="programacion" role="tab" data-toggle="tab">Programacion de Solicitud</a>
          </li>
          <li role="presentation">
              <a href="#ruta_tab" aria-controls="rutas" id="rutas" role="tab">Ruta</a>
          </li>
          <li role="presentation">
              <a href="#ordenes_tab" aria-controls="ordenes" role="tab" id="ordenes">Detalles de la orden</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="programacion_tab">
                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-12">

                        <div class="col-xs-3">
                            <label class="obligatorio" for="sede_a_solicitar">Sede a Solicitar</label>
                            <select class="form-control input-font" id="sede_a_solicitar">
                                <option>Seleccionar Sede</option>
                                <option>Barranquilla</option>
                                <option>Bogota</option>
                            </select>
                        </div>

                        <div class="col-xs-3" style="min-height: 67px;">
                            <label class="obligatorio" for="departamento">Departamento</label>
                            <select class="form-control input-font" id="departamento" data-live-search="true">
                                <option>-</option>
                                @foreach($departamentos as $departamento)
                                    <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                            <select disabled class="form-control input-font" id="ciudad">
                                <option>-</option>
                            </select>
                        </div>

                        <div class="numero_pax">
                            <div class="col-xs-1">
                                <label class="obligatorio" for="numero_pax"># pax</label>
                                <select class="form-control input-font" id="numero_pax">
                                    <option selected>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="col-xs-1 grupo_numero hidden">
                                <label for="grupo_numero">Cantidad</label>
                                <select class="form-control input-font" id="grupo_numero">
                                    @for ($i = 1; $i < 201; $i++)
                                        <option>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <label class="obligatorio" for="pax">Sucursal</label>
                                <input type="text" class="form-control input-font sucursal" id="sucursal" autocomplete="off">
                            </div>

                        </div>

                        <div class="col-xs-12">
                            <div class="row pasajeros">
                                <div class="col-xs-4">
                                    <label class="obligatorio" for="pax">Nombre</label>
                                    <input type="text" class="form-control input-font nombres_pax" autocomplete="off">
                                </div>
                                <div class="col-xs-3">
                                    <label class="" for="celular">Celular</label>
                                    <input type="text" class="form-control input-font celular_pax" autocomplete="off">
                                </div>
                                <div class="col-xs-4">
                                    <label class="" for="email">Email</label>
                                    <input type="text" class="form-control input-font email_pax" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <label>Fecha de Solicitud</label>
                            <div class="input-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control input-font" disabled="true" id="fecha_solicitud" value="<?php echo date('Y-m-d') ?>">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="solicitado_por">Nombre del solicitante</label>
                            <input id="solicitado_por" disabled="true" value="{{Sentry::getUser()->first_name}} {{Sentry::getUser()->last_name}}" type="text" class="form-control input-font" autocomplete="off">
                        </div>
                        <div class="col-xs-4">
                            <label class="obligatorio" for="email_solicitante">Email del solicitante</label>
                            <input id="email_solicitante" disabled="true" value="{{Sentry::getUser()->username}}" type="text" class="form-control input-font" autocomplete="off">
                        </div>
                        <div class="col-xs-3">
                            <label class="obligatorio" for="celular">Centro de costo</label>
                            <input type="text" class="form-control input-font centrodecosto" id="centrodecosto" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="ruta_tab">
                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-12">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-xs-3">
                                    <label class="obligatorio" for="recoger_en">Recogida</label>
                                    <input type="text" class="form-control input-font" id="recoger_en" autocomplete="off">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="dejar_en">Destino</label>
                                    <input type="text" class="form-control input-font" id="dejar_en" autocomplete="off">
                                </div>
                                <div class="col-xs-5">
                                    <label for="detalle_recorrido">Detalle del recorrido</label>
                                    <textarea class="form-control input-font" id="detalle_recorrido"></textarea>
                                </div>
                            </div>
                        </div>

                        <!--<div class="col-xs-3">
                            <label class="obligatorio">Tipo de servicio</label>
                            <div class="form-group">
                                <label id="id_unico" class="radio-inline">
                                    <input checked type="radio" name="radio_tipo" id="inlineRadio1" value="1"> Unico
                                </label>
                            </div>
                        </div>-->
                        <div class="col-xs-12 unico">
                            <div class="row">
                                <div class="col-xs-2">
                                    <label for="fecha_servicio">Fecha de servicio</label>
                                    <div class="input-group">
                                        <div class="input-group date" id="datetimepicker2">
                                            <input type="text" class="form-control input-font" id="fecha_servicio" value="{{date('Y-m-d')}}" autocomplete="off">
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
                                            <input type="text" class="form-control input-font" id="hora_servicio" autocomplete="off">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <h5 style="border-bottom: 1px dashed #CCCCCC;;">ITINERARIO</h5>
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <label for="origen">Origen</label>
                                            <input type="text" class="form-control input-font" id="origen">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="origen">Destino</label>
                                            <input type="text" class="form-control input-font" id="destino">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="origen">Aerolinea</label>
                                            <input type="text" class="form-control input-font" id="aerolinea">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="origen">Vuelo</label>
                                            <input type="text" class="form-control input-font" id="vuelo">
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="hora_servicio">Hora de salida</label>
                                            <div class="input-group">
                                                <div class="input-group date" id="datetimepicker7">
                                                    <input type="text" class="form-control input-font" id="hora_salida">
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
                                                    <input type="text" class="form-control input-font" id="hora_llegada">
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
                        <div class="col-xs-12 multiple hidden">
                            <div class="row">
                                <div class="col-xs-12">
                                </div>
                                <div class="rangos">
                                    <div class="col-xs-2">
                                        <label>Hora de los servicios</label>
                                        <div class="input-group">
                                            <div class="input-group date" id="datetimepicker3">
                                                <input type="text" class="form-control input-font" id="hora_servicios">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Fecha inicial</label>
                                        <div class="input-group">
                                            <div class="input-group date" id="datetimepicker5">
                                                <input name="rangos_a" type="text" class="form-control input-font" id="rango_a" value="{{date('Y-m-d')}}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Fecha final</label>
                                        <div class="input-group">
                                            <div class="input-group date" id="datetimepicker6">
                                                <input name="rangos_b" type="text" class="form-control input-font" id="rango_b">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="notificacion">Notificacion</label>
                                        <select class="form-control input-font" id="notificacion_multiple">
                                            <option>-</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <button id="agregar_fecha" style="margin-top: 31px" class="btn btn-info"><i class="fa fa-plus"></i></button>
                                    <button style="margin-top: 31px" class="btn btn-danger hidden"><i class="fa fa-close"></i></button>
                                </div>
                                <div class="hora_servicio" id="servicios_horas">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="edicion tab-pane fade" id="ordenes_tab">
                <div class="row" style="margin-top: 15px">
                    <div class="col-xs-12">
                        <table style="margin-bottom: 15px;" class="table table-bordered" id="servicios">
                            <thead>
                            <tr>
                                <th>Ruta</th>
                                <th>Detalle</th>
                                <th>Recoger en</th>
                                <th>Dejar en</th>
                                <th>Fecha de inicio</th>
                                <th>Hora de inicio</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                <th>Informacion (si aplica)</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Ruta</th>
                                <th>Detalle</th>
                                <th>Recoger en</th>
                                <th>Dejar en</th>
                                <th>Fecha de inicio</th>
                                <th>Hora de inicio</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                <th>Informacion (si aplica)</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                        <!--
                        <button id="agregar_mas" class="btn btn-info btn-icon">Agregar mas<i class="fa fa-plus icon-btn"></i></button> -->
                        <button type="button" name="button" class="btn btn-primary btn-icon hidden" id="enviar_mail_servicios">
                          MAIL <i class="fa fa-envelope icon-btn"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-success btn-icon" id="continuar">
          Continuar
          <i class="fa fa-arrow-right icon-btn"></i>
        </a>
        <a class="btn btn-warning btn-icon hidden" id="volver">
          Volver
          <i class="fa fa-arrow-left icon-btn"></i>
        </a>
        <a id="programar" class="btn btn-redu btn-icon disabled">
          Programar
          <i class="fa fa-play icon-btn"></i>
        </a>
        <a id="guardar" class="btn btn-primary btn-icon disabled" data-option="1">
          Guardar
          <i class="fa fa-floppy-o icon-btn"></i>
        </a>
        <a data-dismiss="modal" class="btn btn-danger btn-icon">
          Cerrar
          <i class="fa fa-times icon-btn"></i>
        </a>
      </div>
    </div>
  </div>
</div>
