<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Control de Ingreso BAQ</title>
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
          @include('talentohumano.menu_ingreso')
        </div>
      </div>      
        <h4 class="h_titulo" style="font-size: 16px">CONTROL DE INGRESO BAQ, DÍA: <?php echo date('Y-m-d') ?></h4>
        @if(!$documentos)
          @if(isset($permisos->talentohumano->control_ingreso->crear))
            @if($permisos->talentohumano->control_ingreso->crear==='on')
              <button type="button" name="button" data-toggle="modal" class="btn btn-secundary aprobar_foto" id="generar_planilla" data-id="" style="color: black" data-value="2">GENERAR PLANILLA DEL DÍA <i class="fa fa-bolt" aria-hidden="true"></i></button>
            @endif
          @endif
        @endif

        @if(isset($documentos))
          <table id="example" class="table table-bordered hover" cellspacing="0" width="100%">
            <thead>
              <tr style="background: #BBAFA2; color: white">
                <th></th>
                <th>Nombre del Empleado</th>
                <th>Observaciones</th>
                <th>Hora de Llegada AM</th>
                <th>Hora de Salida AM</th>
                <th>Hora de Llegada PM</th>
                <th>Hora de Salida PM</th>
                <th></th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                  <th></th>
                  <th>Nombre del Empleado</th>                 
                  <th>Observaciones</th>
                  <th>Hora de Llegada AM</th>
                  <th>Hora de Salida AM</th>
                  <th>Hora de Llegada PM</th>
                  <th>Hora de Salida PM</th>
                  <th></th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($documentos as $documento)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$documento->id}}" class="">
                        <td>{{$o++}}</td>                        
                        <td><h5 style="font-family: Arial; color: black">{{$documento->nombres}} {{$documento->apellidos}}</h5></td>
                        <td>
                          @if($documento->observaciones!=null)
                          <center>
                            <p>{{$documento->observaciones}}</p>
                          </center>
                          @else
                          <center>
                            @if(isset($permisos->talentohumano->control_ingreso->crear))
                              @if($permisos->talentohumano->control_ingreso->crear==='on')
                                <button id="observacion" type="button" name="button" data-toggle="modal" class="btn btn-warning observacion" data-id="{{$documento->id}}" data-nombre="{{$documento->nombres}}" >Agregar <i class="fa fa-plus" aria-hidden="true"></i></button>
                              @endif
                            @endif
                          </center>
                          @endif
                        <td>                          
                          <div class="input-group">
                              <div class="input-group date" id="datetimepicker3">
                                @if($documento->estado>=1 or ($documento->hora_salidapm!=null and $documento->hora_salidapm!='00:00'))
                                    <input type="text" class="form-control input-font hora1" disabled id="hora_llegada" data="1" autocomplete="off" style="color: orange;" value="{{$documento->hora_llegada}}">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @else
                                  <input type="text" class="form-control input-font hora1" id="hora_llegada" autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @endif                                  
                              </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                              <div class="input-group date" id="datetimepicker3">

                                @if($documento->estado!=4 and Sentry::getUser()->id_empleado===$documento->dataid and date('H:i') >= '17:31' and $permisos->talentohumano->control_ingreso->guardar_personal==='on' and ($documento->hora_llegada!=null or $documento->hora_llegada!=''))
                                  <input type="text" class="form-control input-font hora2" id="hora_salida" disabled autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @elseif($documento->estado>=2 or ($documento->hora_salidapm!=null and $documento->hora_salidapm!='00:00'))
                                  <input type="text" class="form-control input-font hora2" id="hora_salida" disabled autocomplete="off" style="color: orange" value="{{$documento->hora_salida}}">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @elseif($documento->estado< 1)
                                   <input type="text" disabled class="form-control input-font hora2" id="hora_salida" autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @else
                                  <input type="text" class="form-control input-font hora2" id="hora_salida" autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @endif
                                  
                              </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                              <div class="input-group date" id="datetimepicker3">
                                @if($documento->estado===3 or ($documento->hora_salidapm!=null and $documento->hora_salidapm!='00:00'))
                                  <input type="text" class="form-control input-font hora3" id="hora_llegadapm" disabled autocomplete="off" style="color: orange" value="{{$documento->hora_llegadapm}}">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @elseif($documento->estado< 2)
                                   <input type="text" class="form-control input-font hora3" id="hora_llegadapm" autocomplete="off" disabled value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @else
                                  <input type="text" class="form-control input-font hora3" id="hora_llegadapm" autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @endif
                                  
                              </div>
                          </div>
                        </td>
                        <td>
                          <div class="input-group">
                              <div class="input-group date" id="datetimepicker3">

                                @if($documento->estado!=4 and Sentry::getUser()->id_empleado===$documento->dataid and date('H:i') >= '17:31' and $permisos->talentohumano->control_ingreso->guardar_personal==='on' and ($documento->hora_llegada!=null or $documento->hora_llegada!=''))
                                  <input type="text" disabled style="color: green; background: orange" class="form-control input-font hora4" id="hora_salidapm" autocomplete="off" value="<?php echo date('H:i'); ?>">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @elseif($documento->hora_salidapm!=null and $documento->hora_salidapm!='00:00')
                                  <input type="text" style="color: orange" class="form-control input-font hora4" id="hora_salidapm" disabled autocomplete="off" value="{{$documento->hora_salidapm}}">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @elseif($documento->estado< 3)
                                  <input type="text" class="form-control input-font hora4" id="hora_salidapm" autocomplete="off" disabled value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @else
                                  <input type="text" class="form-control input-font hora4" id="hora_salidapm" autocomplete="off" value="">
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                @endif                                  
                              </div>
                          </div>
                        </td>
                        <td> 
                        @if($documento->estado==4)
                          <button type="button" name="button" data-toggle="modal" class="btn btn-primary guardar_horas" disabled data-id="{{$documento->dataid}}" id="guardar_horas" style="color: white">GUARDAR <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                        @else
                          @if(Sentry::getUser()->id_empleado===$documento->dataid and date('H:i') >= '17:31' and $permisos->talentohumano->control_ingreso->guardar_personal==='on' and $documento->hora_llegada!=null and $documento->hora_llegada!='')
                          
                            <button type="button" name="button" data-toggle="modal" class="btn btn-primary guardar_horas" estado="3" data-id="{{$documento->dataid}}" id="guardar_horas" style="color: white">GUARDAR <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                          @elseif(isset($permisos->talentohumano->control_ingreso->crear))
                              @if($permisos->talentohumano->control_ingreso->crear==='on')
                                <button type="button" name="button" data-toggle="modal" class="btn btn-primary guardar_horas" estado="{{$documento->estado}}" data-id="{{$documento->dataid}}" id="guardar_horas" style="color: white">GUARDAR <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                              @else
                                <button type="button" name="button" data-toggle="modal" class="btn btn-primary guardar_horas" disabled data-id="{{$documento->dataid}}" id="guardar_horas" style="color: white">GUARDAR <i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                              @endif
                          @endif
                        @endif                          
                          <button data-foto-id="{{$documento->id}}" data-fecha="" data-hora="" data-novedad="" data-cliente="" class="btn btn-info seleccionartd">SELECCIONAR <i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
                                                      
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
       
    </div>


    <!-- MODAL DE OBSERVACIONES -->
    <div class="modal" tabindex="-1" role="dialog" id='modal_observaciones'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <div class="col-lg-4">
                <h5 class="modal-title">OBSERVACIONES</h5>
              </div>
              <div class="col-lg-3 col-lg-offset-5">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
              </div>
            </div>            
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-8 col-sm-12 col-xs-12 col-md-12">
                  <label class="obligatorio" for="observaciones" >Observaciones</label>
                  <textarea class="form-control input-font" type="text" id="observaciones" placeholder="INGRESA AQUÍ LAS OBSERVACIONES"></textarea>
                  <input type="text" name="id" id="idingreso" class="hidden">
              </div>              
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary guardar_cambios">GUARDAR</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
          </div>
        </div>
      </div>
    </div>
  <!-- FIN OBSERVACIONES -->

  @include('scripts.scripts')    
  
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/control.js')}}"></script>
<!--
  <script type="text/javascript">
    function pulsar(e) {
    if (e.keyCode === 13 && !e.shiftKey) {
      alert('test')
        e.preventDefault();
        $('.guardar_horas').triggerHandler('click');
        //var boton = document.getElementById("guardar_horas");
        //boton.triggerHandler('click');
    }
}
  </script>
-->
  </body>
</html>
