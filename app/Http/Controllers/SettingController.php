<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\Person;
use App\Models\Setting;
use App\traits\JalaliTrait;

class SettingController extends Controller
{
    use JalaliTrait;

    public function index()
    {
        //    پلیس هولدر ها تو کروم
        $settings = Setting::query()->orderByDesc('id')->get(); // دریافت همه تنظیمات
        return view('settings.index', compact('settings'));
    }

    public function store(StoreSettingRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['date'] = $this->convertNowToInt();
            Setting::create($validated); // ذخیره داده‌ها
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('settings.index')
            ->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}
