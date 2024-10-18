<?php

namespace App\Http\Controllers;

use App\Enums\LengthEnum;
use App\Http\DTOs\CalculateInputDTO;
use App\Models\Account;
use App\Models\Person;
use App\Models\Setting;
use App\Models\User;
use App\traits\JalaliTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    use JalaliTrait;

    public function check(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|max:' . LengthEnum::Mid,
        ]);

        session(['check' => 12]);

        $user = User::query()->where('email', $validated['email'])->where('password', $validated['password'])->exists();
        if ($user)
            return redirect()->intended('dashboard')
                ->with('success', 'خوش آمدید');
        else
            return redirect()->route('first')
                ->with('failed', 'لطفا رمز یا ایمیل صحیح را وارد کنید');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function index()
    {
        $settings = $this->validationPercent();
        $accounts = Account::query()->whereNull('parent_id')->with('children')->get()->toArray();
        $people = Person::query()
            ->orWhere('wealth', '>', 0)
            ->orWhere('belongings', '>', 0)
            ->orWhere('percentage_of_participation', '>', 0)
            ->get(['id', 'name', 'wealth', 'belongings', 'percentage_of_participation'])->toArray();
        $totalWealth = Person::query()->sum('wealth');
        $totalBelongings = Person::query()->sum('belongings');
        foreach ($people as &$person) {
            $person['percent_of_wealth'] = ($person['wealth'] * 100) / $totalWealth;
            $person['percent_of_belongings'] = ($person['belongings'] * 100) / $totalBelongings;
        }
        $info = [
            'partners_percentage' => $settings['partners_percentage'],
            'Shareholder_interest_percentage' => $settings['Shareholder_interest_percentage'],
            'total_wealth' => $totalWealth,
            'total_belongings' => $totalBelongings,
            'total_capital' => $totalWealth - $totalBelongings,
        ];

        $today = $this->getNowByDateString();
        return view('dashboard', compact('accounts', 'people', 'info', 'today'));
    }


    public function calculate(CalculateInputDTO $inputDTO)
    {
        Jalalian::fromFormat('Y/m/d', $inputDTO->date);

        dd($inputDTO);
    }
//TODO back in pages   and titles in top page with fav icon
    public function store(CalculateInputDTO $inputDTO)
    {
        dd($inputDTO);
    }

    /**
     * @return array
     */
    public function validationPercent(): array
    {
        $percentage = Person::query()->sum('percentage_of_participation');
        if ($percentage != 100) throw new Exception('درصد های شراکت باید به 100 برسه');
        $settings = Setting::query()->latest()->first(['Shareholder_interest_percentage', 'partners_percentage'])->toArray();
        if (array_sum($settings) != 100) throw new Exception('تقسیم درصد بین سهامدار و شرکا باید به 100 برسه');
        return $settings;
    }
}
