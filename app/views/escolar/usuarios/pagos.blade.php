<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Pagos</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="manifest" href="{{url('manifest.json')}}">
</head>

<body onload="nobackbutton();">
@include('admin.menu')

<h1 style="margin: 0 10px 10px 16px" class="h_titulo">LINKS DE PAGO</h1>

 <div class="container-fluid" style="padding-top: 0; overflow-y: auto;">

   @if(isset($pagos))
     <table id="example_links" class="table table-bordered hover tabla" cellspacing="0" width="100%">
       <thead>
         <tr>
             <th>#</th>
             <th>Vence</th>
             <th>Valor Ordinario</th>
             <th>Valor con Recargo</th>
             <th>Mes</th>
             <th></th>

         </tr>
       </thead>
       <tfoot>
           <tr>
               <th>#</th>
               <th>Vence</th>
               <th>Valor Ordinario</th>
               <th>Valor con Recargo</th>
               <th>Mes</th>
               <th></th>

           </tr>
       </tfoot>
       <tbody>
         <?php
         $fecha = explode('-', date('Y-m-d'));
         $dia = $fecha[2];
         ?>
           @foreach($pagos as $pago)
               <?php
                   $btnEditaractivado = null;
                   $btnEditardesactivado = null;
                   $btnProgactivado = null;
                   $btnProgdesactivado = null;

                   if($pago->mes===1){
                     $mes = 'ENERO';
                   }else if($pago->mes===2){
                     $mes = 'FEBRERO';
                   }else if($pago->mes===3){
                     $mes = 'MARZO';
                   }else if($pago->mes===4){
                     $mes = 'ABRIL';
                   }else if($pago->mes===5){
                     $mes = 'MAYO';
                   }else if($pago->mes===6){
                     $mes = 'JUNIO';
                   }else if($pago->mes===7){
                     $mes = 'JULIO';
                   }else if($pago->mes===8){
                     $mes = 'AGOSTO';
                   }else if($pago->mes===9){
                     $mes = 'SEPTIEMBRE';
                   }else if($pago->mes===10){
                     $mes = 'OCTUBRE';
                   }else if($pago->mes===11){
                     $mes = 'NOVIEMBRE';
                   }else if($pago->mes===12){
                     $mes = 'DICIEMBRE';
                   }
               ?>
               <tr id="{{$pago->id}}" class="@if(intval($pago->mora)===1){{'danger'}}@elseif($pago->estado_pago===1){{'success'}}@endif fila_foto">
                   <td>{{$o++}}</td>
                   <td>2022-02-05 23:59:59</td>
                   <td>$ {{number_format($pago->valor_ordinario)}}</td>

                   <td>$ {{number_format($pago->valor_mora)}}</td>
                  <td>{{$mes}}</td>

                   <td>

                     @if($pago->estado_pago!=1)
                       <a href="@if($pago->mora!=1){{$pago->link}}@else{{$pago->link_mora}}@endif" title="Será redirigido al portal de pagos AOTOUR de Wompi en una nueva ventana" target="_blank" id="enlace" class="btn btn-success">Ir a Pagar <i class="fa fa-external-link" aria-hidden="true"></i></a>
                     @else
                     <div class="estado_servicio_app" style="background: #38FF08; color: black; margin: 2px 0px; font-size: 10px; padding: 5px 5px; width: 120px; border-radius: 2px;">PAGO APROBADO <i class="fa fa-check" aria-hidden="true"></i></div>
                     @endif


                   </td>

               </tr>
           @endforeach
       </tbody>
     </table>
   @endif

  </div>

  @include('scripts.scripts')

  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="{{url('jquery/escolar.js')}}"></script>

</body>
</html>
