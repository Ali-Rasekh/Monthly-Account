<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends BaseModel
{
    use HasFactory;

    protected $fillable = ['person_id', 'transaction_type', 'transaction_amount', 'description', 'jdatetime'];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
