<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Cronograma de Servicios BOG</title>
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

    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-12">
        <h3 class="h_titulo">CRONOGRAMA DE SERVICIOS DEL DÍA {{$fecha}}</h3>       

        <div class="row">
          <div class="col-lg-12">
            <a onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
          </div>          
        </div>

        @if(isset($datos))
          <table id="table_cronograma" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>PROVEEDOR</th>
                <th>CONDUCTOR</th>
                <th>01h</th>
                <th>02h</th>
                <th>03h</th>
                <th>04h</th>
                <th>05h</th>
                <th>06h</th>
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
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>PROVEEDOR</th>
                <th>CONDUCTOR</th>
                <th>01h</th>
                <th>02h</th>
                <th>03h</th>
                <th>04h</th>
                <th>05h</th>
                <th>06h</th>
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
                ?>
                @foreach($datos as $info)

                  @if($info->id!=$conductor and $o!=1)
                    <?php 
                    if($o>1){
                      if($sw==1){
                        $sw=0;
                      }else if($sw==0){
                        $sw=1;
                      }
                    }                        
                     ?>
                  @endif

                  <tr>
                      <td>{{$info->razonsocial}}</td>
                      <td>{{$info->nombre_completo}}</td>
                        <?php
                        $date = date('Y-m-d');
                       for ($i=1; $i <= 24; $i++) {

                          if($i<=9){
                            $data = 0;
                          }else{
                            $data = '';
                          }

                          $servicioss = DB::table('servicios')
                          ->select('servicios.id', 'servicios.fecha_servicio', 'servicios.hora_servicio', 'servicios.proveedor_id', 'servicios.conductor_id', 'servicios.pendiente_autori_eliminacion', 'servicios.estado_servicio_app', 'centrosdecosto.razonsocial', 'subcentrosdecosto.nombresubcentro')
                          ->LeftJoin('centrosdecosto', 'centrosdecosto.id', '=', 'servicios.centrodecosto_id')
                          ->LeftJoin('subcentrosdecosto', 'subcentrosdecosto.id', '=', 'servicios.subcentrodecosto_id')
                          ->where('servicios.fecha_servicio', $fecha)
                          ->whereBetween('servicios.hora_servicio', [$data.$i.':00', $data.$i.':59'])
                          ->where('servicios.proveedor_id',$info->proveedor_id)
                          ->where('servicios.conductor_id',$info->conductor_id)
                          ->whereNull('servicios.pendiente_autori_eliminacion')
                          ->get();

                          $cliente = '';
                          $subcentro = '';
                          $estado_global = '<br>';
                          $cont = 0;
                          $color = '';

                          foreach ($servicioss as $servicio) {
                            $cont++;
                            if($servicio!=null){
                              $value = $servicio->hora_servicio;
                              $color = '';
                              
                              if($servicio->estado_servicio_app===null){
                                $estado = 'P';
                                $style = 'background: blue; color: white; padding: 2px;';
                              }else if($servicio->estado_servicio_app===1){
                                $estado = 'S';
                                $style = 'background: green; color: white; padding: 2px;';
                              }else{
                                $estado = 'F';
                                $style = 'background: gray; color: white; padding: 2px;';
                              }
                              $cliente = 'Cliente: '.$servicio->razonsocial;
                              $subcentro = ' | SubCentro: '.$servicio->nombresubcentro;

                              $val = '<span title="'.$cliente.$subcentro.'" style="'.$style.'">'.$value.'</span>';
                            }else{
                              $value = '';
                              $estado = '';
                              $style = '';
                              $color = '';
                            }

                            $estado_global .= $val.' <br><br> ';
                          }

                          echo '<td style="text-aling: center; background: '.$color.'">'.$estado_global.'</td>';

                      } ?>                        
                  </tr>
                  <?php $conductor = $info->id ?>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('scripts.scripts')
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="{{url('jquery/reportes.js')}}"></script>

    <script type="text/javascript">
      function goBack(){
          window.history.back();
      }
    </script>

  </body>
</html>
