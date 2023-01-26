<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();

        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password|min:6',
        ];
    }

    public function withValidator($validator)
    {
    $validator->after(function ($validator) {
        if (! Hash::check($this->input('old_password'), auth()->user()->password)) {
            $validator->errors()->add('old_password', trans('base.old_password_incorrect'));
        }
        });
    }
}