<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <title>PDF</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">

      
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Playfair Display', serif;
}
#header{
  margin:20px;
}
#header>h1{
  text-align:center;
  font-size:3rem;
}
#header>p{
  text-align:center;
  font-size:1.5rem;
  font-style:italic;
}
.container{
  width:100vw;
  display:flex;
  justify-content:space-around;
  flex-wrap:wrap;
  padding:40px 20px;
}
.card{
  display:flex;
  flex-direction:column;
  width:400px;
  margin-bottom:60px;
}
.card>div{
  box-shadow:0 15px 20px 0 rgba(0,0,0,0.5);
}
.card-image{
  width:400px;
  height:250px;
}
.card-image>img{
  width:100%;
  height:100%;
  object-fit:cover;
  object-position:bottom;
}
.card-text{
  margin:-30px auto;
  margin-bottom:-50px;
  height:50px;
  width:250px;
  background-color:#1D1C20;
  color:#fff;
  padding:20px;
}
.card-meal-type{
  font-style:italic;
}

.card-body{
  font-size:1.25rem;
}
.card-price{
  width:40px;
  height:50px;
  background-color:#970C0A;
  color:#fff;
  margin-left:30px;
  font-size:2rem;
  display:flex;
  justify-content:center;
  align-items:center;
}


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

    <center>
      <table style="width: 100%" >

          <tr>
            <th style="color: white; padding: 5px; width: 49%; text-align: center; float: right;">
              <img src="img/logo_aotour.png" width="220px" height="50px" style="margin-top: 10px; margin-right: -80px">
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
      <br>
      <span style="font-family: sans-serif; font-size: 18px;">Cotización N° {{$consecutivo}}</span>
    </center>
    @if($cantidad<=6)
      <br>
    @endif
    <br>
    <center><strong style="font-size: 22px; font-family: sans-serif">{{$asunto}}
      @if($cantidad<=6)
        <br>
      @endif
    </strong><br><p style="font-size: 15px; font-family: sans-serif">{{ucfirst(strtolower($nombre_completo))}} - {{strtolower($fecha)}}</p></center>

    <center><p style="font-family: sans-serif; font-size: 15px;">Total cotización: $ {{number_format($total)}}</p></center>

    @if($cantidad<=5)
      <br>
    @endif

    <center>

      <table class="table" style="width: 90%; margin-left: 30px">

          <tr >
            <!--<th>Fecha</th>-->
            <th style="font-family: sans-serif">Traslado</th>
            <th style="font-family: sans-serif">Ciudad</th>
            <th style="font-family: sans-serif">Vehículo</th>
            <th style="font-family: sans-serif">No. Pax</th>
            <th style="font-family: sans-serif">Valor/u</th>
            <th style="font-family: sans-serif">Valor total</th>
          </tr>

          @foreach($detalles as $detalle)

            <tr style="border: 1px solid; margin-left: 20px">
              <!--<td>{{$detalle->fecha_servicio}}</td>-->
              <td align="center" style="font-size: 11px; font-family: sans-serif; margin-left: 40px">{{$detalle->tipo_servicio}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">{{$detalle->ciudad}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">{{$detalle->tipo_vehiculo}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">{{$detalle->pax}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">$ {{number_format($detalle->valorxvehiculo)}}</td>
              <td align="center" style="font-size: 11px; font-family: sans-serif;">$ {{number_format($detalle->valortotal)}}</td>
            </tr>

          @endforeach
      </table>

    </center>

    <br>

    @if($cantidad <= 10)
      <footer>

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
              <p  style="font-family: sans-serif; font-size: 12px"><b style="color: #f47321">LÍNEAS DE ATENCIÓN:</b> Bogotá: (601)3440419 - Barranquilla: (605)3582003 - Nacional: (01)8000510400</p>
              @if($cantidad<=8)
                <br>
              @endif
              <span style="font-family: sans-serif">www.aotour.com.co</span>
          </div>
        </center>

      </footer>
    @endif

    @if($cantidad>10)
    <div style="page-break-after: always; margin-bottom: 30px"></div>
      <footer>

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

    @if($cotizacion->archivos1!=null)
      <div style="page-break-after: always; margin-bottom: 30px;"></div>
      <div style="background-color: gray">
      <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo # 1</strong></center>
      
        <?php $sw1 = 1; ?>
        @foreach(json_decode($cotizacion->archivos1) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 30%; text-align: center; float: @if($sw1==1){{'left;'}}@else{{'right;'}}@endif">
                <div style="background: white; border-radius: 0px;">

                  <div id="container" style="margin-top: 60px">
                    <img src="img/fondo_foto.png" id="img1" style="width: 500px; height: 300px;"/>
                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img2" style="width: 290px; margin-top: 5px; margin-left: 80px"/>
                  </div>
                  <!--<img style="background-color: green; height: 260px; margin-top: 15px; width: 340px; border-radius: 20%; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" ><br>-->

                </div>
              </th>
              <th align="left" style="width: 10%; color: white; text-align: center; vertical-align: middle;">
                

              </th>
              <th style="padding: 5px; width: 10%; text-align: left;">

              </th>
            </tr>
        </table>
        <?php $sw1++; ?>
        @endforeach

        <center>

          <div id="header">
            <h1>Características del vehículo</h1>
              </div>
            <div class="container">

            <div class="card">
              
              <div class="card-text">
                
                <p class="card-title">Full Aire</p>
                
              </div>
              <div class="card-price">1</div>
            </div>

              <div class="card">
              
              <div class="card-text">
                
                <p class="card-title">Full Aire</p>
                
              </div>
              <div class="card-price">2</div>
            </div>
              <div class="card">
             
              <div class="card-text">
                <p class="card-title">Full Aire</p>
              </div>
              <div class="card-price">3</div>
            </div>
              
            </div>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 30px">{{$file->c1}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 8px">{{$file->c2}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 8px">{{$file->c3}}</li>
        </center>
        </div>
    @endif

    <!-- Vehiculo 2 -->
    @if($cotizacion->archivos2!=null)
      <div style="page-break-after: always; margin-bottom: 30px"></div>
      <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo # 2</strong></center>
      <center>

        @foreach(json_decode($cotizacion->archivos2) as $file2)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 10%; text-align: center; float: right;">

              </th>
              <th style="width: 80%; color: white; text-align: center; vertical-align: middle;">
                <div style="background: white; border-radius: 0px;">

                  <div id="container" style="margin-top: 60px">
                    <img src="img/fondo_foto.png" id="img1" style="width: 500px; height: 300px;"/>
                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file2->archivos}}" id="img2" style="width: 290px; margin-top: 5px; margin-left: 80px"/>
                  </div>
                  <!--<img style="background-color: green; height: 260px; margin-top: 15px; width: 340px; border-radius: 20%; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file2->archivos}}" ><br>-->

                </div>

              </th>
              <th style="padding: 5px; width: 10%; text-align: left;">

              </th>
            </tr>
        </table>
        @endforeach

        <center>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 30px">{{$file2->c1}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 8px">{{$file2->c2}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 8px">{{$file2->c3}}</li>
        </center>
    @endif

    <!-- Vehiculo 3 -->
    @if($cotizacion->archivos3!=null)
      <div style="page-break-after: always; margin-bottom: 30px"></div>
      <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo 3</strong></center>
      <center>

        @foreach(json_decode($cotizacion->archivos3) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 10%; text-align: center; float: right;">

              </th>
              <th style="width: 80%; color: white; text-align: center; vertical-align: middle;">
                <div style="background: white; border-radius: 0px;">

                  <div id="container" style="margin-top: 60px">
                    <img src="img/fondo_foto.png" id="img1" style="width: 500px; height: 300px;"/>
                    <img src="{{'biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos}}" id="img2" style="width: 290px; margin-top: 5px; margin-left: 80px"/>
                  </div>
                  <!--<img style="background-color: green; height: 260px; margin-top: 15px; width: 340px; border-radius: 20%; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" src="{{url('biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos)}}" ><br>-->

                </div>

              </th>
              <th style="padding: 5px; width: 10%; text-align: left;">

              </th>
            </tr>
        </table>
        @endforeach

        <center>
          <li style="font-family: sans-serif; text-align: center; color: black; margin-top: 30px">{{$file->c1}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black;">{{$file->c2}}</li>
          <li style="font-family: sans-serif; text-align: center; color: black;">{{$file->c3}}</li>
        </center>
    @endif

    <!-- Vehiculo 4 -->
    @if($cotizacion->archivos4!=null)
      <div style="page-break-after: always; margin-bottom: 30px"></div>
      <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo</strong></center>
      <center>

        @foreach(json_decode($cotizacion->archivos4) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 10%; text-align: center; float: right;">

              </th>
              <th style="width: 80%; color: white; text-align: center; vertical-align: middle;">
                <div style="background: white; border-radius: 0px;">

                  <img style="background-color: green; height: 260px; margin-top: 15px; width: 340px; border-radius: 20%; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" src="{{url('biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos)}}" ><br>

                </div>

              </th>
              <th style="padding: 5px; width: 10%; text-align: left;">

              </th>
            </tr>
        </table>
        @endforeach

        <center>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c1}}</li>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c2}}</li>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c3}}</li>
        </center>
    @endif

    <!-- Vehiculo 5 -->
    @if($cotizacion->archivos5!=null)
      <div style="page-break-after: always; margin-bottom: 30px"></div>
      <center><strong style="font-size: 18px; font-family: sans-serif; margin-top: 30px; margin-bottom: 20px">Fotos del Vehículo</strong></center>
      <center>

        @foreach(json_decode($cotizacion->archivos5) as $file)
        <table style="width: 100%" >
            <tr>
              <th style="color: white; padding: 5px; width: 10%; text-align: center; float: right;">

              </th>
              <th style="width: 80%; color: white; text-align: center; vertical-align: middle;">
                <div style="background: white; border-radius: 0px;">

                  <img style="background-color: green; height: 260px; margin-top: 15px; width: 340px; border-radius: 20%; border: #C6C6C6 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;" src="{{url('biblioteca_imagenes/archivos_cotizaciones/'.$file->archivos)}}" ><br>

                </div>

              </th>
              <th style="padding: 5px; width: 10%; text-align: left;">

              </th>
            </tr>
        </table>
        @endforeach

        <center>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c1}}</li>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c2}}</li>
          <li style="font-family: sans-serif; text-align: justify center; color: black;">{{$file->c3}}</li>
        </center>
    @endif



    <!--<img style="margin-top: 5px; margin-bottom: 20px" src="img/microbus2.jpeg" width="80%" height="460px" >
    center>-->

</body></html>
