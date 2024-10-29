<h4 class="h_titulo">Conductores</h4>
<div id="conductorestable" style="margin-bottom: 10px;">
  <table class="table table-bordered table-hover" cellspacing="0" style="margin-top: 20px">
    <thead>
      <tr>
        <th>NOMBRE COMPLETO</th>
        <th>DESDE</th>
        <th>HASTA</th>

        <th style="width: 100px"></th>
      </tr>

    </thead>

    <tbody>
      @foreach($hojavida_conductores as $conductor_vehiculos)
      <tr >
        <td>{{$conductor_vehiculos->conductores_nombre}}</td>
        <td>{{$conductor_vehiculos->fecha_inicial}}</td>
        <td>{{$conductor_vehiculos->fecha_final}}</td>
        <td >
          <input type="hidden" name="id_conductorhv" value="{{$conductor_vehiculos->id}}" id="id_conductorhv">
          <a class="btn btn-success btn-icon fa fa-pencil icon-btn mostrar_hvcond" data-toggle="modal" data-target=".mymodal2" data-id="{{$conductor_vehiculos->conductores_id}}" data-idid="{{$conductor_vehiculos->id}}" data-fec1="{{$conductor_vehiculos->fecha_inicial}}" data-fec2="{{$conductor_vehiculos->fecha_final}}"> </a>
          <a class="btn btn-danger btn-icon fa fa-times icon-btn info_anularcond" data-toggle="modal" data-target=".mymodalanular" data-id2="{{$conductor_vehiculos->conductores_id}}" data-idid2="{{$conductor_vehiculos->id}}" data-fec12="{{$conductor_vehiculos->fecha_inicial}}" data-fec22="{{$conductor_vehiculos->fecha_final}}"> </a>
        </td>

      </tr>
      @endforeach
    </tbody>

  </table>

  <button type="button" class="btn btn-default btn-icon add_conductor" data-toggle="modal" data-target=".mymodal2">Agregar<i class="fa fa-plus icon-btn "></i></button>
</div>

<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_conductor">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"><label id="title_conductor">NUEVO Conductor</label> {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">

                              <div class="col-xs-4">
                                  <label class="obligatorio" for="conductorid">Conductor</label>
                                  <select class="form-control input-font" id="conductorid">
                                      <option>-</option>
                                      @foreach($conductores as $conductor)
                                      <option value="{{$conductor->id}}" id="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>

                                      @endforeach
                                  </select>
                              </div>

                                <div class="col-xs-2" id="container_fdesde">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_emision" >Fecha Desde</label>
                                        <div class='input-group date' id='datetimepickerhv5'>
                                            <input type='text' class="form-control input-font" id="fecha_desde" value="{{date('Y-m-d')}}">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2" id="container_fhasta">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha Hasta</label>
                                        <div class='input-group date' id='datetimepickerhv6'>
                                            <input type='text' class="form-control input-font" id="fecha_vigenciaco">
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
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="editarcond" class="btn btn-primary btn-icon hidden">Editar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}"  id="guardar_conductor" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade mymodalanular" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_conductoranl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title"><label id="title_conductor">Anular Conductor</label> {{$vehiculo->clase}} {{$vehiculo->marca}} {{$vehiculo->placa}}</h4>
                </div>
                <div class="modal-body">
                        <div class="col-xs-12">

                              <div class="col-xs-4">
                                  <label class="obligatorio" for="conductoridan">Conductor</label>
                                  <select class="form-control input-font" id="conductoridan" disabled="disabled">
                                      <option>-</option>
                                      @foreach($conductores as $conductor)
                                      <option value="{{$conductor->id}}" id="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>

                                      @endforeach

                                  </select>
                              </div>

                                <div class="col-xs-2" id="container_fdesdean">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_emision" >Fecha Desde</label>
                                        <div class='input-group date' id='datetimepickerhv5'>
                                            <input type='text' class="form-control input-font" id="fecha_desdean" disabled="disabled">
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar">
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-2" id="container_fhastaan">
                                    <div class="form-group" style="margin-bottom: 0px;">
                                        <label for="fecha_vigencia" class="obligatorio">Fecha Hasta</label>
                                        <div class='input-group date' id='datetimepickerhv6'>
                                            <input type='text' class="form-control input-font" id="fecha_vigenciacoan" disabled="disabled">
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

                    <button type="submit" data-id="{{$hojavida_vehiculo->id}}" id="anular_conductor" class="btn btn-danger btn-icon">Anular<i class="fa fa-floppy-o icon-btn"></i></button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-primary btn-icon">Cerrar<i class="fa fa-upload icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
