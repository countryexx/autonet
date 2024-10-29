<?php
class Proveedor extends Eloquent {

    protected $table = 'proveedores';
    public $timestamps = false;

    public function vehiculos()
    {
      return Vehiculo::where('proveedores_id', $this->id)->get();
    }

    public function conductores()
    {
      return Conductor::where('proveedores_id', $this->id)->get();
    }

    public function scopeValido($query)
    {
        return $query->whereNull('inactivo_total');
    }

    public function scopeAfiliadosinternos($query)
    {
        return $query->whereRaw('(tipo_afiliado is null or tipo_afiliado = 1) and eventual is null');
    }


    public function scopeAfiliadosexternos($query)
    {
        return $query->where('tipo_afiliado', 2)->whereNull('eventual');
    }

    public function scopeBogota($query)
    {
        return $query->whereIn('localidad', ['bogota','provisional'])->whereNull('eventual');
    }

    public function scopeBarranquilla($query)
    {
        return $query->whereIn('localidad', ['barranquilla','provisional'])->whereNull('eventual');
    }

    public function scopeAfiliadoseventuales($query)
    {
        return $query->where('eventual', 1);
    }


}
