<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPartnersPercentageRequest;
use App\Http\Requests\UpsertPersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;
use Mockery\Exception;

class PersonController extends Controller
{

    public function index()
    {
        $people = Person::all();
        $partners = Person::query()->where('is_partner', 1)->get(['id', 'name']);
        return view('people.index', compact('people', 'partners'));
    }

    public function store(UpsertPersonRequest $request)
    {
        try {
            $validated = $request->validated();
            if (empty($validated['is_partner'])) $validated['is_partner'] = 0;
            if ($validated['is_partner'] == 'on') $validated['is_partner'] = 1;
            if (isset($validated['mobile']) && strlen((int)$validated['mobile']) != 11) throw new Exception('mobile number should 11 numbers');
            Person::create($validated);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
        return redirect()->route('people.index')
            ->with('success', 'مشخصات فرد جدید با موفقیت ذخیره شد');
    }

    public function update(Person $person, UpsertPersonRequest $request)
    {
        try {
            $validated = $request->validated();
            if (empty($validated['is_partner'])) $validated['is_partner'] = 0;
            if ($validated['is_partner'] == 'on') $validated['is_partner'] = 1;
            if (isset($validated['mobile']) && strlen((int)$validated['mobile']) != 11) throw new Exception('mobile number should 11 numbers');
            $person->update($validated);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()]);
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
