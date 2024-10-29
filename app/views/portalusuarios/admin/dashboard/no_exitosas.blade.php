<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | No exitosas</title>
   <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">

  <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
  <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{url('animate.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="manifest" href="{{url('manifest.json')}}">
  @include('scripts.styles')

    <link rel="stylesheet" href="{{url('css/jquery.dataTables.min.css')}}">

    <script src="{{url('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>

    <style>

      body {
        background-color: #EAECEA;
        font-family: sans-serif;
      }

      #map{
        height: 80%;
        width: 100%;
        z-index: 1;
      }

      [data-notify="progressbar"] {
	      	margin-bottom: 0px;
	      	position: absolute;
	      	bottom: 0px;
	      	left: 0px;
	      	width: 100%;
	      	height: 5px;
      }

      /*table css*/
      @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700');

      $base-spacing-unit: 24px;
      $half-spacing-unit: $base-spacing-unit / 2;

      $color-alpha: #1772FF;
      $color-form-highlight: #EEEEEE;

      *, *:before, *:after {
      	box-sizing:border-box;
      }

      body {

      	font-family:'Source Sans Pro', sans-serif;
      	margin:0;
        font-size: 19px
      }

      h1,h2,h3,h4,h5,h6 {
      	margin:0;
      }

      .container {
      	max-width: 1000px;
      	margin-right:auto;
      	margin-left:auto;
      	display:flex;
      	justify-content:center;
      	align-items:center;
      	min-height:100vh;
      }

      .table {
      	width:100%;
      	border:1px solid $color-form-highlight;
      }

      .table-header {
      	display:flex;
      	width:100%;
      	background:#000;
      	padding:($half-spacing-unit * 1.5) 0;
      }

      .table-row {
      	display:flex;
      	width:100%;
      	padding:($half-spacing-unit * 1.5) 0;

      	&:nth-of-type(odd) {
      		background:$color-form-highlight;
      	}
      }

      .table-data, .header__item {
      	flex: 1 1 20%;
      	text-align:center;
      }

      .header__item {
      	text-transform:uppercase;
      }

      .filter__link {
      	color:white;
      	text-decoration: none;
      	position:relative;
      	display:inline-block;
      	padding-left:$base-spacing-unit;
      	padding-right:$base-spacing-unit;

      	&::after {
      		content:'';
      		position:absolute;
      		right:-($half-spacing-unit * 1.5);
      		color:white;
      		font-size:$half-spacing-unit;
      		top: 50%;
      		transform: translateY(-50%);
      	}

      	&.desc::after {
      		content: '(desc)';
      	}

      	&.asc::after {
      		content: '(asc)';
      	}

      }

    </style>
</head>
<body background="{{url('biblioteca_imagenes/fondo_pdf.PNG')}}">
  @include('admin.menu')

  <?php
  $datos1 = '{{$datossatisfechos}}';
  $datos2 = '{{$datosnosatisfechos}}';
  $data = '{{$cliente}}';
  ?>

    <section class="content">

      <div class="row">
        <div class="col-md-11">
          <center><h1 style="color: gray; text-decoration: underline; margin-right: -150px"> DASHBOARD {{$generales->mes}}</h1></center>
          <input type="text" name="" value="{{$id}}" class="hidden" id="id_value">
        </div>
        <div class="col-md-1">
          <a style="margin-bottom:10px;" onclick="goBack()" class="btn btn-primary btn-icon">VOLVER<i class="icon-btn fa fa-reply"></i></a>
        </div>
      </div>
      <hr>
      <div class="row">
        <center>
        <div class="col-md-5" style="border: 2px solid gray; margin-left: 75px; border-radius: 15px">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 20px">
                  <h3 style="margin-left: 30px; margin-bottom: 10px; text-decoration: underline; color: gray;">RUTAS NO EXITOSAS - {{$generales->mes}}-{{$generales->ano}}</h3>
                </div>
              </div>
            </div>
            <div class="row" style="border-radius: 30px;">
              <div class="chart-area" style="margin-bottom: 20px">
                <canvas id="myAreaChartt"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5 col-md-push-1" style="border: 2px solid gray; border-radius: 15px">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-md-12" style="margin-bottom: 20px">
                  <h3 style="margin-left: 20px; margin-bottom: 10px; text-decoration: underline; color: gray;">RUTAS EXITOSAS - {{$generales->mes}}-{{$generales->ano}}</h3>
                </div>
              </div>
            </div>
            <div class="row" style="border-radius: 30px;" >
              <div class="chart-area" style="margin-bottom: 20px">
                <canvas id="exitosas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </center>
      </div>

      <hr style="border: 1px solid gray">
      <div class="row">

        <div class="col-md-12" style="margin-bottom: 20px">
          <center><h3 style="margin-left: 20px; margin-bottom: 10px; text-decoration: underline; color: gray;">SUMMARY - {{$generales->mes}}-{{$generales->ano}}</h3></center>
          <!--<button data-option="1" id="query" class="btn btn-success btn-icon">Enviar Reporte al Cliente<i class="fa fa-sign-in icon-btn"></i></button>-->
        </div>

        <!-- COSTOS -->
        <div class="col-md-4" style="margin-left: 10px;">
        	<table border="1" cellspacing="1" width="100%">

        		<tr>
        			<td style="text-align: center; background-color: #ACB9CA; color: black; border-bottom: 1px solid; font-size: 11px" align="center" colspan="8"><b>DISTRIBUCIÓN DE COSTOS</b></td>
        		</tr>
            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Novedad</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Servcios</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Costo</b></td>
        		</tr>
            <?php $total = 0;
            $arra = json_decode($generales->costos_novedades);
            arsort($arra);
            ?>
            @foreach($arra as $costoGeneral)
              <tr>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoGeneral->novedad}}</b></td>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoGeneral->cantidad}}</b></td>
                <td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoGeneral->porcentaje}} %</b></td>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>$ {{number_format($costoGeneral->costo)}}</b></td>
          		</tr>
              <?php $total = $total+$costoGeneral->cantidad; ?>
            @endforeach

            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Grand Total</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>{{$total}}</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>100%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"> <b>$ {{number_format($generales->costo_total)}}</b></td>
        		</tr>

        	</table>

        </div>

        <div class="col-md-3" style="margin-left: 10px;">

          <table border="1" cellspacing="1" width="100%">

        		<tr>
        			<td style="text-align: center; background-color: #ACB9CA; color: black; border-bottom: 1px solid; font-size: 11px" align="center" colspan="8"><b>DISTRIBUCIÓN DE COSTOS POR CAMPAÑA</b></td>
        		</tr>
            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Campaña</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Servicios</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Costo</b></td>
        		</tr>
            <?php
              $total = 0;
              $arrayss = json_decode($generales->costos_campana);
              arsort($arrayss);
            ?>
            @foreach($arrayss as $costoCampana)
              <tr>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoCampana->campana}}</b></td>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoCampana->cantidad}}</b></td>
                <td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoCampana->porcentaje}}%</b></td>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>$ {{number_format($costoCampana->costo)}}</b></td>
          		</tr>
              <?php $total = $total+$costoCampana->cantidad; ?>
            @endforeach

            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Grand Total</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>{{$total}}</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>100%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"> <b>$ {{number_format($generales->costo_total)}}</b></td>
        		</tr>


        	</table>

        </div>

        <div class="col-md-4" style="margin-left: 10px;">
          <table border="1" cellspacing="1" width="100%">

        		<tr>
        			<td style="text-align: center; background-color: #ACB9CA; color: black; border-bottom: 1px solid; font-size: 11px" align="center" colspan="8"><b>COSTOS X CAMPAÑA NOVEDAD "NO SE PRESENTO"</b></td>
        		</tr>
            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Campaña</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Servicios</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Costo</b></td>
        		</tr>
            <?php $total = 0;
            $arrays = json_decode($generales->costos_novedad);
            arsort($arrays);
            ?>
            @foreach($arrays as $costoNovedad)
            <?php

            if($costoNovedad->costo<2000000){
              $collor = '#C6EFCE';
            }else if($costoNovedad->costo>=2000000 and $costoNovedad->costo<7000000){
              $collor = '#FFEB9C';
            }else{
              $collor = '#FFC7CE';
            }

            ?>
              <tr>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoNovedad->campana}}</b></td>
          			<td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoNovedad->cantidad}}</b></td>
                <td style="text-align: center; font-size: 11px" align="center" colspan="2"><b>{{$costoNovedad->porcentaje}} %</b></td>
          			<td style="text-align: center; background-color: {{$collor}}; font-size: 11px" align="center" colspan="2"><b>$ {{number_format($costoNovedad->costo)}}</b></td>
          		</tr>
              <?php $total = $total+$costoNovedad->cantidad; ?>
            @endforeach

            <tr>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>Grand Total</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>{{$total}}</b></td>
              <td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>100%</b></td>
        			<td style="text-align: center; background-color: #D9E1F2; color: black; font-size: 11px" align="center" colspan="2"><b>$ {{number_format($generales->costos_no_transportado)}}</b></td>
        		</tr>


        	</table>

        </div>
        <!-- COSTOS -->

      </div>
      <hr style="border: 1px solid gray">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 20px">
          <center>
            <h3 style="margin-left: 20px; margin-bottom: 10px; text-decoration: underline; color: gray;">RUTAS NO EXITOSAS - {{$generales->mes}}-{{$generales->ano}}</h3>
            <form class="form-inline" id="form_buscar" action="{{url('reportes/exportaramonestados')}}" method="post">

              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 hidden">
                  <div class="input-group">
                    <div class="input-group date" id="datetimepicker1">
                        <input value="{{$generales->fecha_inicial}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
                    </div>
                  </div>
              </div>
              <input type="text" name="cc" value="{{$generales->cliente}}" class="hidden">
              <input type="text" name="id_reporte" value="{{$generales->id}}" class="hidden">

              <!--<button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-download icon-btn"></i></button>-->
            </form>
            <!--<a target="_blank"  type="submit" class="btn btn-info btn-icon input-font">PDF<i class="fa fa-file-pdf-o icon-btn"></i></a>-->
          </center>
        </div>

        <?php
          $sw=1;
          $count = 1;
          $col = 1;
        ?>
        @foreach($programas as $programa)
          @if($sw>5)
            <br><br>
            <?php $sw=1; ?>
          @endif
          <div class="col-md-1" style="margin-left: 5px; margin-top: 25px; width: 11.499999995%">
          	<table border="1" cellspacing="1" width="100%">

              <?php
                if($col==1){
                  $color = '#833C0C';
                }else if($col==2){
                  $color = '#A6A6A6';
                }else if($col==3){
                  $color = '#92D050';
                }else if($col==4){
                  $color = '#FFC000';
                }else if($col==5){
                  $color = '#F4B084';
                }else if($col==6){
                  $color = '#ACB9CA';
                }else if($col==7){
                  $color = '#ED7D31';
                }else if($col==8){
                  $color = 'purple';
                }else if($col==9){
                  $color = '#ED7D31';
                }else{
                  $color = '#ED7D31';
                }
                $color = '#A6A6A6';
              ?>
          		<tr>
          			<td style="text-align: center; background-color: {{$color}}; color: white; text-decoration: underline" align="center" colspan="12"><b>{{$programa->programa}}</b></td>
          		</tr>
          		<tr>
                <td style="text-align: center; background-color: {{$color}}; color: white" align="center" colspan="4">Id</td>
          			<td style="text-align: center; background-color: {{$color}}; color: white" align="center" colspan="4">Nombre</td>
          			<td style="text-align: center; background-color: {{$color}}; color: white" align="center" colspan="4">Amonestaciones</td>
          		</tr>
              <?php
              $amonestados = DB::table('usuarios_amonestados')->where('id_reporte',$programa->id_reporte)->where('programa',$programa->programa)->orderBy('cantidad', 'DESC')->get();
              ?>
              @foreach($amonestados as $user)
              <?php

                if($user->cantidad==1){
                  $color = '#0B9D4D';
                }else if($user->cantidad==2){
                  $color = '#00B050';
                }else if($user->cantidad==3){
                  $color = '#92D050';
                }else if($user->cantidad==4){
                  $color = '#EBFA70';
                }else if($user->cantidad==5){
                  $color = '#FE9979';
                }else if($user->cantidad==6){
                  $color = '#FE7979';
                }else if($user->cantidad==7){
                  $color = '#FD5959';
                }else if($user->cantidad==8){
                  $color = '#FEAB04';
                }else if($user->cantidad==9){
                  $color = '#EC6A50';
                }else{
                  $color = '#D63E20';
                }
              ?>
              <tr>
          			<td style="text-align: center; " align="center" colspan="4">{{$user->id_usuario}}</td>
                <td style="text-align: center; " align="center" colspan="4">{{$user->nombre_usuario}}</td>
          			<td style="text-align: center; background-color: {{$color}}" align="center" colspan="4">{{$user->cantidad}}</td>
          		</tr>
              <?php $count=$user->cantidad; ?>
              @endforeach

          	</table>
          </div>
          <?php $sw++; $col++;?>
        @endforeach

      </div>

    </section>


    @include('scripts.scripts')

