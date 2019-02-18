<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCompany extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // this is already enforced by the middleware
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|min:4|regex:/^[A-Za-z.,()&\-\s\d]+$/',
            'email' => 'email|unique:companies',
            'website' => 'url',      
            'logo' => 'nullable|file|image|mimes:jpeg,png,gif|dimensions:min_width=100,min_height=100',
        ];
    }
}
