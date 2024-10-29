<?php

class Vehiculo extends Eloquent{

    protected $table = 'vehiculos';

    public function proveedor()
    {
        return $this->belongsTo('Proveedor', 'proveedores_id');
    }

    public function administracion()
    {
      return $this->hasMany('Administracion', 'vehiculo_id');
    }

    public function restriccionvehiculo()
    {
        return $this->hasMany('Restriccionvehiculo');
    }

    public function scopeNoeventual($query){
        return $query->whereNull('eventual');
    }

    public function scopeNoarchivado($query){
        return $query->whereNull('archivado');
    }

    public function scopeArchivado($query){
        return $query->where('archivado', 1);
    }

    public function scopeBloqueadototal($query)
    {
        return $query->whereRaw('(bloqueado_total <> 1 or bloqueado_total is null)');
    }

    public function scopeBloqueado($query)
    {
        return $query->whereRaw('(bloqueado <> 1 or bloqueado is null)');
    }

    public static function calculoCantidadDias($value,$fecha_servicio){

      return floor((strtotime($value)-strtotime($fecha_servicio))/86400);

    }

}
