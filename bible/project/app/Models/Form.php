<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Form extends Model
{
     protected $fillable = [
        'name',
        'group_number',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_number', 'number');
    }
}
