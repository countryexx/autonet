<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Detalles Indicadores</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>
      .datos{
        text-align: center;
      }

      .datob{
        text-align: center;
      }

      .inputtexto{
        font-size: 12px;
      }
      .colback{
        border: 1px solid black; 
        padding: 2px; 
        font-size: 12px; 
        background-color: gray;
        text-align: center;
      }

      .colnoback{
        border: 1px solid black; 
        padding: 2px; 
        font-size: 12px;
        text-align: center;
      }

      *{margin: 0; padding: 0;}

      .doc{
        display: flex;
        flex-flow: column wrap;
        width: 100vw;
        height: 100vh;
        justify-content: center;
        align-items: center;
        background: #333944;
      }

      .box{
        width: 300px;
        height: 300px;
        background: #CCC;
        overflow: hidden;
      }

      .box img{
        width: 100%;
        height: auto;
      }

      @supports(object-fit: cover){
          .box img{
            height: 100%;
            object-fit: cover;
            object-position: center center;
          }
      }

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
      	background-color: rgb(255, 255, 255);
      	border-color: rgba(149, 149, 149, 0.3);
      	border-radius: 3px;
      	color: rgb(149, 149, 149);
      	padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
      	height: 50px;
      	margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
      	color: rgb(51, 51, 51);
      	display: block;
      	font-weight: bold;
      	margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')
  <div class="container" style="padding: 0 120px 120px 120px">
    <div class="col-lg-1">
      
    </div>
    <div class="col-lg-10">
      <!-- TEST PLATILLA INDICADOR -->
      <table id="header" style="width:100%;table-layout:auto;empty-cells:show; border: 1px solid #5a5a5a; border-collapse: collapse;">
        <tbody>
          <tr>
            <td width="20" style="padding: 25px; border-right: 1px solid #5a5a5a;"><img style="margin-left: 18%" width="130" src="{{url('biblioteca_imagenes/logos.png')}}"></td>
            
            <td width="400">
              <table style="width:100%; border-collapse: collapse;">
                <tr>
                  <td width="300" style="border-right: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px; text-align: center; font-size: 13px">FORMATO</td>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;" align="center">Codigo</td>
                  <td  align="center" style="border-bottom: 1px solid #5a5a5a;">FM-IT-35</td>
                </tr>
                <tr>
                  <td rowspan="2" style="border-right: 1px solid #5a5a5a;border-bottom: 1px solid #5a5a5a; padding: 5px; text-align: center; font-size: 13px">INDICADORES DE GESTIÓN</td>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 5px;" align="center">Version</td>
                  <td align="center" style="border-bottom: 1px solid black;">2</td>
                </tr>
                <tr>
                  <td style="border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-collapse: collapse; padding: 5px;" align="center">Fecha</td>
                  <td align="center">22/02/21</td>
                </tr>
                <tr>
                  <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid; border-collapse: collapse; padding: 5px; text-align: center; font-size: 13px">GESTIÓN INTEGRAL</td>
                  <td style="border-top: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-right: 1px solid; border-collapse: collapse; padding: 5px;" align="center">Página</td>
                  <td style="border-top: 1px solid" align="center">1 de 1</td>
                </tr>
              </table>
            </td>
          </tr>
        </tbody>
      </table>

  <div class="div_info">
    <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
      <tr>
        <td width="180" class="colback"><b>PROCESO:</b></td>
       <td style="border-top: 1px solid #5a5a5a; border-right: 1px solid #5a5a5a; border-left: 1px solid #5a5a5a; border-bottom: 1px solid #5a5a5a; padding: 2px; font-size: 10px" align="center">{{$indicador->area}}</td>
      
      </tr>               
    </table>

  <!-- NOMBRE O DEFINICIÓN DEL INDICADOR -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
    <tr>
      <td class="colback"><b>NOMBRE O DEFINICIÓN DEL INDICADOR:</b></td>
     <td class="colback" width="270"><b>TIPO DE INDICADOR</b></td>
    </tr>
    <tr>
      <td class="colnoback">{{$indicador->nombre}}</td>
     <td class="colnoback" align="center">{{$indicador->tipo_indicador}}</td>
    </tr>
  </table>

  <!-- FIN NOMBRE O DEFINICIÓN DEL INDICADOR -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px"> <tr>
  <td class="colback"><b style="color: #1E04D8">INTERPRETACIÓN DEL
  INDICADOR:</b></td> </tr> <tr> <td class="colnoback"><b>{{$indicador->interpretacion_indicador}}</b></td> </tr> </table>

  <!-- FIN NOMBRE Y DEFINICIÓN DEL INDICADOR -->

  <!-- META ASOCIADA AL INDICADOR -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
    <tr>
      <td class="colback"><b style="color: #1E04D8">META ASOCIADA AL INDICADOR</b></td>
     <td class="colback" width="270"><b style="color: #1E04D8">VALOR PROGRAMADO</b></td>
    </tr>
    <tr>
      <td class="colnoback">{{$indicador->meta_asociada}}</td>
     <td class="colnoback" align="center">{{$indicador->valor_programado}}</td>
    </tr>
  </table>

  <!-- FIN META ASOCIADA AL INDICADOR -->

  <!-- DESCRIPCIÓN DE LAS VARIABLES DEL INDICADOR -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
    <tr>
      <td colspan="2" class="colback"><b>DESCRIPCIÓN DE LAS VARIABLES DEL INDICADOR</b></td>
    </tr>
    <tr>
      <td width="625" class="colnoback">{{$indicador->variable_a}}</td>
     <td width="600" height="70" class="colnoback" align="center">{{$indicador->variable_b}}</td>
    </tr>
  </table>

  <!-- FIN DESCRIPCIÓN DE LAS VARIABLES DEL INDICADOR -->

  <!-- FÓRMULA DEL INDICADOR -->
  <table style="width:100%; margin-top: 2px; margin-bottom: 2px">
    <tr>
      <td class="colback"><b>FÓRMULA DEL INDICADOR</b></td>
      <td class="colback"><b>FUENTE DE LA INFORMACIÓN</b></td>
    </tr>
    <tr>
      <td width="632" class="colnoback">{{$indicador->formula}}</td>
      <td width="600" height="50" class="colnoback" align="center">{{$indicador->fuente_informacion}}</td>
    </tr>
  </table>
  <!-- FIN FÓRMULA DEL INDICADOR -->

  <!-- FRECUENCIA O PERIOCIDAD DEL REPORTE -->
  <table style="width:100%; margin-top: 2px; margin-bottom: 2px">
    <tr>
      <td class="colback"><b>FRECUENCIA O PERIODICIDAD DEL REPORTE</b></td>
      <td class="colback"><b>UNIDAD DE MEDIDA</b></td>
    </tr>
    <tr>
      <td width="600" class="colnoback">{{$indicador->frecuencia_reporte}}</td>
     <td width="600" height="50" class="colnoback" align="center">{{$indicador->unidad_medida}}</td>
    </tr>

    <tr>
      <td class="colback"><b>TENDENCIA</b></td>
      <td class="colback"><b>TIPO DE MEDICIÓN</b></td>
    </tr>
    <tr>
      <td width="600" class="colnoback">{{$indicador->tendencia}}</td>
     <td width="600" height="50" class="colnoback" align="center">{{$indicador->tipo_medicion}}</td>
    </tr>
  </table>
  <!-- FIN FRECUENCIA O PERIOCIDAD DEL REPORTE -->

  <!-- LÍNEA DE BASE -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
    <tr>
      <td class="colback" colspan="2"><b style="color: #1E04D8">LÍNEA DE BASE (corresponde a la primera evaluación del indicador)</b></td>
    </tr>
    <tr>
     <td width="600" height="50" class="colnoback" colspan="2" align="center">{{$indicador->linea_base}}</td>
    </tr>

    <tr>
      <td class="colback" colspan="2"><b style="color: #1E04D8">PERSONAS Y/O PARTES INTERESADAS QUE DEBEN CONOCER EL RESULTADO</b></td>
    </tr>
    <tr>
     <td width="600" height="50" class="colnoback" colspan="2" align="center">{{$indicador->personas_interesadas}}</td>
    </tr>

    
  </table>

  <!-- FIN LÍNEA DE BASE -->

  <!-- DATOS DE INDICADOR -->

  <!-- FIN DATOS DE INDICADOR -->

  <table style="width:100%; margin-top: 6px; margin-bottom: 10px">

    <!-- TITULO -->
    <tr>
      <td class="colback" colspan="13">
        <b style="color: #1E04D8">PROGRAMACIÓN Y EJECUCIÓN DEL INDICADOR</b>
      </td>
    </tr>
    <!-- TITULO -->

    <!-- MESES -->
    <tr>
      <td class="colnoback"><b></td>
      <td class="colnoback"><b>ENE</td>
      <td class="colnoback"><b>FEB</td>
      <td class="colnoback"><b>MAR</td>
      <td class="colnoback"><b>ABR</td>
      <td class="colnoback"><b>MAY</td>
      <td class="colnoback"><b>JUN</td>
      <td class="colnoback"><b>JUL</td>
      <td class="colnoback"><b>AGO</td>
      <td class="colnoback"><b>SEP</td>
      <td class="colnoback"><b>OCT</td>
      <td class="colnoback"><b>NOV</td>
      <td class="colnoback"><b>DIC</td>
    </tr>
    <!-- FIN MESES -->

    <!-- RESULTADO DESEADO -->
    <tr>
      <td class="colback" style="background-color: green">
        <b style="color: #1E04D8">RESULTADO DESEADO</b>
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
        </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
      <td class="colback">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_deseado}}%" disabled="true">
      </td>
    </tr>
    <!-- FIN RESULTADO DESEADO -->

    <!-- RESULTADO SATISFACTOROIO -->
    <tr>
      <td class="colback" style="background-color: yellow">
        <b style="color: #1E04D8">RESULTADO SATISFACTORIO</b>
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
      <td class="colback" align="center">
        <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_satisfactorio}}%" disabled="true">
      </td>
    </tr>
    <!-- FIN RESULTADO SATISFACTOROIO -->

    <!-- RESULTADO CRÍTICO -->
    <tr>
      <td class="colback" style="background-color: orange">
        <b style="color: #1E04D8">RESULTADO CRÍTICO</b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
      <td class="colback">
        <b style="color: #1E04D8">
          <input type="text" name="1_1" class="form-control inputtexto" value="{{$indicador->resultado_critico}}%" disabled="true">
        </b>
      </td>
    </tr>
    <!-- FIN RESULTADO CRÍTICO -->

    <!-- RESULTADO ALCANZADO -->
    <?php 

        if($indicador->b1===0 || $indicador->b1===null){
          $enero = 0;
        }else{
          $enero = ($indicador->a1/$indicador->b1)*100;
        }
        if($indicador->b2===0 || $indicador->b2===null){
          $febrero = 0;
        }else{
          $febrero = ($indicador->a2/$indicador->b2)*100;
        }
        if($indicador->b3===0 || $indicador->b3===null){
          $marzo = 0;
        }else{
          $marzo = ($indicador->a3/$indicador->b3)*100;
        }
        if($indicador->b4===0 || $indicador->b4===null){
          $abril = 0;
        }else{
          $abril = ($indicador->a4/$indicador->b4)*100;
        }
        if($indicador->b5===0 || $indicador->b5===null){
          $mayo = 0;
        }else{
          $mayo = ($indicador->a5/$indicador->b5)*100;
        }
        if($indicador->b6===0 || $indicador->b6===null){
          $junio = 0;
        }else{
          $junio = ($indicador->a6/$indicador->b6)*100;
        }
        if($indicador->b7===0 || $indicador->b7===null){
          $julio = 0;
        }else{
          $julio = ($indicador->a7/$indicador->b7)*100;
        }
        if($indicador->b8===0 || $indicador->b8===null){
          $agosto = 0;
        }else{
          $agosto = ($indicador->a8/$indicador->b8)*100;
        }
        if($indicador->b9===0 || $indicador->b9===null){
          $septiembre = 0;
        }else{
          $septiembre = ($indicador->a9/$indicador->b9)*100;
        }
        if($indicador->b10===0 || $indicador->b10===null){
          $octubre = 0;
        }else{
          $octubre = ($indicador->a10/$indicador->b10)*100;
        }
        if($indicador->b11===0 || $indicador->b11===null){
          $noviembre = 0;
        }else{
          $noviembre = ($indicador->a11/$indicador->b11)*100;
        }
        if($indicador->b12===0 || $indicador->b12===null){
          $diciembre = 0;
        }else{
          $diciembre = ($indicador->a12/$indicador->b12)*100;
        }          

          if($indicador->resultado_deseado>$indicador->resultado_critico){

            if($enero>$indicador->resultado_satisfactorio){
              $fondo_enero = 'green';
              $color_enero = 'white';
            }else if($enero>=$indicador->resultado_critico and $enero<=$indicador->resultado_satisfactorio){
              $fondo_enero = 'yellow';
              $color_enero = 'black';
            }else{
              $fondo_enero = 'orange';
              $color_enero = 'white';
            }          

            if($febrero>$indicador->resultado_satisfactorio){
              $fondo_febrero = 'green';
              $color_febrero = 'white';
            }else if($febrero>=$indicador->resultado_critico and $febrero<=$indicador->resultado_satisfactorio){
              $fondo_febrero = 'yellow';
              $color_febrero = 'black';
            }else{
              $fondo_febrero = 'orange';
              $color_febrero = 'white';
            }          

            if($marzo>$indicador->resultado_satisfactorio){
              $fondo_marzo = 'green';
              $color_marzo = 'white';
            }else if($marzo>=$indicador->resultado_critico and $marzo<=$indicador->resultado_satisfactorio){
              $fondo_marzo = 'yellow';
              $color_marzo = 'black';
            }else{
              $fondo_marzo = 'orange';
              $color_marzo = 'white';
            }          

            if($abril>$indicador->resultado_satisfactorio){
              $fondo_abril = 'green';
              $color_abril = 'white';
            }else if($abril>=$indicador->resultado_critico and $abril<=$indicador->resultado_satisfactorio){
              $fondo_abril = 'yellow';
              $color_abril = 'black';
            }else{
              $fondo_abril = 'orange';
              $color_abril = 'white';
            }          

            if($mayo>$indicador->resultado_satisfactorio){
              $fondo_mayo = 'green';
              $color_mayo = 'white';
            }else if($mayo>=$indicador->resultado_critico and $mayo<=$indicador->resultado_satisfactorio){
              $fondo_mayo = 'yellow';
              $color_mayo = 'black';
            }else{
              $fondo_mayo = 'orange';
              $color_mayo = 'white';
            }          

            if($junio>$indicador->resultado_satisfactorio){
              $fondo_junio = 'green';
              $color_junio = 'white';
            }else if($junio>=$indicador->resultado_critico and $junio<=$indicador->resultado_satisfactorio){
              $fondo_junio = 'yellow';
              $color_junio = 'black';
            }else{
              $fondo_junio = 'orange';
              $color_junio = 'white';
            }          

            if($julio>$indicador->resultado_satisfactorio){
              $fondo_julio = 'green';
              $color_julio = 'white';
            }else if($julio>=$indicador->resultado_critico and $julio<=$indicador->resultado_satisfactorio){
              $fondo_julio = 'yellow';
              $color_julio = 'black';
            }else{
              $fondo_julio = 'orange';
              $color_julio = 'white';
            }          

            if($agosto>$indicador->resultado_satisfactorio){
              $fondo_agosto = 'green';
              $color_agosto = 'white';
            }else if($agosto>=$indicador->resultado_critico and $agosto<=$indicador->resultado_satisfactorio){
              $fondo_agosto = 'yellow';
              $color_agosto = 'black';
            }else{
              $fondo_agosto = 'orange';
              $color_agosto = 'white';
            }          

            if($septiembre>$indicador->resultado_satisfactorio){
              $fondo_septiembre = 'green';
              $color_septiembre = 'white';
            }else if($septiembre>=$indicador->resultado_critico and $septiembre<=$indicador->resultado_satisfactorio){
              $fondo_septiembre = 'yellow';
              $color_septiembre = 'black';
            }else{
              $fondo_septiembre = 'orange';
              $color_septiembre = 'white';
            }          

            if($octubre>$indicador->resultado_satisfactorio){
              $fondo_octubre = 'green';
              $color_octubre = 'white';
            }else if($octubre>=$indicador->resultado_critico and $octubre<=$indicador->resultado_satisfactorio){
              $fondo_octubre = 'yellow';
              $color_octubre = 'black';
            }else{
              $fondo_octubre = 'orange';
              $color_octubre = 'white';
            }          

            if($noviembre>$indicador->resultado_satisfactorio){
              $fondo_noviembre = 'green';
              $color_noviembre = 'white';
            }else if($noviembre>=$indicador->resultado_critico and $noviembre<=$indicador->resultado_satisfactorio){
              $fondo_noviembre = 'yellow';
              $color_noviembre = 'black';
            }else{
              $fondo_noviembre = 'orange';
              $color_noviembre = 'white';
            }          

            if($diciembre>$indicador->resultado_satisfactorio){
              $fondo_diciembre = 'green';
              $color_diciembre = 'white';
            }else if($diciembre>=$indicador->resultado_critico and $diciembre<=$indicador->resultado_satisfactorio){
              $fondo_diciembre = 'yellow';
              $color_diciembre = 'black';
            }else{
              $fondo_diciembre = 'orange';
              $color_diciembre = 'white';
            }

          }else{

            if($enero<=$indicador->resultado_deseado){
              $fondo_enero = 'green';
              $color_enero = 'white';
            }else if($enero>$indicador->resultado_deseado and $enero<=$indicador->resultado_satisfactorio){
              $fondo_enero = 'yellow';
              $color_enero = 'black';
            }else{
              $fondo_enero = 'orange';
              $color_enero = 'white';
            }

            if($febrero<=$indicador->resultado_deseado){
              $fondo_febrero = 'green';
              $color_febrero = 'white';
            }else if($febrero>$indicador->resultado_deseado and $febrero<=$indicador->resultado_satisfactorio){
              $fondo_febrero = 'yellow';
              $color_febrero = 'black';
            }else{
              $fondo_febrero = 'orange';
              $color_febrero = 'white';
            }
            if($marzo<=$indicador->resultado_deseado){
              $fondo_marzo = 'green';
              $color_marzo = 'white';
            }else if($marzo>$indicador->resultado_deseado and $marzo<=$indicador->resultado_satisfactorio){
              $fondo_marzo = 'yellow';
              $color_marzo = 'black';
            }else{
              $fondo_marzo = 'orange';
              $color_marzo = 'white';
            }
            if($abril<=$indicador->resultado_deseado){
              $fondo_abril = 'green';
              $color_abril = 'white';
            }else if($abril>$indicador->resultado_deseado and $abril<=$indicador->resultado_satisfactorio){
              $fondo_abril = 'yellow';
              $color_abril = 'black';
            }else{
              $fondo_abril = 'orange';
              $color_abril = 'white';
            }
            if($mayo<=$indicador->resultado_deseado){
              $fondo_mayo = 'green';
              $color_mayo = 'white';
            }else if($mayo>$indicador->resultado_deseado and $mayo<=$indicador->resultado_satisfactorio){
              $fondo_mayo = 'yellow';
              $color_mayo = 'black';
            }else{
              $fondo_mayo = 'orange';
              $color_mayo = 'white';
            }
            if($junio<=$indicador->resultado_deseado){
              $fondo_junio = 'green';
              $color_junio = 'white';
            }else if($junio>$indicador->resultado_deseado and $junio<=$indicador->resultado_satisfactorio){
              $fondo_junio = 'yellow';
              $color_junio = 'black';
            }else{
              $fondo_junio = 'orange';
              $color_junio = 'white';
            }
            if($julio<=$indicador->resultado_deseado){
              $fondo_julio = 'green';
              $color_julio = 'white';
            }else if($julio>$indicador->resultado_deseado and $julio<=$indicador->resultado_satisfactorio){
              $fondo_julio = 'yellow';
              $color_julio = 'black';
            }else{
              $fondo_julio = 'orange';
              $color_julio = 'white';
            }

            if($agosto<=$indicador->resultado_deseado){
              $fondo_agosto = 'green';
              $color_agosto = 'white';
            }else if($agosto>$indicador->resultado_deseado and $agosto<=$indicador->resultado_satisfactorio){
              $fondo_agosto = 'yellow';
              $color_agosto = 'black';
            }else{
              $fondo_agosto = 'orange';
              $color_agosto = 'white';
            }          

            if($septiembre<=$indicador->resultado_deseado){
              $fondo_septiembre = 'green';
              $color_septiembre = 'white';
            }else if($septiembre>$indicador->resultado_deseado and $septiembre<=$indicador->resultado_satisfactorio){
              $fondo_septiembre = 'yellow';
              $color_septiembre = 'black';
            }else{
              $fondo_septiembre = 'orange';
              $color_septiembre = 'white';
            }        

            if($octubre<=$indicador->resultado_deseado){
              $fondo_octubre = 'green';
              $color_octubre = 'white';
            }else if($octubre>$indicador->resultado_deseado and $octubre<=$indicador->resultado_satisfactorio){
              $fondo_octubre = 'yellow';
              $color_octubre = 'black';
            }else{
              $fondo_octubre = 'orange';
              $color_octubre = 'white';
            }        

            if($noviembre<=$indicador->resultado_deseado){
              $fondo_noviembre = 'green';
              $color_noviembre = 'white';
            }else if($noviembre>$indicador->resultado_deseado and $noviembre<=$indicador->resultado_satisfactorio){
              $fondo_noviembre = 'yellow';
              $color_noviembre = 'black';
            }else{
              $fondo_noviembre = 'orange';
              $color_noviembre = 'white';
            }        

            if($diciembre<=$indicador->resultado_deseado){
              $fondo_diciembre = 'green';
              $color_diciembre = 'white';
            }else if($diciembre>$indicador->resultado_deseado and $diciembre<=$indicador->resultado_satisfactorio){
              $fondo_diciembre = 'yellow';
              $color_diciembre = 'black';
            }else{
              $fondo_diciembre = 'orange';
              $color_diciembre = 'white';
            }
          }
     ?>
    <tr>
      <td class="colnoback"><b style="color: #1E04D8">
        RESULTADO ALCANZADO
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="uno" class="form-control inputtexto" value="<?php echo number_format($enero).'%' ?>" style="background-color: <?php echo $fondo_enero; ?>; color: <?php echo $color_enero; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="dos" class="form-control inputtexto" value="<?php echo number_format($febrero).'%' ?>" style="background-color: <?php echo $fondo_febrero; ?>; color: <?php echo $color_febrero; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="tres" class="form-control inputtexto" value="<?php echo number_format($marzo).'%' ?>" style="background-color: <?php echo $fondo_marzo; ?>; color: <?php echo $color_marzo; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="cuatro" class="form-control inputtexto" value="<?php echo number_format($abril).'%' ?>" style="background-color: <?php echo $fondo_abril; ?>; color: <?php echo $color_abril; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="cinco" class="form-control inputtexto" value="<?php echo number_format($mayo).'%' ?>" style="background-color: <?php echo $fondo_mayo; ?>; color: <?php echo $color_mayo; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="seis" class="form-control inputtexto" value="<?php echo number_format($junio).'%' ?>" style="background-color: <?php echo $fondo_junio; ?>; color: <?php echo $color_junio; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="siete" class="form-control inputtexto" value="<?php echo number_format($julio).'%' ?>" style="background-color: <?php echo $fondo_julio; ?>; color: <?php echo $color_julio; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="ocho" class="form-control inputtexto" value="<?php echo number_format($agosto).'%' ?>" style="background-color: <?php echo $fondo_agosto; ?>; color: <?php echo $color_agosto; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="nueve" class="form-control inputtexto" value="<?php echo number_format($septiembre).'%' ?>" style="background-color: <?php echo $fondo_septiembre; ?>; color: <?php echo $color_septiembre; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="diez" class="form-control inputtexto" value="<?php echo number_format($octubre).'%' ?>" style="background-color: <?php echo $fondo_octubre; ?>; color: <?php echo $color_octubre; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="once" class="form-control inputtexto" value="<?php echo number_format($noviembre).'%' ?>" style="background-color: <?php echo $fondo_noviembre; ?>; color: <?php echo $color_noviembre; ?>">
      </td>
      <td class="colnoback" align="center">
        <input disabled="true" type="text" id="doce" class="form-control inputtexto" value="<?php echo number_format($diciembre).'%' ?>" style="background-color: <?php echo $fondo_diciembre; ?>; color: <?php echo $color_diciembre; ?>">
      </td>
    </tr>
    <!-- FIN RESULTADO ALCANZADO -->

    <!-- VARIABLE A -->
    <tr>
      <td class="colback"><b style="color: #1E04D8">A</td>
      <td class="colnoback" align="center">
        <input data-num="1" data="{{$indicador->a1}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a1}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="2" data-value="{{$indicador->a2}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a2}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="3" data-value="{{$indicador->a3}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a3}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="4" data-value="{{$indicador->a4}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a4}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="5" data-value="{{$indicador->a5}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a5}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="6" data-value="{{$indicador->a6}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a6}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="7" data-value="{{$indicador->a7}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a7}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="8" data-value="{{$indicador->a8}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a8}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="9" data-value="{{$indicador->a9}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a9}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="10" data-value="{{$indicador->a10}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a10}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="11" data-value="{{$indicador->a11}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a11}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="12" data-value="{{$indicador->a12}}" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datos" value="{{$indicador->a12}}">
      </td>
    </tr>
    <!-- FIN VARIABLE A -->

    <!-- VARIABLE B -->
    <tr>
      <td class="colback" style="background-color: #16B7DF">
        <b style="color: #1E04D8">B</b>
      </td>
      <td class="colnoback" align="center">
        <input data-num="1" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b1}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="2" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b2}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="3" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b3}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="4" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b4}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="5" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b5}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="6" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b6}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="7" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b7}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="8" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b8}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="9" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b9}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="10" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b10}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="11" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b11}}">
      </td>
      <td class="colnoback" align="center">
        <input data-num="12" data-id="{{$indicador->id_indicador}}" type="text" name="1_1" class="form-control inputtexto datob" value="{{$indicador->b12}}">
      </td>
    </tr>
    <!-- FIN VARIABLE B -->
  
    </table>
    
    @include('otros.pushercode')

    <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
      <tr>
        <td class="colback" colspan="2">
          <b style="color: #1E04D8">PROGRAMACIÓN Y EJECUCIÓN DEL INDICADOR</b>
        </td>
      </tr>
      <tr>
        <td width="600" height="140" class="colnoback" colspan="2" align="center">
        <div class="card-body" style="border: 1px solid black">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
          </div>
        </div>
        </td>
      </tr>
    </table>    
    
    <!-- ANÁLISIS DEL INDICADOR -->
    <table style="width:100%; margin-top: 6px; margin-bottom: 10px">
      <tr>
        <td class="colback" colspan="2">
          <b style="color: #1E04D8">ANÁLISIS DEL INDICADOR</b>
        </td>
      </tr>
      <tr>
        <td width="600" height="120" class="colnoback" colspan="2" align="center">
        {{$indicador->analisis}}
        </td>
      </tr>
      <tr>
        <td class="colback" colspan="2">
          <b style="color: #1E04D8">ACCIONES DE MEJORA PLANTEADAS</b>
        </td>
      </tr>
      <tr>
        <td width="600" height="120" class="colnoback" colspan="2" align="center">
          {{$indicador->acciones_mejora}}
        </td>
      </tr>
    </table>
    <!-- FIN ANÁLISIS DEL INDICADOR -->

  <!-- FIN TEST PLANILLA INDICADOR -->
  </div>  
