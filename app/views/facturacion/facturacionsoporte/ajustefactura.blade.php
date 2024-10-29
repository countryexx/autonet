<html>
<head>
    <meta charset="UTF-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Soporte Facturacion</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>
@include('admin.menu')
@include('facturacion.facturacionsoporte.menusoportefacturacion')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h3>Modificacion de montos de facturacion</h3>

<div class="col-lg-12">
        <div class="row">
          <table style="margin-top: 15px;" class="table table-bordered" id="tabla_pasajeros">
            <thead>
              <tr>
                <th>#</th>
                <th>ID de Servicio</th>
                <th>Cobro Unitario</th>
                <th>Pago Unitario</th>
                <th>Cobro total</th>
                <th>Pago total</th>
                <th>Utilidad</th>
                <th>Fecha de actualización</th>                
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($facturacion as $factura)
                  <tr data-pago-id="{{$factura->id}}" onClick="selODessel(this)">
                    <td>{{$i}}</td>
                    <td>{{$factura->servicio_id}}</td>
                    <td>{{$factura->unitario_cobrado}}</td>
                    <td>{{$factura->unitario_pagado}}</td>
                    <td>{{$factura->total_cobrado}}</td>
                    <td>{{$factura->total_pagado}}</td>
                    <td>{{$factura->utilidad}}</td>
                    <td>{{$factura->updated_at}}</td>
                                        
                    <td>
                      <button buscar-pago-id="{{$factura->id}}" class="btn btn-success buscar_servicio">EDITAR</button>                     
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>

</div>
</div>
</div>
</body>
</html>