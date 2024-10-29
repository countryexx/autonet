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
      
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="row">
            <h3 class="h_titulo">
              LISTADO DE FUECS VIGENTES</strong>
            </h3>
            @if(isset($fuec))
            <table id="listado_fuec_vehiculos" class="table table-bordered hover" cellspacing="0" width="100%">
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
                      <td>{{$f->numero_contrato}}</td>
                      <td>{{$f->consecutivo}}</td>
                      <td>{{$f->contratante}}</td>
                      <td>{{$f->objeto_contrato}}</td>
                      <td>{{'ORIGEN: '.$f->origen.' / DESTINO: '.$f->destino}}</td>
                      <td>{{$f->nit_contratante}}</td>
                      <td>{{$f->fecha_inicial}}</td>
                      <td>{{$f->fecha_final}}</td>
                      <td>{{$f->nombre_completo}}</td>
                      <td>
                          
                        <a href="{{'../fuec/exportarfuecpdf/'.$f->id}}" class="btn btn-info btn-list-table">
                            DESCARGAR
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </a>

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
                          
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
            @else
              <small class="text-danger">NO HAY UN FUEC REGISTRADO PARA ESTE VEHICULO</small>
            @endif
            
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
                                  <span id="fecha_creacion_fuec">2018-05-45</span> por
                                  <span style="color: #F47321;" id="usuario_creador_fuec"></span>
                              </p>
                              
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
      <script type="text/javascript">

        $('#listado_fuec_vehiculos').on('click', '.open_modal_historico', function (event) {

          var url = $('meta[name="url"]').attr('content');

          event.preventDefault();

          var fuec_id = $(this).attr('data-fuec-id');

          $.ajax({
              url: url+'/portalproveedores/historicofuec',
              method: 'post',
              data: {
                  fuec_id: fuec_id
              }
          }).done(function (response, responseStatus, data){

              var data_res = data.responseJSON;

              if (data.status==200) {

                  if (data_res.response==true) {

                      $('#ver_descargas').attr('data-fuec-id', data_res.fuec.id);

                      $('#fecha_creacion_fuec').text(data_res.fuec.created_at);

                      var htmlSeguridadSocial = '';

                      for(var i in data_res.seguridad_social) {

                          htmlSeguridadSocial += 'La fecha de registro del conductor <span style="color: #F47321">'+
                          uc_words(data_res.seguridad_social[i].conductor.nombre_completo.toLowerCase())+'</span> es: '+data_res.seguridad_social[i].created_at+
                          ' y fue registrada por <span style="color: #F47321">'+uc_words(data_res.seguridad_social[i].user.first_name.toLowerCase()+' '+
                          data_res.seguridad_social[i].user.last_name.toLowerCase())+'</span><br>';

                      }

                      $('#conductor_info_seguridad_social').html(htmlSeguridadSocial);

                      $('#usuario_creador_fuec').text(data_res.fuec.user.first_name);

                      $('#fecha_creacion_administracion')
                          .text(data_res.administracion.created_at);

                      $('#administracion_creado_por').text(
                          data_res.administracion.user.first_name.trim()
                              .toLowerCase()+' '+
                              data_res.administracion.user.last_name.trim().toLowerCase()
                          
                      );

                      var htmlExamenesSensometricos = '';
                      var creado_por;

                      /*for(var i in data_res.examenes_sensometricos) {

                          var fecha_examen = moment(data_res.examenes_sensometricos[i].ultima_fecha)
                              .add(1, 'y').format('YYYY-MM-DD');

                          if (data_res.examenes_sensometricos[i].user!=null) {
                              creado_por = data_res.examenes_sensometricos[i].user.first_name.toLowerCase()+' '+
                              data_res.examenes_sensometricos[i].user.last_name.toLowerCase();
                          }else{
                              creado_por = 'No registrado';
                          }

                          htmlExamenesSensometricos += 'La fecha de vencimiento de los examenes sensometricos del conductor <span style="color: #F47321">'+
                              uc_words(data_res.examenes_sensometricos[i].conductor.nombre_completo.toLowerCase())+
                              '</span> es: <span>'+fecha_examen+'</span>'+
                              ' y fue registrada por '+
                              '<span style="color: #F47321">'+creado_por+'</span><br>';

                      }*/

                      //$('#conductor_info_examenes_sensometricos').html(htmlExamenesSensometricos);

                      $('#modal_historico_documentacion').modal('show');

                  }
              }

          }).fail(function(){

          });

      });

        var $listado_fuec_vehiculo = $('#listado_fuec_vehiculos').DataTable({
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:    "Mostrar _MENU_ Registros",
            info:           "Mostrando _START_ de _END_ de _TOTAL_ Registros",
            infoEmpty:      "Mostrando 0 de 0 de 0 Registros",
            infoFiltered:   "(Filtrando de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "NINGUN REGISTRO ENCONTRADO",
            emptyTable:     "NINGUN REGISTRO DISPONIBLE EN LA TABLA",
            paginate: {
                first:      "Primer",
                previous:   "Antes",
                next:       "Siguiente",
                last:       "Ultimo"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre d?croissant"
            }
        },
        'bAutoWidth': false ,
        'aoColumns' : [
            { 'sWidth': '3%' },
            { 'sWidth': '5%' },
            { 'sWidth': '4%' },
            { 'sWidth': '10%' },
            { 'sWidth': '15%' },
            { 'sWidth': '15%' },
            { 'sWidth': '8%' },
            { 'sWidth': '7%' },
            { 'sWidth': '7%' },
            { 'sWidth': '10%' },
            { 'sWidth': '19%' }
        ]
    });
      </script>
  </body>
</html>
