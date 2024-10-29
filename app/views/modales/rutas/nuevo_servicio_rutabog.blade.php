<!---MODAL PARA NUEVO SERVICIO-->
<div class="modal fade mymodal" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-servicios">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>NUEVO SERVICIO BOG</strong>
                </div>
                <div class="modal-body tabbable">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#programacion_tab" aria-controls="programacion" id="programacion" role="tab" data-toggle="tab">Programacion de Servicio</a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#ruta_tab" aria-controls="rutas" id="rutas" role="tab">Ruta</a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#ordenes_tab" aria-controls="ordenes" role="tab" id="ordenes">Ordenes de servicio</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="edicion tab-pane fade in active" id="programacion_tab">
                            <div class="row" style="margin-top: 15px">
                                <div class="col-xs-12">
                                    <div class="col-xs-2">
                                        <label>Fecha de orden</label>
                                        <div class="input-group">
                                            <div class="input-group date" id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="fecha_orden" value="{{date('Y-m-d')}}">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2" id="centro_alerta">
                                        <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                        <select class="form-control input-font" id="centro_de_costo">
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
                                    <div class="subcentros hidden">
                                        <div class="col-xs-2">
                                            <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                            <select class="form-control input-font" id="subcentros">
                                                <option>-</option>
                                            </select>
                                        </div>
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
                                                <option>GRUPO</option>
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
                                    </div>
                                    <div class="col-xs-2" style="min-height: 67px;">
                                        <label class="obligatorio" for="departamento">Departamento</label>
                                        <select class="form-control input-font" id="departamento">
                                            <option>-</option>
                                            @foreach($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                        <select disabled class="form-control input-font" id="ciudad">
                                            <option>-</option>
                                        </select>
                                    </div>
                  									<!-- DIV PDF -->
                  									<div class="col-xs-12 hidden" id="pdfs">
                  										<form style="display: inline" id="ingreso_pdfs" enctype="multipart/form-data" method="post">
                  											<div class="col-xs-2">
                  											</div>
                  											<div class="col-xs-2">
                  												<label for="formato_serv">Formato Solicitud:</label>
                  												<label style="height: width:80px;"><input type="file" class="form-control" name="solicitud_pdf" id="solicitud_pdf" accept="application/pdf" data-filename-placement="inside"></label>
                  											</div>
                  											<div class="col-xs-2">
                  											<label for="correo_serv">Correo Autorizado:</label>
                  												<label >
                  													<input type="file" class="form-control" name="correo_pdf" id="correo_pdf" accept="application/pdf" data-filename-placement="inside">
                  												</label>
                  											</div>
                  										</form>
                  									</div>
                  									<!-- DIV PDF -->

                                    <div class="col-xs-12">
                                        <div class="row pasajeros">
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="pax">Pax</label>
                                                <input type="text" class="form-control input-font nombres_pax">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="celular">Celular</label>
                                                <input type="text" class="form-control input-font celular_pax">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="nivel">Nivel</label>
                                                <input type="text" class="form-control input-font nivel_pax">
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="email">Email</label>
                                                <input type="email" class="form-control input-font email_pax" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Fecha de Solicitud</label>
                                        <div class="input-group">
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' class="form-control input-font" id="fecha_solicitud" autocomplete="off">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                        <input id="solicitado_por" type="text" class="form-control input-font" autocomplete="off">
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="email_solicitante">Email solicitante</label>
                                        <input id="email_solicitante" type="text" class="form-control input-font" autocomplete="off">
                                    </div>
                                    <div class="col-xs-2">
                                      <label for="ciudad">Firma y Calificacion</label>
                                      <select class="form-control input-font" id="sv_firma_calificacion">
                                        <option>-</option>
                                        <option value="1">SI</option>
                                        <option value="2">NO</option>
                                      </select>
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
                                                <label class="obligatorio" for="ruta">Ruta</label>
                                                <select class="form-control input-font" id="ruta">
                                                    <option>-</option>
                                                </select>
                                                <!--<small id="agregar_ruta" class="help-block hidden"><a data-toggle="modal" class="shmodal_agregar" href="#shortModal" href="">Agregar ruta!</a></small>-->
                                                <small id="ruta_alerta" class="help-block hidden"><a class="shmodal_noruta" style="color: #a94442">Centro de costo sin rutas solicite una!</a></small>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="recoger_en">Recoger en</label>
                                                <input type="text" class="form-control input-font" id="recoger_en">
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="dejar_en">Dejar en</label>
                                                <input type="text" class="form-control input-font" id="dejar_en">
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="detalle_recorrido">Detalle del recorrido</label>
                                                <textarea class="form-control input-font" id="detalle_recorrido"></textarea>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="detalle_recorrido">Nombre ruta</label>
                                                <select class="form-control input-font" name="select_nombre_ruta"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 proveedor_content">
                                        <label class="obligatorio">Proveedor</label>
                                        <div class="input-group">
                                            <select data-option="1" type="text" class="form-control input-font" id="proveedor">
                                                <option value="0">PROVEEDORES</option>
                                                @foreach($proveedores as $proveedor)
                                                    @if($proveedor->inactivo!=1)
                                                        <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="input-group-addon proveedor_eventual" style="cursor: pointer"><i class="fa fa-car"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="conductor">Conductor</label>
										                    <small role="alert" class="text-danger conductor_alert hidden"></small>
                                        <select disabled class="form-control input-font" id="conductor" estado="false">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="vehiculo">Vehiculo</label>
										                    <small role="alert" class="text-danger vehiculo_alert hidden"></small>
                                        <select disabled class="form-control input-font" id="vehiculo" estado="false">
                                            <option>-</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio">Tipo de servicio</label>
                                        <div class="form-group">
                                            <label id="id_unico" class="radio-inline">
                                                <input checked type="radio" name="radio_tipo" id="inlineRadio1" value="1"> Unico
                                            </label>
                                            <label id="id_multiple" class="radio-inline">
                                                <input type="radio" name="radio_tipo" id="inlineRadio2" value="2"> Multiple
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 unico">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <label for="fecha_servicio">Fecha de servicio</label>
                                                <div class="input-group">
                                                    <div class="input-group date" id="datetimepicker2">
                                                        <input type="text" class="form-control input-font" id="fecha_servicio" value="{{date('Y-m-d')}}">
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
                                            <div class="col-xs-1">
                                                <label class="obligatorio" for="resaltar">Resaltar</label>
                                                <select class="form-control input-font" id="resaltar">
                                                    <option>-</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="pago_directo">Pago Directo</label>
                                                <select class="form-control input-font" id="pago_directo">
                                                    <option>-</option>
                                                    <option value="1">SI</option>
                                                    <option value="0">NO</option>
                                                </select>
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
                                            <th>Conductor</th>
                                            <th>Vehiculo</th>
                                            <th>Informacion</th>
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
                                            <th>Conductor</th>
                                            <th>Vehiculo</th>
                                            <th>Informacion</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <button id="agregar_mas" class="btn btn-info btn-icon">Agregar mas<i class="fa fa-plus icon-btn"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success btn-icon" id="continuar">Continuar<i class="fa fa-arrow-right icon-btn"></i></a>
                    <a id="programar" class="btn btn-redu btn-icon disabled">Programar<i class="fa fa-play icon-btn"></i></a>
                    <a id="guardar" class="btn btn-primary btn-icon disabled">Guardar<i class="fa fa-floppy-o icon-btn"></i></a>
                    <a data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div>
    </div><!-- /.modal-content -->
</div>
