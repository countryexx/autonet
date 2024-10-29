<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{$_ENV['PUSHER_APP_KEY']}}', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('reportes');

  channel.bind('usuarios', function(data) {

    var id_tabla = parseInt(data.id_tabla);
    var id_usuario = parseInt(data.id_usuario);
    var id = parseInt(data.id);

    var sw = parseInt(data.sw);

    if(sw==1){
      
      const icon = '<i class="fa fa-check" aria-hidden="true"></i>';
      $('.'+id+'').html('').append(icon).attr('style', 'color: green; font-size: 15px;');

    }else if(sw==2){

      const icon =  '<span style="font-size: 15px; color: green">'+
                      '<i class="fa fa-check" aria-hidden="true"></i>'+
                    '</span>';
      
      $('.'+id+'').append(icon);
    }else if(sw==3){
      
      $('.'+id+id+'').html('').append('INICIADO').attr('style', 'color: green; font-size: 15px;');

    }else if(sw==4){
      $('.'+id+id+'').html('').append('FINALIZADO').attr('style', 'color: red; font-size: 15px;');
    }

  });

</script>
