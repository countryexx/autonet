<h4 class="h_titulo">Insidencias - Accidentes</h4>
<div id="sucesotable" style="margin-bottom: 10px;">
  <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
    <thead>
      <tr>
        <th>SUCESO</th>
        <th>FECHA</th>
        <th>CONDUCTOR</th>
        <th>CLIENTE SERVICIO</th>
        <th>DAÑOS</th>
        <th>HERIDOS</th>
        <th>FALLECIDOS</th>
        <th>DESCRIPCION</th>

        <th style="width: 100px;"></th>
      </tr>

    </thead>

    <tbody>
      @foreach($hojavida_suceso as $suceso)
      <tr >
        <td>{{$suceso->suceso}}</td>
        <td>{{$suceso->fecha_suceso}}</td>
        <td>{{$suceso->conductor_nombre}}</td>
        <td>{{$suceso->cliente_nombre}}</td>
        <td align="center"><input type="checkbox" name="suceso_check2" id="danos2" <?php if($suceso->danos===1){echo 'checked="checked"';} ?> disabled></td>
        <td align="center"><input type="checkbox" name="suceso_check2" id="heridos2" <?php if($suceso->heridos===1){echo 'checked="checked"';} ?> disabled></td>
        <td align="center"><input type="checkbox" name="suceso_check2" id="fallecidos2" <?php if($suceso->fallecidos===1){echo 'checked="checked"';} ?> disabled></td>
        <td>{{$suceso->descripcion_suceso}}</td>
        <td>
          <a class="btn btn-success btn-icon fa fa-pencil icon-btn info_suceso" data-toggle="modal" data-target=".mymodal4" data-infor="{{$suceso->id}}" data-infor2="{{$suceso->suceso}}" data-infor3="{{$suceso->fecha_suceso}}" data-infor4="{{$suceso->conductor_id}}" data-infor5="{{$suceso->danos}}" data-infor6="{{$suceso->heridos}}" data-infor7="{{$suceso->fallecidos}}" data-infor8="{{$suceso->descripcion_suceso}}" data-infor9="{{$suceso->cliente_nombre}}" > </a>
          <a class="btn btn-danger btn-icon fa fa-times icon-btn info_suceso2" data-toggle="modal" data-target=".mymodal4anular" data-infor="{{$suceso->id}}" data-infor2="{{$suceso->suceso}}" data-infor3="{{$suceso->fecha_suceso}}" data-infor4="{{$suceso->conductor_id}}" data-infor5="{{$suceso->danos}}" data-infor6="{{$suceso->heridos}}" data-infor7="{{$suceso->fallecidos}}" data-infor8="{{$suceso->descripcion_suceso}}" data-infor9="{{$suceso->cliente_nombre}}"> </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <button type="button" class="btn btn-default btn-icon add_suceso" data-toggle="modal" data-target=".mymodal4">Agregar<i class="fa fa-plus icon-btn"></i></button>
</div>

<div class="modal fade mymodal4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_suceso">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"><label id="title_suceso">NUEVO Suceso </label> {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">

                              <div class="col-xs-2">
                                  <label class="obligatorio" for="tipo_transporte">Suceso</label>
                                  <select class="form-control input-font" id="tipo_suceso">
                                      <option>-</option>
                                      <option>ACCIDENTE</option>
                                      <option>INCIDENTE</option>
                                  </select>
                              </div>


                                <div class="col-xs-2" id="container_fsuceso">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha</label>
                                        <div class='input-group date' id='datetimepickerhv4'>
                                            <input type='text' class="form-control input-font" id="fecha_suceso" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="conductor_suceso">Conductor</label>
                                    <select class="form-control input-font" id="conductor_suceso">
                                        <option>-</option>
                                        @foreach($conductores as $conductor)
                                        <option value="{{$conductor->id}}" id="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xs-4">
                                    <label class="obligatorio" for="cliente_servicio">Cliente Servicio</label>
                                    <select class="form-control input-font" id="cliente_servicio">
                                        <option>-</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id}}" id="{{$cliente->id}}">{{$cliente->razonsocial}}</option>

                                        @endforeach
                                    </select>
                                </div>


                        </div>
                        <div class="col-xs-12" style="margin-bottom: 5px">

                          <div class="col-xs-4" align="center">

                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check" id="danos">Daños
                              </label>
                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check" id="heridos">Heridos
                              </label>
                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check" id="fallecidos">Fallecidos
                              </label>

                          </div>
                          <div class="col-xs-6">
                              <label  for="tipo_transporte">Descripcion</label>
                              <textarea class="form-control" id="descripcion"></textarea>
                          </div>

                        </div>

                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid="{{$vehiculo->id}}" id="editar_suceso" class="btn btn-primary btn-icon hidden">Editar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid="{{$vehiculo->id}}" id="guardar_suceso" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade mymodal4anular" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_sucesoanular">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"><label id="title_suceso2">Anular Suceso </label> {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">

                              <div class="col-xs-2">
                                  <label class="obligatorio" for="tipo_suceso2">Suceso</label>
                                  <select class="form-control input-font" id="tipo_suceso2" disabled>
                                      <option>-</option>
                                      <option>ACCIDENTE</option>
                                      <option>INCIDENTE</option>
                                  </select>
                              </div>


                                <div class="col-xs-2" id="container_fsuceso">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_suceso2" class="obligatorio">Fecha</label>
                                        <div class='input-group date' id='datetimepickerhv4'>
                                            <input type='text' class="form-control input-font" id="fecha_suceso2" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="conductor_suceso2">Conductor</label>
                                    <select class="form-control input-font" id="conductor_suceso2" disabled>
                                        <option>-</option>
                                        @foreach($conductores as $conductor)
                                        <option value="{{$conductor->id}}" id="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xs-4">
                                    <label class="obligatorio" for="cliente_servicio2">Cliente Servicio</label>
                                    <select class="form-control input-font" id="cliente_servicio2" disabled>
                                        <option>-</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id}}" id="{{$cliente->id}}">{{$cliente->razonsocial}}</option>

                                        @endforeach
                                    </select>
                                </div>


                        </div>
                        <div class="col-xs-12" style="margin-bottom: 5px">

                          <div class="col-xs-4" align="center">

                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check3" id="danos3" disabled>Daños
                              </label>
                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check3" id="heridos3" disabled>Heridos
                              </label>
                              <label class="checkbox-inline">
                                <input type="checkbox" name="suceso_check3" id="fallecidos3" disabled>Fallecidos
                              </label>

                          </div>
                          <div class="col-xs-6">
                              <label  for="descripcion2">Descripcion</label>
                              <textarea class="form-control" id="descripcion2" disabled></textarea>
                          </div>

                        </div>

                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">

                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid="{{$vehiculo->id}}" id="anular_suceso" class="btn btn-danger btn-icon">Anular<i class="fa fa-times icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-primary btn-icon">Cerrar<i class="fa fa-upload icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
