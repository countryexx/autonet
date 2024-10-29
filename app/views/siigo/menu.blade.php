<ol style="margin-bottom: 10px" class="breadcrumb">
    @if(isset($permisos->administrativo->proveedores->ver))
        @if($permisos->administrativo->proveedores->ver==='on')
            <li><a href="{{url('proveedores')}}">Correos</a></li>
        @endif
    @endif
    @if(isset($permisos->administrativo->proveedores->ver))
        @if($permisos->administrativo->proveedores->ver==='on')
            <li><a href="{{url('proveedores/nuevosproveedores')}}">Actas de Entrega</a></li>
        @endif
    @endif
    @if(isset($permisos->administrativo->proveedores->ver))
        @if($permisos->administrativo->proveedores->ver==='on')
            <li><a href="{{url('proveedores/proveedoreventual')}}">Paz y Salvo </a></li>
        @endif
    @endif
    @if(isset($permisos->administrativo->administracion_proveedores->ver))
        @if($permisos->administrativo->administracion_proveedores->ver==='on')
            <li><a href="{{url('proveedores/administracion')}}">Inventario por Empleado</a></li>
        @endif
    @endif
</ol>