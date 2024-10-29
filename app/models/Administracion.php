<?php
  class Administracion extends Eloquent{
    
    protected $table = 'administracion_vehiculos';

    public function user()
    {
      return $this->belongsTo('User', 'creado_por');
    }

  }
