<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'Shareholder_interest_percentage', 'partners_percentage', 'jdatetime'
    ];

}
