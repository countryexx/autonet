<?php

class PagoServicio extends Eloquent {

  protected $table = 'pago_servicios';

  public function user()
  {
      return $this->belongsTo('User');
  }

  public function servicioaplicacion()
  {
      return $this->hasOne('Servicioaplicacion');
  }

}
