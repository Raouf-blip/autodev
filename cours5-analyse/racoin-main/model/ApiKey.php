<?php

namespace model;

class ApiKey extends \Illuminate\Database\Eloquent\Model {
    protected $table      = 'apikey';
    protected $primaryKey = 'id_apikey'; // la vraie PK dans le schéma SQL
    protected $keyType    = 'string';    // PK non-entière
    public    $incrementing = false;     // pas d'auto-incrément
    public    $timestamps   = false;
}
?>