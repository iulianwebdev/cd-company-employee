<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        return [
            'first_name' => "nullable|required|min:2|regex:/^[A-Za-z\-\'\s]+$/",
            'last_name' => "nullable|required|min:2|regex:/^[A-Za-z\-\'\s]+$/",
            'email' => 'email|unique:employees',
            'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ];
    }
}
