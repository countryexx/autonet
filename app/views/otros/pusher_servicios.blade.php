<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('contabilidad');

  channel.bind('cuenta', function(data) {

    var empresarial = parseInt(data.empresarial);
    //var cancelados = parseInt(data.cancelados);
    //var pagados = parseInt(data.pagados);
    //var sin_tarifa = parseInt(data.sin_tarifa);

    //var servicios_count = cancelados+empresarial+pagados+sin_tarifa;

    if(empresarial>0){

      if (!$('.contabilidad_cuenta_badge').hasClass('fontbulger')) {
        $('.contabilidad_cuenta_badge').addClass('fontbulger');
      }
    }else{
      if ($('.contabilidad_cuenta_badge').hasClass('fontbulger')) {
        $('.contabilidad_cuenta_badge').removeClass('fontbulger');
      }
    }

    $('.contabilidad_cuenta_badge').addClass('fontbulger').text(empresarial);

  });

  //RESPUESTA DE REVISIÓN
  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('contabilidad');

  channel.bind('cuentares', function(data) {

    var cantidad = parseInt(data.cantidad);
    //var cancelados = parseInt(data.cancelados);
    //var pagados = parseInt(data.pagados);
    //var sin_tarifa = parseInt(data.sin_tarifa);

    //var servicios_count = cancelados+empresarial+pagados+sin_tarifa;

    if(cantidad>0){

      if (!$('.contabilidad_cuenta2_badge').hasClass('fontbulger')) {
        $('.contabilidad_cuenta2_badge').addClass('fontbulger');
      }
    }else{
      if ($('.contabilidad_cuenta2_badge').hasClass('fontbulger')) {
        $('.contabilidad_cuenta2_badge').removeClass('fontbulger');
      }
    }

    $('.contabilidad_cuenta2_badge').text(cantidad);

  });
  //FIN RESPUESTA DE REVISIÓN

  Pusher.logToConsole = true;

  //INICIO PUSHER SERVICIOS DE BOGOTÁ
  var pusher2 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var pusher2 = pusher2.subscribe('contabilidad');

  pusher2.bind('acuenta', function(data) {

    var proceso = parseInt(data.proceso);
    var cuenta_id = parseInt(data.cuenta_id);
    
    //location.reload();

  });
  //FIN PUSHER SERVICIOS DE BOGOTÁ

  //INICIO PUSHER SERVICIOS DE BARRANQUILLA
  var pusher3 = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel3 = pusher3.subscribe('serviciob');

  channel3.bind('mobilb', function(data) {

    var proceso = parseInt(data.proceso);
    var cuenta_id = parseInt(data.cuenta_id);

    var servicios_count = cantidad;

    if(servicios_count>0){
      $('.serviciob_mobilb_badge').addClass('fontbulger').text(servicios_count);
      $('.titulo_page').html('('+servicios_count+') Autonet | Servicios y Rutas BAQ');
    }else{
      $('.serviciob_mobilb_badge').removeClass('fontbulger').text(servicios_count);
      $('.titulo_page').html('Autonet | Servicios y Rutas BAQ');
    }

  });
  //FIN PUSHER SERVICIOS DE BARRANQUILLA

  //INICIO PUSHER SERVICIOS SOLICITADOS POR EL CLIENTE EN AUTONET
  var pusherservicios_autonet = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channelservicios_autonet = pusherservicios_autonet.subscribe('serv');

  channelservicios_autonet.bind('autonet', function(data) {

    var cantidad = parseInt(data.cantidad);

    var contadora = cantidad;

    if(contadora>0){
      $('.serv_autonet_badge').addClass('fontbulger').text(contadora);
    }else{
      $('.serv_autonet_badge').removeClass('fontbulger').text(contadora);
    }

  });
  //FIN PUSHER SERVICIOS SOLICITADOS POR EL CLIENTE EN AUTONET
</script>
