<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Lista de Indicadores</title>
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
        <h3 class="h_titulo">Indicadores</h3>       
        <h1 class="h_titulo">LISTA TOTAL DE INDICADORES</h1>
        <a style="margin-bottom: 7px; margin: 0 0 15px 0" class="btn btn-default btn-icon" data-toggle="modal" data-target=".mymodal2">
            ADD<i class="fa fa-plus-circle icon-btn" aria-hidden="true"></i>
          </a>
        @if(isset($documentos))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Nombre Indicador</th>
                  <th>Área</th>                  
                  <th>Fecha de Creación</th>
                  <th>Resultado Deseado</th>
                  <th>Resultado Satisfactorio</th>
                  <th>Resultado Crítico</th>
                  <th>Resultado Alcanzado</th>                 
                  <th></th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Nombre Indicador</th>
                    <th>Área</th>                    
                    <th>Fecha de Creación</th>
                    <th>Resultado Deseado</th>
                    <th>Resultado Satisfactorio</th>
                  	<th>Resultado Crítico</th>
                    <th>Resultado Alcanzado</th>
                    <th></th>
                    
                </tr>
            </tfoot>
            <tbody>
                @foreach($indicadores as $indicador)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$indicador->id}}" class="success fila_foto">
                        <td>{{$o++}}</td>                        
                        <td><a target="_blank" href="{{url('gestionintegral/detallesindicador/'.$indicador->id_indicador)}}">{{$indicador->nombre}}</a></td>
                        <td>{{$indicador->area}}</td>
                        <td>{{$indicador->fecha_creacion}}</td>
                        <td>{{$indicador->resultado_deseado}}%</td>
                        <td>{{$indicador->resultado_satisfactorio}}%</td>
                        <td>{{$indicador->resultado_critico}}%</td>
                        <td>
                          RESULTADO DESEADO
                        </td>
                        <td>
                            <!--<button data-foto-id="{{$indicador->id}}" data-name="{{$indicador->nombre}}" data-hora="" data-novedad="" class="btn btn-info mostrar_foto">VER FOTO <i class="fa fa-camera" aria-hidden="true"></i></button>-->

                            <!-- SI ES ADMINISTRADOR -->
                            @if(Sentry::getUser()->id_rol===1 or Sentry::getUser()->id===4086 or Sentry::getUser()->id===508 or Sentry::getUser()->id===2199)                     
                            
                             <!-- <button type="button" name="button" data-toggle="modal" class="btn btn-danger eliminar_foto"data-foto-id="{{$indicador->id}}" >ELIMINAR <i class="fa fa-trash-o" aria-hidden="true"></i></button>-->

                            @if(Sentry::getUser()->id_rol===1)
                              <!--<button data-foto-id="{{$indicador->id}}" data-fecha="" data-hora="" data-novedad="" data-cliente="" class="btn btn-warning editar_foto">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>-->
                            @else
                             <!-- <button disabled="true" class="btn btn-warning editar_foto">EDITAR <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button> -->
                            @endif

                              
                              @if($indicador->id===1)
                                <!--<button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$indicador->id}}" >APROBADA <i class="fa fa-check-square-o" aria-hidden="true"></i></button>-->
                              @else
                                <!--<button type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$indicador->id}}" >APROBAR <i class="fa fa-check-square-o" aria-hidden="true"></i></button> -->
                              @endif

                            @else
                              <!-- CUALQUIER OTRO USUARIO -->

                              <!--<button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-danger eliminar_foto"data-foto-id="{{$indicador->id}}" >ELIMINAR <i class="fa fa-trash-o" aria-hidden="true"></i></button> -->

                              
                              @if($indicador->estado===1)
                              <!--  <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$indicador->id}}" >APROBADA <i class="fa fa-check-square-o" aria-hidden="true"></i></button> -->
                              @else
                              <!--  <button disabled="true" type="button" name="button" data-toggle="modal" class="btn btn-success aprobar_foto"data-foto-id="{{$indicador->id}}" >APROBAR <i class="fa fa-check-square-o" aria-hidden="true"></i></button> -->
                              @endif

                            @endif
                                                      
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    <!--MODAL PARA SUBIR EXCEL --> 
    <div class="modal fade mymodal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-servicios" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color: orange">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>NUEVO INDICADOR</strong>
          </div>
          <div class="modal-body tabbable">
            <div class="container-fluid" id="ex_ruta" style="padding-top: 0; overflow-y: auto; height: 430px;">
              <div class="row">
                  <div class="col-lg-4">
                    <input class="form-control input-font" type="text" id="proceso" placeholder="INGRESAR PROCESO"></input>
                  </div>
                  <div class="col-lg-4">
                    <input class="form-control input-font" type="text" id="nombre" placeholder="INGRESAR NOMBRE"></input>
                  </div>
                  <div class="col-lg-4">
                    <input class="form-control input-font" type="text" id="tipo" placeholder="ESPECIFICA EL TIPO DE INDICADOR"></input>
                  </div>
              </div>
              <div class="row" style="margin-top: 20px">
                <div class="col-lg-4">
                    <textarea class="form-control input-font" type="text" id="interpretacion_indicador" placeholder="INTERPRETACIÓN DEL INDICADOR"></textarea>
                </div>
                <div class="col-lg-3">
                  <input class="form-control input-font" type="text" id="meta_asociada" placeholder="META ASOCIADA AL INDICADOR"></input>
                </div>
                <div class="col-lg-3">
                  <input class="form-control input-font" type="text" id="valor_programado" placeholder="VALOR PROGRAMADO"></input>
                </div>
              </div>
              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <textarea class="form-control input-font" type="text" id="variable_a" placeholder="DESCRIPCIÓN VARIABLE A"></textarea>
                </div>
                <div class="col-lg-6">
                  <textarea class="form-control input-font" type="text" id="variable_b" placeholder="DESCRIPCIÓN VARIABLE B"></textarea>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="formula_indicador" placeholder="INGRESA LA FÓRMULA DE INDICADOR"></input>
                </div>
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="fuente_informacion" placeholder="INGRESA LA FUNETE DE LA INFORMACIÓN"></input>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="frecuencia" placeholder="FRECUENCIA O PERIOCIDAD"></input>
                </div>
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="unidad_medida" placeholder="UNIDAD DE MEDIDA"></input>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="tendencia" placeholder="TENDENCIA"></input>
                </div>
                <div class="col-lg-6">
                  <input class="form-control input-font" type="text" id="tipo_medicion" placeholder="TIPO DE MEDICIÓN"></input>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <textarea class="form-control input-font" type="text" id="linea_base" placeholder="LÍNEA DE BASE (corresponde a la primera evaluación del indicador)"></textarea>
                </div>
                <div class="col-lg-6">
                  <textarea class="form-control input-font" type="text" id="partes_interesadas" placeholder="PERSONAS Y/O PARTES INTERESADAS QUE DEBEN CONOCER EL RESULTADO"></textarea>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-4">
                  <input class="form-control input-font" type="number" id="resultado_deseado" placeholder="RESULTADO DESEADO"></input>
                </div>
                <div class="col-lg-4">
                  <input class="form-control input-font" type="number" id="resultado_satisfactorio" placeholder="RESULTADO SATISFACTORIO"></input>
                </div>
                <div class="col-lg-4">
                  <input class="form-control input-font" type="number" id="resultado_critico" placeholder="RESULTADO CRÍTICO"></input>
                </div>
              </div>

              <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                  <textarea class="form-control input-font" rows="5" type="text" id="analisis" placeholder="ANÁLISIS DEL INDICADOR"></textarea>
                </div>
                <div class="col-lg-6">
                  <textarea class="form-control input-font" rows="5" type="text" id="acciones_mejora" placeholder="ACCIONES DE MEJORA PLANTEADAS"></textarea>
                </div>                
              </div>

            </div>
          </div>
          <div class="modal-footer">
              <a style="float: right; margin: 0 20px 0 30px;" id="nuevo_indicador" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn" aria-hidden="true"></i></a>
              <span style="float: right; background-color: #F8FAF7; color: black;" class="hidden" id="cargando" class="btn btn-primary btn-icon">CARGANDO EL ARCHIVO<i class="fa fa-spinner fa-spin icon-btn"></i></span>
              <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">POR FAVOR, ADJUNTE UN ARCHIVO EXCEL! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
          </div>
        </div>
      </div>
    </div>   

    
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
<!--
<div class="col-lg-6 col-lg-offset-3" style="margin-top: 50px">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" style="text-align: center;">GENERAR PDF DE RUTAS</div>
				<div class="panel-body">
					<div class="col-lg-12" style="margin: 30px 0 30px 0;">
				        <h3 class="h_titulo">SELECCIONAR LA FECHA Y EL CLIENTE</h3>       
				        <form class="form-inline" action="pdf" method="get">
				        
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
					                        <option>MASTERFOOD</option>
					                        <option>SUTHERLAND BOG</option>
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
-->
  <hr>

  <!--
  <div class="col-lg-8 col-lg-offset-2" style="margin-top: 50px">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center;">GENERAR EXCEL DE CONDUCTORES</div>
        <div class="panel-body">
          <div class="col-lg-12" style="margin: 30px 0 30px 0;">
              <h3 class="h_titulo">SELECCIONAR FECHA INICIAL, FECHA FINAL, CIUDAD Y EL CONDUCTOR A EXPORTAR</h3>
              <form class="form-inline" action="excel" method="get">
                
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
                    <select id="conductor_search2" style="width: 120px;" class="form-control input-font" name="conductores2">
                        <option value="0">-</option>
                        @foreach($conductores as $conductor)
                          <option value="{{$conductor->id}}">{{$conductor->nombre_completo}}</option>
                        @endforeach
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
    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestionintegral.js')}}"></script>

  </body>
</html>
