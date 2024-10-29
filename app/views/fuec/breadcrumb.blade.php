<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <ol style="margin-bottom: 5px" class="breadcrumb">
                <li>
                    <a href="{{url('fuec')}}">Inicio</a>
                </li>
                <li>
                    <a href="{{url('fuec/listado')}}">Listado Proveedores</a>
                </li>
                <li>
                    <a href="{{url('fuec/historialmail')}}">Historial Mail</a>
                </li>
                @if(isset($permisos->administrativo->fuec->crear))
                    @if($permisos->administrativo->fuec->crear==='on')
                        <li>
                            <a href="{{url('fuec/listadonuevo')}}">Fuec Nuevo</a>
                        </li>
                    @endif
                @endif
                <li>
                    <a href="{{url('fuec/listadovencimiento')}}">Vencimientos</a>
                </li>
            </ol>
        </div>
    </div>
</div>
