<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>Reporte de Limpieza</title>
    
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
          <tr>
            <td width="26" style="padding: 20px; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a;"><img width="130" src="biblioteca_imagenes/logos.png"></td>
            <td width="280" align="center">
               <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td align="center">FORMATO</td>
                </tr>
                <tr>
                   <td align="center"><b>CONTROL DE LIMPIEZA Y DESINFECCIÓN DE VEHÍCULOS</b> <br> GESTIÓN OPERATIVA</td>
                </tr>
                <tr>
                  <td align="center"></td>
                </tr>
               </table>
            </td>
            <td width="115">
              <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Codigo</td>
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">FM-TH-21</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Version</td>
                  <td align="center" style="border-bottom: 1px solid black;">1</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-collapse: collapse; padding: 5px;">Fecha</td>
                  <td align="center">12/05/21</td>
                </tr>
              </table>
            </td>
          </tr>
      </table>

      <div class="div_info">
        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>FECHA EXPORTACIÓN:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center"><b>{{date('Y-m-d')}}</b></td> 
          </tr>               
        </table>
        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>PARTES LIMPIADAS DEL VEHÍCULO</b></td>           
          </tr>               
        </table>

        <table>
          <tr>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">#</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Fecha Servicio</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Barras de Sujeción</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Eleva Vidrios</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Manijas</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Palanca de Cambios</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Cinturón</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Asientos</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Timón</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Paredes</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Superficies Externas</td>
          </tr>
          <?php $cont1 = 1; ?>
          @foreach($documentos as $documento)          
            <tr>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center;"><?php echo '<b>'.$cont1.'</b>' ?> </span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center;">{{$documento->fecha}}</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
            </tr>
            <?php $cont1++; ?>
          @endforeach
        </table>

        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>EPP UTILIZADOS</b></td>           
          </tr>               
        </table>

        <table>
          <tr>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">#</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Fecha Servicio </td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Tapabocas? </td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Bayetas de Tela?</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Alcohol?</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Agua y Detergente?</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">Desinfectante Líquido</td>
          </tr>
          <?php $cont2 = 1; ?>
          @foreach($documentos as $documento)          
            <tr>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center;"><?php echo '<b>'.$cont2.'</b>' ?></span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center;">{{$documento->fecha}}</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px">
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center"> 
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px"><br>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center"> 
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px"><br>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center"> 
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px"><br>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center"> 
                <img src="biblioteca_imagenes/check-icon.png" align="center" width="15px" height="15px"><br>
              </td>
            </tr>
            <?php $cont2++; ?>
          @endforeach
        </table>
      
        <table style="margin-top: 30px; width: 100%">
          <tr>
            <td style="width: 80px; font-size: 12px">Responsable:</td>
            <td style="border-bottom: 1px solid #5a5a5a; width: 300px;">{{$nombre_conductor}}</td>
            <td style="width: 110px; font-size: 12px">Tipo de Vehiculo:</td>
            <td style="border-bottom: 1px solid #5a5a5a; width: 100%">{{$tipo_vehiculo}}</td>
            <td style="width: 35px; font-size: 12px">Placa:</td>
            <td style="border-bottom: 1px solid #5a5a5a; width: 100%">{{$placa}}</td>
          </tr>
      </table>
      </div>      

</body></html>
