<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>Código QR</title>
    
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
                   <td align="center"><b>CÓDIGO QR</b> <br> GESTIÓN OPERATIVA</td>
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
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">FM-OP-21</td>
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

        <table style="margin-top: 30px; width: 100%">
          <tr>
            <td>
              <img src="biblioteca_imagenes/codigosqr/{{$dato->cedula}}.png" width="180px" height="140px" align="left">
            </td>
          </tr>
          <tr>
            <td>
              <h4>Datos del Usuario</h4>
            </td>
          </tr>
          <tr>
            <td style="font-size: 12px">Nombre:</td>
            <td style="border-bottom: 1px solid #5a5a5a;">{{$dato->nombres}} {{$dato->apellidos}}</td>
          </tr>
          <tr>
            <td style="font-size: 12px">Cédula:</td>
            <td style="border-bottom: 1px solid #5a5a5a;">{{$dato->cedula}}</td>
          </tr>
          <tr>
            <td style="font-size: 12px">Dirección:</td>
            <td style="border-bottom: 1px solid #5a5a5a;">{{$dato->direccion}}</td>
          </tr>
          <tr>
            <td style="font-size: 12px">Barrio:</td>
            <td style="border-bottom: 1px solid #5a5a5a;">{{$dato->barrio}}</td>
          </tr>
          <tr>
            <td style="font-size: 12px">Empresa:</td>
            <td style="border-bottom: 1px solid #5a5a5a;">{{$centro}}</td>
          </tr>
            
        </table>

        <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
    <br>
    <h3>Conductas dentro del vehículo:</h3>

    <ul>
      <li style="text-align: justify;">NO fumar (incluidos cigarrillos electrónicos)</li>
      <li style="text-align: justify;">NO tener sus dispositivos de audio o celulares sin auricular, recuerde respetar a los demás.</li>
      <li style="text-align: justify;">NO consumir Alimentos o bebidas dentro del vehículo.</li>
      <li style="text-align: justify;">Los elementos que generen basura deben ser depositado en los respectivos basureros dentro del vehículo (Si aplica) o en su defecto antes de subir a él.</li>
      <li style="text-align: justify;">Recuerde mantener el cinturón de seguridad en todo momento dentro del vehículo.</li>
      <li style="text-align: justify;">NO quedarse en los corredores o pasillos.</li>
      <li style="text-align: justify;">NO subir los pies en los asientos.</li>
      <li style="text-align: justify;">NO obstaculizar los pasillos o corredores.</li>
      <li style="text-align: justify;">NO escriba ni dañe el tapizado de la silletería.</li>
      <li style="text-align: justify;">Respetar al conductor y los demás pasajeros.</li>
      <br><br>
      <center>
      <h3 style="color: orange">EL RESPETO NOS UNE, AOTOUR NOS MUEVE.</h3>
      </center>
    </ul><br>
      </div>      

</body></html>
