<html>
<head>
    <meta charset="UTF-8">
	<title>Autonet | Ordenes de Servicio</title>
    @include('scripts.styles')
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
</head>
<body>
@include('admin.menu')
<div class="col-lg-12">
    <h3 class="h_titulo">REVISIÓN DE ORDENES DE SERVICIO</h3>

    <?php
    $recargo = DB::table('centrosdecosto')->where('id',$centrodecosto_id)->first();
    ?>
    <!--<h3 class="h_titulo">RUTAS EJECUTADAS</h3>-->
    @if(isset($servicios))
        <table class="table table-striped table-bordered hover" id="rutas_ejecutadas">
            <thead>
            <tr>
                <td><input style="width: 15px; height: 15px;" type="checkbox" class="select_all"></td>
                <td>RUTA</td>
                <td>DESCRIPCION RECORRIDO</td>
                <td>RECOGER EN</td>
                <td>DEJAR EN</td>
                <td>COD CENTRO COSTO</td>
                <td>FECHA INICIO</td>
                <td>HORA INICIO</td>
                <td>PROVEEDOR</td>
                <td>ESTADO</td>
                <td>OBSERVACION</td>
                <td>PLANILLA</td>

            </tr>
            </thead>
            <tbody>
            @foreach($rutas_programadas as $ruta)
                <tr>
                    <td data-id="{{$ruta->id}}">
                        <input @if(intval($ruta->facturado)===1){{'disabled'}}@endif style="width: 15px; height: 15px;" type="checkbox" class="activar @if(intval($ruta->facturado)===1){{'disabled'}}@endif" check="false">
                    </td>
                    <td>
          					<?php

                      $sw_rn = 0;

          						$tarifa_ruta = DB::table('traslados')->where('id',$ruta->ruta_id)->first();

          						if(count($tarifa_ruta)>0){

                        if($ruta->localidad==1) {

                          $valor = DB::table('tarifas')
                          ->where('trayecto_id',$tarifa_ruta->id)
                          ->where('centrodecosto_id',$ruta->centrodecosto_id)
                          ->whereNotNull('localidad')
                          ->first();
                        }else{
                          $valor = DB::table('tarifas')
                          ->where('trayecto_id',$tarifa_ruta->id)
                          ->where('centrodecosto_id',$ruta->centrodecosto_id)
                          ->whereNull('localidad')
                          ->first();
                        }

          					?>
						<center><select class="form-control input-font" disabled id="ruta">
                    <option value="{{$tarifa_ruta->id}}" selected>{{$tarifa_ruta->nombre}}</option>
            </select>

            <!--{{$tarifa_ruta->nombre}}--><br>
            @if(isset($valor->cliente_auto) and isset($valor->proveedor_auto))
              @if( $ruta->ruta==1 ) <!-- RUTAS -->
                @if( ($ruta->clase!='AUTOMOVIL' and $ruta->clase!='CAMIONETA') )
                  @if($ruta->localidad!=1)
                    @if($ruta->cantidad < 5)
                      <b style="color: green; font-size: 15px">$ {{number_format($valor->cliente_van)}}</b>
                    @else
                      $ {{number_format($valor->cliente_van)}}
                    @endif
                  @else
                    @if($ruta->cantidad>4)
                      $ {{number_format($valor->cliente_van)}}
                    @else
                      $ {{number_format($valor->cliente_auto)}}
                    @endif
                  @endif
                  -
                  @if($ruta->cantidad>4)
                    $ {{number_format($valor->proveedor_van)}}
                  @else
                    $ {{number_format($valor->proveedor_auto)}}
                  @endif
                  <center><div class="estado_servicio_app" style="background: #73ADF7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">
                    {{$ruta->cantidad}} PAX
                  </div></center>
                @else
                  $ {{number_format($valor->cliente_auto)}} - $ {{number_format($valor->proveedor_auto)}}
                  <center><div class="estado_servicio_app" style="background: #73ADF7; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 90px; border-radius: 2px;">
                    {{$ruta->cantidad}} PAX
                  </div></center>
                @endif

              @else
              <!-- EJECUTIVOS -->
                @if( ($ruta->clase=='AUTOMOVIL' or $ruta->clase=='CAMIONETA') )
                  @if($recargo->recargo_nocturno==1 and ($ruta->hora_servicio>=$recargo->desde or $ruta->hora_servicio<$recargo->hasta)) <!--Recargo nocturno -->
                    $ {{number_format($valor->cliente_auto+($valor->cliente_auto*0.20))}} - $ {{number_format($valor->proveedor_auto)}}
                    <br>
                    <center><div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">
                      <b style="color: white; font-size: 12px">Recargo Nocturno</b>
                    </div></center>
                    <?php $sw_rn++; ?>
                  @else
                    $ {{number_format($valor->cliente_auto)}} - $ {{number_format($valor->proveedor_auto)}}
                  @endif

                @else
                  @if($recargo->recargo_nocturno==1 and ($ruta->hora_servicio>=$recargo->desde or $ruta->hora_servicio<$recargo->hasta) ) <!--Recargo nocturno -->
                    $ {{number_format($valor->cliente_van+($valor->cliente_van*0.20))}} - $ {{number_format($valor->proveedor_van)}}
                    <br>
                    <center><div class="estado_servicio_app" style="background: green; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 120px; border-radius: 2px;">
                      <b style="color: white; font-size: 12px">Recargo Nocturno</b>
                    </div></center>
                    <?php $sw_rn++; ?>
                  @else
                    $ {{number_format($valor->cliente_van)}} - $ {{number_format($valor->proveedor_van)}}
                  @endif
                @endif
              @endif

            @else
              $ {{number_format(0)}} - $ {{number_format(0)}}
            @endif
          </center>
					<?php
						}else{
					?>
						<!--<select class="form-control input-font" disabled id="ruta">
                            @foreach($rutas_centro as $rutacentro)
                                @if($rutacentro->nombre_ruta===$ruta->nombre_ruta)
                                    <option value="{{$rutacentro->id}}" selected>{{$rutacentro->nombre_ruta}}</option>
                                @else
                                    <option value="{{$rutacentro->id}}">{{$rutacentro->nombre_ruta}}</option>
                                @endif
                            @endforeach
                        </select>-->
                        <center>
                        <div class="estado_servicio_app" style="background: #D8D8D8; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 100px; border-radius: 2px;">
                          <b style="color: black; font-size: 12px;">SIN TRASLADO</b>
                        </div></center>
					<?php
						}
					?>

                    </td>
                    <td>
                        <input id="detalle_recorrido" type="text" class="form-control input-font" value="{{$ruta->detalle_recorrido}}" disabled></td>
                    <td>
                        <input id="recoger_en" type="text" class="form-control input-font" value="{{$ruta->recoger_en}}" disabled>
                    </td>
                    <td>
                        <input id="dejan_en" type="text" class="form-control input-font"  value="{{$ruta->dejar_en}}" disabled>
                    </td>
                    <td>
                        <input id="cod_centro_costo" class="form-control" type="text" value="{{$ruta->cod_centro_costo}}" disabled>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class='input-group date' id='datetime_fecha'>
                                <input type='text' class="form-control input-font" id="fecha_servicio" value="{{$ruta->fecha_servicio}}" disabled>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class='input-group date' id='datetime_hora'>
                                <input type='text' class="form-control input-font" id="hora_servicio" value="{{$ruta->hora_servicio}}" disabled>
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <center><a href>{{$ruta->razonsocial}}</a><br>
                        <a href title="{{$ruta->clase.'/'.$ruta->marca.'/'.$ruta->placa}}">{{$ruta->nombre_completo}}</a>
                        <br><a>{{$ruta->clase.'/'.$ruta->marca.'/'.$ruta->placa}}</a>
                        @if($ruta->clase!='AUTOMOVIL' and $ruta->clase!='CAMIONETA')
                          <div class="estado_servicio_app" style="background: #f47321; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 45px; border-radius: 2px;">
                            <b style="color: white; font-size: 12px">VAN</b>
                          </div>
                        @else
                          <div class="estado_servicio_app" style="background: gray; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 45px; border-radius: 2px;">
                            <b style="color: white; font-size: 12px">AUTO</b>
                          </div>
                        @endif
                        </center>
                    </td>
                    <td>

                      @if($ruta->numero_planilla!=null)
                        <small class="text-success" style="width: 120px"><b>REVISADO</b></small>
                      @else
                        <small class="text-info" style="width: 120px"><b>PENDING</b></small>
                      @endif

                    </td>
                    <td>
                        <select class="form-control input-font observaciones" id="observaciones" disabled>

                            <option>-</option>

                            @if($ruta->observacion==='REALIZADO A SATISFACCION' or $ruta->ruta===1 or $ruta->ruta==null)
                                <option selected>REALIZADO A SATISFACCION</option>
                            @else
                                <option>REALIZADO A SATISFACCION</option>
                            @endif

                            @if($ruta->observacion==='NO SHOW')
                                <option selected>NO SHOW</option>
                            @else
                                <option>NO SHOW</option>
                            @endif

                            @if($ruta->observacion==='NO REALIZADO')
                                <option selected>NO REALIZADO</option>
                            @else
                                <option>NO REALIZADO</option>
                            @endif

                            @if(($ruta->observacion!='NO SHOW') and ($ruta->observacion!='REALIZADO A SATISFACCION') and ($ruta->observacion!='NO REALIZADO') and ($ruta->observacion!=null))
                                <option selected>PERSONALIZADO</option>
                                <textarea disabled style="margin-top: 8px" rows="6" class="form-control input-font personalizado">{{$ruta->observacion}}</textarea>
                                <div class="alert_select"></div>
                            @elseif($sw_rn==1)
                              <option selected>PERSONALIZADO</option>
                              <textarea disabled style="margin-top: 8px" rows="6" class="form-control input-font personalizado">RN</textarea>
                              <div class="alert_select"></div>
                            @elseif($ruta->observacion===null)
                                <option>PERSONALIZADO</option>
                                <textarea disabled style="margin-top: 8px" rows="6" class="form-control input-font hidden personalizado"></textarea>
                            @elseif($ruta->observacion!=null)
                                <option>PERSONALIZADO</option>
                                <textarea disabled style="margin-top: 8px" rows="6" class="form-control input-font hidden personalizado"></textarea>
                            @endif

                        </select>

                    </td>
                    <td>
                        <input type="text" class="form-control input-font" id="numero_planilla" disabled value="@if($ruta->numero_planilla!=null){{$ruta->numero_planilla}}@else{{$ruta->id}}@endif">
                        <div class="alert_planilla"></div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <div class="col-lg-12">
        <div class="row">
            <div class="col-xs-6">
                <div class="row">
                    <div style="border: 1px dashed #CCCCCC; padding: 10px; margin-bottom:15px">
                        <label class="obligatorio">Calidad del servicio</label>
                        <div class="form-group">
                            <label id="id_bueno" class="radio-inline">
                                <input checked type="radio" name="radio_tipo" id="inlineRadio1" value="BUENO"> Bueno
                            </label>
                            <label id="id_regular" class="radio-inline">
                                <input type="radio" name="radio_tipo" id="inlineRadio2" value="REGULAR"> Regular
                            </label>
                             <label id="id_malo" class="radio-inline">
                                <input type="radio" name="radio_tipo" id="inlineRadio2" value="MALO"> Malo
                            </label>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px">
                            <label id="observaciones_servicio">Observaciones</label>
                            <textarea id="observaciones_servicio" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xs-12" style="margin-bottom:10px">
                <div class="row">
                     @if($permisos->facturacion->revision->crear==='on')
                        <a id="revisar" class="btn btn-default btn-icon input-font">Revisado<i class="fa fa-files-o icon-btn"></i></a>
                     @else
                        <a class="btn btn-default btn-icon input-font disabled">Revisado<i class="fa fa-files-o icon-btn"></i></a>
                     @endif
                     <a href="{{url('facturacion/revision')}}" class="btn btn-primary btn-icon input-font">Volver<i class="fa fa-reply icon-btn"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="alert_eliminar" class="hidden">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Error!<i id="cerrar_alerta_sino" style="float: right" class="fa fa-close"></i></div>
            <div class="panel-body">
                <div id="contenido_alerta">
                </div>
            </div>
        </div>
    </div>
</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>
<script>
    $('table a').click(function (e) {
        e.preventDefault();
    });
</script>
</body>
</html>
