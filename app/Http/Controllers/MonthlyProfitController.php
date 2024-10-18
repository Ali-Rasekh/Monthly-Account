<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonthlyProfitController extends Controller
{
    public function index()
    {
        //TODO should show any jdate time in 1 table toghter and maybe need with acconut values
        return view('profits.index');
    }
}
