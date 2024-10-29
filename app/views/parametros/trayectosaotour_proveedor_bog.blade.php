<html>
<head>
	<title>Autonet | Traslados con Tarifa AOTOUR</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <style type="text/css">
        .switch {
          position: relative;
          display: inline-block;
          width: 60px;
          height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
          opacity: 0;
          width: 0;
          height: 0;
        }

        /* The slider */
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #ccc;
          -webkit-transition: .4s;
          transition: .4s;
        }

        .slider:before {
          position: absolute;
          content: "";
          height: 26px;
          width: 26px;
          left: 4px;
          bottom: 4px;
          background-color: white;
          -webkit-transition: .4s;
          transition: .4s;
        }

        input:checked + .slider {
          background-color: #2196F3;
        }

        input:focus + .slider {
          box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
          -webkit-transform: translateX(26px);
          -ms-transform: translateX(26px);
          transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
          border-radius: 34px;
        }

        .slider.round:before {
          border-radius: 50%;
        }
    </style>
<body>
@include('admin.menu')

<div class="col-lg-12">

<h3 class="h_titulo">LISTADO DE TRAYECTOS CON TARIFA AOTOUR - PROVEEDORES BOG</h3>

    @if(isset($ruta_general))

        <table id="exampless" class="table table-striped table-bordered hover" cellspacing="0" width="100%" style="margin-top: 65px">
            <thead>
                <tr>
                    <th>#</th>
                                                          
                    <th>Nombre</th>
                        @foreach($query as $key)
                            <th style="text-align: center;">{{$key->razonsocial}}</th>
                        @endforeach
                    <!--<th style="text-align: center;">SGS</th>
                    <th>AVIATUR</th>
                    <th style="text-align: center;">Opciones</th>-->
                </tr>
            </thead>
            
            <tbody>
            @foreach($ruta_general as $ruta)
                <tr>
                    <td>{{$i++}}</td>
                    
                    <td>{{$ruta->nombre}}</td>

                    @foreach($query as $key)

                        <td style="text-align: center;">
                        <?php 
                        $tarifa = DB::table('tarifas')
                        ->leftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'tarifas.centrodecosto_id')
                        ->select('tarifas.id', 'tarifas.trayecto_id', 'tarifas.proveedor_auto', 'tarifas.centrodecosto_id', 'centrosdecosto.razonsocial', 'centrosdecosto.id as id_centro')
                        ->where('centrodecosto_id', $key->id_centro)
                        ->whereNotNull('tarifas.localidad')
                        ->where('trayecto_id',$ruta->id)
                        ->first();
                        ?>

                        @if($tarifa!=null)
                            <p class="bolder text-primary" style="margin: 0 !important; font-size: 10px;">$ {{number_format($tarifa->proveedor_auto)}} <a title="Actualizar Tarifa" id="" style="padding: 2px 3px; float: right;" data-id="{{$tarifa->id}}" data-trayecto="{{$tarifa->trayecto_id}}" data-nombre="{{$ruta->nombre}}" data-valor="{{$tarifa->proveedor_auto}}" data-razonsocial="{{$tarifa->razonsocial}}" data-centro="{{$tarifa->id_centro}}" class="btn btn-warning editar_tarifas"><i class="fa fa-pencil-square-o"></i></a></p>
                        @else
                            N/A<a title="Actualizar Tarifa" id="" style="padding: 2px 3px; float: right;" data-nombre="{{$ruta->nombre}}" data-trayecto="{{$ruta->id}}" data-centro="{{$key->id_centro}}" data-razonsocial="{{$key->razonsocial}}" class="btn btn-info añadir_tarifas"><i class="fa fa-plus"></i></a>

                        @endif

                        

                    </td>

                    @endforeach

                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="col-lg-12">

            <a data-auto-c="" data-van-c="" data-auto-p="" data-van-p="" data-nombre="" title="Unificar Tarifa" id="" style="padding: 5px 6px; margin-bottom: 3px; float: right; margin-top: 20px; width: 150px;" class="btn btn-warning unificar">UNIFICAR <i style="float: right;" class="fa fa-random"></i></a>
        </div>
        <br><br><br>
        <!--<div class="col-lg-12">
            <a data-auto-c="" data-van-c="" data-auto-p="" data-van-p="" data-nombre="" title="Actualizar para todos" id="" style="float: right;  width: 150px;" class="btn btn-success editar_trayectosss">Exportar <i style="float: right;" class="fa fa-file-excel-o"></i></a>
        </div>-->

    @endif
   
