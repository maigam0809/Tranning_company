<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

use App\Traits\TraitResponse;

class BaseApiRequest extends FormRequest
{
    // use TraitResponse;

    // protected function failedValidation(Validator $validator)
    // {
    //     $error = $validator->messages()->first();
    //     throw new HttpResponseException(
    //         $this->responseApi([
    //         'success' => false,
    //         'message' => $error,
    //     ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    // }

}
