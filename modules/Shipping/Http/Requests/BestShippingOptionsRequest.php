<?php

namespace Modules\Shipping\Http\Requests;

use Modules\Core\Http\Requests\GeneralRequest;

class BestShippingOptionsRequest extends GeneralRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'origin' => ['required','array'],
            'destination' => ['required','array'],
            'origin.*' => ['required','numeric','max:9999999'],
            'estimated_days' => ['required','integer','max:10000'],
        ];
    }
}
