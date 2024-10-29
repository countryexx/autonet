<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Pasajero extends Eloquent{

    public function centrodecosto()
    {
        return $this->belongsTo('Centrodecosto');
    }

    public function getNombresAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getApellidosAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getBarrioAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getDireccionAttribute($value)
    {
        return strtoupper(strtolower($value));
    }

    public function getCargoAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getAreaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getSubareaAttribute($value)
    {
        return ucwords(strtolower($value));
    }

}
