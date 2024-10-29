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
      $(document).ready( function () {
        $('#tableUser').DataTable();
      });
    </script>

    <!-- Inicio Styles dataTable -->

  <link rel="stylesheet" href="{{url('distdash/css/AdminLTE.min.css')}}">

  <link rel="stylesheet" href="{{url('distdash/css/skins/_all-skins.min.css')}}">
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
<body>
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
      <form id="form" action="{{url('dashboard/obtenerdatos')}}" method="get">
      <div class="col-lg-6">
        @if($cliente===287)
        <p style="font-size: 20px; font-family: times new roman">SEDE AMERICAS: {{$countamericas}} | SEDE TOBERIN: {{$counttoberin}} | SEDE TORRE KRISTAL: {{$counttorrecristal}}</p>
        @endif
        @if($cliente===19)
        <p style="font-size: 20px; font-family: times new roman">RUTAS : {{$countrutas}} | CARNAVALES : {{$countcarnavales}}</p>
        @endif
      </div>
      <div class="col-lg-2">
          <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
          <div class="input-group">
            <div class="input-group date" id="datetimepicker1">
                <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
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
              <input value="{{date('Y-m-d')}}" name="md_fecha_final" style="width: 115;" type="text" class="form-control input-font">
              <span class="input-group-addon">
                  <span class="fa fa-calendar">
                  </span>
              </span>
          </div>
        </div>
      </div>
      <div class="col-lg-1">
        <label class="obligatorio" for="subcentrodecosto_ex_excel">Show</label>
        <button type="submit" class="btn btn-success btn-icon">BUSCAR<i class="fa fa-search icon-btn"></i></button>
      </div>
      </form>
    </div>

    <section class="content">
      <div class="row">
        <div class="col-md-6">

          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-4">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">GENERAL DE SERVICIOS </h3>
                </div>
              </div>

            </div>
            <div class="row" style="border: 2px solid;">
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p style="font-family: times new roman; font-size: 50px; text-align: center;">{{$registros}}</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Usuarios Registrados</p>
              </div>
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p style="font-family: times new roman; font-size: 50px; text-align: center;">{{$recorridosrealizados}}</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Recorridos Realizados</p>
              </div>
              <div class="col-lg-4" style="margin: 98px 0 98px 0">
                <p style="font-family: times new roman; font-size: 50px; text-align: center;">{{$serviciosfacturados}}</p>
                <p style="font-family: times new roman; font-size: 25px; text-align: center;">Servicios Facturados</p>
              </div>
            </div>
          </div>

        </div>

        <!--vista 1 -->
        <div class="col-md-6">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">

              <p style="text-align: left;" class="box-title"> <i class="fa fa-bar-chart-o"></i> COMPORTAMIENTO DE PASAJEROS</p>

            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 300px;"></div>
            </div>
          </div>
        </div>
        <!-- fin vista 1 -->

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
        <div class="col-lg-12">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">USUARIOS AMONESTADOS</h3>
            </div>
              <!-- INICIO PRUEBA DE USUARIOS AMONESTADOS -->
        <div class="row" style="width: 100%; margin-left: 0px; height: 10%">
          <table id="tableUser" class="display">
            <thead>
              <tr>
                <th>#</th>
                <th>NOMBRE COMPLETO</th>
                <th>CANTIDAD DE AMONESTACIONES</th>
              </tr>
            </thead>
            <tbody>
                <?php $i = 1; $sw = 1;
                for($o=1 ; $o <= count($passe) ; $o++){
                ?>
               <?php if($passe[$o]!=null){    ?>
                  <tr>
                      <td>{{$i}}</td>
                      <td>
                     <?php  echo $passe[$o]; ?>
                       </td>
                      <td>
                        @foreach($pasajerosamonestados as $pass)
                          <?php if($pass->nombres.' '.$pass->apellidos==$passe[$o]){?>
                            <i class="fa fa-flag" aria-hidden="true"></i>
                          <?php } ?>
                        @endforeach
                     </td>
                  </tr>
                  <?php
                  $i++;
                    }
                }
                ?>
            </tbody>
          </table>
        </div>

        <!-- FIN PRUEBA DE USUARIOS AMONESTADOS -->

      </div>
        <!-- fin vista 2 -->
      </div>
      <!-- /.row -->
      <div class="row">
        <

      </div>
      <div class="col-lg-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <div class="row">
              <div class="col-lg-4">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title" >% DE UTILIZACIÓN DEL VEHÍCULO</h3>
              </div>
              @if($cliente!=19)
                <div class="col-md-3">
                  <p style="color: #545859; font-family: times new roman; font-size: 15px">AUTO <i class="fas fa-shuttle-van"></i></p>
                </div>
              @endif
              <div class="col-lg-3">
                <p style="color: #DC4405; font-family: times new roman; font-size: 15px">VAN<i class="fas fa-shuttle-van"></i></p>
              </div>
            </div>
          </div>
          <div class="box-body">
            <div id="line-chart" style="height: 300px;"></div>
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
<script></script>
<script language="JavaScript" type="text/JavaScript">
  function selODessel(obj){
    if(obj.checked){
        console.log("chulado")
    }else{
        //desSeleccionarTodos();
        console.log("DesChulado")
    }
  }

  function seleccionarTodos(){
    alert("Selecciono todos")
  }
  function desSeleccionarTodos(){
    alert("Desselecciono todos")
  }


