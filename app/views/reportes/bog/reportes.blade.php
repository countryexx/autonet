<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Programación BOG</title>
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

    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
        <h3 class="h_titulo">PROGRAMACIÓN DE USUARIOS</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('reportes/excel')}}" method="post">
        
          <div class="col-lg-12" style="margin-bottom: 5px;">
              <div class="row">
                  <div class="form-group">
                      <div class="input-group">
                          <div class='input-group date' id='datetimepicker1'>
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
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                        </div>
                    </div>
                  </div>
                <button data-option="1" id="buscarbog" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>

                <button type="submit" title="Exportar datos de lectura Usuarios QR" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>

              </div>
          </div>
        </form>

        @if(isset($documentos))
          <table id="usuariosbog" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>ID SERVICIO</th>
                <th>CONDUCTOR</th>
                <th>PLACA</th>
                <th>FECHA</th>
                <th>HORA</th>
                <th>DETALLE</th>
                <th>USUARIO</th>
                <th>EMPLOY ID / CÉDULA</th>
                <th>DIRECCIÓN</th>
                <th>BARRIO</th>                
                <th></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>ID SERVICIO</th>
                <th>CONDUCTOR</th>
                <th>PLACA</th>
                <th>FECHA</th>
                <th>HORA</th>
                <th>DETALLE</th>
                <th>USUARIO</th>
                <th>EMPLOY ID / CÉDULA</th>
                <th>DIRECCIÓN</th>
                <th>BARRIO</th>                
                <th></th>
              </tr>
            </tfoot>
            <tbody>
                <?php
                    $btnEditaractivado = null;
                    $btnEditardesactivado = null;
                    $btnProgactivado = null;
                    $btnProgdesactivado = null;
                    $conductor = '';
                    $sw = 0;
                ?>
                @foreach($documentos as $documento)

                    @if($documento->servicio_id!=$conductor and $o!=1)
                      <?php 
                      if($o>1){
                        if($sw==1){
                          $sw=0;
                        }else if($sw==0){
                          $sw=1;
                        }
                      }                        
                       ?>
                    @endif

                    <tr id="{{$documento->id}}" class="@if($o===1 and $sw===0){{'info'}}@elseif(intval($documento->servicio_id!=$conductor and $sw===0)){{'info'}}@elseif(intval($documento->servicio_id)===$conductor and $sw===0){{'info'}}@elseif(intval($documento->servicio_id)!=$conductor and $sw===1){{'success'}}@elseif(intval($documento->servicio_id)===$conductor and $sw===1){{'success'}}@endif">
                        <td>{{$o++}}</td>                        
                        <td>{{$documento->servicio_id}}</td>
                        <td>{{$documento->nombre_completo}}</td>
                        <td>{{$documento->placa}}</td>
                        <td>{{$documento->fecha_servicio}}</td>
                        <td>{{$documento->hora_servicio}}</td>
                        <td>{{$documento->detalle_recorrido}}</td>
                        <td>{{$documento->fullname}}</td>
                        <td>{{$documento->id_usuario}}</td>
                        <td>{{$documento->address}}
                        <td>{{$documento->neighborhood}}
                        </td>
                        <td>  
                          @if($documento->status===null)
                            <span style="font-size: 15px; color: red">
                              <i class="fa fa-times" aria-hidden="true"></i></span>
                          @elseif($documento->status===1)
                            <span style="font-size: 15px; color: green">
                              <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                          @elseif($documento->status===2)
                            <span style="font-size: 15px">
                              <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                          @elseif($documento->status===3)
                            <span style="font-size: 15px; color: orange">
                              <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            </span>
                          @endif
                        </td>
                        
                    </tr>
                    <?php $conductor = $documento->servicio_id ?>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>  

    <hr style="border: 10px">

    <!-- AGREGAR MÁS COSAS -->
    @include('portalusuarios.admin.listado.pusher')

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/reportes.js')}}"></script>
  </body>
</html>
