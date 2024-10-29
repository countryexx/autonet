<!--solo para area de transportes se coloca la notificacion -->
@if(Sentry::getUser()->id_rol === 1 || Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 4 ||
    Sentry::getUser()->id_rol === 10 || Sentry::getUser()->id_rol === 3 || Sentry::getUser()->id_rol === 11 ||
    Sentry::getUser()->id_rol === 16 || Sentry::getUser()->id_rol === 8)
  <script src="{{url('boostrap_notify/bootstrap-notify.min.js')}}"></script>
  <script src="https://www.gstatic.com/firebasejs/4.8.1/firebase.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.2.0/firebase-messaging.js"></script>
  <script src="{{asset('firebase_init.js')}}"></script>
  <script>

    // Retrieve Firebase Messaging object.
    const messaging = firebase.messaging();

    navigator.serviceWorker.register('{{asset('firebase-messaging-sw.js')}}')
    .then((registration) => {
      messaging.useServiceWorker(registration);

      messaging.requestPermission()
      .then(function() {
        console.log('Notification permission granted.');

        messaging.getToken()
        .then(function(token) {

          $.ajax({
            url: '{{url('transportes').'/registraridweb'}}',
            method: 'post',
            data: {
                token: token
            },
            type: 'json'
          }).done(function(data){
            console.log(data.respuesta);
          });

        }).catch(function(err) {
          console.log('Unable to retrieve token ', err);
          showToken('Unable to retrieve token ', err);
        });


      })
      .catch(function(err) {
        console.log('Unable to get permission to notify.', err);
      });
    });

    messaging.onTokenRefresh(function() {
      messaging.getToken()
      .then(function(refreshedToken) {
        console.log('Token refreshed.');
      })
      .catch(function(err) {
        console.log('Unable to retrieve refreshed token ', err);
        showToken('Unable to retrieve refreshed token ', err);
      });
    });

    messaging.onMessage(function(payload) {

      @if(Sentry::getUser()->id_rol==8 or Sentry::getUser()->id_rol==1)

        if(payload.data.modulo=='facturacion'){

          $.notify({
            icon: '{{asset('image_notifications.png')}}',
            title: 'AUTONET',
            message: payload.notification.body
          },{
            type: 'minimalist',
            icon_type: 'image',
            template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' +
              '<img data-notify="icon" class="img-circle pull-left">' +
              '<span data-notify="title">{1}</span>' +
              '<span data-notify="message">{2}</span>' +
              '<button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;">×</button>'+
            '</div>',
            newest_on_top: true,
            mouse_over: 'pause',
            delay: 1000,
            timer: 180000
          });

        }

      @endif

      if(payload.data.modulo==null){

        $.notify({
          icon: '{{asset('image_notifications.png')}}',
          title: 'AUTONET',
          message: payload.notification.body
        },{
          type: 'minimalist',
          icon_type: 'image',
          template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">' +
            '<img data-notify="icon" class="img-circle pull-left">' +
            '<span data-notify="title">{1}</span>' +
            '<span data-notify="message">{2}</span>' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1033;">×</button>'+
          '</div>',
          newest_on_top: true,
          mouse_over: 'pause',
          delay: 1000,
          timer: 180000
        });

      }

    });

  </script>
@endif
