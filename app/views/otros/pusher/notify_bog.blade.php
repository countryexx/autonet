<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  /*Servicios que inician los conductores en tiempo real START*/
  Pusher.logToConsole = true;

  var pusherss = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channelss = pusherss.subscribe('inicio_servicio_bog');

  channelss.bind('scheduled_bog', function(data) {

    var id = parseInt(data.id);
    var nombre = data.conductor;
    var hora = data.hora;
    var cliente = data.cliente;

    $('.'+id+'').addClass('parpadea').attr('style', 'margin-bottom: 5px; padding: 5px 8px; background: #409641');
    $('.'+id+'').attr('data-target','.mymodal4');
    $('#'+id+id+'').html('EN SERVICIO').attr('style', 'background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;');
    $('.acepted'+id+'').addClass('hidden');

    //playPause();

  });
  /*Servicios que inician los conductores en tiempo real END*/

  /*Servicios que finalizan los conductores en tiempo real START*/
  Pusher.logToConsole = true;

  var pusherssf = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channelssf = pusherssf.subscribe('fin_servicio_bog');

  channelssf.bind('ended_bog', function(data) {

    var id = parseInt(data.id);
    var nombre = data.conductor;
    var hora = data.hora;
    var cliente = data.cliente;

    $('.'+id+'').removeClass('parpadea').attr('style', 'margin-bottom: 5px; padding: 5px 8px; background: #eaeaea; color: black');
    $('#'+id+id+'').html('FINALIZADO').attr('style', 'background: #eaeaea; color: black; margin: 2px 0px; font-size: 10px; padding: 3px 5px; width: 67px; border-radius: 2px;');

    //playPause2();

  });
  /*Servicios que finalizan los conductores en tiempo real END*/

  function playPause(){
    audio.play();
  }

  function playPause2(){
    audio2.play();
  }

</script>
