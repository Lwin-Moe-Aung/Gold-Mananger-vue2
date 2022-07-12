<?php

namespace App\Http\Requests\Admins;
use App\Models\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = Product::VALIDATION_RULES;
        return $rules;

        //example
        if ($this->getMethod() == 'POST'){
            //store example
            // $rules += ['mobile2' => 'required'];
        } else {
            //update
        }
    }
}