</script>
</html>

<script src="{{url('bootstrapdash/js/bootstrap.min.js')}}"></script>
<script src="{{url('pluginsdash/fastclick/fastclick.js')}}"></script>
<script src="{{url('distdash/js/app.min.js')}}"></script>
<script src="{{url('distdash/js/demo.js')}}"></script>

<script src="{{url('pluginsdash/flot/jquery.flot.min.js')}}"></script>

<script src="{{url('pluginsdash/flot/jquery.flot.resize.min.js')}}"></script>

<script src="{{url('pluginsdash/flot/jquery.flot.pie.min.js')}}"></script>

<script src="{{url('pluginsdash/flot/jquery.flot.categories.min.js')}}"></script>
<script>
  $(function () {



    /*
     * % DE UTILIZACIÓN DE LA CAPACIDAD DEL VEHICULO
     * ----------
     */
    //LINE randomly generated data
    var num = '{{$contadorinformacion}}';

    var arrayJS=<?php echo json_encode($numero);?>;

    var arrayJS2=<?php echo json_encode($numeroauto);?>;


    var sin = [], cos = [];
    for (var i = 1; i <= num ; i += 0.5) {
      sin.push([i, (arrayJS[i])]);
      cos.push([i, arrayJS2[i]]);
    }
    var line_data1 = {
      data: sin,
      color: "#DC4405"
    };
    var line_data2 = {
      data: cos,
      color: "#545859"
    };
    $.plot("#line-chart", [line_data1, line_data2], {
      grid: {
        hoverable: true,
        borderColor: "#f3f3f3",
        borderWidth: 1,
        tickColor: "#f3f3f3"
      },
      series: {
        shadowSize: 0,
        lines: {
          show: true
        },
        points: {
          show: true
        }
      },
      lines: {
        fill: true,
        color: ["#3c8dbc", "#f56954"]
      },
      yaxis: {
        show: true,
      },
      xaxis: {
        show: true
      }
    });
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: "absolute",
      display: "none",
      opacity: 0.8
    }).appendTo("body");
    $("#line-chart").bind("plothover", function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);

        $("#line-chart-tooltip").html(" DÍA " + x + " = " + y+' %')
            .css({top: item.pageY + 5, left: item.pageX + 1})
            .fadeIn(200);
      } else {
        $("#line-chart-tooltip").hide();
      }

    });
    /* FIN* DE UTILIZACION DE LA CAPACIDAD DEL VEHICULO */

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */





    /* END AREA CHART */

    /*
     * COMPORTAMIENTO DE PASAJEROS
     * ---------
     */
     var uno = "{{$cantidadefectivos}}";
     var dos = "{{$cantidadautorizados}}";
     var tres = "{{$cantidadabstraccion}}";

    var bar_data = {
      data: [["EFECTIVOS", uno], ["ABSTENCIÓN", tres], ["AUTORIZADOS", dos]],
      color: "#DC4405"
    };
    $.plot("#bar-chart", [bar_data], {
      grid: {
        borderWidth: 1,
        borderColor: "#545859",
        tickColor: "#545859"
      },
      series: {
        bars: {
          show: true,
          barWidth: 0.5,
          align: "center"
        }
      },
      xaxis: {
        mode: "categories",
        tickLength: 0
      }
    });
    /* FIN COMPORTAMIENTO DE PASAJEROS */

    /*
     * DONUT CHART
     * -----------
     */

     //var img2 = '{{$datossatisfechos}}';
     //var img3 = '{{$datosnosatisfechos}}';

    var str = "{{$datossatisfechos}}";
    var str2 = "{{$datosnosatisfechos}}";

    var donutData = [
      {label: "", data: str, color: "#EDF516"},
      {label: "", data: 5, color: "#F11511"}
    ];
    $.plot("#donut-chart", donutData, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 3 / 4,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });
    /*
     * END DONUT CHART
     */

  });

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:25px; text-align:center; padding:2px; color: #3EFC0F; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
  }

   function consultarInfo(){

    $.ajax({
      url: 'dashboard/consultar',
      data: {
        id: id
      },
      method: 'post',
      dataType: 'json',
      success: function(data){

        if (data.respuesta===true) {

          var contadorPosicion = 0;

          //array para polilineas
          var polyLinesRuta = [];
        }
      }
    });
  }
</script>
