<!DOCTYPE html>
<html>
  <head>
    <meta charset="iso-8859-1">
    <title>PQR</title>
    <!--<link href='https://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic' rel='stylesheet' type='text/css'>-->
    
    <style type="text/css">
      body {
      font-family: 'Arimo', sans-serif !important;
      font-size: 12px !important;
    }
    </style>
   
  </head>
  <body>
  <div class="container">    
    
      <table border="1" cellspacing="1" width="100%">
        <tr>
          <td rowspan="3" style="text-align: center" align="center">
            <img src="biblioteca_imagenes/logo_excel.png" width="280px" height="90px">
          </td>
          
          <td colspan="6" style="text-align: center;" align="center">
            <b>FORMATO</b>
          </td>
          <td colspan="1" style="text-align: center;" align="center">
            <b>Código</b>
          </td>
          <td colspan="3" style="text-align: center;" align="center">
            <b>FM - IT - 61</b>
          </td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: center;" >
            <b>FORMATO DE QUEJAS Y RECLAMOS</b>
          </td>
          <td colspan="1" style="text-align: center;" align="center">
            <b>Versión</b>
          </td>
          <td colspan="3" style="text-align: center;" align="center">
            <b>02</b>
          </td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: center;" align="center">
            <b>GESTIÓN INTEGRAL</b>
          </td>
          <td colspan="1" style="text-align: center;" align="center">
            <b>Fecha</b>
          </td>
          <td colspan="3" style="text-align: center;" align="center">
            <b>12/11/19</b>
          </td>

        </tr>
        <br>
        <tr>
          <td colspan="12"  style="text-align: center;" align="center"><b>Consecutivo N° {{$id}}</b></td>
        </tr>
        
      </table>
    
      <br><br>
    
    <!-- INICIO TABLA 1 -->
    
      <table border="1" cellspacing="1" width="100%">
        
        <tr>
          <td colspan="8"  style="text-align: left; background: #F12E04" align="center"><b>1. DATOS DEL RECLAMANTE</b></td>
        </tr>
        <tr>          
          <td colspan="2"><b>FECHA DE SOLICITUD</b></td>
          <td colspan="2" style="text-align: center;">{{$fecha}}</td>        
          <td colspan="2" style="text-align: center;"><b>TIPO DE SOLICITUD: </b></td>  
          <td colspan="2" style="text-align: center;">{{$tipo_solicitud}}</td>          
        </tr>
        
        <tr><td colspan="8" style="text-align: left" align="center"><b>NOMBRE / ORGANIZACIÓN: </b>{{$nombres}}</td></tr>
        <tr><td colspan="8" style="text-align: left" align="center"><b>DIRECCIÓN: </b>{{$direccion}}</td></tr>
        <tr>
          <td colspan="5" style="text-align: left;" align="center"><b>CIUDAD: </b>{{$ciudad}}</td>
          <td colspan="3" style="text-align: left;" align="center"><b>TELÉFONO: </b>{{$telefono}}</td>
        </tr>
        <tr><td colspan="8" style="text-align: left;" align="center"><b>CORREO ELECTRÓNICO: </b>{{$email}}</td></tr>
        <tr><td colspan="8" style="text-align: left" align="center"><b>DATOS DE LA PERSONA QUE ACTÚA EN REPRESENTACIÓN DEL RECLAMANTE (SI ES APLICABLE)<br><br>NOMBRE: {{$nombres_r}}<br><br> APELLIDO: {{$apellidos_r}}<br><br> DIRECCIÓN: {{$direccion_r}}<br><br> TELÉFONO: {{$telefono_r}}<br><br> CORREO: {{$correo_r}}</b></td></tr>
        
      </table>
   
    <!-- FIN TABLA 1 -->
    <br><br>
    
    <!-- INICIO TABLA 2 -->
    
    <table border="1" cellspacing="1" width="100%">
      
      <tr>
        <td colspan="8"  style="text-align: left; background: #F12E04" align="center"><b>2. DESCRIPCIÓN DEL SERVICIO / PRODUCTO</b></td>
      </tr>

      <tr><td colspan="8" style="text-align: left" align="center"><b>NÚMERO DE REFERENCIA DEL SERVICIO / PRODUCTO (Si lo conoce):</b> {{$servicio}}</td></tr>

      <tr>
        
        <td colspan="1"><b>RUTA</b></td>
        <td colspan="1" style="text-align: center;">{{$ruta}}</td>  
        <td colspan="1"><b>PLACA</b></td>
        <td colspan="1" style="text-align: center;">{{$placa}}</td>    
        <td colspan="1"><b>CONDUCTOR</b></td>
        <td colspan="3" style="text-align: center;">{{$conductor}}</td>    
      </tr>
      
      <tr><td colspan="8" style="text-align: left" align="center"><b>DESCRIPCIÓN: </b> {{$info2}}</td></tr>
      @if($tiposerv==='EJECUTIVO')
        <tr>        
          <td colspan="1"><b>SERVICIO CORPORATIVO</b></td>
          <td colspan="1" style="text-align: center;"></td>  
          <td colspan="1"><b>SERVICIO EJECUTIVO</b></td>
          <td colspan="1" style="text-align: center;">X</td>    
          <td colspan="4"><b>OTROS: </b></td>
        </tr>
      @elseif($tiposerv==='CORPORATIVO')
        <tr>        
          <td colspan="1"><b>SERVICIO CORPORATIVO</b></td>
          <td colspan="1" style="text-align: center;">X</td>  
          <td colspan="1"><b>SERVICIO EJECUTIVO</b></td>
          <td colspan="1" style="text-align: center;"></td>    
          <td colspan="4"><b>OTROS: </b></td>
        </tr>
      @else
        <tr>        
          <td colspan="1"><b>SERVICIO CORPORATIVO</b></td>
          <td colspan="1" style="text-align: center;"></td>  
          <td colspan="1"><b>SERVICIO EJECUTIVO</b></td>
          <td colspan="1" style="text-align: center;"></td>    
          <td colspan="4"><b>OTROS: </b>X</td>
      </tr>
      @endif
          
    </table>
    
    <!-- FIN TABLA 3 -->
    <br><br>
    
    <!-- INICIO TABLA 3 -->
    
    <table border="1" cellspacing="1" width="100%">
      
      <tr>
        <td colspan="8"  style="text-align: left; background: #F12E04" align="center"><b>3. PROBLEMA ENCONTRADO</b></td>
      </tr>

      <tr>
        <td colspan="2" style="text-align: left" align="center"><b>FECHA DE OCURRENCIA</b></td>
        <td colspan="6" style="text-align: left" align="center"><b>{{$fecha_ocurrencia}}</b></td>
      </tr>
      <tr>
        <td colspan="8" style="text-align: left;" align="center"> <b>DESCRIPCIÓN: </b> {{$info}}</td>
      </tr>    
            
    </table>
    <br><br>
  
    <!-- FIN TABLA 3 -->
    
    <!-- INICIO TABLA 4 -->
    
      <table border="1" cellspacing="1" width="100%">
        
        <tr>
          <td colspan="8"  style="text-align: left; background: #F12E04" align="center"><b>4. ADJUNTOS</b></td>
        </tr>      
        <tr>
          <td colspan="8" style="text-align: left" align="center"><b>LISTE LOS DOCUMENTOS SOPORTES QUE ADJUNTA</b></td>        
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">1.</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">2.</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">3.</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">4.</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">5.</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;" align="center">6.</td>
        </tr>
      
    </table>
    
    <!-- FIN TABLA 4 -->
    <div class="row">
      <a href="{{ url('pqr/descargarpqr/' . $id) }}" class="button"><p style="text-align: center;">Descargar PDF</p></a>
    </div>
  
</div>
  </body>
</html>
