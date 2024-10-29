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

    <link rel="stylesheet" href="{{url('css/jquery.dataTables.min.css')}}">

    <script src="{{url('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{url('js/jquery.dataTables.min.js')}}"></script>

    <style>

      body {
        background-color: #EAECEA;
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
      	padding:$base-spacing-unit;
      	font-family:'Source Sans Pro', sans-serif;
      	margin:0;
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

    <!--<div class="row" style="margin-left: 0px; margin-top: 20px">

      <div class="col-lg-6">

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
    </div>-->

    <section class="content">
      <div class="row">
        <div class="col-md-5" style="height: 500px; margin-left: 80px;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-8">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Rutas no Exitosas </h3>
                </div>
                <!--<a style="margin-top: 25px; margin-bottom: 30px;" class="btn btn-primary btn-icon data">Data<i class="fa fa-arrow-down icon-btn"></i></a>-->
              </div>
            </div>
            <?php
            /*$values = 0;

            for ($i=0; $i <count($rutas_no); $i++) {
              $values++;
            }

            echo $values;*/
            ?>
            <div class="row" style="border-radius: 30px;">
              <div class="chart-area" style="margin-bottom: 20px">
                <canvas id="myAreaChartt"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5" style="height: 500px; margin-left: 80px;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-8">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Rutas Exitosas </h3>
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

        <div class="col-md-5" style="height: 100px; margin-left: 70px;">
          <div class="box box-primary" style="height: 100px;">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-11">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Costos por Campaña </h3>
                </div>
              </div>
            </div>
            <div class="row" style="border-radius: 30px;" >
              <div class="chart-area" style="margin-bottom: 20px">
                <canvas id="costos_campana"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5" style="height: 500px; margin-left: 70px;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-8">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> % Utilización </h3>
                </div>
              </div>
            </div>
            <div class="row" style="border-radius: 30px;" >
              <div class="chart-area" style="margin-bottom: 20px">
                <canvas id="utilizacion"></canvas>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5" style="height: 500px; margin-left: 70px;">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-8">
                  <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Costos </h3>
                </div>
              </div>
            </div>
            <div class="row" style="border-radius: 30px;" >
              <p>Distribución de Costos por Campaña</p>

              	<div class="table">
              		<div class="table-header">
              			<div class="header__item"><a id="name" class="filter__link">Campaña</a></div>
              			<div class="header__item"><a id="wins" class="filter__link filter__link--number">Servicios</a></div>
              			<div class="header__item"><a id="draws" class="filter__link filter__link--number">% de Partición</a></div>
              			<div class="header__item"><a id="losses" class="filter__link filter__link--number">Costo</a></div>
              		</div>
              		<div class="table-content">
              			<!--<div class="table-row">
              				<div class="table-data">CAPITAL ONE</div>
              				<div class="table-data">11,890</div>
              				<div class="table-data">65%</div>
              				<div class="table-data">$ 45,289,900.00</div>
              			</div>
                    <div class="table-row">
              				<div class="table-data">DIRECT TV</div>
              				<div class="table-data">1,890</div>
              				<div class="table-data">65%</div>
              				<div class="table-data">$ 8,237,112.00</div>
              			</div>
              			<div class="table-row">
              				<div class="table-data">GO DADDY</div>
              				<div class="table-data">1,560</div>
              				<div class="table-data">20%</div>
              				<div class="table-data">$ 7,287,389.00</div>
              			</div>
              			<div class="table-row">
              				<div class="table-data">AIRBNB</div>
              				<div class="table-data">882</div>
              				<div class="table-data">28%</div>
              				<div class="table-data">$ 2,890,000.00</div>
              			</div>
                    <div class="table-header">
                			<div class="header__item"><a id="name" class="filter__link" href="#">Totales</a></div>
                			<div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">16,222</a></div>
                			<div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">100 %</a></div>
                			<div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">$ 63,704,401 </a></div>
                		</div>-->

              		</div>
              	</div>

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

  $(document).ready(function(){

    $.ajax({
			url: 'datas',
			method: 'post',
			data: {id: 1}
		}).done(function(data){

			if(data.respuesta==true){

        //RUTAS NO EXITOSAS
        var ctxx = document.getElementById("myAreaChartt");

        var $json = JSON.parse(data.dash.rutas_no_exitosas);
        var keys = [];
        var cantidad = [];

        for(i in $json){
          keys.push($json[i].campana)
          cantidad.push($json[i].cantidad)
        }

        const datass = {
          labels: keys,
          datasets: [{
            label: 'My First Dataset',
            data: cantidad,
            backgroundColor: [
              '#FF0429',
              '#06F90A',
              'rgb(255, 205, 86)',
              '#06F9DB',
              '#817474'
            ],
            hoverOffset: 4
          }]
        };

        const stackedBarr = new Chart(ctxx, {
          type: 'pie',
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

        var $jsonexitosas = JSON.parse(data.dash.rutas_exitosas);
        var keysexitosas = [];
        var cantidadexitosas = [];

        for(i in $jsonexitosas){
          keysexitosas.push($jsonexitosas[i].campana)
          cantidadexitosas.push($jsonexitosas[i].cantidad)
        }

        const datae = {
          labels: keysexitosas,
          datasets: [{
            label: 'My First Dataset',
            data: cantidadexitosas,
            backgroundColor: [
              '#FF0429',
              '#06F90A',
              'rgb(255, 205, 86)',
              '#06F9DB',
              '#817474'
            ],
            hoverOffset: 4
          }]
        };

        const stackedBare = new Chart(ctxxx, {
          type: 'pie',
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

        //COSTOS POR CAMPAÑA
        var ctxxxy = document.getElementById("costos_campana");

        var $jsoncosto = JSON.parse(data.dash.costos_campana);
        var keyscosto = [];
        var cantidadcosto = [];
        var cantidadcoston = [];

        $('.table-content').html('');

        for(i in $jsoncosto){
          keyscosto.push($jsoncosto[i].campana)
          cantidadcosto.push($jsoncosto[i].costo)
          cantidadcoston.push($jsoncosto[i].costo_n)

          var totals = 0;
          totals = parseInt($jsoncosto[i].costo)+parseInt($jsoncosto[i].costo_n);

          var htmlData = '<div class="table-row">'+
            '<div class="table-data">'+$jsoncosto[i].campana+'</div>'+
            '<div class="table-data">'+totals+'</div>'+
            '<div class="table-data">'+$jsoncosto[i].porcentaje+'%</div>'+
            '<div class="table-data">$ '+number_format(totals)+'</div>'+
          '</div>';

          $('.table-content').append(htmlData);
          console.log(htmlData)
        }

        const datac = {
            labels: keyscosto, //colocar total de usuarios por campaña
            datasets: [{
              label: 'TRANSPORTADO',
              data: cantidadcosto,
              backgroundColor: [
                'green',
                'green',
                'green',
                'green',
                'green',
              ],
              borderColor: [
                'green',
                'green',
                'green',
                'green',
                'green',
              ],
              borderWidth: 1
            },{
              label: 'NO SE PRESENTÓ',
              data: cantidadcoston,
              backgroundColor: [
                'red',
                'red',
                'red',
                'red',
                'red',
              ],
              borderColor: [
                'red',
                'red',
                'red',
                'red',
                'red',
              ],
              borderWidth: 1
            }]
          };

          const stackedBarc = new Chart(ctxxxy, {
            type: 'bar',
            data: datac,
            options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          },
        });
        //END COSTOS POR CAMPAÑA

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




  //UTILIZACIÓN
  var ctxu = document.getElementById("utilizacion");

  const datau = {
    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15","16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30","31"],
    datasets: [
      {
        label: 'AUTO',
        data: [60,55,41,38,40,57,39,51,60,75,69,60,50,62,43,79,84,81,55,79,79,69,50,68,79,62,67,78,60,79,70],
        borderColor: 'red',
        //backgroundColor: 'blue',
      },
      {
        label: 'VAN',
        data: [80,77,89,82,80,93,91,80,90,95,91,90,88,87,81,96,89,90,76,96,89,90,86,79,88,88,81,85,85,90,96],
        borderColor: 'green',
        //backgroundColor: 'blue',
      }
    ]
  };

  const stackedBaru = new Chart(ctxu, {
    type: 'line',
    data: datau,
    options: {
      responsive: true,
      plugins: {
        tooltip: {
          mode: 'index',
          intersect: false
        },
        title: {
          display: true,
          text: 'Chart.js Line Chart'
        }
      },
      hover: {
        mode: 'index',
        intersec: false
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Month'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Value'
          },
          min: 0,
          max: 100,
          ticks: {
            // forces step size to be 50 units
            stepSize: 50
          }
        }
      }
    },
  });



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

</script>
</html>
