<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Detalle AP</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <style type="text/css">      
      
      .checkbox-container {
          width: 100%;
          box-sizing: border-box;
          text-align:center;
      }
    </style>
  </head>
  <body>
    @include('admin.menu')

      <div class="col-lg-12">
          <h3 class="h_titulo">DETALLE DEL PAGO AP</h3>
          <table class='table table-bordered table-hover'>
            <thead>
              <tr>
                <th>Consecutivo</th>
                <th>Factura</th>
                <th>Fecha de Expedicion</th>
                <th>Centro de Costo</th>
                <th>Proveedor</th>
                <th>Fecha Inicial</th>
                <th>Fecha Final</th>
                <th>Fecha Pago</th>
                <th>Valor</th>
                <th>Usuario</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($pago_proveedores as $pago)
              <tr>
                <td>{{$pago->consecutivo}}</td>
                <td>{{$pago->numero_factura}}</td>
                <td>{{$pago->fecha_expedicion}}</td>
                <td>{{$pago->razonsocial.' / '.$pago->nombresubcentro}}</td>
                <td>{{$pago->razonsocialp}}</td>
                <td>{{$pago->fecha_inicial}}</td>
                <td>{{$pago->fecha_final}}</td>
                <td>{{$pago->fecha_pago}}</td>
                <td><p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">{{'$ '.number_format($pago->valor)}}</p></td>
                <td>{{$pago->first_name.' '.$pago->last_name}}</td>
                <td><a href="../../facturacion/detallepagoproveedores/{{$pago->id}}" class="btn btn-primary btn-list-table">DETALLES</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div style="margin-top: 15px;" class="col-lg-4">
      			<div class="row">
      				<div class="panel panel-default">
      					<div class="panel-heading">TOTALES</div>
      					<div class="panel-body">
                            <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        TOTAL PAGADO
                                      </td>
                                      <td>
                                        <?php
                                          $pagos = DB::table('pagos')->where('id',$id)->first();
                                          echo '$ '.number_format($pagos->total_pagado);
                                        ?>
                                      </td>
                                    </tr>
                                        <tr>
                                          <td>
                                            DESCUENTO RETEFUENTE
                                          </td>
                                          <td>
                                            <?php
                                              echo '$ '.number_format($pagos->descuento_retefuente);
                                            ?>
                                          </td>
                                        </tr>
                                        <?php $pa = DB::table('prestamos')->where('id_pago',$pagos->id)->first(); ?>
                                        
                                </tbody>
                            </table>
                            @if($pa!=null)
                              <button class="hidden" style="margin-bottom: 7px;" type="button" class="btn btn-default btn-icon" data-toggle=  "modal" data-target=".fade">
                                Editar valor descontado del prestamo<i class="fa fa-money icon-btn"></i>
                              </button>
                              <br><br>
                            @endif
                            <!-- -->
                            
                            <!-- -->
                            <table class="table table-bordered hover descuentos" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                                <tbody>

                                <?php
                                    $descuentos = json_decode($pagos->detalles_descuentos);
                                     foreach ($descuentos as $descuento):
                                         echo '<tr>'.
                                                    '<td>'.
                                                        '<textarea rows="2" class="form-control input-font detalle_text" style="text-transform: uppercase;" disabled="">'.$descuento->detalle.'</textarea>'.
                                                    '</td>'.
                                                    '<td>'.
                                                        '<div class="input-group">'.
                                                            '<input type="text" class="form-control input-font valor_descuento" value="'.$descuento->valor.'" disabled="">'.
                                                            '<div class="input-group-addon"><i class="fa fa-usd"></i>'.
                                                            '</div>'.
                                                        '</div>'.
                                                    '</td>'.
                                               '</tr>';
                                     endforeach;
                                ?>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            OTROS DESCUENTOS
                                        </td>
                                        <td>
                                            <?php
                                            echo '$ '.number_format($pagos->otros_descuentos);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            DESCUENTOS DE PRÉSTAMOS
                                        </td>
                                        <td>
                                            <?php
                                            echo '$ '.number_format($pagos->descuento_prestamo);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            CONCEPTO DE PRÉSTAMOS
                                        </td>
                                        <td>
                                            <a id="modal_detalles" pago-id="<?php echo $pagos->id ?>" class="btn btn-danger btn-icon">VER DETALLES<i class="fa fa-eye icon-btn"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL CUENTAS DE COBRO</td>
                                        <td>
                                            <label style="margin-bottom: 0px" class="span-total" id="totales_cuentas" data-value="1536500">
                                                <?php

                                                $total_pago = 0;
                                                foreach ($pago_proveedores as $pago) {
                                                    if ($pago->anulado===null) {
                                                        $total_pago = $total_pago + $pago->valor;
                                                    }
                                                }
                                                echo '$ '.number_format($pagos->total_neto);
                                                ?></label></td>
                                    </tr>
                                    <tr>
                                        <td>OBSERVACIONES</td>
                                        <td><textarea disabled rows="4" class="form-control input-font">{{$pagos->observaciones}}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
      					</div>
      				</div>
      			</div>
      		</div>


      </div>

      <div class="col-lg-12">
					<a style="margin-bottom:10px" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
			</div>

      <!-- -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_vista'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" style="height: 80%; width: 800px">
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">DETALLES DE LOS PRESTAMOS</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      <!-- -->
                      <table class="table table-bordered table-hover" id="exampledetalles">
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

      <!-- Modal para restar de prestamos -->
      @if($pa!=null)
        <div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
          <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #f47321">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;">Gestión de descuento de préstamos</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      <!-- -->
                      <table class="table table-bordered hover descuentos" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                                <tbody>
                                   <tr>
                                      <td>
                                        VALOR ACTUAL A PAGAR: 
                                      </td>
                                      <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-font valor_descuento" value="<?php echo '$ '.number_format($pagos->total_neto)?>" disabled="">
                                            <div class="input-group-addon"><i class="fa fa-usd"></i>
                                            </div>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        VALOR POR DESCONTAR: 
                                      </td>
                                      <td>
                                        <div class="input-group">
                                            <input type="text" id="editar_valor" class="form-control input-font valor_descuento" value="<?php echo '$ '.number_format($pa->valor_prestado);?>" disabled="true">
                                            <div class="input-group-addon"><i class="fa fa-usd"></i>
                                            </div>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        VALOR TOTAL A PAGAR APLICANDO DESCUENTO:
                                      </td>
                                      <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control input-font valor_descuento" value="<?php
                                                $value = $pagos->total_neto - $pa->valor_prestado;
                                                echo '$ '.number_format($value);
                                              ?>" disabled="">
                                            <div class="input-group-addon"><i class="fa fa-usd"></i>
                                            </div>
                                        </div>
                                      </td>
                                    </tr>
                                </tbody>
                            </table>     
                        <div class="card" style="float: left;">
                          <div class="checkbox-container">
                          <label class="checkbox-label">
                              <input type="checkbox" name="dato1" id="dato1">
                              <span class="checkbox-custom rectangular">Descontar valor diferente</span>
                          </label>                          
                          </div>            
                      </div>                       
                      <input type="text" class="hidden" name="id_del_pago" id="id_del_pago" value="<?php echo $pagos->id ?>">
                      <input type="text" class="hidden" name="id_del_prestamo" id="id_del_prestamo" value="<?php echo $pa->id ?>">
                      <!--<input type="text" name="valor_total_prestamo" id="valor_total_prestamo" value=""> -->
                      <a id="efectuar_descuento" style="float: right;" class="btn btn-success btn-icon disabled">Efectuar descuento<i class="icon-btn fa fa-check"></i></a>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
          </div>
        </div>
      @endif
      <!-- Fin Modal de estrar de prestamos -->
  
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
