<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #918984">NAME</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5 style="color: #FF6600"><b>{{$servicios->nombre_completo}}</b></h5>
  </div>                  
</div>
<hr>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #918984">PHONE NUMBER</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <a href="tel:{{$servicios->celular}}"><h5 style="color: #FF6600;"><b>+57 {{$servicios->celular}}</b></h5></a>
  </div>                  
</div>
<hr>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #918984">VEHICLE</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5 style="color: #FF6600"><b>{{$servicios->clase}} / {{$servicios->placa}}</b></h5>
  </div>                  
</div>
<hr>
<div class="row">
  <div class="col-md-4 col-xs-4">
    <h5 style="color: #918984">VEHICLE INFO</h5>
  </div>
  <div class="col-md-8 col-xs-8">
    <h5 style="color: #FF6600"><b>{{$servicios->marca}} / {{$servicios->modelo}} / {{$servicios->color}}</b></h5>
  </div>                  
</div>
