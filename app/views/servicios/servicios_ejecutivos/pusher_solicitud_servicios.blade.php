<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('servicios');

  channel.bind('autonetbaq', function(data) {

    var servicios_count = parseInt(data.cantidad);

    if(servicios_count>0){

      if (!$('.servicios_autonetbaq_badge').hasClass('fontbulger')) {

        $('.servicios_autonetbaq_badge').addClass('fontbulger').text(servicios_count);

      }
      $('.servicios_autonetbaq_badge').text(servicios_count);

    }else{

      if ($('.servicios_autonetbaq_badge').hasClass('fontbulger')) {

        $('.servicios_autonetbaq_badge').removeClass('fontbulger');

      }
      $('.servicios_autonetbaq_badge').text(servicios_count);

    }

    $('.baq1').text(servicios_count);

  });

  Pusher.logToConsole = true;

  var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel2 = pusher2.subscribe('servicios');

  channel2.bind('autonetbog', function(data) {

    var servicios_count = parseInt(data.cantidad);

    if(servicios_count>0){

        if (!$('.servicios_autonetbog_badge').hasClass('fontbulger')) {

            $('.servicios_autonetbog_badge').addClass('fontbulger');
        }
        $('.servicios_autonetbog_badge').text(servicios_count);

    }else{

        if ($('.servicios_autonetbog_badge').hasClass('fontbulger')) {

            $('.servicios_autonetbog_badge').removeClass('fontbulger');

        }
        $('.servicios_autonetbog_badge').text(servicios_count);

    }

    $('.bog1').text(servicios_count);

});

</script>