</body>
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/conductores.js')}}"></script>

<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>

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

</script>

<script type="text/javascript">

  $(document).ready(function(){

    $.ajax({
			url: '../datas',
			method: 'post',
			data: {id: $('#id_value').val()}
		}).done(function(data){

			if(data.respuesta==true){

        //RUTAS NO EXITOSAS
        var ctxx = document.getElementById("myAreaChartt");

        var $json = JSON.parse(data.dash.costos_novedad);
        var keys = [];
        var cantidad = [];

        for(i in $json){
          keys.push(' '+$json[i].porcentaje+' % | '+$json[i].campana.trim().replace('amp;',''))
          cantidad.push($json[i].cantidad)
        }

        const datass = {
          labels: keys,
          datasets: [{
            label: 'Exitosas',
            data: cantidad,
            backgroundColor: [
              '#833C0C',
              '#A6A6A6',
              '#92D050',
              '#FFC000',
              '#F4B084',
              '#ACB9CA',
              '#ED7D31',
              'purple',
              '#6AFFAD',
              '#F71D1D',
              '#0DBCF8',
              '#FF1BD5',
              '#FEFB12'
            ],
            hoverOffset: 4
          }]
        };

        const stackedBarr = new Chart(ctxx, {
          type: 'doughnut',
          data: datass,
          options: {
              scales: {
                  x: {
                      stacked: true
                  },
                  y: {
                      stacked: true
                  }
              }
          }
        });

        //RUTAS EXITOSAS
        var ctxxx = document.getElementById("exitosas");

        var $jsonexitosas = data.exitosas;
        var $jsonno = JSON.parse(data.dash.costos_novedad);
        var keysexitosas = [];
        var cantidadexitosas = [];
        var nosepresento = [];

        for(i in $jsonexitosas){
          keysexitosas.push($jsonexitosas[i].campana.trim().replace('amp;','')+' - '+$jsonexitosas[i].porcentaje+' %')
          cantidadexitosas.push($jsonexitosas[i].cantidad)
          nosepresento.push(($jsonno[i].cantidad))
        }

        const datae = {
          labels: keysexitosas,
          datasets: [{
            label: 'RUTA EJECUTADA CON ÉXITO',
            data: cantidadexitosas,
            backgroundColor: [
              '#833C0C',
              '#A6A6A6',
              '#92D050',
              '#FFC000',
              '#F4B084',
              '#ACB9CA',
              '#ED7D31',
              'purple',
              '#6AFFAD',
              '#F71D1D',
              '#0DBCF8',
              '#FF1BD5',
              '#FEFB12'
            ],
            hoverOffset: 4
          }/*,{
            label: 'NO SE PRESENTÓ',
            data: nosepresento,
            backgroundColor: [
              '#833C0C',
              '#A6A6A6',
              '#92D050',
              '#FFC000',
              '#F4B084',
              '#ACB9CA',
              '#ED7D31',
              'purple'
            ],
            hoverOffset: 4
          }*/]
        };

        const stackedBare = new Chart(ctxxx, {
          type: 'bar',
          data: datae,
          options: {
              scales: {
                  x: {
                      stacked: true
                  },
                  y: {
                      stacked: true
                  }
              }
          }
        });
        //END RUTAS EXITOSAS


			}

		});

  });

  var htmlPaxqr = '';

  var uno = 10;
  $('.search').click(function() {

    var fecha_inicial = $('#fecha_inicial').val();
    var fecha_final = $('#fecha_final').val();

    console.log(fecha_inicial)
    formData = new FormData();
    formData.append('fecha_inicial',fecha_inicial);
    formData.append('fecha_final',fecha_final);

    $.ajax({
      type: "post",
      url: 'dashboard/consultar',
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        if (data.respuesta===true) {

          $('#realizados').html(data.realizados);
          $('#facturados').html(data.facturados);
          $('#registrados').html(data.registrados);

          var result = [data.efectivos, data.abtencion, data.autorizados];
          //stackedBar.data = result;
          stackedBar.data.datasets[0].data = result;
          stackedBar.update();

          //% de utilización del Vehículo
          var myarray = [];
          var myarray2 = [];
          var myarrayFechas = [];
          for(i in data.infovan) {
            myarray.push(parseInt(data.infovan[i].OCUPACION));
            myarrayFechas.push(data.infovan[i].fecha_dia);
          }

          for(i in data.infonauto) {
            myarray2.push(parseInt(data.infonauto[i].OCUPACION));
          }

          var result2 = myarray;
          stackedBar2.data.datasets[0].data = myarray;
          stackedBar2.data.datasets[1].data = myarray2;
          stackedBar2.data.labels = myarrayFechas;
          stackedBar2.update();

          //Usuarios Amonestados
          var myarrayAmonestados = [];
          for(i in data.amonestados){
            //myarrayAmonestados.push(data.amonestados[i].fullname)
            var name = data.amonestados[i].fullname;

            var flag = '';

            for(o in data.amonestadost){
              if(data.amonestados[i].fullname===data.amonestadost[o].fullname){
                flag += '<i class="fa fa-flag" aria-hidden="true"></i>';
              }
            }
            console.log(name)

            $tabless.row.add([
                1,
                name,
                flag,
            ]).draw().nodes().to$().attr('id', name);

          }

        }else if (data.response===false) {
          alert('Error en la ejecución!');
        }
    }
    });

  })

  var enero = 40;
  var febrero = 50;
  var marzo = 50;
  var abril = 50;
  var mayo = 60;
  var junio = 70;
  var julio = 60;
  var agosto = 60;
  var septiembre = 70;
  var octubre = 70;
  var noviembre = 70;
  var diciembre = 70;

  var resultado_des = 80;
  var resultado_sat = 60;
  var resultado_cri = 50;


