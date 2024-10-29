<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Código QR</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style type="text/css">
      .pac-container { 
        z-index: 100000; 
      }
    </style>
</head>
<body>
@include('admin.menu')

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="h_titulo">Código QR</h1>

      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-4">
              <div class="panel panel-default">
                  <div class="panel-heading"><h4><b>Mis Datos</b></h4></div>
                  <div class="panel-body" style="padding: 1%">
                    @foreach($dato as $data)
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Nombres</span>
                          <input id="nombre" data="{{$data->nombres}}" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->nombres}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Apellidos</span>
                          <input id="apellido" data="{{$data->apellidos}}" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->apellidos}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Empresa:</span>
                          <input id="empresa" class="form-control input-font" aria-describedby="basic-addon1" value="{{$centro}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Cédula:</span>
                          <input id="cedula" class="form-control input-font" aria-describedby="basic-addon1" value="{{$data->cedula}}" data-user="{{$data->id}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Employ ID:</span>
                          <input id="employ_id" data="{{$data->id_employer}}" type="number" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->id_employer}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Teléfono:</span>
                          <input id="telefono" data="{{$data->telefono}}" type="number" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->telefono}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Email:</span>
                          <input id="email" class="form-control input-font" aria-describedby="basic-addon1" value="{{$data->correo}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Departamento:</span>
                          <input id="departamento" class="form-control input-font" aria-describedby="basic-addon1" value="{{$data->departamento}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Ciudad/Muncipio:</span>
                          <input id="municipio" class="form-control input-font" aria-describedby="basic-addon1" value="{{$data->municipio}}" disabled>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Dirección:</span>
                          <input id="direccion" data="{{$data->direccion}}" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->direccion}}" disabled>
                          <select class="hidden" id="direccion2">
                            <option>Seleccionar Dirección</option>
                          </select>
                      </div>
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Barrio:</span>
                          <input id="barrio" data="{{$data->barrio}}" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->barrio}}" disabled>
                      </div>
                      @if(isset($data->localidad))
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Localidad:</span>
                          <input id="localidad" data="{{$data->localidad}}" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->localidad}}" disabled>
                      </div>
                      @endif
                      @if(isset($data->area))
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Campaña:</span>
                          <input id="campaña" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->area}}" disabled>
                      </div>
                      @endif
                      @if(isset($data->subarea))
                      <div class="input-group margin_input">
                          <span class="input-group-addon" id="basic-addon1">Sub Área:</span>
                          <input class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->subarea}}" disabled>
                      </div> 
                      @endif
                      <div class="input-group margin_input">
                        <span class="input-group-addon" id="basic-addon1">ARL:</span>
                        <input id="arl" class="form-control input-font form" aria-describedby="basic-addon1" value="{{$data->arl}}" disabled>
                      </div> 
                      <button buscar-pasajero-id="{{$data->id}}" style="float: right;" class="btn btn-success habilitar_edicion">EDITAR</button>

                      <button buscar-pasajero-id="{{$data->id}}" style="float: right;" class="btn btn-success buscar_pasajeros">EDITAR 2</button>

                      <button type="button" data-toggle="modal" class="modal_google">Seleccionar en Google Maps<i class="fa fa-map-marker icon-btn" aria-hidden="true"></i></button>  

                      <button buscar-pasajero-id="{{$data->id}}" style="float: right;" class="btn btn-primary guardar_cambios hidden">Guardar Cambios</button>
                      <button buscar-pasajero-id="{{$data->id}}" style="float: left;" class="btn btn-danger cancelar hidden">Cancelar</button>
                  </div>
              </div>
              </div>
          <div class="col-lg-4 col-md-4 col-xs-4 col-md-offset-4 col-sm-offset-2">
            <form id="form" action="{{url('descargarqr')}}" method="get">
            <div class="row">
              <div class="col-md-4" style="margin-top: 100px">
                <img style="height: 300px; width: 300px margin-top: 80px" src="https://app.aotour.com.co/autonet/biblioteca_imagenes/codigosqr/{{$data->cedula}}.png"><br>
              <br>
              <center>
              <button style="margin-left: 15px;" class="btn btn-success">DESCARGAR MI CÓDIGO EN FORMATO PDF <span><i class="fa fa-download" aria-hidden="true"></i></span></button> 
              </center>
              </div>              
            </div> 
            </form> 
          </div> 
          
          <div class="col-md-4">          
          </div>          
        </div>                          
      </div>
      
    </div>
  </div>
</div>
<!--Modal Editar pasajeros-->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id='modal_pasajeros_editar' style="overflow-y: scroll;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="form_editar_pasajeros">
        <div class="modal-header" style="background: green">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Modificar mi Información</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                @include('servicios.pasajeros.inputs2')
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" style="background: green">Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Modal maps -->
<div class="modal mymodal10" id="modal_google_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="margin: 40px;">      
    <div class="modal-content">
      <div class="modal-header" style="background-color: green">
        <button type="button" class="close closer" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center> <strong style="font-family: Arial; font-size: 20px">
          <form id="form_coordenadas">
            <input  type="text" id="id_pasajero" name="id_pasajero" value="{{$data->id}}" class="hidden" />
            <input  type="text" id="latitud" name="latitud" class="hidden" />      
            <input  type="text" id="longitud" name="longitud" class="hidden"/>      
            <div class="row">
              
              <div class="col-md-5"><input type="text" name="dir" id="dir" placeholder="BUSCAR DIRECCIÓN" style="width: 100%; margin-top: 10px;" class="form-control input-font"></div>
              <div class="col-md-3">
                <button buscar-pasajero-id="{{$data->id}}" style="margin-top: 10px;" class="btn btn-danger">Guardar esta Dirección</button>
              </div>
            </div>            
          </form></strong></center>
      </div>
      @include('portalusuarios.map')
    </div>
</div>
<!-- fin modal maps -->
<!---->
@endforeach 


@include('scripts.scripts')
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

