<html>
<head>
    <meta charset="iso-8859-1">
    <title>{{$fechapdf}} | COSTANCIA DE LIMPIEZA VEHICULAR</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" src="font-awesome/css/font-awesome.min.css">
    <style type="text/css">
      body {
      font-family: 'Arimo', sans-serif !important;
      font-size: 13px !important;
    }
    </style>
    
    
  </head>
<body>

<div class="container" >
  <div class="row">
    <table border="0" cellspacing="0" width="100%">
        <tr>
        <td>
          <h1 style="margin-right: 100px;">COSTANCIA DE LIMPIEZA VEHICULAR</h1>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="biblioteca_imagenes/logo_excel.png" width="240px" height="90px" align="right" style="float: right; margin-left: 100px"></td>
      </tr>
    </table>
  </div>
  
  <hr>
  <br><br><br><br><br>
  <table border="0" cellspacing="0" width="700px">
    <tr>
      <td>
        <table border="1" cellspacing="0" width="100%" align="center">
            <tr style="background: #AEB3B1">
              <td align="center" colspan="8">DATOS DE LA COSTANCIA</td>
            </tr>
            <tr>
                <td colspan="4">NOMBRE PROVEEDOR</td>
                <td align="center" colspan="4">{{$nombrep}}</td>                            
            </tr>
            <tr>
                <td colspan="4">NOMBRE CONDUCTOR</td>
                <td colspan="4" align="center">{{$nombrec}}</td>
            </tr>
            <tr>
                <td colspan="4">PLACA VEHÍCULO</td>
                <td colspan="4" align="center">{{$placapdf}}</td>
            </tr>
            <tr>
                <td colspan="4">TIPO VEHÍCULO</td>
                <td colspan="4" align="center">{{$tipovehiculopdf}}</td>
            </tr>
            <tr>
                <td colspan="4">CIUDAD</td>
                <td colspan="4" align="center">{{$ciudadpdf}}</td>
            </tr>
            <tr>
                <td colspan="4">FECHA</td>
                <td colspan="4" align="center">{{$fechapdf}}</td>
            </tr>
            <tr>
                <td colspan="4">TELÉFONO</td>
                <td colspan="4" align="center">{{$telefonopdf}}</td>
            </tr>
        </table>
      </td>        
    </tr>
  </table>  

  <br><br><br><br>    
  <table border="1" cellspacing="0" width="100%" align="center">
      <tr style="background: #AEB3B1">
          <td align="center">ÍTEM</td>
          <td align="center">REALIZACIÓN</td>                      
      </tr>
      <tr>
          <td>Se realizó limpieza y desinfección al inicio de ruta, donde se limpiaron y desinfectaron los puntos de contacto frecuente de los usuarios y la realización del aseo del vehículo</td>
          <td align="center"><span>SI</span></td>                      
      </tr>
      <tr>
          <td>Se realizó limpieza con los elementos indicados por el ministerio de salud y los epp adecuados</td>
          <td align="center"><span>NO</span></td>
      </tr>      
  </table>
  <br><br><br><br><br>
</div>

</body>

</html>
