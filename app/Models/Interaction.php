<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    protected $guarded = ['id'];

    function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }
}
