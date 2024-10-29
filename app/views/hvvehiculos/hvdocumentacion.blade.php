<h4 class="h_titulo" >Documentos</h4>
<div id="documentaciontable" style="margin-bottom: 10px;">
  <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
    <thead>
      <tr>
        <th>TIPO DOCUMENTO</th>
        <th>EMPRESA QUE EMITE</th>
        <th>NUMERO DEL DOCUMENTO</th>
        <th>FECHA EMISION</th>
        <th>FECHA VENCIMIENTO</th>
        <th >DIAS RESTANTES</th>
        <th>VALOR</th>
        <th style="width: 100px"></th>
      </tr>

    </thead>

    <tbody>
      @foreach($hojavida_documentacion as $doc_vehiculos)
        <?php
        $dias_vigencia = floor((strtotime($doc_vehiculos->fecha_vencimiento)-strtotime(date('Y-m-d')))/86400);
        if($dias_vigencia <= 0){
          $class_vigencia = 'danger';
        }else {
          $class_vigencia = 'default';
        }
        ?>
      <tr class="{{$class_vigencia}}">
        <td >{{$doc_vehiculos->tipo_documento}}</td>
        <td>{{$doc_vehiculos->empresa_emite}}</td>
        <td>{{$doc_vehiculos->numero_documento}}</td>
        <td>{{$doc_vehiculos->fecha_expedicion}}</td>
        <td>{{$doc_vehiculos->fecha_vencimiento}}</td>
        <td>{{ $dias_vigencia }}</td>
        <td>$ {{$doc_vehiculos->valor}}</td>
        <td >

          <a class="btn btn-success btn-icon fa fa-pencil icon-btn mostrar_hvdoc" data-toggle="modal" data-target=".mymodal" data-info1="{{$doc_vehiculos->id}}" data-info2="{{$doc_vehiculos->tipo_documento}}" data-info3="{{$doc_vehiculos->empresa_emite}}" data-info4="{{$doc_vehiculos->numero_documento}}" data-info5="{{$doc_vehiculos->fecha_expedicion}}" data-info6="{{$doc_vehiculos->fecha_vencimiento}}" data-info7="{{$doc_vehiculos->valor}}"> </a>
          <a class="btn btn-danger btn-icon fa fa-times icon-btn conf_drop" data-toggle="modal" data-target=".mymodaleliminar" data-drop1="{{$doc_vehiculos->id}}" data-drop2="{{$doc_vehiculos->tipo_documento}}" data-drop3="{{$doc_vehiculos->empresa_emite}}" data-drop4="{{$doc_vehiculos->numero_documento}}" data-drop5="{{$doc_vehiculos->fecha_expedicion}}" data-drop6="{{$doc_vehiculos->fecha_vencimiento}}" data-drop7="{{$doc_vehiculos->valor}}"> </a>
        </td>

      </tr>
      @endforeach
    </tbody>

  </table>

  <button type="button" class="btn btn-default btn-icon agregar_doc" data-toggle="modal" data-target=".mymodal">Agregar<i class="fa fa-plus icon-btn"></i></button>
</div>

<div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_doc">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">NUEVO Documento {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>

                </div>
                <div class="modal-body">
                        <div class="col-xs-12">

                              <div class="col-xs-2">
                                  <label class="obligatorio" for="tipo_documento">Tipo Documento</label>
                                  <select class="form-control input-font" id="tipo_documento">
                                      <option>-</option>
                                      <option>SOAT</option>
                                      <option>TECNOMECANICA</option>
                                      <option>POLIZA TODO RIESGO</option>
                                      <option>POLIZA CONTRACTUAL</option>
                                      <option>POLIZA EXTRACONTRACTUAL</option>
                                      <option>TARJETA DE OPERACION</option>
                                  </select>

                              </div>
                                <div class="col-xs-2">
                                    <label  for="tipo_transporte">Numero</label>
                                    <input type="text" class="form-control input-font" id="numero_documento">

                                </div>

                                <div class="col-xs-2">
                                    <label  for="empresa_emite">Empresa que Emite</label>
                                    <input type="text" class="form-control input-font" id="empresa_emite">
                                </div>
                                <div class="col-xs-2">
                                    <label for="valor">Valor</label>
                                    <input type="text" class="form-control input-font" id="valor_doc">
                                </div>

                                <div class="col-xs-2" id="container_femision">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_emision" >Fecha Emision</label>
                                        <div class='input-group date' id='datetimepickerhv1'>
                                            <input type='text' class="form-control input-font" id="fecha_emision" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2" id="container_fvigencia">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha Vigencia</label>
                                        <div class='input-group date' id='datetimepickerhv2'>
                                            <input type='text' class="form-control input-font" id="fecha_vigencia" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                        </div>


                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardardoc" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="editardoc" class="btn btn-primary btn-icon hidden">Editar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodaleliminar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_doc3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"> <label id="title_eliminar"> </label> ?</h4>

                </div>
                <div class="modal-body">
                        <div class="col-xs-12">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="tipo_documento2">Tipo Documento</label>
                                  <select class="form-control input-font" id="tipo_documento2" disabled>
                                      <option>-</option>
                                      <option>SOAT</option>
                                      <option>TECNOMECANICA</option>
                                      <option>POLIZA TODO RIESGO</option>
                                      <option>POLIZA CONTRACTUAL</option>
                                      <option>POLIZA EXTRACONTRACTUAL</option>
                                      <option>TARJETA DE OPERACION</option>
                                  </select>

                              </div>
                                <div class="col-xs-2">
                                    <label  for="numero_documento2">Numero</label>
                                    <input type="text" class="form-control input-font" id="numero_documento2" disabled>

                                </div>

                                <div class="col-xs-2">
                                    <label  for="empresa_emite2">Empresa que Emite</label>
                                    <input type="text" class="form-control input-font" id="empresa_emite2" disabled>
                                </div>
                                <div class="col-xs-2">
                                    <label for="valor2">Valor</label>
                                    <input type="text" class="form-control input-font" id="valor_doc2" disabled>
                                </div>

                                <div class="col-xs-2" id="container_femision2">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_emision2" >Fecha Emision</label>
                                        <div class='input-group date' id='datetimepickerhv1'>
                                            <input type='text' class="form-control input-font" id="fecha_emision2" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2" id="container_fvigencia2">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha Vigencia</label>
                                        <div class='input-group date' id='datetimepickerhv2'>
                                            <input type='text' class="form-control input-font" id="fecha_vigencia2" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                        </div>


                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">

                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="eliminardoc" class="btn btn-danger btn-icon">Eliminar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-primary btn-icon">Cancelar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
