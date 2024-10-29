<h4 class="h_titulo">Comparendos</h4>
<div id="comparendostable" style="margin-bottom: 10px;">
  <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
    <thead>
      <tr>
        <th>NUMERO COMPARENDO</th>
        <th>CAUSAL</th>
        <th>FECHA</th>
        <th>DETALLE</th>
        <th>VALOR</th>
        <th>NUMERO DE DESCARGUE</th>
        <th style="width: 100px;"></th>
      </tr>

    </thead>

    <tbody>
      @foreach($hojavida_comparendos as $comparendos)
      <tr >
        <td>{{$comparendos->numero_comparendo}}</td>
        <td>{{$comparendos->causal}}</td>
        <td>{{$comparendos->fecha_comparendo}}</td>
        <td>{{$comparendos->detalle_comparendo}}</td>
        <td>{{$comparendos->valor_comparendo}}</td>
        <td>{{$comparendos->numero_descargue}}</td>
        <td >
          <a class="btn btn-success btn-icon fa fa-pencil icon-btn mostrar_hvcomp" data-toggle="modal" data-target=".mymodal3" data-comp="{{$comparendos->id}}" data-comp2="{{$comparendos->numero_comparendo}}" data-comp3="{{$comparendos->causal}}" data-comp4="{{$comparendos->fecha_comparendo}}" data-comp5="{{$comparendos->detalle_comparendo}}" data-comp6="{{$comparendos->valor_comparendo}}" data-comp7="{{$comparendos->numero_descargue}}"> </a>
          <a class="btn btn-danger btn-icon fa fa-times icon-btn conf_anularcomp" data-toggle="modal" data-target=".mymodal33" data-comp="{{$comparendos->id}}" data-comp2="{{$comparendos->numero_comparendo}}" data-comp3="{{$comparendos->causal}}" data-comp4="{{$comparendos->fecha_comparendo}}" data-comp5="{{$comparendos->detalle_comparendo}}" data-comp6="{{$comparendos->valor_comparendo}}" data-comp7="{{$comparendos->numero_descargue}}"> </a>
        </td>

      </tr>
      @endforeach
    </tbody>

  </table>

  <button type="button" class="btn btn-default btn-icon add_comparendo" data-toggle="modal" data-target=".mymodal3">Agregar<i class="fa fa-plus icon-btn"></i></button>
</div>

<div class="modal fade mymodal3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario4">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"><label id="title_comparendo">NUEVO Comparendo </label> {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="numero_comparendo">Numero</label>
                                  <input type="text" class="form-control input-font" id="numero_comparendo">
                              </div>

                              <div class="col-xs-4">
                                  <label class="obligatorio" for="causal">Causal</label>
                                  <textarea class="form-control" id="causal"></textarea>
                              </div>
                                <div class="col-xs-2" id="container_fcomparendo">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha</label>
                                        <div class='input-group date' id='datetimepickerhv3'>
                                            <input type='text' class="form-control input-font" id="fecha_comparendo" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio" for="detalle_comparendo">Detalle</label>
                                    <textarea class="form-control" id="detalle_comparendo"></textarea>

                                </div>


                        </div>
                        <div class="col-xs-12">
                          <div class="col-xs-2">
                              <label class="obligatorio" for="valor_comparendo">Valor</label>
                              <input type="text" class="form-control input-font" id="valor_comparendo">
                          </div>
                          <div class="col-xs-3">
                              <label class="obligatorio" for="numero_descargue">Numero Descargue</label>
                              <input type="text" class="form-control input-font" id="numero_descargue">
                          </div>
                        </div>


                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid2="{{$vehiculo->id}}" id="editar_comparendo" class="btn btn-primary btn-icon hidden">Editar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid2="{{$vehiculo->id}}" id="guardar_comparendo" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodal33" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario42">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Anular Comparendo {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">
                              <div class="col-xs-2">
                                  <label class="obligatorio" for="numero_comparendo2">Numero</label>
                                  <input type="text" class="form-control input-font" id="numero_comparendo2" disabled>
                              </div>

                              <div class="col-xs-2">
                                  <label class="obligatorio" for="causal2">Causal</label>
                                  <input type="text" class="form-control input-font" id="causal2" disabled>
                              </div>
                                <div class="col-xs-2" id="container_fcomparendo">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia2" class="obligatorio">Fecha</label>
                                        <div class='input-group date' id='datetimepickerhv3'>
                                            <input type='text' class="form-control input-font" id="fecha_comparendo2" disabled>
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label class="obligatorio" for="detalle_comparendo2">Detalle</label>
                                    <textarea class="form-control" id="detalle_comparendo2" disabled></textarea>

                                </div>

                        </div>
                        <div class="col-xs-12">
                          <div class="col-xs-2">
                              <label class="obligatorio" for="valor_comparendo2">Valor</label>
                              <input type="text" class="form-control input-font" id="valor_comparendo2" disabled>
                          </div>
                          <div class="col-xs-3">
                              <label class="obligatorio" for="numero_descargue2">Numero Descargue</label>
                              <input type="text" class="form-control input-font" id="numero_descargue2" disabled>
                          </div>
                        </div>
                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-vid2="{{$vehiculo->id}}" id="anular_comparendo" class="btn btn-danger btn-icon">Anular<i class="fa fa-times icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-primary btn-icon">Cerrar<i class="fa fa-upload icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
