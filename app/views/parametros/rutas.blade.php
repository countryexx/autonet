<html>
<head>
	<title>Autonet | Rutas</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>
@include('admin.menu')

<div class="col-lg-12">

<h3 class="h_titulo">RUTAS Y TARIFAS GENERALES</h3>

    @if(isset($ruta_general))

        <table id="example" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>                                      
                    <th>Van<br> cliente</th>
                    <th>Van<br> proveedor</th>
                    <th>Bus<br> cliente</th>
                    <th>Bus<br> proveedor</th>  
                    <th>Automovil<br> cliente</th>
                    <th>Automovil<br> proveedor</th> 
                    <th>Buseta<br> cliente</th>
                    <th>Buseta<br> proveedor</th>  
                    <th>Minivan<br> cliente</th>
                    <th>Minivan<br> proveedor</th>  
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>                                      
                    <th>Van cliente</th>
                    <th>Van proveedor</th>
                    <th>Bus cliente</th>
                    <th>Bus proveedor</th>  
                    <th>Automovil cliente</th>
                    <th>Automovil proveedor</th> 
                    <th>Buseta cliente</th>
                    <th>Buseta proveedor</th>  
                    <th>Minivan cliente</th>
                    <th>Minivan proveedor</th>  
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($ruta_general as $ruta)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$ruta->codigo_ruta}}</td>
                    <td>{{$ruta->nombre_ruta}}</td>
                    <td>{{$ruta->descripcion_ruta}}</td>
                    <td>$ {{number_format($ruta->tarifa_cliente_van)}}</td>
                    <td>$ {{number_format($ruta->tarifa_proveedor_van)}}</td>
                    <td>$ {{number_format($ruta->tarifa_cliente_bus)}}</td>
                    <td>$ {{number_format($ruta->tarifa_proveedor_bus)}}</td>
                    <td>$ {{number_format($ruta->tarifa_cliente_automovil)}}</td>
                    <td>$ {{number_format($ruta->tarifa_proveedor_automovil)}}</td>
                    <td>$ {{number_format($ruta->tarifa_cliente_buseta)}}</td>
                    <td>$ {{number_format($ruta->tarifa_proveedor_buseta)}}</td>
                    <td>$ {{number_format($ruta->tarifa_cliente_minivan)}}</td>
                    <td>$ {{number_format($ruta->tarifa_proveedor_minivan)}}</td>
                    <td style="text-align: center">
                        <a id="{{$ruta->id}}" data-toggle="modal" href="#shortModal2" style="padding: 5px 6px; margin-bottom: 3px;" class="btn btn-primary editar_ruta"><i class="fa fa-pencil"></i></a>
                        <a id="{{$ruta->id}}" style="padding: 5px 6px;" class="btn btn-danger eliminar_ruta"><i class="fa fa-close"></i></a>
                    </td>                     
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
     <a data-toggle="modal" href="#shortModal" class="btn btn-default btn-icon">Agregar<i class="fa fa-plus icon-btn"></i></a>
   
</div>

<div id="shortModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formulario">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nueva Ruta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <label class="obligatorio" for="nuevo_departamento">Nombre</label>
                            <input class="form-control" type="text" id="nombre">
                        </div>
                        <div class="col-xs-12">
                            <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend>Tarifas</legend>
                               <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="van_cliente">Van cliente</label>
                                        <input class="form-control" type="text" id="van_cliente">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="van_proveedor">Van proveedor</label>
                                        <input class="form-control" type="text" id="van_proveedor">
                                    </div>
                                     <div class="col-xs-3">
                                        <label class="obligatorio" for="bus_cliente">Bus cliente</label>
                                        <input class="form-control" type="text" id="bus_cliente">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="bus_proveedor">Bus proveedor</label>
                                        <input class="form-control" type="text" id="bus_proveedor">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="automovil_cliente">Automovil cliente</label>
                                        <input class="form-control" type="text" id="automovil_cliente">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="automovil_proveedor">Automovil proveedor</label>
                                        <input class="form-control" type="text" id="automovil_proveedor">
                                    </div>
                                     <div class="col-xs-3">
                                        <label class="obligatorio" for="buseta_cliente">Buseta cliente</label>
                                        <input class="form-control" type="text" id="buseta_cliente">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="buseta_proveedor">Buseta proveedor</label>
                                        <input class="form-control" type="text" id="buseta_proveedor">
                                    </div>
                                     <div class="col-xs-3">
                                        <label class="obligatorio" for="minivan_cliente">Minivan cliente</label>
                                        <input class="form-control" type="text" id="minivan_cliente">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="minivan_proveedor">Minivan proveedor</label>
                                        <input class="form-control" type="text" id="minivan_proveedor">
                                    </div>
                               </div>
                            </fieldset>
                            <fieldset style="margin-top: 10px"><legend>Descripcion</legend>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <textarea class="form-control" type="text" id="descripcion"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="guardar_ruta" class="btn btn-primary btn-icon">
                        Guardar<i class="fa fa-floppy-o icon-btn"></i>
                    </button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close     icon-btn"></i></a>
                </div>

            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="shortModal2" class="modal fade">

    <div class="modal-dialog modal-lg">
        <form id="formulario">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Editar Ruta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <label class="obligatorio" for="nombre_editar">Nombre</label>
                            <input class="form-control" type="text" id="nombre_editar">
                        </div>
                        <div class="col-xs-12">
                            <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend>Tarifas</legend>
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="van_cliente_editar">Van cliente</label>
                                        <input class="form-control" type="text" id="van_cliente_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="van_proveedor_editar">Van proveedor</label>
                                        <input class="form-control" type="text" id="van_proveedor_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="bus_cliente_editar">Bus cliente</label>
                                        <input class="form-control" type="text" id="bus_cliente_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="bus_proveedor_editar">Bus proveedor</label>
                                        <input class="form-control" type="text" id="bus_proveedor_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="automovil_cliente_editar">Automovil cliente</label>
                                        <input class="form-control" type="text" id="automovil_cliente_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="automovil_proveedor_editar">Automovil proveedor</label>
                                        <input class="form-control" type="text" id="automovil_proveedor_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="buseta_cliente_editar">Buseta cliente</label>
                                        <input class="form-control" type="text" id="buseta_cliente_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="buseta_proveedor_editar">Buseta proveedor</label>
                                        <input class="form-control" type="text" id="buseta_proveedor_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="minivan_cliente_editar">Minivan cliente</label>
                                        <input class="form-control" type="text" id="minivan_cliente_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="minivan_proveedor_editar">Minivan proveedor</label>
                                        <input class="form-control" type="text" id="minivan_proveedor_editar">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset style="margin-top: 10px"><legend>Descripcion</legend>
                                <div class="col-xs-12">
                                    <div class="row">
                                        <textarea class="form-control" type="text" id="descripcion_editar"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="actualizar_ruta" class="btn btn-primary btn-icon">
                        Guardar<i class="fa fa-floppy-o icon-btn"></i>
                    </button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
                </div>

            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div style="left: 40%" class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>
<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/rutas.js')}}"></script>

</body>
</html>