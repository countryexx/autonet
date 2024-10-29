<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>REPORTE DE LIMPIEZA</title>
    
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
            <td width="26" style="padding: 20px; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a;"><img width="150" src="biblioteca_imagenes/logos.png"></td>
            <td width="280" align="center">
               <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td align="center">FORMATO</td>
                </tr>
                <tr>
                   <td align="center">CONTROL DE LIMPIEZA Y DESINFECCIÓN DE VEHÍCULOS <br> GESTIÓN OPERATIVA</td>
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
            <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>FECHA EXPORTACIÓN:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center"><b>{{date('Y-m-d')}}</b></td>
          </tr>
        </table>
        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>PARTES LIMPIADAS DEL VEHÍCULO <i class="fa fa-heart"></i></b></td>
          </tr>
        </table>
        <?php $conductor_anterior = ''; $sw = 0; $ultimafecha = ''; $color1 = 'blue'; $color2 = 'green';?>
        @foreach($documentos as $documento)
        @if($conductor_anterior!=$documento->nombre_conductor)
        <?php 
          $color = $color1;
        ?>
        <table style="margin-top: 25px">
          <tr>
            <td class="title-table" colspan="11" style="border-bottom: 1px solid black; width: 20px; background-color: orange">{{$documento->nombre_conductor}}</td>
          </tr>
          <tr>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px" align="center">#</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 26px">Fecha Servicio</td>
            <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Barras de Sujeción</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Eleva Vidrios</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Manijas</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Palanca de Cambios</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Cinturón</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Asientos</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Timón</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 14px">Paredes</td>
              <td class="title-table" style="border-bottom: 1px solid black; width: 20px">Superficies Externas</td>
          </tr>
          <?php $cont1 = 1; ?>
          @endif
            <tr>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center;"><?php echo $cont1 ?></span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                @if($ultimafecha!=$documento->fecha)
                  @if($color=='blue')
                    <?php $color = 'green';?>
                  @else
                    <?php $color = 'blue';?>
                  @endif
                @endif
                <span style="text-align: center; font-size: 11px; color: <?php echo $color;?>">{{$documento->fecha}}</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
              <td style="text-align: center; border-bottom: 1px solid black;" align="center">
                <span style="text-align: center; font-size: 11px;">Ok</span>
              </td>
            </tr>
            <?php $cont1++; ?>
          @if($conductor_anterior!=$documento->nombre_conductor and $sw==0 and $switch==0)
        </table>
        <br><br>
        <?php $sw = 1; ?>
        @endif
        <?php $conductor_anterior = $documento->nombre_conductor; 
        $ultimafecha = $documento->fecha;?>
        @endforeach
        @if($switch==1)
        </table>
        @endif
      </div>
</body></html>
