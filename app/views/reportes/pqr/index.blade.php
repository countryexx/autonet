<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title>PDF</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">



    div.inline { float:center; }

    .headerinfo {
        padding-left: 0px;
        width: 100%;
        margin-left: 20px;
      }

      .contain er-left {
        display: flex;
        margin: 15px 0px;
      }

      .headerinfo-cajas {
        overflow: hidden;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-right: 30px;
        position: relative;
        display: inline-block;
      }

      .headerinfo-cajas__titulo {
        color: black;
        font-size: 18px;
      }

      .headerinfo-cajas__titulo-center {
        color: black;
        font-size: 18px;
        text-align: center;
      }

      .headerinfo-cajas__subtitulo {
        color: #796f6a;
        font-size: 12px;
      }

      .headerinfo-cajas__subtitulo-2 {
        font-size: 15px;
      }

      .iconos {
        display: flex;
        flex-direction: column;
      }

      .headerinfo-cajas__icon {
        width: 15px;
        height: 15px;
        margin-bottom: 10px;
      }

      #container {
        position:relative;
      }

      #img2 {
          position: absolute;
          left: 50px;
          top: 50px;
      }

      body {
       font-family: sans-serif;
    }
    </style>
  </head><body>

    <div class="container">

    <table border="1" cellspacing="1" width="100%">
      <tr>
        <td rowspan="3" colspan="3" style="text-align: center; font-size: 40px; width: 60px" align="center">
          <img style="padding-left: 20px; padding-right: 20px" src="biblioteca_imagenes/logo_excel.png" >
        </td>

        <td colspan="3" style="text-align: center;" align="center">
          <p style="font-size: 12px">FORMATO</p>
        </td>
        <td colspan="1" style="text-align: center;" align="center">
          <p style="font-size: 12px">Código</p>
        </td>
        <td colspan="3" style="text-align: center;" align="center">
          <p style="font-size: 12px">FM - IT - 61</p>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;" >
          <p style="font-size: 12px">FORMULARIO DE RESPUESTA PQR</p>
        </td>
        <td colspan="1" style="text-align: center;" align="center">
          <p style="font-size: 12px">Versión</p>
        </td>
        <td colspan="3" style="text-align: center;" align="center">
          <p style="font-size: 12px">02</p>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;" align="center">
          <p style="font-size: 12px">GESTIÓN INTEGRAL</p>
        </td>
        <td colspan="1" style="text-align: center;" align="center">
          <p style="font-size: 12px">Fecha</p>
        </td>
        <td colspan="3" style="text-align: center;" align="center">
          <p style="font-size: 12px">12/11/19</p>
        </td>

      </tr>
      <!--<tr>
        <td colspan="12"  style="text-align: center;" align="center"><b>Consecutivo N° 1</b></td>
      </tr>-->

    </table>

    <br><br>

  <!-- INICIO TABLA 1 -->

    <table border="1" cellspacing="1" width="100%">

      <tr>
        <td colspan="8"  style="text-align: left; background: #f47321; color: white" align="center"><b>1. DATOS DEL RECLAMANTE</b></td>
      </tr>
      <tr>
        <td colspan="2"><b>Fecha de solicitud</b></td>
        <td colspan="2" style="text-align: center;">{{$fecha}}</td>
        <td colspan="2" style="text-align: center;"><b>Tipo de Solicitud: </b></td>
        <td colspan="2" style="text-align: center;">{{$tipo_solicitud}}</td>
      </tr>

      <tr><td colspan="8" style="text-align: left" align="center"><b>Organización: </b>{{ucfirst(strtolower($nombres))}}</td></tr>
      <tr><td colspan="8" style="text-align: left" align="center"><b>Solicitante: </b>{{ucfirst(strtolower($solicitante))}}</td></tr>
      <tr><td colspan="8" style="text-align: left" align="center"><b>Dirección: </b>{{$direccion}}</td></tr>
      <tr>
        <td colspan="5" style="text-align: left;" align="center"><b>Ciudad: </b>{{ucfirst(strtolower($ciudad))}}</td>
        <td colspan="3" style="text-align: left;" align="center"><b>Teléfono: </b>{{$telefono}}</td>
      </tr>
      <tr><td colspan="8" style="text-align: left;" align="center"><b>Correo electrónico: </b>{{$email}}</td></tr>
      <tr><td colspan="8" style="text-align: left" align="center">Datos de la persona que actúa en presencia del reclamante (si es aplicable) <br><!--<br><br>NOMBRE: nombre r<br><br> APELLIDO: 1<br><br> DIRECCIÓN: 1<br><br> TELÉFONO: 1<br><br> CORREO: 1--></td></tr>

    </table>

  <!-- FIN TABLA 1 -->
  <br><br>

  <!-- INICIO TABLA 2 -->

  <table border="1" cellspacing="1" width="100%">

    <tr>
      <td colspan="8"  style="text-align: left; background: #f47321; color: white" align="center"><b>2. DESCRIPCIÓN DEL SERVICIO / PRODUCTO</b></td>
    </tr>

    <tr><td colspan="8" style="text-align: left" align="center"><b>Número de referencia del servicio / Producto (Si lo conoce):</b> </td></tr>

    <tr>

      <td colspan="1"><b>Ruta</b></td>
      <td colspan="1" style="text-align: center;">
        @if($ruta=='N/A'){{''}}@else{{$ruta}}@endif</td>
      <td colspan="1"><b>Placa</b></td>
      <td colspan="1" style="text-align: center;">{{$placa}}</td>
      <td colspan="1"><b>Conductor</b></td>
      <td colspan="3" style="text-align: center;"><p style="font-size: 15px">{{ucwords(strtolower($conductor))}}</p></td>
    </tr>

    <tr><td colspan="8" style="text-align: left" align="center"><b>Descripción: </b> {{$info2}}</td></tr>
    @if($tiposerv==='EJECUTIVO')
      <tr>
        <td colspan="1"><b>EJECUTIVO</b></td>
        <td colspan="1" style="text-align: center;">X</td>
        <td colspan="2"><b>RUTA ENTRADA</b></td>
        <td colspan="1" style="text-align: center;"></td>
        <td colspan="2"><b>RUTA SALIDA</b></td>
        <td colspan="1" style="text-align: center;"></td>
      </tr>
    @elseif($tiposerv==='RUTA ENTRADA')
      <tr>
        <td colspan="1"><b>EJECUTIVO</b></td>
        <td colspan="1" style="text-align: center;"></td>
        <td colspan="2"><b>RUTA ENTRADA</b></td>
        <td colspan="1" style="text-align: center;">X</td>
        <td colspan="2"><b>RUTA SALIDA</b></td>
        <td colspan="1" style="text-align: center;"></td>
      </tr>
    @else
      <tr>
        <td colspan="1"><b>EJECUTIVO</b></td>
        <td colspan="1" style="text-align: center;"></td>
        <td colspan="2"><b>RUTA ENTRADA</b></td>
        <td colspan="1" style="text-align: center;"></td>
        <td colspan="2"><b>RUTA SALIDA</b></td>
        <td colspan="1" style="text-align: center;">X</td>
    </tr>
    @endif


  </table>

  <!-- FIN TABLA 3 -->
  <br><br>

  <!-- INICIO TABLA 3 -->

  <table border="1" cellspacing="1" width="100%">

    <tr>
      <td colspan="8"  style="text-align: left; background: #f47321; color: white" align="center">
        <b>3. RESPUESTA @if($soporte!=null)
        <a style="float: right" target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/pdf/'.$soporte_pdf)}}"> PQR (click para ver)</a>
      @endif
    </b></td>
    </tr>

    <tr>
      <td colspan="2" style="text-align: left" align="center"><b>Fecha de ocurrencia</b></td>
      <td colspan="6" style="text-align: left" align="center"><b> {{$fecha_ocurrencia}}</b></td>
    </tr>
    <tr>
      <td colspan="8" style="text-align: left;" align="center"> <b style="margin-left: 10px;">Descripción: </b> <p style="text-align: justify; font-size: 13px; margin-left: 10px; margin-right: 10px">

        <?php
        $order   = array("\n", "\r");
        $replace = '<br />';
        $str = str_replace($order, $replace, $info);

        ?>
        {{$str}}
      </p> </td>
    </tr>

  </table>
  <br><br>

  <!-- FIN TABLA 3 -->

  <!-- INICIO TABLA 4 -->

    <table border="1" cellspacing="1" width="100%">

      <tr>
        <td colspan="8"  style="text-align: left; background: #f47321; color: white" align="center"><b>4. ADJUNTOS</b></td>
      </tr>
      <tr>
        <td colspan="8" style="text-align: left" align="center"><b>Lista de los documentos soporte</b></td>
      </tr>
      @if($archivos!=null)
        <?php $sw = 1; ?>
        @foreach(json_decode($archivos) as $file)
        <tr>
          <td colspan="8" style="text-align: left;" align="center">{{$sw}}. <a target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/soportes/'.$file->archivos)}}">{{$file->archivos}}</a></td>
        </tr>
        <?php $sw++; ?>
        @endforeach
      @endif


  </table>

  <!-- FIN TABLA 4 -->

  <!-- versión con imagenes -->
  <!--<div style="page-break-after: always; margin-bottom: 30px"></div>
  <table border="1" cellspacing="1" width="100%">

      <tr>
        <td colspan="8"  style="text-align: left; background: #f47321; color: white" align="center"><b>4. ADJUNTOS</b></td>
      </tr>
      <tr>
        <td colspan="8" style="text-align: left" align="center"><b>LISTA DE LOS DOCUMENTOS SOPORTE</b></td>
      </tr>
      @if($archivos!=null)
        <?php $sw = 1; ?>
        @foreach(json_decode($archivos) as $file)
        <tr>
          <td colspan="8" style="text-align: left;" align="center">{{$sw}}. <a target="_blank" href="{{url('biblioteca_imagenes/reportes/pqr/soportes/'.$file->archivos)}}">{{$file->archivos}}</a></td>
        </tr>
        <?php $sw++; ?>
        @endforeach
      @endif

  </table>

  @if($archivos!=null)
    <?php $sws = 1; ?>
    @foreach(json_decode($archivos) as $file)
      <img style="position: relative; width: 49%; height: 0; padding-bottom: 20%; margin-top: 12px" src="{{'biblioteca_imagenes/reportes/pqr/soportes/'.$file->archivos}}" alt="" >
      <?php $sws++; ?>
    @endforeach
  @endif-->
</div>

  </body></html>
