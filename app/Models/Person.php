<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends BaseModel
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name', 'wealth', 'belongings', 'percentage_of_participation'
    ];
}
