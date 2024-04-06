<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgencyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username_agency' => 'required|string|unique:agency_users,username',
            'password_user_agency' => 'required|string',
            'email_user_agency' => 'required|string|email|max:150|unique:agency_users,email',
            'agency_id' => 'required',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ];
    }
}
