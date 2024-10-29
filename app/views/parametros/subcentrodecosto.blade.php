<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | Subcentros</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>
@include('admin.menu')
<div class="col-lg-12">
    <h3 class="h_titulo">SUBCENTROS | {{$razon_social}}</h3>
    @if(isset($subcentrosdecosto))
        <table id="@if($centrodecosto->razonsocial==='PERSONA NATURAL'){{'example'}}@else{{'example1'}}@endif" class="table table-bordered hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    @if($centrodecosto->razonsocial==='PERSONA NATURAL')
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>C.C</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Asesor Comercial</th>
                    <th>Tercero</th>
                    <th></th>
                    @else
                        <th>Codigo</th>
                        <th>Razon Social</th>
                        <th>Contacto</th>
                        <th>Cargo</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Telefono</th>
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tfoot>
                <tr>
                    @if($centrodecosto->razonsocial==='PERSONA NATURAL')
                        <th>#</th>
                        <th>Nombre completo</th>
                        <th>C.C</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Celular</th>
                        <th>Email</th>
                        <th>Asesor Comercial</th>
                        <th>Tercero</th>
                        <th></th>
                    @else
                        <th>Codigo</th>
                        <th>Razon Social</th>
                        <th>Contacto</th>
                        <th>Cargo</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Telefono</th>
                        <th></th>
                    @endif
                </tr>
            </tfoot>
            <tbody>
            @foreach($subcentrosdecosto as $subcentro)
                @if($centrodecosto->razonsocial==='PERSONA NATURAL')
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$subcentro->nombresubcentro}}</td>
                        <td>{{$subcentro->identificacion}}</td>
                        <td>{{$subcentro->direccion}}</td>
                        <td>{{$subcentro->telefono}}</td>
                        <td>{{$subcentro->celular}}</td>
                        <td>{{$subcentro->email_contacto}}</td>
                        <td>{{$subcentro->nombre_completo}}</td>
                        <td>{{$subcentro->tnombre_completo}}</td>
                        <td>
                            @if(isset($permisos->administrativo->centros_de_costo->editar))
                                @if($permisos->administrativo->centros_de_costo->editar==='on')
                                    <a data-toggle="modal" data-target=".modal_editar" class="btn btn-list-table btn-primary editar_cliente" id="{{$subcentro->id}}">EDITAR</a>
                                @else
                                    <a class="btn btn-list-table btn-primary editar_cliente disabled">EDITAR</a>
                                @endif
                            @else
                                <a class="btn btn-list-table btn-primary editar_cliente disabled">EDITAR</a>
                            @endif
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{'CL00'.$id.'-'.$i++}}</td>
                        <td>{{$subcentro->nombresubcentro}}</td>
                        <td>{{$subcentro->nombre_contacto}}</td>
                        <td>{{$subcentro->cargo_contacto}}</td>
                        <td>{{$subcentro->email_contacto}}</td>
                        <td>{{$subcentro->celular}}</td>
                        <td>{{$subcentro->telefono}}</td>
                        <td>
                            @if(isset($permisos->administrativo->centros_de_costo->editar))
                                @if($permisos->administrativo->centros_de_costo->editar==='on')
                                    <a data-toggle="modal" data-target=".modal_editar" class="btn btn-list-table btn-primary editar_subcentro" id="{{$subcentro->id}}">EDITAR</a>
                                @else
                                    <a class="btn btn-list-table btn-primary editar_subcentro disabled">EDITAR</a>
                                @endif
                            @else
                                <a class="btn btn-list-table btn-primary editar_subcentro disabled">EDITAR</a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($permisos->administrativo->centros_de_costo->crear))
        @if($permisos->administrativo->centros_de_costo->crear==='on')
            <button type="button" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal">Agregar<i class="fa fa-plus icon-btn"></i></button>
        @else
            <button type="button" class="btn btn-default btn-icon disabled disabled" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
        @endif
    @else
        <button type="button" class="btn btn-default btn-icon disabled" disabled>Agregar<i class="fa fa-plus icon-btn"></i></button>
    @endif
    <a href="{{url('centrodecosto')}}" class="btn btn-icon btn-primary">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>

