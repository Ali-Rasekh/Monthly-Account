<?php

namespace App\Http\Controllers;

use App\Enums\LengthEnum;
use App\Http\DTOs\CalculateInputDTO;
use App\Http\DTOs\StoreAccountValuesInputDTO;
use App\Models\Account;
use App\Models\AccountValue;
use App\Models\MonthlyProfit;
use App\Models\Person;
use App\Models\Setting;
use App\Models\User;
use App\traits\JalaliTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        list($people, $totalWealth, $totalBelongings) = $this->getPeople();
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

//todo session time to imi
    public function calculate(CalculateInputDTO $inputDTO)
    {
        $inputDTO->fillSystematicFields();   //- bedehkar o check pardakhti
        Jalalian::fromFormat('Y/m/d', $inputDTO->date);
        list($monthlyProfitsTable, $totalWealth, $totalBelongings) = $this->getPeople();
        $totalSarmaie = $inputDTO->total_wealth - $inputDTO->total_belongings;
        $totalAccounts = array_sum($inputDTO->accounts);
        $totalProfits = $totalAccounts - $totalSarmaie;
        $partnersProfits = ($inputDTO->partners_percentage * $totalProfits) / 100;
        $placeHoldersProfits = $totalProfits - $partnersProfits;
        $percentWealthProfits = ($totalWealth * 100) / ($totalWealth + $totalBelongings);
        $totalWealthProfits = ($placeHoldersProfits * $percentWealthProfits) / 100;
        // مقداری از سود که به سهامدارا میرسه نه به متعلقات
        $totalBelongingProfits = $placeHoldersProfits - $totalWealthProfits;
        list($monthlyProfitsShow, $monthlyProfitsTable) = $this->prepareMonthlyProfitsTable($monthlyProfitsTable, $totalWealthProfits, $totalBelongingProfits, $partnersProfits, $inputDTO);
        list($accountValuesShow, $accountValuesTable) = $this->prepareAccountValues($inputDTO);

        return view('show_profits', compact('monthlyProfitsTable', 'monthlyProfitsShow', 'accountValuesTable', 'accountValuesShow'));
    }

    public function store(Request $request)
    {
        try {
            $accountValuesTable = json_decode($request['accountValuesTable']);
            $monthlyProfitsTable = json_decode($request['monthlyProfitsTable']);
            $date = $accountValuesTable[0]->jdatetime;
            $time = Jalalian::now()->toTimeString();
            $dateTime = $date . ' ' . $time;
            $jdatetime = $this->convertDateTimeToInt($dateTime);
            $this->insertAccountValues($accountValuesTable, $jdatetime);
            $this->insertMonthlyProfits($monthlyProfitsTable, $jdatetime);

        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('dashboard')
            ->with('success', ' سود ماهانه با موفقیت ذخیره شد');
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

    /**
     * @return array
     */
    public function getPeople(): array
    {
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
        return array($people, $totalWealth, $totalBelongings);
    }

    /**
     * @param CalculateInputDTO $inputDTO
     * @return array[]
     */
    public function prepareAccountValues(CalculateInputDTO $inputDTO): array
    {
        foreach ($inputDTO->accounts as $key => $account) {
            $keys[] = $key;
        }
        $accountNames = Account::query()->whereIn('id', $keys)->pluck('name', 'id');
        $accountValuesShow = [];
        $accountValuesTable = [];
        foreach ($inputDTO->accounts as $key => $value) {
            $accountValuesShow[] = [
                'account_id' => $key,
                'account_name' => $accountNames[$key],
                'value' => $value,
                'jdatetime' => $inputDTO->date,
            ];
            $accountValuesTable[] = [
                'account_id' => $key,
                'value' => $value,
                'jdatetime' => $inputDTO->date,
            ];
        }
        return array($accountValuesShow, $accountValuesTable);
    }

    /**
     * @param mixed $peopleWithNames
     * @param float|int $totalWealthProfits
     * @param float|int $totalBelongingProfits
     * @param float|int $partnersProfits
     * @param CalculateInputDTO $inputDTO
     * @return mixed
     */
    public function prepareMonthlyProfitsTable(mixed $peopleWithNames, float|int $totalWealthProfits, float|int $totalBelongingProfits, float|int $partnersProfits, CalculateInputDTO $inputDTO): mixed
    {
        foreach ($peopleWithNames as &$person) {
            $person['person_id'] = $person['id'];
            $person['current_wealth'] = $person['wealth'];
            $person['current_belongings'] = $person['belongings'];
            $person['current_participation_percentage'] = $person['percentage_of_participation'];

            if ($person['percent_of_wealth'] > 0)
                $person['wealth_profit'] = ($person['percent_of_wealth'] * $totalWealthProfits) / 100;

            if ($person['percent_of_belongings'] > 0)
                $person['belongings_profit'] = ($person['percent_of_belongings'] * $totalBelongingProfits) / 100;

            if ($person['percentage_of_participation'] > 0)
                $person['participation_profit'] = ($person['percentage_of_participation'] * $partnersProfits) / 100;

            $person['total_profit'] = $person['wealth_profit'] + $person['belongings_profit'] + $person['participation_profit'];
            $person['jdatetime'] = $inputDTO->date;

            unset($person['id'], $person['wealth'], $person['belongings'],
                $person['percentage_of_participation'],
                $person['percent_of_wealth'], $person['percent_of_belongings']
            );
        }
        $peopleTable = array_map(function ($q) {
            unset($q['name']);
            return $q;
        }, $peopleWithNames);

        return [$peopleWithNames, $peopleTable];
    }

    /**
     * @param mixed $accountValuesTable
     * @return void
     */
    public function insertAccountValues(mixed $accountValuesTable, string $dateTime): void
    {
        $insertData = [];
        foreach ($accountValuesTable as $item) {
            $insertData[] = [
                'account_id' => $item->account_id,
                'value' => $item->value,
                'jdatetime' => $dateTime,
                'created_at' => now(),
            ];
        }
        AccountValue::insert($insertData);
    }

    /**
     * @param mixed $monthlyProfitsTable
     * @return void
     */
    public function insertMonthlyProfits(mixed $monthlyProfitsTable, string $dateTime): void
    {
        $insertData = [];
        foreach ($monthlyProfitsTable as $item) {
            $insertData[] = [
                'person_id' => $item->person_id,
                'current_wealth' => $item->current_wealth,
                'current_belongings' => $item->current_belongings,
                'current_participation_percentage' => $item->current_participation_percentage,
                'wealth_profit' => $item->wealth_profit,
                'belongings_profit' => $item->belongings_profit,
                'participation_profit' => $item->participation_profit,
                'total_profit' => $item->total_profit,
                'jdatetime' => $dateTime,
                'created_at' => now(),
            ];
        }
        MonthlyProfit::insert($insertData);
    }
}
