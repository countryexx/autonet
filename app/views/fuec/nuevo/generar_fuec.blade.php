<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <title>Autonet | Listado Fuec</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>

    .doc {
      float: right;
    }
    .cond {
      float: right;
    }
    /* Center the loader */
    #loader {
      position: absolute;
      left: 40%;
      bottom: 12%;
      z-index: 1;
      width: 60px;
      height: 60px;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #f47321;
      -webkit-animation: spin 1s linear infinite;
      animation: spin 1s linear infinite;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Add animation to "page content" */
    .animate-bottom {
      position: relative;
      -webkit-animation-name: animatebottom;
      -webkit-animation-duration: 1s;
      animation-name: animatebottom;
      animation-duration: 1s
    }

    @-webkit-keyframes animatebottom {
      from { bottom:-100px; opacity:0 }
      to { bottom:0px; opacity:1 }
    }

    @keyframes animatebottom {
      from{ bottom:-100px; opacity:0 }
      to{ bottom:0; opacity:1 }
    }

    #myDiv {
      display: none;
      text-align: center;
    }

    </style>
  </head>
  <body >
  @include('admin.menu')
  @include('fuec.breadcrumb')
  <div class="col-lg-12">

      <h3 class="h_titulo">CIUDAD</h3>
      <form class="form-inline" id="form_buscar">
          <div class="col-lg-12" style="margin-bottom: 5px">
              <div class="row">
                  <div class="form-group">
                    <select id="ciudad" class="form-control input-font" style="margin-bottom: 20px">
                        <option value="0">SELECCIONAR CIUDAD</option>
                        <option value="BARRANQUILLA">BARRANQUILLA</option>
                        <option value="BOGOTA">BOGOTA</option>
                    </select>
                  </div>
                  <i id="cargando" style="margin-left: 12px; font-size: 20px" class="fa fa-spinner fa-spin hidden"></i>
              </div>
          </div>
      </form>

      <div class="row" style="margin-top: 25px">
        <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="panel panel-default">
                  <div class="panel-heading">Lista de Proveedores
                    <a style="float: right;" id="continuar_proceso" class="detalles_centro btn btn-list-table btn-success ">Continuar</a>
                  </div>
                  <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 500px; margin-top: 20px">

                    <table name="mytableT" id="proveedores" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                       <thead>
                         <tr>
                          <td>Check</td>
                           <td>Proveedor</td>
                           <td>Conductor</td>
                           <td>Vehículo</td>
                         </tr>
                       </thead>
                       <tbody>

                       </tbody>
                     </table>
                  </div>
              </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" id='modal_fuec'>

        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;" id="proveedor_nombre"> GENERACIÓN DE FUEC MASIVO </h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>SELECCIONAR CLIENTES</b> </div>
                        <div class="panel-body" style="padding-top: 0; overflow-y: auto; height: 360px; margin-top: 20px">

                          <table name="clientes_fuec" id="clientes_fuec" class="table table-hover table-bordered tablesorter tabla" style="margin-top: 15px">
                             <thead>
                               <tr>
                                <td>Check</td>
                                 <td>Nombre del Cliente</td>
                               </tr>
                             </thead>
                             <tbody>

                             </tbody>
                           </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                      <div class="panel panel-default">
                          <div class="panel-heading" style="background: #FA8A2C"><b>SELECCIONAR RUTAS</b>
                            <span style="float: right; background-color: #F8FAF7; color: red; margin-top: 10px" class="hidden" id="excel" class="btn btn-primary btn-icon">NO HAY ARCHIVO! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                          </div>
                          <div class="panel-body"  style="padding-top: 0; overflow-y: auto; height: 360px; margin-top: 20px">
                            <table name="rutasF" id="table_rutas" class="table table-hover table-bordered tablesorter">
                               <thead>
                                 <tr>
                                   <td></td>
                                   <td>Origen</td>
                                   <td>Destino</td>
                                 </tr>
                               </thead>
                               <tbody>
                                 @foreach($rutas_fuec as $rutas)
                                  <tr>
                                    <td data-id="{{$rutas->id}}">
                                      <input style="width: 15px; height: 15px;" type="checkbox" check="false">
                                    </td>
                                    <td>{{$rutas->origen}}</td>
                                    <td>{{$rutas->destino}}</td>
                                  </tr>
                                 @endforeach
                               </tbody>
                             </table>
                          </div>
                      </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <select id="objeto_contrato" class="form-control input-font" style="margin-bottom: 25px">
                      <option>OBJETO DE CONTRATO</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL EMPRESARIAL</option>
                      <option>TRANSPORTE TERRESTRE DE TURISTAS</option>
                      <option>TRANSPORTE TERRESTRE DE PERSONAL FAMILIAR Y AMIGOS</option>
                      <option>TRANSPORTE TERRESTRE DE HUESPEDES</option>
                      <option>TRANSPORTE TERRESTRE DE USUARIOS DEL SERVICIO DE SALUD</option>
                      <option>TRANSPORTE TERRESTRE DE EMPLEADOS DE JAMAR</option>
                      <option>TRANSPORTE TERRESTRE GRUPO ESPECÍFICO DE USUARIOS (TRANSPORTE DE PARTICULAR)</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary guardar_fuecs"><span class="hecho hidden">Hecho <i class="fa fa-check" aria-hidden="true"></i></span> <span class="generando hidden">Generando <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span> <span class="generar">Generar</span></button>
              </div>
          </div>
        </div>
      </div>

      <!--<div class="modal fade" tabindex="-1" role="dialog" id='modal_documentos'>
        <div class="modal-dialog modal-xs" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;">DOCUMENTACIÓN VEHÍCULO</h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>Documentos</b> </div>
                        <div class="panel-body">
                          <h5 id="soat"></h5>
                          <br>
                          <h5 id="tecnomecanica"></h5>
                          <br>
                          <h5 id="mantenimiento_preventivo"></h5>
                          <br>
                          <h5 id="tarjeta_operacion"></h5>
                          <br>
                          <h5 id="poliza_contractual"></h5>
                          <br>
                          <h5 id="poliza_extracontractual"></h5>
                          <br>
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
        </div>
      </div>-->

      <!--<div class="modal fade" tabindex="-1" role="dialog" id='modal_conductor'>
        <div class="modal-dialog modal-xs" role="document">
          <div class="modal-content">
              <div class="modal-header warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="text-align: center;">DOCUMENTACIÓN CONDUCTOR</h4>
              </div>
              <div class="modal-body" style="height: 100%">
                <div class="col-lg-12 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background: #FA8A2C">
                        <b>Documentos</b> </div>
                        <div class="panel-body">
                          <h5 id="licencia"></h5>
                          <br>
                          <h5 id="seguridad_social"></h5>
                          <br>
                          <h5 id="examenes"></h5>
                          <br>
                        </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              </div>
          </div>
        </div>
      </div>-->

      <div class="documentacion_conductor hidden">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>DOCUMENTACION DEL CONDUCTOR</strong>
            </div>
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>LICENCIA DE CONDUCCION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_fvencimiento" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>SEGURIDAD SOCIAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_fssocial" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>EXAMENES PSICOSENCOMETRICOS<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="conductor_examenes" style="font-size: 10px" class="text-success bolder"></small>
                </li>
              </ul>
              <button type="button" class="btn btn-primary btn-block ok">
                OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="documentacion_vehiculo hidden">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <strong>DOCUMENTACION DEL VEHICULO</strong>
            </div>
            <div class="panel-body">
              <ul class="list-group">
                <li class="list-group-item">
                  <span>ADMINISTRACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vadministracion" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>TARJETA DE OPERACION<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vtarjeta_operacion" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>SOAT<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vsoat" style="font-size: 10px" class="text-success bolder "></small>
                </li>
                <li class="list-group-item">
                  <span>TECNOMECANICA<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vtecnomecanica" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>MANTENIMIENTO PREVENTIVO<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vmantenimiento_preventivo" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>POLIZA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vpoliza_contractual" style="font-size: 10px" class="text-success bolder"></small>
                </li>
                <li class="list-group-item">
                  <span>POLIZA EXTRA CONTRACTUAL<i class="circle_alerta" style="float: right; position: absolute; left: 265px; top: 16px;"></i></span><br>
                  <small id="vpoliza_extracontractual" style="font-size: 10px" class="text-success bolder"></small>
                </li>
              </ul>
              <button type="button" class="btn btn-primary btn-block ok">
                OK! <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
              </button>
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
  <script src="{{url('jquery/fuec.js')}}"></script>

  </body>
  </html>
