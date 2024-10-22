<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedProfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'profit', 'jdatetime'
    ];

}
