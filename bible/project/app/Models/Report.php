<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'first_at',
        'second_at',
        'created_at',
        'updated_at'
    ];
}
