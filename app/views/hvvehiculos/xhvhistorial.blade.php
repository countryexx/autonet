<h4 class="h_titulo" >Historial</h4>
<div id="historialtable" style="margin-bottom: 10px;">
  <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
    <thead>
      <tr>
        <th>Orden compra/servicio</th>
        <th>Tipo de mantenimiento</th>
        <th>Fecha realización</th>
        <th>Nombre taller autorizado</th>
        <th>Nombre del técnico que realiza el servicio</th>
        <th>Kilometraje</th>
        <th>Detalle del servicio</th>
        <th>No. Factura</th>
        <th>Fecha entrada.</th>
        <th>Fecha salida</th>
        <th>No. acción preventiva o correctiva</th>
        <th style="width: 100px"></th>
      </tr
    </thead>

    <tbody>
      @foreach($hojavida_mantenimientos as $mnto_vehiculo)
      <tr class="default">
        <td>{{$mnto_vehiculo->numero_orden}}</td>
        <td>{{$mnto_vehiculo->tipo_mantenimiento}}</td>
        <td>{{$mnto_vehiculo->fecha_realizacion}}</td>
        <td>{{$mnto_vehiculo->nombre_taller}}</td>
        <td>{{$mnto_vehiculo->nombre_tecnico}}</td>
        <td>{{$mnto_vehiculo->kilometraje}}</td>
        <td>{{$mnto_vehiculo->detalle_servicio}}</td>
        <td>{{$mnto_vehiculo->numero_factura}}</td>
        <td>{{$mnto_vehiculo->fecha_entrada}}</td>
        <td>{{$mnto_vehiculo->fecha_salida}}</td>
        <td>{{$mnto_vehiculo->numero_accion}}</td>
        <td >

          <a class="btn btn-success btn-icon fa fa-pencil icon-btn mostrar_hvmnto" data-toggle="modal" data-target=".mymodalhst" data-info1="{{$mnto_vehiculo->id}}" data-info2="{{$mnto_vehiculo->tipo_mantenimiento}}" data-info3="{{$mnto_vehiculo->fecha_realizacion}}" data-info4="{{$mnto_vehiculo->nombre_taller}}" data-info5="{{$mnto_vehiculo->detalle_servicio}}" data-info6="{{$mnto_vehiculo->numero_factura}}" data-info7="{{$mnto_vehiculo->fecha_entrada}}" data-info8="{{$mnto_vehiculo->fecha_salida}}" data-info9="{{$mnto_vehiculo->numero_accion}}" data-info10="{{$mnto_vehiculo->numero_orden}}" data-info11="{{$mnto_vehiculo->nombre_tecnico}}" data-info12="{{$mnto_vehiculo->kilometraje}}"> </a>
          <a class="btn btn-danger btn-icon fa fa-times icon-btn mostrar_hvmnto2" data-toggle="modal" data-target=".mymodalhst2" data-drop1="{{$mnto_vehiculo->id}}" data-drop2="{{$mnto_vehiculo->tipo_mantenimiento}}" data-drop3="{{$mnto_vehiculo->fecha_realizacion}}" data-drop4="{{$mnto_vehiculo->nombre_taller}}" data-drop5="{{$mnto_vehiculo->detalle_servicio}}" data-drop6="{{$mnto_vehiculo->numero_factura}}" data-drop7="{{$mnto_vehiculo->fecha_entrada}}" data-drop8="{{$mnto_vehiculo->fecha_salida}}" data-drop9="{{$mnto_vehiculo->numero_accion}}" data-drop10="{{$mnto_vehiculo->numero_orden}}" data-drop11="{{$mnto_vehiculo->nombre_tecnico}}" data-drop12="{{$mnto_vehiculo->kilometraje}}"> </a>
        </td>

      </tr>
      @endforeach
    </tbody>

  </table>

  <button type="button" class="btn btn-default btn-icon agregar_mnto" data-toggle="modal" data-target=".mymodalhst">Agregar<i class="fa fa-plus icon-btn"></i></button>
</div>

