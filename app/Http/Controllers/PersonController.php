<?php

namespace App\Http\Controllers;

use App\Http\DTOs\UpsertPersonDTO;
use App\Http\Requests\SetPartnersPercentageRequest;
use App\Http\Requests\UpsertPersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;
use Mockery\Exception;

class PersonController extends Controller
{

    public function index()
    {
        $people = Person::query()->orderByDesc('id')->get();
        $partners = Person::query()->where('is_partner', 1)->get(['id', 'name']);
        return view('people.index', compact('people', 'partners'));
    }

    public function store(UpsertPersonDTO $inputDTO)
    {
        try {
            $inputDTO->fillSystematicFields();
            Person::create($inputDTO->toArray());
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('people.index')
            ->with('success', 'مشخصات فرد جدید با موفقیت ذخیره شد');
    }

    public function update(Person $person, UpsertPersonDTO $inputDTO)
    {
        try {
            $inputDTO->fillSystematicFields();
            $person->update($inputDTO->toArray());
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return redirect()->route('people.index')
            ->with('success', 'مشخصات فرد با موفقیت به روز رسانی شد');
    }

    public function setPartnersPercentage(SetPartnersPercentageRequest $request)
    {
        try {
            $validated = $request->validated();
            foreach ($validated['partner'] as $key => $item) {
                $ids[] = $key;
                Person::query()->where('id', $key)->update(['percentage_of_participation' => $item]);
            }
            $inputCount = count($ids);
            $existIds = Person::query()->whereIn('id', $ids)->where('is_partner', 1)->count();
            if ($existIds != $inputCount) throw new \Exception('incorrect ids');
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('people.index')
            ->with('success', 'مشخصات فرد با موفقیت به روز رسانی شد');
    }
}
