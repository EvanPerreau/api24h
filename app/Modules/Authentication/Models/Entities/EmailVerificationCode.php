<?php

namespace App\Modules\Authentication\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $code
 * @property int $user_id
 */
class EmailVerificationCode extends Model
{
    protected $table = 'email_verification_code';

    protected $fillable = [
        'user_id',
        'code',
    ];

    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
