<ol style="margin-bottom: 5px" class="breadcrumb">
     @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
        @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
            <li><a href="{{url('facturacion/prestamosproveedores')}}" class="btn btn-default btn-icon">Préstamos <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
     @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
        @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
            <li><a href="{{url('facturacion/listadoprestamosproveedores')}}" class="btn btn-default btn-icon">Lista de Préstamos <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
       @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
           <li><a href="{{url('facturacion/listadoanticiposproveedores')}}" class="btn btn-default btn-icon">Lista de Anticipos <i class="fa fa-sign-in icon-btn"></i></a></li>
       @endif
   @endif
</ol>
