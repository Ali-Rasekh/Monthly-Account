<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\Person;
use App\Models\Setting;
use App\traits\JalaliTrait;
use Morilog\Jalali\Jalalian;

class SettingController extends Controller
{
    use JalaliTrait;

    public function index()
    {
        $settings = Setting::query()->orderByDesc('id')->get();
        return view('settings.index', compact('settings'));
    }

    public function store(StoreSettingRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['jdatetime'] = $this->getNowByDateTimeString();
            Setting::create($validated);
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('settings.index')
            ->with('success', 'تنظیمات با موفقیت ذخیره شد');
    }
}
