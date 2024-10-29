<?php

/**
 * Controlador para el modulo de transportes
 */
class TransportederutaController extends BaseController{

  public function getIndex($code){
    
    //$code = Crypt::decryptString($code);

    $code = DB::table('qr_rutas')
    ->where('code',$code)
    ->first();

    return View::make('transportederuta.qr', [
      'id' => $code
    ]);

  }

  public function getQr($code){
    
    $code = Crypt::decryptString($code);

    $codigo = DB::table('qr_rutas')
    ->where('code',$code)
    ->first();

    if($codigo){

      return View::make('transportederuta.qr', [
        'id' => $code,
        'codigo' => $codigo
      ]);

    }else{

      return View::make('transportederuta.qr_invalido', [
        'id' => $code
      ]);

    }

  }

  public function getConfirmarubicacion($id) {

    $usuario = DB::table('pasajeros_rutas')
    ->select('id', 'nombres', 'confirmado', 'direccion', 'barrio', 'localidad', 'hora', 'fecha', 'latitude', 'longitude', 'tipo')
    ->where('id', $id)
    ->first();

    if($usuario->tipo==1) {
      $tipo = 'ENTRADA';
    }else{
      $tipo = 'SALIDA';
    }

    if($usuario->confirmado==1) {
      
      return View::make('autogestion.confirmado')
      ->with('tipo',$tipo)
      ->with('usuario',$usuario);

    }else{
      
      return View::make('autogestion.confirmar')
      ->with('tipo',$tipo)
      ->with('usuario',$usuario);

    }

  }

  public function postActualizarubicacion() {

    $id = Input::get('id');
    $direccion = Input::get('direccion');
    $lat = Input::get('lat');
    $lng = Input::get('lng');

    $pax = PasajeroRuta::find($id);
    $pax->direccion = $direccion;
    $pax->latitude = $lat;
    $pax->longitude = $lng;
    $pax->confirmado = 1;
    $pax->save();


    return Response::json([
      'response' => true
    ]);

  }

}
