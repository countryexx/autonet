<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Préstamos a proveedores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
      @include('facturacion.menu_prestamos')
    </div>
      <div class="col-lg-12">
          <h3 class="h_titulo">REGISTRO DE PRÉSTAMO A PROVEEDORES</h3>
          <input type="text" name="id_de_pago" id="id_de_pago" value="" class="hidden">
          <div style="margin-top: 15px;" class="col-lg-4">
      			<div class="row">
      				<div class="panel panel-default">
      					<div class="panel-heading">REGISTRAR NUEVO PRÉSTAMO</div>

      					<div class="panel-body">
                            <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        <b>NOMBRE DEL PROVEEDOR</b>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <select style="width: 100%; margin-top: 15px" class="form-control input-font" name="prov_select" id="prov_select">
                                            <option value="null">-</option>
                                            @foreach($proveedores as $proveedor)
                                              <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>FECHA DEL PAGO</b>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <div class="input-group">
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
                                        <b>CONCEPTO</b>
                                      </td>
                                      <td>
                                        <input type="text" placeholder="INGRESAR LA RAZÓN DEL PRÉSTAMO" name="razon" id="razon" class="form-control">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>VALOR</b>
                                      </td>
                                      <td>
                                        <input type="text" placeholder="INGRESAR EL VALOR DEL PRÉSTAMO" name="valor" id="valor" class="form-control">
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <b>ANTICIPO</b>
                                      </td>
                                      <td>
                                        <label style="font-size: 15px">¿Este préstamo es un anticipo?</label>
                                        <input style="float: right; margin-right: 10px" type="checkbox" class="anticipo">
                                      </td>
                                    </tr>

                                </tbody>
                            </table>
                            <br><br>

                            <div class="col-lg-12">
                              <a id="guardar_prestamo" style="float: right;" class="btn btn-success btn-icon">GUARDAR<i class="icon-btn fa fa-save"></i></a>
                            </div>
      					</div>
      				</div>
      			</div>
      		</div>

          <!-- VISTA DE LOS PRÉSTAMOS ACTIVOS -->

          <div style="margin: 15px 0 0 50px;" class="col-lg-7">
            <div class="row">
              <div class="panel panel-default">
                <div class="panel-heading">PRÉSTAMOS ACTIVOS</div>

                <div class="panel-body">
                            <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>
                                    <tr>
                                      <td>
                                        <b>NOMBRE DEL PROVEEDOR</b>
                                      </td>
                                      <td>
                                        <div class="form-group">
                                          <input type="text" name="name" id="name_provider" class="form-control" disabled="true" style="margin-top: 15px; width: 70%; background: gray">
                                        </div>
                                      </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <table id="exampleprestamos2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <td>ID</td>
                                  <td>VALOR</td>
                                  <td>FECHA</td>
                                  <td>CONCEPTO</td>
                                  <td>ESTADO</td>
                                  <td>VER DETALLES</td>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                              <tfoot>
                                <tr>
                                  <td>ID</td>
                                  <td>VALOR</td>
                                  <td>FECHA</td>
                                  <td>CONCEPTO</td>
                                  <td>ESTADO</td>
                                  <td>VER DETALLES</td>
                                </tr>
                              </tfoot>
                            </table>
                            <!--
                            <table class="table table-bordered">
                                <tbody>
                                  <tr>
                                    <td>
                                      # DE PRÉSTAMO
                                    </td>
                                    <td>
                                      VALOR DEL PRESTAMO
                                    </td>
                                    <td>
                                      VER DETALLES
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>
                                        <label style="margin-bottom: 0px" class="span-total" id="totales_cuentas" data-value="1536500">
                                        <h1>1,000,000</h1></label></td>
                                    <td>
                                      <a style="color: black !important; background:#0ABB04; font-size:12px; padding:3px 1px; border-radius:3px; -moz-border-radius:3px; -webkit-border-radius:3px; text-decoration:none; display: block; text-align: center;" target="_blank" href="{{url('serviciosgps/viaje/123')}}">VER DATELLES <i class="fa fa-money" aria-hidden="true"></i></a>
                                    </td>
                                  </tr>
                                </tbody>
                            </table> -->
                            <div class="col-lg-12">
                              <a id="guardar_edicion" style="float: right;" class="btn btn-warning btn-icon">ACTUALIZAR LISTA<i class="icon-btn fa fa-list-alt"></i></a>
                            </div>
                </div>
              </div>
            </div>
          </div>


      </div>
<!--
      <div class="col-lg-6">
					<a style="margin-bottom:10px" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
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
  <script src="{{url('jquery/facturacion.js')}}"></script>
  <script type="text/javascript">
    function goBack(){
        window.history.back();
    }

    $('#valor').keyup(function(){
      valor = $(this).val();
      $(this).val(number_format(valor));
    });

  </script>
  </body>
</html>
