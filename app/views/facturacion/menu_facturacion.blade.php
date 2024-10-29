<ol style="margin-bottom: 10px" class="breadcrumb">
    <!--@if(isset($permisos->facturacion->revision->ver))
        @if($permisos->facturacion->revision->ver==='on')
            <li><a href="{{url('facturacion/pagoservicios')}}" class="btn btn-default btn-icon">Wompi <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif-->
    @if(isset($permisos->facturacion->revision->ver))
        @if($permisos->facturacion->revision->ver==='on')
            <li><a href="{{url('facturacion/clientes')}}" class="btn btn-default btn-icon">Novedades <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->facturacion->revision->ver))
        @if($permisos->facturacion->revision->ver==='on')
            <li><a href="{{url('facturacion/dashboard')}}" class="btn btn-default btn-icon">Dashboard <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->facturacion->revision->ver))
        @if($permisos->facturacion->revision->ver==='on')
            <li><a href="{{url('facturacion/revision')}}" class="btn btn-default btn-icon">Revision <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->facturacion->liquidacion->ver))
        @if($permisos->facturacion->liquidacion->ver==='on')
            <li><a href="{{url('facturacion/liquidacion')}}" class="btn btn-default btn-icon">Liquidacion <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->facturacion->autorizar->ver))
        @if($permisos->facturacion->autorizar->ver==='on')
            <li><a href="{{url('facturacion/autorizacionservicios')}}" class="btn btn-default btn-icon">Pendientes por Autorizar <i class="fa fa-sign-in icon-btn"></i></a></li>
                <li><a href="{{url('facturacion/serviciosautorizados')}}" class="btn btn-default btn-icon">Autorizados <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(isset($permisos->facturacion->ordenes_de_facturacion->ver))
        @if($permisos->facturacion->ordenes_de_facturacion->ver==='on')
            <li><a href="{{url('facturacion/ordenesfacturacion')}}" data-jq-dropdown="#jq-dropdown-1" class="btn btn-default btn-icon">Ordenes de Facturacion <i class="fa fa-sign-in icon-btn"></i></a></li>
            <li><a href="{{url('facturacion/facturasconap')}}" data-jq-dropdown="#jq-dropdown-1" class="btn btn-default btn-icon">Con AP Sin Ingreso <i class="fa fa-sign-in icon-btn"></i></a></li>
            <!--<li class="dropdown">
                <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Facturas <span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{url('facturacion/facturasanuladas')}}">Facturas Anuladas</a></li>
                    <li><a href="{{url('facturacion/facturasporvencer')}}">Facturas por Vencer</a></li>
                    <li><a href="{{url('facturacion/facturasvencidas')}}">Facturas Vencidas</a></li>
                    <li><a href="{{url('facturacion/facturasconingreso')}}">Facturas con Ingreso</a></li>
                    <li><a href="{{url('facturacion/facturasrevisadas')}}">Facturas Revisadas</a></li>
                </ul>
            </li>-->
        @endif
    @endif
</ol>
