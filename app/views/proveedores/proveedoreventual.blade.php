<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Proveedor Eventual</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
      <style>
          #example2 tbody tr td input[type="text"]{
              text-transform: uppercase;
          }
      </style>
  </head>

  <body>
    @include('admin.menu')

    <div class="col-lg-12">
      <div class="col-lg-5">
        <div class="row">
          @include('proveedores.menu_proveedores')
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              <table id="example1" class="table table-hover table-bordered">
                <thead>
                  <tr>
                    <th>Nit</th>
                    <th>Razon Social</th>
                    <th>Detalles</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proveedor_eventual as $proveedor)
                    <tr data-id="{{$proveedor->id}}">
                      <td>{{$proveedor->nit}}</td>
                      <td>{{$proveedor->razonsocial}}</td>
                      <td>
                          @if(isset($permisos->administrativo->proveedores->editar))
                              @if($permisos->administrativo->proveedores->editar==='on')
                                <a data-id="{{$proveedor->id}}" data-toggle="modal" href="#modal-proveedor" class="btn btn-list-table btn-primary editar_eventual">EDITAR <i class="fa fa-pencil-square-o"></i></a>
                              @else
                                  <a class="btn btn-list-table btn-primary editar_eventual disabled">EDITAR <i class="fa fa-pencil-square-o"></i></a>
                              @endif
                          @else
                              <a class="btn btn-list-table btn-primary editar_eventual disabled">EDITAR <i class="fa fa-pencil-square-o"></i></a>
                          @endif
                          <a data-id="{{$proveedor->id}}" data-toggle="modal" href="#modal-conductor" class="btn btn-list-table btn-info conductor_eventual">CONDUCTOR <i class="fa fa-user"></i></a>
                          <a data-id="{{$proveedor->id}}" data-toggle="modal" href="#modal-vehiculo" class="btn btn-list-table btn-success vehiculo_eventual" >VEHICULO <i class="fa fa-car"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <tr>
                    <th>Nit</th>
                    <th>Razon Social</th>
                    <th>Detalles</th>
                    </tr>
                  </tr>
                </tfoot>
              </table>
              @if(isset($permisos->administrativo->proveedores->crear))
                  @if($permisos->administrativo->proveedores->crear==='on')
                      <a style="margin-top: 15px" class="btn btn-default btn-icon" data-toggle="modal" href="#modal-nuevo-proveedor">AGREGAR<i class="fa fa-plus icon-btn "></i></a>
                  @else
                      <a style="margin-top: 15px" class="btn btn-default btn-icon disabled">AGREGAR<i class="fa fa-plus icon-btn "></i></a>
                  @endif
              @else
                  <a style="margin-top: 15px" class="btn btn-default btn-icon disabled">AGREGAR<i class="fa fa-plus icon-btn "></i></a>
              @endif
              <a style="margin-top: 15px" class="btn btn-primary btn-icon" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="modal fade" id="modal-nuevo-proveedor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <strong>NUEVO PROVEEDOR EVENTUAL</strong>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="nit_proveedor" class="obligatorio">Nit</label>
                            <input class="form-control input-font" id="nit_proveedor">
                        </div>
                        <div class="col-lg-9">
                            <label for="razonsocial_proveedor" class="obligatorio">Razon Social </label>
                            <input class="form-control input-font" id="razonsocial_proveedor">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-icon" id="guardar_proveedor_eventual">GUARDAR<i class="fa fa-save icon-btn"></i></button>
                    <button type="button" class="btn btn-danger btn-icon" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-proveedor">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    				<strong>EDITAR PROVEEDOR</strong>
    			</div>
    			<div class="modal-body">
                  <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                      <label for="nit" class="obligatorio">Nit</label>
                      <input type="text" class="form-control input-font" id="nit">
                    </div>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                      <label for="razonsocial" class="obligatorio">Razon Social</label>
                      <input type="text" class="form-control input-font" id="razonsocial">
                    </div>
                  </div>
    			</div>
    			<div class="modal-footer">
                  <button type="button" class="btn btn-primary btn-icon input-font" id="actualizar_proveedor_eventual">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></button>
                  <button type="button" class="btn btn-danger btn-icon input-font" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
    			</div>
    		</div><!-- /.modal-content -->
    	</div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-conductor">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    				<strong>CONDUCTORES EVENTUALES</strong>
    			</div>
    			<div class="modal-body">
                    <table id="example2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 35%">NOMBRE</th>
                                <th style="width: 20%">IDENTIFICACION</th>
                                <th style="width: 20%">CELULAR</th>
                                <th style="width: 10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control input-font">
                                </td>
                                <td>
                                    <input type="text" class="form-control input-font">
                                </td>
                                <td>
                                    <input type="text" class="form-control input-font">
                                </td>
                                <td>
                                    <button class="btn btn-primary agregar_conductor_eventual"><i class="fa fa-save"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

    			</div>
    			<div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-icon input-font" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
    			</div>
    		</div><!-- /.modal-content -->
    	</div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-vehiculo">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    				<strong>VEHICULOS EVENTUALES</strong>
    			</div>
    			<div class="modal-body">
                    <table id="vehiculo_eventual" class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 15%">PLACA</th>
                            <th style="width: 20%">CLASE</th>
                            <th style="width: 20%">MARCA</th>
                            <th style="width: 25%">LINEA</th>
                            <th style="width: 15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <input type="text" class="form-control input-font">
                            </td>
                            <td>
                                <select type="text" class="form-control input-font">
                                    <option>-</option>
                                    <option>AUTOMOVIL</option>
                                    <option>CAMIONETA</option>
                                    <option>BUSETA</option>
                                    <option>BUS</option>
                                    <option>MICROBUS</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control input-font">
                            </td>
                            <td>
                                <input type="text" class="form-control input-font">
                            </td>
                            <td>
                                <button class="btn btn-primary agregar_conductor_eventual"><i class="fa fa-save"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-danger input-font btn-icon" data-dismiss="modal">CERRAR<i class="fa fa-close icon-btn"></i></button>
    			</div>
    		</div><!-- /.modal-content -->
    	</div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
    </div>
    <script type="text/javascript">
        function goBack(){
            window.history.back();
        }

    </script>

    @include('scripts.scripts')
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/proveedores.js')}}"></script>
  </body>
</html>
