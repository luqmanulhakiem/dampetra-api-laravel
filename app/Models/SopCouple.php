<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        return $this->hasOne(SopCategory::class, 'id', 'category_id');
    }
}
