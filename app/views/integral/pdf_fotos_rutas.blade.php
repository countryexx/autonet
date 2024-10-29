<html>
<head>
    <meta charset="UTF-8">
    <title>RUTAS DEL DÍA {{$fecha}}</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" src="font-awesome/css/font-awesome.min.css">
    <style type="text/css">
      body {
      font-family: 'Arimo', sans-serif !important;      
    }
    </style>
    
    
  </head>
<body>

<div class="container" >
  <div class="row">
    <table border="0" cellspacing="0" width="100%">
        <tr>
        <td>
          <h4 style="margin-right: 100px;">RUTAS DEL DÍA {{$fecha}}</h4>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="biblioteca_imagenes/logo_excel.png" width="240px" height="90px" align="right" style="float: right; margin-left: 100px"></td>
      </tr>
    </table>
  </div>
  <hr>
  <br>
    <?php $contador = 0;?>
    @foreach($documentos as $documento)          
        @if($contador=='4')          
          <div style="page-break-after: always;"></div>
          <h5 style="text-align: center;">RUTA {{$documento->tipo_ruta}} {{$documento->hora}} - {{$documento->nombre_completo}}</h5>
          <img style="margin-left: 190px" src="biblioteca_imagenes/gestion_documental/{{$documento->id}}.jpeg" width="250px" height="180px" >
          <br><br> 
          <?php $contador=0; ?> 
        @else
          <h5 style="text-align: center;">RUTA {{$documento->tipo_ruta}} {{$documento->hora}} - {{$documento->nombre_completo}}</h5>
          <img style="margin-left: 190px" src="biblioteca_imagenes/gestion_documental/{{$documento->id}}.jpeg" width="250px" height="180px" >
          <br><br>  
        @endif
        <?php $contador++?>
    @endforeach

  <br><br>
</div>

</body>

</html>