</div>

<div id="shortModall" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formulario">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nuevo Trayecto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-xs-4">
                            <label class="obligatorio" for="nombre_editar">Nombre del Trayecto</label>
                            <input autocomplete="off" class="form-control" type="text" id="nombre_nuevo_trayecto">
                        </div>

                        <div class="col-xs-2">
                            <label class="obligatorio" for="nombre_editar">Valor Tarifa Cliente</label>
                            <input autocomplete="off" class="form-control" type="number" id="valor_tarifa_cliente">
                        </div>

                        <div class="col-xs-2">
                            <label class="obligatorio" for="nombre_editar">Valor Tarifa Proveedor</label>
                            <input autocomplete="off" class="form-control" type="number" id="valor_tarifa_proveedor">
                        </div>

                        <!--<div class="col-xs-3">
                            <label class="obligatorio" for="ciudad_new">Centro de Costo</label>
                            
                            <select class="form-control input-font" id="ciudad_new">
                                <option>Seleccionar</option>
                                @foreach($centrosdecosto as $centro)
                                    <option>{{$centro->razonsocial}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio" for="ciudad_new">Archivo</label><br>
                            <form style="display: inline" id="form_ruta">
                              <div style="display: inline-block; margin-bottom: 15px;">
                                  <input id="excel_ruta" type="file" value="Subir" name="excel">
                              </div>
                            </form>
                        </div>-->
                        
                        <!--<div class="col-xs-12">
                            
                              <table name="mytable" id="ruta_import" class="table table-hover table-bordered tablesorter">
                                  <thead>
                                      <tr>
                                          <td>#</td>
                                          <td>TRAYECTO</td>
                                          <td>CLIENTE AUTO</td>
                                          <td>CLIENTE VAN</td>
                                          <td>PROVEEDOR AUTO</td>
                                          <td>PROVEEDOR VAN</td>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>

                        </div>-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="guardar_ruta_individual" class="btn btn-primary btn-icon">
                        Guardar<i class="fa fa-floppy-o icon-btn"></i>
                    </button>
                    <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close     icon-btn"></i></a>
                </div>

            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="shortModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <form id="formulario">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Nuevo Trayecto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <label class="obligatorio" for="ciudad_new">Centro de Costo</label>
                            
                            <select class="form-control input-font" id="ciudad_new">
                                <option>Seleccionar</option>
                                @foreach($centrosdecosto as $centro)
                                    <option>{{$centro->razonsocial}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-2">
                            <label class="obligatorio" for="ciudad_new">Archivo</label><br>
                            <form style="display: inline" id="form_ruta">
                              <div style="display: inline-block; margin-bottom: 15px;">
                                  <input id="excel_ruta" type="file" value="Subir" name="excel">
                              </div>
                            </form>
                        </div>
						
                        <div class="col-xs-12">
                            
                              <table name="mytable" id="ruta_import" class="table table-hover table-bordered tablesorter">
                                  <thead>
                                      <tr>
                                          <td>#</td>
                                          <td>TRAYECTO</td>
                                          <td>CLIENTE AUTO</td>
                                          <td>CLIENTE VAN</td>
                                          <td>PROVEEDOR AUTO</td>
                                          <td>PROVEEDOR VAN</td>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>

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
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Generar Aumento</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-2">
                        <label class="obligatorio" for="nombre_editar">Porcentaje a aumentar</label>
                        <input autocomplete="off" class="form-control" type="number" id="nombre_aumentar">
                    </div>
					<div class="col-xs-6">
                        <!--<label class="obligatorio" for="ciudad_editar">Clientes</label>
                        
						<select class="form-control input-font selectpicker" id="clientes_editar" multiple data-live-search="true">
                            <option>Seleccionar</option>
							@foreach($centrosdecosto as $cliente)
								<option value="{{$cliente->id}}">{{$cliente->razonsocial}}</option>
							@endforeach
						</select>-->
						
                    </div>
                    <div class="col-xs-12">
                        <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend>Clientes</legend>
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <p>Selecciona los clientes a los que desea aumentar un procentaje</p>
                                    <table name="clientes_fuec" id="clientes_fuecs" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                                         <thead>
                                           <tr>
                                            <td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_alls" type="checkbox" check="false"></center></td>
                                             <td style="text-align: center;">Nombre del Cliente</td>
                                           </tr>
                                         </thead>
                                         <tbody>
                                            @foreach($clientes as $cliente)
                                                <tr>
                                                    <td><center><input class="clientss" data-id="{{$cliente->id}}" style="width: 15px; height: 15px;" type="checkbox" check="false"></center></td>
                                                    <td>{{$cliente->razonsocial}}</td>
                                                </tr>
                                            @endforeach
                                         </tbody>
                                       </table>

                                </div>
                                

                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="aumentar_porcentaje" class="btn btn-info btn-icon">
                    Aumentar %<i class="fa fa-floppy-o icon-btn"></i>
                </button>
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="unificar" class="modal fade">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Añadir clinte a tarifa AOTOUR</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-xs-12">
                        <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend>Clientes</legend>
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    <p style="font-size: 21px;">Selecciona los clientes a los que deseas unificar con tarifas AOTOUR</p>
                                    <table name="clientes_fuec" id="clientes_tarifa" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                                         <thead>
                                           <tr>
                                            <td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_alls" type="checkbox" check="false"></center></td>
                                             <td style="text-align: center;">Nombre del Cliente</td>
                                           </tr>
                                         </thead>
                                         <tbody>
                                            
                                         </tbody>
                                       </table>

                                </div>
                                

                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="unificar_tarifa" class="btn btn-info btn-icon">
                    Unificar<i class="fa fa-floppy-o icon-btn"></i>
                </button>
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="shortModal22" class="modal fade">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Actualizar Tarifa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="obligatorio" for="nombre_editar">Nombre de Trayecto</label>
                        <input class="form-control" disabled type="text" id="nombre_editar2">
                    </div>
                    <div class="col-xs-6">
                        <!--<label class="obligatorio" for="ciudad_editar">Clientes</label>
                        
                        <select class="form-control input-font selectpicker" id="clientes_editar" multiple data-live-search="true">
                            <option>Seleccionar</option>
                            @foreach($centrosdecosto as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->razonsocial}}</option>
                            @endforeach
                        </select>-->
                        
                    </div>
                    <div class="col-xs-12">
                        <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend class="title_tarifa">Tarifa</legend>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="automovil_cliente_editar">Valor de Tarifa</label>
                                    <input class="form-control" type="number" id="cliente_auto2">
                                </div>
                                <!--<div class="col-xs-3">
                                    <label class="obligatorio" for="minivan_cliente_editar">Cliente VAN</label>
                                    <input class="form-control" type="number" id="cliente_van">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="van_cliente_editar">Proveedor AUTO</label>
                                    <input class="form-control" type="number" id="proveedor_auto">
                                </div>
                                <div class="col-xs-3">
                                    <label class="obligatorio" for="bus_cliente_editar">Proveedor VAN</label>
                                    <input class="form-control" type="number" id="proveedor_van">
                                </div>-->
                                

                            </div>
                        </fieldset>

                    </div>
                    <div class="col-lg-12" style="margin-top: 25px">
                        <p id="mensaje" style="font-size: 15px;">Se actualizará solo para este cliente</p>
                        <label class="switch" data-sw="1">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="col-lg-6 hidden tabla_clientes">
                        <table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                             <thead>
                               <tr>
                                <td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_all" type="checkbox" check="false"></center></td>
                                 <td style="text-align: center;">Nombre del Cliente</td>
                               </tr>
                             </thead>
                             <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td><center><input data-id="{{$cliente->id}}" style="width: 15px; height: 15px;" type="checkbox" class="clients" check="false"></center></td>
                                        <td>{{$cliente->razonsocial}}</td>
                                    </tr>
                                @endforeach
                             </tbody>
                           </table>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button id="actualizar_tarifas" class="btn btn-success btn-icon">
                    ACTUALIZAR<i class="fa fa-floppy-o icon-btn"></i>
                </button>
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="modalAñadir" class="modal fade">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">Añadir Tarifa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-4">
                        <label class="obligatorio" for="nombre_editar">Nombre de Trayecto</label>
                        <input class="form-control" disabled type="text" id="nombre_editar3">
                    </div>
                    
                    <div class="col-xs-12">
                        <fieldset style="margin-top: 10px; margin-bottom: 5px;"><legend class="title_tarifa">Tarifa</legend>
                            <div class="row">
                                <div class="col-xs-2">
                                    <label class="obligatorio" for="automovil_cliente_editar">Valor de Tarifa</label>
                                    <input class="form-control" type="number" id="cliente_auto3">
                                </div>

                            </div>
                        </fieldset>

                    </div>
                    <div class="col-lg-12" style="margin-top: 25px">
                        <p id="mensaje" style="font-size: 15px;">Se añadirá sólo para este cliente</p>
                    </div>
                    <div class="col-lg-6 hidden tabla_clientes">
                        <table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                             <thead>
                               <tr>
                                <td style="text-align: center;">Check All <br><center><input style="width: 15px; height: 15px;" class="select_all" type="checkbox" check="false"></center></td>
                                 <td style="text-align: center;">Nombre del Cliente</td>
                               </tr>
                             </thead>
                             <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td><center><input data-id="{{$cliente->id}}" style="width: 15px; height: 15px;" type="checkbox" class="clients" check="false"></center></td>
                                        <td>{{$cliente->razonsocial}}</td>
                                    </tr>
                                @endforeach
                             </tbody>
                           </table>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button id="añadir_tarifas" class="btn btn-success btn-icon">
                    AÑADIR<i class="fa fa-floppy-o icon-btn"></i>
                </button>
                <a data-dismiss="modal" id="limpiar" class="btn btn-danger btn-icon">Cerrar<i class="fa fa-close icon-btn"></i></a>
            </div>

        </div><!-- /.modal-content -->
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
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
<script src="{{url('jquery/tarifastraslados.js')}}"></script>
<script type="text/javascript">

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();

    //$('#examples').on('click', '.editar_trayecto', function(event) {
    $('.editar_trayecto').click(function(){

        $('#actualizar_trayecto').attr('data-id',$(this).attr('id'));

        $('#nombre_editar').val($(this).attr('data-nombre'))
        $('#shortModal2').modal('show');

    });

    $('.unificar').click(function(){

        $('#actualizar_trayecto').attr('data-id',$(this).attr('id'));

        $.ajax({
          url: '../tarifastraslados/consultarclientestarifa',
          method: 'post',
          data: {}
        }).done(function(data){

          if(data.respuesta==true){
            
            for(var e in data.clientes){
                $clientes_tarifa.row.add([
                    '<input style="width: 15px; height: 15px;" data-id="'+data.clientes[e].id_centro+'" class="select_todos" type="checkbox" check="false">',
                    data.clientes[e].razonsocial
                ]).draw();
            }

            $('#nombre_editar').val($(this).attr('data-nombre'))
            $('#unificar').modal('show');

          }else if(data.respuesta==false){

          }

        });

    });

    $('#actualizar_tarifas').click(function(e) {

        var sw = $('.switch').attr('data-sw');
        var cliente = $(this).attr('data-cliente')
        var centro = $(this).attr('data-centro')

        if(sw==1){
            
            var valor = $('#cliente_auto2').val();
            var id = $(this).attr('data-id');
            //alert(valor+' , '+id)

            $.ajax({
              url: '../tarifastraslados/actualizartarifaindividualproveedor',
              method: 'post',
              data: {id: id, valor: valor}
            }).done(function(data){

              if(data.respuesta=='igual'){
                alert('¡No has modificado el valor de la tarifa! Intenta modificando el valor...')
              }else if(data.respuesta==true){
                alert('¡Tarifa Actualizada para el cliente '+cliente+'!')
                location.reload();
              }else if(data.respuesta==false){

              }

            });

        }else if(sw==2){
            
            var valor = $('#cliente_auto2').val();

            var fecha_pago_real = $('#fecha_pago_real').val();
            var idArray = [];

            var id_trayecto = $(this).attr('data-trayecto');

            e.preventDefault();
            $('#clientes_fuec tbody tr').each(function(index){

              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 0:
                          var $objeto = $(this).find('.clients');
                          
                          if ($objeto.is(':checked')) {
                              idArray.push($objeto.attr('data-id'));
                          }

                      break;
                  }
              });
            });

            $.ajax({
              url: '../tarifastraslados/actualizartrayectomasivo',
              method: 'post',
              data: {id_trayecto: id_trayecto, idArray: idArray, valor: valor, centro: centro, cliente_auto: valor}
            }).done(function(data){

              if(data.respuesta==true){
                alert('¡Tarifas Actualizadas!')
                location.reload();
              }else if(data.respuesta==false){

              }

            });
        }

    });

    $('#añadir_tarifas').click(function(e) {

        //var sw = $('.switch').attr('data-sw');
        var cliente = $(this).attr('data-cliente')
        var centro = $(this).attr('data-centro')
        var id_trayecto = $(this).attr('data-trayecto')
            
        var valor = $('#cliente_auto3').val();
        
        console.log(centro)

        if(centro==97) {

            $.ajax({
              url: '../tarifastraslados/anadirtarifaindividualaotour',
              method: 'post',
              data: {id_trayecto: id_trayecto, centro: centro, valor: valor}
            }).done(function(data){

              if(data.respuesta=='igual'){
                alert('¡No has modificado el valor de la tarifa! Intenta modificando el valor...')
              }else if(data.respuesta==true){

                var comple = '';

                if(data.centrodecosto_id==97) {
                    comple = 'Se añadió también a los clientes con tarifa AOTOUR'
                }
                alert('¡Tarifa Añadida!<br><br>'+comple);
                location.reload();
              }else if(data.respuesta==false){

              }

            });

        }else{

            console.log(centro+' , '+id_trayecto+' , '+valor)

            $.ajax({
              url: '../tarifastraslados/anadirtarifaindividual',
              method: 'post',
              data: {id_trayecto: id_trayecto, centro: centro, valor: valor}
            }).done(function(data){

              if(data.respuesta=='igual'){
                alert('¡No has modificado el valor de la tarifa! Intenta modificando el valor...')
              }else if(data.respuesta==true){
                alert('¡Tarifa Añadida!');
                location.reload();
              }else if(data.respuesta==false){

              }

            });

        }

    });

    $('#actualizar_trayecto').click(function(){

        var id_trayecto = $(this).attr('data-id');

        var clientes = $('#clientes_editar').val();
        var cliente_auto = $('#cliente_auto').val();
        var cliente_van = $('#cliente_van').val();
        var proveedor_auto = $('#proveedor_auto').val();
        var proveedor_van = $('#proveedor_van').val();

        console.log(id_trayecto)

        console.log(clientes)
        console.log(cliente_auto)
        console.log(cliente_van)
        console.log(proveedor_auto)
        console.log(proveedor_van)

        $.ajax({
          url: '../tarifastraslados/actualizartrayecto',
          method: 'post',
          data: {id_trayecto: id_trayecto, clientes: clientes, cliente_auto: cliente_auto, cliente_van: cliente_van, proveedor_auto: proveedor_auto, proveedor_van: proveedor_van}
        }).done(function(data){

          if(data.respuesta==true){
            alert('¡Tarifas Actualizadas!')
            location.reload();
          }else if(data.respuesta==false){

          }

        });

    });

    $('#aumentar_porcentaje').click(function(e){

        var valor = $('#nombre_aumentar').val();

        if(valor=='') {
            alert('El campo con el valor del porcentaje está vacío...')
        }else{

            var idArray = [];

            var id_trayecto = $(this).attr('data-trayecto');

            e.preventDefault();
            $('#clientes_fuecs tbody tr').each(function(index){

              $(this).children("td").each(function (index2){
                  switch (index2){
                      case 0:
                          var $objeto = $(this).find('.clientss');
                          
                          if ($objeto.is(':checked')) {
                              idArray.push($objeto.attr('data-id'));
                          }

                      break;
                  }
              });
            });

            //console.log(idArray)

            $.ajax({
              url: '../tarifastraslados/aumentarporcentaje',
              method: 'post',
              data: {valor: valor, idArray: idArray}
            }).done(function(data){

              if(data.respuesta==true){
                alert('¡Aumento realizado!')
                $('#nombre_aumentar').val('');
                $('#clientes_fuecs tbody tr').each(function(index){

                  $(this).children("td").each(function (index2){
                      switch (index2){
                          case 0:
                              var $objeto = $(this).find('.clientss');
                              
                              if ($objeto.is(':checked')) {
                                  $objeto.prop('checked', false)
                              }

                          break;
                      }
                  });
                });
                //location.reload();
              }else if(data.respuesta==false){

              }

            });

        }

    });

    $('#unificar_tarifa').click(function(e){

        var idArray = [];

        var id_trayecto = $(this).attr('data-trayecto');

        e.preventDefault();
        $('#clientes_tarifa tbody tr').each(function(index){

          $(this).children("td").each(function (index2){
              switch (index2){
                  case 0:
                      var $objeto = $(this).find('.select_todos');
                      
                      if ($objeto.is(':checked')) {
                          idArray.push($objeto.attr('data-id'));
                      }

                  break;
              }
          });
        });

        console.log(idArray)

        $.ajax({
          url: '../tarifastraslados/unirclienteproveedor',
          method: 'post',
          data: {idArray: idArray}
        }).done(function(data){

          if(data.respuesta==true){
            
            alert('Se ha unificado la tarifa de este cliente con tarifa AOTOUR')
            location.reload();
          }else if(data.respuesta==false){

          }

        });

        

    });

    $('.editar_tarifas').click(function() {

        var id = $(this).attr('data-id');
        var razonsocial = $(this).attr('data-razonsocial');
        var id_trayecto = $(this).attr('data-trayecto');
        var data_centro = $(this).attr('data-centro');
        //alert(id);

        $('.title_tarifa').html('Tarifa - <b>'+razonsocial+'</b>')
        $('#nombre_editar2').val($(this).attr('data-nombre'))
        $('#cliente_auto2').val($(this).attr('data-valor'))
        $('#actualizar_tarifas').attr('data-id',id);
        $('#actualizar_tarifas').attr('data-cliente',razonsocial);
        $('#actualizar_tarifas').attr('data-trayecto',id_trayecto);
        $('#actualizar_tarifas').attr('data-centro',data_centro);
        
        $('#shortModal22').modal('show');


    });

    $('.añadir_tarifas').click(function() {

        //var id = $(this).attr('data-id');
        var razonsocial = $(this).attr('data-razonsocial');
        var id_trayecto = $(this).attr('data-trayecto');
        var data_centro = $(this).attr('data-centro');

        $('.title_tarifa').html('Tarifa - <b>'+razonsocial+'</b>')
        $('#nombre_editar3').val($(this).attr('data-nombre'))
        $('#cliente_auto3').val($(this).attr('data-valor'))
        //$('#actualizar_tarifas').attr('data-id',id);
        $('#añadir_tarifas').attr('data-cliente',razonsocial);
        $('#añadir_tarifas').attr('data-trayecto',id_trayecto);
        $('#añadir_tarifas').attr('data-centro',data_centro);
        
        $('#modalAñadir').modal('show');


    });

    $('.switch').change(function() {

        var sw = $(this).attr('data-sw');

        if(sw==1){
            $(this).attr('data-sw',2);
        }else if(sw==2){
            $(this).attr('data-sw',1);
        }

        if( $(this).attr('data-sw') == 2 ){
            $('#mensaje').html('Se actualizará para varios clientes').attr('style="color: red; font-size: 15px')
            $('.tabla_clientes').removeClass('hidden');
        }else{
            $('#mensaje').html('Se actualizará solo para este cliente').attr('style="color: red; font-size: 15px')
            $('.tabla_clientes').addClass('hidden');
        }

    });

    $('.select_all').change(function(e){
        if ($(this).is(':checked')) {
            $('#clientes_fuec tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:
                            
                            //$(this).closest('tr').find('input[type="text"], select, textarea').removeAttr('disabled');
                            $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);

                        break;
                    }
                });
            });
        }else if(!$(this).is(':checked')){
            $('#clientes_fuec tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:
                            
                            //$(this).closest('tr').find('input[type="text"], select, textarea').attr('disabled','disabled');
                            $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);
                            
                        break;
                    }
                });
            });
        }
    });

    $('.select_alls').change(function(e){
        if ($(this).is(':checked')) {
            $('#clientes_fuecs tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:
                            
                            //$(this).closest('tr').find('input[type="text"], select, textarea').removeAttr('disabled');
                            $(this).find('input[type="checkbox"]').prop('checked',true).attr('check',true);

                        break;
                    }
                });
            });
        }else if(!$(this).is(':checked')){
            $('#clientes_fuecs tbody tr').each(function(index){
                $(this).children("td").each(function (index2){
                    switch (index2){
                        case 0:
                            
                            //$(this).closest('tr').find('input[type="text"], select, textarea').attr('disabled','disabled');
                            $(this).find('input[type="checkbox"]').prop('checked',false).attr('check',false);
                            
                        break;
                    }
                });
            });
        }
    });

    $('#guardar_ruta_individual').click(function() {

        var nombre = $('#nombre_nuevo_trayecto').val();

        $.ajax({
          url: '../tarifastraslados/nuevotrayecto',
          method: 'post',
          data: {nombre: nombre}
        }).done(function(data){

          if(data.respuesta==true){
            alert('¡Nuevo Trayecto Añadido!')
            location.reload();
          }else if(data.respuesta==false){

          }

        });

    });

    var $listado_clientes = $('#clientes_fuec').DataTable({
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
                sortDescending: ": activer pour trier la colonne par ordre d?croissant"
            }
        },
        'bAutoWidth': false ,
        "paging": false,
        'aoColumns' : [
            { 'sWidth': '2%' },
            { 'sWidth': '7%' },
        ]
    });

    var $listado_clientess = $('#clientes_fuecs').DataTable({
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
                sortDescending: ": activer pour trier la colonne par ordre d?croissant"
            }
        },
        'bAutoWidth': false ,
        "paging": false,
        'aoColumns' : [
            { 'sWidth': '2%' },
            { 'sWidth': '7%' },
        ]
    });

    $('#examples').DataTable( {
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
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
            { 'sWidth': '2%' },
        ]
    } );

    var $clientes_tarifa = $('#clientes_tarifa').DataTable( {
        paginate: false,
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
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' },
            { 'sWidth': '5%' },
        ]
    } );

</script>
</body>
</html>