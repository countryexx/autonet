<?php
  class Seguridadsocial extends Eloquent{

    protected $table = 'seguridad_social';

    public function user()
    {
      return $this->belongsTo('User', 'creado_por');
    }

    public function conductor()
    {
      return $this->belongsTo('Conductor');
    }

  }
