<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    <style type="text/css">
    	iframe {
		width: 500px;
		height: 350px;
		}
        .parpadea {
        
        animation-name: parpadeo;
        animation-duration: 4s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;

        -webkit-animation-name:parpadeo;
        -webkit-animation-duration: 3s;
        -webkit-animation-timing-function: linear;
        -webkit-animation-iteration-count: infinite;

        color: orange
      }
      @keyframes parpadeo {  
        0% { opacity: 1.0; }
         50% { opacity: 0.0; }
        100% { opacity: 1.0; }
      }
        

        .img-icon {
          width: 280px;
          height: 160px;
          
          border-radius: 4px;
          margin-bottom: 16px;
        }

    </style>
</head>

@include('scripts.styles')

<body>


@include('admin.menu')
<!--<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=wNKkNjkStawzchJIfAl6Jkq5Q52vaXWhI87FB3NMaxBUdkGDBbyGgsbwxGVi"></script></span>-->
@if(Sentry::getUser()->usuario_portal===0)
	@include('admin.mensaje')
  @include('otros.pusher.servicios_cancelados')
@endif

@if(Sentry::getUser()->usuario_portal===1 and (Sentry::getUser()->centrodecosto_id==19 || Sentry::getUser()->centrodecosto_id==287))
  @include('admin.mensaje_bienvenida')
@endif

@include('scripts.scripts')

</body>
</html>
