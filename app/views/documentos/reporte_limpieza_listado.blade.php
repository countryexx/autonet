<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Listado de Limpieza</title>
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
        <h3 class="h_titulo">REPORTE DE LIMPIEZA DE VEHÍCULOS</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/exportarreportes')}}" method="post">
        
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                    <div class="form-group">
                      <select id="conductor_search" style="width: 120px;" class="form-control input-font" name="conductores">
                          <option>-</option>
                          @foreach($conductores as $conductor)
                            <option>{{$conductor->nombre_conductor}}</option>
                          @endforeach
                      </select>
                    </div>
                    
                  <button data-option="1" id="buscarreportes" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>
                  <button data-option="1" type="submit" id="descargarpdf" class="btn btn-warning btn-icon">Descargar<i class="fa fa-file icon-btn"></i></button>     
                </div>
            </div>
        </form>

        @if(isset($datos))
          <div class="row">
            <div class="col-md-4">
              <table id="reporte_limpieza" class="table table-bordered hover tabla" cellspacing="0" width="100%">
                <thead>
                  <tr>
                      <th></th>
                      <th>Nombre del Conductor</th>
                      <th></th>
                      
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Nombre del Conductor</th>
                        <th></th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($datos as $documento)
                        <?php
                            $btnEditaractivado = null;
                            $btnEditardesactivado = null;
                            $btnProgactivado = null;
                            $btnProgdesactivado = null;
                        ?>
                        <tr id="{{$documento->id}}" class="@if($documento->conductor_id!=null){{'success'}}@endif">
                            <td>{{$o++}}</td>                        
                            <td>{{$documento->nombre_conductor}}</td>
                            <td>
                              <a href="{{url('gestiondocumental/exportarreporte/'.$documento->id)}}" class="btn btn-info btn-list-table">DESCARGAR<i class="fa fa-download" aria-hidden="true"></i>
                              </a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!--<div class="col-md-1">
              
            </div>
            <div class="col-md-6">
              <div class="containter-fluid" style="border: 1px solid black; height: 450px">
                <h1>Vista previa pdf</h1>
              </div>
            </div>
            <div class="col-md-1">
              
            </div>-->
          </div>
        @endif
    </div>

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestiondocumental.js')}}"></script>

  </body>
</html>
