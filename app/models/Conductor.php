<?php

class Conductor extends Eloquent{

    protected $table = 'conductores';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('User', 'usuario_id');
    }

    public function proveedor()
    {
        return $this->belongsTo('Proveedor', 'proveedores_id');
    }

    public function seguridadsocial()
    {
        return $this->hasMany('Seguridadsocial', 'conductor_id');
    }

    public function scopeNoeventual($query){
        return $query->whereNull('eventual');
    }

    public function scopeSeguridadsocialmes($query){
        /*
        $seguridad_social = DB::table('seguridad_social')
                ->where('conductor_id',$conductor->conductor_id)
                ->where('ano',intval(date('Y')))
                ->where('mes',intval(date('m')))
                ->pluck('mes');*/

        return $query->selectRaw('*, (select numero_ingreso from seguridad_social where conductor_id = conductores.id and ano = '.intval(date('Y')).
        ' and mes = '.intval(date('m')).' limit 1) as seguridad');

    }

    public function scopeBloqueado($query)
    {
        return $query->whereRaw('(bloqueado <> 1 or bloqueado is null)');
    }

    public function scopeBloqueadototal($query)
    {
        return $query->whereRaw('(bloqueado_total <> 1 or bloqueado_total is null)');
    }

    public function scopeNoarchivado($query){
        return $query->whereNull('archivado');
    }

    public function scopeArchivado($query){
        return $query->where('archivado', 1);
    }

    public function scopeAprobada($query){
        return $query->whereNull('bloqueado')->whereNotNull('foto_app')->where('foto_autorizacion',1)->where('estado','activo');
    }

    public function scopePoraprobar($query){
        return $query->whereNotNull('foto_sin_autorizar')->where('foto_autorizacion',0)->where('estado','activo')->whereNull('bloqueado')->whereNull('bloqueado_total');
    }

    public function scopeSinfoto($query){
        return $query->whereNull('bloqueado')->where('estado','activo')->whereNull('archivado')->whereNull('foto_app')->whereNull('foto_sin_autorizar')->where('foto_autorizacion',0);
    }

    public function scopeTodosb($query){
        return $query->whereNull('bloqueado')->where('estado','activo')->whereNull('archivado');
    }

    public function scopeConfoto($query){
        return $query->whereNotNull('foto_app');
    }

    public function scopeConfotosinautorizar($query){
        return $query->whereNotNull('foto_sin_autorizar');
    }

    public function scopeActivos($query){
        return $query->whereNull('bloqueado_total')->whereNull('bloqueado');
    }

}
