<?php
class Centrodecosto extends Eloquent {

  protected $table = 'centrosdecosto';
  public $timestamps = false;

  public function user(){

    return $this->hasMany('User');

  }

  public function subcentro(){

    return $this->hasMany('Subcentro', 'centrosdecosto_id');

  }

  public function scopeActivos($query)
  {
      return $query->whereNull('inactivo_total');
  }

  public function scopeInternos($query)
  {
      return $query->whereRaw('(tipo_cliente is null or tipo_cliente = 1)');
  }

  public function scopeAfiliadosexternos($query)
  {
      return $query->where('tipo_cliente', 2);
  }

  public function nombreruta(){

    return $this->hasMany('NombreRuta', 'centrodecosto_id');

  }

}
