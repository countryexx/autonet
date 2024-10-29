<?php

class Conductoresexamenes extends Eloquent {

  protected $table = 'conductor_examenes';

  public function conductor()
  {
    return $this->belongsTo('Conductor');
  }

  public function user()
  {
    return $this->belongsTo('User', 'creado_por');
  }

}
