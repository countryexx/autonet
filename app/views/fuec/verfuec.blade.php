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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  </head>
  <body>
      @include('admin.menu')
      @include('fuec.breadcrumb')
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="row">
            <h3 class="h_titulo">
              LISTADO DE FUECS - <strong style="color: #f47321;">{{$vehiculo->marca.' '.$vehiculo->modelo.' '.$vehiculo->placa}}</strong>
            </h3>
            @if(isset($fuec))
            <table id="listado_fuec_vehiculo" class="table table-bordered hover" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Contrato</th>
                  <th>Fuec</th>
                  <th>Contratante</th>
                  <th>Objeto de contrato</th>
                  <th>Ruta</th>
                  <th>Nit</th>
                  <th>Fecha Inicial</th>
                  <th>Fecha Final</th>
                  <th>Conductor(es)</th>
                  <th>Informacion</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th>Contrato</th>
                  <th>Fuec</th>
                  <th>Contratante</th>
                  <th>Objeto de contrato</th>
                  <th>Ruta</th>
                  <th>Nit</th>
                  <th>Fecha Inicial</th>
                  <th>Fecha Final</th>
                  <th>Conductor(es)</th>
                  <th>Informacion</th>
                </tr>
                </tfoot>
                <tbody>
                  <?php
                    $i=1;
                  ?>
                  @foreach($fuec as $f)
                    <tr data-fuec-id="{{$f->id}}" @if($f->cantidad_descargas>0) {{'class="success"'}} @endif>
                      <td>{{$i++}}</td>
                      <td>{{$f->contrato->numero_contrato}}</td>
                      <td>{{$f->consecutivo}}</td>
                      <td>{{$f->contrato->contratante}}</td>
                      <td>{{$f->objeto_contrato}}</td>
                      <td>{{'ORIGEN: '.$f->rutafuec->origen.' / DESTINO: '.$f->rutafuec->destino}}</td>
                      <td>{{$f->contrato->nit_contratante}}</td>
                      <td>{{$f->fecha_inicial}}</td>
                      <td>{{$f->fecha_final}}</td>
                      <td>{{$f->conductores()}}</td>
                      <td>
                          @if(isset($permisos->administrativo->fuec->editar))
                              @if($permisos->administrativo->fuec->editar==='on')
                                  <a href="{{'../../fuec/editar/'.$f->id}}" class="btn btn-primary btn-list-table">
                                      EDITAR
                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                  </a>
                              @else
                                  <a class="btn btn-primary btn-list-table disabled">
                                      EDITAR
                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                  </a>
                              @endif
                          @else
                              <a class="btn btn-primary btn-list-table disabled">
                                  EDITAR
                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </a>
                          @endif

                          @if(isset($permisos->administrativo->fuec->descargar))
                              @if($permisos->administrativo->fuec->descargar==='on')
                                  <a href="{{'../../fuec/exportarfuecpdf/'.$f->id}}" class="btn btn-info btn-list-table">
                                      DESCARGAR
                                      <i class="fa fa-download" aria-hidden="true"></i>
                                  </a>
                              @else
                                  <a class="btn btn-info btn-list-table disabled">
                                      DESCARGAR
                                      <i class="fa fa-download" aria-hidden="true"></i>
                                  </a>
                              @endif
                          @else
                              <a class="btn btn-info btn-list-table disabled">
                                  DESCARGAR
                                  <i class="fa fa-download" aria-hidden="true"></i>
                              </a>
                          @endif
                          <label for="check_correo" class="btn btn-default btn-list-table" style="padding: 1px 2px 2px 3px;">
                              <input type="checkbox" class="check_correo">
                          </label>
                          <a href="#" style="padding: 3px 4px;" class="btn btn-success btn-list-table open_modal_historico" data-fuec-id="{{$f->id}}">
                              <span style="font-size: 12px;">
                                  @if($f->cantidad_descargas!=null)
                                    {{$f->cantidad_descargas}}
                                  @elseif($f->cantidad_descargas==null)
                                      {{0}}
                                  @endif
                              </span>
                              <i class="fa fa-download"></i>
                          </a>
                          <a class="btn btn-default btn-list-table fuec_enviado" data-fuec-id="{{$f->id}}">
                              @if($f->envio_fuec_id!=null)
                                <i title="Enviado" style="color: green;" class="fa fa-envelope" aria-hidden="true"></i>
                              @else
                                  <i title="No Enviado" style="color: red" class="fa fa-envelope" aria-hidden="true"></i>
                              @endif
                          </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            @else
              <small class="text-danger">NO HAY UN FUEC REGISTRADO PARA ESTE VEHICULO</small>
            @endif
            <a class="btn btn-success btn-icon" data-proveedor-email="@if(!is_null($vehiculo->proveedor->email) and $vehiculo->proveedor->email!=''){{strtolower($vehiculo->proveedor->email)}}@else{{'null'}}@endif" id="enviar_mail">
                ENVIAR MAIL
                <i class="fa fa-envelope icon-btn"></i>
            </a>
            @include('admin.back_button')
          </div>
        </div>
      </div>

      <div class="modal fade" id="open_modal_mail_enviados" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <strong>INFORMACION DE ENVIO</strong>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-12">
                  <div id="envio_info_fuec">

                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal_historico_documentacion">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                          <i class="fa fa-times" style="font-size: 15px;"></i>
                      </button>
                      <strong>HISTORIAL DE DOCUMENTACION</strong>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-lg-12">
                              <p>
                                  Este fuec fue creado el dia y hora
                                  <span id="fecha_creacion_fuec">2018-05-45</span> por el usuario
                                  <span style="color: #F47321;" id="usuario_creador_fuec"></span>
                              </p>
                              <div class="list-group">
                                  <a class="list-group-item">
                                      <h4 style="font-size: 15px;" class="list-group-item-heading">
                                          <span style="color: #337AB7">Seguridad Social</span>
                                      </h4>
                                      <p class="list-group-item-text" id="conductor_info_seguridad_social">
                                      </p>
                                  </a>
                                  <a class="list-group-item">
                                      <h4 style="font-size: 15px;" class="list-group-item-heading">
                                          <span style="color: #337AB7">Administracion</span>
                                      </h4>
                                      <p class="list-group-item-text">
                                          La fecha de registro es: <span id="fecha_creacion_administracion"></span>
                                          y fue realizada por <span id="administracion_creado_por" style="color: #F47321"></span>
                                      </p>
                                  </a>
                                  <a class="list-group-item">
                                      <h4 style="font-size: 15px;" class="list-group-item-heading">
                                          <span style="color: #337AB7">Examenes Sensométricos</span>
                                      </h4>
                                      <p class="list-group-item-text" id="conductor_info_examenes_sensometricos">
                                      </p>
                                  </a>
                              </div>
                              <a class="btn btn-primary" id="ver_descargas">
                                  Descargas <i class="fa fa-download change_for_preloader" aria-hidden="true"></i>
                              </a>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">CERRAR</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <div class="modal fade" id="modal_descargas">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <strong>DESCARGAS</strong>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-lg-12">
                            <div style="overflow-y: scroll; height: 270px;">
                              <table class="table table-bordered table-hover" id="tabla_descargas_fuec">
                                  <thead>
                                  <tr>
                                      <th>IP</th>
                                      <th>Navegador</th>
                                      <th>Fecha y Hora</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>
                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <script src="{{url('dist/fuec.js')}}"></script>
  </body>
</html>
