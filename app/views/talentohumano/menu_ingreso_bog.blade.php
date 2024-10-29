<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->talentohumano->control_ingreso_bog->ver))
        @if($permisos->talentohumano->control_ingreso_bog->ver==='on')
            <li><a href="{{url('control/controlbog')}}">Control de Ingreso</a></li>
        @endif
    @endif
    @if(isset($permisos->talentohumano->control_ingreso_bog->historial))
        @if($permisos->talentohumano->control_ingreso_bog->historial==='on')
            <li><a href="{{url('control/historialllegadabog')}}">Histórico</a></li>
        @endif
    @endif    
    
</ol>