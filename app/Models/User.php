<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'gender', 'unix_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->unix_id = IdGenerator::generate([
                'table' => $model->getTable(),
                'length' => 10,
                'field' => 'unix_id',
                'prefix' => "DTU-"
            ]);
        });
    }

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
