<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create()
    {
        if (Address::where('user_id', Auth::id())->exists()) {
            return redirect()->route('address.edit');
        }
        return view('address.form', ['address' => null]);
    }

    public function store(AddressRequest $request)
    {
        Address::create($request->validated() + ['user_id' => Auth::id()]);
        return redirect()->route('address.edit')->with('message', '住所を登録しました');
    }

    public function edit()
    {
        $address = Address::firstOrNew(['user_id' => Auth::id()]);
        return view('address.form', compact('address'));
    }

    public function update(AddressRequest $request)
    {
        $address = Address::firstOrNew(['user_id' => Auth::id()]);
        $address->fill($request->validated() + ['user_id' => Auth::id()])->save();
        return back()->with('message', '住所を更新しました');
    }
}
