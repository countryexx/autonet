<html>
	<head>
	    <meta charset="UTF-8">
	    <meta name="url" content="{{url('/')}}">
	    <title>Autonet | Generar PQR</title>
	    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	    @include('scripts.styles')
	    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
	    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
      <link rel="manifest" href="{{url('manifest.json')}}">	</head>
      <style media="screen">
      div.textarea{
        overflow-y: scroll;
        min-height: 230px;
        min-width: 450px;
        font-size: 14px;
      }
    </style>
	<body>
		@include('admin.menu')

		<div class="container-fluid" >
      <form id="formulariopqr">
        <div style="margin-top: 25px">
          <strong class="h_titulo" >GENERAR PQR</strong>
        </div>   
      <hr style="margin-top: 5px; margin-bottom: 2px; border-top: 1px dotted black;">
      <div class="row">  
      
          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
              <div class="panel panel-default">
                  <div class="panel-heading">Datos del Reclamante</div>
                  <div class="panel-body">
                      <div class="row">            
                        <div class='col-lg-4 col-md-3 col-sm-3 col-xs-6'>
                          <label for="fecha">Fecha de solicitud</label>
                          <div class="input-group">
                            <div class="input-group date" id='datetimepicker1'>
                                <input type='text' class="form-control input-font" id="fecha_inicial" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                          </div>
                        </div >
                        <div class='col-lg-3 col-md-2 col-sm-2 col-xs-6'>
                          <label for="tiposolicitud" class="obligatorio">Tipo Solicitud</label>
                          <select class="form-control input-font" name="tiposolicitud" id="tiposolicitud">
                              <option value="0">-</option>
                              <option value="1">Queja</option>
                              <option value="2">Reclamo</option>
                          </select>
                        </div>
                        <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
                          <label for="nombres" class="obligatorio">Nombre / Organización</label>
                          <input class="form-control input-font" type="text" name="nombres" id="nombres">
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-6">
                          <label for="ciudad" class="obligatorio">Ciudad</label>
                          <select class="form-control input-font" name="ciudad" id="ciudad">
                            <option value="0">-</option>
                            <option value="1">BARRANQUILLA</option>
                            <option value="2">BOGOTA</option>                      
                            <option value="3">CARTAGENA</option>
                            <option value="4">CALI</option>
                            <option value="5">MEDELLIN</option>
                          </select>
                        </div>
                        <div class="col-lg-3 col-md-2 col-sm-2 col-xs-4 ">
                          <label for="telefono" class="obligatorio">Teléfono</label>
                          <input class="form-control input-font" type="text" name="telefono" id="telefono">
                        </div>                        
                        <div class="col-lg-4 col-md-2 col-sm-2 col-xs-4 ">
                          <label for="telefono" class="obligatorio">Dirección</label>
                          <input class="form-control input-font" type="text" name="direccion" id="direccion">
                        </div>
                        <div class='col-lg-12 col-md-5 col-sm-5 col-xs-12'>
                          <label for="email" class="obligatorio">Correo Electrónico</label>
                          <input class="form-control" name="email" type="email" id="email">
                        </div>
                      </div>
                      <div class="row" >
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin: 15px 0 0 0">
                          <label for="descriptionserv">Descripción de la Ocurrencia</label>
                          <textarea name="info" id="info" rows="7" cols="50" class="form-control"></textarea>
                        </div>
                        

                      </div>
                     
                                        
                  </div>
              </div>
              
          </div>  
          
          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
              <div class="panel panel-default">
                  <div class="panel-heading">Descripción del Servicio (Si lo conoce)</div>
                  <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 ">
                          <label for="servicio">N° Servicio</label>
                          <input class="form-control input-font" type="text" name="servicio" id="servicio">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 ">
                          <label for="ruta">Ruta</label>
                          <input class="form-control input-font" type="text" name="ruta" id="ruta">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 ">
                          <label for="placa">Placa</label>
                          <input class="form-control input-font" type="text" name="placa" id="placa">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                          <label for="conductor">Conductor</label>
                          <input class="form-control input-font" type="text" name="conductor" id="conductor">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >                            
                          <label for="tiposerv">Tipo de Servicio</label>
                          <select class="form-control input-font" name="tiposerv" id="tiposerv">
                            <option value="0">-</option>
                            <option value="1">Ejecutivo</option>
                            <option value="2">Corporativo</option>                
                            <option value="3">Otros</option>
                          </select>            
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
                          <label for="fecha">Fecha de Ocurrencia</label>
                          <div class="input-group">
                            <div class="input-group date" id='datetimepicker1'>
                                <input type='text' class="form-control input-font" id="fecha_ocurrencia" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-6" style="margin: 15px 0 0 0">
                          <label for="info2">Descripción del Servicio</label>
                          <textarea name="info2" id="info2" rows="10" cols="50" class="form-control"></textarea>
                        </div>
                      </div>                                                                  
                  </div>
              </div>  
              
          </div>

              <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px">
                  <div class="panel panel-default">
                      <div class="panel-heading">Datos de la persona que actúa en representación del reclamante (Si es aplicable)</div>
                        <div class="panel-body">
                          <div class="row"> 
                            <div class="col-lg-12 col-md-4 col-sm-4 col-xs-6">
                              <label for="conductor">Nombres</label>
                              <input class="form-control input-font" type="text" name="nombres_r" id="nombres_r">
                            </div>
                            <div class="col-lg-12 col-md-4 col-sm-4 col-xs-6">
                              <label for="conductor">Apellidos</label>
                              <input class="form-control input-font" type="text" name="apellidos_r" id="apellidos_r">
                            </div>                                                        
                            <div class="col-lg-12 col-md-4 col-sm-4 col-xs-6">
                              <label for="conductor">Teléfono</label>
                              <input class="form-control input-font" type="text" name="telefono_r" id="telefono_r">
                            </div>
                            <div class="col-lg-12 col-md-4 col-sm-4 col-xs-6">
                              <label for="conductor">Dirección</label>
                              <input class="form-control input-font" type="text" name="direccion_r" id="direccion_r">
                            </div>     
                            <div class="col-lg-12 col-md-4 col-sm-4 col-xs-6">
                              <label for="conductor">Correo</label>
                              <input class="form-control input-font" type="text" name="correo_r" id="correo_r">
                            </div>                        
                          </div>
                      </div>
                  </div>
                  <input type="checkbox" name="aceptar_politicas" style="vertical-align: sub; float: right;">                  
                  @if ($errors->has('aceptar_politicas'))
                      <br><small class="text-danger">{{$errors->first('aceptar_politicas')}}</small>
                  @endif
                  <label style="margin-right: 5px; float: right; float: right;">Autorizo a que me puedan responder a mi correo electrónico.</label>
              </div>                              
      </div>

        <div class="modal-footer">
          <div class="col-xs-4">
            <div >
                <input id="excel_ruta" type="file" value="Subir" name="excel">
            </div>
          </div>
          <button id="enviarpqr" type="button" class="btn btn-primary btn-icon">Enviar<i class="fa fa-send icon-btn"></i></button>                
        </div>
            
      </form>
      </div>

      <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
      </div>
    <div class="guardado bg-success text-success hidden model">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul style="margin: 0;padding: 0;">
        </ul>
    </div>

	</body>





@include('scripts.scripts')


<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/conductores.js')}}"></script>


<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
<script></script>
<script language="JavaScript" type="text/JavaScript">
  function selODessel(obj){
    if(obj.checked){
        console.log("chulado")
    }else{
        //desSeleccionarTodos();
        console.log("DesChulado")
    }
  }

  function seleccionarTodos(){
    alert("Selecciono todos")
  }
  function desSeleccionarTodos(){
    alert("Desselecciono todos")
  }
  

</script>
</html>