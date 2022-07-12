<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnRequest extends FormRequest
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
            'product_id' => ['required'],
            'daily_setup' => ['required'],
            'customer_id' => ['required'],
            'name' => ['required'],
            // 'gold_plus_gem_weight' => ['required'],
            // 'gold_price' => ['required'],
            // 'gem_weight' => ['required'],
            // 'gem_price' => ['required'],
            // 'fee' => ['required'],
            // 'fee_price' => ['required'],
            // 'fee_for_making' => ['required'],
            // 'before_total' => ['required'],
            // 'final_total' => ['required'],
        ];
    }
}
