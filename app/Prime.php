<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    protected $table = 'primes';

    protected $fillable = [
        'nom',
        'prix',
    ];
}
