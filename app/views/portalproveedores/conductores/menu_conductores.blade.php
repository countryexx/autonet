<ol style="margin-bottom: 10px; font-size: 45px; background-color: gray; color: white" class="breadcrumb">
    <?php $i = 0; ?>
    @if(isset($conductores))
        @foreach($conductores as $conduc)
            @if($conduc->id==$id)
                <?php $color = 'orange'; $tamaño = '22px'; ?>
            @else
                <?php $color = 'white'; $tamaño = '12px'; ?>
            @endif

            <?php

            if($count[$i]>0){
                $clase = 'badge_menu_head fontbulger';
                $color_alerta = 'purple';
            }else{
                $clase = 'badge_menu_head';
                $color_alerta = 'green';
            }
            ?>

            <li> 
                
                <i title="Desvincular este conductor" data-conductor="{{$conduc->id}}" style="font-size: 21px; color: red" class="fa fa-times-circle desvincular" aria-hidden="true"></i> 
                
                <a style="color: green; font-size: <?php echo $tamaño; ?>; color: <?php echo $color; ?> " href="{{url('portalproveedores/documentaciondeconductor/'. Crypt::encryptString($conduc->id))}}"> {{$conduc->nombre_completo}}</a> <h5 style="font-size: 12px; background-color: <?php echo $color_alerta; ?>" class="{{$clase}}">{{$count[$i]}}</h5> </li>
            <?php $i++; ?>
       @endforeach
    @endif
</ol>
