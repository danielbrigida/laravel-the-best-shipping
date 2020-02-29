<?php

namespace Modules\Shipping\Http\Requests;

use Modules\Core\Http\Requests\GeneralRequest;

class ShippingOptionsRequest extends GeneralRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => ['required','string','max:210'],
            'type' => ['required','string','max:210'],
            'origin' => ['required','string','min:8','max:9',function($attribute,$value,$fail) {
                if($this->validateZipCode($value) == false) {
                    $fail('Invalid zip code. Format: 00000-000');
                }
            }],
            'destination' => ['required','string','min:8','max:9',function($attribute,$value,$fail) {
                if($this->validateZipCode($value) == false) {
                    $fail('Invalid zip code. Format: 00000-000');
                }
            }],
            'cost' => ['required','numeric','max:9999999'],
            'estimated_days' => ['required','integer','max:10000'],
        ];
    }


    private function validateZipCode($value)
    {
         return preg_match("/^[0-9]{5}([- ]?[0-9]{3})?$/", trim($value));
    }
}