/*
  var ctx2 = document.getElementById("myAreaChart2");

  const data = {
    labels: ["EFECTIVOS", "ABSTENCIÓN", "AUTORIZADOS"],
    datasets: [{
      label: 'Comportamiento de Pasajeros',
      data: [0, 0, 0],
      backgroundColor: [
        '#0097F9',
        '#F7CC0B',
        'gray',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 99, 132, 0.2)',
      ],
      borderColor: [
        'white',
        'rgb(255, 159, 64)',
        'white',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
      ],
      borderWidth: 1
    }]
  };

  const stackedBar = new Chart(ctx2, {
    type: 'bar',
    data: data,
    options: {
        scales: {
            x: {
                stacked: true
            },
            y: {
                stacked: true
            }
        }
    }
  });

  //2
  var ctx3 = document.getElementById("myAreaChart3");

  const dataS = {
    labels: [1],
    datasets: [{
      label: '% de uso VAN',
      data: [0],
      fill: true,
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1
    },
    {
      label: '% de uso AUTO',
      data: [0],
      fill: true,
      borderColor: 'orange',
      tension: 0.1
    }]
  };

  const stackedBar2 = new Chart(ctx3, {
    type: 'line',
    data: dataS,
  });

  $('.clis').click(function() {
    console.log('testtt')
    var result = [25, 99, 45];
    //stackedBar.data = result;
    stackedBar.data.datasets[0].data = result;
    stackedBar.update();
  });*/

















  //DASH SAMU






  //DASH SAMU

  var $tabless = $('#tableUser').DataTable({
        paging: true,
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            },
            responsive: true
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '1%' }, //count
            { 'sWidth': '1%' }, //cliente
            { 'sWidth': '1%' }, //tipo de ruta
        ],
        processing: true,
        "bProcessing": true
    });

    $('.data').click(function() {

      $.ajax({
        url: '../reportes/data',
        method: 'post',
        data: {}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    $('#query').click(function(e){ //Obtener access token

      $.ajax({
        url: '../query',
        method: 'post',
        data: {foto_id: 123}
      }).done(function(data){

        if(data.respuesta==true){
          alert('Success!!!')
        }else if(data.respuesta==false){

        }

      });

    });

    function goBack(){
        window.history.back();
    }

</script>
</html>
