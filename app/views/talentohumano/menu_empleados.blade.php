<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->talentohumano->empleados->ver))
        @if($permisos->talentohumano->empleados->ver==='on')
            <li><a href="{{url('talentohumano/personaladministrativo')}}">Empleados Administrativos</a></li>

            <li><a href="{{url('talentohumano/personaloperativo')}}">Empleados Operativos</a></li>
            
            <li><a href="{{url('talentohumano/personalretirado')}}">Empleados Retirados</a></li>
        @endif
    @endif
    
</ol>