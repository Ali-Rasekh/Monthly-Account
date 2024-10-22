<?php

namespace App\Http\Controllers;

use App\Models\AccountValue;
use App\Models\MonthlyProfit;
use App\traits\JalaliTrait;
use Mockery\Exception;

class MonthlyProfitController extends Controller
{
    use JalaliTrait;

    //TODO check all todos
    public function index()
    {
        $date = $this->calculateDate();
        $accountValues = AccountValue::query()->where('jdatetime', $date)->get();
        $monthlyProfits = MonthlyProfit::query()->where('jdatetime', $date)->get()->toArray();

        $allDateTimes = AccountValue::query()->pluck('jdatetime','id')->unique()->toArray();
        arsort($allDateTimes);
//dd($allDateTimes);
        return view('profits.index', compact('monthlyProfits', 'accountValues', 'allDateTimes'));
    }


    public function calculateDate(): int
    {
        $maxDateTime = AccountValue::query()->max('jdatetime');
        $dateId = request()->query('date');
        if (is_null($dateId)) {
            return $maxDateTime;
        } else {
            $date = AccountValue::query()->where('id', $dateId)->first('jdatetime')->jdatetime;
            if (empty($date)) throw new Exception('تاریخ اشتباه است.');
        }
        return $this->convertDateTimeToInt($date);
    }
}
