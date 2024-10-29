<?php

    $rutaMapa = intval($servicio->estado_servicio_app);
    $recorrido_gps = $servicio->recorrido_gps;
    $valorCalificacion = 0;
    $letraCalificacion = '';
    $clasemodificacion = '';

    if($permisos->barranquilla->encuestabq->ver==='on'):
        if ($servicio->pregunta_1!=null):

        if ($servicio->pregunta_1==1):
            $valorCalificacion = $valorCalificacion + 4.5;
        elseif ($servicio->pregunta_1==2):
            $valorCalificacion = $valorCalificacion + 1.5;
        endif;

        if ($servicio->pregunta_2==1):
            $valorCalificacion = $valorCalificacion + 4.5;
        elseif ($servicio->pregunta_2===2):
            $valorCalificacion = $valorCalificacion + 1.5;
        endif;

        if ($servicio->pregunta_3===1):
            $valorCalificacion = $valorCalificacion + 4.5;
        elseif ($servicio->pregunta_3==2):
            $valorCalificacion = $valorCalificacion + 1.5;
        endif;

        if ($servicio->pregunta_4==1):
            $valorCalificacion = $valorCalificacion + 4.5;
        elseif ($servicio->pregunta_4==2):
            $valorCalificacion = $valorCalificacion + 1.5;
        endif;

        $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_8);
        $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_9);
        $valorCalificacion = $valorCalificacion+intval($servicio->pregunta_10);

        if ($valorCalificacion>0 && $valorCalificacion<=10):
            $clasemodificacion = 'danger';
            $letraCalificacion = 'M';
        elseif ($valorCalificacion>=11 && $valorCalificacion<=20):
            $clasemodificacion = 'warning';
            $letraCalificacion = 'R';
        elseif ($valorCalificacion>=21 && $valorCalificacion<=27):
            $clasemodificacion = 'yellow';
            $letraCalificacion = 'A';
        elseif ($valorCalificacion>=28 && $valorCalificacion<=32):
            $clasemodificacion = 'success';
            $letraCalificacion = 'B';
        elseif ($valorCalificacion>=32 && $valorCalificacion<=35):
            $clasemodificacion = 'info';
            $letraCalificacion = 'E';
        endif;

        echo '<a data-toggle="modal" style="margin-top: 5px; margin-bottom: 5px; padding: 5px 6px;" class="btn btn-'.$clasemodificacion.
             '"><i class="fa fa-file-text"></i><br>'.$letraCalificacion.'</a>';
    endif;
    endif;
    /**
     * PERMISOS PARA EDITAR SERVICIOS
     */
    if($permisos->barranquilla->serviciosbq->edicion==='on'){
        $btnEditaractivado = '<a id="'.$servicio->id.'" data-toggle="modal" data-target=".mymodal1"'.
                'style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio">'.
                '<i class="fa fa-pencil"></i></a>';
    }else{
        $btnEditaractivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary editar_servicio disabled">'.
                '<i class="fa fa-pencil"></i></a>';
    }

    $btnEditardesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-primary disabled">'.
            '<i class="fa fa-pencil"></i></a>';

    /**
     * PERMISOS PARA ELIMINAR SERVICIOS
     */
    if($permisos->barranquilla->serviciosbq->eliminacion==='on'){

        $btnProgactivado = '<a id="'.$servicio->id.'" style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion">'.
                '<i class="fa fa-ban" aria-hidden="true"></i></a>';
    }else{
        $btnProgactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning programar_eliminacion disabled">'.
                '<i class="fa fa-ban" aria-hidden="true"></i></a>';
    }

    $btnProgdesactivado = '<a style="margin-bottom: 5px; padding: 5px 6px;" class="btn btn-warning disabled">'.
            '<i class="fa fa-ban" aria-hidden="true"></i></a>';
?>
<!-- SI EL SERVICIO ESTA PENDIENTE POR ELIMINAR ENTONCES $btnEditardesactivado.$btnProgdesactivado-->
@if($servicio->rechazar_eliminacion==1)
    {{$btnEditaractivado.$btnProgdesactivado}}
@elseif($servicio->pendiente_autori_eliminacion==1)
    {{$btnEditardesactivado.$btnProgdesactivado}}
<!-- SI EST FACTURADO ENTONCES -->
@elseif($servicio->facturado==1)
{{-- SI EL USUARIO ES ADMINISTRADOR O GERENTE --}}
    @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12)
        {{$btnEditaractivado.$btnProgdesactivado}}
    @else
        {{$btnEditardesactivado.$btnProgdesactivado}}
    @endif
<!-- SI ESTA REVISADO Y ESTA EN FACTURACION PUEDE SER EDITADO Y ELIMINADO POR FACTURACION -->
@elseif($servicio->liquidado==1)
<!-- SI EL USUARIO ES ADMINISTRADOR O GERENTE O FACTURACION -->
    @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
        {{$btnEditaractivado.$btnProgactivado}}
    @else
        {{$btnEditardesactivado.$btnProgdesactivado}}
    @endif
<!-- SI ESTA REVISADO Y ESTA EN FACTURACION PUEDE SER EDITADO Y ELIMINADO POR FACTURACION -->
@elseif($servicio->revisado==1)
    @if(Sentry::getUser()->id==2 or Sentry::getUser()->id==12 or Sentry::getUser()->id_tipo_usuario==2)
        {{$btnEditaractivado.$btnProgactivado}}
    @else
        {{$btnEditardesactivado.$btnProgdesactivado}}
    @endif
<!-- SI ESTA REVISADO Y ESTA ES COORDINADOR PUEDE SER EDITADO PERO NO PUEDE SER ELIMINADO POR COORDINADORES -->
@else
    {{$btnEditaractivado.$btnProgactivado}}
@endif

@if($servicio->estado_servicio_app==2)
  <a data-toggle="modal" data-target=".mymodal4" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px; background: #eaeaea; color: black" class="btn btn-success ruta_mapa {{$servicio->id}}" title="Mapa GPS">
    <i class="fa fa-map-marker" aria-hidden="true"></i>
  </a>
@elseif($servicio->estado_servicio_app==1)
<a data-toggle="modal" data-target=".mymodal4" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px; background: green" class="btn btn-success ruta_mapa {{$servicio->id}} parpadea" title="Mapa GPS">
  <i class="fa fa-map-marker" aria-hidden="true"></i>
</a>
@else
<a data-toggle="modal" data-id="{{$servicio->id}}" style="margin-bottom: 5px; padding: 5px 8px; background: gray" class="btn btn-success ruta_mapa {{$servicio->id}}" title="Mapa GPS">
  <i class="fa fa-map-marker" aria-hidden="true"></i>
</a>
@endif

@if($servicio->estado_servicio_app===null and $servicio->usuario_id !=null and $servicio->ejecutado!=1)
<a style="padding: 6px 6px;" class="btn btn-info enviar_notification" data-id="{{$servicio->id}}" title="Enviar Notificacion APP"><i class="fa fa-info-circle"></i></a>
@endif
