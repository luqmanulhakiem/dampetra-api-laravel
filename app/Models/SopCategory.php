<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SopCategory extends Model
{
    protected $guarded = ['id'];

    function sopCouple(): BelongsTo
    {
        return $this->belongsTo(SopCouple::class, 'id', 'category_id');
    }
}
