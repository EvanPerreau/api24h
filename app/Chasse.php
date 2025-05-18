<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Authentication\Models\Entities\User;

class chasse extends Model
{
    protected $table = 'chasses';

    protected $fillable = [
        'nom',
        'lieu',
        'date',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
