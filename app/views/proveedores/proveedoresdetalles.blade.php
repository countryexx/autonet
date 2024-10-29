<html>
<head>
    <meta charset="UTF-8">
    <title>Autonet | @foreach($proveedores as $proveedor){{ucwords(strtolower($proveedor->razonsocial))}}@endforeach</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
</head>
@include('scripts.styles')
<link rel="stylesheet" href="{{url('lightbox/css/lightbox.css')}}">
<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
<link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
<body>
@include('admin.menu')
<div class="col-lg-12 proveedores">
    @if(isset($proveedores))
        <div class="row">
            @foreach($proveedores as $proveedor)
              <div class="col-lg-12">
                <h3 class="h_titulo">{{($proveedor->razonsocial)}}</h3>
                @if(intval($proveedor->inactivo_total)===1)
                  <small class="text-danger">ESTE PROVEEDOR HA SIDO BLOQUEADO EN TODA LA APLICACION!</small>
                @elseif(intval($proveedor->inactivo)===1)
                  <small class="text-danger">ESTE PROVEEDOR HA SIDO BLOQUEADO PARA SU USO!</small>
                @endif
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Informacion Basica</div>
                        <div class="panel-body">
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Nit:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->nit.'-'.$proveedor->codigoverificacion}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Razon Social:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->razonsocial.' '.$proveedor->tipoempresa}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Representante Legal:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->representantelegal}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">c.c:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->cc}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Direccion:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->direccion}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Ubicacion:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->departamento.' - '.$proveedor->ciudad}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Email:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->email}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Telefono:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->telefono}}" disabled>
                            </div>
                            <div class="input-group margin_input">
                                <span class="input-group-addon" id="basic-addon1">Celular:</span>
                                <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->celular}}" disabled>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                  <div class="panel panel-default">
                      <div class="panel-heading">Contacto</div>
                      <div class="panel-body">
                          <div class="input-group margin_input">
                              <span class="input-group-addon" id="basic-addon1">Nombres:</span>
                              <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->nombre_completo}}" disabled>
                          </div>
                          <div class="input-group margin_input">
                              <span class="input-group-addon" id="basic-addon1">Cargo:</span>
                              <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->cargo}}" disabled>
                          </div>
                          <div class="input-group margin_input">
                              <span class="input-group-addon" id="basic-addon1">Email:</span>
                              <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->email_contacto}}" disabled>
                          </div>
                          <div class="input-group margin_input">
                              <span class="input-group-addon" id="basic-addon1">Telefono:</span>
                              <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->telefono_contacto}}" disabled>
                          </div>
                          <div class="input-group margin_input">
                              <span class="input-group-addon" id="basic-addon1">Celular:</span>
                              <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->celular_contacto}}" disabled>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Informacion Tributaria</div>
                    <div class="panel-body">
                        <div class="input-group margin_input">
                            <span class="input-group-addon" id="basic-addon1">Actividad Economica</span>
                            <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->actividad_economica}}" disabled>
                        </div>
                        <div class="input-group margin_input">
                            <span class="input-group-addon" id="basic-addon1">Codigo de Actividad</span>
                            <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->codigo_actividad}}" disabled>
                        </div>
                        <div class="input-group margin_input">
                            <span class="input-group-addon" id="basic-addon1">Codigo Ica</span>
                            <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->codigo_ica}}" disabled>
                        </div>
                        <div class="input-group margin_input">
                            <span class="input-group-addon" id="basic-addon1">Tarifa Ica</span>
                            <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->tarifa_ica}}" disabled>
                        </div>
                        <div class="input-group margin_input">
                            <span class="input-group-addon" id="basic-addon1">Tipo de Servicio</span>
                            <input class="form-control input-font" aria-describedby="basic-addon1" value="{{$proveedor->tipo_servicio}}" disabled>
                        </div>
                    </div>
                </div>
              </div>
            @endforeach
        </div>
    @endif
