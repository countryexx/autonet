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
    </style>
  </head><body>

  <?php
    /*$consecutivo = 1234;
    $asunto = 'PRUEBA';
    $nombre_completo = 'AGENCIA DE VIAJES Y TURISMO AVIATUR';
    $fecha = '2023-06-13';*/

  ?>
  <!--@if($cantidad==3)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 50px">
  @elseif($cantidad<=2)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 60px">
  @elseif($cantidad>=5)
    <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; padding-bottom: 100px">
  @endif-->
  <div class="container-fluid" style="border: 1px solid gray; border-radius: 20px; height: 1010px">
    <center>
      <table style="width: 100%">

          <tr>
            <th style="color: white; padding: 5px; width: 49%; text-align: center; float: right;">
              <img src="img/logo_aotour.png" width="200px" height="50px" style="margin-top: 10px; margin-right: -80px">
            </th>
            <th style="color: white; padding: 5px; text-align: center; vertical-align: middle;"><img src="img/raya.png" width="15px" height="110px" style="margin-top: 10px"></th>
            <th style="padding: 5px; width: 49%; text-align: left;">
              <!--<p style="float: left; font-family: sans-serif">Contacto: Jhonnys Ojeda Soto<br>Tel: (+57) 3013869946<br>Email: comercial@aotour.com.co</p>-->
              <p style="font-family: sans-serif;"><b style="font-size: 11px">Contacto:</b> <span style="font-size: 9px">{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}</span></p>
              <p style="font-family: sans-serif;"><b style="font-size: 11px">Tel:</b> <span style="font-size: 9px">(+57) {{$telefono}}</span></p>
              <p style="font-family: sans-serif;"><b style="font-size: 11px">Email:</b> <span style="font-size: 9px">{{$email}}</span></p>
            </th>
          </tr>


      </table>
      @if($cantidad<=9)
        <br>
      @endif
      <span style="font-family: sans-serif; font-size: 18px;">Cotización N° {{$consecutivo}}</span>
    </center>
    @if($cantidad<=6)
      <br><br>
    @endif
    <br>
    <center><strong style="font-size: 22px; font-family: sans-serif">{{$asunto}}
      @if($cantidad<=6)
        <br>
      @endif
    </strong><br><p style="font-size: 15px; font-family: sans-serif">{{ucwords(strtolower($nombre_completo))}}</p></center><!-- Fecha del evento -->

    @if($no_mostrar=='checked')
      <br><br>
    @else
      @if($cantidad<=6)
        <br>
      @endif
      <center><p style="font-family: sans-serif; font-size: 15px;">Total cotización: $ {{number_format($total)}}</p></center>
    @endif

    <!--@if($cantidad<=5)
      <br>
    @endif-->

    <center>

      <table class="table" style="width: 98%; margin-left: 30px">

          <tr >
            <!--<th>Fecha</th>-->
            <th style="font-family: sans-serif; width: 12%; text-align: left">Ciudad</th>
            <th style="font-family: sans-serif; width: 12%; text-align: center">Fecha</th>
            <th style="font-family: sans-serif; width: 12%; text-align: left">Traslado</th>
            <th style="font-family: sans-serif; width: 12%;">Vehículo</th>
            <th style="font-family: sans-serif; width: 12;">Cant</th>
            <th style="font-family: sans-serif; width: 12%;">Pax</th>
            <th style="font-family: sans-serif; width: 12%;">Valor/u</th>
            <th style="font-family: sans-serif; width: 16%;">Total</th>
          </tr>

          @foreach($detalles as $detalle)
            <?php
              $fech = explode('-', $detalle->fecha_servicio);
              $mes = $fech[1];
              if($mes==='01'){
                $mes = 'ENE';
              }else if($mes==='02'){
                $mes = 'FEB';
              }else if($mes==='03'){
                $mes = 'MAR';
              }else if($mes==='04'){
                $mes = 'ABR';
              }else if($mes==='05'){
                $mes = 'MAY';
              }else if($mes==='06'){
                $mes = 'JUN';
              }else if($mes==='07'){
                $mes = 'JUL';
              }else if($mes==='08'){
                $mes = 'AGO';
              }else if($mes==='09'){
                $mes = 'SEP';
              }else if($mes==='10'){
                $mes = 'OCT';
              }else if($mes==='11'){
                $mes = 'NOV';
              }else if($mes==='12'){
                $mes = 'DIC';
              }
              $dats =  $fech[2].'-'. $mes.'-'.substr($fech[0], -2);
            ?>
            <tr style="border: 1px solid; margin-left: 20px">
      				<!--<td>{{$detalle->fecha_servicio}}</td>-->
              <td style="font-size: 9px; font-family: sans-serif;">{{$detalle->ciudad}}</td>
              <td style="font-size: 11px; font-family: sans-serif; text-align: center;">{{$dats}}</td>
      				<td style="font-size: 8px; font-family: sans-serif; text-align: left">{{$detalle->tipo_servicio}}</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif; text-align: center;">{{$detalle->tipo_vehiculo}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif; text-align: center;">{{$detalle->vehiculos}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">{{$detalle->pax}}</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif;">$ {{number_format($detalle->valorxvehiculo)}}</td>
      				<td align="center" style="font-size: 11px; font-family: sans-serif; width: 16%">$ {{number_format($detalle->valortotal)}}</td>
      			</tr>

          @endforeach
      </table>

    </center>

    <br>

    @if($cantidad <= 10)
      <footer>

        <center>

          <div style="padding-top: 3px; margin-top: 2px !important; !important;">
              <div style="font-family: arial; text-align: center">
                <div style="display: inline-block; width: 100%; !important; font-family: sans-serif; font-size: 11px; text-align: justify">
                  @if($observaciones!=null and $observaciones!='')
                    <p style="margin-left: 40px;"><b style="text-decoration: underline">Nota</b>: {{ucfirst(strtolower($observaciones))}}.</p>
                  @endif

                  <p style="margin-left: 40px"><b>Esta cotización tiene vigencia de 30 días.</b> <!--- Fecha de solicitud: {{strtolower($fecha)}}--></p>
                  <p style="margin-left: 40px">Fecha de solicitud: {{$fecha}}, solicitado por <a style="color: black" target="_blank" href="{{url('biblioteca_imagenes/archivos_cotizaciones/'.$soporte)}}"><b>{{$contacto}}</b></a>.</p>
                  <br>

                  <p style="margin-left: 40px; margin-right: 55px"><b>ESPECIFICACIONES TÉCNICAS.</b> Conformidad con la ley 769 del 2002 y código nacional de tránsito en todo concerniente a especificaciones técnicos mecánicas,
                    ambientales, de peso, dimisiones, de comodidad y seguridad. Modeló de vehículos recientes / full equipo. Vehículos climatizados. Seguros obligatorios.
                    <br><b>POLÍTICAS DE SERVICIOS:</b> Atención al cliente 24 horas. Aplica tarifa mínima equivalente a dos horas en servicio a disposición. Aplica tarifa de tiempo de
                    espera, a partir de 15 minutos de acuerdo a la hora programada para dar inicio al servicio. Estas tarifas no aplican para eventos municipales y nacionales,
                    eventos de alteración de orden público. La tarifa nocturna comienza a aplicarse a partir de las 18 horas. La tarifa correspondiente al día a disposición no
                    incluye traslado al aeropuerto. La tarifa de traslado intermunicipales corresponde exclusivamente a trayectos comprendidos entre punto de recogida y punto
                    de destino. La cancelación de servicio locales, deben efectuarse por escrito y con tiempo previo mínimo-igual a dos horas de la establecida para la recogida
                    en el punto de origen, en caso de tratarse un servicio intermunicipal, el tiempo mínimo es de 6 horas. La no cancelación oportuna del servicio genera
                    facturación y cobro del 100% del valor acordado. Las tarifas de servicio Aeropuerto no incluyen protocolo de recepción. Las tarifas son objetos de revisión y
                    modificación, de acuerdo a las temporadas especiales. La vigencia de tarifas: 31 de diciembre del 2023.</p>
                </div>

              </div>
              <br>
              <p  style="font-family: sans-serif; font-size: 12px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p>
              @if($cantidad<=8)
                <br><br>
              @endif
              <span style="font-family: sans-serif">www.aotour.com.co</span>
          </div>
        </center>

      </footer>
    @endif

    @if($cantidad>10)
    <div style="page-break-after: always; margin-bottom: 30px"></div>
      <footer>
        <p style="margin-left: 60px"><b>{{$observaciones}}.</b></p>
        <center>
          <br>
          <div style="padding-top: 3px; margin-top: 2px !important; !important;">
              <div style="font-family: arial; text-align: center">
                <div style="display: inline-block; width: 90%; !important; font-family: sans-serif; font-size: 11px; text-align: justify">
                  <p style="margin-left: 60px"><b>Esta cotización tiene vigencia de 30 días.</b></p>
                  <br>

                  <p style="margin-left: 60px"><b>ESPECIFICACIONES TÉCNICAS.</b> Conformidad con la ley 769 del 2002 y código nacional de tránsito en todo concerniente a especificaciones técnicos mecánicas,
                    ambientales, de peso, dimisiones, de comodidad y seguridad. Modeló de vehículos recientes / full equipo. Vehículos climatizados. Seguros obligatorios.
                    <br><b>POLÍTICAS DE SERVICIOS:</b> Atención al cliente 24 horas. Aplica tarifa mínima equivalente a dos horas en servicio a disposición. Aplica tarifa de tiempo de
                    espera, a partir de 15 minutos de acuerdo a la hora programada para dar inicio al servicio. Estas tarifas no aplican para eventos municipales y nacionales,
                    eventos de alteración de orden público. La tarifa nocturna comienza a aplicarse a partir de las 18 horas. La tarifa correspondiente al día a disposición no
                    incluye traslado al aeropuerto. La tarifa de traslado intermunicipales corresponde exclusivamente a trayectos comprendidos entre punto de recogida y punto
                    de destino. La cancelación de servicio locales, deben efectuarse por escrito y con tiempo previo mínimo-igual a dos horas de la establecida para la recogida
                    en el punto de origen, en caso de tratarse un servicio intermunicipal, el tiempo mínimo es de 6 horas. La no cancelación oportuna del servicio genera
                    facturación y cobro del 100% del valor acordado. Las tarifas de servicio Aeropuerto no incluyen protocolo de recepción. Las tarifas son objetos de revisión y
                    modificación, de acuerdo a las temporadas especiales. La vigencia de tarifas: 31 de diciembre del 2023.</p>
                </div>

              </div>
              <br>
              <p  style="font-family: sans-serif; font-size: 12px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p><br>
              <span style="font-family: sans-serif">www.aotour.com.co</span>
          </div>
        </center>

      </footer>
    @endif
    <?php

    $cotizacion = DB::table('cotizaciones')
    ->where('id',$consecutivo)
    ->first();

    ?>
</div>

<!--
    @if($cotizacion->archivos1!=null)
      <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="height: 1005px; border: 1px solid gray; margin-top: 5px">

        @foreach(json_decode($cotizacion->archivos1) as $file)
          <?php $name = $file->desv1; ?>
        @endforeach

      <center><strong style="font-size: 45px; font-family: sans-serif; margin-top: 30px; margin-bottom: 70px; color: #f47321"><br>{{$name}}</strong></center>

        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos1) as $file)
        <table style="width: 100%">
            <tr>
              <th style="color: white; padding: 5px; width: 25%; text-align: center;">



              </th>
              <th align="center" style="width: 45%; padding: 5px; color: white; text-align: center; vertical-align: middle;">

                <div style="border-radius: 10px;">
                  @if($sw1==2)
                    <div id="container" style="margin-top: 40px">
                  @else
                    <div id="container" style="margin-top: 70px">
                  @endif

                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img1" style="margin-left: -15px; width: 350px; height: 230px; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41);"/>

                  </div>
                </div>

              </th>
              <th style="padding: 5px; width: 30%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach
        <br><br><br>
        <center>

          <table style="width: 95%;" style="margin-left: 25px">
              <tr style="border: 1px solid gray; margin-left: 15px">
                <th style="padding: 5px; width: 4%; text-align: center; vertical-align: middle; margin-left: 25px">

                </th>
                <th style="padding: 5px; width: 30%; text-align: center; vertical-align: middle; border: 1px solid gray; margin-left: 25px">
                  <p style="font-family: sans-serif; font-weight: normal;"><img src="img/log.png" alt="" style="height: 30px; width: 30px"> {{$file->c1}}</p>
                </th>
                <th style="width: 33%; padding: 5px; text-align: center; vertical-align: middle; border: 1px solid gray">
                  <p style="font-family: sans-serif; font-weight: normal;"><img src="img/log.png" alt="" style="height: 30px; width: 30px"> {{$file->c2}}</p>
                </th>
                <th style="width: 30%; text-align: center; vertical-align: middle; border: 1px solid gray">
                  <p style="font-family: sans-serif; font-weight: normal;"><img src="img/log.png" alt="" style="height: 30px; width: 30px"> {{$file->c3}}</p>
                </th>
              </tr>
          </table>
          <br>
          <p  style="font-family: sans-serif; font-size: 12px; margin-top: 20px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p><br>
          <span style="font-family: sans-serif">www.aotour.com.co</span>
        </center>

      </div>
    @endif-->

    <!-- Vehiculo 2 -->
    <!--
    @if($cotizacion->archivos2!=null)
    <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="height: 1005px; border: 1px solid gray; margin-top: 5px">

        @foreach(json_decode($cotizacion->archivos2) as $file)
          <?php $name = $file->desv2; ?>
        @endforeach

      <center><strong style="font-size: 45px; font-family: sans-serif; margin-top: 30px; margin-bottom: 70px; color: #f47321"><br>{{$name}}</strong></center>

        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos2) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 25%; text-align: center;">



              </th>
              <th align="center" style="width: 45%; padding: 5px; color: white; text-align: center; vertical-align: middle;">

                <div style="border-radius: 10px;">
                  @if($sw1==2)
                    <div id="container" style="margin-top: 40px">
                  @else
                    <div id="container" style="margin-top: 70px">
                  @endif

                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img1" style="margin-left: -15px; width: 350px; height: 230px; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41);"/>

                  </div>
                </div>

              </th>
              <th style="padding: 5px; width: 30%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach
        <br><br><br>
        <center>

          <table style="width: 100%" >
              <tr>
                <th style="padding: 5px; width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">1</b>.{{$file->c1}}</p>
                </th>
                <th style="width: 33%; padding: 5px; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">2</b>.{{$file->c2}}</p>
                </th>
                <th style="width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">3</b>.{{$file->c3}}</p>
                </th>
              </tr>
          </table>

        </center>

      </div>
    @endif
