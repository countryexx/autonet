<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <title>Calificar Servicio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="./style.css">
@include('scripts.styles')
     <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{url('bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style type="text/css">
        *{
        margin: 0;
        padding: 0;
    }
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;    
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;  
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }

    /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */
    </style>

</head>
<body>

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-12 col-xs-12">
              <!--<h4 style="text-align: left;">TRACKING <i class="fa fa-map-marker" aria-hidden="true"></i></h4>-->
              <center><img style="margin-bottom: 20px; margin-top: 10px" src="{{url('img/logo_aotour.png')}}" width="120px"></center>
            </div>
            <center><div class="col-lg-12" style="margin-top: 10px">
                <span><br>Esperamos que hayas disfrutado tu viaje.<br>

Tu opinión es muy importante para nosotros. Te agradecemos calificar nuestro servicio. </span>
            </div></center>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-lg-4 col-lg-push-5">
            
                <div class="rate" style="margin-left: 100px;">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="text">1 star</label>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-push-5">
                <textarea class="form-control input-font detalle_text h4 text-left mt-3 mb-4 pb-3" rowspan="10" type="" name="" placeholder="Escribe un comentario (Opcional)" id="comentario"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-lg-push-5">
                <button class="btn btn-primary btn-block" id="enviar_calificacion" disabled >Calificar</button>
            </div>
        </div>

    </div>

    

<input type="number" name="" value="{{$id_ser}}" class="hidden" id="id_ser">
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
        <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
    </symbol>
    <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
        <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
    </symbol>
</svg>
 

</body>
    @include('scripts.scripts')
    <script src="{{url('jquery/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    

<script type="text/javascript">

    $('.angry').click(function(){
        
        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: 1}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

    });

    $('.sad').click(function(){
        
        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: 2}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

    });

    $('.ok').click(function(){
        
        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: 3}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

    });

    $('.good').click(function(){
        
        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: 4}
        }).done(function(data){

          if(data.respuesta==true){
            alert('Success!!!')
          }else if(data.respuesta==false){

          }

        });

    });

    $('#happy').click(function(){
        
        var id = $('#id_ser').val();

        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: 5, id: id}
        }).done(function(data){

          if(data.respuesta==true){
            
            $.confirm({
            title: 'Gracias!',
            content: 'Se ha enviado tu calificación.',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-primary',
                    keys: ['enter', 'shift'],
                    action: function(){

                      location.reload();

                    }

                }
            }        
        });

          }else if(data.respuesta==false){

          }

        });

    });

    $('#star1').click(function(){

        $('#enviar_calificacion').removeAttr('disabled','disabled');
        $('#enviar_calificacion').attr('data-rate',1);

    });

    $('#star2').click(function(){

        $('#enviar_calificacion').removeAttr('disabled','disabled');
        $('#enviar_calificacion').attr('data-rate',2);
        
    });

    $('#star3').click(function(){

        $('#enviar_calificacion').removeAttr('disabled','disabled');
        $('#enviar_calificacion').attr('data-rate',3);
        
    });

    $('#star4').click(function(){

        $('#enviar_calificacion').removeAttr('disabled','disabled');
        $('#enviar_calificacion').attr('data-rate',4);
        
    });

    $('#star5').click(function(){

        $('#enviar_calificacion').removeAttr('disabled','disabled');
        $('#enviar_calificacion').attr('data-rate',5);
        
    });

    $('#enviar_calificacion').click(function(){

        var id = $('#id_ser').val();
        var rate = $(this).attr('data-rate');
        var comentarios = $('#comentario').val();

        //alert('Prueba '+id+' , '+comentarios);

        $.ajax({
          url: '../ratevalue',
          method: 'post',
          data: {tipo: rate, id: id, comentarios: comentarios}
        }).done(function(data){

          if(data.respuesta==true){
            
            $.confirm({
            title: 'Gracias!',
            content: 'Se ha enviado tu calificación.',
            buttons: {
                confirm: {
                    text: 'Ok',
                    btnClass: 'btn-primary',
                    keys: ['enter', 'shift'],
                    action: function(){

                      location.reload();

                    }

                }
            }        
        });

          }else if(data.respuesta==false){

          }

        });

    });

</script>
</html>
