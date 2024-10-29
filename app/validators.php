<?php

Validator::extend('sololetrasyespacio', function($attribute, $value){
  return preg_match('|^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$| ', $value);
});

Validator::extend('letrasespacioycoma', function($attribute, $value){
  return preg_match('/^[,\sa-zA-Z]+$/', $value);
});

Validator::extend('letrasespacionumerosycoma', function($attribute, $value){
    return preg_match('|^[A-Z0-9, a-z]*$|', $value);
});

Validator::extend('letrasnumerosyespacios', function($attribute, $value){
return preg_match('|^[A-Z0-9 áéíóúñüÁÉÍÓÚÑÜa-z]*$|', $value);
});

Validator::extend('select', function($attribute, $value){
    return preg_match('/^[a-zA-Z.]/', $value);
});