@if($centrodecosto->razonsocial==='PERSONA NATURAL')
    <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario_subcentro">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <strong>NUEVA PERSONA NATURAL</strong>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="nombre_completo_editar">Primer Nombre</label>
                                        <input class="form-control input-font" type="text" id="first_name">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="nombre_completo_editar">Segundo Nombre</label>
                                        <input class="form-control input-font" type="text" id="last_name">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="cedula">C.C</label>
                                        <input class="form-control input-font" type="text" id="cedula">
                                    </div>
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="direccion">Direccion</label>
                                        <input class="form-control input-font" type="text" id="direccion">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="celular">Celular</label>
                                        <input class="form-control input-font" type="text" id="celular">
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="telefono">Telefono</label>
                                        <input class="form-control input-font" type="text" id="telefono">
                                    </div>
                                    
                                    <div class="col-xs-3">
                                        <label for="email">Email</label>
                                        <input class="form-control input-font" type="text" id="email">
                                    </div>
                                    <div class="col-xs-3">
                                      <label for="asesor_comercial">Asesor Comercial</label>
                                      <select class="form-control input-font" id="asesor_comercial">
                                        <option value="0">-</option>
                                        @foreach ($comercial as $value)
                                            <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-xs-3">
                                      <label for="tercero">Tercero</label>
                                      <select class="form-control input-font" id="tercero">
                                        <option value="0">-</option>
                                        @foreach ($terceros as $value)
                                            <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right;" class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="copy">
                          <label class="form-check-label" for="flexCheckDefault" style="font-size: 15px;">
                            Copiar Datos
                          </label>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <h4>Address</h4>
                                <div class="row">
                                    <div class="col-xs-5">
                                        <label class="obligatorio" for="nombresubcentro">Dirección</label>
                                        <input class="form-control input-font" type="text" id="direccion_siigo">
                                    </div>
                                    <div class="col-xs-5">
                                      <label class="obligatorio">Ciudad</label><br>
                                      <select class="selectpicker" id="ciudad" data-show-subtext="true" data-live-search="true">
                                        <option data-subtext="Seleccionar una" id="0">Ciudades</option>
                                        <option data-subtext="Atlántico" state-name="Atlántico" id="08001" data-state="08" country-code="Co" country-name="Colombia" state-code="08">Barranquilla</option>
                                        <option data-subtext="Antioquia" id="05001" data-state="05">Medellín</option>
                                        <option data-subtext="Bogotá D.C" id="11001" data-state="11">Bogotá</option>
                                        <option data-subtext="Valle del Cauca" id="76001" data-state="76">Cali</option>
                                      </select>
                                    </div>
                                </div>
                                <h4>Contacto</h4>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label class="obligatorio" for="direccion">Primer Nombre</label>
                                        <input class="form-control input-font" type="text" id="first_name_siigo">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="telefono">Segundo Nombre</label>
                                        <input class="form-control input-font" type="text" id="last_name_siigo">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="email">Email</label>
                                        <input class="form-control input-font" type="text" id="email_siigo">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="{{$id}}" type="submit" id="guardar_cliente" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>

                        <button data-id="{{$id}}" id="guardar_cliente2" class="btn btn-success btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>

                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade modal_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario_subcentro">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <strong>EDITAR PERSONA NATURAL</strong>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="nombre_completo_editar">Nombre Completo</label>
                                        <input class="form-control input-font" type="text" id="nombre_completo_editar">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="cc_editar">C.C o Nit</label>
                                        <input class="form-control input-font" type="text" id="identificacion_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="direccion_editar">Direccion</label>
                                        <input class="form-control input-font" type="text" id="direccion_editar">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="telefono_editar">Telefono</label>
                                        <input class="form-control input-font" type="text" id="telefono_editar">
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="obligatorio" for="celular_editar">Celular</label>
                                        <input class="form-control input-font" type="text" id="celular_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="email_editar">Email</label>
                                        <input class="form-control input-font" type="text" id="email_editar" autocomplete="off">
                                    </div>
                                    <div class="col-xs-3">
                                      <label for="asesor_comercial">Asesor Comercial</label>
                                      <select class="form-control input-font" id="asesor_comercial_editar">
                                        <option value="0">-</option>
                                        @foreach ($comercial as $value)
                                            <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="col-xs-3">
                                      <label for="tercero_editar">Tercero</label>
                                      <select class="form-control input-font" id="tercero_editar">
                                        <option value="0">-</option>
                                        @foreach ($terceros as $value)
                                            <option value="{{$value->id}}">{{$value->nombre_completo}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="actualizar_cliente" class="btn btn-primary btn-icon">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></button>
                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
@else
    <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario_subcentro">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <strong>NUEVO SUB-CENTRO DE COSTO</strong>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="razonsocial">Razon Social</label>
                                        <input class="form-control input-font" type="text" id="razonsocial">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="nombre_completo">Nombre Completo</label>
                                        <input class="form-control input-font" type="text" id="nombre_completo">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="cargo">Cargo</label>
                                        <input class="form-control input-font" type="text" id="cargo">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="email">Email</label>
                                        <input class="form-control input-font" type="text" id="email" autocomplete="off">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="celular">Celular</label>
                                        <input class="form-control input-font" type="text" id="celular">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="telefono">Telefono</label>
                                        <input class="form-control input-font" type="text" id="telefono">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="{{$id}}" type="submit" id="guardar" class="btn btn-primary btn-icon">Guardar<i class="fa fa-floppy-o icon-btn"></i></button>
                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade modal_editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg">
            <form id="formulario_subcentro">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                        <strong>EDITAR SUB-CENTRO DE COSTO</strong>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="razonsocial_editar">Razon Social</label>
                                        <input class="form-control input-font" type="text" id="razonsocial_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="nombre_completo_editar">Nombre Completo</label>
                                        <input class="form-control input-font" type="text" id="nombre_completo_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="cargo_editar">Cargo</label>
                                        <input class="form-control input-font" type="text" id="cargo_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="email_editar">Email</label>
                                        <input class="form-control input-font" type="text" id="email_editar" autocomplete="off">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="celular_editar">Celular</label>
                                        <input class="form-control input-font" type="text" id="celular_editar">
                                    </div>
                                    <div class="col-xs-3">
                                        <label class="obligatorio" for="telefono_editar">Telefono</label>
                                        <input class="form-control input-font" type="text" id="telefono_editar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="{{$id}}" type="submit" id="actualizar_subcentrodecosto" class="btn btn-primary btn-icon">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></button>
                        <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
@endif
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

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/subcentros.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script>

    $('#copy').click(function() {

        if ($('#copy').is(':checked')) {
            
            $('#direccion_siigo').val($('#direccion').val());
            $('#first_name_siigo').val($('#first_name').val());
            $('#last_name_siigo').val($('#last_name').val());
            $('#email_siigo').val($('#email').val());

        }else{

            $('#direccion_siigo').val('');
            $('#first_name_siigo').val('');
            $('#last_name_siigo').val('');
            $('#email_siigo').val('');

        }

    })

    $('#guardar_cliente2').click(function (e) {

        e.preventDefault();

        var formData = new FormData();
        var id = $(this).attr('data-id');
        //var nombre_completo = $('#nombresubcentro').val().trim().toUpperCase();
        var first_name = $('#first_name').val().trim().toUpperCase();
        var last_name = $('#last_name').val().trim().toUpperCase();
        var cedula = $('#cedula').val().trim();
        var direccion = $('#direccion').val().trim().toUpperCase();
        var telefono = $('#telefono').val().trim();
        var celular = $('#celular').val().trim();
        var email = $('#email').val().trim().toUpperCase();
        var asesor_comercial = $('#asesor_comercial').val();
        var tercero = $('#tercero').val();

        var direccion_siigo = $('#direccion_siigo').val();

        var first_name_siigo = $('#first_name_siigo').val();
        var last_name_siigo = $('#last_name_siigo').val();
        var email_siigo = $('#email_siigo').val();

        var ciudad = $('#ciudad option:selected').html();
        var state_name = $('#ciudad option:selected').attr('state-name');
        var state_code = $('#ciudad option:selected').attr('state-code');
        var country_code = $('#ciudad option:selected').attr('country-code');
        var country_name = $('#ciudad option:selected').attr('country-name');
        var id_ciudad = $('#ciudad option:selected').attr('id');

        
        var select = $('#picker').val();

        console.log('Picker : ' + select)
        
        
        

        console.log(ciudad+' , '+state_name+' , '+country_code+' , '+country_name+' , '+id_ciudad+' , '+state_code)

        console.log(direccion_siigo+' , '+first_name_siigo+' , '+last_name_siigo+' , '+email_siigo)

        

        if(first_name==='' || last_name==='' || cedula==='' || direccion==='' || email==='' || direccion_siigo==='' || ciudad==='Ciudades' || first_name_siigo==='' || last_name_siigo==='' || email_siigo===''){
            
            var text = '';

            if(first_name===''){
                text += 'Campo Nombres<br>';
            }

            if(last_name===''){
                text += 'Campo Apellidos<br>';
            }

            if(cedula===''){
                text += 'Campo C.C<br>';
            }

            if(direccion===''){
                text += 'Campo Dirección<br>';
            }

            if(email===''){
                text += 'Campo Email<br>';
            }

            if(direccion_siigo===''){
                text += 'Campo dirección<br>';
            }

            if(ciudad==='Ciudades'){
                text += 'Campo Ciudad<br>';
            }

            if(first_name_siigo===''){
                text += 'Campo Nombres<br>';
            }

            if(last_name_siigo===''){
                text += 'Campo Apellidos<br>';
            }

            if(email_siigo===''){
                text += 'Campo Email<br>';
            }


            alert(text);

        
            //alert('Digite el nombre completo');
        }else{

            formData.append('id',id);
            //formData.append('nombre_completo',nombre_completo);
            formData.append('first_name',first_name);
            formData.append('last_name',last_name);
            formData.append('identificacion',cedula);
            formData.append('direccion',direccion);
            formData.append('telefono',telefono);
            formData.append('celular',celular);
            formData.append('email',email);
            formData.append('asesor_comercial',asesor_comercial);
            formData.append('tercero',tercero);

            formData.append('ciudad',ciudad);
            formData.append('state_name',state_name);
            formData.append('country_code',country_code);
            formData.append('country_name',country_name);
            formData.append('id_ciudad',id_ciudad);
            formData.append('state_code',state_code);

            formData.append('direccion_siigo',direccion_siigo);
            formData.append('first_name_siigo',first_name_siigo);
            formData.append('last_name_siigo',last_name_siigo);
            formData.append('email_siigo',email_siigo);

            $.ajax({
                data: formData,
                type: 'post',
                url: '../../centrodecosto/nuevocliente',
                processData: false,
                contentType: false,
                success: function(data){

                    if(data.mensaje===false){
                        if(!($('.guardado').hasClass('hidden'))){
                            $('.guardado').addClass('hidden');
                        }

                        $('.errores-modal ul li').remove();
                        for(i in data.errores){
                            var string = JSON.stringify(data.errores[i]);
                            var clean = string.split('"').join('')
                                .split('.').join('<br>')
                                .split(',').join('<li>')
                                .split('[').join('')
                                .split(']').join('');

                            $('.errores-modal').removeClass('hidden');
                            $('.errores-modal ul').append('<li>'+clean+'</li>');
                        }
                    }else if(data.respuesta===true){

                        if(!($('.errores-modal').hasClass('hidden'))){
                            $('.errores-modal').addClass('hidden');
                        }

                        location.reload();

                    }else{
                        $('.errores-modal ul li').remove();
                        $('.errores-modal').addClass('hidden');
                    }
                },
                error: function (request, status, error) {
                    console.log('Hubo un error, llame al administrador del sistema'+request+status+error);
                }
            });
        }
    });

    $('#example').DataTable( {
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
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
        "order": [[ 0, "asc" ]],
        'bAutoWidth': false,
        'aoColumns': [
            {'sWidth': '2%'},
            {'sWidth': '14%'},
            {'sWidth': '5%'},
            {'sWidth': '12%'},
            {'sWidth': '5%'},
            {'sWidth': '5%'},
            {'sWidth': '8%'},
            {'sWidth': '8%'},
            {'sWidth': '8%'},
            {'sWidth': '3%'}
        ]
    });

    $('#example1').DataTable( {
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
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
        'bAutoWidth': false,
        'aoColumns': [
            {'sWidth': '5%'},
            {'sWidth': '15%'},
            {'sWidth': '15%'},
            {'sWidth': '10%'},
            {'sWidth': '10%'},
            {'sWidth': '10%'},
            {'sWidth': '10%'},
            {'sWidth': '10%'},
        ]
    });
</script>
</body>
</html>
