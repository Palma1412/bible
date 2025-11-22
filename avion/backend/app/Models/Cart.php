<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Cart extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';
    protected $fillable  = ['uuid', 'user_id', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function items() {
        return $this->hasMany(CartItem::class, 'cart_uuid', 'uuid');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
