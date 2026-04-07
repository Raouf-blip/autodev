<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $table = 'photo';
    protected $primaryKey = 'id_photo';
    public $timestamps = false;

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class, 'id_annonce');
    }
}
