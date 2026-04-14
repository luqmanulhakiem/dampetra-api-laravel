<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SopCouple extends Model
{
    protected $guarded = ['id'];

    /**
     * Get Sop Category
     * @return HasOne
     */
    function category(): HasOne
    {
        return $this->hasOne(SopCategory::class, 'category_id', 'id');
    }

    /**
     * Get Couple
     * @return BelongsTo
     */
    function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }
}