</div>
<div class="col-lg-12">
  <!--<a class="btn btn-success btn-icon margin_button" id="editar">EDITAR<i class="fa fa-pencil icon-btn"></i></a>
  <a class="btn btn-info btn-icon margin_button" id="actualizar">ACTUALIZAR<i class="fa fa-refresh icon-btn"></i></a>-->
  <div class="btn-group dropup margin_button">
      @if(isset($permisos->administrativo->proveedores->bloquear_desbloquear))
          @if($permisos->administrativo->proveedores->bloquear_desbloquear==='on')
              <button style="padding:8px" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  BLOQUEAR <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                  <li><a class="tama�o-dropdownmayus" id="mostrar_modal_uso">Bloqueo Uso <i class="fa fa-ban"></i></a></li>
                  <li><a class="tama�o-dropdownmayus" id="mostrar_modal_general">Bloqueo General <i class="fa fa-close"></i></a></li>
              </ul>
          @else
              <button style="padding:8px" type="button" class="btn btn-danger dropdown-toggle disabled" aria-haspopup="true" aria-expanded="false">
                  BLOQUEAR <span class="caret"></span>
              </button>
          @endif
      @else
          <button style="padding:8px" type="button" class="btn btn-danger dropdown-toggle disabled" aria-haspopup="true" aria-expanded="false">
              BLOQUEAR <span class="caret"></span>
          </button>
      @endif

  </div>
  <!--<a class="btn btn-redu btn-icon margin_button">ADJUNTAR DOCUMENTACION<i class="fa fa-cloud-upload icon-btn"></i></a>-->
  <div class="btn-group dropup margin_button">
      <button style="padding:8px" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          ver <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
          <!--<li><a class="tama�o-dropdownmayus" data-toggle="modal" data-target="#myModal" href="">Documentos Adjuntos <i class="fa fa-file-image-o"></i></a></li>-->
          @if($proveedor->tipo_servicio==='TRANSPORTE TERRESTRE')
          <li><a class="tama�o-dropdownmayus" href="../conductores/{{$id}}">Conductores <i class="fa fa-user"></i></a></li>
          <li><a class="tama�o-dropdownmayus" href="../vehiculos/{{$id}}">Vehiculos <i class="fa fa-bus"></i></a></li>
          @endif
      </ul>
  </div>
  <a class="btn btn-primary btn-icon margin_button" onclick="goBack()">Volver<i class="fa fa-reply icon-btn"></i></a>
</div>
<div class="bloqueo_proveedor hidden" id="container_uso">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>BLOQUEO DE USO</strong><i style="float: right; font-weight:100" class="fa fa-close cerrar_alerta"></i>
      </div>
      <div class="panel-body">
        <label class="text-justify">Esta opcion bloqueara o desbloqueara a este proveedor para la programacion de servicios, pero lo dejara activo para el proceso de revision y posterior pago.<br><br><span class="text-danger bolder">¿Que desea hacer?</span></label>
      </div>
      <div class="panel-footer">
        <button id="bloqueo_uso" data-id="{{$proveedor->id}}" type="button" name="button" class="btn btn-danger"><div style="vertical-align: super;display: inline-block;">BLOQUEAR</div> <i class="fa fa-2x fa-frown-o"></i></button>
        <button id="desbloqueo_uso" data-id="{{$proveedor->id}}" type="button" name="button" class="btn btn-success"><div style="vertical-align: super;display: inline-block;">DESBLOQUEAR</div> <i class="fa fa-2x fa-smile-o"></i></button>
      </div>
    </div>

  </div>
</div>

<div class="bloqueo_proveedor hidden" id="container_general">
  <div class="col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>BLOQUEO GENERAL</strong><i style="float: right; font-weight:100" class="fa fa-close cerrar_alerta"></i>
      </div>
      <div class="panel-body">
        <label>Esta opcion bloqueara o desbloqueara a este proveedor en todo el sistema.<br><br><span class="text-danger bolder">¿Que desea hacer?</span></label>
      </div>
      <div class="panel-footer">
        <button id="bloqueo_general" data-id="{{$proveedor->id}}" type="button" name="button" class="btn btn-danger"><div style="vertical-align: super;display: inline-block;">BLOQUEAR</div> <i class="fa fa-2x fa-frown-o"></i></button>
        <button id="desbloqueo_general" data-id="{{$proveedor->id}}" type="button" name="button" class="btn btn-success"><div style="vertical-align: super;display: inline-block;">DESBLOQUEAR</div> <i class="fa fa-2x fa-smile-o"></i></button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h4 class="modal-title" id="myModalLabel">DOCUMENTACION</h4>
            </div>
            <div class="modal-body">
                <a href="http://placehold.it/500x500" data-lightbox="roadtrip"><img src="http://placehold.it/250x250" class="img-thumbnail"></a>
                <a href="http://placehold.it/500x500" data-lightbox="roadtrip"><img src="http://placehold.it/250x250" class="img-thumbnail"></a>
                <a href="http://placehold.it/500x500" data-lightbox="roadtrip"><img src="http://placehold.it/250x250" class="img-thumbnail"></a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-icon" data-dismiss="modal">Cerrar<i class="fa fa-times icon-btn"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('lightbox/js/lightbox.min.js')}}"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
<script src="{{url('jquery/proveedores.js')}}"></script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

</script>
<script type="text/javascript">
    function goBack(){
        window.history.back();
    }

</script>
</body>
</html>
