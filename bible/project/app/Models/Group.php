<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $primaryKey = 'number';
    public $incrementing = false;
    protected $table = 'groups';
    protected $keyType = 'string';

    protected $fillable = ['number'];

    public function issuanceBooks(): HasMany
    {
        return $this->hasMany(IssuanceBook::class, 'group_number', 'number');
    }
}
