<html xmlns="http://www.w3.org/1999/html">
<head>
	<title>Autonet | Centro de costo</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
		<meta name="url" content="{{url('/')}}">
</head>

@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">

<body>

@include('admin.menu')

<div class="col-lg-12">
    <h3 class="h_titulo">TARIFAS POR KILOMETRAJE</h3>
    @include('parametros.menu_cc')
		<div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">

    </div>
    @if(isset($centrosdecosto))
    <table id="examplekm" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Ciudad</th>
            <th>Razon Social</th>
            <th>Valor Local</th>
            <th>Valor Municipal</th>
            <th>Valor Departamental</th>
            <th>Informacion</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>ID</th>
            <th>Ciudad</th>
            <th>Razon Social</th>
            <th>Valor Local</th>
            <th>Valor Municipal</th>
            <th>Valor Departamental</th>
            <th>Informacion</th>
        </tr>
        </tfoot>
        <tbody>
        @foreach($centrosdecosto as $centrodecosto)
        <tr class="@if($centrodecosto->inactivo==1){{'warning'}}@endif @if($centrodecosto->inactivo_total){{'danger'}}@endif">
            <td>
                @if(intval(strlen($centrodecosto->id))===1)
                {{'CL00'.$centrodecosto->id}}
                @elseif(intval(strlen($centrodecosto->id))===2)
                {{'CL0'.$centrodecosto->id}}
                @elseif(intval(strlen($centrodecosto->id))===3)
                {{'CL'.$centrodecosto->id}}
                @endif
            </td>
            <td><?php echo strtoupper($centrodecosto->localidad); ?></td>
            <td>{{$centrodecosto->razonsocial.' '.$centrodecosto->tipoempresa}}</td>
            <td>{{$centrodecosto->valor_metro}}</td>
            <td>{{$centrodecosto->valor_metro_m}}</td>
            <td>{{$centrodecosto->valor_metro_d}}</td>
            <td>
                <a data-id="{{$centrodecosto->id}}" data-toggle="modal" data-target=".mymodal1" class="detalles_centro btn btn-list-table btn-primary">Detalles</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
    @if(isset($permisos->administrativo->centros_de_costo->crear))
        @if($permisos->administrativo->centros_de_costo->crear==='on')
            <button type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">Agregar<i class="fa fa-plus icon-btn"></i></button>
        @else
            <button type="button" class="btn btn-default btn-icon disabled" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
        @endif
    @else
        <button type="button" class="btn btn-default btn-icon disabled" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
    @endif
    <a class="btn btn-primary btn-icon" href="{{url('/')}}">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

