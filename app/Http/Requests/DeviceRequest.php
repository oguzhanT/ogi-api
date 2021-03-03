<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DeviceRequest extends FormRequest
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
            'uid' => 'string|required',
            'language' => 'string|required',
            'os' => 'string|required',
            'app_key' => 'string|required',
        ];
    }

    public function messages(): array
    {
        return [
            'uid.required' => trans('validation.required'),
            'uid.string' =>  trans('validation.string'),
            'language.required' =>  trans('validation.required'),
            'language.string' =>  trans('validation.string'),
            'os.required' => trans('validation.required'),
            'os.string' =>  trans('validation.string'),
            'app_key.required' => trans('validation.required'),
            'app_key.string' =>  trans('validation.string'),
        ];
    }
}
