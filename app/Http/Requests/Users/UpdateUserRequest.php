<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'phone' => 'required|'.$this->id,
            'email' => 'required|email|'.$this->id,
            'image' => 'required',
            'address' => 'required',
            'password' => 'nullable|min:6',
            'gender' => 'required'
        ];
    }
}