<div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                  	<strong>NUEVO CENTRO DE COSTO</strong>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
																<div class="col-xs-2">
                                    <label class="obligatorio" for="tipo_cliente">Tipo de cliente</label>
                                    <select class="form-control input-font" id="tipo_cliente" name="tipo_cliente">
                                        <option value="0">TIPO CLIENTE</option>
                                        <option value="1">INTERNO</option>
                                        <option value="2">AFILIADO EXTERNO</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="nit">Nit.</label>
                                    <input class="form-control input-font" type="text" id="nit">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="digitoverificacion">Digito verificacion</label>
                                    <select name="digitoverificacion" class="form-control input-font" id="digitoverificacion">
                                        <option>-</option>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio" for="razonsocial">Razon social</label>
                                    <input class="form-control input-font" type="text" id="razonsocial">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="tipoempresa">Tipo de empresa</label>
                                    <select class="form-control input-font" name="tipoempresa" id="tipoempresa">
                                        <option>-</option>
                                        <option>P.N</option>
                                        <option>S.A.S</option>
                                        <option>S.A</option>
                                        <option>S.C.A</option>
                                        <option>S.C</option>
                                        <option>L.T.D.A</option>
                                        <option>OTROS</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="direccion">Direccion</label>
                                    <input class="form-control input-font" type="text" id="direccion">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="departamento">Departamento</label>
                                    <select class="form-control input-font" id="departamento">
                                        <option>-</option>
                                        @foreach($departamentos as $departamento)
                                            <option value="{{$departamento->id}}">{{$departamento->departamento}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio" for="ciudad">Ciudad o Municipio</label>
                                    <select disabled class="form-control input-font" id="ciudad">
                                        <option>-</option>
                                    </select>
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="email">Email</label>
                                    <input class="form-control input-font" type="text" id="email" autocomplete="off">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="telefono">Telefono</label>
                                    <input class="form-control input-font" type="text" id="telefono">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="telefono">Asesor Comercial</label>
                                    <select class="form-control input-font" id="asesorcomercial">
                                        <option value="0">-</option>
                                        <?php foreach ($asesor_comercial as $key => $value): ?>
                                            <?php echo '<option value="'.$value->id.'">'.$value->nombre_completo.'</option>'; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio">Credito</label>
                                    <select id="credito" class="form-control input-font">
                                        <option value="0">-</option>
                                        <option value="1">SI</option>
                                        <option value="2">NO</option>
                                    </select>
                                </div>
                                <div class="col-xs-2 hidden plazo_pago">
                                    <label class="obligatorio">Plazo de Pago</label>
                                    <input type="text" class="form-control input-font" id="plazo_pago">
                                </div>
                                <div class="col-xs-2">
                                      <label class="obligatorio" for="localidad">Localidad</label>
                                      <select class="form-control input-font" name="localidad" id="localidad">
                                          <option>-</option>
                                          <option>Barranquilla</option>
                                          <option>Bogota</option>
                                      </select>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(isset($permisos->administrativo->centros_de_costo->crear))
                        @if($permisos->administrativo->centros_de_costo->crear==='on')
                            <button type="submit" id="guardar" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        @else
                            <button type="submit" class="btn btn-primary btn-icon input-font disabled" disabled>Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        @endif
                    @else
                        <button type="submit" class="btn btn-primary btn-icon input-font disabled" disabled>Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    @endif
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon input-font">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade mymodal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_actualizar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    	<strong>EDITAR VALORES</strong>
                </div>
                <div class="modal-body">
                    <div class="row edicion">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-4">
                                    <label class="obligatorio">Valor Metro Local</label>
                                    <input class="form-control input-font" type="text" id="valor_metro_l" value="">
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio">Valor Metro InterMunicipal</label>
                                    <input class="form-control input-font" type="text" id="valor_metro_m" value="">
                                </div>
                                <div class="col-xs-4">
                                    <label class="obligatorio">Valor Metro InterDepartamental</label>
                                    <input class="form-control input-font" type="text" id="valor_metro_d" value="">
                                </div>
                               
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(isset($permisos->administrativo->centros_de_costo->editar))
                        @if($permisos->administrativo->centros_de_costo->editar==='on')
                            
                            <button id="actualizar_cc" class="btn btn-primary btn-icon input-font">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        @else
                            <a class="btn btn-success btn-icon input-font disabled">Editar<i class="fa fa-pencil icon-btn"></i></a>
                            <button class="btn btn-primary btn-icon input-font disabled" disabled>Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        @endif
                    @else
                        
                        <button id="actualizar_cc" class="btn btn-primary btn-icon input-font disabled" disabled>Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                    @endif

                    <a data-dismiss="modal" class="btn btn-danger btn-icon input-font">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <form id="formulario_actualizar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">CONTACTOS</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 datos_nuevos">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label class="obligatorio">Nombre</label>
                                    <input type="text" class="form-control nombre input-font">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio">Cargo</label>
                                    <input type="text" class="form-control cargo input-font">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio">Email</label>
                                    <input type="text" class="form-control email input-font">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio">Celular</label>
                                    <input type="text" class="form-control celular input-font">
                                </div>
                                <div class="col-xs-2">
                                    <label class="obligatorio">Telefono</label>
                                    <input type="text" class="form-control telefono input-font">
                                </div>
                                <div class="col-xs-1">
                                    <button style="margin-top:30px" id="nuevo_contacto" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="lista">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <a data-dismiss="modal" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div>

<div class="errores-modal bg-danger text-danger hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul>
    </ul>
</div>

<div class="guardado bg-success text-success hidden model">
    <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
    <ul style="margin: 0;padding: 0;">
    </ul>
</div>

</body>

@include('scripts.scripts')
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/clientes.js')}}"></script>


</html>
