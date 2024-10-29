<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Verificación de Fotos BAQ</title>
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
        <h3 class="h_titulo">GESTIÓN DE FOTOS DE BIOSEGURIDAD</h3>       
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
                    <select id="conductor_search" style="width: 120px;" class="form-control input-font" name="conductores">
                        <option value="0">-</option>
                        @foreach($conductores as $conductor)
                          <option value="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                  	<select data-option="1" name="cliente_search" style="width: 130px;" class="form-control input-font" id="cliente_search">
                        <option>CLIENTE</option>
                        <option>ACEROS CORTADOS</option>
                        <option>LHOIST</option>
                        <option>PIMSA</option>
                        <option>PUERTO PIMSA</option>
                        <option>QUANTICA - BILATERAL</option>
                        <option>SUTHERLAND BAQ</option>
                    </select>
	                </div> 
                    
                  <button data-option="1" id="buscar" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>
                    
                </div>
            </div>
        </form>
        <button data-option="1" id="wompi" class="btn btn-default btn-icon">Wompi<i class="fa fa-search icon-btn"></i></button>
        <button data-option="1" id="wompicard" class="btn btn-default btn-icon">Wompi Card<i class="fa fa-search icon-btn"></i></button>

        <button data-option="1" id="wompinequi" class="btn btn-default btn-icon">Wompi Nequi<i class="fa fa-search icon-btn"></i></button>

        @if(isset($documentos))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Cliente</th>
                  <th>Tipo de Ruta</th>                  
                  <th>Hora</th>
                  <th>Fecha</th>
                  <th>Placa</th>
                  <th>Novedades</th>
                  <th>Nombre conductor</th>                 
                  <th></th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Cliente</th>
                    <th>Tipo de Ruta</th>                    
                    <th>Hora</th>
                    <th>Fecha</th>
                    <th>Placa</th>
                  	<th>Novedades</th>
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
                    <tr id="{{$documento->id}}" class="@if(intval($documento->estado)===1){{'info'}}@endif fila_foto">
                        <td>{{$o++}}</td>                        
                        <td>{{$documento->cliente}}</td>
                        <td>{{$documento->tipo_ruta}}</td>
                        <td>{{$documento->hora}}</td>
                        <td>{{$documento->fecha}}</td>
                        <td>{{$documento->placa}}</td>
                        <td>{{$documento->novedadesruta}}
                        <td>{{$documento->nombre_completo}}
                        </td>
                        <td>                          
                            <button data-foto-id="{{$documento->id}}" data-name="{{$documento->nombre_completo}}" data-hora="{{$documento->hora}}" data-novedad="{{$documento->novedadesruta}}" class="btn btn-info mostrar_foto">VER FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>

                            <!-- SI ES ADMINISTRADOR -->
                            @if(Sentry::getUser()->id_rol===1 || Sentry::getUser()->id_rol===29)                     
                            
                              <button type="button" name="button" data-toggle="modal" class="btn btn-danger eliminar_foto"data-foto-id="{{$documento->id}}" >ELIMINAR <i class="fa fa-trash-o" aria-hidden="true"></i></button>

                              <button data-foto-id="{{$documento->id}}" data-fecha="{{$documento->fecha}}" data-hora="{{$documento->hora}}" data-novedad="{{$documento->novedadesruta}}" data-cliente="{{$documento->cliente}}" class="btn btn-warning editar_foto">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                              
                              @if($documento->estado===1)
                                <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$documento->id}}" >APROBADA <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                              @else
                                <button type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$documento->id}}" >APROBAR <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                              @endif                              

                            @else
                              <!-- CUALQUIER OTRO USUARIO -->

                              <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-danger eliminar_foto"data-foto-id="{{$documento->id}}" >ELIMINAR <i class="fa fa-trash-o" aria-hidden="true"></i></button>

                              <button disabled="true" class="btn btn-warning editar_foto">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                              
                              @if($documento->estado===1)
                                <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$documento->id}}" >APROBADA <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                              @else
                                <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$documento->id}}" >APROBAR <i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                              @endif

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

<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" style="text-align: center;">GENERAR PDF FOTOS</div>
				<div class="panel-body">
					<div class="col-lg-12" style="margin: 30px 0 30px 0;">
				        <h3 class="h_titulo">SELECCIONAR LA FECHA Y EL CLIENTE</h3>       				        
                <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/exportarpdf')}}" method="post">
				        
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
				                     
				                    <div class="form-group">
				                    	<select data-option="1" name="cliente" style="width: 200px;" class="form-control input-font" id="cliente">
					                        <option>CLIENTE</option>
					                        <option>ACEROS CORTADOS</option>
					                        <option>LHOIST</option>
					                        <option>PIMSA</option>
					                        <option>PUERTO PIMSA</option>
					                        <option>QUANTICA - BILATERAL</option>
					                        <option>SUTHERLAND BAQ</option>
					                    </select>
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

  <!-- PRUEBA EXPORTAR -->
@if(Sentry::getUser()->id==2 and 1>2)
  <form class="form-inline" action="pdf2" method="get">
        <button type="submit" style="margin-left: 20px" class="btn btn-primary btn-icon input-font">PDF PRUEBA<i class="fa fa-file-pdf-o icon-btn" aria-hidden="true"></i></button>
      </form>

      <a href="{{'exportarreporte'}}" class="btn btn-info btn-list-table">
            DESCARGAR
            <i class="fa fa-download" aria-hidden="true"></i>
        </a> 
  <!-- PRUEBA EXPORTAR PDF -->
  @endif


  <!--
  <hr>
  <div class="col-lg-8 col-lg-offset-2" style="margin-top: 50px">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center;">GENERAR EXCEL DE CONDUCTORES</div>
        <div class="panel-body">
          <div class="col-lg-12" style="margin: 30px 0 30px 0;">
                <h3 class="h_titulo">SELECCIONAR FECHA INICIAL, FECHA FINAL, CIUDAD Y EL CONDUCTOR A EXPORTAR</h3>
                <form class="form-inline" action="gestiondocumental/excel" method="get">
                
                    <div class="col-lg-12" style="margin-bottom: 5px">
                        <div class="row">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="fecha_inicial_excel" style="width: 120px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
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
                                        <input name="fecha_final_excel" style="width: 120px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                             
                            <div class="form-group">
                      <select data-option="1" name="ciudad" style="width: 160px;" class="form-control input-font" id="ciudad_search2">
                          <option value="0">CIUDAD CONDUCTOR</option>
                          <option value="1">BARRANQUILLA</option>
                          <option value="2">BOGOTA</option>
                          <option value="3">CARTAGENA</option>
                      </select>
                  </div>   
                  <div class="form-group">
                      <select disabled id="conductor_search2" style="width: 120px;" class="form-control input-font" name="conductores2">
                          <option value="0">-</option>
                      </select>
                  </div>  
                                                                                             
                            <button type="submit" style="margin-left: 20px" class="btn btn-success btn-icon input-font">DESCARGAR EXCEL<i class="fa fa-file-excel-o icon-btn" aria-hidden="true"></i></button>                   
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>  
-->

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

    <script type="text/javascript">
      
      $('#wompinequi').click(function(e){

      $.ajax({
        url: 'wompinequi',
        method: 'post',
        data: {foto_id: 123}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });
   
    });

    </script>

  </body>
</html>
