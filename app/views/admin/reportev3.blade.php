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
            <td width="20" style="padding: 20px; border-right: 1px solid #5a5a5a;"><img width="120" src="{{url('biblioteca_imagenes/logos.png')}}"></td>
            <td width="280" align="center">
               <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td align="center" style="border-bottom: 1px solid #5a5a5a;">FORMATO</td>
                </tr>
                <tr>
                   <td align="center" ><br><b style="border-bottom: 1px solid #5a5a5a;">CONTROL DE LIMPIEZA Y DESINFECCIÓN DE VEHÍCULOS</b> <br><br> <b>GESTIÓN OPERATIVA</b></td>
                </tr>
                <tr>
                  <td align="center"></td>
                </tr>
               </table>
            </td>
            <td width="120">
              <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;"><b>Código</b></td>
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">CÓDIGO DE FORMATO</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;"><b>Versión</b></td>
                  <td align="center" style="border-bottom: 1px solid black;"># DE VERSIÓN</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-collapse: collapse; padding: 5px;"><b>Fecha</b></td>
                  <td align="center">FECHA DE CREACIÓN</td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="div_info">
        <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
          <tr>
            <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px"><b>FECHA EXPORTACIÓN:</b></td>
           <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center"><b>{{date('Y-m-d')}}</b></td> 
          </tr>               
        </table>
        <table id="informacion_conductor">
          <tbody>
            <tr>
              <td style="border-bottom: 1px solid #5a5a5a; width: 15px"><b>PARTES LIMPIADAS DEL VEHÍCULO</b></td>              
            </tr>
          </tbody>
        </table>
        <table id="servicios" style="width:100%;">
          <thead>
            <tr style="margin-top: 10px">
              
              <th class="title-table" style="border-right: 1px solid white; width: 20px">BARRAS DE SUJECIÓN</th><!-- BARRAS DE SUJECIÓN -->

              <th class="title-table" style="border-right: 1px solid white; width: 20px">ELEVA VIDRIOS</th><!-- ELEVA VIRIOS -->
              <th class="title-table" style="border-right: 1px solid white; width: 20px">MANIJAS</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">PALANCA DE CAMBIOS</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">CINTURÓN</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">ASIENTOS</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">TIMÓN</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">PAREDES</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">SUP. EXTERN</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">USÓ TAPABOCAS?</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">BAYETAS DE TELA?</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">USÓ ALCOHOL?</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">USÓ AGUA Y DETERGENTE?</th>
              <th class="title-table" style="border-right: 1px solid white; width: 20px">USÓ DESINFECTANTE LÍQUIDO</th>              
            </tr>
          </thead>

          <tbody>
            @if(isset($documentos))
              <?php $contador = 1; ?>
              @foreach($documentos as $limpieza)
                <tr>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->barras_de_sujecion==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->eleva_vidrios==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>              
                  <td style="font-size: 10px">
                    @if($limpieza->manijas==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>              
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->palanca_de_cambios==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->cinturones_de_seguridad==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->asientos==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->timon==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->paredes==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->superficies_externas==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->tapabocas==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->bayetas_de_tela==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->alcohol==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->mezcla_de_agua_y_detergente==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>
                  <td style="border-right: 1px solid white; font-size: 10px">
                    @if($limpieza->desinfectantes_liquidos==1)
                      <input type="checkbox" name="" checked="true" style="background-color: blue">
                    @else
                      <input type="checkbox" name="" disabled style="background-color: blue">
                    @endif
                  </td>                  
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
        <table id="informacion_conductor" style="margin-top: 30px">
          <tbody>
            <tr>
              <td style="width: 105px">Conductor Responsable del Reporte:</td>
              <td style="border-bottom: 1px solid #5a5a5a; width: 155px">SAMUEL DAVID GONZALEZ MENDOZA</td>
              <td style="width: 85px">Tipo de Vehiculo:</td>
              <td style="border-bottom: 1px solid #5a5a5a; width: 85px">DEPORTIVO MERCEDES AMG</td>
              <td style="width: 35px">Placa:</td>
              <td style="border-bottom: 1px solid #5a5a5a; width: 45px">SGM227</td>
            </tr>
          </tbody>
        </table>
      </div>

  </body></html>
