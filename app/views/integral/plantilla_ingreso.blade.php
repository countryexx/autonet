<!DOCTYPE html>
<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
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
      <table id="header" style="width:100%;table-layout:auto;empty-cells:show; border: 1px solid #5a5a5a; border-collapse: collapse;">
        <tbody>
          <tr>
            <td width="20" style="padding: 20px; border-right: 1px solid #5a5a5a;"><img width="120" src="biblioteca_imagenes/logos.png"></td>
            <td width="280" align="center">
               <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td align="center">FORMATO</td>
                </tr>
                <tr>
                   <td align="center"><b>CONTROL DE ENTRADA Y SALIDA DE EMPLEADOS</b> <br> GESTIÓN DEL TALENTO HUMANO</td>
                </tr>
                <tr>
                  <td align="center"></td>
                </tr>
               </table>
            </td>
            <td width="120">
              <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Codigo</td>
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">FM-TH-20</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Version</td>
                  <td align="center" style="border-bottom: 1px solid black;">2</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-collapse: collapse; padding: 5px;">Fecha</td>
                  <td align="center">10/02/17</td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="div_info">
        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>FECHA:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center">{{$fecha}}</td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>MES:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center">ENERO</td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px">  <b>AÑO:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px">2021</td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>RESPONSABLE:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center">{{Sentry::getUser()->first_name}} {{Sentry::getUser()->last_name}}</td>
          </tr>               
        </table>

        <table id="servicios" style="width:98%;">
          <thead>
            <tr>
              <th class="title-table" style="border-right: 1px solid white; width: 10px">N°</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">LLEGADA AM</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">SALIDA AM</th>
              <th class="title-table" style="border-right: 1px solid white; width: 120px">NOMBRES Y APELLIDOS</th>
              <th class="title-table" style="border-right: 1px solid white; width: 70px">CARGO</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">LLEGADA PM</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">SALIDA PM</th>
            </tr>
          </thead>

          <tbody>
            @if(isset($documentos))
              <?php $contador = 1; ?>
              @foreach($documentos as $documento)
                <tr>
                  <td style="border-right: 1px solid white; font-size: 10px"><?php echo $contador ?></td>
                  <td style="border-right: 1px solid white; font-size: 10px">{{$documento->hora_llegada}}</td>
                  <td style="border-right: 1px solid white; font-size: 10px">{{$documento->hora_salida}}</td>              
                  <td style="font-size: 10px">{{$documento->nombres}} {{$documento->apellidos}}</td>              
                  <td style="border-right: 1px solid white; font-size: 10px">{{$documento->cargo}}</td>
                  <td style="border-right: 1px solid white; font-size: 10px">{{$documento->hora_llegadapm}}</td>
                  <td style="border-right: 1px solid white; font-size: 10px">{{$documento->hora_salidapm}}</td>
                </tr>
                <?php $contador++; ?>
              @endforeach
            @else
              <tr>
                <td style="border-right: 1px solid white; font-size: 10px">NO SE REGISTRA NINGÚN INGRESO EN EL SISTEMA.</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>

  </body></html>
