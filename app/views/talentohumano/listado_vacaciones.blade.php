<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Listado de Vacaciones</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
  </head>
  <body>
    @include('admin.menu')
    <div class="col-lg-10">
      @include('talentohumano.menu_talentohumano')
    </div>
      <div class="col-lg-12">
          <h3 class="h_titulo">LISTADO DE VACACIONES</h3>
          <input type="text" name="id_de_pago" id="id_de_pago" value="" class="hidden">
          <div style="margin-top: 15px;">
            <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_inicial" name="fecha_pago" value="{{date('Y-m-d')}}" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA INICIAL">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group" id="datetime_fecha">
              <div class='input-group date' id='datetimepicker10'>
                <input id="fecha_final" name="fecha_pago" value="{{date('Y-m-d')}}" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA FINAL">
                  <span class="input-group-addon">
                      <span class="fa fa-calendar">
                      </span>
                  </span>
              </div>
            </div>
          </div>
            <div class="input-group proveedor_content">
              <select data-option="1" name="empleado" style="width: 150px;" class="form-control input-font" id="empleado">
                <option value="0">LISTA DE EMPLEADOS</option>
                @foreach($empleados as $empleado)
                  <option value="{{$empleado->id}}">{{$empleado->nombres}} {{$empleado->apellidos}}</option>
                @endforeach
              </select>
            </div>          
            <a proceso="2" id="buscar_vacaciones" class="btn btn-default btn-icon">
            Buscar<i class="fa fa-search icon-btn"></i></a>
          </div>
          </div>
      </form>
            <table id="vacaciones_table" class="table table-bordered hover tabla" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nombre del Empleado</td>
                  <td>Fecha Inicial</td>
                  <td>Fecha Final</td>                  
                  <td>Usuario</td>
                  <td>Observaciones</td>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                @foreach($vacaciones as $prestamo)
                  <tr>
                    <td>{{$i}}</td>
                    <td>{{$prestamo->nombres}} {{$prestamo->apellidos}}</td>
                    <td class="feich" >{{$prestamo->fecha_inicial}}</td>
                    <td>{{$prestamo->fecha_final}}</td>
                    </td>
                    <td>{{$prestamo->first_name}} {{$prestamo->last_name}} </td>
                    <td>
                      <p class="bolder text-primary" style="margin: 0 !important; font-size: 12px;">{{$prestamo->observaciones}}</p>
                    </td>
                  </tr>
                  <?php $i++; ?>
                @endforeach                      
              </tbody>
              <tfoot>
                <tr>
                  <td>#</td>
                  <td>Nombre del Empleado</td>
                  <td>Fecha Inicial</td>
                  <td>Fecha Final</td>                     
                  <td>Usuario</td>
                  <td>Observaciones</td>                               
                </tr>
              </tfoot>
            </table>
      		</div>

      </div>
      
    <div class="errores-modal bg-danger text-danger hidden model" style="background: orange; color: black">
        <i style="cursor: pointer; position: absolute;right: 5px;top: 4px;" class="fa fa-close cerrar"></i>
        <ul>
        </ul>
    </div>

  @include('scripts.scripts')
  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/talentohumano.js')}}"></script>
  <script type="text/javascript">
    function goBack(){
        window.history.back();
    }
  </script>
  </body>
</html>
