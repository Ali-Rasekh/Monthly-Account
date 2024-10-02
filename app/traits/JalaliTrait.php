<?php

namespace App\traits;

use Illuminate\Support\Str;
use Mockery\Exception;
use Morilog\Jalali\Jalalian;

trait JalaliTrait
{
    public function convertNowToInt(): int
    {
        $now = Jalalian::now()->toDateString();
        return (int)Str::remove('/', $now);
    }

    public function convertIntDateToString(int $date): int
    {
        if (strlen($date) != 8) throw new Exception('date should 8 ');
        $dateSTR = "$date";
        $year = substr($dateSTR, 0, 4);
        $month = substr($dateSTR, 4, 2);
        $day = substr($dateSTR, 6);
        return "$year/$month/$day";
    }

}
