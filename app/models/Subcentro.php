<?php
class Subcentro extends Eloquent{
    protected $table = 'subcentrosdecosto';
    public $timestamps = false;

    public function scopeNobloqueado($query)
    {
        return $query->whereNull('bloqueado');
    }

}
