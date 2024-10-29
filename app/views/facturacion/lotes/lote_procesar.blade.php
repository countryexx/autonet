<html>
<head>
	<meta name="url" content="{{url('/')}}">
	<title>Autonet | Lote Pagos por Procesar</title>
	<link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon" />
	@include('scripts.styles')
	<link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/datatables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker\css\bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
<body>

	@include('admin.menu')
	<div class="col-lg-10">
		@include('facturacion.menu_pago_proveedores')
	</div>
	<div class="col-lg-12">
		<h3 class="h_titulo">Lotes por Procesar</h3>
		<!--<button style="margin-bottom: 15px" type="button" class="btn btn-default btn-icon lotes">
			Crear Lote
			<i class="fa fa-plus icon-btn"></i>
		</button>-->

	    <table id="example_lotes" class="table table-bordered hover tabla" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<td>Consecutivo</td>
	    			<td>Nombre</td>
	    			<td>Fecha de Expedicion</td>
            <td>Proceso</td>
	    			<td>Valor</td>
            <td>Creado Por</td>
	    			<td></td>
	    		</tr>
	    	</thead>
        <tbody>
          @foreach($lotes as $lote)
            <tr>
              <td>{{$lote->id}}</td>
              <td>{{$lote->nombre}}</td>
              <td>{{$lote->created_at}}</td>
              <td>
                @if($lote->estado==null)
                  En Construcción
                @elseif($lote->estado==1)
                  Por Procesar
                @elseif($lote->estado==2)
                  Por Aprobar
                @endif
              </td>
              <td>$ {{number_format($lote->valor)}}</td>
              <td>{{$lote->first_name.' '.$lote->last_name}}</td>
              <td>
                @if($lote->estado>1)
                  <center>
										<a href="{{url('facturacion/listadodepagosporprocesar/'.$lote->id)}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-warning btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true"><i class="fa fa-spinner fa-spin" aria-hidden="true" style="font-size: 16px;"></i></a>
										<!--<img src="{{url('img/loaders.gif')}}" alt="" height="20px" width="20px">-->
                  </center>
                @else
                  <center>
                    <a href="{{url('facturacion/listadodepagosporprocesar/'.$lote->id)}}" style="padding: 6px 8px 6px 8px; display: inline-block" type="button" class="btn btn-primary btn-list-table" aria-haspopup="true" title="Ver el Lote" aria-expanded="true"><i class="fa fa-share" aria-hidden="true" style="font-size: 16px;"></i></a>
                  </center>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
	    	<tfoot>
	    		<tr>
	    			<td>Consecutivo</td>
	    			<td>Nombre</td>
	    			<td>Fecha de Expedicion</td>
	    			<td>Proceso</td>
	    			<td>Valor</td>
            <td>Creado Por</td>
	    			<td></td>
	    		</tr>
	    	</tfoot>
	    </table>

		<!-- -->
    <div class="modal fade" tabindex="-1" role="dialog" id='modal_lote' data-backdrop="false" >
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="text-align: center;" id="name"><b id="title" class="parpadea">Crear Lote</b></h4>
            </div>
            <div class="modal-body">

              <div class="row">

                <div class="col-lg-12">
                  <label>Nombre del Lote</label>
                  <input class="form-control input-font detalle_text" style="text-transform: uppercase;" placeholder="Nombre del Lote" autocomplete="off" id="nombre_lote">
                </div>

              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
        						<div class="input-group" id="datetime_fecha">
                      <label for="">Fecha</label>
        							<div class='input-group date' id='datetimepicker10'>
        								<input id="fecha_lote" name="fecha_inicial" style="width: 100px;" type='text' class="form-control input-font" placeholder="FECHA">
                        <span class="input-group-addon">
                            <span class="fa fa-calendar">
                            </span>
                        </span>
        							</div>
        						</div>
        					</div>
                </div>

              </div>

            </div>

            <div class="modal-footer">

              <center>
                <a data-dismiss="modal" class="btn btn-danger btn-icon">CERRAR<i class="fa fa-times icon-btn"></i></a>
                <a id="agregar_lote" style="float: right; margin-right: 6px; margin-left: 20px" class="btn btn-primary btn-icon">GUARDAR<i class="fa fa-check icon-btn"></i></a>
              </center>

            </div>
        </div>
      </div>
    </div>
		<!-- -->
	</div>

@include('scripts.scripts')
<script src="{{url('jquery/jquery-ui.min.js')}}"></script>
<script src="{{url('datatables/media/js/jquery.datatables.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\moment-with-locales.js')}}"></script>
<script src="{{url('bootstrap-datetimepicker\js\bootstrap-datetimepicker.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{url('jquery/facturacion.js')}}"></script>
<script>

function goBack(){
    window.history.back();
}

  $('.lotes').click(function(){
    //Abrir modal
    $('#modal_lote').modal('show');
  });

  $('#agregar_lote').click(function(){

      var nombreLote = $('#nombre_lote').val().toUpperCase();
      var fecha = $('#fecha_lote').val();

      console.log(nombreLote)
      console.log(fecha)

      if(nombreLote==='' || fecha===''){

        var text = '';

        if(nombreLote===''){
          text += '<li>El nombre es obligatorio.<br></li>'
        }

        if(fecha===''){
          text += '<li>La fecha obligatoria.</li>'
        }

        $.confirm({
            title: 'Atención',
            content: text,
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-primary',
                    keys: ['enter', 'shift'],
                    action: function(){



                    }

                }
            }
        });

      }else{

        $.ajax({
          url: 'nuevolote',
          method: 'post',
          data: {nombre: nombreLote, fecha: fecha}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Lote Creado!');
            location.reload();
          }else if(data.respuesta==false){

          }

        });

      }

    });

	window.onload=function(){
		var pos=window.name || 0;
		window.scrollTo(0,pos);

	}
	window.onunload=function(){
	window.name=self.pageYOffset || (document.documentElement.scrollTop+document.body.scrollTop);
	}

  $tableg = $('#example_lotes').DataTable( {
      "order": [[ 0, "asc" ]],
      paging: false,
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
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      },
      'bAutoWidth': false,
      'aoColumns' : [
          { 'sWidth': '1%' },
          { 'sWidth': '6%' },
          { 'sWidth': '3%' },
          { 'sWidth': '4%' },
          { 'sWidth': '4%' },
          { 'sWidth': '8%' },
          { 'sWidth': '3%' }
      ],
  });


</script>
</body>
</html>
