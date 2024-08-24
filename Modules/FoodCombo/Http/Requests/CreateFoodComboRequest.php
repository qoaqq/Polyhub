<?php

namespace Modules\FoodCombo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFoodComboRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:display,hide'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
