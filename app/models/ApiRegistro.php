<?php

class ApiRegistro extends Eloquent{
    protected $table = 'registro';
    protected $hidden = ['created_at','updated_at'];
}
