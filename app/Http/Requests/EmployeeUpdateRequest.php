<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'user_id'  => 'nullable|exists:users,id',
            'company_id'  => 'required|exists:companies,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email|unique:users|max:255',
            'phone' => 'nullable|string',
            'user_role' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
}
