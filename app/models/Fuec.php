<?php

  class Fuec extends Eloquent{

    protected $table = 'fuec';

    public function vehiculo()
    {
        return $this->belongsTo('Vehiculo', 'vehiculo');
    }

    public function user()
    {
      return $this->belongsTo('User', 'creado_por');
    }

    public function contrato()
    {
        return $this->belongsTo('Contrato');
    }

    public function rutafuec()
    {
        return $this->belongsTo('Rutafuec', 'ruta_id');
    }

    public function conductores()
    {
        $conductores = explode(',', $this->conductor);
        $conductores = Conductor::whereIn('id', $conductores)->get();
        $i=1;

        $nombre_conductores = '';

        foreach ($conductores as $conductor) {
          $nombre_conductores = $conductor->nombre_completo.' ';          
        }

        return $nombre_conductores;
    }

    public function enviofuec()
    {
        return $this->belongsTo('Enviofuec', 'envio_fuec_id');
    }

  }
