<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>RUTAS DEL {{$fecha}}</title>
    
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
      <table style="width: 100%">
            <tr>
            <td><img src="biblioteca_imagenes/logo_excel.png" width="240px" height="90px" align="left" style="float: left;"></td>
            <td>
              <span style="float: right;">RUTAS DEL {{$fecha}}</span>
            </td>
          </tr>
        </table>
      <hr>
      <br>
        <?php $contador = 0;?>
        @foreach($documentos as $documento)          
            @if($contador=='3')          
              <div style="page-break-after: always;"></div>
              <h5 style="text-align: center;">RUTA {{$documento->tipo_ruta}} {{$documento->hora}} - {{$documento->nombre_completo}}</h5>
              <img style="margin-left: 190px" src="biblioteca_imagenes/gestion_documental/{{$documento->id}}.jpeg" width="400px" height="300px" >
              <br>
              <?php $contador=0; ?> 
            @else
              <h5 style="text-align: center;">RUTA {{$documento->tipo_ruta}} {{$documento->hora}} - {{$documento->nombre_completo}}</h5>
              <img style="margin-left: 190px" src="biblioteca_imagenes/gestion_documental/{{$documento->id}}.jpeg" width="400px" height="300px" >
              <br>
            @endif
            <?php $contador++?>
        @endforeach
      <br><br>

</body></html>
