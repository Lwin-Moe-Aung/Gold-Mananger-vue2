<?php

namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Contact;

class ContactRequest extends FormRequest
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
        $rules = Contact::VALIDATION_RULES;
        //example
        if ($this->getMethod() == 'POST'){
            //store example
            // $rules += ['mobile2' => 'required'];
        } else {
            //update
        }
        return $rules;

    }
}
