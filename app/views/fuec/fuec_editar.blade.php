<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Fuec</title>
      @include('scripts.styles')
      <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
      <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
    @include('admin.menu')
    @include('fuec.breadcrumb')
    <div class="col-lg-10 col-md-10 col-sm-12">
        <h3 class="h_titulo">EDITAR FUEC</h3>
        <div class="panel panel-default">
            <div class="panel-heading">Fuec</div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <label>Proveedor</label>
                      <select id="proveedor" class="form-control input-font proveedor" disabled>
                        <option value="0">-</option>
                        @foreach($proveedores as $proveedor)
                          @if($fuec->proveedor===$proveedor->id)
                              <option selected value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                          @else
                            <option value="{{$proveedor->id}}">{{$proveedor->razonsocial}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    <?php
                      $vehiculos = DB::table('vehiculos')->where('proveedores_id',$fuec->proveedor)->get();
                    ?>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                      <label>Vehiculo</label>
                      <select id="vehiculo" class="form-control input-font vehiculo" disabled estado="false">
                        <option value="0">-</option>
                          @foreach($vehiculos as $vehiculo)
                              @if($vehiculo->id===$fuec->vehiculo)
                              <option selected value="{{$vehiculo->id}}">{{$vehiculo->clase.' / '.$vehiculo->placa.' / '.$vehiculo->marca.' / '.$vehiculo->modelo}}</option>
                              @else
                              <option value="{{$vehiculo->id}}">{{$vehiculo->clase.' / '.$vehiculo->placa.' / '.$vehiculo->marca.' / '.$vehiculo->modelo}}</option>
                              @endif
                          @endforeach
                      </select>
                      <small role="alert" class="text-danger vehiculo_alert hidden"></small>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 contrato">
                        <label for="contrato" class="obligatorio contrato">Contrato</label>
                        <select disabled class="form-control input-font contrato" id="contrato" estado="false">
                          <option value="0">-</option>
                          <?php

                          $contratos = DB::table('contratos')->get();

                          ?>
                          @foreach($contratos as $contrato)
                              @if(intval($fuec->contrato_id)===intval($contrato->id))
                              <option selected value="{{$contrato->id}}">{{'CONTRATO: '.$contrato->numero_contrato.' / CONTRATANTE: '.$contrato->contratante.' / '.$contrato->fecha_inicio.' / '.$contrato->fecha_vencimiento}}</option>
                              @else
                              <option value="{{$contrato->id}}">{{'CONTRATO: '.$contrato->numero_contrato.' / CONTRATANTE: '.$contrato->contratante.' / '.$contrato->fecha_inicio.' / '.$contrato->fecha_vencimiento}}</option>
                              @endif
                          @endforeach
                        </select>
                        <small id="alert_contrato" class="text-danger hidden"></small>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                      <div class="row">
                        <div id="conductores">
                          <?php
                            $conductor = explode(',',$fuec->conductor);

                            foreach($conductor as $cond){
                              $conductores = DB::table('conductores')->where('proveedores_id',$fuec->proveedor)->get();
                              echo '<div class="col-xs-4">';
                              echo '<label>Conductor</label>';
                              echo '<select id="conductor" class="form-control input-font conductor conductor_editar" disabled estado="true">';
                              echo '<option value="0">-</option>';
                                foreach($conductores as $cc){
                                  if(intval($cond)===intval($cc->id)){
                                      echo '<option selected value="'.$cc->id.'">'.$cc->nombre_completo.'</option>';
                                  }else{
                                      echo '<option value="'.$cc->id.'">'.$cc->nombre_completo.'</option>';
                                  }

                                }
                              echo '</select>';
                              echo '<small role="alert" class="text-danger conductor_alert hidden"></small>';
                              echo '</div>';
                            }

                          ?>

                        </div>
                        <button id="agregar_conductor" style="margin-top: 25px; margin-left: 15px;" class="btn btn-primary" type="text"><i class="fa fa-plus"></i></button>
                        <button disabled id="eliminar_conductor" style="margin-top: 25px;" class="btn btn-danger" type="text"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                    $rutas = DB::table('rutas_fuec')->get();
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6">
                      <label class="obligatorio">Rutas</label>
                      <select disabled class="form-control input-font ruta_fuec" id="ruta_fuec">
                        <option value="0">-</option>
                        @foreach($rutas as $ruta)
                          @if(intval($fuec->ruta_id)===intval($ruta->id))
                          <option selected value="{{$ruta->id}}">{{'ORIGEN: '.$ruta->origen.' DESTINO: '.$ruta->destino}}</option>
                          @else
                          <option value="{{$ruta->id}}">{{'ORIGEN: '.$ruta->origen.' DESTINO: '.$ruta->destino}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">
                  <button id="mostrar_ruta" style="margin-top: 25px;" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="row">
                    <?php

                      $des_ruta = DB::table('rutas_fuec')->where('id',$fuec->ruta_id)->pluck('ruta');

                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="ruta" class="obligatorio">Descripcion</label>
                        <textarea disabled rows="5" type="text" class="form-control input-font" id="descripcion_ruta" placeholder="">{{$des_ruta}}</textarea>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <label for="objeto_contrato" class="obligatorio">Objeto Contrato</label>
                        <select class="form-control input-font" id="objeto_contrato" disabled>
                          <option>-</option>
                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL')
                            <option selected>TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE TURISTAS')
                            <option selected>TRANSPORTE TERRESTRE DE TURISTAS</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE TURISTAS</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE PERSONAL DE TURISMO')
                            <option selected>TRANSPORTE TERRESTRE DE PERSONAL DE TURISMO</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE PERSONAL DE TURISMO</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y DE AMIGOS')
                            <option selected>TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y DE AMIGOS</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y DE AMIGOS</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE HUESPEDES')
                            <option selected>TRANSPORTE TERRESTRE DE HUESPEDES</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE HUESPEDES</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD')
                            <option selected>TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR')
                            <option selected>TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE GRUPO ESPECIFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)')
                            <option selected>TRANSPORTE TERRESTRE GRUPO ESPECIFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)</option>
                          @else
                            <option>TRANSPORTE TERRESTRE GRUPO ESPECIFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)</option>
                          @endif

                          @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE ESTUDIANTES' or $fuec->objeto_contrato==='TRANSPORTE TERRESTRE ESCOLAR')
                            <option selected>TRANSPORTE TERRESTRE DE ESTUDIANTES</option>
                          @else
                            <option>TRANSPORTE TERRESTRE DE ESTUDIANTES</option>
                          @endif

                        </select>
                    </div>
                        @if($fuec->objeto_contrato==='TRANSPORTE TERRESTRE DE ESTUDIANTES' or $fuec->objeto_contrato==='TRANSPORTE TERRESTRE ESCOLAR')
                            <div class="col-lg-3 col-md-3 col-sm-3 colegio">
                                <label for="objeto_contrato" class="obligatorio">Nombre del Colegio</label>
                                <input disabled type="text" class="form-control input-font" id="colegio" value="{{$fuec->colegio}}">
                            </div>
                        @else
                            <div class="col-lg-3 col-md-3 col-sm-3 colegio hidden">
                                <label for="objeto_contrato" class="obligatorio">Nombre del Colegio</label>
                                <input type="text" class="form-control input-font" id="colegio">
                            </div>
                        @endif

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="input-group" style="display: inline-block; width: 113px; float: left; margin-right: 20px;">
                                    <label class="obligatorio" for="fecha_inicial">Fecha inicial</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="fecha_inicial" style="width: 75px;" type='text' class="form-control input-font" value="{{$fuec->fecha_inicial}}" disabled>
                                  <span class="input-group-addon">
                                      <span class="fa fa-calendar">
                                      </span>
                                  </span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label class="obligatorio" for="fecha_final">Fecha final</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input name="fecha_final" style="width: 75px;" type='text' class="form-control input-font" value="{{$fuec->fecha_final}}" disabled>
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar">
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                  </div>
                </div>
              </div>
              <div style="float: left;">
                <label for="users_creado">Generado por: <b>{{$fuec->first_name}} {{$fuec->last_name}}</b></label>
              </div>
            </div>
            <div class="panel-footer">
              <a type="button" class="btn btn-success btn-icon" id="editar_fuec">EDITAR<i class="icon-btn fa fa-pencil"></i></a>
              <a data-id="{{$fuec->id}}" type="button" class="btn btn-info btn-icon disabled" id="actualizar_fuec">GUARDAR<i class="icon-btn fa fa-save"></i></a>
              <a onclick="goBack()" type="button" class="btn btn-primary btn-icon" id="actualizar_fuec">VOLVER<i class="icon-btn fa fa-reply"></i></a>
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
            </ul>
            <button type="button" class="btn btn-primary ok">
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
            <button type="button" class="btn btn-primary ok">
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

    <script type="text/javascript" src="{{url('dist\fuec.js')}}"></script>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
  </body>
</html>
