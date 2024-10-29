<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Fuec</title>
      @include('scripts.styles')
      <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
      <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
  </head>
  <body>
  @include('admin.menu')
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-4">
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
          </ol>
      </div>
    </div>
  </div>
  <div class="col-lg-10 col-md-10 col-sm-12">
      <h3 class="h_titulo">MAILS ENVIADOS</h3>
      <table class="table table-bordered table-hover" id="listado_mails_enviados">
          <thead>
          <tr>
              <th>#</th>
              <th>Placa</th>
              <th>Email</th>
              <th>Fecha</th>
              <th>Enviado por</th>
              <th>Politicas</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
              @foreach($envio_fuec as $envios)
                  <tr>
                      <td>{{$i}}</td>
                      <td>{{$envios->vehiculo->placa}}</td>
                      <td>{{$envios->email}}</td>
                      <td>{{$envios->created_at}}</td>
                      <td>{{$envios->user->first_name.' '.$envios->user->last_name}}</td>
                      <td>
                        @if ($envios->politicas_aceptadas==1)
                            Aceptadas el dia <span style="color: #F47321">{{$envios->fecha_aceptacion}}</span>, desde la ip
                            <span style="color: #F47321">{{json_decode($envios->jsonIP)->IP}}</span> y navegador
                            <span style="color: #F47321">{{json_decode($envios->jsonIP)->USER_AGENT}}</span>
                        @else
                          No aceptadas
                        @endif
                      </td>
                      <td>
                          <a href="{{url('fuec/enviados/'.$envios->id)}}" class="btn btn-default btn-list-table">
                              LISTADO
                              <i class="fa fa-list-ol" aria-hidden="true"></i>
                          </a>
                      </td>
                  </tr>
                  <?php $i++; ?>
              @endforeach
          </tbody>
      </table>
      @include('admin.back_button')
  </div>

  <script type="text/javascript" src="{{url('dist\fuec.js')}}"></script>
  </body>
</html>
