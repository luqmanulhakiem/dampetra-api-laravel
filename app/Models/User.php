<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Get the daily emotions for the user.
     * @return HasMany
     */
    public function dailyEmotions(): HasMany
    {
        return $this->hasMany(DailyEmotion::class);
    }

    /** Get the period logs for the user.
     * @return HasMany
     */
    public function periodLogs(): HasMany
    {
        return $this->hasMany(PeriodLog::class);
    }

    /** Get the couple relationship for the user.
     * @return BelongsTo
     */    public function couples(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }
}
