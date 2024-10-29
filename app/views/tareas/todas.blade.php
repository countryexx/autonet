<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">

    <title>Autonet | Tareas Usuarios</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

    <style>

      body {
        background-color: lightgray;
      }

      table{
          empty-cells:hide;
      }

    #list1 .form-control {
      border-color: transparent;
    }
    #list1 .form-control:focus {
      border-color: transparent;
      box-shadow: none;
    }
    #list1 .select-input.form-control[readonly]:not([disabled]) {
      background-color: #fbfbfb;
    }
    
    .avatar {
      vertical-align: middle;
      width: 30px;
      height: 30px;
      border-radius: 50%;
    }

    </style>
  </head>
  <body>
    @include('admin.menu')

    <div class="row" style="margin-left: 3px">
      <h1 class="h3 text-left mt-3 mb-4 pb-3" style="margin-left: 16px">Tareas</h1>
      <div class="col-lg-1">

          <div class="input-group" id="datetime_fecha">
              <label class="h5 text-center mt-3 mb-4 pb-3">Fecha Inicial</label>
              <div class='input-group date' id='datetime_fecha'>
                  <input id="fecha_filtro" name="fecha_pago" style="width: 80px;" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
          </div>
        
      </div>
      <div class="col-lg-1">
        <div class="input-group" id="datetime_fecha">
            <label class="h5 text-center mt-3 mb-4 pb-3">Fecha Final</label>
            <div class='input-group date' id='datetime_fecha'>
                <input id="fecha_filtro2" name="fecha_pago" style="width: 80px;" type='text' class="form-control input-font" placeholder="Fecha" value="{{date('Y-m-d')}}">
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
        </div>
      </div>
      <div class="col-lg-1">
        <div class="input-group">
          <label class="h5 text-center mt-3 mb-4 pb-3">Estado</label><br>
          <select id="estado" style="width: 100%;" class="form-control input-font" name="centrodecosto">
            <option value="0">En proceso</option>
            <option value="1">Terminadas</option>
          </select>
        </div>
      </div>
      <div class="col-lg-2">
        <label class="h5 text-center mt-3 mb-4 pb-3">Usuario</label><br>
        <div class="input-group" id="datetime_fecha" style="width: 100%">
          
          <select style="width: 100%" data-option="1" name="proveedores" class="form-control selectpicker" multiple data-live-search="true" id="select_usuarios">
          @foreach($users as $user)
            <option value="{{$user->id}}">{{ $user->nombres.' '.$user->apellidos }}</option>
          @endforeach
          </select>
        </div>
      </div>

      <div class="col-lg-1">
        <div class="input-group" id="datetime_fecha">
            <label class="h5 text-center mt-3 mb-4 pb-3">Filtro</label><br>
            <button title="" data-option="1" id="compartido_con" class="btn btn-default btn-icon buscar_fecha ">Buscar<i class="fa fa-search icon-btn"></i></button>
        </div>
      </div>

    </div>

    <div class="row">
      <div class="col-lg-12">
        
        <section class="" style="width: 98%;">
          <div style="margin-left: 30px;">
            <div class="row d-flex justify-content-center align-items-center h-50 actividades_hoy">
              <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                  <div class="card-body py-4 px-4 px-md-5">

                    <hr class="my-4">

                    <center>
                      
                    <div style="margin-top: 20px;" class="fechas hidden">
                      <span class="date_activity h4 text-center mt-3 mb-4 pb-3"><b>{{date('Y-m-d')}}</b></span>
                      <span class="h4 text-center mt-3 mb-4 pb-3"><b>-</b></span>
                      <span class="date_activity2 h4 text-center mt-3 mb-4 pb-3"><b>{{date('Y-m-d')}}</b></span>
                    </div>
                    </center>

                    <table id="example_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Opciones</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Compartido con</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estados </td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $o = 1; ?>
                        @if(isset($actividades))
                        @foreach($actividades as $actividad)
                          <tr>
                            <th>
                              <center>
                                <b>
                                {{$o}}
                                </b>
                                @if($actividad->estado==null)
                                  <i class="fa fa-spinner" style="color: orange; font-size: 15px" aria-hidden="true"></i> 
                                @else
                                  <i class="fa fa-check" style="color: green; font-size: 25px" aria-hidden="true"></i> 
                                @endif
                              </center>
                            </th>
                            <th><center>{{$actividad->fecha}}</center></th>
                            <th>
                              <span class="h5 text-center mt-3 mb-4 pb-3">{{$actividad->nombre}}</span>
                              

                            @if($actividad->nombres!=null)<br><b style="font-size: 10px; color: gray;">({{$actividad->nombres. ' '.$actividad->apellidos}})</b>@endif

                              @if($actividad->asignado_por!=null)
                                <br>
                                <span style="color: orange">Asignada por: {{$actividad->first_name.' '.$actividad->last_name}}</span>
                              @endif
                          </th>
                            <th>

                              <center>
                                <a data-id="{{$actividad->id}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-primary btn-list-table compartir_tarea @if($actividad->estado==1){{'disabled'}}@endif" aria-haspopup="true" title="Compartir Tarea" aria-expanded="true"><i class="fa fa-share" aria-hidden="true" style="font-size: 16px;"></i>
                              </a>

                              <!--<a data-id="{{$actividad->id}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-warning btn-list-table adjuntar_soporte @if($actividad->estado==1){{'disabled'}}@endif" aria-haspopup="true" title="Adjuntar Soporte" aria-expanded="true"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 16px;"></i>
                              </a>-->

                              <a href="{{url('tareas/task/'.$actividad->id)}}" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-default btn-list-table" aria-haspopup="true" title="Ver Tarea" aria-expanded="true"><i class="fa fa-eye ver_tarea" aria-hidden="true" style="font-size: 16px;"></i>
                              </a>

                              @if($actividad->estado == null)
                                <a data-id="{{$actividad->id}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success btn-list-table cerrar_tarea" title="Cerrar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 16px;"></i>
                                </a>
                              @else

                                <a data-id="{{$actividad->id}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-info btn-list-table activar_tarea" title="Reactivar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-repeat" aria-hidden="true" style="font-size: 16px;"></i>
                              </a>
                              @endif

                            </center>

                            </th>
                            <th>
                              <center>
                              @if($actividad->implicados!=null)

                              <?php
                                $consulta =  DB::table('empleados')
                                ->whereIn('id',[$actividad->implicados])
                                ->get();

                                $usuarioss = explode(",", $actividad->implicados);

                                for ($i=0; $i <count($usuarioss) ; $i++) { 
                                  
                                  $foto = DB::table('empleados')
                                  ->where('id',$usuarioss[$i])
                                  ->pluck('foto');

                                  $nombres = DB::table('empleados')
                                  ->where('id',$usuarioss[$i])
                                  ->first();

                                  $apellidos = DB::table('empleados')
                                  ->where('id',$usuarioss[$i])
                                  ->pluck('apellidos');

                                  ?>
                                  <img src="https://app.aotour.com.co/autonet/biblioteca_imagenes/talentohumano/fotos/{{$foto}}" alt="Avatar" class="avatar" title="{{$nombres->nombres.' '.$nombres->apellidos}}">
                                  <?php

                                }
                              ?>
                              @endif
                              </center>
                            </th>
                            <th>
                              <center>
                              @if($actividad->estado==null)
                                <div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">En Proceso</div>

                              @else
                                
                                <div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Terminada</div>

                              @endif

                              @if($actividad->comentarios==null)

                                <div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Comentarios</div>

                              @else

                                <div class="estado_servicio_app" style="background: blue; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Comentarios</div>

                              @endif

                              @if($actividad->adjuntos==null)

                                <div class="estado_servicio_app" style="background: #67F6C7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Adjuntos</div>

                              @else

                                <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Adjuntos</div>

                              @endif
                              </center>
                            </th>
                          </tr>
                          <?php $o++; ?>
                        @endforeach
                        @endif
                      </tbody>
                      <tfoot>
                        <tr>
                        <tr>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">#</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Fecha</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Nombre</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Opciones</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3">Compartido con</td>
                          <td style="text-align: center;" class="h4 text-center mt-3 mb-4 pb-3"> Estados </td>
                        </tr>
                      </tfoot>
                    </table>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

    </div>

    <div class="modal fade mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-rutas" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">REGISTRO DE ACTIVIDAD</h4>
              </div>
              <div class="modal-body tabbable">
                  
                  <!--<a id="agregar_descuento" style="margin-right: 3px;" class="btn btn-info btn-icon margin">AGREGAR<i class="fa fa-plus icon-btn"></i></a>-->

                  <!--<a id="eliminar_descuento" class="btn btn-danger btn-icon">ELIMINAR<i class="fa fa-close icon-btn"></i></a>-->
                  <br>
                  <table class="table table-bordered hover descuentos" style="margin-bottom:15px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3); margin-top: 25px;">
                    <tr>
                      <td width="300">
                         <input class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="NOMBRE DE LA ACTIVIDAD" id="nombre_actividad1"></input>
                      </td>
                      <td width="300px">
                        <textarea rows="3" class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="Ingrese la descripción" id="nombre_actividad1"></textarea>
                      </td>
                      <td width="300"><select data-option="1" name="proveedores" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">
                        @foreach($users as $user)
                          <option value="{{$user->id}}">{{ $user->nombres.' '.$user->apellidos }}</option>
                        @endforeach
                          <option value="0">BETTY CARRILLO</option>
                          <option value="0">DAVID COBA DE LA CRUZ</option>
                        </select>
                      </td>
                        <!--<td>
                          
                          <center>

                            <form class="dropzone" id="my-dropzone">
                                <input type="hidden" name="id" id="id_fac">
                                <div class="dz-message" data-dz-message><span>Presiona para subir las imágenes</span></div>
                            </form>


                          </center>
                        </td>-->
                    </tr>
                  </table>
                 
              </div>
              <div class="modal-footer">
                <a class="btn btn-primary btn-icon boton_guardar" id="subir">GUARDAR<i class="fa fa-save icon-btn"></i></a>
                <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
              </div>
          </div>
      </div>
  </div>

    <!--<div class="col-lg-12">

        <h3 class="h_titulo">Siigo - Consultas</h3>
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">

        </form>
        <button data-option="1" id="tiposdecomprobante" class="btn btn-default btn-icon">Tipos de Comprobantes<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="tiposdecomprobante2" class="btn btn-default btn-icon">Tipos de Comprobantes 2<i class="fa fa-sign-in icon-btn"></i></button>

        <button data-option="1" id="consultarcliente" class="btn btn-default btn-icon">Consultar Cliente<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="listarclientes" class="btn btn-default btn-icon">Listar Clientes<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="formasdepago" class="btn btn-default btn-icon">Formas de pago<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="impuestos" class="btn btn-default btn-icon">Impuestos<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="vendedor" class="btn btn-default btn-icon">Vendedor<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarfactura" class="btn btn-default btn-icon">Factura Individual<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarfacturapdf" class="btn btn-default btn-icon">Consultar Factura PDF<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="consultarrecibo" class="btn btn-default btn-icon">CR<i class="fa fa-file-text icon-btn"></i></button>

        <button data-option="1" id="mail" class="btn btn-default btn-icon">Envío Email<i class="fa fa-file-text icon-btn"></i></button>

        


    </div>-->

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_tarea_hoy'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea h4 text-center mt-3 mb-4 pb-3">Tarea <i class="fa fa-plus" style="float: right;" aria-hidden="true"></i></b></h4>
            </div>
            <div class="modal-body">
              <center>

                <div class="row" style="width: 50%">
                  <input class="form-control input-font detalle_text h4 text-center mt-3 mb-4 pb-3" style="text-transform: uppercase;" placeholder="Ingresa el nombre" id="nombre_actividad"></input>
                  <p style="float: left; color: red;" class="limit hidden">Límite de caracteres excedido (20)*</p>
                </div>

                <div class="row" style="width: 90%; margin-top: 12px;">
                  <textarea rows="4" class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="Ingresa la descripción" id="descripcion_actividad"></textarea>
                </div>

                <div class="row" style="width: 90%; margin-top: 12px;">
                  <label class="h5 text-center mt-3 mb-4 pb-3">A quién quieres añadir como participante?</label>
                  <select data-option="1" name="proveedores" id="participantes" class="form-control input-font selectpicker" multiple data-live-search="true">
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->nombres. ' '.$user->apellidos}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="row" style="width: 90%; margin-top: 12px;">
                  <a style="width: 80%;" target="_blank" type="submit" class="btn btn-primary boton_guardar h4 text-center mt-3 mb-4 pb-3">Guardar <i class="fa fa-save" aria-hidden="true"></i></a>
                </div>

              </center>
            </div>

            <div class="modal-footer">
              <center>
                <span class="h5 text-center mt-3 mb-4 pb-3"><b>Nota:</b> Si necesitas adjuntar algún soporte, lo puedes hacer en la vista individual de la tarea.</span>
              </center>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_opciones'>
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: white">
              <h4 class="modal-title" style="text-align: center; color: black;" id="name"><b id="title" class="parpadea">Opciones</b></h4>
            </div>
            <div class="modal-body">
              <center>
                <div class="row">
                  <button style="width: 80%;" type="submit" class="btn btn-primary compartir_tarea">Compartir Tarea <i class="fa fa-share" aria-hidden="true"></i></button>
                </div>

                <div class="row" style="margin-top: 10px">
                  <button style="width: 80%;" type="submit" class="btn btn-warning adjuntar_soporte">Adjuntar Soporte <i class="fa fa-paperclip" aria-hidden="true"></i></button>
                </div>

                <div class="row" style="margin-top: 10px">
                  <a style="width: 80%;" target="_blank" type="submit" class="btn btn-info ver_tarea">Ver Tarea <i class="fa fa-comment" aria-hidden="true"></i></a>
                </div>

                <div class="row" style="margin-top: 10px">
                  <button style="width: 80%;" type="submit" class="btn btn-success cerrar_tarea">Cerrar Tarea <i class="fa fa-check" aria-hidden="true"></i></button>
                </div>
              </center>
            </div>

            <div class="modal-footer">
              

              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_nota2'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #E53935">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">ADJUNTOS</b></h4>
            </div>
            <div class="modal-body">
              <center>
                <iframe id="pdf" style="width: 550px; height: 560px;" src="{{url('biblioteca_imagenes/facturacion/siigo/E0600M5HDM.pdf')}}"></iframe>
              </center>
            </div>

            <div class="modal-footer">
              <!--<span style="float: left">Factura N° <b id="invoice" style="color: #F47321;"></b> <b style="color: #F47321;" id="valor_invoice"></b> </span>-->
              <!--<a id="guardar_soporte1" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>-->
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_asignar'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Asignar Tarea a otro usuario</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">
                <div class="col-lg-4">
                  
                  <label>Selecciona al responsable de la Tarea</label>
                  <div class="selectpicker select">
                   <select class="slct" data-live-search="true" id="asignado">
                    <option value="0">SELECCIONAR</option>
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{ $user->nombres.' '.$user->apellidos }}</option>
                    @endforeach
                   </select>
                  </div>

                </div>

                <div class="col-lg-3">
                  <label>Nombre de la Tarea</label>
                  <input class="form-control input-font detalle_text" id="nombre_tarea" style="text-transform: uppercase;" placeholder="Nombre de la Tarea" id="nombre_tarea">
                  <p style="float: left; color: red; font-family: inherit;" class="limites hidden">Límite de caracteres excedido (20)*</p>
                </div>

                <div class="col-lg-5">
                  
                  <label>Descripción de la Tarea</label>
                  <textarea rows="4" class="form-control input-font detalle_text" id="descripcion_tarea" style="text-transform: uppercase;" placeholder="Descripción"></textarea>

                </div>

              </div>

              <div class="row">
                <div class="col-lg-4 col-lg-push-8" style="margin-top: 30px;">
                  <label>A quién quieres añadir como participante?</label>
                  <select data-option="1" name="proveedores" id="participantes2" class="form-control input-font selectpicker" multiple data-live-search="true">
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->nombres. ' '.$user->apellidos}}</option>
                    @endforeach
                  </select>
                </div>
                
              </div>

            </div>

            <div class="modal-footer">
              
              <a id="guardar_asignar_tarea" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_adjuntar'>
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Adjuntar Soporte</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">

                <center>

                  <form class="dropzone" id="my-dropzone">
                      <input type="number" name="id" value="0" id="id_activity" class="id_activity">
                      <div class="dz-message" data-dz-message><span>Presiona para subir las imágenes</span></div>
                  </form>

                </center>
                
              </div>

            </div>

            <div class="modal-footer">
              
              <a id="guardar_adjunto" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id='modal_share'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="h4 text-center mt-3 mb-4 pb-3">Compartir Tarea</b></h4>
            </div>
            <div class="modal-body">
              
              <div class="row">

                <div class="col-lg-8 col-lg-push-2">

                  <label class="h4 text-center mt-3 mb-4 pb-3">A quién quieres añadir como participante?</label>
                  <select data-option="1" name="proveedores" id="participantes3" class="form-control input-font selectpicker" multiple data-live-search="true" style="width: 50%">
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->nombres. ' '.$user->apellidos}}</option>
                    @endforeach
                  </select>

                </div>
                
              </div>

            </div>

            <div class="modal-footer">
              
              <a id="guardar_share" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon h4 text-center mt-3 mb-4 pb-3">COMPARTIR<i class="fa fa-share icon-btn"></i></a>
              
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade mymodal33" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #E53935">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">ADJUNTOS</b></h4>
            </div>
            <div class="modal-body">
              <center>
                <iframe id="pdf" style="width: 550px; height: 560px;" src="{{url('biblioteca_imagenes/facturacion/siigo/E0600M5HDM.pdf')}}"></iframe>
              </center>
            </div>

            <div class="modal-footer">
              <!--<span style="float: left">Factura N° <b id="invoice" style="color: #F47321;"></b> <b style="color: #F47321;" id="valor_invoice"></b> </span>-->
              <!--<a id="guardar_soporte1" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>-->
              
            </div>
        </div>
      </div>
    </div>

    <!--<div class="col-lg-12">
      <h3 class="h_titulo">Siigo</h3>

      <button data-option="1" id="auth" class="btn btn-default btn-icon">AUTH<i class="fa fa-sign-in icon-btn"></i></button>
      <button data-option="1" id="factura" class="btn btn-default btn-icon">Crear Factura<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="recibo" class="btn btn-default btn-icon">Crear RC<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="facturadian" class="btn btn-default btn-icon">Crear Factura DIAN<i class="fa fa-file-text icon-btn"></i></button>

      <button data-option="1" id="notac" class="btn btn-default btn-icon">Nota Crédito<i class="fa fa-file-text icon-btn"></i></button>

      
    </div>-->

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="{{url('dropzonejs/dist/dropzone.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestiondocumental.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">

      $tablecuentas = $('#example_table').DataTable( {
        "order": [[ 0, "asc" ]],
        paging: false,

        language: {
          processing:     "Procesando...",
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
        'bAutoWidth': false,
        'aoColumns' : [
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
          { 'sWidth': '4%' },
          { 'sWidth': '2%' },
          { 'sWidth': '2%' },
        ],
      });

      $('.buscar_fecha').click(function(){
        
        var fecha = $('#fecha_filtro').val();
        var fecha2 = $('#fecha_filtro2').val();
        var users = $('#select_usuarios').val();
        var opcion = $('#estado').val();

        $('.fechas').removeClass('hidden')
        $('.date_activity').html('<b>'+fecha+'</b>');
        $('.date_activity2').html('<b>'+fecha2+'</b>');

        $tablecuentas.clear().draw();

        $.ajax({
          url: 'filtrardiaas',
          method: 'post',
          data: {fecha: fecha, fecha2: fecha2, users: users, opcion: opcion}
        }).done(function(data){

          if(data.respuesta==true){
            
            var cont = 1 ;

            for(i in data.actividades){

              var nomb = '';

              if(data.actividades[i].nombres!=null){
               nomb = '<br><b style="font-size: 10px; color: gray;">('+data.actividades[i].nombres+' '+data.actividades[i].apellidos+')</b>';
              }

              var botones = '<center>';

              if(data.actividades[i].estado==1){
                var classe = 'disabled';
              }

              botones += '<a data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-primary btn-list-table compartir_tarea" aria-haspopup="true" title="Compartir Tarea" aria-expanded="true"><i class="fa fa-share" aria-hidden="true" style="font-size: 16px;"></i></a>';

              //botones += '<button data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-warning btn-list-table adjuntar_soporte" aria-haspopup="true" title="Adjuntar Soporte" aria-expanded="true"><i class="fa fa-paperclip" aria-hidden="true" style="font-size: 16px;"></i></button>';

              botones += '<a href="https://app.aotour.com.co/autonet/tareas/task/'+data.actividades[i].id+'" target="_blank" style="padding: 6px 8px 6px 8px; display: inline-block; margin-right: 5px" type="button" class="btn btn-default btn-list-table" aria-haspopup="true" title="Ver Tarea" aria-expanded="true"><i class="fa fa-eye ver_tarea" aria-hidden="true" style="font-size: 16px;"></i></a>';

              if(data.actividades[i].estado!=1){

                botones += '<a data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-success btn-list-table cerrar_tarea" title="Cerrar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-check-square-o" aria-hidden="true" style="font-size: 16px;"></i></a>';

              }else{

                botones += '<a data-id="'+data.actividades[i].id+'" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-info btn-list-table activar_tarea" title="Reactivar Tarea" aria-haspopup="true" aria-expanded="true"><i class="fa fa-repeat" aria-hidden="true" style="font-size: 16px;"></i></a>';

              }
              
              botones += '</center>';

              var estado = '<center>';

              if(data.actividades[i].estado==null){
                                
                estado += '<div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">En Proceso</div>';

              }else{
                
                estado += '<div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Terminada</div>';

              }

              if(data.actividades[i].comentarios==null){

                estado += '<div class="estado_servicio_app" style="background: red; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Comentarios</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: blue; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Comentarios</div>';

              }

              if(data.actividades[i].adjuntos==null){

                estado += '<div class="estado_servicio_app" style="background: #67F6C7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Sin Adjuntos</div>';

              }else{

                estado += '<div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">Con Adjuntos</div>';

              }

              estado += '</center>';

              if(data.actividades[i].estado==null){
                var icons = '<i class="fa fa-spinner" style="color: orange; font-size: 15px" aria-hidden="true"></i> ';
              }else{
                var icons = '<i class="fa fa-check" style="color: green; font-size: 25px" aria-hidden="true"></i> ';
              }

              var asigned = '';

              if(data.actividades[i].asignado_por!=null){

                asigned += '<br>'+
                '<span style="color: orange">Asignada por: '+data.actividades[i].first_name+' '+data.actividades[i].last_name+'</span>';
              }

              $tablecuentas.row.add([
                '<center><b>'+cont+' </b>'+icons+'</center>',
                '<center><b>'+data.actividades[i].fecha+'</b></center>',
                '<b>'+data.actividades[i].nombre+'<b>'+nomb+asigned,
                botones,
                '...',
                estado,
              ]).draw();
              cont++;

            }


          }else if(data.respuesta==false){

          }

        });

      });

      function dayss(id){
        alert('pruebas')
      }

      Dropzone.options.myDropzone = {
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFilezise: 1,
        maxFiles: 4,
        addRemoveLinks: 'dictCancelUploadConfirmation ',
        url: 'tareas/ingresoimagenv2',
        init: function() {
            var submitBtn = document.querySelector("#subir");

            myDropzone = this;
            submitBtn.addEventListener("click", function(e){
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });
            this.on("addedfile", function(file) {

            });
            this.on("complete", function(file) {

            });
            myDropzone.on("success", function(file, response) {
                if(response.mensaje===true){
                    $(file.previewElement).fadeOut({
                        complete: function() {
                            // If you want to keep track internally...
                            myDropzone.removeFile(file);
                        }
                    });
                    alert(response.respuesta);
                }else if(response.mensaje===false){
                    alert(response.respuesta);
                }

            });
        }
      };

      $('.add_task').click(function(){
        //Abrir modal
        $('#modal_asignar').modal('show');
      });

      //Tipos de Comprobantes
      $('#tiposdecomprobante').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/tiposdecomprobante',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Tipos de Comprobantes 1
      $('#tiposdecomprobante2').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/tiposdecomprobante2',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Listar Clientes
      $('#consultarcliente').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/consultarcliente',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Listar Clientes
      $('#listarclientes').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/listarclientes',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            //console.log(data.response.results)
              for(i in data.response.results) {
                console.log(data.response.results[i].identification+' , '+data.response.results[i].name+' , '+data.response.results[i].person_type+' , '+data.response.results[i].id_type.code)
              }
          }else if(data.respuesta==false){

          }

        });

      });

      //Formas de Pago
      $('#formasdepago').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/formasdepago',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Impuestos
      $('#impuestos').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/impuestos',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Vendedor
      $('#vendedor').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/vendedor',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      //Autenticación

      $('.auth').click(function(e){ //Obtener access token

        $.ajax({
          url: 'siigo/auth',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#factura').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearfactura',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#recibo').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearrecibo',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#facturadian').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/crearfacturadian',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#notac').click(function(e){ //Crear factura

        $.ajax({
          url: 'siigo/notac',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfactura').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarfactura',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfacturapdf').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarfacturapdf',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarrecibo').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/consultarrecibo',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#mail').click(function(e){ //Consultar factura individual

        $.ajax({
          url: 'siigo/mail',
          method: 'post',
          data: {factura_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarfacturas').click(function(e){ //Consultar facturas

        $.ajax({
          url: 'siigo/consultarfacturas',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      $('#consultarclientes').click(function(e){ //Consultar clientes

        $.ajax({
          url: 'siigo/consultarcliente',
          method: 'post',
          data: {foto_id: 123}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

      });

      /*$('.compartido_con').click(function(){
        //alert('Compartido Con');
        console.log('prueba')

        $('#modal_nota2').modal('show');
      });*/

      $('.task').click(function(){
        //alert('Compartido Con');
        console.log('prueba')

        $('#modal_nota').modal('show');
      });

      

      /*$('#agregar_descuento').click(function(event){
      event.preventDefault();
      $elemento = '<tr>'+
                    '<td>'+
                        '<textarea rows="2" class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="NOMBRE DE LA ACTIVIDAD"></textarea>'+
                    '</td>'+
                    '<td>'+
                          '<select data-option="1" name="proveedores" class="form-control input-font selectpicker" multiple data-live-search="true" id="proveedor_search">'+
                          '<option value="0">USUARIOS</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                          '<option value="0">SAMUEL GONZALEZ</option>'+
                        '</select>'+
                    '</td>'+
                  '</tr>';
      $('.descuentos').removeClass('hidden').append($elemento);
    });*/

    /*$('#eliminar_descuento').click(function(event){

      $('.descuentos tbody tr').last().remove();
      var total_descuentos = 0;
      var totales = 0;
      var otros_descuentos = 0;

      $('.descuentos tbody tr').each(function(index) {
        if ($(this).find('.valor_descuento').val()==='') {
          descuento = 0;
        }else {
          descuento = parseInt($(this).find('.valor_descuento').val());
        }
        total_descuentos += descuento;
      });

      total = parseInt($('#totales_cuentas').attr('data-value'));
      valor_retefuente = $('.valor_retefuente').val();

      if (valor_retefuente==='') {
        valor_retefuente = 0;
      }else{
        valor_retefuente = parseInt(valor_retefuente);
      }
      var valor_prestamo = $('#prestamo1').val();
      if (valor_prestamo==='') {
        valor_prestamo = 0;
      }else{
        valor_prestamo = parseInt(valor_prestamo);
      }

      $('#otros_descuentos').val(total_descuentos);
      $('#totales_pagado').val(total-valor_retefuente-total_descuentos-valor_prestamo);

    });*/

    $('#nombre_actividad').keyup(function(e){
      var cantidad = $(this).val().length;
      console.log(cantidad);

      if(cantidad>20){
        $('.limit').removeClass('hidden');
        $('.boton_guardar').attr('disabled','disabled');
        $('.boton_guardar').addClass('disabled');
      }else{
        $('.limit').addClass('hidden');
        $('.boton_guardar').removeAttr('disabled','disabled');
        $('.boton_guardar').removeClass('disabled');
      }

    });

    $('#nombre_tarea').keyup(function(e){
      var cantidad = $(this).val().length;
      console.log(cantidad);

      if(cantidad>20){
        $('.limites').removeClass('hidden');
        $('#guardar_asignar_tarea').attr('disabled','disabled');
        $('#guardar_asignar_tarea').addClass('disabled');
      }else{
        $('.limites').addClass('hidden');
        $('#guardar_asignar_tarea').removeAttr('disabled','disabled');
        $('#guardar_asignar_tarea').removeClass('disabled');
      }

    });

    $('.boton_guardar').click(function(){

      var nombre = $('#nombre_actividad').val().toUpperCase();
      var users = $('#participantes').val();
      var descripcionTarea = $('#descripcion_actividad').val();

      console.log('users : '+users)

      if(nombre==='' || descripcionTarea===''){
        var text = '';

        if(nombre===''){
          text += '<li>El nombre de la tarea es obligatorio.<br></li>'
        }

        if(descripcionTarea===''){
          text += '<li>La descripción de la tarea es obligatoria.</li>'
        }

        $.confirm({
            title: 'Atención',
            content: text,
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      

                    }

                }
            }        
        });

      }else{

        if(users===null){

          $.confirm({
              title: 'Atención',
              content: 'No has seleccionado ninguna copia. <br><br>¿Estás seguro de no compartir tu tarea?',
              buttons: {
                  confirm: {
                      text: 'Si, Crear Tarea,',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'tareas/agregaractividad',
                          method: 'post',
                          data: {nombre: nombre, users: users, descripcionTarea: descripcionTarea, cantidad: 0}
                        }).done(function(data){

                          if(data.respuesta==true){
                            alert('¡Tarea Agregada!');
                            location.reload();
                          }else if(data.respuesta==false){

                          }

                        });

                      }

                  },
                  cancel: {
                    text: 'Volver',
                  }
              }        
          });


        }else{

          $.ajax({
            url: 'tareas/agregaractividad',
            method: 'post',
            data: {nombre: nombre, users: users, descripcionTarea: descripcionTarea}
          }).done(function(data){

            if(data.respuesta==true){
              alert('Tarea creada satisfactoriamente!')
              //location.reload();
            }else if(data.respuesta==false){

            }

          });

        }

        

      }

    });

    $('#guardar_asignar_tarea').click(function(){

      var asignado = $('#asignado').val();
      var nombreTarea = $('#nombre_tarea').val().toUpperCase();
      var descripcionTarea = $('#descripcion_tarea').val().toUpperCase();
      var participantesTarea = $('#participantes2').val();

      console.log(asignado)
      console.log(nombreTarea)
      console.log(descripcionTarea)
      console.log(participantesTarea)

      if(asignado==0 || nombreTarea==='' || descripcionTarea===''){
        var text = '';

        if(asignado==0){
          text += '<li>Selecciona al responsable de la tarea.<br></li>'
        }

        if(nombreTarea===''){
          text += '<li>El nombre de la tarea es obligatorio.<br></li>'
        }

        if(descripcionTarea===''){
          text += '<li>La descripción de la tarea es obligatoria.</li>'
        }

        $.confirm({
            title: 'Atención',
            content: text,
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-success',
                    keys: ['enter', 'shift'],
                    action: function(){

                      

                    }

                }
            }        
        });

      }else{

        if(participantesTarea==null){

          $.confirm({
              title: 'Atención',
              content: 'No has seleccionado ninguna copia. <br><br>¿Estás seguro de no compartir tu tarea?',
              buttons: {
                  confirm: {
                      text: 'Si, Crear Tarea,',
                      btnClass: 'btn-success',
                      keys: ['enter', 'shift'],
                      action: function(){

                        $.ajax({
                          url: 'asignartarea',
                          method: 'post',
                          data: {asignado: asignado, nombreTarea: nombreTarea, descripcionTarea: descripcionTarea, participantesTarea: participantesTarea, cantidad: 1}
                        }).done(function(data){

                          if(data.respuesta==true){
                            alert('¡Tarea Asignada!');
                            location.reload();
                          }else if(data.respuesta==false){

                          }

                        });

                      }

                  },
                  cancel: {
                    text: 'Volver',
                  }
              }        
          });


        }else{

          $.ajax({
            url: 'asignartarea',
            method: 'post',
            data: {asignado: asignado, nombreTarea: nombreTarea, descripcionTarea: descripcionTarea, participantesTarea: participantesTarea, cantidad: 0}
          }).done(function(data){

            if(data.respuesta==true){
              alert('¡Tarea Asignada!');
              location.reload();
            }else if(data.respuesta==false){

            }

          });

        }
        //console.log('users : '+users)

        

      }

    });

    $('.opciones').click(function(){

      var id = $(this).attr('data-id');
      
      var urlTask = 'https://app.aotour.com.co/autonet/tareas/task/'+id;

      $('.compartir_tarea').attr('data-id',id);
      $('.ver_tarea').attr('href',urlTask);
      $('.cerrar_tarea').attr('data-id',id);
      $('.adjuntar_soporte').attr('data-id',id);

      $('#modal_opciones').modal('show');
    })

    $('.tarea_hoy').click(function(){

      //var id = $(this).attr('data-id');
      
      //var urlTask = 'http://localhost/autonet/tareas/task/'+id;

      //$('.compartir_tarea').attr('data-id',id);
      //$('.ver_tarea').attr('href',urlTask);
      //$('.cerrar_tarea').attr('data-id',id);

      $('#modal_tarea_hoy').modal('show');
    })

    $('#example_table').on('click', '.activar_tarea', function(event) {

      var id = $(this).attr('data-id');

      console.log(id)

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de reactivar esta tarea?',
          buttons: {
              confirm: {
                  text: 'Si, Reactivarla.',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'activartarea',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.response==true){                       

                        $('#modal_opciones').modal('hide')

                        $.alert({
                          title: 'Realizado!',
                          content: '¡Tarea Activada!',
                        });

                        location.reload();

                      }else if(data.response==false){

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

    $('#example_table').on('click', '.cerrar_tarea', function(event) {

      var id = $(this).attr('data-id');

      console.log(id)

      $.confirm({
          title: 'Confirmación',
          content: 'Estás seguro de cerrar esta tarea?',
          buttons: {
              confirm: {
                  text: 'Si, Cerrarla.',
                  btnClass: 'btn-success',
                  keys: ['enter', 'shift'],
                  action: function(){

                    $.ajax({
                      url: 'cerrartarea',
                      method: 'post',
                      data: {id: id}
                    }).done(function(data){

                      if(data.response==true){                       

                        $('#modal_opciones').modal('hide')

                        $.alert({
                          title: 'Realizado!',
                          content: '¡Tarea cerrada!',
                        });

                        location.reload();

                      }else if(data.response==false){

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

    $('#example_table').on('click', '.adjuntar_soporte', function(event) {

      var id = $(this).attr('data-id');

      //alert(id)

      $('.id_Activity').val(id);

      $('#modal_opciones').modal('hide');
      $('#modal_adjuntar').modal('show');

    });

    $('#example_table').on('click', '.compartir_tarea', function(event) {

      var id = $(this).attr('data-id');

      //alert(id)

      //$('.id_Activity').val(id);
      $('#guardar_share').attr('data-id',id);
      $('#modal_share').modal('show');

    });

    $('#guardar_share').click(function(){

      var id = $(this).attr('data-id');

      var users = $('#participantes3').val();

      if(users===null){

        $.confirm({
            title: 'Atención',
            content: 'No has seleccionado ningún usuario...',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-warning',
                    keys: ['enter', 'shift'],
                    action: function(){

                      

                    }

                }
            }        
        });

      }else{

        $.ajax({
          url: 'sharetask',
          method: 'post',
          data: {id: id, users: users}
        }).done(function(data){

          if(data.response==true){                       

            alert('Tarea compartida!')

            location.reload();

          }else if(data.response==false){

          }

        });

      }
      //alert($(this).attr('data-id')+' , '+users);

    });

    $('#datetime_fecha, .datetime_fecha').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        icons: {
            time: 'glyphicon glyphicon-time',
            date: 'glyphicon glyphicon-calendar',
            up: 'glyphicon glyphicon-chevron-up',
            down: 'glyphicon glyphicon-chevron-down',
            previous: 'glyphicon glyphicon-chevron-left',
            next: 'glyphicon glyphicon-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'glyphicon glyphicon-trash',
            close: 'glyphicon glyphicon-remove'
        }
    });

    $('.dayss').click(function(){
      alert('pruebas')
    });

    $('.buscar_fechas').click(function(){

      var fecha = $('#fecha_filtro').val();

      console.log(fecha)
    });

    $('#guardar_adjunto').click(function(){
      alert($('.id_Activity').val())
    });

    $('input[type=file]').bootstrapFileInput();
    $('.file-inputs').bootstrapFileInput();
    </script>

  </body>
</html>
