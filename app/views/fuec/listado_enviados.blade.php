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
    <h3 class="h_titulo">FUECS ENVIADOS</h3>
    <p>Enviado por:
      <span style="color: #F47321">
        {{ucwords(strtolower($envio_fuec->user->first_name).' '.strtolower($envio_fuec->user->last_name))}},
      </span>
        al correo electronico:
          <span style="color: #F47321">{{$envio_fuec->email}},</span>
      </span>
      en la fecha y hora:
        <span style="color: #F47321">{{$envio_fuec->created_at}}</span>
    </p>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Contrato</th>
            <th>Consecutivo</th>
            <th>Contratante</th>
            <th>Ruta</th>
            <th>Nit</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($fuecs as $fuec)
          <tr>
            <td>{{$i}}</td>
            <td>{{$fuec->contrato->numero_contrato}}</td>
            <td>{{$fuec->consecutivo}}</td>
            <td>{{$fuec->contrato->contratante}}</td>
            <td>{{'ORIGEN: '.$fuec->rutafuec->origen.' / DESTINO: '.$fuec->rutafuec->destino}}</td>
            <td>{{$fuec->contrato->nit_contratante}}</td>
            <td>{{$fuec->fecha_inicial}}</td>
            <td>{{$fuec->fecha_final}}</td>
            <td>
              <a class="btn btn-list-table btn-default" href="{{url('fuec/editar/'.$fuec->id)}}">
                  VER
                  <i class="fa fa-search" aria-hidden="true"></i>
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
