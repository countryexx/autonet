<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Autonet | Historial {{$empleado->nombres}} {{$empleado->apellidos}}</title>
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
    @include('scripts.styles')
    <style type="text/css">      
      
      .checkbox-container {
          width: 100%;
          box-sizing: border-box;
          text-align:center;
      }
    </style>
  </head>
  <body>
    @include('admin.menu')

      <div class="col-lg-12">
          <h3 class="h_titulo">HISTORIAL DEL EMPLEADO</h3>
          
          <div style="margin-top: 15px;" class="col-lg-12">
      			<div class="row">
      				<div class="panel panel-default">
      					<div class="panel-heading">HISTORY <h5>{{$empleado->nombres}} {{$empleado->apellidos}}</h5></div>
      					<div class="panel-body">
                            <table style="margin-bottom:15px" class="table table-bordered hover">
                                <tbody>                                    
                                        
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <tbody>                                  
                                 
                                    <tr>
                                        <?php $json = json_decode($empleado->historial); 
                                        $cont = 1;
                                        $total = 0;
                                        ?>
                                        <td colspan="2">
                                          <table class="table table-bordered table-hover" id="exampledetallessinpago">
                                              <thead>
                                              <tr>
                                                <td>FECHA</td>
                                                <td>DETALLES</td>
                                              </tr>
                                              </thead>
                                              <tbody>
                                                @foreach($json as $data)
                                                  <tr>
                                                    <td><h4>{{$data->time}}</h4></td>
                                                    <td><h4>{{$data->detalle}}</h4></td>                                                    
                                                  </tr>
                                                  
                                                @endforeach
                                              </tbody>
                                          </table>      
                                                                                 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
      					</div>
      				</div>
      			</div>
      		</div>


      </div>
  
  @include('scripts.scripts')
  <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
  <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
  <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
  <script src="{{url('jquery/facturacion.js')}}"></script>
  </body>
</html>
