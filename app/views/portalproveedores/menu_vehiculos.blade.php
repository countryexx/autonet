<ol style="margin-bottom: 10px; font-size: 45px; background-color: gray; color: white" class="breadcrumb">
    <?php $i = 0; ?>
    @foreach($vehiculoss as $vehiculo)
        @if($vehiculo->placa===$placa)
            <?php $color = 'orange'; $tamaño = '35px'; ?>
        @else
            <?php $color = 'white'; $tamaño = '25px'; ?>
        @endif

        <?php

        if($count[$i]>0){
            $clase = 'badge_menu_head fontbulger';
            $color_alerta = 'red';
        }else{
            $clase = 'badge_menu_head';
            $color_alerta = 'green';
        }
        ?>

        <li><a style="color: green; font-size: <?php echo $tamaño; ?>; color: <?php echo $color; ?> " href="{{url('portalproveedores/documentaciondevehiculo/'.Crypt::encryptString($vehiculo->placa))}}">{{$vehiculo->placa}}</a> <span style="font-size: 10px; background-color: <?php echo $color_alerta; ?>" class="{{$clase}}">{{$count[$i]}}</span> </li>
        <?php $i++; ?>
   @endforeach
</ol>
