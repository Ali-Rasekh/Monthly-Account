<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\Person;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all(); // دریافت همه تنظیمات
        return view('settings.index', compact('settings'));
    }

    public function create()
    {
        $lastSettings = Setting::query()->latest()->first(['Shareholder_interest_percentage', 'partners_percentage'])->toArray();
        $people = Person::query()->whereNotNull('percentage_of_participation')->get(['id', 'name', 'percentage_of_participation'])->toArray();
        return view('settings.create', compact('people', 'lastSettings'));
    }

    public function store(StoreSettingRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $partnersPercent = $validated['each_partner_percent'];
            data_forget($validated, 'each_partner_percent');
            Setting::create($validated); // ذخیره داده‌ها

            foreach ($partnersPercent as $key => $value) {
                Person::query()->where('id', $key)->update(['percentage_of_participation' => $value]);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('settings.index')
            ->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete(); // حذف رکورد

        return redirect()->route('settings.index')
            ->with('success', 'تنظیمات با موفقیت حذف شد.');
    }
}
