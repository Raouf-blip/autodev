<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $primaryKey = 'id_annonce';
    public $timestamps = false;
    public $links = null;

    public function annonceur(): BelongsTo
    {
        return $this->belongsTo(Annonceur::class, 'id_annonceur');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'id_annonce');
    }
}
