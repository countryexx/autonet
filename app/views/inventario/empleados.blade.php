<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Inventario por Empleado</title>
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

      *{margin: 0; padding: 0;}
.doc{
  display: flex;
  flex-flow: column wrap;
  width: 100vw;
  height: 100vh;
  justify-content: center;
  align-items: center;
  background: #333944;
}
.box{
  width: 300px;
  height: 300px;
  background: #CCC;
  overflow: hidden;
}

.box img{
  width: 100%;
  height: auto;
}
@supports(object-fit: cover){
    .box img{
      height: 100%;
      object-fit: cover;
      object-position: center center;
    }
}
     

      .btn .dropdown-toggle{
        padding: 8px 12px;
      }

      .alert-minimalist {
        background-color: rgb(255, 255, 255);
        border-color: rgba(149, 149, 149, 0.3);
        border-radius: 3px;
        color: rgb(149, 149, 149);
        padding: 10px;
      }

      .alert-minimalist > [data-notify="icon"] {
        height: 50px;
        margin-right: 12px;
      }

      .alert-minimalist > [data-notify="title"] {
        color: rgb(51, 51, 51);
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
      }

      .alert-minimalist > [data-notify="message"] {
        font-size: 13px;
        font-weight: 400;
      }

    </style>
  </head>
  <body>
    @include('admin.menu')
  
    <div class="col-lg-12">

        <h3 class="h_titulo">Inventario por Empleado</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">
          @include('inventario.menu')
            
        </form>

          <table id="example2" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th>Empleado</th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Empleado</th>
                    
                </tr>
            </tfoot>
            <tbody>
                <?php $o = 1; ?>
                @foreach($empleados as $empleado)
                  <tr>
                    <td>
                      <p> 

                        <?php 

                        $consult = "SELECT * FROM equipos WHERE FIND_IN_SET('".$empleado->id."', empleado) > 0 ";

                        $consulta = DB::select($consult);

                        ?>

                        @if($consulta)
                          <a class="btn btn-primary" data-toggle="collapse" href="#{{$empleado->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                          {{ $empleado->nombres }} {{ $empleado->apellidos }} <i class="fa fa-mouse-pointer" aria-hidden="true"></i>
                          </a>
                        @else
                          <a class="btn btn-danger" data-toggle="collapse" href="#{{$empleado->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                          {{ $empleado->nombres }} {{ $empleado->apellidos }} <i class="fa fa-mouse-pointer" aria-hidden="true"></i>
                          </a>
                        @endif
                      </p>
                      <div class="collapse" id="{{$empleado->id}}">
                        <div class="card card-body">
                          <?php 

                          

                          if($consulta){

                            $equip = '';

                            foreach ($consulta as $equipos) {
                              $equip .= '<li class="list-group-item">'.$equipos->categoria.' '.$equipos->marca.' <a target="_blank" href="http://localhost/autonet/inventario/equipo/'.$equipos->id.'" style="float: right;" id="notificar" class="mostrar_equipo btn btn-list-table btn-warning ">Ver Equipo</a></li>';
                              //echo $equipos->categoria;
                            }

                            $start = '<ul class="list-group">';
                            $end = '</ul>';

                            echo($start.$equip.$end);

                          }else{
                            echo '<ul class="list-group">
                            <li class="list-group-item">Este empleado no tiene ningún equipo asignado!</li>
                          </ul>';
                          }

                          ?>
                        </div>
                      </div>
                    </td>

                  </tr>
                  <?php $o++; ?>
                @endforeach
            </tbody>
          </table>
        
    </div>  

    <!-- MODAL FOTO -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_equipo'>
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #0FAEF3">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="text-align: center;" id="name"></h4>
            </div>
            <div class="modal-body">
              <center>
                <img style="width: 410px; height: 400px; border: white 6px solid;" id="imagen">
                </center>
            </div>
            <div class="modal-footer">
              <div class="row">
                <div class="col-md-9">
                  <p id="novedades_modal" style="text-align: left;"></p>
                </div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #B1B2B4">Cerrar</button>
                </div>
              </div>                    
            </div>
        </div>
      </div>
    </div>

    @include('scripts.scripts')    
    
    <script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
    <script src="{{url('jquery/bootstrap.file-input.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
    <script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="{{url('jquery/inventario.js')}}"></script>

    <script type="text/javascript">

    </script>

  </body>
</html>
