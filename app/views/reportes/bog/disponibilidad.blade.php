<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Disponibilidad</title>
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

      table {
        display: table;
        border-collapse: separate;
        border-spacing: 0;
        border-color: grey;
      }

    </style>
  </head>
  <body>
    <div class="col-lg-12">

        <!--<form class="form-inline" id="form_buscar">
            <div class="col-lg-12" style="margin-bottom: 20px; margin-top: 20px; text-align: center;">
                <div class="row">
                    <div class="form-group">
                      <span style="float: right;"> <i style="color: yellow;" class="fa fa-square" aria-hidden="true"></i> AMARILLO: EJECUTIVOS | <i style="color: gray;" class="fa fa-square" aria-hidden="true"></i> GRIS: SGS | <i style="color: green;" class="fa fa-square" aria-hidden="true"></i> VERDE: BANCO POPULAR | <i style="color: purple;" class="fa fa-square" aria-hidden="true"></i> MORADO: OPTUM</span>
                    </div>
                    
                </div>
            </div>
        </form>-->

        <select style="width: 170px;" class="form-control input-font change">
          <option value="0">TODOS</option>
          <option value="1">HABILITADOS</option>
          <option value="2">PRÓXIMOS POR VENCERSE</option>
          <option value="3">VENCIDOS</option>
        </select>

        @if(isset($datos))
          <table id="table_cronograma"  class="display table table-striped table-bordered nowrap" cellspacing="0" style="width:100%">
            <thead>
              <tr>
                <th>CONDUCTOR</th>
                <th>07h</th>
                <th>08h</th>
                <th>09h</th>
                <th>10h</th>
                <th>11h</th>
                <th>12h</th>
                <th>13h</th>
                <th>14h</th>
                <th>15h</th>
                <th>16h</th>
                <th>17h</th>
                <th>18h</th>
                <th>19h</th>
                <th>20h</th>
                <th>21h</th>
                <th>22h</th>
                <th>23h</th>
                <th>00h</th>
                <th>01h</th>
                <th>02h</th>
                <th>03h</th>
                <th>04h</th>
                <th>05h</th>
                <th>06h</th>
                <th>#</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>CONDUCTOR</th>
                <th>07h</th>
                <th>08h</th>
                <th>09h</th>
                <th>10h</th>
                <th>11h</th>
                <th>12h</th>
                <th>13h</th>
                <th>14h</th>
                <th>15h</th>
                <th>16h</th>
                <th>17h</th>
                <th>18h</th>
                <th>19h</th>
                <th>20h</th>
                <th>21h</th>
                <th>22h</th>
                <th>23h</th>
                <th>00h</th>
                <th>01h</th>
                <th>02h</th>
                <th>03h</th>
                <th>04h</th>
                <th>05h</th>
                <th>06h</th>
                <th>#</th>
              </tr>
            </tfoot>
            <tbody>
                <?php
                    $btnEditaractivado = null;
                    $btnEditardesactivado = null;
                    $btnProgactivado = null;
                    $btnProgdesactivado = null;
                    $conductor = '';
                    $sw = 0;

                    $totalHabilitados = 0;
                    $totalPorvencer = 0;
                    $totalVencidos = 0;
                    $total = 0;
                ?>
                @foreach($datos as $info)

                  <?php

                    $fecha = date('Y-m-d');
                    
                    $ss = "select seguridad_social.fecha_inicial, seguridad_social.fecha_final from seguridad_social where conductor_id = ".$info->id." and '".$fecha."' between fecha_inicial and fecha_final ";
                    $ss = DB::select($ss);

                    $sw = 0;
                    $fechs = null;

                    if($ss) {

                      $dosdias = strtotime ('+2 day', strtotime($fecha));
                      $dosdias = date ('Y-m-d' , $dosdias);

                      foreach ($ss as $seg) {
                        $fechs = $seg->fecha_final;
                        if( $seg->fecha_final>$dosdias ){
                          $sw = 1; //verde
                        }else{
                          $sw = 2; //naranja
                        }

                      }

                    }else{
                      $sw = 3; //Roja
                    }

                    //Licencia
                    ##CANTIDAD DE DOCUMENTOS VENCIDOS POR CONDUCTOR
                    $documentos_vencidos_por_conductor = 0;
                    $documentos_vencidos = 0;
                    $documentos_por_vencer = 0;
                    ##CANTIDAD DE DOCUMENTOS POR VENCER POR CONDUCTOR
                    $documentos_por_vencer_por_conductor = 0;

                    $statusLicencia = 0;

                    $licencia_conduccion = floor((strtotime($info->fecha_licencia_vigencia)-strtotime(date('Y-m-d')))/86400);
                    //DIA ACTUAL
                    $fecha_actual = intval(date('d'));
                    ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS VENCIDOS
                    if ($licencia_conduccion<0){
                        $documentos_vencidos_por_conductor++;
                        $documentos_vencidos++;
                        $statusLicencia = 2;
                    }

                    ##CANTIDAD DE CONDUCTORES QUE TIENEN DOCUMENTOS POR VENCER
                    if (($licencia_conduccion>=0 && $licencia_conduccion<=7))
                    {
                        $documentos_por_vencer++;
                        $documentos_por_vencer_por_conductor++;
                        $statusLicencia = 1;
                    }

                    if($sw==1 and $statusLicencia==0){
                      $totalHabilitados = $totalHabilitados+1;
                    }else if($sw==3 || $statusLicencia==3) {
                      $totalVencidos = $totalVencidos+1;
                    }else{
                      $totalPorvencer = $totalPorvencer+1;
                    }

                    $total = $total+1;

                  ?>

                  <tr class="{{$sw}}">

                      <td data-conductor="{{$info->nombre_completo}}" statusSs="{{$sw}}" statusLicencia="{{$statusLicencia}}" licencia="{{$info->fecha_licencia_vigencia}}" ss="{{$fechs}}" class="docs" style="background: @if($sw==1 and $statusLicencia==0){{'green'}}@elseif($sw==3 || $statusLicencia==3){{'red'}}@else{{'orange'}}@endif;" >
                        <b style="font-size: 9px; color: white">

                        {{$info->nombre_completo}}
                        
                        </b>
                      </td>
                        <?php
                        $date = date('Y-m-d');
                       for ($i=7; $i <= 23; $i++) {

                          if($i<=9){
                            $data = 0;
                          }else{
                            $data = '';
                          }

                          $horaActual = $data.$i.':00';

                          $servicioss = DB::table('servicios')
                          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.proveedor_id', 'servicios.conductor_id', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.detalle_recorrido', 'servicios.ruta', 'servicios.centrodecosto_id', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro', 'conductores.inicio_fecha', 'conductores.inicio_hora', 'conductores.fin_fecha', 'conductores.fin_hora')
                          ->LeftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                          ->LeftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                          ->LeftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
                          ->where('servicios.fecha_servicio', $fecha)
                          ->whereBetween('servicios.hora_servicio', [$data.$i.':00', $data.$i.':59'])
                          ->where('servicios.proveedor_id',$info->id_proveedor)
                          ->where('servicios.conductor_id',$info->id)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->get();

                          $cliente = '';
                          $subcentro = '';
                          $estado_global = '<br>';
                          $cont = 0;
                          $color = '';
                          $contadora = 0;
                          $total = 0;

                          $colorCuadro = '';

                          if($date>=$info->inicio_fecha && $date<=$info->fin_fecha){

                            if($info->inicio_fecha==$info->fin_fecha){
                            
                              if($info->inicio_hora<=$horaActual and $info->fin_hora>=$horaActual and $info->inicio_fecha>=$date and $info->fin_fecha<=$date){
                                $color = 'red';
                              }

                            }else{

                              if($info->inicio_hora<=$horaActual and '23:59'>=$horaActual){
                                $color = 'red';
                              }

                            }

                          }

                          foreach ($servicioss as $servicio) {
                            $cont++;
                            
                            if($servicio!=null){

                              if($servicio->ruta===1){

                                $value = $servicio->detalle_recorrido;
                                if($servicio->centrodecosto_id===349){
                                  $color = 'purple';
                                }else if($servicio->centrodecosto_id===287){
                                  $color = 'gray';
                                }else if($servicio->centrodecosto_id===311){
                                  $color = 'green';
                                }else{
                                  $color = 'blue';
                                }
                                $style = 'color: white; padding: 1px;';
                              }else{

                                if($servicio->centrodecosto_id===349){
                                  $client = 'OPT';
                                }else if($servicio->centrodecosto_id===287){
                                  $client = 'SGS';
                                }else if($servicio->centrodecosto_id===311){
                                  $client = 'BP';
                                }else if($servicio->centrodecosto_id===343){
                                  $client = 'CONN';
                                }else if($servicio->centrodecosto_id===330){
                                  $client = 'STR';
                                }else if($servicio->centrodecosto_id===329){
                                  $client = 'AVI';
                                }else if($servicio->centrodecosto_id===325){
                                  $client = 'HYD';
                                }else if($servicio->centrodecosto_id===59){
                                  $client = 'BOS';
                                }else if($servicio->centrodecosto_id===1){
                                  $client = 'CONT';
                                }else if($servicio->centrodecosto_id===218){
                                  $client = 'DOWQ';
                                }else if($servicio->centrodecosto_id===35){
                                  $client = 'FARG';
                                }else if($servicio->centrodecosto_id===100){
                                  $client = 'PN';
                                }else if($servicio->centrodecosto_id===80){
                                  $client = 'SUP';
                                }else{
                                  $client = 'EJE';
                                }

                                $value = $servicio->hora_servicio.'<br><b>'.$client.'</b>';
                                $color = 'yellow';
                                $style = 'color: black; padding: 1px;';
                              }
                              
                              if($servicio->estado_servicio_app===null){
                                $estado = 'P';
                                //$style = 'color: white; padding: 2px;';
                              }else if($servicio->estado_servicio_app===1){
                                $estado = 'S';
                                //$style = 'background: green; color: white; padding: 2px;';
                              }else{
                                $estado = 'F';
                                //$style = 'background: gray; color: white; padding: 2px;';
                              }
                              $cliente = 'Cliente: '.$servicio->razonsocial;
                              $subcentro = ' | SubCentro: '.$servicio->nombresubcentro;

                              $val = '<span title="'.$cliente.$subcentro.'" style="'.$style.'">'.$value.'</span>';
                              $contadora++;
                            }else{
                              $value = '';
                              $estado = '';
                              $style = '';
                              
                            }

                            $estado_global .= $val.' <br><br> ';
                          }
                          
                          echo '<td style="padding: 1px; height; 10px; font-size: 9px; text-aling: center; background: '.$color.'">'.$estado_global.'</td>';

                      }
                        /*$service = DB::table('servicios')
                          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.proveedor_id', 'servicios.conductor_id', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app')
                          ->where('servicios.fecha_servicio', $fecha)
                          ->where('servicios.conductor_id',$info->id)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->get();
                          $total = count($service);
                          echo '<td style="text-aling: center; background: '.$color.'">'.$total.'</td>';*/

                      ?>  

                      <!-- Madrugada -->

                      <!-- <td><b>{{$info->nombre_completo}}</b></td> -->
                        <?php
                        $date = date('Y-m-d');
                       for ($i=0; $i <= 06; $i++) {

                          if($i<=9){
                            $data = 0;
                          }else{
                            $data = '';
                          }

                          $horaActual = $data.$i.':00';

                          $nextday = strtotime ('+1 day', strtotime($fecha));
                          $nextday = date ('Y-m-d' , $nextday);

                          $servicioss = DB::table('servicios')
                          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.proveedor_id', 'servicios.conductor_id', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'servicios.detalle_recorrido', 'servicios.ruta', 'servicios.centrodecosto_id', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro', 'conductores.inicio_fecha', 'conductores.inicio_hora', 'conductores.fin_fecha', 'conductores.fin_hora')
                          ->LeftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                          ->LeftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                          ->LeftJoin('conductores', 'conductores.id', '=', 'servicios.conductor_id')
                          ->where('servicios.fecha_servicio', $nextday)
                          ->whereBetween('servicios.hora_servicio', [$data.$i.':00', $data.$i.':06'])
                          ->where('servicios.proveedor_id',$info->id_proveedor)
                          ->where('servicios.conductor_id',$info->id)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->get();

                          $cliente = '';
                          $subcentro = '';
                          $estado_global = '<br>';
                          $cont = 0;
                          $color = '';
                          $contadora = 0;
                          $total = 0;

                          $colorCuadro = '';

                          if($date>=$info->inicio_fecha && $date<=$info->fin_fecha){

                            if($info->inicio_fecha==$info->fin_fecha){
                              
                              if($info->inicio_hora<=$horaActual and $info->fin_hora>=$horaActual and $info->inicio_fecha>=$date and $info->fin_fecha<=$date){
                                $color = 'red';
                              }else if($info->inicio_fecha==$nextday and $info->inicio_hora<=$horaActual and $info->fin_hora>=$horaActual){
                                $color = 'red';
                              }

                            }else{

                              if('00:00'<=$horaActual and $info->fin_hora>=$horaActual){
                                $color = 'red';
                              }

                            }

                          }

                          foreach ($servicioss as $servicio) {
                            $cont++;
                            
                            if($servicio!=null){

                              if($servicio->ruta===1){

                                $value = $servicio->detalle_recorrido;
                                if($servicio->centrodecosto_id===349){
                                  $color = 'purple';
                                }else if($servicio->centrodecosto_id===287){
                                  $color = 'gray';
                                }else if($servicio->centrodecosto_id===311){
                                  $color = 'green';
                                }else{
                                  $color = 'blue';
                                }
                                $style = 'color: white; padding: 1px;';
                              }else{

                                if($servicio->centrodecosto_id===349){
                                  $client = 'OPT';
                                }else if($servicio->centrodecosto_id===287){
                                  $client = 'SGS';
                                }else if($servicio->centrodecosto_id===311){
                                  $client = 'BP';
                                }else if($servicio->centrodecosto_id===343){
                                  $client = 'CONN';
                                }else if($servicio->centrodecosto_id===330){
                                  $client = 'STR';
                                }else if($servicio->centrodecosto_id===329){
                                  $client = 'AVI';
                                }else if($servicio->centrodecosto_id===325){
                                  $client = 'HYD';
                                }else if($servicio->centrodecosto_id===59){
                                  $client = 'BOS';
                                }else if($servicio->centrodecosto_id===1){
                                  $client = 'CONT';
                                }else if($servicio->centrodecosto_id===218){
                                  $client = 'DOWQ';
                                }else if($servicio->centrodecosto_id===35){
                                  $client = 'FARG';
                                }else if($servicio->centrodecosto_id===100){
                                  $client = 'PN';
                                }else if($servicio->centrodecosto_id===80){
                                  $client = 'SUP';
                                }else{
                                  $client = 'EJE';
                                }

                                $value = $servicio->hora_servicio.'<br><b>'.$client.'</b>';
                                $color = 'yellow';
                                $style = 'color: black; padding: 1px;';
                              }
                              
                              if($servicio->estado_servicio_app===null){
                                $estado = 'P';
                                //$style = 'color: white; padding: 2px;';
                              }else if($servicio->estado_servicio_app===1){
                                $estado = 'S';
                                //$style = 'background: green; color: white; padding: 2px;';
                              }else{
                                $estado = 'F';
                                //$style = 'background: gray; color: white; padding: 2px;';
                              }
                              $cliente = 'Cliente: '.$servicio->razonsocial;
                              $subcentro = ' | SubCentro: '.$servicio->nombresubcentro;

                              $val = '<span title="'.$cliente.$subcentro.'" style="'.$style.'">'.$value.'</span>';
                              $contadora++;
                            }else{
                              $value = '';
                              $estado = '';
                              $style = '';
                              
                            }

                            $estado_global .= $val.' <br><br> ';
                          }
                          
                          echo '<td style="text-aling: center; background: '.$color.'">'.$estado_global.'</td>';

                      }
                        $service = DB::table('servicios')
                          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.proveedor_id', 'servicios.conductor_id', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app')
                          ->where('servicios.fecha_servicio', $fecha)
                          ->where('servicios.conductor_id',$info->id)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->get();
                          $total = count($service);
                          echo '<td style="text-aling: center; background: '.$color.'">'.$total.'</td>';

                      ?>  
                  </tr>
                  <?php $conductor = $info->id ?>
                @endforeach
            </tbody>
          </table>
        @endif

        <?php 

        $consulta = "select distinct centrosdecosto.razonsocial, centrosdecosto.id as id_centro from servicios left join centrosdecosto on centrosdecosto.id = servicios.centrodecosto_id where servicios.fecha_servicio = '".date('Y-m-d')."' and servicios.pendiente_autori_eliminacion is null and servicios.localidad = 1";

        $clientes = DB::select($consulta);


        ?>

        <div class="row">
          <div class="col-lg-4 col-lg-push-8">
            <table id="table_cronograma" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                <tr>
                  <th style="text-align: center; background: orange;">CLIENTE</th>
                  <th style="text-align: center; background: orange;">CANTIDAD</th>
                </tr>
              </thead>
              <tbody>
                <?php $total = 0; ?>
                <tr>
                    <td>
                      HABILITADOS
                    </td>
                    <td style="text-align: center;">
                      {{$totalHabilitados}}
                    </td>
                  </tr>

                  <tr>
                    <td>
                      POR VENCER
                    </td>
                    <td style="text-align: center;">
                      {{$totalPorvencer}}
                    </td>
                  </tr>

                  <tr>
                    <td>
                      VENCIDOS
                    </td>
                    <td style="text-align: center;">
                      {{$totalVencidos}}
                    </td>
                  </tr>
                
                  <tr>
                    <td style="text-align: center;">TOTAL</td>
                    <td style="text-align: center; background: orange;">{{$total}}</td>
                  </tr>
              </tbody>
            </table>
          </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id='modal_docs'>
          <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" style="text-align: center;" id="name"></h4>
                </div>
                <div class="modal-body">
                  <center>
                    <div class="row">
        
                      <div class="col-lg-8 col-md-8 col-sm-8 col-lg-push-2">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span style="font-size: 15px;"><b style="font-size: 20px;">Documentación</b></span></div>
                              <div class="panel-body">

                                <div class="input-group margin_input">
                                  <span class="input-group-addon ss" id="basic-addon1"><b style="color: white;">SS:</b></span>
                                  <input class="form-control input-font" aria-describedby="basic-addon1" id="ss" value="" disabled>
                                </div>
                                <div class="input-group margin_input">
                                  <span class="input-group-addon licencia" id="basic-addon1"><b style="color: white;">Licencia:</b></span>
                                  <input style="" class="form-control input-font" aria-describedby="basic-addon1" id="licencia" value="" disabled>
                                </div>
                               
                            </div>
                          </div>
                            </div>

                    </div>
                  </center>
                </div>
                <div class="modal-footer">
                  <div class="row">
                    <div class="col-md-9">
                      
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>                    
                </div>
            </div>
          </div>
        </div>

        <!--<div class="row">
          <div class="col-lg-12">
            <a onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
          </div>          
        </div>-->
    </div>

    @include('scripts.scripts')
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <!--<script src="{{url('jquery/reportes.js')}}"></script>-->

    <script type="text/javascript">
      function goBack(){
          window.history.back();
      }

      $( document ).ready(function() {

        var request = setInterval(function(){
          
          location.reload();

        }, 120000);

      });

      $('.change').change(function() {

        var id = $(this).val();

        if(id==0) {

          $('.1').removeClass('hidden');
          $('.2').removeClass('hidden');
          $('.3').removeClass('hidden');

        }else{

          $('.1').addClass('hidden');
          $('.2').addClass('hidden');
          $('.3').addClass('hidden');

          $('.'+id+'').removeClass('hidden');

        }

      });

      $('.docs').click(function() {
        
        var placa = $(this).attr('data-conductor');

        var ss = $(this).attr('ss');
        var licencia = $(this).attr('licencia');


        $('#name').html(placa);

        $('#ss').val(ss);
        $('#licencia').val(licencia);

        //estados de colores
        if( $(this).attr('statusSs')==1 ) {
          $('.ss').attr('style','background: green');
        }else if( $(this).attr('statusSs')==2 ) {
          $('.ss').attr('style','background: orange');
        }else{
          $('.ss').attr('style','background: red');
        }

        if( $(this).attr('statusLicencia')==0 ) {
          $('.licencia').attr('style','background: green');
        }else if( $(this).attr('statusLicencia')==1 ) {
          $('.licencia').attr('style','background: orange');
        }else{
          $('.licencia').attr('style','background: red');
        }

        $('#modal_docs').modal('show');

      });

      //table cronograma de servicios
      var $table_cronograma1 = $('#table_cronograma1').DataTable({
          paging: false,
          searching: true,
          language: {
              processing:     "Procesando...",
              search:         "Buscar:",
              lengthMenu:    "Mostrar _MENU_ Registros",
              info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
              infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
              infoFiltered:   "(Filtrando de _MAX_ registros en total)",
              infoPostFix:    "",
              loadingRecords: "Cargando...",
              zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
              emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
              paginate: {
                  first:      "Primer",
                  previous:   "Antes",
                  next:       "Siguiente",
                  last:       "Ultimo"
              },
              aria: {
                  sortAscending:  ": activer pour trier la colonne par ordre croissant",
                  sortDescending: ": activer pour trier la colonne par ordre décroissant"
              },
              responsive: true
          },
          'bAutoWidth': false ,
          'aoColumns' : [
              { 'sWidth': '6%' }, //conductor
              //{ 'sWidth': '1%' }, //01h
              //{ 'sWidth': '1%' }, //02h
              //{ 'sWidth': '1%' }, //03h
              //{ 'sWidth': '1%' }, //04h
              //{ 'sWidth': '1%' }, //05h
              //{ 'sWidth': '1%' }, //06h
              //{ 'sWidth': '1%' }, //07h
              { 'sWidth': '1%' }, //08h
              { 'sWidth': '1%' }, //09h
              { 'sWidth': '1%' }, //10h
              { 'sWidth': '1%' }, //11h
              { 'sWidth': '1%' }, //12h
              { 'sWidth': '1%' }, //13h
              { 'sWidth': '1%' }, //14h
              { 'sWidth': '1%' }, //15h
              { 'sWidth': '1%' }, //16h
              { 'sWidth': '1%' }, //17h
              { 'sWidth': '1%' }, //18h
              { 'sWidth': '1%' }, //19h
              { 'sWidth': '1%' }, //20h
              { 'sWidth': '1%' }, //21h
              { 'sWidth': '1%' }, //22h
              { 'sWidth': '1%' }, //23h
              { 'sWidth': '1%' }, //24h
              { 'sWidth': '1%' }, //#
          ],
          processing: true,
          "bProcessing": true
      });
      //fin table cronograma de servicios

      var $table_cronograma = $('#table_cronograma').DataTable( {
        scrollY:        "600px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true
    } );

      var $table_cronograma12 = $('#table_cronograma12').DataTable({
      paging: true,
      searching: true,
       scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true,
      language: {
          processing:     "Procesando...",
          search:         "Buscar:",
          lengthMenu:    "Mostrar _MENU_ Registros",
          info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
          infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
          infoFiltered:   "(Filtrando de _MAX_ registros en total)",
          infoPostFix:    "",
          loadingRecords: "Cargando...",
          zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
          emptyTable:     "NINGUN SERVICIO FINALIZADO EN EL MOMENTO",
          paginate: {
              first:      "Primer",
              previous:   "Antes",
              next:       "Siguiente",
              last:       "Ultimo"
          },
          aria: {
              sortAscending:  ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      'bAutoWidth': false ,
      'aoColumns' : [
              { 'sWidth': '6%' }, //conductor
              //{ 'sWidth': '1%' }, //01h
              //{ 'sWidth': '1%' }, //02h
              //{ 'sWidth': '1%' }, //03h
              //{ 'sWidth': '1%' }, //04h
              //{ 'sWidth': '1%' }, //05h
              //{ 'sWidth': '1%' }, //06h
              //{ 'sWidth': '1%' }, //07h
              { 'sWidth': '1%' }, //08h
              { 'sWidth': '1%' }, //09h
              { 'sWidth': '1%' }, //10h
              { 'sWidth': '1%' }, //11h
              { 'sWidth': '1%' }, //12h
              { 'sWidth': '1%' }, //13h
              { 'sWidth': '1%' }, //14h
              { 'sWidth': '1%' }, //15h
              { 'sWidth': '1%' }, //16h
              { 'sWidth': '1%' }, //17h
              { 'sWidth': '1%' }, //18h
              { 'sWidth': '1%' }, //19h
              { 'sWidth': '1%' }, //20h
              { 'sWidth': '1%' }, //21h
              { 'sWidth': '1%' }, //22h
              { 'sWidth': '1%' }, //23h
              { 'sWidth': '1%' }, //24h
              { 'sWidth': '1%' }, //#
          ],
      processing: true,
      "bProcessing": true
      });

      $('#datetimepicker1, #datetimepicker2').datetimepicker({
          locale: 'es',
          format: 'YYYY-MM-DD',
          icons: {
              time: 'glyphicon glyphicon-time',
              date: 'glyphicon glyphicon-calendar',
              up: 'glyphicon glyphicon-chevron-up',
              down: 'glyphicon glyphicon-chevron-down',
              previous: 'glyphicon glyphicon-chevron-left',
              next: 'glyphicon glyphicon-chevron-right',
              today: 'glyphicon glyphicon-screenshot',
              clear: 'glyphicon glyphicon-trash',
              close: 'glyphicon glyphicon-remove'
          }
      });

    </script>

  </body>
</html>
