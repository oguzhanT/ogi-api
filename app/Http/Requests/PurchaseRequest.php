<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PurchaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $validator->errors()
            ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client-token' => 'string|required',
            'receipt' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'client-token.required' => trans('validation.required'),
            'client-token.string' =>  trans('validation.string'),
            'receipt.required' =>  trans('validation.required'),
            'receipt.string' =>  trans('validation.string'),
        ];
    }
}