-->
    <!-- Vehiculo 3 -->
    <!--
    @if($cotizacion->archivos3!=null)
    <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="height: 1005px; border: 1px solid gray; margin-top: 5px">

        @foreach(json_decode($cotizacion->archivos3) as $file)
          <?php $name = $file->desv3; ?>
        @endforeach

      <center><strong style="font-size: 45px; font-family: sans-serif; margin-top: 30px; margin-bottom: 70px; color: #f47321"><br>{{$name}}</strong></center>

        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos3) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 25%; text-align: center;">



              </th>
              <th align="center" style="width: 45%; padding: 5px; color: white; text-align: center; vertical-align: middle;">

                <div style="border-radius: 10px;">
                  @if($sw1==2)
                    <div id="container" style="margin-top: 40px">
                  @else
                    <div id="container" style="margin-top: 70px">
                  @endif

                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img1" style="margin-left: -15px; width: 350px; height: 230px; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41);"/>

                  </div>
                </div>

              </th>
              <th style="padding: 5px; width: 30%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach
        <br><br><br>
        <center>

          <table style="width: 100%" >
              <tr>
                <th style="padding: 5px; width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">1</b>.{{$file->c1}}</p>
                </th>
                <th style="width: 33%; padding: 5px; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">2</b>.{{$file->c2}}</p>
                </th>
                <th style="width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">3</b>.{{$file->c3}}</p>
                </th>
              </tr>
          </table>

        </center>

      </div>
    @endif
