<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePasswordFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
