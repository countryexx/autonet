<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Listado de Préstamos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
      @include('facturacion.menu_prestamos')
    </div>
      <div class="col-lg-12">
          <h3 class="h_titulo">LISTADO DE PRÉSTAMOS A PROVEEDORES</h3>
          <input type="text" name="id_de_pago" id="id_de_pago" value="" class="hidden">
          <div style="margin-top: 15px;">
            <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_inicial" name="fecha_pago" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
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
                <input id="fecha_final" name="fecha_pago" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
                              <span class="input-group-addon">
                                  <span class="fa fa-calendar">
                                  </span>
                              </span>
              </div>
            </div>
          </div>
          <div class="input-group proveedor_content">
            <select data-option="1" name="proveedores" style="width: 130px;" class="form-control input-font" id="proveedor_search">
              <option value="0">PROVEEDORES</option>
              @foreach($proveedores as $proveedor)
                <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
              @endforeach
            </select>
            <span style="cursor: pointer" class="input-group-addon proveedor_eventual_pagos"><i class="fa fa-car"></i></span>
          </div>
          <div class="form-group">
            <select data-option="1" name="estado" style="width: 130px;" class="form-control input-font">
              <option value="0">TODOS</option>
              <option value="1" selected="">SIN PAGO</option>
              <option value="2">PAGADOS</option>
            </select>
          </div>
                  <a proceso="2" id="buscar_prestamos" class="btn btn-default btn-icon">
                      Buscar<i class="fa fa-search icon-btn"></i>
                  </a>
              </div>
          </div>
      </form>
            <table id="exampleprestamos" class="table table-bordered hover tabla" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Proveedor</td>
                  <td>Fecha</td>
                  <td>Valor Inicial</td>
                  <td>Abono</td>
                  <td>Valor Pendiente</td>
                  <td>Estado</td>
                  <td>Usuario</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($prestamos as $prestamo)
                  <tr @if($prestamo->estado_prestamo===1 and $prestamo->auditado===1){{'class="success"'}}@endif>
                    <td style="text-align: center">
                        {{$prestamo->id}}
                        @if($prestamo->anticipo==1)
                          <br><i class="fa fa-font" style="color: #66BB6A; " aria-hidden="true"></i>
                        @endif
                      </td>
                    <td>
                      {{$prestamo->razonsocial}}
                    </td>
                    <td class="feich" >{{$prestamo->fecha}}</td>
                    <td>$ {{number_format($prestamo->valor_prestado)}}</td>
                    <td>
                      @if($prestamo->abono>0)
                      <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; text-align: center">
                        $ {{number_format( intval($prestamo->valor_prestado)-intval($prestamo->abono))}}
                      </p>

                      @endif

                    </td>
                    <td>
                      <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">
                        <?php
                        if($prestamo->abono!=0){
                          echo '$ '.number_format($prestamo->abono);
                        }else{
                          if( $prestamo->estado_prestamo==1 ){
                            echo '$ '.number_format('0');
                          }else{
                            echo '$ '.number_format($prestamo->valor_prestado);
                          }
                        }
                        ?>
                      </p>
                    </td>
                    <td>@if($prestamo->estado_prestamo===1)
                        <center>
                          @if($prestamo->estado_prestamo==1 and $prestamo->auditado==1)
                            <a target="_blank" style="background: green; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 70px; border-radius: 2px;" href="{{url('/facturacion/detalleap/' .$prestamo->id_pago) }}">CON AP</a>
                          @elseif($prestamo->estado_prestamo==1 and $prestamo->preparado==1 and $prestamo->auditado!=1)
                            <a target="_blank" style="background: #2874A6; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 70px; border-radius: 2px;" href="{{url('/facturacion/detalleap/' .$prestamo->id_pago) }}">CON AP</a>
                          @else
                            <a target="_blank" style="background: gray; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 70px; border-radius: 2px;" href="{{url('/facturacion/detalleap/' .$prestamo->id_pago) }}">CON AP</a>
                          @endif
                        </center>
                      @else
                        <center>
                          <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 14px; padding: 6px 10px; width: 70px; border-radius: 2px;">
                          SIN AP
                        </div>
                        </center>
                      @endif</td>
                    <td>{{$prestamo->first_name}} {{$prestamo->last_name}}</td>
                    <td>
                      <a id="modal_agregar" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-warning add">AGREGAR</a>
                      <a id="ver_detalles" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-info ver">VER DETALLES</a>
                      <!--<a id="modal_agregar" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-danger fecha">Actualizar fecha</a>-->

                      @if(Sentry::getUser()->id===2 || Sentry::getUser()->id===3801 || Sentry::getUser()->id===12)

                        @if( ($prestamo->preparado!=1 and $prestamo->auditado!=1) or $prestamo->auditado==1)

                        @else
                          <a target="_blank" href="{{url('/facturacion/listadopagosauditados/' .$prestamo->id_pago) }}" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-primary">Auditar</a>
                        @endif
                      @endif

                      @if($prestamo->estado_prestamo==1 and $prestamo->auditado==1)
                        <a target="_blank" href="{{url('/facturacion/listadopagosautorizados2/' .$prestamo->id_pago) }}" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-success @if($prestamo->estado_prestamo!=1 or $prestamo->auditado!=1){{'disabled'}}@endif">Legalizar</a>
                      @endif
                      @if(Sentry::getUser()->id===2)
                        <!--<a target="_blank" href="{{url('/facturacion/listadopagosauditados/' .$prestamo->id_pago) }}" pago-id="{{$prestamo->id}}" nombre="{{$prestamo->razonsocial}}" class="btn btn-list-table btn-primary @if( ($prestamo->preparado!=1 and $prestamo->auditado!=1) or $prestamo->auditado==1){{'disabled'}}@endif">Auditar</a>-->
                      @endif

                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td>#</td>
                  <td>Proveedor</td>
                  <td>Fecha</td>
                  <td>Valor Inicial</td>
                  <td>Abono</td>
                  <td>Valor Pendiente</td>
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
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">AGREGAR DESCUENTO AL PRÉSTAMO</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      <!-- -->
                      <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        <b>NOMBRE DEL PROVEEDOR</b>
                                      </td>
                                      <td>
                                        <b><h4 id="titulo_proveedor" style="color: green"></h4></b> <input type="text" id="prestamo_id" name="prestamo_id" class="hidden">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>FECHA DE REALIZACIÓN</b>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <div class='input-group date' id='datetimepicker20'>
                                                  <input name="fecha_final" id="fecha_prestamo2" style="width: 100%;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                                        <b>CONCEPTO DEL DESCUENTO</b>
                                      </td>
                                      <td>
                                        <input type="text" placeholder="INGRESAR LA RAZÓN DEL DESCUENTO" name="razon2" id="razon2" class="form-control">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>VALOR A DESCONTAR</b>
                                      </td>
                                      <td>
                                        <input type="text" placeholder="INGRESAR EL VALOR DEL DESCUENTO" name="valor2" id="valor2" class="form-control">
                                      </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="col-lg-12">
                              <a id="guardar_prestamo2" style="float: right;" class="btn btn-success btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                            </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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
                      <!-- -->
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

        <!-- -->
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
                      <!-- -->
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
    <!-- -->

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
  <script src="{{url('jquery/facturacion.js')}}"></script>
  <script type="text/javascript">
    function goBack(){
        window.history.back();
    }
  </script>
  </body>
</html>
