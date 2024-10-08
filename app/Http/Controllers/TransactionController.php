<?php

namespace App\Http\Controllers;

use App\Enums\TransactionTypeEnum;
use App\Http\DTOs\CreateTransactionDTO;
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
        //TODO get 1 id transactions    and in person index and transaction search مشاهده تراکنش ها
    }

    public function store(CreateTransactionDTO $input)
    {
        try {
            $input->fillSystematicFields();
            $personId = $input->person_id;
            Transaction::create($input->toArray());

            if ($input->transaction_type == TransactionTypeEnum::wealth) {
                $wealth = Person::query()->find($personId, 'wealth')->wealth;
                $wealth += $input->transaction_amount;
                if ($wealth < 0) throw new \Exception('wealth lower than 0');
                Person::query()->where('id', $personId)->update(['wealth' => $wealth]);
            } elseif ($input->transaction_type == TransactionTypeEnum::belongings) {
                $belongings = Person::query()->find($personId, 'belongings')->belongings;
                $belongings += $input->transaction_amount;
                if ($belongings < 0) throw new \Exception('belongings lower than 0');
                Person::query()->where('id', $personId)->update(['belongings' => $belongings]);
            } else throw new Exception('type is 1 , 2');
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 400]);
        }
        return redirect()->route('people.index')
            ->with('success', 'تراکنش با موفقیت ثبت شد');
    }
}
