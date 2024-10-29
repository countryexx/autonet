<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('servicios');

  channel.bind('mobile', function(data) {

    var empresarial = parseInt(data.empresarial);
    var cancelados = parseInt(data.cancelados);
    var pagados = parseInt(data.pagados);
    var sin_tarifa = parseInt(data.sin_tarifa);

    var servicios_count = cancelados+empresarial+pagados+sin_tarifa;

    if(servicios_count>0){

      if (!$('.servicios_mobile_badge').hasClass('fontbulger')) {

        $('.servicios_mobile_badge').addClass('fontbulger');

      }
      $('.servicios_mobile_badge').addClass('fontbulger').text(servicios_count);

    }else{

      if ($('.servicios_mobile_badge').hasClass('fontbulger')) {

        $('.servicios_mobile_badge').removeClass('fontbulger');

      }
      $('.servicios_mobile_badge').removeClass('fontbulger').text(servicios_count);

    }

    if(empresarial>0){
      $('.list_empresariales .badge_menu').removeClass('hidden').text(empresarial);
    }else{
      $('.list_empresariales .badge_menu').addClass('hidden').text(empresarial)
    }

    if(cancelados>0){
      $('.list_cancelados .badge_menu').removeClass('hidden').text(cancelados);
    }else{
      $('.list_cancelados .badge_menu').addClass('hidden').text(cancelados);
    }

    if(pagados>0){
      $('.list_pagados .badge_menu').removeClass('hidden').text(pagados);
    }else{
      $('.list_pagados .badge_menu').addClass('hidden').text(pagados);
    }

    if(sin_tarifa>0){
      $('.list_sin_tarifa .badge_menu').removeClass('hidden').text(sin_tarifa);
    }else{
      $('.list_sin_tarifa .badge_menu').addClass('hidden').text(sin_tarifa);
    }

  });

  Pusher.logToConsole = true;

  var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel2 = pusher2.subscribe('servicios');

  channel2.bind('mobile', function(data) {

    var cantidad = parseInt(data.cantidad);

    var servicios_count = cantidad;

    if(servicios_count>0){

      if (!$('.servicio_mobil_badge').hasClass('fontbulger')) {

        $('.servicio_mobil_badge').addClass('fontbulger').text(servicios_count);

      }

    }else{

      $('.servicio_mobil_badge').removeClass('fontbulger').text(servicios_count);

    }

  });

  /*Servicios que inician los conductores en tiempo real START*/
  /*Pusher.logToConsole = true;

  var pusherss = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channelss = pusherss.subscribe('inicio_servicio');

  channelss.bind('scheduled', function(data) {

    var id = parseInt(data.id);
    var nombre = data.conductor;
    var hora = data.hora;
    var cliente = data.cliente;

    $('.'+id+'').addClass('parpadea').attr('style', 'margin-bottom: 5px; padding: 5px 8px; background: #409641');
    $('.'+id+'').attr('data-target','.mymodal4');
    $('#'+id+id+'').html('EN SERVICIO').attr('style', 'background: #409641; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;');
    $('.acepted'+id+'').addClass('hidden');

    playPause();

    $.confirm({
        title: 'SERVICIO INICIADO',
        content: 'El conductor <b>'+nombre+'</b> ha INICIADO el servicio de las <b>'+hora+'</b> del cliente <b>'+cliente+'</b>.',
        buttons: {
            confirm: {
                text: 'OK',
                btnClass: 'btn-success',
                keys: ['enter', 'shift'],
                action: function(){

                  //$("html, body").animate({ scrollTop: $("."+id+"").scrollTop() }, 1000);

                }

            },
            cancel: {
              text: 'Volver',
            }
        }
    });

  });*/
  /*Servicios que inician los conductores en tiempo real END*/

  /*Servicios que finalizan los conductores en tiempo real START*/
  /*Pusher.logToConsole = true;

  var pusherssf = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channelssf = pusherssf.subscribe('fin_servicio');

  channelssf.bind('ended', function(data) {

    var id = parseInt(data.id);
    var nombre = data.conductor;
    var hora = data.hora;
    var cliente = data.cliente;

    $('.'+id+'').removeClass('parpadea').attr('style', 'margin-bottom: 5px; padding: 5px 8px; background: #de0000');
    $('#'+id+id+'').html('FINALIZADO').attr('style', 'background: #de0000; color: white; margin: 2px 0px; font-size: 9px; padding: 3px 5px; width: 67px; border-radius: 2px;');

    playPause();

    $.confirm({
        title: 'SERVICIO FINALIZADO',
        content: 'El conductor <b>'+nombre+'</b> ha FINALIZADO el servicio de las <b>'+hora+'</b> del cliente <b>'+cliente+'</b>.',
        buttons: {
            confirm: {
                text: 'OK',
                btnClass: 'btn-danger',
                keys: ['enter', 'shift'],
                action: function(){

                    $("html, body").animate({ scrollTop: $("."+id+"").scrollTop() }, 1000);

                }

            },
            cancel: {
              text: 'Volver',
            }
        }
    });

  });*/
  /*Servicios que finalizan los conductores en tiempo real END*/

  /*function playPause(){
        audio.play();
  }*/

</script>
