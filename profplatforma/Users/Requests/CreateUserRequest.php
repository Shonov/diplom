<?php

namespace  ProfPlatforma\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        //mimes:png,jpg,jpeg,gif
        return [
            'phone' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'middle_name' => 'string|nullable|max:255',
            'city' => 'string',
            'gender' => 'in:Мужской,Женский,',
            'birthday' => 'date',
            'categories' => 'array',
            'photo' => '',
            'description' => 'string',
            'public_offer' => 'boolean',
            'confimed' => 'boolean',
        ];
    }
}