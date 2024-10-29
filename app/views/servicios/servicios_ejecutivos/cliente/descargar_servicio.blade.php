<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>Orden # {{$servicio->id}}</title>
    
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

    <div class="div_info" style="border-top: 1px solid">

    <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
  <tr>
    <td style="padding: 0;" align="center">
      <table cellpadding="0" cellspacing="0" role="presentation" width="100%">
        <tr>
          <td class="col" width="850" style="padding: 0;">

            <table cellspacing="0" id="table_detalle_solicitud" style="width: 60%;" border="1">
                
                    <tr>
                        <td colspan="4" class="sans-serif p-general" style="color: black; font-size: 12px; padding: 10px">
                            <h4>Foto del Conductor</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                        <img class="foto_conductor" src="biblioteca_imagenes/proveedores/conductores/{{$servicio->foto}}" alt="" style="width: 180px; height: 50%; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;">
                        </td>
                    </tr>
                    <tr bgcolor="#f98006" style="margin-top: 15px">
                        <th width="70" class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">FECHA</th>
                        <th width="70" class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">HORA</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">RECOGER EN</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">LLEVAR A</th>                                  
                    </tr>
                
                    <!-- inicio foreach-->
                    <tr bgcolor="#EFEFEF">
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->fecha_servicio}}
                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->hora_servicio}}
                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->recoger_en}}
                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->dejar_en}}
                        </td>
                    </tr>
                  <!-- fin foreach-->
            </table>
            <br><br>
           
            <table cellspacing="0" id="table_detalle_solicitud" style="width: 60%;" border="1">
                
                    <tr bgcolor="#f98006">                                   
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">INFORMACIÓN DEL CONDUCTOR</th>
                        <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">INFORMACIÓN DEL VEHICULO</th>
                    </tr>
                
                  <!-- inicio foreach-->
                    <tr bgcolor="#EFEFEF">                
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->cc}} /{{$servicio->nombre_completo}} / {{$servicio->celular}}
                        </td>
                        <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                            {{$servicio->clase}} / {{$servicio->placa}} / {{$servicio->marca}} / {{$servicio->modelo}}
                        </td>                                      
                    </tr>
                  <!-- fin foreach-->
            </table>

            @if($servicio->origen!=null)
                <br><br>
                <table cellspacing="0" id="table_detalle_solicitud" style="width: 60%;" border="1">
                    
                        <tr bgcolor="gray">
                            <th class="sans-serif p-general" colspan="6" style="color: white; font-size: 12px; padding: 10px">ITINERARIO</th>
                        </tr>
                        <tr bgcolor="#f98006">
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">ORIGEN</th>
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">DESTINO</th>
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">AEROLINEA</th>
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">VUELO</th>
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">HORA SALIDA</th>
                            <th class="sans-serif p-general" style="color: white; font-size: 12px; padding: 10px">HORA LLEGADA</th>
                        </tr>
                    
                    <!-- inicio foreach-->
                        <tr>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->origen}}
                            </td>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->destino}}
                            </td>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->aerolinea}}
                            </td>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->vuelo}}
                            </td>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->hora_salida}}
                            </td>
                            <td class="sans-serif p-general" style="color: #353535; font-size: 12px; padding: 10px; text-align: center;">
                                {{$servicio->hora_llegada}}
                            </td>
                        </tr>
                    <!-- fin foreach-->
                </table>
            @endif
            <br>
          </td>
        </tr>
    </table>
        <br>

      
    </div>

</body></html>
