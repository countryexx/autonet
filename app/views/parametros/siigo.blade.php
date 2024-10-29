<html xmlns="http://www.w3.org/1999/html">
<head>
	<title>Autonet | Siigo</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
		<meta name="url" content="{{url('/')}}">
</head>

@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<body>

@include('admin.menu')

<div class="col-lg-12">
    <h3 class="h_titulo">Clientes pendiente por crear en Siigo</h3>
    @include('parametros.menu_cc')
		<div class="col-lg-2 col-md-3 col-sm-2" style="margin-bottom: 5px;">

    </div>
    @if(isset($centrosdecosto))
    <table id="examplesiigo" class="table table-striped table-bordered hover" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Ciudad</th>
            <th>Razon Social - Nit</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Informacion</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>ID</th>
            <th>Ciudad</th>
            <th>Razon Social - Nit</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
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
            <td>{{$centrodecosto->razonsocial.' '.$centrodecosto->tipoempresa}} - {{$centrodecosto->nit}}</td>
            <td>{{$centrodecosto->nombres_contacto}}</td>
            <td>{{$centrodecosto->apellidos_contacto}}</td>
            <td>{{$centrodecosto->correo_contacto}}</td>
            <td>
                <a data-id="{{$centrodecosto->id}}" data-razon="{{$centrodecosto->razonsocial}}" data-nit="{{$centrodecosto->nit}}" data-digit="{{$centrodecosto->codigoverificacion}}" data-tipo="{{$centrodecosto->tipoempresa}}" data-direccion="{{$centrodecosto->direccion}}" data-city="{{$centrodecosto->ciudad}}" data-tel="{{$centrodecosto->telefono}}" data-emails="{{$centrodecosto->email}}" data-names="{{$centrodecosto->nombres_contacto}}" data-apellidos="{{$centrodecosto->apellidos_contacto}}" data-mail="{{$centrodecosto->correo_contacto}}" data-url="{{$centrodecosto->rut}}" data-toggle="modal" data-target=".mymodal1" class="ver_rut btn btn-list-table btn-warning">Ver RUT</a>

                <a data-id="{{$centrodecosto->id}}" data-razonsocial="{{$centrodecosto->razonsocial}}" class="generar_cliente btn btn-list-table btn-info  ">Generar en Siigo</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
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
                    	<strong>RUT</strong>
                </div>
                <div class="modal-body">
                    <div class="row edicion">
                        <div class="col-xs-12">

                            <center>
                                <iframe id="pdf" style="width: 900px; height: 390px;"></iframe>
                            </center>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="obligatorio" for="razon">Razón Social</label>
                            <input type="text" id="razon" disabled class="form-control razon input-font">
                        </div>
                        <div class="col-lg-3">
                            <label style="text-align: left;" for="nit">Nit</label>
                            <input type="text" id="nitd" disabled class="form-control nitd input-font">
                        </div>
                        <div class="col-lg-1">
                            <label class="obligatorio" for="digit">Digito</label>
                            <input type="text" id="digit" disabled class="form-control digit input-font">
                        </div>
                        <div class="col-lg-1">
                            <label class="obligatorio" for="tipo">Empresa</label>
                            <input type="text" id="tipo" disabled class="form-control tipo input-font">
                        </div>
                        <div class="col-lg-3">
                            <label class="obligatorio" for="direcciond">Direccion</label>
                            <input type="text" id="direcciond" disabled class="form-control direcciond input-font">
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-lg-3">
                            <label class="obligatorio" for="city">Ciudad</label>
                            <input type="text" id="city" disabled class="form-control city input-font">
                        </div>
                        <div class="col-lg-3">
                            <label style="text-align: left;" for="tel">Teléfono</label>
                            <input type="text" id="tel" disabled class="form-control tel input-font">
                        </div>
                        
                        <div class="col-lg-3">
                            <label class="obligatorio" for="emails">Mail</label>
                            <input type="text" id="emails" disabled class="form-control emails input-font">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Datos del Contacto</h4>
                            <div class="row">
                                
                                <div class="col-lg-3">
                                    <label style="text-align: left;" for="nit">Nombres</label>
                                    <input type="text" id="names" disabled class="form-control names input-font">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="apellidosd">Apellidos</label>
                                    <input type="text" id="apellidosd" disabled class="form-control apellidosd input-font">
                                </div>
                                <div class="col-lg-3">
                                    <label class="obligatorio" for="mail">Correo</label>
                                    <input type="text" id="mail" disabled class="form-control mail input-font">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">

                            <!--<button style="margin-top: 10px; float: right;" type="submit" id="guardar" class="btn btn-primary btn-icon input-font">GUARDAR CAMBIOS<i class="fa fa-floppy-o icon-btn"></i></button>-->

                        </div>
                    </div>
                    <div class="row">
                        
                        

                    </div>
                </div>
                <div class="modal-footer">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript">
    
    $tablekm = $('#examplesiigo').DataTable({
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "Ningun registro encontrado",
            emptyTable:     "Ningun registro disponible en la tabla",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre d�croissant"
            }
        },
        'bAutoWidth': false ,
        "order": [[ 2, "asc" ]],
        'aoColumns' : [
            { 'sWidth': '3%' },
            { 'sWidth': '4%' },
            { 'sWidth': '8%' },
            { 'sWidth': '8%' },
            { 'sWidth': '7%' },
            { 'sWidth': '8%' },
            { 'sWidth': '18%' }
        ]
    });

    $('#examplesiigo').on('click', '.generar_cliente', function () {
        console.log('test '+$(this).attr('data-id'));

        var razon = $(this).attr('data-razonsocial');
        var id = $(this).attr('data-id');

        $.confirm({
            title: 'Confirmación',
            content: 'Estás seguro de Generar al cliente '+razon+' en Siigo?',
            buttons: {
                confirm: {
                    text: 'Si, Generar!',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      $.ajax({
                        type: "post",
                        url: "generarcliente",
                        data: {
                            'id': id
                        },
                        dataType: 'json',
                        success: function(data) {

                            if(data.mensaje===false){

                                alert('respuesta falsa')

                            }else if(data.mensaje===true){
                                
                                alert('Cliente creado en siigo!')
                                location.reload();
                            }
                        }
                    });

                    }

                },
                cancel: {
                  text: 'Cancelar',
                } 
            }        
        });

    });

    $('#examplesiigo').on('click', '.ver_rut', function () {
        console.log('test '+$(this).attr('data-direccion'));

        $('#nitd').val($(this).attr('data-nit'))
        $('#razon').val($(this).attr('data-razon'))
        $('#digit').val($(this).attr('data-digit'))
        $('#tipo').val($(this).attr('data-tipo'))
        $('#direcciond').val($(this).attr('data-direccion'))
        $('#city').val($(this).attr('data-city'))
        $('#tel').val($(this).attr('data-tel'))
        $('#emails').val($(this).attr('data-emails'))

        $('#names').val($(this).attr('data-names'))
        $('#apellidosd').val($(this).attr('data-apellidos'))
        $('#mail').val($(this).attr('data-mail'))

        $('#pdf').attr('src', 'http://localhost/autonet/biblioteca_imagenes/clientes/rut/'+$(this).attr('data-url'));
    });

</script>


</html>
