<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'mobile', 'wealth', 'is_partner', 'belongings', 'percentage_of_participation'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
