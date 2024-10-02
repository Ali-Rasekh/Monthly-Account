<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected $hidden = ['created_at', 'updated_at'];

    public function getDateAttribute($value): string
    {
        $year = substr($value, 0, 4);
        $month = substr($value, 4, 2);
        $day = substr($value, 6, 2);

        return $year . '/' . $month . '/' . $day;
    }

    public function setDateAttribute($value): void
    {
        $this->attributes['date'] = str_replace('/', '', $value);
    }

}
