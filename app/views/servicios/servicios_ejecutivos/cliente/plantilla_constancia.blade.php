<!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Constancia de Orden # {{$servicio->id}}</title>
    @include('scripts.styles')
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet">
    <style>

      body{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
      }

      #header{
        font-size: 12px;
      }

      .title-table{
        padding: 5px;
        background: #dadada;
        text-align: center;
        font-size: 10px;
        font-weight: 500;
      }

      #servicios tbody td{
        background: #efefef;
        padding: 10px;
        text-align: center;
        font-size: 12px;
      }

      #pasajeros tbody td{
        background: #efefef;
        padding: 10px;
        text-align: center;
        font-size: 12px;
      }

      .number_table{
        width: 10px;
        background: #dadada !important;
        border-right: 1px solid white;
        border-bottom: 1px solid white;
      }

      .pax_name_table{
        border-bottom: 1px solid white;
      }

      #client {
        padding-left: 6px;
        border-left: 6px solid #F47321;
        float: left;
        margin-bottom: 30px;
      }

      h3.name {
        font-weight: 500;
        font-size: 20px;
        margin: 0;
      }

      #informacion{
        table-layout: auto;
        empty-cells: show;
        border-collapse: collapse;
        margin-bottom: 15px;
        margin-top: 5px;
        width: 100%;
      }

      #informacion_conductor{
        table-layout: auto;
        empty-cells: show;
        border-collapse: collapse;
        margin-bottom: 10px;
        margin-top: 15px;
        width: 100%;
      }

      #informacion tr td, #informacion_conductor tr td{
        padding: 5px;
        font-size: 12px;
      }

      .div_info{
        padding: 5px;
        border-left: 1px solid #5a5a5a;
        border-right: 1px solid #5a5a5a;
        border-bottom: 1px solid #5a5a5a;
      }

    </style>
  </head><body>
     
    <div class="col-md-6 col-md-offset-3" style="margin-top: 25px">
      <div class="div_info" style="border-top: 1px solid">

        <table id="informacion">
          <tbody>
            <tr>
              <td style="width: 42px"><b>Ciudad:</b></td>
              <td style="border-bottom: 1px solid #5a5a5a; width: 70px">{{ucwords(strtolower($servicio->ciudad))}}</td>
              
            </tr>
          </tbody>
        </table>

        <table>
          <tbody>
            <tr>
              <td style="padding: 5px; font-size: 12px;"><b>Nombre Pasajero(s):</b></td>
            </tr>
          </tbody>
        </table>

        <table id="pasajeros" style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse; margin-bottom: 15px;">
          <tbody>

              <?php

                $pax = explode('/',$servicio->pasajeros);

                $paxHtml = '';

    						for ($i=0; $i < count($pax); $i++) {
    							$pasajeros[$i] = explode(',', $pax[$i]);
    						}

    						for ($i=0; $i < count($pax)-1; $i++) {

    							for ($j=0; $j < count($pasajeros[$i]); $j++) {

    								if ($j===0) {
                        $nombre = $pasajeros[$i][$j];
                    }

    							}

                  if ($i==0) {
                    $paxHtml .= '<tr><td colspan="1" class="number_table">'.($i+1).'</td><td class="pax_name_table">'.ucwords(strtolower($nombre)).'</td>';
                  }

                  if ($i==1) {
                    $paxHtml .= '<td class="number_table">'.($i+1).'</td><td class="pax_name_table">'.ucwords(strtolower($nombre)).'</td></tr>';
                  }

                  if ($i==2) {
                    $paxHtml .= '<tr><td class="number_table">'.($i+1).'</td><td class="pax_name_table">'.ucwords(strtolower($nombre)).'</td>';
                  }

                  if ($i==3) {
                    $paxHtml .= '<td class="number_table">'.($i+1).'</td><td class="pax_name_table">'.ucwords(strtolower($nombre)).'</td></tr>';
                  }

                  if ($i==4) {
                    $paxHtml .= '<tr><td class="number_table">'.($i+1).
                                '</td><td class="pax_name_table">'.strtolower($nombre).
                                '</td></tr>';
                  }

    						}

                echo $paxHtml;

              ?>

          </tbody>
        </table>

        <table>
          <tbody>
            <tr>
              <td style="padding: 5px; font-size: 12px;"><b>Detalles del servicio</b></td>
            </tr>
          </tbody>
        </table>

        <table id="servicios" style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse;">
          <thead>
            <tr>
              <th class="title-table" style="border-right: 1px solid white; width: 100px">FECHA</th>
              <th class="title-table" style="border-right: 1px solid white; width: 50px">HORA</th>
              <th class="title-table">Recogida - Destino</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="border-right: 1px solid white">{{$servicio->fecha_servicio}}</td>
              <td style="border-right: 1px solid white">{{substr($servicio->hora_servicio, -8, 5)}}</td>
              <td>{{ucwords(strtolower($servicio->recoger_en)).' - '.ucwords(strtolower($servicio->dejar_en))}}</td>
            </tr>
          </tbody>
        </table>

        <div style="width: 100%; min-height: 100px; background: #efefef; font-size: 12px; padding: 5px;">
        </div>

        <table>
          <tbody>
            <tr>
              <td style="padding: 5px; font-size: 12px;"><b>Firma del pasajero</b></td>
            </tr>
          </tbody>
        </table>

        <div style="width: 100%; height: 150px; background: #efefef; padding: 5px;">
            @if($sw===1)
                <img src="{{url('biblioteca_imagenes/firmas_servicios/firma_'.$servicio->id.'.png')}}" style="width: 250px;">
            @else
                <span style="color: red">No se registró firma</span>
            @endif
        </div>

        <p style="font-size: 10px; margin-top: 0px;">Cualquier comentario o sugerencia adicional del servicio prestado por favor escribir al correo electronico: servicios@aotour.com.co</p>
        <table>
          <tbody>
            <tr>
              <td><img style="width: 80px;" src="img/calidad_iconos.png" alt=""></td>
              <td><img style="width: 100px;" src="img/logo-supertransporte.png" alt=""></td>
            </tr>
          </tbody>
        </table>
      </div>
      <a style="float: right; margin-top: 15px" class="btn btn-warning mostrar_foto" target="_blank" href="{{url('serviciosejecutivos/downloadpdf/'.$servicio->id)}}">DESCARGAR PDF <i class="fa fa-download" aria-hidden="true"></i></a>
      </div>
  </body></html>