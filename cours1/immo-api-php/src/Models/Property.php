<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends \Illuminate\Database\Eloquent\Model
{
    use SoftDeletes;
    protected $table = 'property';
    protected $primaryKey = 'id';
    protected $attributes = [
      'is_sold' => false,
    ];
    protected $casts = [
      'is_sold' => 'boolean',
    ];

    protected $with = ['options'];

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }
}