<div class="modal fade mymodalhst" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_mnto">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">NUEVO Mantenimiento {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>

                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <div class="col-xs-2">
                            <label class="obligatorio" for="numero_orden">Orden de compra</label>
                            <input type="text" class="form-control input-font" id="numero_orden">
                        </div>

                        <div class="col-xs-2">
                            <label class="obligatorio" for="tipo_mantenimiento">Tipo mantenimiento</label>
                            <select class="form-control input-font" id="tipo_mantenimiento">
                                <option>-</option>
                                <option>PREVENTIVO</option>
                                <option>CORRECTIVO</option>
                            </select>
                        </div>
                        
                        <div class="col-xs-2" id="container_frealizacion">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_realizacion" >Fecha realización</label>
                                <div class='input-group date' id='datetimepickerhv1'>
                                    <input type='text' class="form-control input-font" id="fecha_realizacion" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2">
                            <label  for="nombre_taller">Nombre taller autorizado</label>
                            <input type="text" class="form-control input-font" id="nombre_taller">

                        </div>

                        <div class="col-xs-2">
                            <label  for="nombre_tecnico">Nombre t&eacute;cnico quien realiza el servicio</label>
                            <input type="text" class="form-control input-font" id="nombre_tecnico">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="kilometraje">Kilometraje</label>
                            <input type="text" class="form-control input-font" id="kilometraje">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="numero_factura">No. factura</label>
                            <input type="text" class="form-control input-font" id="numero_factura">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="detalle_servicio">Detalle del servicio</label>
                            <input type="text" class="form-control input-font" id="detalle_servicio">
                        </div>

                        <div class="col-xs-2" id="container_fentrada">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_entrada" >Fecha entrada</label>
                                <div class='input-group date' id='datetimepickerhv1'>
                                    <input type='text' class="form-control input-font" id="fecha_entrada" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2" id="container_fsalida">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_salida" class="obligatorio">Fecha salida</label>
                                <div class='input-group date' id='datetimepickerhv2'>
                                    <input type='text' class="form-control input-font" id="fecha_salida" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="numero_accion">N&uacute;mero de aacci&oacute;n</label>
                            <input type="text" class="form-control input-font" id="numero_accion">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" data-veh="{{$id}}" id="guardarmnto" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="editarmnto" class="btn btn-primary btn-icon hidden">Editar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodalhst2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_mnto3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"> <label id="title_eliminar_mnto"> </label> ?</h4>

                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        <div class="col-xs-2">
                            <label class="obligatorio" for="numero_orden">Orden de compra</label>
                            <input type="text" class="form-control input-font" id="numero_orden_drop">
                        </div>

                        <div class="col-xs-2">
                            <label class="obligatorio" for="tipo_mantenimiento">Tipo mantenimiento</label>
                            <select class="form-control input-font" id="tipo_mantenimiento_drop">
                                <option>-</option>
                                <option>PREVENTIVO</option>
                                <option>CORRECTIVO</option>
                            </select>
                        </div>
                        
                        <div class="col-xs-2" id="container_frealizacion">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_realizacion" >Fecha realización</label>
                                <div class='input-group date' id='datetimepickerhv1'>
                                    <input type='text' class="form-control input-font" id="fecha_realizacion_drop" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2">
                            <label  for="nombre_taller">Nombre taller autorizado</label>
                            <input type="text" class="form-control input-font" id="nombre_taller_drop">

                        </div>

                        <div class="col-xs-2">
                            <label  for="nombre_tecnico">Nombre t&eacute;cnico quien realiza el servicio</label>
                            <input type="text" class="form-control input-font" id="nombre_tecnico_drop">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="kilometraje">Kilometraje</label>
                            <input type="text" class="form-control input-font" id="kilometraje_drop">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="numero_factura">No. factura</label>
                            <input type="text" class="form-control input-font" id="numero_factura_drop">
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="detalle_servicio">Detalle del servicio</label>
                            <input type="text" class="form-control input-font" id="detalle_servicio_drop">
                        </div>

                        <div class="col-xs-2" id="container_fentrada">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_entrada" >Fecha entrada</label>
                                <div class='input-group date' id='datetimepickerhv1'>
                                    <input type='text' class="form-control input-font" id="fecha_entrada_drop" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2" id="container_fsalida">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="fecha_salida" class="obligatorio">Fecha salida</label>
                                <div class='input-group date' id='datetimepickerhv2'>
                                    <input type='text' class="form-control input-font" id="fecha_salida_drop" value="{{date('Y-m-d')}}">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-2">
                            <label for="numero_accion">N&uacute;mero de acci&oacute;n</label>
                            <input type="text" class="form-control input-font" id="numero_accion_drop">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-bottom: 10px;">

                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="eliminarmnto" class="btn btn-danger btn-icon">Eliminar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-primary btn-icon">Cancelar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
