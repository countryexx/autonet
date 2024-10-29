<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="url" content="{{url('/')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autonet | Aceptar Politicas</title>
    @include('scripts.styles')
    <link href="{{url('img/favicon.png')}}" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="{{url('bootstrap/css/datatables.css')}}">
    <link rel="stylesheet" href="{{url('datatables/media/css/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <style media="screen">
      div.textarea{
        overflow-y: scroll;
        min-height: 300px;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-8 col-lg-offset-3 col-md-offset-2 col-xs-12">
              <div class="text-center">
                <img style="margin-top: 20px;" src="{{url('img/logo_aotour.png')}}" width="200px;">
              </div>
              <h5 class="text-center">
                <strong>RECOMENDACIONES PREVIAS</strong><br><br>
                <p>Tomate el tiempo de leer</p>
              </h5>
              <div class="form-group">
                <label for="">
                </label>
                <div class="form-control textarea">
                  @include('fuec.politicas')
                </div>
              </div>
              <form action="{{url('politicas/fuec/aceptar/'.$fuec->enviofuec->id)}}" method="post">
                <div class="col-xs-12">
                  <div class="row">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 @if($errors->has('cc')) {{'has-error'}} @endif">
                      <div class="row">
                        <label for="cc">Numero de identificacion</label>
                        <input type="text" class="form-control input-font" id="cc" name="cc" value="{{Input::old('cc')}}" placeholder="Digite el numero de su cedula" autocomplete="off">
                        @if ($errors->has('cc'))
                            <small class="text-danger">{{$errors->first('cc')}}</small>
                        @endif
                        @if (Session::has('errores'))
                          <small class="text-danger">{{Session::get('errores')}}</small>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label style="margin-right: 5px; display: inline;">Notifico que he recibido los fuec y acepto que he leido y he entendido la recomendaciones que me han sido suministradas.</label>
                  <input type="checkbox" name="aceptar_politicas" style="vertical-align: sub;">
                  @if ($errors->has('aceptar_politicas'))
                      <br><small class="text-danger">{{$errors->first('aceptar_politicas')}}</small>
                  @endif
                </div>
                <button type="submit" class="btn btn-primary" name="button">ENVIAR</button>
              </form>
          </div>
        </div>
      </div>
      <script src="{{url('dist/fuec.js')}}"></script>
  </body>
</html>
