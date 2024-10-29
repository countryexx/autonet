<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Historial de llegada BOG</title>
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
    <style>

      *{margin: 0; padding: 0;}
        .doc{
          display: flex;
          flex-flow: column wrap;
          width: 100vw;
          height: 100vh;
          justify-content: center;
          align-items: center;
          background: #333944;
        }
        .box{
          width: 300px;
          height: 300px;
          background: #CCC;
          overflow: hidden;
        }

        .box img{
          width: 100%;
          height: auto;
        }
        @supports(object-fit: cover){
            .box img{
              height: 100%;
              object-fit: cover;
              object-position: center center;
            }
        }
     

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')
    
    <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-3">
            @include('talentohumano.menu_ingreso_bog')
          </div>
        </div>
        <h3 class="h_titulo">HISTORIAL DE LLEGADA BOG</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('control/pdfbog')}}" method="get">
        
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group datef' id='datetimepicker1'>
                                <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                          <div class='input-group datef' id='datetimepicker1'>
                              <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                          <span class="input-group-addon">
                              <span class="fa fa-calendar">
                              </span>
                          </span>
                          </div>
                      </div>
                    </div>  
	                <div class="form-group">
                    <select id="empleado_search" style="width: 120px;" class="form-control input-font" name="empleados">
                        <option value="0">-</option>
                        @foreach($empleados as $empleado)
                          <option value="{{$empleado->id}}">{{$empleado->nombres}} {{$empleado->apellidos}}</option>
                        @endforeach
                    </select>
                  </div>
                    
                  <button data-option="1" id="buscar" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>
                  <button title="Sólo puedes exportar un día, lo haces seleccionando una opción en la segunda fecha y presionando este botón." type="submit"class="btn btn-warning btn-icon input-font">EXPORTAR<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>

        @if(isset($datos))
          <table id="exampleh" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr style="background: #BBAFA2; color: white">
                <th></th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Hora de Llegada</th>                    
                <th>Hora de Salida</th>
                <th>Hora de Llegada PM</th>
                <th>Hora de Salida PM</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                  <th></th>
                  <th>Empleado</th>
                  <th>Fecha</th>
                  <th>Hora de Llegada</th>                    
                  <th>Hora de Salida</th>
                  <th>Hora de Llegada PM</th>
                  <th>Hora de Salida PM</th>
                	<th>Observaciones</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($datos as $data)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$data->id}}" class="@if($data->observaciones!=null){{'info'}}@endif fila_foto">
                      <td><b>{{$o++}}</b></td>                        
                      <td><b>{{$data->nombres}} {{$data->apellidos}}</b></td>
                      <td><b>{{$data->fecha}}</b></td>
                      <td><b>{{$data->hora_llegada}}</b></td>
                      <td><b>{{$data->hora_salida}}</b></td>
                      <td><b>{{$data->hora_llegadapm}}</b></td>
                      <td><b>{{$data->hora_salidapm}}</b></td>
                      <td>
                        @if($data->observaciones!=null)
                          <b>{{$data->observaciones}}</b>
                        @else
                          <b>N/A</b>
                        @endif
                      </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>  

<!-- MODAL FOTO -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #0FAEF3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;" id="name"></h4>
        </div>
        <div class="modal-body">
          <center>
            <img style="width: 410px; height: 400px; border: white 6px solid;" id="imagen">
            </center>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              <p id="novedades_modal" style="text-align: left;"></p>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
            </div>
          </div>                    
        </div>
    </div>
  </div>
</div>
<!-- MODAL EDITAR -->
<div class="modal fade" tabindex="-1" role="dialog" id='modal_editar'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #0FAEF3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;">EDITAR INFO</h4>
        </div>
        <div class="modal-body">
          <input type="text" name="id" id="id" class="hidden">
          <div class="row">
            <div class="col-md-4">
              <span>HORA</span>
            </div>
            <div class="col-md-8">
              <input type="text" name="hora_editar" id="hora_editar" class="form-control input-font">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4">
              <span>FECHA</span>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <div class="input-group">
                        <div class='input-group date' id='datetimepicker111'>
                            <input name="fecha_editar" id="fecha_editar" style="width: 130px;" type='text' class="form-control input-font">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <span>CLIENTE</span>
            </div>
            <div class="col-md-8">
              <select class="form-control input-font" id="cliente_editar">
                <option value="1">SUTHERLAND BAQ</option>
                <option value="2">SUTEHRLAND BOG</option>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4">
              <span>NOVEDADES</span>
            </div>
            <div class="col-md-8">
              <textarea class="form-control input-font" id="novedades_editar" name="novedades_editar"></textarea>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">
              <button type="button" name="button" id="guardar_cambios" data-toggle="modal" class="btn btn-success" style="float: right;" data-foto-id="" >ACTUALIZAR <i class="fa fa-save" aria-hidden="true"></i></button>
            </div>
          </div>          
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-9">
              <p id="novedades_modal" style="text-align: left;"></p>
            </div>
            <div class="col-md-3">
              <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
            </div>
          </div>                    
        </div>
    </div>
  </div>
</div>
<br><br>
<hr style="border: 10px">

  @include('scripts.scripts')    
  
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/control.js')}}"></script>

  </body>
</html>
