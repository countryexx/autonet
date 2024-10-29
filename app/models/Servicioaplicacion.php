<?php

class Servicioaplicacion extends Eloquent{

    protected $table = 'servicios_aplicacion';

    public function pagoservicio()
    {
        $pago_servicio = Pagoservicio::find($this->pago_servicio_id);
        return $pago_servicio;
    }

    public function tarifastraslados()
    {
        return $this->belongsTo('Tarifastraslados');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function servicio()
    {
        return $this->belongsTo('Servicio', 'servicio_id');
    }

    public function tarifado_por()
    {
        $tarifador_user_id = $this->tarifador_user_id;
        $user = User::find($tarifador_user_id);
        return $user->first_name.' '.$user->last_name;
    }

    public function scopeSintarifa($query)
    {
        return $query->where('esperando_tarifa', 1)->whereNull('tarifado')->whereNull('cancelado');
    }

    public function scopeTarifado($query)
    {
        return $query->where('tarifado', 1)->whereNull('pago_servicio_id')->whereNull('programado')->whereNull('pago_facturacion')->whereNull('cancelado')->whereNull('empresarial');
    }

    public function scopePagados($query)
    {
        return $query->whereNotNull('pago_servicio_id')->whereNull('programado')->whereNull('cancelado');
    }

    public function scopeProgramado($query)
    {
        return $query->where('programado', 1);
    }

    public function scopePagofacturacion($query)
    {
        return $query->where('pago_facturacion', 1)->whereNull('programado')->whereNull('cancelado');
    }

    public function scopePagocredito($query)
    {
        return $query->where('pago_pendiente', 1)->whereNull('cancelado');
    }

    public function scopeCanceladosinprogramar($query)
    {
        return $query->where('cancelado', 1);
    }

    public function scopePagopendiente($query)
    {
        return $query->where('pago_pendiente', 1)->where('programado', 1)->whereNull('cancelado');
    }

}
