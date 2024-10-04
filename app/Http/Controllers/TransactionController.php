<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypeEnum;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Person;
use App\Models\Transaction;
use App\traits\JalaliTrait;
use phpDocumentor\Reflection\Exception;

class TransactionController extends Controller
{
    use JalaliTrait;

    public function index()
    {
        $transactions = Transaction::query()->orderByDesc('id')->get();
        foreach ($transactions as &$transaction) {
            $type = $transaction['transaction_type'];
            $transaction['person_name'] = Person::query()->where('id', $transaction['person_id'])->first('name')->name;
            if ($type == 1) $transaction['transaction_type'] = 'سرمایه';
            if ($type == 2) $transaction['transaction_type'] = 'متعلقات';
        }
        return view('transactions.index', compact('transactions'));
    }

    public function getForOnePerson()
    {
        //TODO get 1 id transactions
    }

    public function store(StoreTransactionRequest $request)
    {

        try {
            $validated = $request->validated();
            $amount = $validated['transaction_amount'];

            if ($validated['operation'] == '-') $validated['transaction_amount'] = -$amount;
            unset($validated['operation']);
            $validated['jdatetime'] = $this->getNowByDateTimeString();
            $personId = $validated['person_id'];
            Transaction::create($validated);

            if ($validated['transaction_type'] == 1) {
                $wealth = Person::query()->find($personId, 'wealth')->wealth;
                $wealth += $amount;
                if ($wealth < 0) throw new \Exception('wealth lower than 0');
                Person::query()->where('id', $personId)->update(['wealth' => $wealth]);
            } elseif ($validated['transaction_type'] == 2) {
                $belongings = Person::query()->find($personId, 'belongings')->belongings;
                $belongings += $amount;
                if ($belongings < 0) throw new \Exception('belongings lower than 0');
                Person::query()->where('id', $personId)->update(['belongings' => $belongings]);
            } else throw new Exception('type is 1 , 2');
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('people.index')
            ->with('success', 'تراکنش با موفقیت ثبت شد');

    }
}
