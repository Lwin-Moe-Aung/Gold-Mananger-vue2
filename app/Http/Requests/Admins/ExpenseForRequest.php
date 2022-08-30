<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ExpenseFor;

class ExpenseForRequest extends FormRequest
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
        $rules = ExpenseFor::VALIDATION_RULES;
        return $rules;
    }
}
