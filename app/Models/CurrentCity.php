<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'last_query',
        'response'
    ];
}
