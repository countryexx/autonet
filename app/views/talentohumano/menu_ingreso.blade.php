<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->talentohumano->control_ingreso->ver))
        @if($permisos->talentohumano->control_ingreso->ver==='on')
            <li><a href="{{url('control')}}">Control de Ingreso</a></li>
        @endif
    @endif
    @if(isset($permisos->talentohumano->control_ingreso->historial))
        @if($permisos->talentohumano->control_ingreso->historial==='on')
            <li><a href="{{url('control/historialllegada')}}">Histórico</a></li>
        @endif
    @endif    
    
</ol>