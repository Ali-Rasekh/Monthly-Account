<?php

namespace App\Http\Controllers;

use App\Enums\LengthEnum;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::query()->whereNull('parent_id')->with('children')->get()->toArray();
        return view('accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:' . LengthEnum::Mid,
                'parent_id' => 'nullable|integer'
            ]);
            Account::create($validated);
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('accounts.index')
            ->with('success', 'حساب  با موفقیت اضافه شد');
    }


    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:' . LengthEnum::Mid,
                'update_id' => 'required|integer'
            ]);
            $account = Account::query()->findOrFail($validated['update_id']);
            $account->update(['name' => $validated['name']]);
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('accounts.index')
            ->with('success', 'حساب  با موفقیت آپدیت شد');
    }

    public function destroy(Account $account)
    {
        try {
            $account->delete();
        } catch (\Throwable $e) {
            return response(['message' => $e->getMessage()])->setStatusCode(500);
        }
        return redirect()->route('accounts.index')
            ->with('success', 'حساب  با موفقیت حذف شد');
    }
}
