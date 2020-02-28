<?php namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralRequest extends FormRequest {

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException( response()->json( [
            'errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY ) );
    }

}
