<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('dashboard');

  channel.bind('datos', function(data) {

    var valor = parseInt(data.valor);
    var resultado_des = parseInt(data.resultado_deseado);
    var resultado_sat = parseInt(data.resultado_satisfactorio);
    var resultado_cri = parseInt(data.resultado_critico);

    //document.getElementById("myAreaChart").value('');

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
          data: [data.enero, data.febrero, data.marzo, data.abril, data.mayo, data.junio, data.julio, data.agosto, data.septiembre, data.octubre, data.noviembre, data.diciembre],
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
        maintainAspectRatio: true,
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
  });

  Pusher.logToConsole = true;
/*
  var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel2 = pusher2.subscribe('servicio');

  channel2.bind('mobil', function(data) {

    var cantidad = parseInt(data.cantidad);

    var servicios_count = cantidad;

    if(servicios_count>0){

        $('.servicio_mobil_badge').addClass('fontbulger').text(servicios_count);
      

      $('.titulo_page').html('('+servicios_count+') Autonet | Servicios y Rutas BOG');

    }else{

      $('.servicio_mobil_badge').removeClass('fontbulger').text(servicios_count);

      $('.titulo_page').html('Autonet | Servicios y Rutas BOG');

    }

  });

  var pusher3 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel3 = pusher3.subscribe('serv');

  channel3.bind('autonet', function(data) {

    var cantidad = parseInt(data.cantidad);

    var contadora = cantidad;

    if(contadora>0){

        $('.servicios_autonet_badge').addClass('fontbulger').text(contadora);
      

      //$('.titulo_page').html('('+servicios_count+') Autonet | Servicios y Rutas BOG');

    }else{

      $('.servicios_autonet_badge').removeClass('fontbulger').text(contadora);

      //$('.titulo_page').html('Autonet | Servicios y Rutas BOG');

    }

  });*/

</script>
