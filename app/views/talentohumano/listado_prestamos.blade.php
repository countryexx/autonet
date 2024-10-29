<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Listado de Préstamos a Empleados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
      @include('talentohumano.menu_talentohumano')
    </div>
      <div class="col-lg-12">
          <h3 class="h_titulo">LISTADO DE PRÉSTAMOS A EMPLEADOS</h3>
          <input type="text" name="id_de_pago" id="id_de_pago" value="" class="hidden">
          <div style="margin-top: 15px;">
            <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_inicial" name="fecha_pago" value="{{date('Y-m-d')}}" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_final" name="fecha_pago" value="{{date('Y-m-d')}}" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class="input-group proveedor_content">
            <select data-option="1" name="empleado" style="width: 150px;" class="form-control input-font" id="empleado">
              <option value="0">LISTA DE EMPLEADOS</option>
              @foreach($empleados as $empleado)
                <option value="{{$empleado->id}}">{{$empleado->nombres}} {{$empleado->apellidos}}</option>
              @endforeach
            </select>
            
          </div>
          <div class="form-group">
            <select data-option="1" name="estado" style="width: 150px;" class="form-control input-font">
              <option value="0">TODOS</option>
              <option value="1" selected="">PENDIENTE DE PAGO</option>
              <option value="2">ABONADOS</option>
              <option value="3">PAGOS REALIZADOS</option>
            </select>
          </div>
              <a proceso="2" id="buscar_prestamos" class="btn btn-default btn-icon">
                Buscar<i class="fa fa-search icon-btn"></i>
              </a>
              </div>
          </div>
      </form>
            <table id="example2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nombre Completo</td>
                  <td>Fecha Solicitud</td>
                  <td>Fecha Aprobación</td>
                  <td>Valor</td>
                  <td>Estado</td>
                  <td>Usuario</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($prestamos as $prestamo)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$prestamo->nombres}} {{$prestamo->apellidos}}</td>
                    <td class="feich" >{{$prestamo->fecha_solicitud}}</td>
                    <td>{{$prestamo->fecha_aprobacion}}</td>
                    <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;"><?php echo '$ '.number_format($prestamo->valor)?></p></td>                              
                    <td>
                      @if($prestamo->estado_prestamo===0)
                        <span style="color: red">PENDIENTE DE PAGO</span>
                      @elseif($prestamo->estado_prestamo===1)
                        <span style="color: red">ABONADO</span>
                      @else
                        <span style="color: red">PAGADO</span>
                      @endif
                    </td>
                    <td>{{$prestamo->first_name}} {{$prestamo->last_name}} </td>
                    <td>
                      @if($permisos->talentohumano->prestamos->gestionar==='on')
                        <a id="modal_agregar" prestamo-id="{{$prestamo->id}}" nombre="{{$prestamo->nombres}}" apellido="{{$prestamo->apellidos}}" valor-pendiente="{{$prestamo->valor_restante}}" fecha="{{$prestamo->fecha_aprobacion}}" class="btn btn-list-table btn-danger add">ABONAR</a>
                      @else
                        <a id="modal_agregar" prestamo-id="{{$prestamo->id}}" nombre="{{$prestamo->nombres}}" apellido="{{$prestamo->apellidos}}" valor-pendiente="{{$prestamo->valor_restante}}" fecha="{{$prestamo->fecha_aprobacion}}" class="btn btn-list-table btn-danger disabled add">ABONAR</a>
                      @endif
                      <!-- 
                      <a id="ver_detalles" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->nombres}}" class="btn btn-list-table btn-info ver">VER DETALLES</a>
                      <a id="modal_agregar" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->nombres}}" class="btn btn-list-table btn-danger fecha">Actualizar fecha</a>-->
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach                      
              </tbody>
              <tfoot>
                <tr>
                  <td>#</td>
                  <td>Nombre Completo</td>
                  <td>Fecha Solicitud</td>
                  <td>Fecha Aprobación</td>
                  <td>Valor</td>
                  <td>Estado</td>
                  <td>Usuario</td>
                  <td></td>                               
                </tr>
              </tfoot>
            </table>
      		</div>

      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id='modal_add'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">GESTIÓN DE ABONOS</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      
                      <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        <label>NOMBRE EMPLEADO</label>
                                      </td>
                                      <td>  
                                         <input type="text" id="prestamo_id" name="prestamo_id" class="hidden">
                                        <input type="text" name="titulo_proveedor" id="titulo_proveedor" class="form-control" disabled="true">                         
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <label>FECHA DEL ABONO</label>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <div class="input-group" style="margin-bottom: -15px">
                                              <div class='input-group date' id='datetimepicker20'>
                                                  <input name="fecha_final" id="fecha_prestamo" style="width: 100%;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar">
                                                  </span>
                                              </span>
                                              </div>
                                          </div>
                                      </div> 
                                      </td>
                                    </tr>                                    
                                    <tr>
                                      <td>
                                        <label>VALOR A ABONAR</label>
                                      </td>
                                      <td>
                                        <input type="number" placeholder="INGRESAR EL VALOR A ABONAR" name="abono" id="abono" class="form-control" value="<?php echo number_format('0') ?>">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <label>VALOR PENDIENTE DE PAGO</label>
                                      </td>
                                      <td>
                                        <input type="number" disabled="true" placeholder="INGRESAR EL VALOR DEL DESCUENTO" name="pendiente" id="pendiente" class="form-control">
                                        <input type="tetxt" name="test" id="test" class="hidden">
                                      </td>
                                    </tr>

                                </tbody>
                            </table>                            
                    </div>
                  </div>

                </div>                
                <div class="modal-footer">                  
                  <button type="button" class="btn btn-success guardar_abono">ABONAR</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id='modal_fecha'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">MODIFICAR FECHA</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      
                      <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>                                    
                                    <tr>
                                      <td>
                                        <b>FECHA DE PAGO</b>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <div class='input-group date' id='datetimepicker21'>
                                                  <input name="fecha_final" id="fecha_prestamo3" style="width: 100%;" type='text' class="form-control input-font">
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar">
                                                  </span>
                                              </span>
                                              </div>
                                          </div>
                                      </div> 
                                      </td>
                                    </tr>
                                </tbody>
                            </table>               
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <a id="modificar_fecha" style="float: right;" class="btn btn-success btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                </div>
            </div>
          </div>
        </div>

        <!-- 
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_vista_sinpago'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="height: 80%; width: 800px">
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">DETALLES DE LOS DESCUENTOS</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      
                      <table class="table table-bordered table-hover" id="exampledetallessinpago">
                          <thead>
                          <tr>
                          <th>#</th>
                            <th>CREADO POR</th>
                            <th>CONCEPTO</th>
                            <th>VALOR</th>
                            <th>FECHA Y HORA</th>
                          </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>                      
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>
    -->

    <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
    </div>

  @include('scripts.scripts')
  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/talentohumano.js')}}"></script>
  <script type="text/javascript">
    function goBack(){
        window.history.back();
    }
  </script>
  </body>
</html>
