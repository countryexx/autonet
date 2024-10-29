<div class="row">
  <div class="col-lg-12col-md-4 col-xs-12">
    <center>
      @if($servicios->foto!='FALSE' and $servicios->foto!=NULL)
        <img class="foto_conductor" src="{{url('biblioteca_imagenes/proveedores/conductores/'.$servicios->foto.'')}}" alt="" style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;">
      
        <img class="hidden" src="{{url('img/samuel.JPEG')}}" width="280px" height="168px" display= "block" > 
       @else
        <img class="foto_conductor" src="{{url('biblioteca_imagenes/conductor-violento.JPG')}}" alt="" style="width: 180px; height: 200px; border-radius: 50%; border: white 6px solid; -webkit-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); -moz-box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); box-shadow: 1px 2px 2px 0px rgb(38, 113, 41); margin-bottom: 10px;">
       @endif
     </center>
     <br>
     
     <span><b>{{$servicios->nombre_completo}} <br> {{$servicios->placa}}</b> <a href="tel:{{$servicios->celular}}"><h5 style="color: #FF6600;"><b><i class="fa fa-phone" aria-hidden="true"></i> Llamar al Conductor</b></h5></a> <hr style="border: 1px solid orange"><b>{{$servicios->clase}} | {{$servicios->marca}} | {{$servicios->modelo}} | {{$servicios->color}}</b><br></span>
  </div>
                  
</div>
<hr style="border: 1px solid orange">
<div class="row">
  <div class="col-md-5 col-xs-5">
    <h5 style="color: #FF7433">FECHA Y HORA</h5>
  </div>
  <div class="col-md-7 col-xs-7">
    <h5>{{$servicios->fecha_servicio}}, {{$servicios->hora_servicio}}</h5>
  </div>
</div>
<!--
<hr style="border: 1px solid orange">
<div class="row">
  <div class="col-md-5 col-xs-5">
    <h5 style="color: #FF7433">DATA1</h5>
  </div>
  <div class="col-md-7 col-xs-7">
    <h5>DATA 1</h5>
  </div>                  
</div>
<hr style="border: 1px solid orange">
<div class="row">
  <div class="col-md-5 col-xs-5">
    <h5 style="color: #FF7433">DATA 2</h5>
  </div>
  <div class="col-md-7 col-xs-7">
    <h5>DATA 2</h5>
  </div>                  
</div>-->