<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->talentohumano->prestamos->ver))
        @if($permisos->talentohumano->prestamos->ver==='on')
            <li><a href="{{url('talentohumano/solicitudesdeprestamos')}}">Registro de Préstamos a Empleados</a></li>
        @endif
    @endif
    @if(isset($permisos->talentohumano->prestamos->ver))
        @if($permisos->talentohumano->prestamos->ver==='on')
            <li><a href="{{url('talentohumano/listadodeprestamos')}}">Listado de Prestamos a Empleados</a></li>
        @endif
    @endif
    @if(isset($permisos->talentohumano->vacaciones->ver))
        @if($permisos->talentohumano->vacaciones->ver==='on')
            <li><a href="{{url('talentohumano/vacaciones')}}">Vacaciones</a></li>
        @endif
    @endif
    @if(isset($permisos->talentohumano->vacaciones->ver))
        @if($permisos->talentohumano->vacaciones->ver==='on')
            <li><a href="{{url('talentohumano/listadodevacaciones')}}">Historial de Vacaciones</a></li>
        @endif
    @endif
    
</ol>