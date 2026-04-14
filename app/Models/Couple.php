<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Couple extends Model
{
    protected $guarded = ['id'];

    function couples(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /** Get the SOP Couples for the couple.
     * @return HasMany
     */
    function sopCouples(): HasMany
    {
        return $this->hasMany(SopCouple::class);
    }
}
