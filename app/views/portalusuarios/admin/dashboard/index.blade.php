<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Dashboard</title>
   <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">

  <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
  <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{url('animate.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="manifest" href="{{url('manifest.json')}}">
  @include('scripts.styles')

   <!-- Inicio Styles dataTable -->
    <link rel="stylesheet" href="{{url('css/jquery.dataTables.min.css')}}">

    <script src="{{url('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>

    <script>
      /*$(document).ready( function () {
        $('#tableUser').DataTable();
      });*/
    </script>

    <!-- Inicio Styles dataTable -->


    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGM6WeUAlFGPSsT5pCtu-wRzrEC-pt4yw" async defer></script>-->
    <style>

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

    </style>
</head>
<body background="{{url('biblioteca_imagenes/fondo_pdf.PNG')}}">
  @include('admin.menu')
  @if($cliente===19)
  	<?php $i = 1;  $numero = [];?>
    @foreach($infovan as $informacion)
      <?php
      $numero[$i] = $informacion->OCUPACION;
      $i++;
      ?>
    @endforeach
  @else
  <?php $i = 1;  $numero = [];?>
    @foreach($infovan as $informacion)
      <?php
      $numero[$i] = $informacion->OCUPACION;
      $i++;
      ?>
    @endforeach
  @endif

  <?php $i = 1;  $numeroauto = [];?>
  @foreach($infoauto as $informacion)
    <?php

    $numeroauto[$i] = $informacion->OCUPACION;
    $i++;
    ?>
  @endforeach

  <?php
  $datos1 = '{{$datossatisfechos}}';
  $datos2 = '{{$datosnosatisfechos}}';
  $data = '{{$cliente}}';
  ?>

    <div class="row" style="margin-left: 0px; margin-top: 20px">

      <div class="col-lg-6">
        <!--@if($cliente===287)
        <p style="font-size: 20px; font-family: times new roman">SEDE AMERICAS2: {{$countamericas}} | SEDE TOBERIN: {{$counttoberin}} | SEDE TORRE KRISTAL: {{$counttorrecristal}}</p>
        @endif
        @if($cliente===19)
        <p style="font-size: 20px; font-family: times new roman">RUTAS : {{$countrutas}} | CARNAVALES : {{$countcarnavales}}</p>
        @endif-->
      </div>

      <div class="col-lg-2">
          <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
          <div class="input-group">
            <div class="input-group date" id="datetimepicker1">
                <input value="{{date('Y-m-d')}}" id="fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
                <span class="input-group-addon">
                    <span class="fa fa-calendar">
                    </span>
                </span>
            </div>
          </div>
      </div>
      <div class="col-lg-2">
        <label class="obligatorio" for="rt_fecha_final">Fecha Final</label>
        <div class="input-group">
          <div class="input-group date" id="datetimepicker1">
              <input value="{{date('Y-m-d')}}" id="fecha_final" style="width: 115;" type="text" class="form-control input-font">
              <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </span>
          </div>
        </div>
      </div>
      <div class="col-lg-1">
        <label class="obligatorio" for="subcentrodecosto_ex_excel">Búsqueda</label>
        <button type="button" class="btn btn-primary btn-icon search">Filtrar<i class="fa fa-search icon-btn"></i></button>
      </div>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-md-5" style="margin-left: 80px;">

          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-6">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> GENERAL DE SERVICIOS</h3>
                </div>
              </div>

            </div>
            <div class="row" style="border: 2px solid;">
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p id="registrados" style="font-family: times new roman; font-size: 50px; text-align: center;">0</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Usuarios Registrados</p>
              </div>
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p id="realizados" style="font-family: times new roman; font-size: 50px; text-align: center;">0</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Recorridos Realizados</p>
              </div>
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p id="facturados" style="font-family: times new roman; font-size: 50px; text-align: center;">0</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Servicios Facturados</p>
              </div>
            </div>
          </div>

        </div>

        <div class="col-md-5" style="height: 500px; margin-left: 80px;">

          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-8">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> UTILIZACIÓN DE VEHÍCULOS </h3>
                </div>
              </div>

            </div>
            <div class="row" style="border: 2px solid;">
              <div class="chart-area" >
                <canvas id="myAreaChart3"></canvas>
              </div>
            </div>
          </div>

        </div>

        <?php $i = 1;  $passe = [];?>
        @foreach($pasajerosamonestados as $passengers)
          <?php
          $passe[$i] = $passengers->nombres.' '.$passengers->apellidos;
          $i++;
          ?>
        @endforeach
        <?php
        for($i=1;$i<=count($passe);$i++){
          for($j=1;$j<=count($passe);$j++){
            if($i!=$j){
              if($passe[$i]==$passe[$j]){
                $passe[$i]="";
              }
            }
          }
        }

        ?>

      <!--vista 2 -->

      <div class="col-md-5" style="height: 500px; margin-left: 80px;">

        <div class="box box-primary">
          <div class="box-header with-border">
            <div class="row">
              <div class="col-lg-8">
                <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> COMPORTAMIENTO DE PASAJEROS </h3>
              </div>
            </div>

          </div>
          <div class="row" style="border: 2px solid;">
            <div class="chart-area">
              <canvas id="myAreaChart2"></canvas>
            </div>
          </div>
        </div>

      </div>

      <div class="col-md-5" style="height: 500px; margin-left: 80px;">

        <div class="box box-primary">
          <div class="box-header with-border">
            <div class="row">
              <div class="col-lg-8">
                <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> USUARIOS AMONESTADOS </h3>
              </div>
            </div>

          </div>
          <div class="row" style="border: 2px solid;">
            <table id="tableUser" class="display" style="margin: 20px; width: 95%;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NOMBRE COMPLETO</th>
                  <th>CANTIDAD DE AMONESTACIONES</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

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
  });

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

</script>
</html>
