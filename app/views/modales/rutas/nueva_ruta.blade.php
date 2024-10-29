<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>AGREGAR RUTA</strong>
          </div>
            <div class="modal-body tabbable">
                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                    <li role="presentation" class="active">
                        <a href="#prog_ex" aria-controls="progr_exx" id="prog_exx" role="tab" data-toggle="tab">Programacion de Ruta</a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#ex_ruta" aria-controls="exx_ruta" id="exx_ruta" role="tab">Importar Listado</a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#ex_programar" aria-controls="e" id="exx_programar" role="tab">Ruta</a>
                    </li>
                    <li role="presentation">
                        <a href="#export_exce_ruta" aria-controls="e" id="export_ruta" role="tab" data-toggle="tab">Exportar</a>
                    </li>
                    <li role="presentation">
                        <a href="#export_exce_ruta2" aria-controls="e" id="export_ruta2" role="tab" data-toggle="tab">Exportar Dia</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_nombres_ruta" aria-controls="e" id="nombres_ruta" role="tab" data-toggle="tab">Nombres de ruta</a>
                    </li>
                </ul>
                <div class="tab-content">
                  <div role="tabpanel" class="tab-pane fade in active" id="prog_ex">
                      <div class="row" style="margin-top: 15px">
                        <div class="col-xs-12">
                            <div class="col-xs-2">
                                <label>Fecha de servicio</label>
                                <div class="input-group">
                                    <div class="input-group date" id='datetimepicker1'>
                                        <input type='text' class="form-control input-font" id="ruta_fecha_servicio" value="{{date('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2" id="centro_alerta">
                                <label class="obligatorio" for="centro_de_costo">Centro de costo</label>
                                <select class="form-control input-font" id="ruta_centro_de_costo">
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
                            <div class="ruta_subcentros hidden">
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="subcentros">Subcentro de costo</label>
                                    <select class="form-control input-font" id="ruta_subcentros">
                                        <option>-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2" style="min-height: 67px;">
                                <label class="obligatorio" for="departamento">Departamento</label>
                                <select class="form-control input-font" id="ruta_departamento">
                                    <option>-</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                <select disabled class="form-control input-font" id="ruta_ciudad">
                                    <option>-</option>
                                </select>
                                <small class="text-danger hidden">Esta ciudad no tiene tarifas!</small>
                            </div>
                            <div class="col-xs-2">
                              <label class="obligatorio" for="ciudad">Tipo de traslado</label>
                              <select disabled class="form-control input-font" id="tipo_traslado"><option value="0">-</option></select>
                            </div>
                            <div class="col-xs-12">
                              <div class="row">
                                <div class="col-xs-2">
                                    <label>Fecha de Solicitud</label>
                                    <div class="input-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control input-font" id="ruta_fecha_solicitud" value="">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="solicitado_por">Solicitado por</label>
                                    <input id="ruta_solicitado_por" type="text" class="form-control input-font">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="email_solicitante">Email Solicitante</label>
                                    <input id="ruta_email_solicitante" type="text" class="form-control input-font">
                                </div>
                                <div class="col-xs-2">
                                  <label class="firma_calificacion" for="ciudad">Firma y calificacion</label>
                                  <select class="form-control input-font" id="firma_calificacion">
                                    <option>-</option>
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 500px;">
                      <form style="display: inline" id="form_ruta">
                          <div style="display: inline-block; margin-bottom: 15px;">
                              <input id="excel_ruta" type="file" value="Subir" name="excel">
                          </div>
                      </form>
                      <table name="mytable" id="ruta_import" class="table table-hover table-bordered tablesorter">
                          <thead>
                              <tr>
                                  <td>#</td>
                                  <td>NOMBRES</td>
                                  <td>APELLIDOS</td>
                                  <td>CEDULA</td>
                                  <td>DIRECCION</td>
                                  <td>BARRIO</td>
                                  <td>CARGO</td>
                                  <td>AREA</td>
                                  <td>SUB AREA</td>
                                  <td>HORARIO</td>
                                  <td>RUTA</td>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
			                <a class="btn btn-info btn-icon" id="add_pax_ruta">AGREGAR<i class="fa fa-plus icon-btn"></i></a>
                  </div>
                  <div role="tabpanel" class="tab-pane fade" id="ex_programar" style="padding-top: 0; overflow-y: auto; height: 500px;">
                        <table id="ruta_a_programar" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>RUTA</td>
                                    <td>PROVEEDOR</td>
                                    <td>CONDUCTOR</td>
                                    <td>VEHICULO</td>
                                    <td>RECOGER EN</td>
                                    <td>DEJAR EN</td>
                                    <td>HORA</td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                  <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarrutasfechas')}}" method="post">
                                          <div class="col-xs-12">
                                              <h6>EXPORTAR RELACION DE LISTADO ENTRE FECHAS</h6>
                                          </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-2">
                                              <label class="obligatorio" for="rt_fecha_final">Fecha Final</label>
                                              <div class="input-group">
                                                <div class="input-group date" id="datetimepicker1">
                                                    <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </span>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarlistadodia')}}" method="post">
                                            <div class="col-xs-12">
                                                <h6>EXPORTAR LISTADO DEL DIA</h6>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div role="tabpanel" class="tab-pane fade" id="export_exce_ruta2">
                        <div class="row" style="margin-top: 15px">
                            <div class="col-xs-12">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <form id="form" action="{{url('transportes/exportarrutasdia')}}" method="post">
                                            <div class="col-xs-12">
                                                <h6>Exportar Rutas Del Dia</h6>
                                            </div>
                                            <div class="col-xs-2">
                                                <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
                                                <div class="input-group">
                                                  <div class="input-group date" id="datetimepicker1">
                                                      <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                                                      <span class="input-group-addon">
                                                          <span class="fa fa-calendar">
                                                          </span>
                                                      </span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label class="obligatorio" for="centrodecosto_ex_excel">Centro de costo</label>
                                                <select name="md_centrodecosto" id="centrodecosto_ex_excel" type="text" class="form-control input-font centrodecosto_ex_excel">
                                                    <option>-</option>
                                                    @foreach($centrosdecosto as $centro)
                                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Subcentro de Costo</label>
                                              <select name="md_subcentrodecosto" id="subcentrodecosto_ex_excel" type="text" class="form-control input-font subcentrodecosto_ex_excel" disabled>
                                                <option>-</option>
                                              </select>
                                            </div>
                                            <div class="col-xs-1">
                                              <label class="obligatorio" for="subcentrodecosto_ex_excel">Exportar</label>
                                              <button type="submit" id="exportar_rutas_pasajeros" class="btn btn-success btn-icon">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                                            </div>
                                            <div class="col-xs-12">
                                              <div class="row">
                                                <div class="col-xs-12">
                                                    <h6>Campos a Exportar</h6>
                                                    <ul class="list-group">
                                                      <div class="row">
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Nombres
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_nombre" name="ch_nombre" type="checkbox" checked="true">
                                                                  <label for="ch_nombre" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Apellidos
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_apellido" name="ch_apellido" type="checkbox" checked="true">
                                                                  <label for="ch_apellido" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Cedula
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_cedula" name="ch_cedula" type="checkbox"/>
                                                                  <label for="ch_cedula" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Direccion
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_direccion" name="ch_direccion" type="checkbox"/>
                                                                  <label for="ch_direccion" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Barrio
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_barrio" name="ch_barrio" type="checkbox"/>
                                                                  <label for="ch_barrio" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Cargo
                                                              <div class="material-switch pull-right">
                                                                    <input id="ch_cargo" name="ch_cargo" type="checkbox"/>
                                                                  <label for="ch_cargo" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Area
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_area" name="ch_area" type="checkbox" checked="true">
                                                                  <label for="ch_area" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Sub area
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_subarea" name="ch_subarea" type="checkbox" checked="true">
                                                                  <label for="ch_subarea" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Horario
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_horario" name="ch_horario" type="checkbox"/>
                                                                  <label for="ch_horario" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                          <li class="list-group-item">
                                                              Embarcado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_embarcado" name="ch_embarcado" type="checkbox" checked="true">
                                                                  <label for="ch_embarcado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              No Embarcado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_no_embarcado" name="ch_no_embarcado" type="checkbox" checked="true">
                                                                  <label for="ch_no_embarcado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                          <li class="list-group-item">
                                                              Autorizado
                                                              <div class="material-switch pull-right">
                                                                  <input id="ch_autorizado" name="ch_autorizado" type="checkbox" checked="true">
                                                                  <label for="ch_autorizado" class="label-default"></label>
                                                              </div>
                                                          </li>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <li class="list-group-item">
                                                                Firma
                                                                <div class="material-switch pull-right">
                                                                    <input id="ch_firma" name="ch_firma" type="checkbox" checked="true">
                                                                    <label for="ch_firma" class="label-default"></label>
                                                                </div>
                                                            </li>
                                                        </div>
                                                      </div>
                                                    </ul>
                                                </div>
                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div role="tabpanel" class="tab-pane fade" id="tab_nombres_ruta">
                    <div class="row" style="margin-top: 15px">
                      <div class="col-lg-12">
                        <div id="container_nombre_rutas">
                          <div class="col-xs-12">
                            <div class="row">
                              <div class="col-xs-3">
                                <div class="form-group">
                                  <label for="">Centros de costo</label>
                                  <select class="form-control input-font" name="centrodecosto">
                                    <option value="0">SELECCIONAR UN CENTRO DE COSTO</option>
                                    @foreach($centrosdecosto as $centro)
                                        <option value="{{$centro->id}}">{{$centro->razonsocial}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="container_nueva_ruta hidden">
                                <form id="form_nuevo_nombre_ruta">
                                  <div class="col-xs-3">
                                    <div class="form-group">
                                      <label for="input_nueva_ruta">Nueva ruta</label>
                                      <input name="input_nombre_ruta" type="text" class="form-control input-font"
                                             id="input_nueva_ruta" placeholder="Registre un nombre de ruta" autocomplete="off">
                                    </div>
                                  </div>
                                  <button style="margin-top: 25px;" type="submit" class="btn btn-primary" name="button">
                                    <i class="fa fa-save"></i>
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-6 hidden">
                            <table class="table table-bordered" id="table_nombre_rutas">
                              <thead>
                                <tr>
                                  <td>NOMBRE DE LA RUTA</td>
                                  <td>FECHA DE CREACION</td>
                                  <td></td>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="continuar_ruta" class="btn btn-success btn-icon">CONTINUAR <i class="fa fa-arrow-right icon-btn"></i></a>
                <a id="ordenar_rutas" class="btn btn-info btn-icon disabled">ORDENAR<i class="fa fa-bars icon-btn" aria-hidden="true"></i></a>
                <a id="siguiente" class="btn btn-redu btn-icon disabled">PROGRAMAR<i class="fa fa-play icon-btn" aria-hidden="true"></i></a>
                <a id="guardar_rutas" class="btn btn-primary btn-icon disabled">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>
