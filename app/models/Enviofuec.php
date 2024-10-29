<?php
/**
 * Created by PhpStorm.
 * User: AUX-AUTONET
 * Date: 14/12/2018
 * Time: 8:25
 */

/**
 * Class Enviofuec
 */
class Enviofuec extends Eloquent
{

  protected $table = 'envio_fuec';

  public function fuec()
  {
    return $this->hasMany('Fuec', 'envio_fuec_id');
  }

  public function vehiculo()
  {
    return $this->belongsTo('Vehiculo');
  }

  public function user()
  {
    return $this->belongsTo('User', 'enviado_por');
  }

}
