<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = Account::query()->whereNull('parent_id')->with('children')->get()->toArray();
//        dd($accounts);
        return view('dashboard', compact('accounts'));
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
