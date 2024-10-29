<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Getión de Documentos</title>
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
        <h3 class="h_titulo">GESTIÓN DE DOCUMENTOS | {{$cliente}}</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">
        
            <div class="col-lg-12" style="margin-bottom: 5px">
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
	                <div class="form-group">
                        <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                    </div>
                    
                    <button data-option="1" id="buscarfotos" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                    
                </div>
            </div>
        </form>

        @if(isset($documentos))
          <table id="example2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Tipo de Ruta</th>                  
                  <th>Hora</th>
                  <th>Fecha</th>
                  <th>Nombre Documento</th>
                  <th>Placa</th>
                  <th>Nombre conductor</th>                 
                  <th></th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Tipo de Ruta</th>                    
                    <th>Hora</th>
                    <th>Fecha</th>
                    <th>Nombre Documento</th>
                    <th>Placa</th>
                    <th>Nombre conductor</th>
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
                    <tr id="{{$documento->id}}" class="fila_foto">
                        <td>{{$o++}}</td>                        
                        <td>{{$documento->tipo_ruta}}</td>
                        <td>{{$documento->hora}}</td>
                        <td>{{$documento->fecha}}</td>
                        <td>{{$documento->nombre_documento}}</td>
                        <td>{{$documento->placa}}</td>
                        <td>{{$documento->nombre_completo}}
                        </td>
                        <td>                          
                            <button data-foto-id="{{$documento->id}}" class="btn btn-info mostrar_foto">VER FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>  

    
<div class="modal fade" tabindex="-1" role="dialog" id='modal_img'>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header" style="background: #0FAEF3">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align: center;">Foto</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12" align="center">
              <img style="width: 410px; height: 350px" id="imagen">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
        </div>
    </div>
  </div>
</div>

<br><br>
<hr style="border: 10px">

<div class="col-lg-4 col-lg-offset-4" style="margin-top: 50px">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" style="text-align: center;">GENERAR PDF DE RUTAS</div>
				<div class="panel-body">
					<div class="col-lg-12" style="margin: 30px 0 30px 0;">
				        <h3 class="h_titulo">SELECCIONAR LA FECHA</h3>       
				        <form class="form-inline" action="pdffotos" method="get">
				        
				            <div class="col-lg-12" style="margin-bottom: 5px">
				                <div class="row">
				                    <div class="form-group">
				                        <div class="input-group">
				                            <div class='input-group date' id='datetimepicker1'>
				                                <input name="fecha_pdf" style="width: 120px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
				                                <span class="input-group-addon">
				                                    <span class="fa fa-calendar">
				                                    </span>
				                                </span>
				                            </div>
				                        </div>
				                    </div>
				                      <button type="submit" style="margin-left: 20px" class="btn btn-warning btn-icon input-font">DESCARGAR PDF DE RUTAS<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>                            
				                </div>
				            </div>
				        </form>
				    </div>
				</div>
			</div>
		</div>
	</div>
  <hr>


<!--
<div class="col-md-12" style="margin: 30px 0 30px 0;">
	<form action="gestiondocumental/pdf" method="get">
		<button style="float: right;" type="submit" class="btn btn-success btn-icon input-font">DESCARGAR PDF <i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>
	</form>
</div>
-->

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
