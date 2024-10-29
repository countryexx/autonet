<ol style="margin-bottom: 5px" class="breadcrumb">
    @if(isset($permisos->contabilidad->pago_proveedores->ver))
        @if($permisos->contabilidad->pago_proveedores->ver==='on')
            <li><a href="{{url('facturacion/pagoproveedores')}}" class="btn btn-default btn-icon" style="font-size: 10px">Servicios a Pagar <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    @if(Sentry::getUser()->id===2 or Sentry::getUser()->id===37 or Sentry::getUser()->id===3801 or Sentry::getUser()->id===170 or Sentry::getUser()->id===5438)
    @if(isset($permisos->contabilidad->pago_proveedores->ver))
        @if($permisos->contabilidad->pago_proveedores->ver==='on')
        <?php
              $consul = DB::table('listado_cuentas')->where('estado',0)->get();
              $consul = count($consul);
              ?>
          <li><a href="{{url('facturacion/cuentas')}}" class="btn btn-default btn-icon" style="font-size: 10px">Cuentas de Cobro <i class="fa fa-sign-in icon-btn"></i> <div style="background: gray; color: yellow" class="badge_menu_head contabilidad_cuenta_badge">{{$consul}}
            </div></a></li>
        @endif
    @endif
    @endif

    @if(isset($permisos->contabilidad->factura_proveedores->ver))
        @if($permisos->contabilidad->factura_proveedores->ver==='on')
            <li><a href="{{url('facturacion/lote')}}" class="btn btn-default btn-icon" style="font-size: 10px">PAGOS POR PREPARAR <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif

    @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
        @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
            <li><a href="{{url('facturacion/lotesporprocesar')}}" class="btn btn-default btn-icon" style="font-size: 10px">Pagos por PROCESAR <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif

    <!--@if(isset($permisos->contabilidad->listado_de_pagos_auditar->ver))
        @if($permisos->contabilidad->listado_de_pagos_auditar->ver==='on')
            <li><a href="{{url('facturacion/listadodepagosauditados')}}" class="btn btn-default btn-icon" style="font-size: 10px">Pagos a Auditar <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif-->

    @if(isset($permisos->contabilidad->listado_de_pagos_autorizar->ver))
        @if($permisos->contabilidad->listado_de_pagos_autorizar->ver==='on')
            <li><a href="{{url('facturacion/lotesporaprobar')}}" class="btn btn-default btn-icon" style="font-size: 10px">Pagos POR APROBAR <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif

    @if(isset($permisos->contabilidad->listado_de_pagados->ver))
        @if($permisos->contabilidad->listado_de_pagados->ver==='on')
            <li><a href="{{url('facturacion/listadopagos')}}" class="btn btn-default btn-icon" style="font-size: 10px">Pagados <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif

    @if(isset($permisos->contabilidad->listado_de_pagos_autorizar->ver))
        @if($permisos->contabilidad->listado_de_pagos_autorizar->ver==='on')
            <li><a href="{{url('facturacion/lotesaprobados')}}" class="btn btn-default btn-icon" style="font-size: 10px">Lotes Aprobados <i class="fa fa-sign-in icon-btn"></i></a></li>
        @endif
    @endif
    <!-- @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
        @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
            <li><a href="{{url('facturacion/prestamosproveedores')}}">Préstamos</a></li>
        @endif
    @endif
     @if(isset($permisos->contabilidad->listado_de_pagos_preparar->ver))
        @if($permisos->contabilidad->listado_de_pagos_preparar->ver==='on')
            <li><a href="{{url('facturacion/listadoprestamosproveedores')}}">Lista de Préstamos</a></li>
        @endif
    @endif-->
</ol>
