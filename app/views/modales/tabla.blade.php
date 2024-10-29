<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">COMPANY</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5>{{$servicios->razonsocial}}</h5>
  </div>                  
</div>
<hr>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">PASSENGER (S)</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5><?php 
        $pax = explode('/',$servicios->pasajeros);
        $sw = count($pax);
        $count = 0;
        for ($i=0; $i < count($pax); $i++) {
            $pasajeros[$i] = explode(',', $pax[$i]);
        }

        for ($i=0; $i < count($pax)-1; $i++) {

            for ($j=0; $j < count($pasajeros[$i]); $j++) {

              if ($j===0) {
                $nombre = $pasajeros[$i][$j];
              }                                           

            }
            $count++;
            if($sw===$count){
              echo $nombre;
            }else{
              echo $nombre.' / ';
            }
            

        }
      ?></h5>
  </div>                  
</div>
<hr color="blue" size=100>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">SERVICE DATE</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5>{{$servicios->fecha_servicio}}</h5>
  </div>                  
</div>
<hr color="blue" size=100>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">SERVICE TIME</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5>{{$servicios->hora_servicio}}</h5>
  </div>                  
</div>
<hr color="black" size=100>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">PICK UP PLACE</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5>{{$servicios->recoger_en}}</h5>
  </div>                  
</div>
<hr color="black" size=100>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #FF7433">DESTINATION PLACE</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5>{{$servicios->dejar_en}}</h5>
  </div>                  
</div>