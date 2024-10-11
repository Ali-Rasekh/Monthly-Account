<?php

namespace App\Models;

use Database\Factories\AccountValuesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountValue extends BaseModel
{
    /** @use HasFactory<AccountValuesFactory> */
    use HasFactory;

    protected $fillable = [
        'account_id', 'value', 'jdatetime'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
