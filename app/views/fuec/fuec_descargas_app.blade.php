<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    <meta name="full_name_user" content="{{Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Servicios Programados</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    @include('scripts.styles')
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="manifest" href="{{url('manifest.json')}}">
    <style>

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

    </style>
  </head>
  <body>

    @include('admin.menu')

    <div class="col-lg-12">
        <h3 class="h_titulo">LISTADO DE FUEC</h3>


        <form class="form-inline" id="form_buscar" method="post" action="{{url('serviciosejecutivos/exportarlistadoservicios')}}">
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_inicial" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                                <span class="input-group-addon">
                                    <span class="fa fa-calendar">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class='input-group date' id='datetimepicker1'>
                                <input name="fecha_final" style="width: 89px;" type='text' class="form-control input-font" value="{{date('Y-m-d')}}">
                            <span class="input-group-addon">
                                <span class="fa fa-calendar">
                                </span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input name="codigo" placeholder="CODIGO" style="width: 100px" type="text" class="form-control input-font">
                    </div>
                    <button data-option="1" id="buscar" class="btn btn-default btn-icon">
                        Buscar<i class="fa fa-search icon-btn"></i>
                    </button>
                    @if(Sentry::getUser()->id === 5251)
                      <button type="submit" class="btn btn-success btn-icon input-font">EXCEL<i class="fa fa-file-excel-o icon-btn"></i></button>
                    @endif
                </div>
            </div>
        </form>

        @if(isset($fuecs))
          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Codigo</th>
                  <th>Solicitante</th>
                  <th>Ciudad</th>
                  <th>Fecha Orden / Fecha Servicio</th>
                  <th>Itinerario</th>
                  <th>Desde</th>
                  <th>Hasta</th>
                  <th>Detalles</th>
                  <th>Conductor</th>
                  <th>Pax</th>
                  <th>Horario</th>
                  <th>Estado</th>
                  <th>Detalles</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Codigo</th>
                    <th>Solicitante</th>
                    <th>Ciudad</th>
                    <th>Fecha Orden / Fecha Servicio</th>
                    <th>Itinerario</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Detalles</th>
                    <th>Conductor</th>
                    <th>Pax</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($fuecs as $fuec)
                    <?php
                        $btnEditaractivado = null;
                        $btnEditardesactivado = null;
                        $btnProgactivado = null;
                        $btnProgdesactivado = null;
                    ?>
                    <tr id="{{$fuec->id}}">
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td><span class="bolder">1</span></td>
                        <td></td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        @endif
    </div>

    @include('scripts.scripts')

    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/serviciosejecutivos2.js')}}"></script>

  </body>
</html>
