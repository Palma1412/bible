<?php

namespace App\Models;

use App\Enums\BookTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class InformationResource extends Model
{
    protected $fillable = [
        'name',
        'author',
        'type',
        'delivery_date',
        'debit_date',
    ];

    public function getWriteOffStatusAttribute()
    {
        $deliveryDate = Carbon::parse($this->delivery_date);
        $age = $deliveryDate->diffInYears(now());

        if ($age >= 5) {
            return 'Подлежит списанию';
        }
        
        return 'Активна';
    }

    public function setDeliveryDateAttribute($value)
    {
        $this->attributes['delivery_date'] = $value;
        
        if ($value) {
            $this->attributes['debit_date'] = Carbon::parse($value)->addYears(5);
        } else {
            // Если дата поступления очищается, тоже очищаем дату списания
            $this->attributes['debit_date'] = null;
        }
    }

    protected $casts = [
        'delivery_date' => 'date', // Добавьте это приведение типа
        'debit_date' => 'date',    // И это тоже, если нужно
    ];

    public function issuanceBooks(): HasMany
    {
        return $this->hasMany(IssuanceBook::class);
    }

    public function getStatusAttribute(): string
    {
        // Проверяем, есть ли активная выдача (например, без даты возврата)
        return $this->issuanceBooks()->exists() ? 'Выдано' : 'В наличии';
    }
}