-->
    <!-- Vehiculo 4 -->
    <!--
    @if($cotizacion->archivos4!=null)
    <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="height: 1005px; border: 1px solid gray; margin-top: 5px">

        @foreach(json_decode($cotizacion->archivos4) as $file)
          <?php $name = $file->desv4; ?>
        @endforeach

      <center><strong style="font-size: 45px; font-family: sans-serif; margin-top: 30px; margin-bottom: 70px; color: #f47321"><br>{{$name}}</strong></center>

        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos4) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 25%; text-align: center;">



              </th>
              <th align="center" style="width: 45%; padding: 5px; color: white; text-align: center; vertical-align: middle;">

                <div style="border-radius: 10px;">
                  @if($sw1==2)
                    <div id="container" style="margin-top: 40px">
                  @else
                    <div id="container" style="margin-top: 70px">
                  @endif

                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img1" style="margin-left: -15px; width: 350px; height: 230px; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41);"/>

                  </div>
                </div>

              </th>
              <th style="padding: 5px; width: 30%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach
        <br><br><br>
        <center>

          <table style="width: 100%" >
              <tr>
                <th style="padding: 5px; width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">1</b>.{{$file->c1}}</p>
                </th>
                <th style="width: 33%; padding: 5px; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">2</b>.{{$file->c2}}</p>
                </th>
                <th style="width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">3</b>.{{$file->c3}}</p>
                </th>
              </tr>
          </table>

        </center>

      </div>
    @endif
