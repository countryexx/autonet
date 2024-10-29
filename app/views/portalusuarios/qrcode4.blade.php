<!DOCTYPE html>
<html><head>
    <meta charset="iso-8859-1">
    <title>QR {{$pasajero->cedula}}</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <style type="text/css">
      body {
      font-family: 'Arimo', sans-serif !important;
      font-size: 13px !important;
    }
    </style>    
  </head><body>
      <div class="container" >
  <div class="row">
    <div class="col-lg-6"> 
    <div style="margin: 120px 0 120px 130px">     
                       
      </div>
    </div>
    <div class="col-lg-6">
      
    </div>
  </div>
  <table border="0" cellspacing="0" width="700px">
        <tr>
        <td>
          <h1 style="margin-right: 350px; width: 60px">QR CODE</h1>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="biblioteca_imagenes/logo_excel.png" width="280px" height="90px" align="right"></td>
      </tr>
    </table>
  <hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">
  <br><br><br><br><br>
  <table border="0" cellspacing="0" width="700px">
        <tr>
        <td>
          <img src="biblioteca_imagenes/codigosqr/{{$pasajero->cedula}}.png" width="280px" height="240px" align="left">
        </td>
        <td>
          <table border="0" cellspacing="0" width="250px">
            <tr>
              
            <td><p style="font-size: 10px; font-family: time new roman">Nombre: </p></td>
            <td><p style="font-size: 5px; font-family: time new roman">{{$pasajero->nombres}} {{$pasajero->apellidos}}</p></td>
            </tr>
            <tr>
              <td><p style="font-size: 10px; font-family: time new roman">Cédula: </p></td>
              <td><p style="font-size: 5px; font-family: time new roman"></p>{{$pasajero->cedula}}</td>
            </tr>
            <tr>
              <td><p style="font-size: 10px; font-family: time new roman">Dirección: </p></td>
              <td><p style="font-size: 5px; font-family: time new roman"></p>{{$pasajero->direccion}}</td>
            </tr>
            <tr>
              <td><p style="font-size: 10px; font-family: time new roman">Barrio: </p></td>
              <td><p style="font-size: 5px; font-family: time new roman"></p>{{$pasajero->barrio}}</td>
            </tr>
            <tr>
              <td><p style="font-size: 10px; font-family: time new roman">Empresa: </p></td>
              <td><p style="font-size: 5px; font-family: time new roman"></p>{{$centro}}</td>
            </tr>                                        
          </table>
        </td>

      </tr>
    </table>  

    <br><br><br><br>
    
<hr style="margin-top: 2px; margin-bottom: 4px; border-top: 1px dotted #337AB7;">    
<br><br>
    <h1>Conductas dentro del vehículo:</h1>


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
  <h1 style="color: orange">EL RESPETO NOS UNE, AOTOUR NOS MUEVE.</h1>
  </center>
</ul><br>
</div>

</body></html>

</html>