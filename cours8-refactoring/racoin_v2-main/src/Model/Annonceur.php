<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonceur extends Model
{
    protected $table = 'annonceur';
    protected $primaryKey = 'id_annonceur';
    public $timestamps = false;

    public function annonces(): HasMany
    {
        return $this->hasMany(Annonce::class, 'id_annonceur');
    }
}
