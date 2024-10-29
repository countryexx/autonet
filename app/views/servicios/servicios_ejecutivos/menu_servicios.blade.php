<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->barranquilla->transportesbq->ver))
        @if($permisos->barranquilla->transportesbq->ver==='on')
            <li><a href="{{url('transportesbaq')}}">Servicios</a></li>
        @endif
    @endif
    @if(isset($permisos->barranquilla->transportesbq->ver))
        @if($permisos->barranquilla->transportesbq->ver==='on')
            <li><a href="{{url('transportesrutas')}}">Rutas</a></li>
        @endif
    @endif
    @if(isset($permisos->barranquilla->transportesbq->ver))
        @if($permisos->barranquilla->transportesbq->ver==='on')
            <li><a href="{{url('serviciosyrutasbarranquilla')}}">Servicos y Rutas </a></li>
        @endif
    @endif
</ol>