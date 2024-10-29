<html>
<head>
    <meta charset="iso-8859-1">
    <title>QR {{$data}}</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">
      body {
      font-family: 'Arimo', sans-serif !important;
      font-size: 12px !important;
    }
    </style>
  </head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <center>
      <h1 class="h_titulo">CÓDIGO QR</h1>

        <br>
        <h3 class="h_titulo">{{$nombres}} {{$apellidos}}</h3>
        <br><br>
        <h3 class="h_titulo">{{$centro}}</h3>
        <br><br>
      </center>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4">            
          </div>
          <div class="col-lg-4 col-lg-offset-4" style="margin: 0 0 0 210px">
            <div class="row">
              <img src="biblioteca_imagenes/codigosqr/{{$data}}.png" width="330px" height="330px">            
            </div>            
          </div>  
                   
        </div> 
        <br><br>
        <div class="row" style="margin-top: 30px">
          <p style="font-size: 20px">Conductas dentro del vehículo:</p>


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
          </ul><br>


          <p style="font-size: 20px; color: orange">El respeto nos une, Aotour nos mueve.</p>
        </div>                         
      </div>
    </div>
  </div>
</div>

</body>

</html>
