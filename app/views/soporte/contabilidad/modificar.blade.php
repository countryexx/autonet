<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Soporte | Detalles del Pago</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')

      <div class="col-lg-12">
          <h3 class="h_titulo">DETALLES DEL PAGO</h3>
          <input type="text" name="id_de_pago" id="id_de_pago" value="{{$id}}" class="hidden">
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
                                </tbody>
                            </table>
                            <a class="btn boton-novedad-app agregar_nuevo_descuento" id="modificacion" data-servicio-id="'.$descuento->detalle.'"><small>AGREGAR DESCUENTO</small></a><br><br>
                            <table class="table table-bordered hover descuentos" id="tabla_ejemplo" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);">
                                <tbody>

                                <?php
                                    $contador = 1;
                                    $descuentos = json_decode($pagos->detalles_descuentos);
                                     foreach ($descuentos as $descuento):
                                         echo   
                                                    
                                                    '<tr id="'.$contador.'">'.
                                                      
                                                        '<td>'.
                                                            '<textarea rows="2" required="true" class="form-control input-font detalle_text" style="text-transform: uppercase;">'.$descuento->detalle.'</textarea>'.
                                                        '</td>'.
                                                        '<td>'.
                                                            '<div class="input-group">'.
                                                                '<input type="text" class="form-control input-font valor_descuento" required="true" value="'.$descuento->valor.'">'.
                                                                '<div class="input-group-addon"><i class="fa fa-usd"></i>'.
                                                                '</div>'.
                                                            '</div>'.
                                                        '</td>'.
                                                        '<td>'.
                                                           '<div class"input-group">'.
                                                              '<a class="btn btn-danger quitar_nuevo_descuento" id="quitar_nuevo_descuento" data-id="'.$contador.'"><small>Quitar</small></a>'.
                                                          '</div>'.
                                                        '</td>'.
                                                   '</tr>';
                                                $contador = $contador+1;
                                     endforeach;                                     
                                ?>
                                </tbody>
                            </table>
                            <input class="hidden" type="text" name="contador" id="contador" value="<?php echo $contador ?>">
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
                                </tbody>
                            </table>
                            <div class="col-lg-12">
                              <a id="guardar_edicion" style="float: right;" class="btn btn-success btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                            </div> 
      					</div>
      				</div>
      			</div>
      		</div>


      </div>

      <div class="col-lg-6">
					<a style="margin-bottom:10px" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
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
