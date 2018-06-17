<?php

namespace ProfPlatforma\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'title' => 'required|string|max:128',
            'description' => 'required|string|max:255',
            'address' => 'string|max:255',
            'coordinates' => 'string|max:255',
            'time_period' => 'in:В любое время,В период,Не позднее чем',
            'start_date' => 'string|max:255',
            'end_date' => 'string|max:255',
            'archive' => 'string',
            'budget_scale_id' => 'numeric',
            'user_id' => 'numeric',
        ];
    }
}
