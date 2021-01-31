<?php

namespace App\Http\Requests\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class OrderPlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Auth::guard('customer')->check()) {
            return [];
        } else {
            return [
               'first_name' => 'required',
               'last_name' => 'required',
               'email' => 'required|email|unique:users,email',
               'password' => 'required|string|min:6|confirmed'
            ];
        }
    }
}
