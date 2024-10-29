<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(Sentry::getUser()->id===5489 or Sentry::getUser()->id===5486 or Sentry::getUser()->id===5502 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/nuevosvehiculos')}}">Vehículos Disponibles</a></li>
    @endif

    @if(Sentry::getUser()->id===5489 or Sentry::getUser()->id===5486 or Sentry::getUser()->id===5502 or Sentry::getUser()->id===4646 or Sentry::getUser()->id===5474 or Sentry::getUser()->id===170 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/vehiculosenrevision')}}">En Revisión</a></li>
    @endif

    @if(Sentry::getUser()->id===4646 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/nuevosproveedores')}}">Juridica</a></li>
    @endif

    @if(Sentry::getUser()->id===5474 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/seguridadsocial')}}">TH</a></li>
    @endif

    @if(Sentry::getUser()->id===170 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/datosfinancieros')}}">Contabilidad</a></li>
    @endif

    @if(Sentry::getUser()->id===4646 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/capacitacion')}}">Capacitación</a></li>
    @endif

    @if(Sentry::getUser()->id===4646 or Sentry::getUser()->id===2)
        <li><a href="{{url('portalproveedores/conductoresagregados')}}">Conductores Agregados</a></li>
    @endif
</ol>
