<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="url" content="{{url('/')}}">
    
    <title>Autonet | Correos Corporativos</title>
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

        <h3 class="h_titulo">LISTADO DE CORREOS CORPORATIVOS</h3>       
        <form class="form-inline" id="form_buscar" action="{{url('gestiondocumental/downloadpdf')}}" method="post">
          @include('inventario.menu')
            <div class="col-lg-12" style="margin-bottom: 5px">
                <div class="row">

                  <!--<div class="form-group">
                  	<select data-option="1" name="cliente_search" style="width: 130px;" class="form-control input-font" id="cliente_search">
                        <option>ÁREA</option>
                        <option>ACEROS CORTADOS</option>
                        <option>LHOIST</option>
                        <option>PIMSA</option>
                        <option>PUERTO PIMSA</option>
                        <option>QUANTICA - BILATERAL</option>
                        <option>SUTHERLAND BAQ</option>
                    </select>
	                </div> 
                    
                  <button data-option="1" id="buscar" class="btn btn-default btn-icon">Buscar<i class="fa fa-search icon-btn"></i></button>-->
                    
                </div>
            </div>
        </form>

          <table id="example" class="table table-bordered hover tabla" cellspacing="0" width="100%">
            <thead>
              <tr>
                  <th></th>
                  <th>Dirección</th>
                  <th>Reenvío</th>
                  <th>Empleado (s)</th>                  
                  <th>Historial</th>
                  <th></th>
                  
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Dirección</th>
                    <th>Reenvío</th>
                    <th>Empleado (s)</th>                  
                    <th>Historial</th>
                    <th></th>
                    
                </tr>
            </tfoot>
            <tbody>
                <?php $o = 1; ?>
                @foreach($correos as $correo)
                  <tr>
                    <td>{{$o}}</td>
                    <td><span style="font-size: 16px">{{$correo->address}}</span></td>
                    <td>
                      <?php 

                      $emails = explode(',', $correo->reenvio);
                      
                      $mails = DB::table('correos')
                      ->whereIn('id', $emails)
                      ->get();

                      $addre = '';
                      $sw = 0;

                      foreach ($mails as $mail) {
                         $addre .= $mail->address.'<br>';
                         $sw++;
                       } 
                       //echo $sw;

                       echo $addre;

                      ?>
                    </td>
                    <td>
                      <?php 

                      $usuarios = explode(',', $correo->usuario);
                      
                      $users = DB::table('empleados')
                      ->whereIn('id', $usuarios)
                      ->get();

                      $names = '';
                      $sw = 0;

                      foreach ($users as $user) {
                         $names .= $user->nombres.' '.$user->apellidos.'<br>';
                         $sw++;
                       } 
                       //echo $sw;

                       echo $names;

                      ?>
                    </td>
                    <td>

                      <a target="_blank" href="{{url('inventario/address/'.$correo->id)}}" id="notificar" class="detalles_centro btn btn-list-table btn-primary ">Ver Historial</a>

                    </td>
                    <td>
                      Creado el {{$correo->created_at}}
                    </td>
                  </tr>
                  <?php $o++; ?>
                @endforeach
            </tbody>
          </table>
        
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
