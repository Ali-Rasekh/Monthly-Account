<?php

namespace App\Models;

use App\traits\JalaliTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use JalaliTrait;

    protected $hidden = ['created_at', 'updated_at'];
//TODO  مبالغ باید به صورت عددی نشون داده بشن   یعنی 1و000            number format belongoing wealth
    public function getJdatetimeAttribute($value): string
    {
        return $this->convertIntDateToString($value);
    }

    public function setJdatetimeAttribute($value): void
    {
        $this->attributes['jdatetime'] = $this->convertDateTimeToInt($value);
    }

}
