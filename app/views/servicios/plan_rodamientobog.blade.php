<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Plan de rodamiento</title>

    @include('scripts.styles')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <style media="screen">
      .font{
        font-size: 12px;
        vertical-align: middle !important;
        text-align: center;
      }
      .background-header{
          background: #F47321;
          color: white
      }

      .background-cell{
          background: #f1f1f1;
      }
    </style>
  </head>
  <body>
    @include('admin.menu')
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h3 class="h_titulo">PLAN DE RODAMIENTO</h3>
          <a href="{{URL::previous()}}" class="btn btn-primary">
            VOLVER <i class="fas fa-arrow-alt-circle-left"></i>
          </a>
          <table class="table table-bordered table-responsive" id="servicios">
            <thead>
              <tr class="background-header">
                <th class="font" style="width: 135px;">RUTA</th>
                <th class="font" style="width: 40px;">RECOGER</th>
                <th class="font" style="width: 170px;">DEJAR</th>
                <th class="font" style="width: 80px;">HORA SERVICIO</th>
                @foreach ($fechas as $fecha)
                  <th class="font" style="width: 150px;">{{$fecha}}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>

            <?php
              $i = 1;
              $razonsocial = null;
              $nombre_ruta = null;
              $hora_servicio = null;
            ?>

            <!--
              Por fecha recorrer array de servicios
            -->

              @foreach ($servicios_agrupados as $servicio)

                <?php

                  if ($i==1) {

                    echo '<tr class="background-header">'.
                      '<td colspan="3" class="font">'.$servicio->razonsocial.'</td>'.
                    '</tr>';

                  }else{

                    if ($razonsocial!=$servicio->razonsocial) {

                      echo '<tr class="background-header">'.
                        '<td colspan="3" class="font">'.$servicio->razonsocial.'</td>'.
                      '</tr>';

                    }

                  }


                ?>
                <tr class="content_cell">
                  <td class="font background-cell">{{$servicio->nombre}}</td>
                  <td class="font background-cell">{{$servicio->recoger_en}}</td>
                  <td class="font background-cell">{{$servicio->dejar_en}}</td>
                  <td class="font background-cell">{{$servicio->hora_servicio}}</td>

                  @foreach ($fechas as $fecha)
                    <?php
                      $ser = DB::table('servicios')->where('fecha_servicio', $fecha)
                      ->leftJoin('vehiculos', 'servicios.vehiculo_id', '=', 'vehiculos.id')
                      ->where('centrodecosto_id', $servicio->centrodecosto_id)
                      ->where('hora_servicio', $servicio->hora_servicio)
                      ->where('ruta_nombre_id', $servicio->ruta_nombre_id)
                      ->first();
                    ?>
                    @if (count($ser))
                      <td class="font" style="background: #ffff9d;">{{$ser->placa}}</td>
                    @else
                      <td class="font" style="background: #f1f1f1;"></td>
                    @endif
                  @endforeach

                </tr>

                <?php
                  $i++;
                  $razonsocial = $servicio->razonsocial;
                  $nombre_ruta = $servicio->nombre;
                  $hora_servicio = $servicio->hora_servicio;
                ?>
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{asset('xls_js/xlsx.core.min.js')}}"></script>
    <script src="{{asset('file_saver/FileSaver.min.js')}}"></script>
    <script src="{{asset('table_export/js/tableexport.js')}}"></script>
    <script type="text/javascript">

      $(function(){
        $('#servicios').tableExport({
          bootstrap: true,
          position: 'top',
          formats: ["xlsx", "csv"],
          filename: 'Plan de rodamiento',
          sheetname: '{{$fecha_inicial}} - {{$fecha_final}}',
          trimWhitespace: true
        });
      });

    </script>
  </body>
</html>
