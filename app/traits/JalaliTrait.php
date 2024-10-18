<?php

namespace App\traits;

use Illuminate\Support\Str;
use Mockery\Exception;
use Morilog\Jalali\Jalalian;

trait JalaliTrait
{
    public function convertDateTimeToInt(string $dateTime = null): int
    {
        if (is_null($dateTime))
            $dateTime = Jalalian::now()->toDateTimeString();

        $date = substr($dateTime, 0, 10);
        $date = Str::remove('/', $date);
        $time = substr($dateTime, 11);
        $time = Str::remove(':', $time);

        return $date . $time;
    }

    public function convertIntDateToString(int $datetime): string
    {
        if (strlen($datetime) != 14) throw new Exception('date should 14');

        $year = substr($datetime, 0, 4);
        $month = substr($datetime, 4, 2);
        $day = substr($datetime, 6, 2);
        $date = "$year/$month/$day";

        $hour = substr($datetime, 8, 2);
        $min = substr($datetime, 10, 2);
        $sec = substr($datetime, 12);
        $time = "$hour:$min:$sec";

        return "$date $time";
    }

    public function getNowByDateTimeString(): string
    {
        return Jalalian::now()->toDateTimeString();
    }

    public function getNowByDateString(): string
    {
        return Jalalian::now()->toDateString();
    }
}