-->
    <!-- Vehiculo 5 -->
    <!--
    @if($cotizacion->archivos5!=null)
    <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="height: 1005px; border: 1px solid gray; margin-top: 5px">

        @foreach(json_decode($cotizacion->archivos5) as $file)
          <?php $name = $file->desv5; ?>
        @endforeach

      <center><strong style="font-size: 45px; font-family: sans-serif; margin-top: 30px; margin-bottom: 70px; color: #f47321"><br>{{$name}}</strong></center>

        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos5) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 25%; text-align: center;">



              </th>
              <th align="center" style="width: 45%; padding: 5px; color: white; text-align: center; vertical-align: middle;">

                <div style="border-radius: 10px;">
                  @if($sw1==2)
                    <div id="container" style="margin-top: 40px">
                  @else
                    <div id="container" style="margin-top: 70px">
                  @endif

                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img1" style="margin-left: -15px; width: 350px; height: 230px; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41);"/>

                  </div>
                </div>

              </th>
              <th style="padding: 5px; width: 30%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach
        <br><br><br>
        <center>

          <table style="width: 100%" >
              <tr>
                <th style="padding: 5px; width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">1</b>.{{$file->c1}}</p>
                </th>
                <th style="width: 33%; padding: 5px; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">2</b>.{{$file->c2}}</p>
                </th>
                <th style="width: 33%; text-align: center; vertical-align: middle;">
                  <p style="font-family: sans-serif; font-weight: normal;"><b style="font-size: 70px; color: #f47321">3</b>.{{$file->c3}}</p>
                </th>
              </tr>
          </table>

        </center>

      </div>
    @endif
-->


    <!--<img style="margin-top: 5px; margin-bottom: 20px" src="img/microbus2.jpeg" width="80%" height="460px" >
    center>-->

</body></html>
