<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600" rel="stylesheet">
    <style>

      body{
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
      }

      .title-table{
        padding: 10px;
        background: #F47321;
        color: white;
        text-align: center;
        font-size: 12px;
        font-weight: 500;
      }

      #servicios tbody td, #pasajeros tbody td{
        background: #DDDDDD;
        padding: 10px;
        text-align: center
      }

      .number_table{
        width: 10px;
        background: #a5a5a5 !important;
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

    </style>
  </head>
  <body>
      <table style="width:100%;table-layout:auto;empty-cells:show; border: 1px solid #5a5a5a; border-collapse: collapse; margin-bottom: 30px;">
        <tbody>
          <tr>
            <td width="20" style="padding: 20px; border-right: 1px solid #5a5a5a;"><img width="120" src="biblioteca_imagenes/logos.png"></td>
            <td width="280" align="center">Formato</br> Constancia de Prestación de Servicios</td>
            <td width="120">
              <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Codigo</td>
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">FM-CM-12</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;">Version</td>
                  <td align="center" style="border-bottom: 1px solid black;">2</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-collapse: collapse; padding: 5px;">Fecha</td>
                  <td align="center">07/07/2017</td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>

      <div id="client">
        <div class="to"><span style="color: #F47321">Empresa Solicitante:</span> Masterfoods Colombia</div>
        <div class="address"><span style="color: #F47321">Fecha:</span> 2018-08-25</div>
        <div class="email"><span style="color: #F47321">Ciudad:</span> Barranquilla</div>
      </div>

      <table>
        <tbody>
          <tr>
            <td style="padding: 5px;">Nombre Pasajero(s):</td>
          </tr>
        </tbody>
      </table>

      <table id="pasajeros" style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse; margin-bottom: 30px;">
        <tbody>
          <tr>
            <td class="number_table">1</td>
            <td class="pax_name_table" style="padding: 5px;">
              Michell Jose Gutierrez Rincon
            </td>
            <td class="number_table">2</td>
            <td class="pax_name_table" style="padding: 5px;">
              Alejandro Gomez Castro
            </td>
          </tr>
          <tr>
            <td class="number_table">3</td>
            <td class="pax_name_table" style="padding: 5px;">
              Jorge Luis Zapata
            </td>
            <td class="number_table">4</td>
            <td class="pax_name_table" style="padding: 5px;">
              Maria Andrea Jimenez
            </td>
          </tr>
        </tbody>
      </table>


      <table>
        <tbody>
          <tr>
            <td style="padding: 5px;">Detalles del servicio</td>
          </tr>
        </tbody>
      </table>

      <table id="servicios" style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse;">
        <thead>
          <tr>
            <th class="title-table" style="border-right: 1px solid white; width: 80px"><strong>FECHA</strong></th>
            <th class="title-table" style="border-right: 1px solid white; width: 50px"><strong>HORA INICIO</strong></th>
            <th class="title-table" style="border-right: 1px solid white; width: 50px"><strong>HORA FINALIZACION</strong></th>
            <th class="title-table"><strong>DESCRIPCION</strong></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="border-right: 1px solid white">2017-05-20</td>
            <td style="border-right: 1px solid white">05:30</td>
            <td style="border-right: 1px solid white">07:50</td>
            <td>Planta a casa</td>
          </tr>
        </tbody>
      </table>

      <!--<table style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse;">
        <tbody>
          <tr>
            <td style="padding: 5px; width: 130px;">
              Conductor Asignado:
            </td>
            <td style="padding: 5px; width: 130px;">Cristobal Beleño</td>
            <td style="padding: 5px; width: 110px;">
              Tipo de Vehiculo:
            </td>
            <td style="padding: 5px; width: 90px;">Automovil</td>
            <td style="padding: 5px; width: 40px;">
              Placa:
            </td>
            <td style="padding: 5px; width: 60px;">ARF456</td>
          </tr>
        </tbody>
      </table>
      <table style="width:100%;table-layout:auto;empty-cells:show; border-collapse: collapse;">
        <tbody>
          <tr>
            <td style="padding: 5px; width: 135px;">
              Calidad del servicio:
            </td>
            <td style="padding: 5px; width: 50px;">Excelente</td>
            <td style="padding: 5px; width: 50px;">x</td>
            <td style="padding: 5px; width: 45px;">Bueno</td>
            <td style="padding: 5px; width: 50px;">x</td>
            <td style="padding: 5px; width: 50px;">Regular</td>
            <td style="padding: 5px; width: 50px;">x</td>
            <td style="padding: 5px; width: 35px;">Malo</td>
            <td style="padding: 5px; width: 50px;">x</td>
          </tr>
        </tbody>
      </table>-->
  </body>
</html>
