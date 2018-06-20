<?php

namespace ProfPlatforma\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
//            'title' => 'string|max:128',
//            'description' => 'string|max:255',
//            'is_submited' => 'boolean'
//            'coordinates' => 'string|max:255',
//            'time_period' => 'in: at any time, during the period, not later than',
//            'date' => 'string|max:255',
//            'budget' => 'numeric',
//            'photos.*.    profile' => 'images|mimes:jpeg,bmp,png',
        ];
    }
}
