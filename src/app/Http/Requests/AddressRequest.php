<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'postal_code'   => ['required','regex:/^\d{3}-\d{4}$/'], // 123-4567
            'prefecture'    => ['required','string','max:50'],
            'city'          => ['required','string','max:100'],
            'address_line1' => ['required','string','max:255'],
            'address_line2' => ['nullable','string','max:255'],
            'phone'         => ['nullable','string','max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex'    => '郵便番号はハイフンありの8文字で入力してください',
            'prefecture.required'  => '住所（都道府県）を入力してください',
            'city.required'        => '住所（市区町村）を入力してください',
            'address_line1.required'=> '住所（番地）を入力してください',
        ];
    }
}