</div>
    <hr style="border: 10px">

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/gestionintegral.js')}}"></script>

    <script src="{{url('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{url('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{url('js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{url('vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->

    <script type="text/javascript">

      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#858796';

      function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
          };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }

      
      var enero = "<?php echo $enero; ?>"
      var febrero = "<?php echo $febrero; ?>"
      var marzo = "<?php echo $marzo; ?>"
      var abril = "<?php echo $abril; ?>"
      var mayo = "<?php echo $mayo; ?>"
      var junio = "<?php echo $junio; ?>"
      var julio = "<?php echo $julio; ?>"
      var agosto = "<?php echo $agosto; ?>"
      var septiembre = "<?php echo $septiembre; ?>"
      var octubre = "<?php echo $octubre; ?>"
      var noviembre = "<?php echo $noviembre; ?>"
      var diciembre = "<?php echo $diciembre; ?>"

      var resultado_des = "<?php echo $indicador->resultado_deseado ?>"
      var resultado_sat = "<?php echo $indicador->resultado_satisfactorio ?>"
      var resultado_cri = "<?php echo $indicador->resultado_critico ?>"

      var ctx = document.getElementById("myAreaChart");

      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
          datasets: [{
            label: "RESULTADO ALCANZADO",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "black",
            pointRadius: 3,
            pointBackgroundColor: "black",//COLOR BORDE DEL PUNTO
            pointBorderColor: "red",//COLOR INTERDO DEL PUNTO
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre],
          },
          {
            label: "RESULTADO DESEADO",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "green",
            pointRadius: 3,
            pointBackgroundColor: "black",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: [resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des, resultado_des],
          },
          {
          label: "RESULTADO SATISFACTOROIO",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "yellow",
          pointRadius: 3,
          pointBackgroundColor: "black",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat, resultado_sat],
          },
          {
          label: "RESULTADO CRÍTICO",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "orange",
          pointRadius: 3,
          pointBackgroundColor: "black",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: [resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri, resultado_cri],
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return '' + value+' %';
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': '+ number_format(tooltipItem.yLabel)+'%';
              }
            }
          }
        }
      });
    </script>
  </body>
</html>