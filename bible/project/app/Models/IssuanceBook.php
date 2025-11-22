<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssuanceBook extends Model
{
    protected $table = 'issuance_books';
    protected $fillable = [
        'form_id',
        'initial',
        'information_resources_id',
        'consumer'
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function informationResource()
    {
        return $this->belongsTo(InformationResource::class, 'information_resource_id');
    }
}
