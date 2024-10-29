<?php

//index.php

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Autonet | Dashboard</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">

  <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="manifest" href="{{url('manifest.json')}}">
  @include('scripts.styles')

  <link rel="stylesheet" href="{{url('distdash/css/AdminLTE.min.css')}}">

  <link rel="stylesheet" href="{{url('distdash/css/skins/_all-skins.min.css')}}">

</head>

 <body>

  <div class="col-xs-2">
    <label class="obligatorio" for="rt_fecha_inicial">Fecha Inicial</label>
    <div class="input-group">
      <div class="input-group date" id="datetimepicker1">
          <input value="{{date('Y-m-d')}}" name="md_fecha_inicial" style="width: 115;" type="text" class="form-control input-font">
          <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
      </div>
    </div>
  </div>

  <?php $i = 1;  $numero = [];?>
  @foreach($infovan as $informacion)
    <?php
    $numero[$i] = $informacion->OCUPACION;
    $i++;
    ?>
  @endforeach

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
  ?>

  <div class="container-fluid">

    <div class="row">
      <p style="font-family: Copperplate; font-size: 40px; text-align: center; color: #FF5733; float: left; margin-left: 30px">{{$nombrecentrodecosto}}</p>
    <!-- <img style="margin-top: 20px; float: right; margin-right: 40px" src="{{url('img/logo_aotour.png')}}" width="200px;"> -->
    </div>

   <!--
    <div class="row" style="margin-left: 1px">
      <div class="col-lg-6" style="float: left;">
        <a href="{{URL::previous()}}" class="btn btn-primary">
         <i class="fa fa-arrow-left" aria-hidden="true"></i>    REGRESAR
        </a>
      </div>

    </div>
  -->

    <section class="content">
      <div class="row">
        <div class="col-md-6">

          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-4">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">GENERAL DE SERVICIOS s</h3>
                </div>
                <div class="col-lg-6">
                  <h6> AMERICAS: {{$countamericas}} , TOBERIN: {{$counttoberin}} , TORRE CRISTAL: {{$counttorrecristal}}</h6>
                </div>
              </div>

            </div>
            <div class="row">
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

          <!-- /.box -->
          <!-- Line chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-lg-6">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title" >% DE UTILIZACIÓN DEL VEHÍCULO</h3>
                </div>
                <div class="col-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <p style="color: green">AUTO<i class="fa fa-car" aria-hidden="true"></i></p>
                    </div>
                    <div class="col-lg-6">
                      <p style="color: red">VAN<i class="fa fa-bus" aria-hidden="true"></i></p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="box-body">
              <div id="line-chart" style="height: 300px;"></div>
            </div>
          </div>

        </div>

        <!--vista 1 -->
        <div class="col-md-6">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <h5 style="text-align: center;" class="box-title"> <i class="fa fa-bar-chart-o"></i> COMPORTAMIENTO DE PASAJEROS</h5>
              </div>
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
        <div class="col-lg-6">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>
              <h3 class="box-title">USUARIOS AMONESTADOS</h3>
            </div>

        <div class="row" style="width: 100%; margin-left: 0px;">
          <table  class="table table-bordered">
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
      </div>
        <!-- fin vista 2 -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <!-- interactive chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO</h3>
              <div class="box-tools pull-right">
                <p style="font-family: times new roman">Tiempo Real</p>
                <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                  <button type="button" class="btn btn-default btn-xs active" data-toggle="on">SI</button>
                  <button type="button" class="btn btn-default btn-xs" data-toggle="off">NO</button>
                </div>
              </div>

            </div>
            <div class="box-body">
              <div id="interactive" style="height: 300px;"></div>
            </div>

          </div>


        </div>

      </div>

    </section>
    @include('modales.rutas.modaldashboard')

  </div>

<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('datatables/media/js/dataTables.bootstrap.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/pasajeros.js')}}"></script>
</body>

</html>

<!-- jQuery 2.2.3 -->

<script src="{{url('pluginsdash/jQuery/jquery-2.2.3.min.js')}}"></script>

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
     * COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data = [], totalPoints = 4;

    function getRandomData() {

      if (data.length > 0)
        data = data.slice(1);

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y = prev + Math.random() * 10 - 5;

        if (y < 0) {
          y = 0;
        } else if (y > 100) {
          y = 100;
        }

        data.push(y);
      }

      // Zip the generated y values with the x values
      var res = [];
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]]);
      }

      return res;
    }

    var interactive_plot = $.plot("#interactive", [getRandomData()], {
      grid: {
        borderColor: "#0571DE",
        borderWidth: 1,
        tickColor: "#4FFF03"
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color: "#3c8dbc"
      },
      lines: {
        fill: true, //Converts the line chart to area chart
        color: "#3c8dbc"
      },
      yaxis: {
        min: 0,
        max: 100,
        show: true
      },
      xaxis: {
        show: true
      }
    });

    var updateInterval = 500; //Fetch data ever x milliseconds
    var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()]);

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw();
      if (realtime === "on")
        setTimeout(update, updateInterval);
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === "on") {
      update();
    }
    //REALTIME TOGGLE
    $("#realtime .btn").click(function () {
      if ($(this).data("toggle") === "on") {
        realtime = "on";
      }
      else {
        realtime = "off";
      }
      update();
    });
    /*
     * FIN COMPORTAMIENTO MENSUAL EN TIEMPO DE RECORRIDO
     */


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
      sin.push([i, arrayJS[i]]);
      cos.push([i, arrayJS2[i]]);
    }
    var line_data1 = {
      data: sin,
      color: "red"
    };
    var line_data2 = {
      data: cos,
      color: "green"
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
      color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
      grid: {
        borderWidth: 1,
        borderColor: "#4FFF03",
        tickColor: "#4FFF03"
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
</script>
