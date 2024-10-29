<?php

class TokenPayU extends Eloquent
{
    protected $table = 'tokens_payu';

    protected $hidden = ['creditCardTokenId', 'updated_at', 'identificationNumber'];

    public function scopeValido($query)
    {
        return $query->where('valido', 1);
    }

}
