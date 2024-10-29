<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Detalle Prestamo</title>
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
          <h3 class="h_titulo">DETALLE DEL PRESTAMO</h3>
          
          <div style="margin-top: 15px;" class="col-lg-6">
      			<div class="row">
      				<div class="panel panel-default">
      					<div class="panel-heading">TOTALES</div>
      					<div class="panel-body">
                            <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        TOTAL PRESTADO
                                      </td>
                                      <td>
                                        <?php                                         
                                          echo '$ '.number_format($prestamo->valor_prestado);
                                        ?>
                                      </td>
                                    </tr>
                                        <tr>
                                          <td>
                                            FECHA DEL PAGO
                                          </td>
                                          <td>
                                            {{$prestamo->fecha}}
                                          </td>
                                        </tr>
                                        
                                </tbody>
                            </table>
                            <br><br>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            ESTADO DEL PRÉSTAMO
                                        </td>
                                        <td>
                                            @if($prestamo->estado_prestamo==0)
                                              SIN PAGO
                                            @elseif($prestamo->estado_prestamo==1)
                                            <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">PAGADO <i class="fa fa-check"></i></p>                                         
                                            @else
                                              ABONADO
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            PAGO EN EL QUE SE DESCTONTÓ ESTE PRESTAMO
                                        </td>
                                        <td>    
                                            <a href="{{url('facturacion/detalleap/'.$prestamo->id_pago)}}" target="_blank" class="btn btn-list-table btn-primary">VER</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>FECHA DEL PAGO</td>
                                        <td>
                                          {{$prestamo->fecha_pago}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <?php $json = json_decode($prestamo->detalles_valores); 
                                        $cont = 1;
                                        $total = 0;
                                        ?>
                                        <td colspan="2">
                                          <table class="table table-bordered table-hover" id="exampledetallessinpago">
                                              <thead>
                                              <tr>
                                                <td>#</td>
                                                <td>CREADO POR</td>
                                                <td>CONCEPTO</td>
                                                <td>VALOR</td>
                                                <td>FECHA Y HORA</td>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($json as $data)
                                                  <tr>
                                                    <td><?php echo $cont ?></td>
                                                    <td>{{$data->usuario}}</td>
                                                    <td>{{$data->concepto}}</td>
                                                    <td><?php echo number_format($data->valor); ?></td>
                                                    <td>{{$data->timestamp}}</td>
                                                  </tr>
                                                  <?php $cont++; 
                                                      $total = $total+$data->valor;
                                                  ?>
                                                @endforeach
                                              </tbody>
                                          </table>      
                                          <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px; float: right;"><?php echo '$ '.number_format($total); ?> <i class="fa fa-money"></i></p>                                        
                                        </td>
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

      <!-- Modal para restar de prestamos -->
      @if(1>2)
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
                      <a id="efectuar_descuento" style="float: right;" class="btn btn-success btn-icon">Efectuar descuento<i class="icon-btn fa fa-check"></i></a>
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
