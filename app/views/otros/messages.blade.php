<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var canal = "<?php echo $id_ser; ?>"

  var channel = pusher.subscribe(canal);

  channel.bind('messages', function(data) {

    var info = data.info;

    var id = 1;

    $('.conversacion').html('');

    var $json = JSON.parse(data.motivo);
    console.log($json)

    var htmlJson = '';
    var cont = 1;
    var nombre = '';

    for(i in $json){
      if($json[i].usuario==2){
        var color = '#EDC9C0';
        var col = 'usuario1';
        nombre = $json[i].date+' '+$json[i].time;
        var flo = 'right';
        var radius = '10px 10px 10px 10px';
      }else{
        var color = '#A2C0BD';
        var col = 'usuario2';
        nombre = $json[i].date+' '+$json[i].time;
        var flo = 'right';
        var radius = '10px 10px 10px 10px';
      }
      htmlJson += '<div class="col-lg-12" style="background: #f47321; height:  100px; margin-bottom: 10px">'+
                        '<span style="margin-top: 4px; font-size: 11px; color: white; float: right;">'+nombre+'</span>'+
                        '<span style="color:  white; font-family: Bahnschrift; font-size: 11px; float: left; margin-top: 10px;">'+$json[i].mensaje+'</span>'+
                      '</div>';
        cont++;
        $('.conversacion').append(htmlJson);
        htmlJson = '';
    }


    //$('#mensajes').html('Hola! Bienvenido a colombia. Me encuentro en el aeropuerto, terminal 2.');

  });

  Pusher.logToConsole = true;

</script>
