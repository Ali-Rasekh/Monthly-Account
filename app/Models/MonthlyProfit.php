<?php

namespace App\Models;

use Database\Factories\MonthlyProfitFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyProfit extends BaseModel
{
    /** @use HasFactory<MonthlyProfitFactory> */
    use HasFactory;

    protected $fillable = [
        'person_id',
        'current_wealth',
        'current_belongings',
        'current_participation_percentage',
        'wealth_profit',
        'belongings_profit',
        'participation_profit',
        'total_profit',
        'jdatetime',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
