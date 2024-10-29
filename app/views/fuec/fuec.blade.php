<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Fuec</title>
      @include('scripts.styles')
      <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
      <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
  @include('admin.menu')
  @include('fuec.breadcrumb')
  <div class="col-lg-10 col-md-10 col-sm-12">
      <h3 class="h_titulo">CREACION FUEC</h3>
      <div class="panel panel-default">
          <div class="panel-heading">Fuec</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-3">
                    <label class="obligatorio">Proveedor</label>
                    <select id="proveedor" class="form-control input-font">
                      <option value="0">-</option>
                      @foreach($proveedores as $proveedor)
                          <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-3">
                    <label class="obligatorio">Vehiculo</label>
                    <select id="vehiculo" class="form-control input-font" disabled estado="false">
                      <option value="0">-</option>
                    </select>
                    <small role="alert" class="text-danger vehiculo_alert hidden"></small>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 contrato">
                      <label for="contrato" class="obligatorio">Contrato</label>
                      <select class="form-control input-font" id="contrato" estado="false">
                        <option value="0">-</option>
                        @foreach($contratos as $contrato)
                          <option value="{{$contrato->id}}">{{$contrato->contratante.' / CONTRATO: '.$contrato->numero_contrato.' / '.$contrato->fecha_inicio.' / '.$contrato->fecha_vencimiento}}</option>
                        @endforeach
                      </select>
                      <small id="alert_contrato" class="text-danger hidden"></small>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                          <div id="conductores">
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <label>Conductor</label>
                              <select id="conductor" class="form-control input-font conductor" disabled estado="false">
                                <option value="0">-</option>
                              </select>
                              <small role="alert" class="text-danger conductor_alert hidden"></small>
                            </div>
                          </div>
                          <button disabled id="agregar_conductor" style="margin-top: 25px; margin-left: 15px;" class="btn btn-primary" type="text"><i class="fa fa-plus"></i></button>
                          <button disabled id="eliminar_conductor" style="margin-top: 25px;" class="btn btn-danger" type="text"><i class="fa fa-close"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                        <label class="obligatorio">Rutas</label>
                        <select class="form-control input-font" id="ruta_fuec">
                          <option value="0">-</option>
                          @foreach($rutas as $ruta)
                            <option value="{{$ruta->id}}">{{'ORIGEN: '.$ruta->origen.' DESTINO: '.$ruta->destino}}</option>
                          @endforeach
                        </select>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2">
                    @if(isset($permisos->administrativo->fuec->rutas_fuec))
                      @if($permisos->administrativo->fuec->rutas_fuec==='on')
                        <button id="mostrar_ruta" style="margin-top: 25px;" class="btn btn-primary">
                          <i class="fa fa-plus"></i>
                        </button>
                        <button id="editar_ruta" style="margin-top: 25px;" class="btn btn-success" disabled>
                          <i class="fa fa-pencil"></i>
                        </button>
                      @else
                        <button style="margin-top: 25px;" class="btn btn-primary disabled" disabled>
                          <i class="fa fa-plus"></i>
                        </button>
                        <button style="margin-top: 25px;" class="btn btn-success disabled" disabled>
                          <i class="fa fa-pencil"></i>
                        </button>
                      @endif
                    @else
                      <button style="margin-top: 25px;" class="btn btn-primary disabled" disabled>
                        <i class="fa fa-plus"></i>
                      </button>
                      <button style="margin-top: 25px;" class="btn btn-success disabled" disabled>
                        <i class="fa fa-pencil"></i>
                      </button>
                    @endif

                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <label for="ruta" class="obligatorio">Descripcion</label>
                  <textarea disabled rows="5" type="text" class="form-control input-font" id="descripcion_ruta" placeholder=""></textarea>
              </div>
              <!--<div class="col-lg-3">
                <label class="obligatorio" for="">Convenio</label>
                <select class="form-control input-font" id="convenio">
                  <option value="0">-</option>
                  <option value="1">SI</option>
                  <option value="2">NO</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label for="">Empresa</label>
                <input disabled class="form-control input-font" type="text" id="convenio_empresa">
              </div>-->
              <div class="col-lg-3 col-md-3 col-sm-6">
                  <label for="objeto_contrato" class="obligatorio">Objeto Contrato</label>
                  <select class="form-control input-font" id="objeto_contrato">
                      <option>-</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL</option>
                      <option>TRANSPORTE TERRESTRE DE TURISTAS</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y DE AMIGOS</option>
                      <option>TRANSPORTE TERRESTRE DE HUESPEDES</option>
                      <option>TRANSPORTE TERRESTRE DE ESTUDIANTES</option>
                      <option>TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD</option>
                      <option>TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR</option>
                      <option>TRANSPORTE TERRESTRE GRUPO ESPECIFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)</option>
                  </select>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 hidden colegio">
                <label for="objeto_contrato" class="obligatorio">Nombre del Colegio</label>
                <input type="text" class="form-control input-font" id="colegio">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6">
                <div style="display: inline-block; width: 113px; float: left; margin-right: 20px;" class="input-group">
                  <label class="obligatorio" for="fecha_inicial">Fecha inicial</label>
                    <div  class='input-group date' id='datetimepicker1'>
                        <input name="fecha_inicial" style="width: 75px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
                <div class="input-group" style="display: inline-block; width: 113px ">
                  <label class="obligatorio" for="fecha_final">Fecha final</label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input name="fecha_final" style="width: 75px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                </div>
              </div>

            </div>
          </div>
          <div class="panel-footer">
            @if(isset($permisos->administrativo->fuec->crear))
              @if($permisos->administrativo->fuec->crear==='on')
                <a type="button" class="btn btn-primary btn-icon" id="guardar_fuec">GUARDAR<i class="icon-btn fa fa-save"></i></a>
              @else
                <a type="button" class="btn btn-primary btn-icon" disabled>GUARDAR<i class="icon-btn fa fa-save"></i></a>
              @endif
            @else
              <a type="button" class="btn btn-primary btn-icon disabled">GUARDAR<i class="icon-btn fa fa-save"></i></a>
            @endif
          </div>
      </div>
  </div>

  <div class="documentacion_conductor hidden">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>DOCUMENTACION DEL CONDUCTOR</strong>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fvencimiento" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
            </li>
          </ul>
          <button type="button" class="btn btn-primary btn-block ok">
            OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="documentacion_vehiculo hidden">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>DOCUMENTACION DEL VEHICULO</strong>
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">
              <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
            </li>
            <li class="list-group-item">
              <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
            </li>
            <li class="list-group-item">
              <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
              <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
            </li>
          </ul>
          <button type="button" class="btn btn-primary btn-block ok">
            OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="errores-modal bg-danger text-danger hidden model">
      <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
      <ul>
      </ul>
  </div>

  <div id="rutas_fuec" class="hidden">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>AGREGAR RUTA</strong>
      </div>
      <div class="panel-body">
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="a_origen">Origen</label>
          <input id="a_origen" class="form-control input-font" type="text" name="name" value="">
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="a_destino">Destino</label>
          <input id="a_destino" class="form-control input-font" type="text" name="name" value="">
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="a_ruta">Ruta</label>
          <textarea rows="6" class="form-control input-font" id="a_ruta"></textarea>
        </div>
      </div>
      <div class="panel-footer">
        <button id="guardar_ruta" type="button" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn"></i></button>
        <button type="button" class="btn btn-danger btn-icon cerrar_ruta">CERRAR<i class="fa fa-close icon-btn"></i></button>
      </div>
    </div>
  </div>

  <div id="editar_rutas_fuec" class="hidden">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>AGREGAR RUTA</strong>
      </div>
      <div class="panel-body">
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="b_origen">Origen</label>
          <input id="b_origen" class="form-control input-font" type="text" value="">
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="b_destino">Destino</label>
          <input id="b_destino" class="form-control input-font" type="text" value="">
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <label for="b_ruta">Ruta</label>
          <textarea rows="6" class="form-control input-font" id="b_ruta"></textarea>
        </div>
      </div>
      <div class="panel-footer">
        <button id="actualizar_ruta" type="button" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-save icon-btn"></i></button>
        <button type="button" class="btn btn-danger btn-icon cerrar_ruta">CERRAR<i class="fa fa-close icon-btn"></i></button>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="{{url('dist\fuec.js')}}"></script>
  </body>
</html>
