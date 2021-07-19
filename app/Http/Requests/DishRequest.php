<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishRequest extends FormRequest
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
            'name'          =>  'required|max:40|min:5',
            'category'      =>  'required|max:20|min:5',
            'sub_category'  =>  'required|max:40|min:5',
            'image'         =>  'required|mimes:jpeg,jpg,bmp,png',
            'description'   =>  'required',
            'price'         =>  'required',
            'is_available'  =>  'required',
        ];
    }
}
