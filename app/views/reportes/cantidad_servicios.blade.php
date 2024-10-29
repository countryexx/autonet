<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Cantidad de Servicios</title>
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
        <h3 class="h_titulo">SERVICIOS REALIZADOS POR DÍA | SEMANA | MES</h3>

        @if(isset($datos))
          <table id="table_cantidad" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr style="background: orange">
                <th>PROVEEDOR</th>
                <th>CONDUCTOR</th>
                <th>HOY</th>
                <th>ESTA SEMANA</th>
                <th>ESTE MES</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>PROVEEDOR</th>
                <th>CONDUCTOR</th>
                <th>HOY</th>
                <th>ESTA SEMANA</th>
                <th>ESTE MES</th>
              </tr>
            </tfoot>
            <tbody>
                @foreach($datos as $data)

                    <tr>
                      <td>{{$data->razonsocial}}</td>
                      <td>{{$data->nombre_completo}}</td>
                      <?php

                      $date = date('Y-m-d');

                      $dday = date('m');
                      $year = date('Y');
                      $hoy = date('d');

                      //día

                      $query = "select id, fecha_servicio, proveedor_id, conductor_id, pendiente_autori_eliminacion from servicios where fecha_servicio = '".$date."' and proveedor_id ='".$data->proveedor_id."' and conductor_id = '".$data->conductor_id."' and pendiente_autori_eliminacion is null";

                      $consulta = DB::select($query);

                      $total = count($consulta);
                      echo '<td>'.$total.'</td>';
                      //semana

                      //WEEK
                      $day = date("l");

                      $fecha_actual = date('Y-m-d');

                      if($day=='Monday'){
                        
                        $dia = 'LUNES.';
                        $diasmenos = $fecha_actual;

                      }else if($day=='Tuesday'){

                        $diasmenos = date('Y-m-d',strtotime('-1 day',strtotime($fecha_actual)));
                        $dia = 'MARTES.';

                      }else if($day=='Wednesday'){

                        $diasmenos = date('Y-m-d',strtotime('-2 day',strtotime($fecha_actual)));
                        $dia = 'MIÉRCOLES.';

                      }else if($day=='Thursday'){

                        $diasmenos = date('Y-m-d',strtotime('-3 day',strtotime($fecha_actual)));
                        $dia = 'JUEVES.';

                      }else if($day=='Friday'){
                        
                        $diasmenos = date('Y-m-d',strtotime('-4 day',strtotime($fecha_actual)));
                        $dia = 'VIERNES.';

                      }else if($day=='Saturday'){

                        $diasmenos = date('Y-m-d',strtotime('-5 day',strtotime($fecha_actual)));
                        $dia = 'SÁBADO.';

                      }else if($day=='Sunday'){

                        $diasmenos = date('Y-m-d',strtotime('-6 day',strtotime($fecha_actual)));
                        $dia = 'DOMINGO.';
                        
                      }else{
                        echo "NADA DE ESO";
                      }
                      //END WEEK

                      $query = "select id, fecha_servicio, proveedor_id, conductor_id, pendiente_autori_eliminacion from servicios where fecha_servicio between '".$diasmenos."' and '".$fecha_actual."' and proveedor_id ='".$data->proveedor_id."' and conductor_id = '".$data->conductor_id."' and pendiente_autori_eliminacion is null";

                      $consulta = DB::select($query);

                      $total_semana = count($consulta);
                      echo '<td>'.$total_semana.'</td>';

                      //mes
                      $date1 = $year.$dday.'01';
                      $date2 = date('Y-m-d');

                      $query = "select id, fecha_servicio, proveedor_id, conductor_id, pendiente_autori_eliminacion from servicios where fecha_servicio between '".$date1."' and '".$date2."' and proveedor_id ='".$data->proveedor_id."' and conductor_id = '".$data->conductor_id."' and pendiente_autori_eliminacion is null";

                      $consulta = DB::select($query);

                      $total_mes = count($consulta);

                      echo '<td>'.$total_mes.'</td>';

                      ?>                      
                    </tr>
                    <?php $conductor = $data->id ?>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>  

    <hr style="border: 10px">

    <!-- AGREGAR MÁS COSAS -->

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/reportes.js')}}"></script>
  </body>
</html>
